function setTheme(t) {
  document.documentElement.setAttribute('data-theme', t);
  localStorage.setItem('theme', t);
  document.querySelectorAll('#themeToggle button').forEach((btn, i) => {
    btn.classList.toggle('active', ['light', 'auto', 'dark'][i] === t);
  });
}
function initTheme() {
  const saved = localStorage.getItem('theme') || 'auto';
  setTheme(saved);
}

initTheme();