<?php
require('database.php');
$player_id = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM Beta_Tester
          ORDER BY PlayerID';
$statement = $db->prepare($query);
$statement->execute();
$players = $statement->fetchAll();
$statement->closeCursor();

$query2 = 'SELECT * FROM Beta_Tester WHERE PlayerID = :player_id';
$statement = $db->prepare($query2);
$statement->bindValue(':player_id', $player_id);
$statement->execute();
$player = $statement->fetch();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Player Manager</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<!-- the body section -->
<body>
    <header><h1>Player Manager</h1></header>

    <main>
        <h1>Edit Player</h1>
        <form action="add_edit_player.php" method="post"
              id="edit_player_form">

            <label>Player ID:</label>
            <input value="<?php echo $player['PlayerID']; ?>" type="text" name="player_id" readonly><br>

            <label>First Name:</label>
            <input value="<?php echo $player['PlayerFname']; ?>" type="text" name="player_fname"><br>

            <label>Last Name:</label>
            <input value="<?php echo $player['PlayerLname']; ?>" type="text" name="player_lname"><br>

            <label>Street 1:</label>
            <input value="<?php echo $player['Street1']; ?>" type="text" name="street1"><br>

            <label>Street 2:</label>
            <input value="<?php echo $player['Street2']; ?>" type="text" name="street2"><br>

            <label>Zip Code:</label>
            <input value="<?php echo $player['ZipCode']; ?>" type="text" name="zip_code"><br>

            <label>State:</label>
            <input value="<?php echo $player['State']; ?>" type="text" name="state"><br>

            <input type="submit" value="Edit Player"><br>
        </form>
        <p><a href="player_list.php">View Player List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Player Manager Inc.</p>
    </footer>
</body>
</html>
