<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/tailwind.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Manual Scoring</title>
    <script>
        $(document).ready(function() {
            const allSelects = $("select[name^='player']");
            const initialOptions = allSelects.first().html();

            function updateSelectOptions() {
                const selectedValues = [];

                allSelects.each(function() {
                    if ($(this).val() !== '') {
                        selectedValues.push($(this).val());
                    }
                });

                allSelects.each(function() {
                    const currentSelect = $(this);
                    const currentValue = currentSelect.val();

                    currentSelect.html(initialOptions);
                    currentSelect.val(currentValue);

                    currentSelect.find('option').each(function() {
                        const option = $(this);
                        const optionValue = option.val();

                        if (selectedValues.indexOf(optionValue) >= 0 && optionValue !== currentValue) {
                            option.remove();
                        }
                    });
                });
            }

            function isUniqueSelection() {
                const selectedValues = [];
                let isUnique = true;

                allSelects.each(function() {
                    const currentValue = $(this).val();
                    if (selectedValues.indexOf(currentValue) >= 0) {
                        isUnique = false;
                    } else {
                        selectedValues.push(currentValue);
                    }
                });

                return isUnique;
            }

            allSelects.on('change', updateSelectOptions);

            $("#score-form").on("submit", function(event) {
                if (!isUniqueSelection()) {
                    event.preventDefault();
                    alert("错误：选择的名次不能重复，请重新选择。");
                }
            });
        });
    </script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">Manual Scoring</h1>

    <?php
    // 包含数据库连接文件
    require_once 'inc/db.php';

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

        echo "<p class='text-green-500'>成功添加游戏记录！</p>";
    }
    ?>

    <form id="score-form" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                积分倍数
            </label>
            <select
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="multiplier" name="multiplier">
                <option value="1">1 倍</option>
                <option value="2">2 倍</option>
                <option value="3">3 倍</option>
            </select>
        </div>

        <?php
        foreach ($playersResult as $player) {
            echo "<div class='mb-4'>";
            echo "<label class='block text-gray-700 text-sm font-bold mb-2' for='player-" . htmlspecialchars($player["id"]) . "'>";
            echo htmlspecialchars($player["name"]);
            echo "</label>";
            echo "<select class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' id='player-" . htmlspecialchars($player["id"]) . "' name='player[" . htmlspecialchars($player["id"]) . "]'>";
            echo "<option value='1'>🥇</option>";
            echo "<option value='2'>🥈</option>";
            echo "<option value='3'>🥉</option>";
            echo "<option value='4'>🤡</option>";
            echo "</select>";
            echo "</div>";
        }
        ?>
        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
               href="view_scores.php">
                Check Scores
            </a>
        </div>
    </form>
</div>
</body>
</html>