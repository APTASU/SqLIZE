<?php
$PlayerId = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);
$PlayerFname = filter_input(INPUT_POST, 'player_fname');
$PlayerLname = filter_input(INPUT_POST, 'player_lname');
$street1 = filter_input(INPUT_POST, 'street1');
$street2 = filter_input(INPUT_POST, 'street2');
$ZipCode = filter_input(INPUT_POST, 'zip_code');
$State = filter_input(INPUT_POST, 'state');

if (
    $PlayerId == null ||
    $PlayerFname == null ||
    $PlayerLname == null ||
    $Street1 == null ||
    $ZipCode == null ||
    $State == null
) {
    $error = "Invalid player data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    $query = 'UPDATE Beta_Tester
    SET PlayerFname = :player_fname, PlayerLname = :player_lname, Street1 = :street1, Street2 = :street2, ZipCode = :zip_code, State = :state
    WHERE PlayerID = :player_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $playerId);
    $statement->bindValue(':player_fname', $playerFname);
    $statement->bindValue(':player_lname', $playerLname);
    $statement->bindValue(':street1', $street1);
    $statement->bindValue(':street2', $street2);
    $statement->bindValue(':zip_code', $ZipCode);
    $statement->bindValue(':state', $state);
    $statement->execute();
    $statement->closeCursor();

    include('index.php');
}
?>
