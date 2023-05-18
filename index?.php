<?php
require_once('database.php');

// Get player ID
if (!isset($player_id)) {
    $player_id = filter_input(INPUT_GET, 'player_id', FILTER_VALIDATE_INT);
    if ($player_id == NULL || $player_id == FALSE) {
        $player_id = 1;
    }
}

// Get name for selected player
$queryPlayer = 'SELECT * FROM Beta_Tester WHERE PlayerID = :player_id';
$statement1 = $db->prepare($queryPlayer);
$statement1->bindValue(':player_id', $player_id);
$statement1->execute();
$player = $statement1->fetch();
$player_name = $player['PlayerFname'] . ' ' . $player['PlayerLname'];
$statement1->closeCursor();

// Get all players
$query = 'SELECT * FROM Beta_Tester ORDER BY PlayerID';
$statement = $db->prepare($query);
$statement->execute();
$players = $statement->fetchAll();
$statement->closeCursor();

// Get games for selected player
$queryGames = 'SELECT g.* FROM Game g
               INNER JOIN Payment p ON g.GameID = p.GameID
               WHERE p.PlayerID = :player_id
               ORDER BY g.GameID';
$statement3 = $db->prepare($queryGames);
$statement3->bindValue(':player_id', $player_id);
$statement3->execute();
$games = $statement3->fetchAll();
$statement3->closeCursor();
?>

<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Game Manager</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<!-- the body section -->
<body>
    <header><h1>Game Manager</h1></header>
    <main>
        <h1>Player List</h1>
        <aside>
            <!-- display a list of players -->
            <h2>Players</h2>
            <nav>
                <ul>
                    <?php foreach ($players as $player) : ?>
                        <li>
                            <a href=".?player_id=<?php echo $player['PlayerID']; ?>">
                                <?php echo $player['PlayerFname'] . ' ' . $player['PlayerLname']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>          
        </aside>
        <section>
            <!-- display a table of games for selected player -->
            <h2><?php echo $player_name; ?></h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Released</th>
                    <th>Cost</th>
                </tr>
                <?php foreach ($games as $game) : ?>
                    <tr>
                        <td><?php echo $game['GameID']; ?></td>
                        <td><?php echo $game['Gamename']; ?></td>
                        <td><?php echo $game['Date_Realeased']; ?></td>
                        <td><?php echo $game['GameCost']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p><a href="add_game_form.php?player_id=<?php echo $player_id; ?>">Add Game</a></p>
            <p><a href="player_list.php">List Players</a></p>        
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Game Manager Inc.</p>
    </footer>
</body>
</html>
