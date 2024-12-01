<?php 
    include("../phpFiles/dbConnect.php");
    include("../pages/login.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $patientid = $_POST['patientid'];
        $chargeamount = $_POST['chargeamount'];
        $amountpaid = $_POST['amountpaid'];
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $notes = $_POST['notes'];

        $query = "SELECT patientID, patientBalance FROM patients WHERE patientID = '$patientid';";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $prev_balance = $row["patientBalance"];
        }

        $calculate = (float)$chargeamount - (float)$amountpaid;
        $balance = (float)$prev_balance + $calculate;
        
        $sql="INSERT INTO transactions (patientID, transChargeAmount, transAmountPaid, transDate, transTime, transNotes) VALUES ('$patientid', '$chargeamount', '$amountpaid', '$date', '$time', '$notes');";
        $sql_update="UPDATE patients SET patientBalance = '$balance' WHERE patientID = '$patientid';";
        
        if ($conn->query($sql) === TRUE && $conn->query($sql_update) === TRUE) {
            $balance = "0";
            $result->free_result();
            $conn->close();
            header("Location: transaction.php");
        } else {
            echo "Error: " . $conn->error;
            echo "<script>msgAlert('Something went wrong.', 'error', 'transaction.php');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Record</title>
    <link rel="stylesheet" href="../styles/requestUpdate.css">
    <?php include('header.php'); ?>
</head>
<body>
<div class="am-container">
        <div class="am-body">
            <div class="am-head">
                <h1>Add Transaction</h1>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"  class="am-body-box" id="forms">
            <a href="transaction.php"><i class="fas fa-arrow-alt-circle-left"></i></a>
                <div class="am-row">
                    <div class="am-col-6">
                        <p>Patient ID:</p>
                        <select name="patientid" required>
                        <?php
                            $dropdownQuery = $conn->query("SELECT patientID, patientFirstName, patientLastName FROM patients;");
                            while($dropdown = $dropdownQuery->fetch_assoc()) {
                                echo '<option value="' . $dropdown['patientID'] . '">' . $dropdown['patientID'] . ' - ' . $dropdown['patientFirstName'] . ' ' . $dropdown['patientLastName'] . '</option>';
                            } 
                        ?>
                        </select>
                    </div>
                    <div class="am-col-6">
                        <p>Charge Amount: </p>
                        <input type="number" id="chargeamount" name="chargeamount" placeholder="Enter Charge Amount" required>
                    </div>
                </div>
                <div class="am-row">
                    <div class="am-col-6">
                        <p>Amount Paid: </p>
                        <input type="number" id="amountpaid" name="amountpaid" placeholder="Enter Amount Paid" required>
                    </div>
                    <div class="am-col-6">
                        <p>Notes: </p>
                        <textarea id="notes" name="notes" rows="3" cols="50" placeholder="Enter your Notes"></textarea>
                    </div>
                </div>

                <div class="am-row">
                    <div class="am-col-3">
                    <button type="submit" id="form-btn" name="submit" value="Submit" onclick="return confirm('Are you sure you want to submit?')">Add Transaction</button>
                    </div>
                </div>
            </form>
            <div class="am-footer">
                    <p>Toothbuds Dental Clinic</p>
            </div>
        </main>
    </div>
</body>
</html>
