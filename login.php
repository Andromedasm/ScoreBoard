<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>玩家登录</title>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">玩家登录</h1>

    <?php
    // 包含数据库连接文件
    require_once 'inc/db.php';

    // 连接到数据库
    $conn = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $player_name = $_POST['player_name'];

        $query = "SELECT * FROM players WHERE name = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$player_name]);

        if ($stmt->rowCount() === 1) {
            session_start();
            $_SESSION['player_id'] = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
            header("Location: manual_scoring.php");
            exit;
        } else {
            echo "<p class='text-red-500'>玩家名不存在！</p>";
        }
    }
    ?>

    <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="player_name">
                玩家名
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="player_name" name="player_name" type="text" placeholder="请输入玩家名">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                登录
            </button>
        </div>
    </form>
</div>
</body>
</html>
