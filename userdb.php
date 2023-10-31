<?php
function addUser($firstname, $lastname, $email) 
{
  global $db; 
//   $query = "insert into friends values ('" . $friendname . "', '" . $major . "'," . $year .") ";
  //=$db->query($query);  // compile + exe

  $query = "INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)";
  // prepare: 
  // 1. prepare (compile) 
  // 2. bindValue + exe

  $statement = $db->prepare($query); 
  $statement->bindValue(':firstname', $firstname);
  $statement->bindValue(':lastname', $lastname);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $statement->closeCursor();
}

function getAllUsers()
{
  global $db;
  $query = "select * from users";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function updateUser($firstname, $lastname , $email)
{
    global $db; 
    $query = "update users set firstname=:firstname, lastname=:lastname where email=:email";

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
    $query = "delete from users where email=:email";

    $statement = $db->prepare($query); 
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
}
?>
