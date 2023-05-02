<?php
// api/game_history.php
header("Content-Type: application/json");

// 包含数据库连接文件
require_once "../inc/db.php";

// 连接到数据库
$conn = getDatabaseConnection();

// 获取游戏历史记录
$query = "SELECT p.name, gr.game_round, gr.game_time, gr.score FROM game_records gr JOIN players p ON gr.player_id = p.id ORDER BY gr.game_time DESC";
$result = $conn->query($query);

// 将结果转换为数组
$gameHistory = $result->fetchAll(PDO::FETCH_ASSOC);

// 输出JSON格式的结果
echo json_encode($gameHistory);

// 关闭数据库连接
$conn = null;
?>
