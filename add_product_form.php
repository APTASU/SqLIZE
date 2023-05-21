<!-- add_player_form.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Add Players</title>
</head>
<body>
    <h2>Add Players</h2>
    <form action="add_players.php" method="post">
        <label for="game_id">Game ID:</label>
        <input type="text" name="game_id" id="game_id" required>
        <hr>
        <h3>Players:</h3>
        <div id="players-container">
            <div class="player">
                <label for="player_fname">First Name:</label>
                <input type="text" name="player[0][player_fname]" required>
                <br>
                <label for="player_lname">Last Name:</label>
                <input type="text" name="player[0][player_lname]" required>
                <br>
                <label for="street1">Street 1:</label>
                <input type="text" name="player[0][street1]" required>
                <br>
                <label for="street2">Street 2:</label>
                <input type="text" name="player[0][street2]">
                <br>
                <label for="zip_code">ZIP Code:</label>
                <input type="text" name="player[0][zip_code]" required>
                <br>
                <label for="state">State:</label>
                <input type="text" name="player[0][state]" required>
                <hr>
            </div>
        </div>
        <button type="button" onclick="addPlayer()">Add Player</button>
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        var playerCount = 1;

        function addPlayer() {
            var playerContainer = document.getElementById("players-container");

            var playerDiv = document.createElement("div");
            playerDiv.classList.add("player");

            var playerHTML = `
                <label for="player_fname">First Name:</label>
                <input type="text" name="player[${playerCount}][player_fname]" required>
                <br>
                <label for="player_lname">Last Name:</label>
                <input type="text" name="player[${playerCount}][player_lname]" required>
                <br>
                <label for="street1">Street 1:</label>
                <input type="text" name="player[${playerCount}][street1]" required>
                <br>
                <label for="street2">Street 2:</label>
                <input type="text" name="player[${playerCount}][street2]">
                <br>
                <label for="zip_code">ZIP Code:</label>
                <input type="text" name="player[${playerCount}][zip_code]" required>
                <br>
                <label for="state">State:</label>
                <input type="text" name="player[${playerCount}][state]" required>
                <hr>
            `;

            playerDiv.innerHTML = playerHTML;
            playerContainer.appendChild(playerDiv);

            playerCount++;
        }
    </script>
</body>
</html>
