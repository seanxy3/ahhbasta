<?php
include("../phpFiles/dbConnect.php");
include("../pages/login.php");

$successPrompt["successSubmit"] = "";
$patientID = "";
$patientFirstName = "";
$patientLastName = "";
$patientAge = "";
$patientSex = "";
$patientMobileNo = "";
$patientEmail = "";
$patientAddress = "";
$patientOccupation = "";
//$patientBalance = "";
$updateMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    
    $patientID = isset($_POST["patientID"]) ? $_POST["patientID"] : "";
    $patientFirstName = isset($_POST["patientFirstName"]) ? $_POST["patientFirstName"] : "";
    $patientLastName = isset($_POST["patientLastName"]) ? $_POST["patientLastName"] : "";
    $patientAge = isset($_POST["patientAge"]) ? $_POST["patientAge"] : "";
    $patientSex = isset($_POST["patientSex"]) ? $_POST["patientSex"] : "";
    $patientMobileNo = isset($_POST["patientMobileNo"]) ? $_POST["patientMobileNo"] : "";
    $patientEmail = isset($_POST["patientEmail"]) ? $_POST["patientEmail"] : "";
    $patientAddress = isset($_POST["patientAddress"]) ? $_POST["patientAddress"] : "";
    $patientOccupation = isset($_POST["patientOccupation"]) ? $_POST["patientOccupation"] : "";
    //$patientBalance = isset($_POST["patientBalance"]) ? $_POST["patientBalance"] : "";


    $updateQuery = "UPDATE patients SET patientFirstName = '$patientFirstName', patientLastName = '$patientLastName', patientAge = '$patientAge', patientSex = '$patientSex', patientMobileNo = '$patientMobileNo', patientEmail = '$patientEmail', patientAddress = '$patientAddress', patientOccupation = '$patientOccupation' WHERE patientID ='$patientID'";
    
    if ($conn->query($updateQuery) === TRUE) {
        $successPrompt["successSubmit"] = "Record Updated Successfully";
        // $updateMessage = "Record updated successfully";
    } else {
        $updateMessage = "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    $patientID = isset($_POST["patientID"]) ? $_POST["patientID"] : "";

    $selectQuery = "SELECT * FROM patients WHERE patientID = $patientID";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $patientID = $row["patientID"];
        $patientFirstName = $row["patientFirstName"];
        $patientLastName = $row["patientLastName"];
        $patientAge = $row["patientAge"];
        $patientSex = $row["patientSex"];
        $patientMobileNo = $row["patientMobileNo"];
        $patientEmail = $row["patientEmail"];
        $patientAddress = $row["patientAddress"];
        $patientOccupation = $row["patientOccupation"];
        //$patientBalance = $row["patientBalance"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include("../pages/header.php");?>
    <link rel="stylesheet" href="../styles/requestUpdate.css">
</head>
<body>

<div class="am-container">
    <div class="am-body">
        <div class="am-head">
            <h1>Patient Record Update</h1>
        </div>
        <p class = "success">
            <?php
                if(isset($successPrompt["successSubmit"])){
                    echo $successPrompt["successSubmit"];
                }else{
                    echo "";
                }
            ?>
        </p>

        <form class="am-body-box" method="post" action="patientRecordUpdate.php">
        <a href="patientRecord.php"><i class="fas fa-arrow-alt-circle-left"></i></a>

            <div class="am-row">
                <div class="am-col-6">
                    <p>Patient ID</p>
                    <input type="number" name="patientID" id="patientID" value="<?php echo $patientID; ?>" readonly>
                </div>

            </div>

            <div class="am-row">
                <div class="am-col-6">
                    <p>First Name</p>
                    <input type="text" name="patientFirstName" id="patientFirstName" placeholder="Enter New First Name" value="<?php echo $patientFirstName; ?>" required>
                </div>

                <div class="am-col-6">
                    <p>Last Name</p>
                    <input type="text" name="patientLastName" id="patientLastName" placeholder="Enter New Last Name" value="<?php echo $patientLastName; ?>" required>
                </div>
            </div>

            <div class="am-row">
                <div class="am-col-6">
                    <p>Age</p>
                    <input type="number" name="patientAge" id="patientAge" placeholder="Enter New Age" value="<?php echo $patientAge; ?>" required>
                </div>

                <div class="am-col-6">
                    <p>Sex</p>
                    <select name="patientSex">
                        <option value="M" <?php echo ($patientSex == 'M') ? 'selected' : ''; ?>>Male</option>
                        <option value="F" <?php echo ($patientSex == 'F') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
            </div>

            <div class="am-row">
                <div class="am-col-6">
                    <p>Mobile Number</p>
                    <input type="text" name="patientMobileNo" id="patientMobileNo" placeholder="Enter New Mobile Number" value="<?php echo $patientMobileNo; ?>" required>
                </div>

                <div class="am-col-6">
                    <p>Email</p>
                    <input type="email" name="patientEmail" id="patientEmail" placeholder="Enter New Email" value="<?php echo $patientEmail; ?>" required>
                </div>
            </div>

            <div class="am-row">
                <div class="am-col-6">
                    <p>Address</p>
                    <input type="text" name="patientAddress" id="patientAddress" placeholder="Enter New Address" value="<?php echo $patientAddress; ?>" required>
                </div>

                <div class="am-col-6">
                    <p>Occupation</p>
                    <input type="text" name="patientOccupation" id="patientOccupation" placeholder="Enter New Occupation" value="<?php echo $patientOccupation; ?>" required>
                </div>
            </div>

                <div class="am-row">
                    <div class="am-col-12">
                        <button type="submit" name="submit" onclick = "return confirm('Are you sure you want to update this record?');">UPDATE RECORD</button>
                    </div>
                </div>

        </form>
        <div class="am-footer">
                    <p>Toothbuds Dental Clinic</p>
                </div>

    </div>
</div>

</body>
</html>