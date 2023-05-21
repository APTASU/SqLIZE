<?php
require_once('database.php');

$query = 'SELECT *
          FROM Game
          ORDER BY GameID';

$statement = $db->prepare($query);
$statement->execute();
$games = $statement->fetchAll();
$statement->closeCursor();

// Get the player and game data
$playerFname = filter_input(INPUT_POST, 'player_fname');
$playerLname = filter_input(INPUT_POST, 'player_lname');
$street1 = filter_input(INPUT_POST, 'street1');
$street2 = filter_input(INPUT_POST, 'street2');
$zipCode = filter_input(INPUT_POST, 'zip_code');
$state = filter_input(INPUT_POST, 'state');
$gameID = filter_input(INPUT_POST, 'game_id', FILTER_VALIDATE_INT);

// Validate inputs
if (
    $playerFname == null ||
    $playerLname == null ||
    $street1 == null ||
    $zipCode == null ||
    $state == null ||
    $gameID === null || 
    $gameID === false
) {
    $error = "Invalid player or game data. Check all fields and try again.";
    include('error.php');
} else {
    // Add the player to the database
    $query = 'INSERT INTO Beta_Tester (PlayerFname, PlayerLname, Street1, Street2, ZipCode, State)
              VALUES (:player_fname, :player_lname, :street1, :street2, :zip_code, :state)';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_fname', $playerFname);
    $statement->bindValue(':player_lname', $playerLname);
    $statement->bindValue(':street1', $street1);
    $statement->bindValue(':street2', $street2);
    $statement->bindValue(':zip_code', $zipCode);
    $statement->bindValue(':state', $state);
    $statement->execute();
    $statement->closeCursor();

    // Get the newly added player's ID
    $playerID = $db->lastInsertId();

    // Add the player to the game
    $query = 'INSERT INTO Player_Game (PlayerID, GameID)
              VALUES (:player_id, :game_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $playerID);
    $statement->bindValue(':game_id', $gameID);
    $statement->execute();
    $statement->closeCursor();

    // Redirect to a success page or desired location
    header("Location: player_added_to_game.php");
}
?>
