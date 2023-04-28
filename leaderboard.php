<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Leaderboard</title>
    <style>
        .ranking-1 {
            background-color: gold;
        }

        .ranking-2 {
            background-color: silver;
        }

        .ranking-3 {
            background-color: #cd7f32;
        }

        .ranking-1,
        .ranking-2,
        .ranking-3 {
            transition: all 0.3s ease;
        }

        .ranking-1:hover,
        .ranking-2:hover,
        .ranking-3:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .player-name {
            font-weight: bold;
            font-size: 1.2em;
            color: #4a5568; /* 更深的灰色 */
        }

        .player-score {
            font-style: italic;
            font-size: 1.1em;
            color: #718096; /* 浅灰色 */
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl mb-6">Leaderboard</h1>
    <?php require 'inc/leaderboard_functions.php'; ?>
    <div class="mb-4">
        <button id="toggle-button"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            切换排名
        </button>
    </div>

    <div id="total-leaderboard" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl mb-4">Total</h2>
        <?php displayLeaderboard($totalLeaderboardResult, 'total_score'); ?>
    </div>

    <div id="daily-leaderboard" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" style="display:none;">
        <h2 class="text-2xl mb-4">Daily</h2>
        <?php displayLeaderboard($dailyLeaderboardResult, 'daily_score'); ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#toggle-button').click(function () {
            $('#total-leaderboard, #daily-leaderboard').toggle();
        });
    });
</script>
</body>
</html>
