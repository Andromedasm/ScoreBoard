<?php
// 包含数据库连接文件
require_once 'inc/db.php';

// 连接到数据库
$conn = getDatabaseConnection();

// 查询用户累积名次数据
$query = "SELECT p.name,
                 SUM(CASE WHEN gr.score = 3 * gr.multiplier THEN 1 ELSE 0 END) AS rank_1_count,
                 SUM(CASE WHEN gr.score = 1 * gr.multiplier THEN 1 ELSE 0 END) AS rank_2_count,
                 SUM(CASE WHEN gr.score = -1 * gr.multiplier THEN 1 ELSE 0 END) AS rank_3_count,
                 SUM(CASE WHEN gr.score = -3 * gr.multiplier THEN 1 ELSE 0 END) AS rank_4_count,
                 SUM(CASE WHEN gr.score = 6 THEN 1 ELSE 0 END) AS rank_1_count_double,
                 SUM(CASE WHEN gr.score = 9 THEN 1 ELSE 0 END) AS rank_1_count_triple
          FROM game_records gr
          JOIN players p ON gr.player_id = p.id
          GROUP BY p.name
          ORDER BY rank_1_count DESC, rank_2_count DESC, rank_3_count DESC, rank_4_count DESC";
$result = $conn->query($query);

// 关闭数据库连接
$conn = null;
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>User Rankings</title>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">用户排名</h1>

    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">玩家</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">1名</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2名</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">3名</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">4名</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <?php
        // 循环显示用户累积名次数据

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $player_name = htmlspecialchars($row['name']);
            $rank_1_count = intval($row['rank_1_count']);
            $rank_2_count = intval($row['rank_2_count']);
            $rank_3_count = intval($row['rank_3_count']);
            $rank_4_count = intval($row['rank_4_count']);
            $rank_1_count_double = intval($row['rank_1_count_double']);
            $rank_1_count_triple = intval($row['rank_1_count_triple']);

            $rank_1_display = $rank_1_count;
            if ($rank_1_count_double > 0) {
                $rank_1_display .= " (地{$rank_1_count_double}次)";
            }
            if ($rank_1_count_triple > 0) {
                $rank_1_display .= " (天{$rank_1_count_triple}次)";
            }
            ?>

            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $player_name ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $rank_1_display ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $rank_2_count ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $rank_3_count ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $rank_4_count ?></td>
            </tr>

            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
