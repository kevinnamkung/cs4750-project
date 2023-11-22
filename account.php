<?php
    require("connect-db.php");
    require("userdb.php");

    session_start();
    
    //check if user is logged in
    if(!isset($_SESSION["logged"]) && $_SESSION["logged"] == false){
        header("location: userLogin.php");
        exit;
    }

?>

<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="User Form">  
        <title>User Sign Up</title>
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
            <h2>Your Account</h2>
            <h4>Review your information below:<h4>
            
            <h5><b>First Name: </b><?php echo htmlspecialchars($_SESSION["firstName"]); ?></h5>
            <h5><b>Last Name: </b><?php echo htmlspecialchars($_SESSION["lastName"]); ?></h5>
            <h5><b>Email: </b><?php echo htmlspecialchars($_SESSION["email"]); ?></h5>
            <form method="post" action="userEdit.php">
                <div class="row mb-3 mx-3">
                    <input type = "submit" value = "Update Info" name = "update"
                        class="btn btn-primary" title= "update info" />
                </div>
            </form>
            <!-- <a href="userHub.php" class = "button">User Hub</a> -->
        </body_x>
    </body>
</html>