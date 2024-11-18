<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page as needed
    header("Location: index.html");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: index.html");
    exit();
}
?>