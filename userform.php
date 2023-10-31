<?php
    require("connect-db.php");
    require("userdb.php");

    $list_of_users = getAllUsers();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        if (!empty($_POST['deleteBtn']))
        {
            deleteUser($_POST['email_delete']);
            $list_of_users = getAllUsers();
        }
        else if (!empty($_POST['confirmUpdateBtn']))
        {
            updateUser($_POST['firstname'], $_POST['lastname'], $_POST['email']);
            $list_of_users = getAllUsers();
        } 
        else if (!empty($_POST['actionBtn']))
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
        <meta name="description" content="potd5: user tables">  
        <title>POTD5: user tables</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
    </head>

    <body>
        <h1> POTD 5: User Table </h1>

        <form name="mainForm" action="userform.php" method="post">
            <div class="row mb-3 mx-3">
                First Name:
                <input type="text" class="form-control" name="firstname" required \
                    value="<?php echo $_POST['user_firstname_update']; ?>"
                />        
            </div>
            <div class="row mb-3 mx-3">
                Last Name:
                <input type="text" class="form-control" name="lastname" required
                    value="<?php echo $_POST['user_lastname_update']; ?>"
                />        
            </div>  
            <div class="row mb-3 mx-3">
                Email:
                <input type="text" class="form-control" name="email" required 
                    value="<?php echo $_POST['user_email_update']; ?>"
                />        
            </div>
            <div class="row mb-3 mx-3">
                <input type = "submit" value = "Create User" name = "actionBtn"
                    class="btn btn-primary" title= "Add User" />
            </div>
            <div class="row mb-3 mx-3">
                <input type = "submit" value = "Confirm Update" name = "confirmUpdateBtn"
                    class="btn btn-secondary" title= "Update User" />
            </div>
        </form> 


        <h3>List of Users</h3>
        <div class="row justify-content-center">  
        <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
            <thead>
            <tr style="background-color:#B0B0B0">
                <th width="30%">First Name        
                <th width="30%">Last Name        
                <th width="30%">Email 
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </thead>


        <?php foreach ($list_of_users as $user): ?>
            <tr>
                <td><?php echo $user['firstname']; ?></td> 
                <td><?php echo $user['lastname']; ?></td>        
                <td><?php echo $user['email']; ?></td> 
                <td>
                    <form action = "userform.php" method = "post">
                        <input type="submit" value="Update" name = "updateBtn" class="btn btn-secondary" />
                        <input type="hidden" name="user_firstname_update" value="<?php echo $user['firstname']; ?>" />
                        <input type="hidden" name="user_lastname_update" value="<?php echo $user['lastname']; ?>" />
                        <input type="hidden" name="user_email_update" value="<?php echo $user['email']; ?>" />
                    </form>
                </td>
                <td>
                    <form action = "userform.php" method = "post">
                    <input type="submit" value="Delete" name = "deleteBtn" class="btn btn-danger"  />
                    <input type="hidden" name="email_delete" value="<?php echo $user['email']; ?>" />
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
        </div>  

    </body> 
</html>
