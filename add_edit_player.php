<?php
$player_id = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);
$player_fname = filter_input(INPUT_POST, 'player_fname');
$player_lname = filter_input(INPUT_POST, 'player_lname');
$street1 = filter_input(INPUT_POST, 'street1');
$street2 = filter_input(INPUT_POST, 'street2');
$zip_code = filter_input(INPUT_POST, 'zip_code');
$state = filter_input(INPUT_POST, 'state');

if (
    $player_fname == null ||
    $player_lname == null ||
    $street1 == null ||
    $zip_code == null ||
    $state == null
) {
    $error = "Invalid player data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    $query = 'UPDATE Beta_Tester
    SET PlayerFname = :player_fname, PlayerLname = :player_lname, Street1 = :street1, Street2 = :street2, ZipCode = :zip_code, State = :state';

    // Add condition to include Player ID in the query only if it is set and valid
    if ($player_id !== null && $player_id !== false) {
        $query .= ', PlayerID = :player_id';
    }

    $query .= ' WHERE PlayerID = :player_id_existing';

    $statement = $db->prepare($query);
    $statement->bindValue(':player_fname', $player_fname);
    $statement->bindValue(':player_lname', $player_lname);
    $statement->bindValue(':street1', $street1);
    $statement->bindValue(':street2', $street2);
    $statement->bindValue(':zip_code', $zip_code);
    $statement->bindValue(':state', $state);

    // Bind the Player ID values based on whether it is editable or not
    if ($player_id !== null && $player_id !== false) {
        $statement->bindValue(':player_id', $player_id);
    }
    $statement->bindValue(':player_id_existing', $player_id);

    $statement->execute();
    $statement->closeCursor();

    header("Location: index.php"); // Added a redirect to the index page
    exit; // Added an exit statement to stop further execution
}
?>
