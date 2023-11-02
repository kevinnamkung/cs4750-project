<?php
    require("connect-db.php");
    require("userdb.php");

    $list_of_users = getAllUsers();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        if (!empty($_POST['userSubmit']))
        {
            addUser($_POST['firstname'], $_POST['lastname'], $_POST['email']);
            $list_of_users = getAllUsers();  
        }
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
        <h1>User Sign Up</h1>
        <form name="userSignUp" action="userCreated.php" method="post">
            <div class="row mb-3 mx-3">
                First Name:
                <input type="text" class="form-control" name="firstname" required/>
            </div>
            <div class="row mb-3 mx-3">
                Last Name:
                <input type="text" class="form-control" name="lastname" required/>      
            </div>  
            <div class="row mb-3 mx-3">
                Email:
                <input type="text" class="form-control" name="email" required/>        
            </div>
            <div class="row mb-3 mx-3">
                <input type = "submit" value = "Create Account" name = "userSubmit"
                    class="btn btn-primary" title= "Add User" />
            </div>
        </form> 
        </body_x>
    </body> 
</html>
