document.addEventListener("DOMContentLoaded", () => {
    const allSelects = document.querySelectorAll("select[name^='player']");
    const initialOptions = allSelects[0].innerHTML;

    function updateSelectOptions() {
        // ...
    }

    function isUniqueSelection() {
        // ...
    }

    async function fetchPlayerList() {
        try {
            const response = await fetch("api/get_players.php");

            if (response.ok) {
                const players = await response.json();
                const playerList = document.getElementById("player-list");

                players.forEach((player) => {
                    const playerDiv = document.createElement("div");
                    playerDiv.classList.add("mb-4");

                    const playerLabel = document.createElement("label");
                    playerLabel.classList.add("block", "text-gray-700", "text-sm", "font-bold", "mb-2");
                    playerLabel.setAttribute("for", `player-${player.id}`);
                    playerLabel.textContent = player.name;

                    const playerSelect = document.createElement("select");
                    playerSelect.classList.add(
                        "shadow",
                        "appearance-none",
                        "border",
                        "rounded",
                        "w-full",
                        "py-2",
                        "px-3",
                        "text-gray-700",
                        "leading-tight",
                        "focus:outline-none",
                        "focus:shadow-outline"
                    );
                    playerSelect.id = `player-${player.id}`;
                    playerSelect.name = `player[${player.id}]`;
                    const ranks = ["🥇", "🥈", "🥉", "🤡"];
                    ranks.forEach((rank, index) => {
                        const rankOption = document.createElement("option");
                        rankOption.value = index + 1;
                        rankOption.textContent = rank;
                        playerSelect.appendChild(rankOption);
                    });

                    playerDiv.appendChild(playerLabel);
                    playerDiv.appendChild(playerSelect);
                    playerList.appendChild(playerDiv);
                });
            } else {
                console.error("Error fetching player list:", response.status, response.statusText);
            }
        } catch (error) {
            console.error("Error fetching player list:", error);
        }
    }

    allSelects.forEach((select) => {
        select.addEventListener("change", updateSelectOptions);
    });

    const scoreForm = document.getElementById("score-form");
    scoreForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        if (!isUniqueSelection()) {
            alert("错误：选择的名次不能重复，请重新选择。");
            return;
        }

        // 将表单数据转换为FormData对象
        const formData = new FormData(scoreForm);

        try {
            // 向后端发送异步请求
            const response = await fetch("api/manual_scoring.php", {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                alert("成功添加游戏记录！");
                scoreForm.reset();
            } else {
                alert("提交失败，请稍后重试。");
            }
        } catch (error) {
            console.error("Error submitting form:", error);
            alert("提交失败，请检查网络连接。");
        }
    });
    fetchPlayerList();
});
