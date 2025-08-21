document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".wishlist-btn");
    const statusBox = document.getElementById("status");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const projectCard = this.closest(".project-card");
            const projectId = projectCard.getAttribute("data-id");

            fetch("student_dashboard.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `ajax=1&project_id=${projectId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "added") {
                    button.textContent = "Remove from Wishlist";
                    button.classList.add("added");
                    showStatus("✅ Added to wishlist!", "success");
                } else if (data.status === "removed") {
                    button.textContent = "Add to Wishlist";
                    button.classList.remove("added");
                    showStatus("❌ Removed from wishlist.", "error");
                }
            })
            .catch(() => {
                showStatus("⚠️ Error. Try again.", "error");
            });
        });
    });

    function showStatus(message, type) {
        statusBox.textContent = message;
        statusBox.className = "status-msg " + type;
        setTimeout(() => statusBox.textContent = "", 3000);
    }
});
