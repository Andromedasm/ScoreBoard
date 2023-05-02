<?php
header('Content-Type: application/json');

$response = array();

if (isset($_POST['record_id']) && isset($_POST['new_score'])) {
    $recordId = intval($_POST['record_id']);
    $newScore = intval($_POST['new_score']);

    // 包含数据库连接文件
    require_once '../inc/db.php';

    // 连接到数据库
    $conn = getDatabaseConnection();

    // 更新分数
    $stmt = $conn->prepare("UPDATE game_records SET score = :new_score WHERE id = :record_id");
    $stmt->bindParam(':new_score', $newScore, PDO::PARAM_INT);
    $stmt->bindParam(':record_id', $recordId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    // 关闭数据库连接
    $conn = null;
} else {
    $response['status'] = "error";
}

echo json_encode($response);
