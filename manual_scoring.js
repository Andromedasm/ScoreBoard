document.addEventListener("DOMContentLoaded", () => {
    const allSelects = document.querySelectorAll("select[name^='player']");
    const initialOptions = allSelects[0].innerHTML;

    function updateSelectOptions() {
        // ...
    }

    function isUniqueSelection() {
        // ...
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
});
