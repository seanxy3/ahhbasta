<?php
    include("../phpFiles/dbConnect.php");
    include("../pages/login.php");

    $searchKeyword = isset($_GET['searchKeyword']) ? $_GET['searchKeyword'] : '';

    $recordPerPage = 13;  
      
      if (isset($_GET["page"])) {    
          $page = $_GET["page"];    
      }    
      else {    
          $page = 1;    
      }    
  
    $startPage = ($page-1) * $recordPerPage;

    $sql = "SELECT transactions.transactionID, transactions.patientID, patients.patientFirstName, patients.patientLastName, transactions.transChargeAmount, transactions.transAmountPaid, transactions.transTime, transactions.transDate, transactions.transNotes, patients.patientBalance
            FROM transactions
            JOIN patients on patients.patientID = transactions.patientID";

    if (!empty($searchKeyword)) {
        $sql .= " WHERE transactions.transactionID LIKE '%$searchKeyword%' OR transactions.patientID LIKE '%$searchKeyword%' OR patients.patientFirstName LIKE '%$searchKeyword%' OR patients.patientLastName LIKE '%$searchKeyword%' OR transactions.transDate LIKE '%$searchKeyword%' OR transactions.transNotes LIKE '%$searchKeyword%'";
    }

    $sql .= "  ORDER BY transactions.transDate, transactions.transTime ASC LIMIT $startPage, $recordPerPage;";

    $result = $conn->query($sql);
    $totalRecords = mysqli_num_rows($result);

    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Record</title>
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
            <h1>Transaction Record</h1>
            <div class="main-content">
                <div class="contain">
                    <div class="button">
                        <a href="addTransaction.php"><i class="fa-solid fa-plus"></i></a>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="search">
                        <input type="text" placeholder="Search" name="searchKeyword">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>
                <div class="table-container">
                    <?php 
                        echo "<table>";
                        echo "<tr>";
                        echo "<th>Transaction ID</th>";
                        echo "<th>Patient ID</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Charge Amount</th>";
                        echo "<th>Amount Paid</th>";
                        echo "<th>Date</th>";
                        echo "<th>Time</th>";
                        echo "<th>Notes</th>";
                        echo "</tr>";
                        if ($result->num_rows > 0){
                            while ($row = $result->fetch_assoc()){
                                echo "<tr>";
                                echo "<td>" . $row["transactionID"] . "</td>";
                                echo "<td>" . $row["patientID"] . "</td>";
                                echo "<td>" . $row["patientFirstName"] . "</td>";
                                echo "<td>" . $row["patientLastName"] . "</td>";
                                echo "<td>" . $row["transChargeAmount"] . "</td>";
                                echo "<td>" . $row["transAmountPaid"] . "</td>";
                                echo "<td>" . $row["transDate"] . "</td>";
                                echo "<td>" . date("h:i A",strtotime($row["transTime"])) . "</td>";
                                echo "<td>" . $row["transNotes"] . "</td>";
                                echo "</tr>";
                            }

                            echo "</table><br>";
                        }else{
                            echo "<tr><td colspan = '9' id = 'noRes'>No Results</td></tr>";
                            echo "</table><br>";
                        }
                    ?>
                </div>
                <div class = "paginationCont">
                    <div class = "paginationMain">
                        <?php
                            $query = "SELECT COUNT(*) FROM transactions JOIN patients on patients.patientID = transactions.patientID";
                            $baseUrl = "transaction.php";
                            if (!empty($searchKeyword)) {
                                $query .= " WHERE transactions.transactionID LIKE '%$searchKeyword%' OR transactions.patientID LIKE '%$searchKeyword%' OR patients.patientFirstName LIKE '%$searchKeyword%' OR patients.patientLastName LIKE '%$searchKeyword%' OR transactions.transDate LIKE '%$searchKeyword%' OR transactions.transNotes LIKE '%$searchKeyword%'";
                                $baseUrl .= "?searchKeyword=$searchKeyword";
                            }else{
                                $baseUrl .= "?";
                            }
                            include("../pages/pagination.php");
                        ?>    
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
