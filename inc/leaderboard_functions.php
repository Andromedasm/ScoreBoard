<?php
// 包含数据库连接文件
require_once 'inc/db.php';

// 连接到数据库
$conn = getDatabaseConnection();

// 今天的日期
$today = date("Y-m-d");

// 总排名查询
$totalLeaderboardQuery = "
        SELECT players.name, SUM(game_records.score) as total_score
        FROM game_records
        JOIN players ON game_records.player_id = players.id
        GROUP BY players.id
        ORDER BY total_score DESC
    ";

// 每日排名查询
$dailyLeaderboardQuery = "
        SELECT players.name, SUM(game_records.score) as daily_score
        FROM game_records
        JOIN players ON game_records.player_id = players.id
        WHERE DATE(game_records.game_time) = '$today'
        GROUP BY players.id
        ORDER BY daily_score DESC
    ";

$totalLeaderboardResult = $conn->query($totalLeaderboardQuery);
$dailyLeaderboardResult = $conn->query($dailyLeaderboardQuery);

function displayLeaderboard($result, $scoreColumnName) {
    if ($result->rowCount() > 0) {
        echo "<table class='table-auto w-full'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='px-4 py-2 text-xl font-bold'>Rank</th>";
        echo "<th class='px-4 py-2 text-xl font-bold'>Player</th>";
        echo "<th class='px-4 py-2 text-xl font-bold'>Score</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $rank = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rankingClass = "";
            if ($rank === 1) {
                $rankingClass = "ranking-1";
            } elseif ($rank === 2) {
                $rankingClass = "ranking-2";
            } elseif ($rank === 3) {
                $rankingClass = "ranking-3";
            }

            echo "<tr class='$rankingClass'>";
            echo "<td class='border px-4 py-2 text-lg font-semibold'>" . $rank . "</td>";
            echo "<td class='border px-4 py-2 text-lg'>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td class='border px-4 py-2 text-lg'>" . $row[$scoreColumnName] . "</td>";
            echo "</tr>";

            $rank++;
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>暂无数据</p>";
    }
}

?>
