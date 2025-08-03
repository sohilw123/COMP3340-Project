document.addEventListener("DOMContentLoaded", function () {
  const themeSelect = document.getElementById("themeSelect");
  const themeLink = document.getElementById("themeStylesheet");

  // Load saved theme from localStorage
  const savedTheme = localStorage.getItem("selectedTheme");
  if (savedTheme) {
    themeLink.href = "css/" + savedTheme;
    if (themeSelect) themeSelect.value = savedTheme;
  }

  // Update theme on selection change
  if (themeSelect) {
    themeSelect.addEventListener("change", function () {
      const selectedTheme = themeSelect.value;
      themeLink.href = "css/" + selectedTheme;
      localStorage.setItem("selectedTheme", selectedTheme);
    });
  }
});
