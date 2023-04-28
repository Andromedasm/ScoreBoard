<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Score Entry Form</title>
    <!-- Include Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.4/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
<div class="flex justify-center items-center h-screen">
    <form action="score.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Enter Game Score</h2>
        <?php
        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            // Connect to the database
            require_once 'inc/db.php';

            // 连接到数据库
            $conn = getDatabaseConnection();

            // Get the player ID
            $player_id = $_POST['player_id'];

            // Get the game round
            $game_round = $_POST['game_round'];

            // Get the game time
            $game_time = date('Y-m-d H:i:s', strtotime($_POST['game_time']));

            // Get the score and multiplier
            $score = $_POST['score'];
            $multiplier = $_POST['multiplier'];

            // Calculate the total score based on the multiplier
            $total_score = $score * $multiplier;

            // Prepare and execute the SQL statement
            $stmt = $conn->prepare('INSERT INTO game_records (player_id, game_round, game_time, score, multiplier) VALUES (:player_id, :game_round, :game_time, :score, :multiplier)');
            $stmt->bindValue(':player_id', $player_id);
            $stmt->bindValue(':game_round', $game_round);
            $stmt->bindValue(':game_time', $game_time);
            $stmt->bindValue(':score', $total_score);
            $stmt->bindValue(':multiplier', $multiplier);
            $stmt->execute();

            // Redirect to the home page
            header('Location: index.php');
        }
        ?>
        <div class="mb-4">
            <label for="player_id" class="block font-medium text-gray-700">Player</label>
            <select name="player_id" id="player_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                <?php
                // Connect to the database
                $conn = new PDO('pgsql:host=localhost;dbname=mydatabase', 'myusername', 'mypassword');

                // Prepare and execute the SQL statement
                $stmt = $conn->prepare('SELECT id, name FROM players ORDER BY name');
                $stmt->execute();

                // Loop through the players and create an option for each one
                while ($row = $stmt->fetch()) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="game_round" class="block font-medium text-gray-700">Game Round</label>
            <input type="number" name="game_round" id="game_round" min="1" max="10" value="1"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                   required>
        </div>
        <div class="mb-4">
            <label for="game_time" class="block font-medium text-gray-700">Game Time</label>
            <input type="datetime-local" name="game_time" id="game_time"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                   required>
        </div>
        <div class="mb-4">
            <label for="score" class="block font-medium text-gray-700">Score</label>
            <input type="number" name="score" id="score"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                   required>
        </div>
        <div class="mb-4">
            <label for="multiplier" class="block font-medium text-gray-700">Multiplier</label>
            <select name="multiplier" id="multiplier"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    required>
                <option value="1">1x</option>
                <option value="2">2x</option>
                <option value="3">3x</option>
            </select>
        </div>
        <div class="mt-6">
            <button type="submit" name="submit"
                    class="w-full px-4 py-2 text-white font-semibold bg-indigo-500 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Submit Score
            </button>
        </div>
    </form>
</div>
</body>
</html>

        

        