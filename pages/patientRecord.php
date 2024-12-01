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

    $sql = "SELECT * FROM patients";

    //search if search not empty
    if (!empty($searchKeyword)) {
        $sql .= " WHERE patientFirstName LIKE '%$searchKeyword%' OR patientLastName LIKE '%$searchKeyword%' OR patientID LIKE '%$searchKeyword%' OR patientAge LIKE '%$searchKeyword%' OR patientSex LIKE '%$searchKeyword%' OR patientMobileNo LIKE '%$searchKeyword%' OR patientEmail LIKE '%$searchKeyword%' OR patientAddress LIKE '%$searchKeyword%' OR patientOccupation LIKE '%$searchKeyword%' OR patientBalance LIKE '%$searchKeyword%' OR patientStatus LIKE '%$searchKeyword%'";
    }

    $sql .= " ORDER BY patientLastName ASC, patientFirstName ASC LIMIT $startPage, $recordPerPage;";

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
    <title>Dashboard</title>
    <?php include("../pages/header.php");?>
    <link rel="stylesheet" href="../styles/transaction.css">
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
            <h1 class="header">Patient Record</h1>

            <div class="main-content">
                <div class="contain">  
                    <div class="button">
                        <a href="addPatient.php"><i class="fa-solid fa-plus"></i></a>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="search">
                        <input type="text" name="searchKeyword" value="<?php echo $searchKeyword; ?>" placeholder="  Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>
                <?php
                    echo "<table>";
                    echo "<tr><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Age</th><th>Sex</th><th>Mobile Number</th><th>Email</th><th>Address</th><th>Occupation</th><th>Balance</th><th>Status</th><th>Action</th></tr>";
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["patientID"] . "</td>";
                        echo "<td>" . $row["patientFirstName"] . "</td>";
                        echo "<td>" . $row["patientLastName"] . "</td>";
                        echo "<td>" . $row["patientAge"] . "</td>";
                        echo "<td>" . $row["patientSex"] . "</td>";
                        echo "<td>" . $row["patientMobileNo"] . "</td>";
                        echo "<td>" . $row["patientEmail"] . "</td>";
                        echo "<td>" . $row["patientAddress"] . "</td>";
                        echo "<td>" . $row["patientOccupation"] . "</td>";
                        echo "<td>" . $row["patientBalance"] . "</td>";
                        echo "<td>" . $row["patientStatus"] . "</td>";

                        //update and delete buttons
                        echo "<td>
                                <div class='action-buttons'>
                                    <form action='patientRecordUpdate.php' method='post'>
                                        <input type='hidden' name='patientID' value='{$row['patientID']}'>
                                        <button type='submit'><i class='fas fa-edit'></i></button>
                                    </form>
                                </td>";
                        echo "</tr>";
                        echo "</div>";
                        }
                        
                        echo "</table><br>";
                    } else {
                        echo "<tr><td colspan = '12' id = 'noRes'>No Results</td></tr>";
                        echo "</table><br>";
                    }
                ?>

                <div class = "paginationCont">
                    <div class = "paginationMain">
                        <?php
                            $query = "SELECT COUNT(*) FROM patients";
                            $baseUrl = "patientRecord.php";
                            if (!empty($searchKeyword)) {
                                $query .= " WHERE patientFirstName LIKE '%$searchKeyword%' OR patientLastName LIKE '%$searchKeyword%' OR patientID LIKE '%$searchKeyword%' OR patientAge LIKE '%$searchKeyword%' OR patientSex LIKE '%$searchKeyword%' OR patientMobileNo LIKE '%$searchKeyword%' OR patientEmail LIKE '%$searchKeyword%' OR patientAddress LIKE '%$searchKeyword%' OR patientOccupation LIKE '%$searchKeyword%' OR patientBalance LIKE '%$searchKeyword%' OR patientStatus LIKE '%$searchKeyword%'";
                                $baseUrl .= "?searchKeyword=$searchKeyword";
                            }else{
                                $baseUrl .= "?";
                            }
                            include("../pages/pagination.php");
                        ?>    
                    </div>
                </div>
            </div>
            
    </div>
</body>
</html>