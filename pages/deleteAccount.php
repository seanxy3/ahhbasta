<?php
include("../phpFiles/dbConnect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["accountID"])) {
    $accountID = $_GET["accountID"];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete account
    $deleteSql = "DELETE FROM accounts WHERE accountID = $accountID";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Account deleted successfully";
    } else {
        echo "Error deleting account: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}
header('location: ./accountManagement.php');
?>