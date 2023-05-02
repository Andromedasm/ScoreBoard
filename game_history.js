// game_history.js
document.addEventListener("DOMContentLoaded", () => {
    const gameHistoryTable = document.getElementById("gameHistoryTable");

    // 向后端请求游戏历史记录数据
    fetch("api/game_history.php")
        .then((response) => response.json())
        .then((data) => {
            // 循环显示游戏历史记录
            data.forEach((row) => {
                const tr = document.createElement("tr");

                const nameTd = document.createElement("td");
                nameTd.classList.add("px-6", "py-4", "whitespace-nowrap", "name");
                nameTd.textContent = row.name;
                tr.appendChild(nameTd);

                const roundTd = document.createElement("td");
                roundTd.classList.add("px-6", "py-4", "whitespace-nowrap", "round");
                roundTd.textContent = row.game_round;
                tr.appendChild(roundTd);

                const gameTimeTd = document.createElement("td");
                gameTimeTd.classList.add("px-6", "py-4", "whitespace-nowrap");
                gameTimeTd.textContent = row.game_time;
                tr.appendChild(gameTimeTd);

                const scoreTd = document.createElement("td");
                scoreTd.classList.add("px-6", "py-4", "whitespace-nowrap");

                // 根据分数显示相应的图标
                const score = row.score;
                if (score >= 3) {
                    scoreTd.textContent = "🥇";
                } else if (score == 2) {
                    scoreTd.textContent = "🥈";
                } else if (score == 1) {
                    scoreTd.textContent = "🥉";
                } else {
                    scoreTd.textContent = "🤡";
                }
                tr.appendChild(scoreTd);

                gameHistoryTable.appendChild(tr);
            });
        })
        .catch((error) => console.error("Error fetching game history data:", error));
});

