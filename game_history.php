<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>游戏历史记录</title>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">游戏历史记录</h1>

    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">玩家</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">游戏回合</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">游戏时间</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">得分</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <?php
        // 包含数据库连接文件
        require_once 'inc/db.php';

        // 连接到数据库
        $conn = getDatabaseConnection();

        // 获取游戏历史记录
        $query = "SELECT p.name, gr.game_round, gr.game_time, gr.score FROM game_records gr JOIN players p ON gr.player_id = p.id ORDER BY gr.game_time DESC";
        $result = $conn->query($query);

        // 循环显示游戏历史记录
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["game_round"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["game_time"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["score"]) . "</td>";
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
