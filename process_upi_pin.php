<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "test");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$upiPin = $_POST['upi_pin'];
// Check if the user is a parent or child
$accountType = $_SESSION['account_type'];
$tableName = ($accountType === 'parent') ? 'parents' : 'children';

// Update the UPI PIN in the database
$query = "UPDATE $tableName SET upi_pin = ? WHERE username = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $upiPin, $username);

if ($stmt->execute()) {
    echo "<body align=center style='background-color:#9400ff;color:white;font-size:3rem;margin-top:300px'>UPI PIN updated successfully!</body>";
} else {
    echo "Error updating UPI PIN. Please try again.";
}
echo "<br><br>";
echo "<a href='dashboarda.php' style='text-decoration:none;color:white'>Go Back</a>";
$stmt->close();
$mysqli->close();
?>