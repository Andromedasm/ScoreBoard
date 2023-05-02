<?php
// api/manual_scoring.php

// 包含数据库连接文件
require_once '../inc/db.php';

// 连接到数据库
$conn = getDatabaseConnection();

// 获取玩家列表
$playersQuery = "SELECT * FROM players";
$playersResult = $conn->query($playersQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerRanks = $_POST['player'];
    $multiplier = intval($_POST['multiplier']);
    $baseScores = [3, 1, -1, -3];

    $game_round_query = "SELECT MAX(game_round) AS max_round FROM game_records";
    $game_round_result = $conn->query($game_round_query);
    $game_round = $game_round_result->fetch(PDO::FETCH_ASSOC)['max_round'] + 1;

    foreach ($playerRanks as $player_id => $rank) {
        $score = $baseScores[$rank - 1] * $multiplier;
        $insert_query = "INSERT INTO game_records (player_id, game_round, game_time, score, multiplier) VALUES (?, ?, NOW(), ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->execute([$player_id, $game_round, $score, $multiplier]);
    }

    // 返回成功的响应
    http_response_code(200);
    echo json_encode(['message' => '成功添加游戏记录！']);
} else {
    // 返回错误的响应
    http_response_code(405);
    echo json_encode(['message' => '请求方法不允许。']);
}
