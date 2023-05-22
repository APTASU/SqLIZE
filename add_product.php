<?php
require_once('database.php');

// Get the player and game data
$game_id = filter_input(INPUT_POST, 'game_id', FILTER_VALIDATE_INT);
$player_fname = filter_input(INPUT_POST, 'player_fname');
$player_lname = filter_input(INPUT_POST, 'player_lname');
$street1 = filter_input(INPUT_POST, 'street1');
$street2 = filter_input(INPUT_POST, 'street2');
$zip_code = filter_input(INPUT_POST, 'zip_code');
$state = filter_input(INPUT_POST, 'state');

// Validate inputs
if (
    $game_id === null || 
    $player_fname === null ||
    $player_lname === null ||
    $street1 === null ||
    $zip_code === null ||
    $state === null 
) {
    $error = "Invalid player or game data. Check all fields and try again.";
    include('error.php');
} else {
    // Add the player to the database
    $query = 'INSERT INTO Beta_Tester (PlayerFname, PlayerLname, Street1, Street2, ZipCode, State)
              VALUES (:player_fname, :player_lname, :street1, :street2, :zip_code, :state)';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_fname', $player_fname);
    $statement->bindValue(':player_lname', $player_lname);
    $statement->bindValue(':street1', $street1);
    $statement->bindValue(':street2', $street2);
    $statement->bindValue(':zip_code', $zip_code);
    $statement->bindValue(':state', $state);
    $statement->execute();
    $statement->closeCursor();

    $playerID = $db->lastInsertID();

    $query =  'INSERT INTO Payment (PlayerID, GameID)
               VALUES (:player_id, :game_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $playerID);
    $statement->bindValue(':game_id', $game_id);
    $statement->execute();
    $statement->closeCursor();

    // Redirect to a success page or desired location
    header("Location: index.php");
}
?>
