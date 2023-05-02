<?php
// api/leaderboard.php

require_once '../inc/db.php';

$conn = getDatabaseConnection();

$today = date("Y-m-d");

$totalLeaderboardQuery = "
        SELECT players.name, SUM(game_records.score) as total_score
        FROM game_records
        JOIN players ON game_records.player_id = players.id
        GROUP BY players.id
        ORDER BY total_score DESC
    ";

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

$total_leaderboard = $totalLeaderboardResult->fetchAll(PDO::FETCH_ASSOC);
$daily_leaderboard = $dailyLeaderboardResult->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'total_leaderboard' => $total_leaderboard,
    'daily_leaderboard' => $daily_leaderboard
];

echo json_encode($data);

$conn = null;
?>
