document.addEventListener("DOMContentLoaded", function () {
  const themeSelect = document.getElementById("themeSelect");
  const themeLink = document.getElementById("themeStylesheet");

  // Adjust path since this script runs in HTML/products/
  const cssBasePath = "../css/";

  // Load saved theme from localStorage
  const savedTheme = localStorage.getItem("selectedTheme");
  if (savedTheme) {
    themeLink.href = cssBasePath + savedTheme;
    if (themeSelect) themeSelect.value = savedTheme;
  }

  // Update theme on selection change
  if (themeSelect) {
    themeSelect.addEventListener("change", function () {
      const selectedTheme = themeSelect.value;
      themeLink.href = cssBasePath + selectedTheme;
      localStorage.setItem("selectedTheme", selectedTheme);
    });
  }
});
