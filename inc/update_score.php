<?php

if (isset($_POST['record_id']) && isset($_POST['new_score'])) {
    $recordId = intval($_POST['record_id']);
    $newScore = intval($_POST['new_score']);

    // 包含数据库连接文件
    require_once 'db.php';

    // 连接到数据库
    $conn = getDatabaseConnection();

    // 更新分数
    $stmt = $conn->prepare("UPDATE game_records SET score = :new_score WHERE id = :record_id");
    $stmt->bindParam(':new_score', $newScore, PDO::PARAM_INT);
    $stmt->bindParam(':record_id', $recordId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    // 关闭数据库连接
    $conn = null;
} else {
    echo "error";
}
