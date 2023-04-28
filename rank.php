<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leaderboard</title>
    <!-- Include Tailwind CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.4/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
<div class="flex justify-center items-center h-screen">
    <table class="bg-white p-6 rounded-lg shadow-md">
        <thead>
        <tr>
            <th class="font-medium text-gray-700 px-4 py-2">Rank</th>
            <th class="font-medium text-gray-700 px-4 py-2">Player Name</th>
            <th class="font-medium text-gray-700 px-4 py-2">Total Score</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Connect to the database
        require_once 'inc/db.php';
        
        // 连接到数据库
        $conn = getDatabaseConnection();

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare('SELECT players.name, leaderboard.total_score FROM leaderboard INNER JOIN players ON leaderboard.player_id = players.id ORDER BY leaderboard.total_score DESC');
        $stmt->execute();

        // Initialize the rank counter
        $rank = 1;

        // Loop through the leaderboard entries and create a row for each one
        while ($row = $stmt->fetch()) {
            echo '<tr>';
            echo '<td class="text-gray-700 px-4 py-2">' . $rank . '</td>';
            echo '<td class="text-gray-700 px-4 py-2">' . $row['name'] . '</td>';
            echo '<td class="text-gray-700 px-4 py-2">' . $row['total_score'] . '</td>';
            echo '</tr>';

            // Increment the rank counter
            $rank++;
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
