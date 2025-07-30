document.getElementById('themeSelect').addEventListener('change', function() {
  document.getElementById('themeStylesheet').setAttribute('href', 'css/' + this.value);
  localStorage.setItem('selectedTheme', this.value); // persist choice
});

window.addEventListener('DOMContentLoaded', () => {
  const saved = localStorage.getItem('selectedTheme');
  if (saved) {
    document.getElementById('themeStylesheet').href = 'css/' + saved;
    document.getElementById('themeSelect').value = saved;
  }
});
