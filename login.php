<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "test");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$accountType = $_POST['account_type'];

$query = "";
$tableName = "";

if ($accountType === 'parent') {
    $query = "SELECT * FROM parents WHERE username = ?";
    $tableName = "parents";
} elseif ($accountType === 'child') {
    $query = "SELECT * FROM children WHERE username = ?";
    $tableName = "children";
} else {
    die("Invalid account type. Please select 'parent' or 'child'.");
}

$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Username not found. Please check and try again.";
} else {
    $row = $result->fetch_assoc();
    if (($password === $row['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['account_type'] = $accountType;
        header("Location: dashboarda.php");
        // Perform any necessary actions after successful login
    } else {
        echo "Incorrect password. Please try again.";
    }
    
}

$stmt->close();
$mysqli->close();
?>