<?php
  include("../phpFiles/dbConnect.php");
  include("../pages/login.php");

  $updateMessage = "";  
  $searchKeyword = isset($_GET['searchKeyword']) ? $_GET['searchKeyword'] : '';

  $recordPerPage = 13;  
  
  if (isset($_GET["page"])) {    
      $page = $_GET["page"];    
  }    
  else {    
      $page = 1;    
  }    

  $startPage = ($page-1) * $recordPerPage; 
  //table view function
  $sql = "SELECT requests.requestID, requests.patientID, patients.patientFirstName, patients.patientLastName, patients.patientMobileNo, patients.patientStatus, requests.requestServices, requests.requestDate, requests.requestTime, requests.requestNotes, requests.requestStatus
          FROM requests
          LEFT JOIN patients ON requests.patientID = patients.patientID
          WHERE requests.requestStatus ='Pending'";

  //search if search not empty
  if (!empty($searchKeyword)) {
    $sql .= " AND (patients.patientFirstName LIKE '%$searchKeyword%' OR patients.patientLastName LIKE '%$searchKeyword%' OR patients.patientMobileNo LIKE '%$searchKeyword%' OR requests.requestID LIKE '%$searchKeyword%' OR requests.patientID LIKE '%$searchKeyword%' OR requests.requestDate LIKE '%$searchKeyword%' OR requests.requestTime LIKE '%$searchKeyword%' OR requests.requestServices LIKE '%$searchKeyword%')";
  }

  $sql .= " ORDER BY requests.requestDate ASC, requests.requestTime ASC LIMIT $startPage, $recordPerPage;";

  $result = $conn->query($sql);
  $totalRecords = mysqli_num_rows($result);

  if (!$result) {
      die("Error in SQL query: " . $conn->error);
  }

  //if approve button is clicked
  if (isset($_POST["approved"])){
    $requestID = isset($_POST["requestID"]) ? $_POST["requestID"] : "";
    $updateRequestStatusQuery = "UPDATE requests SET requestStatus = 'Approved' WHERE requestID = $requestID";

    $updatePatientStatusQuery = "UPDATE patients SET patientStatus = 'Verified' WHERE patientID = (SELECT patientID FROM requests WHERE requestID = $requestID)";

    if ($conn->query($updateRequestStatusQuery) === TRUE && $conn->query($updatePatientStatusQuery) === TRUE){
      // Update patient status even if request update is successful
      $updateMessage = "Record updated successfully";
      header("Location: appointmentRequest.php");
    } else {
        $updateMessage = "Error updating request record: " . $conn->error;
    }
  }

  //if decline button is clicked
  if (isset($_POST["declined"])) {
    $requestID = isset($_POST["requestID"]) ? $_POST["requestID"] : "";

    //get patientID & patientStatus from db
    $patientStatusQuery = "SELECT patientStatus, patientID FROM patients WHERE patientID = (SELECT patientID FROM requests WHERE requestID = $requestID)";
    $patientStatusResult = $conn->query($patientStatusQuery);

    if ($patientStatusResult->num_rows > 0) {
      $patientData = $patientStatusResult->fetch_assoc();
      $patientStatus = $patientData["patientStatus"];
      $patientID = $patientData["patientID"];

    // get values from db//
      $patientStatusQuery = "SELECT patientStatus, patientID FROM patients WHERE patientID = (SELECT patientID FROM requests WHERE requestID = $requestID)";
      $patientStatusResult = $conn->query($patientStatusQuery);

      if ($patientStatusResult->num_rows > 0) {
          $patientData = $patientStatusResult->fetch_assoc();
          $patientStatus = $patientData["patientStatus"];
          $patientID = $patientData["patientID"];

          switch ($patientStatus) {
              case "Verified":
                  $updateRequestStatusQuery = "UPDATE requests SET requestStatus = 'Declined', requestDate = null, requestTime = null WHERE requestID = $requestID";

                  if ($conn->query($updateRequestStatusQuery) === TRUE) {
                      $updateMessage = "Record updated successfully";
                      header("Location: appointmentRequest.php");
                  } else {
                      $updateMessage = "Error updating request record: " . $conn->error;
                  }
                  break;

              case "Not Verified":
                  $deleteRequestsQuery = "DELETE FROM requests WHERE patientID = '$patientID'";
                  $deletePatientsQuery = "DELETE FROM patients WHERE patientID = '$patientID'";

                  if ($conn->query($deleteRequestsQuery) === TRUE && $conn->query($deletePatientsQuery) === TRUE) {
                      $updateMessage = "Record deleted successfully";
                      header("Location: appointmentRequest.php");
                  } else {
                      $updateMessage = "Error deleting records: " . $conn->error;
                  }
                  break;

              default:
                  $updateMessage = "Unknown patient status";
                  break;
          }
          exit();
        } else {
          $updateMessage = "Error fetching patient status: " . $conn->error;
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/transaction.css">
    <?php include('header.php'); ?>
</head>
<body>
    <div class="container">
        <?php 
            if($_SESSION["accRole"] == "Admin"){
                include('adminSidebar.php'); 
            }else{
                include('sidebar.php'); 
            } 
        ?>  
        <main>
          <h1>Appointment Request</h1>
          <div class="main-content">
            <div class="contain">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="search" id="upd-form">
                <input type="text" name="searchKeyword" value="<?php echo $searchKeyword; ?>" placeholder="  Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </form>
            </div>
            <?php
              echo "<table>";
              echo "<tr><th>Request ID</th><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Mobile Number</th><th>Patient Status</th><th>Services</th><th>Date</th><th>Time</th><th>Notes</th><th>Appointment Status</th><th>Action</th></tr>";
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $patientID = $row["patientID"];
                    echo "<tr>";
                    echo "<td>" . $row["requestID"] . "</td>";
                    echo "<td>" . $row["patientID"] . "</td>";
                    echo "<td>" . $row["patientFirstName"] . "</td>";
                    echo "<td>" . $row["patientLastName"] . "</td>";
                    echo "<td>" . $row["patientMobileNo"] . "</td>";
                    echo "<td>" . $row["patientStatus"] . "</td>";
                    echo "<td>" . $row["requestServices"] . "</td>";
                    echo "<td>" . $row["requestDate"] . "</td>";
                    echo "<td>" . " ". date("h:i A",strtotime($row["requestTime"])) . " ". "</td>";
                    echo "<td>" . $row["requestNotes"] . "</td>";
  
                    echo "<td>";
                    echo "<div class='action-buttons'>
                            <form action='appointmentRequest.php' method='post'>
                                <input type='hidden' name='requestID' value='{$row['requestID']}'>
                                <button type='submit' name='approved' id='approve' onclick = 'return confirm(\"Are you sure you want to approve this appointment?\");'><i class='fas fa-check-square'></i></button>
                                <button type='submit' name='declined' id='decline' onclick = 'return confirm(\"Are you sure you want to decline this appointment?\");'><i class='fas fa-times-circle'></i></button>
                            </form>";

                    echo "</div>";

                    echo "</td>";
  
                    echo "<td>
                            <div class='action-buttons'>
                              <form action='appointmentRequestUpdate.php' method='post'>
                                  <input type='hidden' name='requestID' value='{$row['requestID']}'>
                                  <input type='hidden' name='requestStatus' value='{$row['requestStatus']}'>
                                  <button type='submit' onclick='openPopup()'><i class='fas fa-edit'></i></button>
                                  
                              </div>
                              </form>
                          </td>";
                    echo "</tr>";
                    
                  }
                  echo "</div>";
                //   echo "</table><br>";
                  
                } else {
                    echo "<tr><td colspan = '12' id = 'noRes'>No Results</td></tr>";
                }
                echo "</table><br>";
            ?>

            <div class = "paginationCont">
                <div class = "paginationMain">
                    <?php
                        $query = "SELECT COUNT(*)
                        FROM requests
                        LEFT JOIN patients ON requests.patientID = patients.patientID
                        WHERE requests.requestStatus ='Pending'";

                        $baseUrl = "appointmentRequest.php";
                        if (!empty($searchKeyword)) {
                            $query .= " AND (patients.patientFirstName LIKE '%$searchKeyword%' OR patients.patientLastName LIKE '%$searchKeyword%' OR patients.patientMobileNo LIKE '%$searchKeyword%' OR requests.requestID LIKE '%$searchKeyword%' OR requests.patientID LIKE '%$searchKeyword%' OR requests.requestDate LIKE '%$searchKeyword%' OR requests.requestTime LIKE '%$searchKeyword%' OR requests.requestServices LIKE '%$searchKeyword%')";
                            $baseUrl .= "?searchKeyword=$searchKeyword";
                        }else{
                            $baseUrl .= "?";
                        }
                        include("../pages/pagination.php");
                    ?>    
                </div>
          </div>
        </main> 
  </div>
    
  <script src ="../scripts/confirmAppointment.js"></script>
</body>
</html>