<?php
session_start();
// Establish a database connection
$mysqli = new mysqli("localhost", "root", "", "test");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$dateOfBirth = $_POST['date_of_birth'];
$accountNumber = $_POST['account_number'];
$username = $_POST['username'];
$password = $_POST['password']; // Hash the password
$accountType = $_POST['account_type'];
$parentToken = isset($_POST['parent_token']) ? $_POST['parent_token'] : null;

// Initialize token ID
$tokenID = null;

// Determine the SQL query based on the account type
if ($accountType === 'parent') {
    $tokenID = generateUniqueToken();

    // Insert data into the 'parents' table
    $query = "INSERT INTO parents (account_number, name, date_of_birth, username, password, token_id) VALUES (?, ?, ?, ?, ?, ?)";
} elseif ($accountType === 'child') {
    // Verify that the parent's token exists in the parents table
    $parentTokenCheckQuery = "SELECT token_id FROM parents WHERE token_id = ?";
    $stmt = $mysqli->prepare($parentTokenCheckQuery);
    $stmt->bind_param("s", $parentToken);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the parent token is valid
    if ($result->num_rows === 0) {
        die("Parent token not found. Please check and try again.");
    }

    // Insert data into the 'children' table
    $query = "INSERT INTO children (account_number, parent_token_id, name, date_of_birth, username, password) VALUES (?, ?, ?, ?, ?, ?)";
}

// Prepare the SQL query
$stmt = $mysqli->prepare($query);

// Bind parameters based on account type
if ($accountType === 'parent') {
    $stmt->bind_param("ssssss", $accountNumber, $name, $dateOfBirth, $username, $password, $tokenID);
} elseif ($accountType === 'child') {
    $stmt->bind_param("ssssss", $accountNumber, $parentToken, $name, $dateOfBirth, $username, $password);
}

// Execute the SQL query
if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    $_SESSION['account_type'] = $accountType;
    header("Location: dashboarda.php");
} else {
    echo "Error: " . $stmt->error;
}

// Close the database connection and prepared statement
$stmt->close();
$mysqli->close();

// Function to generate a unique token
function generateUniqueToken() {
    return substr(md5(uniqid(rand(), true)), 0, 10);
}
?>
