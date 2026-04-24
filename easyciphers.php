<?php require_once("asset.php");
if(!isLevel(5)){ 
    header("Location: index.php");
}
 
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
 
    $ciphers = ['caesar', 'atbash', 'railfence'];
    $type = $ciphers[array_rand($ciphers)];
 
    switch ($type) {
        case 'caesar':
            $shift = rand(1, 25);
            $encrypted = caesarEncrypt($phrase, $shift);
            $name = "Caesar Cipher";
            $hint = "Shift: $shift";
            break;
        case 'atbash':
            $encrypted = atbash($phrase);
            $name = "Atbash Cipher";
            $hint = "The alphabet is reversed — A becomes Z, B becomes Y, etc.";
            break;
        case 'railfence':
            $encrypted = railFence(str_replace(' ', '', $phrase));
            $name = "Rail Fence Cipher";
            $hint = "Write letters in a zigzag over 3 rows, then read across each row.";
            break;
    }
 
    $_SESSION['cipher'] = [
        'answer' => $phrase,
        'encrypted' => $encrypted,
        'name' => $name,
        'hint' => $hint,
        'hint_revealed' => false
    ];
 
    // Redirect to strip ?new from the URL so subsequent form POSTs
    // don't re-trigger cipher generation.
    header("Location: easyciphers.php");
    exit;
}
 
// Check answer
$result = '';
if (isset($_POST['answer'])) {
    // Normalize both sides: lowercase, trim, strip internal spaces.
    // This handles Rail Fence (encrypted without spaces) and Caesar/Atbash equally.
    $userAnswer    = str_replace(' ', '', strtolower(trim($_POST['answer'])));
    $correctAnswer = str_replace(' ', '', $_SESSION['cipher']['answer']);
    if ($userAnswer === $correctAnswer) {
        if (!$_SESSION['cipher']['hint_revealed']) {
            // TODO: award point to user here
            $_SESSION['flash'] = 'correct';
        } else {
            $_SESSION['flash'] = 'correct_no_point';
        }
        unset($_SESSION['cipher']); // Clear so a fresh cipher is generated on next load
        header('Location: easyciphers.php');
        exit;
    } else {
        $result = 'wrong';
    }
}
 
// Pick up flash message set by a correct answer redirect
if (isset($_SESSION['flash'])) {
    $result = $_SESSION['flash'];
    unset($_SESSION['flash']);
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
            <p>A set of five random words have been encrypted with a simple method of encryption. The words most likely aren't a coherent sentence.</p>
            <p class="points">+1 pt</p>
        </div>
        <div class="cipherbox">
            <p class="cipher-text"><?php echo htmlspecialchars($c['encrypted']); ?></p>
            <form method="POST">
                <input type="text" name="answer" placeholder="Your answer..." required>
                <input class="submit" type="submit" value="Submit">
            </form>
            <p class="result-msg"><?php
                if ($result === 'correct') echo 'Correct! +1 point awarded.';
                elseif ($result === 'correct_no_point') echo 'Correct! (No point awarded — hint was used.)';
                elseif ($result === 'wrong') echo 'Try again';
            ?></p>
            <a href="easyciphers.php?new=1">New cipher</a>
        </div>
        <div class="hintbox">
            <h2>Hint &lpar;No points will be awarded for the solve&rpar;</h2>
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