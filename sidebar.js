// sidebar.js
document.addEventListener("DOMContentLoaded", () => {
    const sidebarCheck = document.querySelector(".sidebar-check");
    const sidebarLabel = document.querySelector(".sidebar-label");

    sidebarLabel.addEventListener("click", () => {
        if (sidebarCheck.checked) {
            document.body.classList.add("sidebar-open");
        } else {
            document.body.classList.remove("sidebar-open");
        }
    });
});
