<?php require_once("asset.php");

$wordList = ["apple","brave","cloud","dance","eagle","frost","grape",
             "honey","ivory","jolly","lemon","mango","night","ocean",
             "piano","quest","river","stone","tiger","ultra","vivid",
             "water","xenon","yacht","zebra"];

function caesarEncrypt($text, $shift) {
    return preg_replace_callback('/[a-z]/', function($m) use ($shift) {
        return chr((ord($m[0]) - 97 + $shift) % 26 + 97);
    }, $text);
}
function atbash($text) {
    return preg_replace_callback('/[a-z]/', function($m) {
        return chr(122 - (ord($m[0]) - 97));
    }, $text);
}
function reverseWords($text) {
    return implode(' ', array_map('strrev', explode(' ', $text)));
}
function railFence($text, $rails = 3) {
    $fence = array_fill(0, $rails, []);
    $rail = 0; $dir = 1;
    foreach (str_split($text) as $c) {
        $fence[$rail][] = $c;
        if ($rail === 0) $dir = 1;
        if ($rail === $rails - 1) $dir = -1;
        $rail += $dir;
    }
    return implode('', array_merge(...$fence));
}

// Generate new cipher if requested or none exists
if (!isset($_SESSION['cipher']) || isset($_GET['new'])) {
    shuffle($wordList);
    $words = array_slice($wordList, 0, 5);
    $phrase = implode(' ', $words);

    $ciphers = ['caesar', 'atbash', 'reverse', 'railfence'];
    $type = $ciphers[array_rand($ciphers)];

    switch ($type) {
        case 'caesar':
            $shift = rand(1, 25);
            $encrypted = caesarEncrypt($phrase, $shift);
            $name = "Caesar Cipher";
            $desc = "Each letter is shifted forward in the alphabet by a fixed amount.";
            $hint = "Shift: $shift";
            break;
        case 'atbash':
            $encrypted = atbash($phrase);
            $name = "Atbash Cipher";
            $desc = "Each letter is mapped to its reverse (A↔Z, B↔Y...).";
            $hint = "The alphabet is reversed — A becomes Z, B becomes Y, etc.";
            break;
        case 'reverse':
            $encrypted = reverseWords($phrase);
            $name = "Reversed Words";
            $desc = "Each word is spelled backwards.";
            $hint = "Try reading each word backwards.";
            break;
        case 'railfence':
            $encrypted = railFence(str_replace(' ', '', $phrase));
            $name = "Rail Fence Cipher";
            $desc = "Letters are written in a zigzag across 3 rails then read off row by row.";
            $hint = "Write letters in a zigzag over 3 rows, then read across each row.";
            break;
    }

    $_SESSION['cipher'] = [
        'answer' => $phrase,
        'encrypted' => $encrypted,
        'name' => $name,
        'desc' => $desc,
        'hint' => $hint,
        'hint_revealed' => false
    ];
}

// Check answer
$result = '';
if (isset($_POST['answer'])) {
    if (strtolower(trim($_POST['answer'])) === $_SESSION['cipher']['answer']) {
        $result = 'correct';
        // TODO: award point to user here
    } else {
        $result = 'wrong';
    }
}

// Reveal hint
if (isset($_POST['hint'])) {
    $_SESSION['cipher']['hint_revealed'] = true;
}

$c = $_SESSION['cipher'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Ciphers</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'auto');
    </script>
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    <main>
    <div class="row">
        <div class="infobox">
            <h2>Cipher Challenge</h2>
            <p>A five-word phrase has been encrypted. Decrypt it to earn a point.</p>
            <p class="points">+1 pt</p>
        </div>
        </div>
        <div class="cipherbox">
            <h2>Decrypt this:</h2>
            <p class="cipher-text"><?php echo htmlspecialchars($c['encrypted']); ?></p>
            <form method="POST">
                <input type="text" name="answer" placeholder="Your answer..." required>
                <input class="submit" type="submit" value="Submit">
            </form>
            <?php if ($result === 'correct'): ?>
                <p>✅ Correct!</p>
            <?php elseif ($result === 'wrong'): ?>
                <p>❌ Try again</p>
            <?php endif; ?>
            <a href="easyciphers.php?new=1">New cipher</a>
        </div>
        <div class="hintbox">
            <h2>Hint</h2>
            <?php if ($c['hint_revealed']): ?>
                <p><?php echo htmlspecialchars($c['hint']); ?></p>
            <?php else: ?>
                <form method="POST">
                    <button type="submit" name="hint">Reveal hint</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    </main>
    <?php require_once "_footer.php"; ?>
</body>
</html>