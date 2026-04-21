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

const dropdownToggle = document.querySelector('.dropdown-toggle');
if (dropdownToggle) {
    dropdownToggle.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('.dropdown-menu').classList.toggle('open');
    });
}

document.addEventListener('click', function (e) {
  if (!e.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown-menu').forEach(function (menu) {
      menu.classList.remove('open');
    });
  }
});

initTheme();
