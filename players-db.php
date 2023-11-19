<?php
function getAllPlayers()
{
  global $db;
  $query = "SELECT * FROM Players;"; 
//   $query = "SELECT
//         Players.playerName,
//         Players.position,
//         Players.nationality,
//         Players.club,
//         Forward.goals,
//         Forward.shots,
//         Forward.assists,
//         Midfielder.duelsWon,
//         Midfielder.passes,
//         Midfielder.assists,
//         Defender.cleanSheets,
//         Defender.tackleSuccess,
//         Goalkeepers.cleanSheets,
//         Goalkeepers.saves
//     FROM
//     Players
//     LEFT JOIN Forward ON Players.playerName = Forward.playerName
//     LEFT JOIN Midfielder ON Players.playerName = Midfielder.playerName
//     LEFT JOIN Defender ON Players.playerName = Defender.playerName
//     LEFT JOIN Goalkeepers ON Players.playerName = Goalkeepers.playerName;
//     ";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function filterPlayers($playerName, $position, $club, $nationality)
{
    global $db;

    $query = "select * from Players"; // Starting with a true condition
    
    if ($position !== null && !empty($position)) {
        //$query .= " AND position = :position";
        if($position = "Forward") {
            $query .= " NATURAL JOIN Forward";

        }
        if($position = "Midfielder") {
            $query .= " NATURAL JOIN Midfielder";

        }
        if($position = "Defender") {
            $query .= " NATURAL JOIN Defender";

        }
        if($position = "Goalkeeper") {
            $query .= " NATURAL JOIN Goalkeepers";
        }
    }

    $query .= " WHERE 1=1";

    // Add conditions for filtering if criteria are provided
    if ($playerName !== null && !empty($playerName)) {
        $query .= " AND playerName = :playerName";
        //if ($position!=NULL or $club!=NULL or $nationality !=NULL){
        //    $query .= " AND";
        //}
        
    }
    
    if ($club !== null && !empty($club)) {
        $query .= " AND club = :club";
        //if ($nationality !=NULL){
        //    $query .= " AND";
        //}
    }
    
    if ($nationality !== null && !empty($nationality)) {
        $query .= " AND nationality = :nationality";
    }

    $statement = $db->prepare($query);

    // Bind parameters if they are provided
    if ($playerName !== null && !empty($playerName)) {
        $statement->bindValue(':playerName', $playerName);
    }

    if ($position !== null && !empty($position)) {
        $statement->bindValue(':position', $position);
    }

    if ($club !== null && !empty($club)) {
        $statement->bindValue(':club', $club);
    }

    if ($nationality !== null && !empty($nationality)) {
        $statement->bindValue(':nationality', $nationality);
    }

        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
}
?>