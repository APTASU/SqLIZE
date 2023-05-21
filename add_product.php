<?php

// Get the game data
$gameID = filter_input(INPUT_POST, 'game_id', FILTER_VALIDATE_INT);

// Validate game ID
if ($gameID === null) {
    $error = "Invalid game ID. Please select a valid game.";
    include('error.php');
    exit;
}

// Get the players data as an array
$players = $_POST['player'];

// Validate inputs and add players
require_once('database.php');
$successCount = 0; // Counter for successful player additions

foreach ($players as $player) {
    $playerFname = filter_var($player['player_fname']);
    $playerLname = filter_var($player['player_lname']);
    $street1 = filter_var($player['street1']);
    $street2 = filter_var($player['street2']);
    $zipCode = filter_var($player['zip_code'], FILTER_VALIDATE_INT);
    $state = filter_var($player['state']);

    // Validate player inputs
    if (
        $playerFname == null ||
        $playerLname == null ||
        $street1 == null ||
        $zipCode === false ||
        $state == null
    ) {
        continue; // Skip invalid player data and move to the next player
    }

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

    $playerID = $db->lastInsertID();

    // Add payment information
    $query =  'INSERT INTO Payment (PlayerID, GameID)
               VALUES (:player_id, :game_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $playerID);
    $statement->bindValue(':game_id', $gameID);
    $statement->execute();

    $successCount++;
}

// Redirect to a success page or desired location
header("Location: index.php");
exit;
?>
