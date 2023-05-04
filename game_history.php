<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>Game History</title>
    <style>
        tbody tr:nth-child(odd) {
            background-color: rgba(229, 231, 235, 0.5); /* 这是一个浅灰色背景 */
        }
        .name {
            font-weight: bold;
            font-size: 1.2em;
        }

        .round {
            font-style: italic;
            font-size: 1.1em;
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">Game History</h1>

    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Round</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datetime</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <?php
        // 包含数据库连接文件
        require_once 'inc/db.php';

        // 连接到数据库
        $conn = getDatabaseConnection();

        // 获取游戏历史记录
        $query = "SELECT p.name, gr.game_round, gr.game_time, gr.score, gr.multiplier FROM game_records gr JOIN players p ON gr.player_id = p.id ORDER BY gr.game_time DESC";
        $result = $conn->query($query);

        // 循环显示游戏历史记录
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap name\">" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap round\">" . htmlspecialchars($row["game_round"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["game_time"]) . "</td>";

            // 计算名次
            $score = intval($row["score"]);
            $multiplier = intval($row["multiplier"]);
            $rank = 0;

            if ($score == 3 * $multiplier) {
                $rank = 1;
            } elseif ($score == 1 * $multiplier) {
                $rank = 2;
            } elseif ($score == -1 * $multiplier) {
                $rank = 3;
            } else {
                $rank = 4;
            }

            // 根据名次显示相应的图标
            if ($rank == 1) {
                echo "<td class=\"px-6 py-4 whitespace-nowrap\">🥇</td>";
            } elseif ($rank == 2) {
                echo "<td class=\"px-6 py-4 whitespace-nowrap\">🥈</td>";
            } elseif ($rank == 3) {
                echo "<td class=\"px-6 py-4 whitespace-nowrap\">🥉</td>";
            } else {
                echo "<td class=\"px-6 py-4 whitespace-nowrap\">🤡</td>";
            }

            echo "</tr>";
        }

        // 关闭数据库连接
        $conn = null;
        ?>
        </tbody>
    </table>
</div>
</body>
</html>