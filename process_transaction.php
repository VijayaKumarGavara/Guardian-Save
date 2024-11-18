<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$accountType = $_SESSION['account_type'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data (recipient_account_number, amount, upi_pin)
    $sender_account_type = $_POST['sender_account_type'];
    $recipientAccountNumber = $_POST['recipient_account_number'];
    $amount = floatval($_POST['amount']);
    $upi_pin = $_POST['upi_pin'];

    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "test");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Step 1: Validate the UPI PIN
    $query = "SELECT upi_pin, balance FROM " . ($accountType === 'parent' ? 'parents' : 'children') . " WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
	
    if ($upi_pin === $row['upi_pin']) {
	echo '$row';
        // Incorrect UPI PIN, redirect with an error message
        //header("Location: transaction.html?error=incorrect_upi_pin");
        //exit();
    }

    // Step 2: Check if the sender has a sufficient balance
    if ($row['balance'] < $amount) {
        // Insufficient balance, redirect with an error message
        header("Location: transaction.php?error=insufficient_balance");
        exit();
    }

    // Step 3: Update sender's balance
    $newSenderBalance = $row['balance'] - $amount;

    // Step 4: Update recipient's balance
    $query = "SELECT balance FROM " . ($sender_account_type === 'parent' ? 'parents' : 'children') . " WHERE account_number = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $recipientAccountNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $newRecipientBalance = $row['balance'] + $amount;

    // Start a database transaction
    $mysqli->begin_transaction();

    try {
        // Update sender's balance
        $query = "UPDATE " . ($accountType === 'parent' ? 'parents' : 'children') . " SET balance = ? WHERE username = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ds", $newSenderBalance, $username);
        $stmt->execute();

        // Update recipient's balance
        $query = "UPDATE " . ($sender_account_type === 'parent' ? 'parents' : 'children') . " SET balance = ? WHERE account_number = ?";
	//$query = "UPDATE " . ($sender_account_type === 'parent' ? 'parents' : 'children') . " SET balance = ? WHERE account_number = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ds", $newRecipientBalance, $recipientAccountNumber);
        $stmt->execute();

        // Commit the transaction
        $mysqli->commit();

        // Redirect back to the dashboard with a success message
        header("Location: dashboarda.php?success=transaction_successful");
        exit();
    } catch (Exception $e) {
        // An error occurred, rollback the transaction and handle the error
        $mysqli->rollback();
        header("Location: transaction.html?error=transaction_failed");
        exit();
    } finally {
        // Close the database connection
        $stmt->close();
        $mysqli->close();
    }
} else {
    // Redirect to the transaction form if accessed without a POST request
    header("Location: transaction.php");
    exit();
}
?>