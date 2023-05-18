<?php
// Get the game data
$gameID = filter_input(INPUT_POST, 'game_id');
$gameName = filter_input(INPUT_POST, 'game_name');
$dateReleased = filter_input(INPUT_POST, 'date_released');
$gameCost = filter_input(INPUT_POST, 'game_cost');

// Validate inputs
if (
    $gameID == null ||
    $gameName == null ||
    $dateReleased == null ||
    $gameCost == null
) {
    $error = "Invalid game data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the game to the database
    $query = 'INSERT INTO Game (GameID, Gamename, Date_Realeased, GameCost)
              VALUES (:game_id, :game_name, :date_released, :game_cost)';
    $statement = $db->prepare($query);
    $statement->bindValue(':game_id', $gameID);
    $statement->bindValue(':game_name', $gameName);
    $statement->bindValue(':date_released', $dateReleased);
    $statement->bindValue(':game_cost', $gameCost);
    $statement->execute();
    $statement->closeCursor();

    // Display the Game List page
    include('game_list.php');
}
?>
