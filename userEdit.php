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
            <h2>Edit your Information Below:</h2>
            
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3 mx-3">
                <label for="firstName" class="form-label"><b>First Name:</b></label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($_SESSION["firstName"]); ?>">
            </div>

            <div class="mb-3 mx-3">
                <label for="lastName" class="form-label"><b>Last Name:</b></label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($_SESSION["lastName"]); ?>">
            </div>

            <div class="mb-3 mx-3">
                <label for="email" class="form-label"><b>Email:</b></label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION["email"]); ?>">
            </div>

            <div class="row mb-3 mx-3">
                <input type="submit" value="Update Info" name="update" class="btn btn-primary" title="Update info" />
            </div>
        </form>


        </body_x>
    
    </body>
</html>