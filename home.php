<?php
session_start();
 
require("connect-db.php");
require("userdb.php");

// logging out
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //reset everything including cookies and destroy session
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
    header("location: home.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="User Form">  
        <title>CS 4750 Home</title>
        <link rel="stylesheet" type="text/css" href="shared/homestyle.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
            /* Center text elements within the body */
            body_x {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
<body style="background-color: #d4d4dc;">
    <?php include('shared/header.php'); ?>

    <body_x>
        <br>
        <h1>Premier League Dream Team Maker</h1>

        <br>

        <img src="shared/premlogo.png">

        <br>
        
        <p>Welcome to the Premier League Dream Team Maker. In this app, you can build your own team of all time Premier League players including legends of the game and rising stars.</p>

        <h3>Steps</h3>
        <ol>
            <li>Create an account</li>
            <li>Next, create a team</li>
            <li>Filter through hundreds of players and add your favorites to your team</li>
            <li>Look at your friends' teams</li>
        </ol>
        
        <?php
        if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
            $name = $_SESSION["firstName"];
            echo "<h3>Logged in as <b>$name</b></h3>";

            echo '<br>';

            echo '<form method="post">
                    <div class="row mb-3 mx-3">
                        <input type = "submit" value = "Log Out" name = "logout"
                            class="btn btn-primary" title= "logout" />
                    </div>
                </form>';
        } else {
            ?>
            <a href="userform.php" class="button">Create an account now</a>
            <h3>or</h3>
            <a href="userlogin.php" class="button">Login</a>
            <?php
        }
        ?>


        <br>
    </body_x>
    
</body>
</html>
