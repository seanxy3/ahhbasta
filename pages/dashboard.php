<?php
    include("../phpFiles/dbConnect.php");
    include("../pages/login.php");

    // get the date today
    date_default_timezone_set('Asia/Manila');
    function getCurrentDate() {
        return date('Y-m-d');
      }
    
    $currentDate = getCurrentDate();

    $sqlRequestsToday = "SELECT appointments.requestID, appointments.patientID, patients.patientFirstName, patients.patientLastName, patients.patientMobileNo, appointments.requestServices, appointments.requestTime, appointments.requestNotes
    FROM appointments
    LEFT JOIN patients ON appointments.patientID = patients.patientID
    WHERE appointments.requestDate ='$currentDate' ORDER BY appointments.requestTime ASC";
    $resultRequestsToday = $conn->query($sqlRequestsToday);
    
    $sqlTotalTransactions = "SELECT COUNT(transactionID) AS totalTransactions FROM transactions";
    $resultTotalTransactions = $conn->query($sqlTotalTransactions);


    $sqlVerifiedPatients = "SELECT COUNT(patientID) AS verifiedPatients FROM patients WHERE patientStatus='Verified'";
    $resultVerifiedPatients = $conn->query($sqlVerifiedPatients);

    $sqlPendingRequests = "SELECT COUNT(requestID) AS pendingRequests FROM `requests` WHERE requestStatus='Pending'";
    $resultPendingRequests = $conn->query($sqlPendingRequests);
    

    $sqlAmountCharged = "SELECT SUM(transChargeAmount) AS amountCharged FROM transactions";
    $resultAmountCharged = $conn->query($sqlAmountCharged);

    $sql = "SELECT transDate, transChargeAmount, transAmountPaid, transTime FROM transactions ORDER BY transactions.transDate ASC, transactions.transTime ASC";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $sql = "SELECT transDate, transChargeAmount, transAmountPaid, transTime FROM transactions ORDER BY transactions.transDate ASC, transactions.transTime ASC";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $serviceCheck = "SELECT requestServices FROM requests WHERE requestStatus = 'Approved'";
    $services = $conn->query($serviceCheck);

    $allService = array();

    if ($services && mysqli_num_rows($services) > 0) {
        while ($row = mysqli_fetch_assoc($services)) {
            $serviceChosen = explode(", ", $row['requestServices']);
            $allService = array_merge($allService, $serviceChosen);
        }
    }
        // Count the occurrences of each service
    $serviceCounts = array_count_values($allService);

    // Sort the services by count in descending order
    krsort($serviceCounts);

    // Take only the top 5 services
    $top5Services = array_slice($serviceCounts, 0, 4);


    if (!empty($allService)) {
        $serviceCounts = array_count_values($allService);
    }

    $dataPoints = array();
    foreach ($top5Services as $service => $count) {
        $dataPoints[] = array("label" => $service, "y" => $count);
    }


    $dataPointsJson = json_encode($dataPoints);

    $sqlBar = "SELECT
        SUM(CASE WHEN patientAge BETWEEN 0 AND 12 THEN 1 ELSE 0 END) as Child,
        SUM(CASE WHEN patientAge BETWEEN 13 AND 19 THEN 1 ELSE 0 END) as Teenager,
        SUM(CASE WHEN patientAge BETWEEN 20 AND 39 THEN 1 ELSE 0 END) as Young_Adult,
        SUM(CASE WHEN patientAge >= 40 THEN 1 ELSE 0 END) as Adult
        FROM patients;";
    $resultBar = $conn->query($sqlBar);
    $rowBarChart = $resultBar->fetch_assoc();

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Dashboard</title>
        <?php include("../pages/header.php");?>
        <link rel="stylesheet" href="../styles/dashboard.css" />
        <script type="text/javascript" src ="../scripts/dashboard.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>  
        <script>
            var chartData = <?php echo json_encode($data); ?>;
            var dataPoints = <?php echo $dataPointsJson; ?>;
            var barChartData = <?php echo json_encode($rowBarChart, JSON_NUMERIC_CHECK); ?>;
        </script>
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
            <section class="main">
                <div class="main-top">
                    <h1>Dashboard</h1>
                </div>
                <div class="grid-container">
                    <div class="card">
                        <div class="per">
                            <p>Total Transactions</p>
                            <?php
                            if ($resultTotalTransactions->num_rows > 0) {
                                $rowTotalTransactions = $resultTotalTransactions->fetch_assoc();
                                echo "<h2>" . $rowTotalTransactions["totalTransactions"] . "</h2>";
                            } else {
                                echo "<h2>0</h2>";
                            }
                            ?>
                        </div>

                        <i class="fa-solid fa-hand-holding-dollar fa-2xl"></i>
                    </div>
                    <div class="card">
                        <div class="per">
                            <p>Verified Patients</p>
                            <?php
                            if ($resultVerifiedPatients->num_rows > 0) {
                                $rowVerifiedPatients = $resultVerifiedPatients->fetch_assoc();
                                echo "<h2>" . $rowVerifiedPatients["verifiedPatients"] . "</h2>";
                            } else {
                                echo "<h2>0</h2>";
                            }
                            ?>
                        </div>

                        <i class="fa-solid fa-user fa-2xl"></i>
                    </div>
                    <div class="card">
                        <div class="per">
                            <p>Pending Appointments</p>
                            <?php
                            if ($resultPendingRequests->num_rows > 0) {
                                $rowPendingRequests = $resultPendingRequests->fetch_assoc();
                                echo "<h2>" . $rowPendingRequests["pendingRequests"] . "</h2>";
                            } else {
                                echo "<h2>0</h2>";
                            }
                            ?>
                        </div>

                        <i class="fa-solid fa-calendar fa-2xl"></i>
                    </div>
                    <div class="card">
                        <div class="per">
                            <p>Gross Income</p>
                            <?php
                            if ($resultAmountCharged->num_rows > 0) {
                                $rowAmountCharged = $resultAmountCharged->fetch_assoc();
                                echo "<h2>₱" . $rowAmountCharged["amountCharged"] . "</h2>";
                            } else {
                                echo "<h2>₱0.00</h2>";
                            }
                            ?>
                        </div>

                        <i class="fa-solid fa-money-bill fa-2xl"></i>
                    </div>
                    <div id="chartContainer"></div>

                    <div id="pieContainer"></div>

                    <?php
                        if ($resultRequestsToday->num_rows > 0) {
                            echo '<table>';
                            echo "<tr><th>Request ID</th><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Mobile Number</th><th>Services</th><th>Time</th><th>Notes</th>";

                            while ($row = $resultRequestsToday->fetch_assoc()) {
                            echo '<tr>';
                            echo "<td>" . $row["requestID"] . "</td>";
                            echo "<td>" . $row["patientID"] . "</td>";
                            echo "<td>" . $row["patientFirstName"] . "</td>";
                            echo "<td>" . $row["patientLastName"] . "</td>";
                            echo "<td>" . $row["patientMobileNo"] . "</td>";
                            echo "<td>" . $row["requestServices"] . "</td>";
                            echo "<td>" . " ". date("h:i A",strtotime($row["requestTime"])) . " ". "</td>";
                            echo "<td>" . $row["requestNotes"] . "</td>";
                            echo '</tr>';
                            }
                            echo '</table>';
                        } else {
                            echo '<p class="no-result">No appointments for today.</p>';
                        }

                    ?>

                    <div id="barContainer"></div>
                </div>

            </section>
        </div>
    </body>
</html>

