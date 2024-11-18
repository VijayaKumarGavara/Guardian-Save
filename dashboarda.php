<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
    // Check if the user has already set a UPI PIN
    $mysqli = new mysqli("localhost", "root", "", "test");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    $accountType = $_SESSION['account_type'];
	
    $query = "SELECT account_number,name FROM " . ($accountType === 'parent' ? 'parents' : 'children') . " WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
	$row = $result->fetch_assoc();
    $name = $row['name'];
    $account_number = $row['account_number'];
    
    //$stmt->close();
    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
  padding:0px 30px 20px 30px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.2);
  perspective: 2700px;
}
        body{
            font-family: 'Poppins',sans-serif;
            background: #9400ff;
        }
        nav{
		height : 50px;
            display: flex;
            //justify-content: space-evenly;
            align-items: center;
            height: 70px;
        }
        nav ul{
            display: flex;
            justify-content: center;
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
            color: #27005D   }
        .one{
            color: black;
        }
	.header{
		height : 60px;
	}
        .two{
            width: 220px;
            height: 50px;
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
            margin-right: 0px;

            

            
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
            padding-top: 30px;
            font-size: 15px;
            text-align:left;
            
        }
        .name{
            color: #27005D;
            text-align: left;
            
        }
        .but{
            margin-top:60px ;
            width: 200px;
            height: 70px;
            cursor: pointer;
            border-radius: 7px;
            border-style: solid;
            border-width: 3.5px;
            color: black;
            font-size: 1.1rem;
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
	ul{
	list-style : none;
    }
    .namea{
        display : flex;
        justify-content : flex-start;
        margin-left : 40px;
    }
#a{
  padding-top:30px;
  padding-right:300px;
}

    </style>
</head>
<body>
    <header>
        <nav>
            <div class="name namea"> 
                <p style="color:white; font-size:60px;" id="a">Guardian Save</p>
                </div>

             <ul>
                    <li><a href="logout.php"><button class="two">Logout</button></a></li>
                </ul>
            </div>
        </nav>
    </header>
    <center><div class="container">
        <div class="main"> 
            <p style="font-size: 3rem;">Hi, <?php
		echo $name;
		?>	  <div class="name" style="font-size: 3rem;">Welcome to Guardian Save
            </div></p>
            <br><p style="font-size: 25px;">Account Number:  <?php
		echo $account_number;
		?>	</p>
        
            <div >
            <a href="create_upi.php"><button class="but" style="margin-left:50px ;">Security Pin</button></a>
            
            <a href="check_balance.php"><button class="but" style="margin-left:150px ;">Check Balance</button></a>
            <a href="approve.php" target = "_blank"><button class="but" style="margin-left:200px ;">Transaction</button></a>
        </div></div>
    </div>
    </center>
    
</body>
</html>