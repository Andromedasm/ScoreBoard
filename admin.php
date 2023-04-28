<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Admin Panel</title>
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .modal.active {
            opacity: 1;
            pointer-events: all;
        }

        tbody tr:nth-child(odd) {
            background-color: rgba(229, 231, 235, 0.5); /* 这是一个浅灰色背景 */
        }

    </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">Admin Panel</h1>

    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-gray-200">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">玩家</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">游戏回合</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">游戏时间</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">得分</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <?php
        // 包含数据库连接文件
        require_once 'inc/db.php';

        // 连接到数据库
        $conn = getDatabaseConnection();

        // 获取游戏历史记录
        $query = "SELECT gr.id, p.name, gr.game_round, gr.game_time, gr.score FROM game_records gr JOIN players p ON gr.player_id = p.id ORDER BY gr.game_time DESC";
        $result = $conn->query($query);

        // 循环显示游戏历史记录
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["game_round"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["game_time"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\">" . htmlspecialchars($row["score"]) . "</td>";
            echo "<td class=\"px-6 py-4 whitespace-nowrap\"><button class=\"bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded edit-score\" data-id=\"" . htmlspecialchars($row["id"]) . "\">编辑</button></td>";
            echo "</tr>";
        }

        // 关闭数据库连接
        $conn = null;
        ?>
        </tbody>
    </table>
</div>
<div class="modal" id="edit-modal">
    <div class="bg-white p-8 rounded shadow-lg w-96">
        <h2 class="text-xl mb-4">编辑分数</h2>
        <form id="edit-score-form">
            <input type="hidden" id="record-id" name="record_id">
            <div class="mb-4">
                <label for="new-score" class="block mb-2">新分数:</label>
                <input type="number" id="new-score" name="new_score" class="border border-gray-300 w-full p-2">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">保存</button>
            <button type="button" id="cancel-edit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">取消</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        let recordId;
        $('.edit-score').click(function () {
            recordId = $(this).data('id');
            $('#record-id').val(recordId);
            $('#edit-modal').addClass('active');
        });

        $('#cancel-edit').click(function () {
            $('#edit-modal').removeClass('active');
        });

        $('#edit-score-form').submit(function (event) {
            event.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: 'inc/update_score.php',
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response === 'success') {
                        alert('分数已更新');
                        location.reload();
                    } else {
                        alert('更新失败，请稍后重试');
                    }
                }
            });
        });
    });

</script>
</body>
</html>