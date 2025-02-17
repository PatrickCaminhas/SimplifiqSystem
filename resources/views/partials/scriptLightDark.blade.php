<script>
    document.addEventListener("DOMContentLoaded", function () {
      const html = document.documentElement;
      const themeToggleButton = document.getElementById("toggle-theme");
      const themeIcon = document.getElementById("theme-icon");

      // Carregar o tema salvo no localStorage
      const savedTheme = localStorage.getItem("theme") || "light";
      html.setAttribute("data-bs-theme", savedTheme);
      updateIcon(savedTheme);

      themeToggleButton.addEventListener("click", function () {
        const currentTheme = html.getAttribute("data-bs-theme");
        const newTheme = currentTheme === "light" ? "dark" : "light";

        html.setAttribute("data-bs-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        updateIcon(newTheme);
      });

      function updateIcon(theme) {
        if (theme === "dark") {
          themeIcon.classList.replace("bi-moon-stars-fill", "bi-sun-fill");
        } else {
          themeIcon.classList.replace("bi-sun-fill", "bi-moon-stars-fill");
        }
      }
    });
  </script>
