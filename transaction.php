

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
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
            justify-content: flex-start;
            margin-left:140px;
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
            padding-top: 0px;
            font-size: 20px;
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
        .namea{
            display : flex;
            justify-content: flex-end;
            margin-left : 140px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="namea" > 
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
            <p style="font-size: 3rem;">Transaction</p><br>
             <form action="process_transaction.php" method="post">
              
                    <label for="sender_account_number" style="font-size:20px">Recipient Account type:</label>
                    <select id="sender_account_type" style="font-size:20px"  name="sender_account_type" required><br><br>
                    <option style="font-size:20px" value="parent">Guardian</option>
                    <option style="font-size:20px" value="child">Dependent</option>
                   </select><br><br>
                
                    <label style="font-size:20px" for="recipient_account_number">Recipient Account Number:</label>
                    <input style="height:20px;"  type="text" name="recipient_account_number" required><br><br>
                
                    <label style=" font-size:20px" for="amount">Amount:</label>
                    <input style="height:20px;" type="number" name="amount" required><br><br>
                
                <label for="upi_pin" style="font-size:20px">Enter Your UPI PIN:</label>
                <input style="height:20px;" type="password" name="upi_pin" required><br><br>
                <input class="but" style="text-align: center; align-content: left;" type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>
    </center>
    
</body>
</html>