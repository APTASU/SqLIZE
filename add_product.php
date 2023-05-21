<?php


// Get the player and game data
$gameID = filter_input(INPUT_POST, 'game_id', FILTER_VALIDATE_INT);
$playerFname = filter_input(INPUT_POST, 'player_fname');
$playerLname = filter_input(INPUT_POST, 'player_lname');
$street1 = filter_input(INPUT_POST, 'street1');
$street2 = filter_input(INPUT_POST, 'street2');
$zipCode = filter_input(INPUT_POST, 'zip_code');
$state = filter_input(INPUT_POST, 'state');


// Validate inputs
if (
    $gameID === null || 
    $playerFname == null ||
    $playerLname == null ||
    $street1 == null ||
    $zip_Code == null ||
    $state == null 
) {
    $error = "Invalid player or game data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');
    // Add the player to the database

    $query = 'INSERT INTO Beta_Tester (PlayerFname, PlayerLname, Street1, Street2, ZipCode, State)
              VALUES (:player_fname, :player_lname, :street1, :street2, :zip_Code, :state)';
    $statement = $db->prepare($query);

    $statement->bindValue(':player_fname', $playerFname);
    $statement->bindValue(':player_lname', $playerLname);
    $statement->bindValue(':street1', $steet1);
    $statement->bindValue(':street2', $steet2);
    $statement->bindValue(':zip_Code', $ZipCode);
    $statement->bindValue(':state', $state);
    $statement->execute();
    $statement->closeCursor();

    $playerID = $db->lastInsertID();

    $query =  'INSERT INTO Payment (PlayerID, GameID)
               VALUES (:player_id, :game_id)';
    $statement = $db->prepare($query);           
    $statement->bindValue(':player_id', $playerID);
    $statement->bindValue(':game_id', $gameID);
    $statement->execute();
    $statement->closeCursor();

    // Redirect to a success page or desired location
    header("Location: index.php");
}
?>
