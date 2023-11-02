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
?>
