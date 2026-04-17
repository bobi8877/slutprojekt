<nav>
    <a href="index.php">Home</a>
    <a href="solve.php">Solve</a>
    <a href="leaderboard.php">Leaderboard</a>
    <?php if(!isLevel(10)):?>
        <a href="login.php">Log in</a>
        <a href="register.php">Register</a>
    <?php else: ?>
        <a href="login.php?logout=1">Logout</a>
    <?php endif; ?>
    <div class="theme-toggle" id="themeToggle">
        <div>Theme:</div>
        <div class="theme-buttons">
            <button onclick="setTheme('light')" title="Ljust läge">☀️</button>
            <button onclick="setTheme('auto')" title="Automatiskt">⚙️</button>
            <button onclick="setTheme('dark')" title="Mörkt läge">🌙</button>
        </div>
    </div>
</nav>