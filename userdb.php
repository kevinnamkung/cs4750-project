<?php
function addUser($firstname, $lastname, $email, $pw) {
  global $db;
  // Hash the password using password_hash
  $hashedPassword = password_hash($pw, PASSWORD_DEFAULT);
  
  $query = "INSERT INTO User (firstname, lastname, email, hashed_password) VALUES (:firstname, :lastname, :email, :hashed_password)";

  try{
    // Prepare the SQL query
    $statement = $db->prepare($query);
    
    // Bind values
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':hashed_password', $hashedPassword);
    
    // Execute the query
    $statement->execute();
    $statement->closeCursor();
    
    // $query2 = "SELECT userID FROM User WHERE email = :email";
    // $statement2 = $db->prepare($query2);
    // $statement2->bindValue(":email", $email);
    // $statement2->execute();
    // $results = $statement->fetchAll();   // fetch()
    // $statement2->closeCursor();

    session_start();
    $_SESSION['logged'] = true;
    $_SESSION['firstName'] = $firstname;
    $_SESSION['lastName'] = $lastname;
    $_SESSION['email'] = $email;
    #$_SESSION['userID'] = $results[0]['userID'];
    
    header("location: userCreated.php");
  } catch (PDOException $e) {
    // Handle any database errors here, e.g., log the error, display an error message, etc.
    error_log("Error: " . $e->getMessage());
  }
}

function getAllUsers()
{
  global $db;
  $query = "select * from User";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function updateUser($firstname, $lastname , $email)
{
    global $db; 
    $query = "update User set firstname=:firstname, lastname=:lastname where email=:email";

    $statement = $db->prepare($query); 
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
}

function deleteUser($email)
{
    global $db; 
    $query = "delete from User where email=:email";

    $statement = $db->prepare($query); 
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
}

function loginUser($email, $password)
{
  global $db;
  $query = "select * from User where email = :email";

  $statement = $db->prepare($query); 
  $statement->bindValue(':email', $email);
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();

  // does user exist
  if(count($results) == 1 && $results[0]['email'] == $email){
    // check if password is correct
    if(password_verify($password, $results[0]['hashed_password'])){
        session_start();
        $_SESSION['userID'] = $results[0]['userID'];
        $_SESSION['firstName'] = $results[0]['firstName'];
        $_SESSION['lastName'] = $results[0]['lastName'];
        $_SESSION['email'] = $results[0]['email'];
        $_SESSION['logged'] = true;
        header("location: userHub.php");
    } else {
      $_SESSION['logged'] = false;
    }
  } else {
    $_SESSION['logged'] = false;
  }
  
}
?>
