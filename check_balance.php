<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$accountType = $_SESSION['account_type'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $upi_pin = $_POST['upi_pin'];

    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "test");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Validate the UPI PIN
    $query = "SELECT upi_pin, balance FROM " . ($accountType === 'parent' ? 'parents' : 'children') . " WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($upi_pin !== $row['upi_pin']) {
        // Incorrect UPI PIN, set an error message
        $error_message = "Incorrect UPI PIN. Please try again.";
    } else {
        // UPI PIN is correct, display the balance
        $success_message = "Your balance is Rs " . $row['balance'] ;
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Balance</title>
    <link rel="icon" type="image" href="Yellow Minimalist Round Shaped Cafe Logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,500;0,700;1,400&family=Roboto+Slab:wght@300;400&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .container{
  position: relative;
  max-width: 1250px;
  width: 100%;
  max-height: 600px;
  height: 100%;
  background: #fff;
  padding: 40px 30px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.2);
  perspective: 2700px;
}
        body{
            font-family: 'Poppins',sans-serif;
            background: #9400ff;
        }
        nav{
            display: flex;
            //justify-content: space-around;
            align-items: center;
            height: 70px;
        }
        nav ul{
            display: flex;
            justify-content: flex-end;
            margin-left : 140px;
        }
        .name{
            display : flex;
            justify-content : flex-end;
            margin-left : 40px;
        }
        nav ul li;{
            font-size: 1.2rem;
            list-style: none;
            margin: 0 25px;
        }
        .left{
            font-size: 2rem;
        }
        .name1{
            color: white;
        }
        .name2{
            color: #27005D   
        }
        .one{
            color: black;
        }
        .two{
            width: 220px;
            height: 70px;
            cursor: pointer;
            border-radius: 7px;
            border-style: solid white;
            border-color: white;
            border-width: 3.5px;
            font-size: 1.3rem;
            font-family: 'Poppins',sans-serif;
            font-weight: bold;
            color: white;
            background-color: #9400FF;
            position:absolute;
            /* text-align:right; */
            margin: left 65px;
            

            
        }
        .one:hover{
            color: #27005D;
        }
        .two:hover{
            color: #27005D ;
            background-color: #EEEEEE;
        }
        a{
            text-decoration: none;
        }
        header{
            position: sticky;
            background-color: #9400ff;
            height: 150px;
        }
        .main{
            background-color: white;
            height: 500px;
            padding-top: 0px 30px 20px 0px;
            font-size: 3rem;
            text-align:left;
            
        }
        .name{
            color: #27005D;
            text-align: left;
            
        }
        .but{
            margin-top:60px ;
            width: 220px;
            height: 70px;
            cursor: pointer;
            border-radius: 7px;
            border-style: solid;
            border-width: 3.5px;
            color: black;
            font-size: 1.3rem;
            font-family: 'Poppins',sans-serif;
            font-weight: bold;
            color:#9400FF;
            background-color:#EEEEEE;
            /* text-align: center; */
            
        }
        .but:hover{
            color:#EEEEEE;
            background-color:#9400FF;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="name" > 
                <p style="color:white; font-size:60px; margin-top: 60px; margin-right: 0px;">Guardian Save</p>
                </div>

             <ul>
                    <!-- <a href="index.html"><li class="one">Home</li></a>
                    <a href="abouthtml"><li class="two">About</li></a>
                    <a href="#"><li class="one">Projects</li></a> -->
                    <a href="logout.php"><button class="two">Logout</button></a>
                </ul>
            </div>
        </nav>
    </header>
    <center><div class="container">
        <div class="main"> 
            <p>Check Balance</p>
            <?php if (isset($error_message)): ?>
            <p><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <p><?php echo $success_message; ?></p>
            
        <?php else: ?>
            <form action="" method="post">
                <label for="upi_pin" style="font-size:25px">Enter Your UPI PIN:</label>
                <input style="height:25px;" type="password" name="upi_pin" required><br><br>
                <input class="but" style="text-align: center; align-content: left;" type="submit" name="submit" value="Check Balance">
               
            </form>
            <br>
        <a href="dashboarda.php" style="font-size: 20px;">Go Back to DashBoard</a>
            
        <?php endif; ?>
            
        </div>
    </div>
    </center>
    
</body>
</html>