<?php 
require_once("asset.php");

if (!isLevel(10)) {
    header("Location: index.php");
    exit;
}

$wordList = ["apple","brave","cloud","dance","eagle","frost","grape",
             "honey","ivory","jolly","lemon","mango","night","ocean",
             "piano","quest","river","stone","tiger","ultra","vivid",
             "water","xenon","yacht","zebra", "magic", "light", "abide",
             "bloom", "crisp", "dwell", "ember", "feast", "glide", "harsh",
             "inlet", "joint", "karma", "latch", "medal", "nudge", "orbit",
             "shard", "bluff", "crown", "drift", "elbow", "fling", "groan",
             "hinge", "infer", "kneel", "lucid", "mercy", "novel", "porch",
             "squat", "pride", "sweep", "thorn", "blaze", "crane", "daisy",
             "evoke", "fable", "giant", "hiker", "amble", "resin", "brook",
             "charm", "gloss", "thugs", "sahur"];


function vigenereEncrypt($text, $key) {
    $key = strtolower(preg_replace('/[^a-z]/', '', $key));
    $kl = strlen($key);
    $ki = 0;
    return preg_replace_callback('/[a-z]/', function($m) use ($key, $kl, &$ki) {
        $c = ord($m[0]) - 97;
        $k = ord($key[$ki % $kl]) - 97;
        $ki++;
        return chr(($c + $k) % 26 + 97);
    }, strtolower($text));
}

function keyedCaesarEncrypt($text, $key, $shift = 5) {
    $key = strtolower(preg_replace('/[^a-z]/', '', $key));
    $alphabet = [];
    foreach (str_split($key) as $char) {
        if (!in_array($char, $alphabet)) $alphabet[] = $char;
    }
    for ($i = 97; $i <= 122; $i++) {
        if (!in_array(chr($i), $alphabet)) $alphabet[] = chr($i);
    }
    $alphabetStr = implode('', $alphabet);

    return preg_replace_callback('/[a-z]/', function($m) use ($alphabetStr, $shift) {
        $pos = strpos($alphabetStr, $m[0]);
        $newPos = ($pos + $shift) % 26;
        return $alphabetStr[$newPos];
    }, strtolower($text));
}

function beaufortEncrypt($text, $key) {
    $key = strtolower(preg_replace('/[^a-z]/', '', $key));
    $kl = strlen($key);
    $ki = 0;
    return preg_replace_callback('/[a-z]/', function($m) use ($key, $kl, &$ki) {
        $p = ord($m[0]) - 97;
        $k = ord($key[$ki % $kl]) - 97;
        $ki++;
        return chr(($k - $p + 26) % 26 + 97);
    }, strtolower($text));
}

function autokeyEncrypt($text, $key) {
    $key = strtolower(preg_replace('/[^a-z]/', '', $key));
    $plainLetters = strtolower(preg_replace('/[^a-z]/', '', $text));
    $fullKey = $key . $plainLetters; 
    
    $ki = 0;
    return preg_replace_callback('/[a-z]/', function($m) use ($fullKey, &$ki) {
        $p = ord($m[0]) - 97;
        $k = ord($fullKey[$ki]) - 97;
        $ki++;
        return chr(($p + $k) % 26 + 97);
    }, strtolower($text));
}


if (!isset($_SESSION['medium_cipher']) || isset($_GET['new'])) {
    shuffle($wordList);
    $words  = array_slice($wordList, 0, 5);
    $phrase = implode(' ', $words);

    $keys = ['enigma', 'shadow', 'crypto', 'matrix', 'vector', 'bypass', 'phantom', 'secure'];
    $key  = $keys[array_rand($keys)];

    $types = ['vigenere', 'keyedcaesar', 'beaufort', 'autokey'];
    $type  = $types[array_rand($types)];

    switch ($type) {
        case 'vigenere':
            $encrypted = vigenereEncrypt($phrase, $key);
            $cipherName = "Vigenère Cipher";
            break;
        case 'keyedcaesar':
            $shift = rand(3, 7);
            $encrypted = keyedCaesarEncrypt($phrase, $key, $shift);
            $cipherName = "Keyed Caesar Cipher (Shift: $shift)";
            break;
        case 'beaufort':
            $encrypted = beaufortEncrypt($phrase, $key);
            $cipherName = "Beaufort Cipher";
            break;
        case 'autokey':
            $encrypted = autokeyEncrypt($phrase, $key);
            $cipherName = "Autokey Cipher";
            break;
    }

    $hidingMethods = ['url', 'comment', 'data_attr', 'css_var'];
    $method = $hidingMethods[array_rand($hidingMethods)];

    $_SESSION['medium_cipher'] = [
        'answer'        => $phrase,
        'encrypted'     => $encrypted,
        'name'          => $cipherName,
        'key'           => $key,
        'method'        => $method,
        'hint'          => "The key is hidden somewhere on this page's landscape or URL parameters. Inspect everything!",
        'hint_revealed' => false
    ];

    if ($method === 'url') {
        header("Location: mediumciphers.php?debug_token=" . $key);
    } else {
        header("Location: mediumciphers.php");
    }
    exit;
}

if ($_SESSION['medium_cipher']['method'] === 'url' && !isset($_GET['debug_token'])) {
    header("Location: mediumciphers.php?debug_token=" . $_SESSION['medium_cipher']['key']);
    exit;
}


$result = '';
if (isset($_POST['answer'])) {
    $userAnswer    = str_replace(' ', '', strtolower(trim($_POST['answer'])));
    $correctAnswer = str_replace(' ', '', $_SESSION['medium_cipher']['answer']);

    if ($userAnswer === $correctAnswer) {
        if (!$_SESSION['medium_cipher']['hint_revealed']) {
            awardPoints($conn, $_SESSION['id'], 25);
            $_SESSION['flash'] = 'correct';
        } else {
            $_SESSION['flash'] = 'correct_no_point';
        }
        unset($_SESSION['medium_cipher']);
        header('Location: mediumciphers.php');
        exit;
    } else {
        $result = 'wrong';
    }
}

if (isset($_SESSION['flash'])) {
    $result = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

if (isset($_POST['hint'])) {
    $_SESSION['medium_cipher']['hint_revealed'] = true;
}

$c = $_SESSION['medium_cipher'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medium Cipher Challenge</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'auto');
    </script>
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    
    <main <?php if($c['method'] === 'css_var') echo 'style="--system-key: \'' . htmlspecialchars($c['key']) . '\';"'; ?>>
    <div class="row">
        <div class="infobox">
            <h2>Medium Cipher</h2>
            <p>Unlike easy ciphers, these require an encryption <strong>Key</strong> to be solved. The key has been randomly obfuscated somewhere inside this page architecture.</p>
            <p class="points">+25 pt</p>
        </div>
        
        <div class="cipherbox" <?php if($c['method'] === 'data_attr') echo 'data-encryption-key="' . htmlspecialchars($c['key']) . '"'; ?>>
            
            <?php if($c['method'] === 'comment'): ?>
                <?php endif; ?>

            <p class="cipher-text"><?php echo htmlspecialchars($c['encrypted']); ?></p>
            <form method="POST">
                <input type="text" name="answer" placeholder="Your decrypted answer words..." required>
                <input class="submit" type="submit" value="Submit">
            </form>
            <p class="result-msg"><?php
                if ($result === 'correct')              echo 'Correct! +25 points awarded.';
                elseif ($result === 'correct_no_point') echo 'Correct! (No points awarded because the hint was used.)';
                elseif ($result === 'wrong')            echo 'Try again';
            ?></p>
            <a href="mediumciphers.php?new=1">New cipher</a>
        </div>
        <div class="hintbox">
            <h2>Hint &lpar;No points will be awarded&rpar;</h2>
            <?php if ($c['hint_revealed']): ?>
                <p><?= htmlspecialchars($c['hint']); ?></p>
                <p style="margin-top:10px;"><strong>Cipher Strategy:</strong> This was encrypted using <em><?= htmlspecialchars($c['name']) ?></em></p>
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