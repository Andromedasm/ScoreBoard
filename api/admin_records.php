<?php
// api/admin_records.php

// 包含数据库连接文件
require_once '../inc/db.php';

// 连接到数据库
$conn = getDatabaseConnection();

// 获取游戏历史记录
$query = "SELECT gr.id, p.name, gr.game_round, gr.game_time, gr.score FROM game_records gr JOIN players p ON gr.player_id = p.id ORDER BY gr.game_time DESC";
$result = $conn->query($query);

// 将游戏历史记录转换为关联数组
$records = $result->fetchAll(PDO::FETCH_ASSOC);

// 将关联数组转换为JSON格式并输出
echo json_encode($records);

// 关闭数据库连接
$conn = null;
?>
