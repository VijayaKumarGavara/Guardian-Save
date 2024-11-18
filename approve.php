<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the logged-in user is a parent
$type = $_SESSION['account_type'];
if ($type === "parent") {
    header("Location: transaction.php");
    exit();
}

// Initialize variables
$error = null;
$childName = null;
$amount = 100; // Example amount, can be fetched dynamically if needed

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept'])) {
        $enteredUpiPin = $_POST['upi_pin'];

        // Establish database connection
        $mysqli = new mysqli("localhost", "root", "", "test");
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Fetch parent_token_id and child's name based on the username
        $childUsername = $_SESSION['username'];
        $query = "SELECT parent_token_id, name FROM children WHERE username = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $childUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $dbParentTokenId = $row['parent_token_id'];
            $childName = $row['name'];

            // Fetch the parent's UPI PIN using parent_token_id
            $query = "SELECT upi_pin FROM parents WHERE token_id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("s", $dbParentTokenId);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($parentUpiPin);

            if ($stmt->fetch()) {
                // Validate the entered UPI PIN
                if ($enteredUpiPin === $parentUpiPin) {
                    // UPI PIN is correct, proceed to transaction
                    header("Location: transaction.php");
                    exit();
                } else {
                    $error = "Invalid UPI PIN. Please try again.";
                }
            } else {
                $error = "UPI PIN not found. Please try again.";
            }
        } else {
            $error = "Child's information not found. Please try again.";
        }

        // Close database connection
        $stmt->close();
        $mysqli->close();
    } elseif (isset($_POST['reject'])) {
        // Parent rejects the request, redirect to dashboard
        header("Location: dashboarda.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Request Approval</title>
    <link rel="icon" type="image" href="Yellow Minimalist Round Shaped Cafe Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,500;0,700;1,400&family=Roboto+Slab:wght@300;400&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <style>
        /* Add your CSS styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #9400ff;
        }
        nav {
            display: flex;
            align-items: center;
            height: 70px;
        }
        nav ul {
            display: flex;
            justify-content: flex-end;
            margin-left: 50px;    
        }
        nav ul li {
            font-size: 1.2rem;
            list-style: none;
            margin: 0 25px;
        }
        .container {
            max-width: 1250px;
            margin: auto;
            padding: 40px;
            background: white;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }
        .but1, .but2 {
            margin-top: 20px;
            width: 220px;
            height: 70px;
            border-radius: 7px;
            border: 3.5px solid;
            font-size: 1.3rem;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
        }
        .but1 {
            color: #9400FF;
            background-color: #EEEEEE;
        }
        .but2 {
            color: #9400FF;
            background-color: #EEEEEE;
        }
        .but1:hover {
            color: #EEEEEE;
            background-color: #5D9C59;
        }
        .but2:hover {
            color: #EEEEEE;
            background-color: red;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div>
                <p style="color:white; font-size:60px; margin-top: 60px;">Guardian Save</p>
            </div>
            <ul>
                <li><a href="logout.php"><button class="but1">Logout</button></a></li>
            </ul>
        </nav>
    </header>
    <center>
        <div class="container">
            <div class="main">
                <h2>Money Request Approval</h2><br>
                <p style="font-size: 2rem;">You got a money request from <?php echo htmlspecialchars($childName); ?>:</p>
                <p style="font-size: 2rem;">Do you want to accept or reject this request?</p>
                <form action="approve.php" method="post">
                    <?php if (isset($error)) { ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                    <?php } ?>
                    <label for="upi_pin" style="font-size: 1.8rem;">Enter Your UPI PIN:</label>
                    <input style="height: 1.8rem; width: 300px; border: 2px solid black" type="password" name="upi_pin"><br><br>
                    <input class="but1" type="submit" name="accept" value="Accept">
                    <input class="but2" type="submit" name="reject" value="Reject">
                </form>
            </div>
        </div>
    </center>
</body>
</html>
