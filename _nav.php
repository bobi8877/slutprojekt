<nav>
    <a href="index.php">Home</a>
    <?php if(isLevel(10)): ?>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle">Solve</a>
        <div class="dropdown-menu">
            <a href="easyciphers.php">Easy ciphers</a>
            <a href="hardcipherselect.php">Difficult ciphers</a>
        </div>
    </div>
    <?php endif; ?>
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
    <?php if(isLevel(10)):?>
        <div class="logged-in-as">Logged in as: <?php echo htmlspecialchars($_SESSION['name']); ?></div>
    <?php endif; ?>
</nav>