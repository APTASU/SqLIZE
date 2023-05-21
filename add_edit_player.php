<?php
$player_id = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);
$player_fname = filter_input(INPUT_POST, 'player_fname');
$player_lname = filter_input(INPUT_POST, 'player_lname');
$street1 = filter_input(INPUT_POST, 'street1');
$street2 = filter_input(INPUT_POST, 'street2');
$zip_code = filter_input(INPUT_POST, 'zip_code');
$state = filter_input(INPUT_POST, 'state');

if (
    $player_id == null ||
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
    SET PlayerFname = :player_fname, PlayerLname = :player_lname, Street1 = :street1, Street2 = :street2, ZipCode = :zip_code, State = :state
    WHERE PlayerID = :player_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $player_id);
    $statement->bindValue(':player_fname', $player_fname);
    $statement->bindValue(':player_lname', $player_lname);
    $statement->bindValue(':street1', $street1);
    $statement->bindValue(':street2', $street2);
    $statement->bindValue(':zip_code', $zip_code);
    $statement->bindValue(':state', $state);
    $statement->execute();
    $statement->closeCursor();

    include('index.php');
}
?>
