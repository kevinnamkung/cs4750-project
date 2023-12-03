<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require("connect-db.php");
    require("userdb.php");

    session_start();

    //check if user is logged in
    if(!isset($_SESSION["logged"]) && $_SESSION["logged"] == false){
        header("location: userLogin.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {   
        if (!empty($_POST['createTeam']))
        {   
            echo "UserID: " . $_SESSION['userID'];
            createTeam($_SESSION['userID'], $_POST['teamName']);
            if (!empty($_POST['createTeam'])) {   
                $result = createTeam($_SESSION['userID'], $_POST['teamName']);
                echo "Create Team Result: " . ($result ? "Success" : "Failure");
                // Remove the below line after debugging
                exit; // Temporarily prevent redirection to see the result
            }
            header("location: userHub.php");
        }
    } 

?>

<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="User Form">  
        <title>Create New Team</title>
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
            <h1>Create New Team</h1>
            <form name="createTeam" method="post">
                <div class="row mb-3 mx-3">
                    Team Name
                    <input type="text" class="form-control" name="teamName" required/>
                </div>
                <div class="row mb-3 mx-3">
                    <input type = "submit" value = "Create Team" name = "createTeam"
                        class="btn btn-primary" title= "Create Team" />
                </div>
            </form> 
        </body_x>
    </body> 
</html>
