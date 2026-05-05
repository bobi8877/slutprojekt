<!DOCTYPE html>
<?php
require_once("asset.php");
if (!isLevel(10)) {
    header("Location: index.php");
    exit;
}

define('SIGNOCC_ANSWER', 'goon'); 
define('SIGNOCC_NAME',   'significationes_occultae');
define('SIGNOCC_POINTS', 750);


$partialHints = [
];

$result  = '';
$hint    = '';
$already = hasSolved($conn, $_SESSION['id'], SIGNOCC_NAME);

if (isset($_POST['answer']) && !$already) {
    $userAnswer = strtolower(trim($_POST['answer']));

    if ($userAnswer === SIGNOCC_ANSWER) {
        awardPoints($conn, $_SESSION['id'], SIGNOCC_POINTS, SIGNOCC_NAME);
        $result = 'correct';
    } else {
        $result = 'wrong';

        foreach ($partialHints as $keyword => $hintText) {
            if (str_contains($userAnswer, $keyword)) {
                $hint = $hintText;
                break;
            }
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script src="app.js" defer></script>
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'auto');
    </script>
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    <main>
        <div class="hardciphercontent">
            <img class="strange-art" src="strangeart.png" alt="">
            <p>He did not write the message.</p>
            <?php if ($already || $result === 'correct'): ?>
                <p class="result-msg result-correct">You have already solved this cipher. Well done!</p>
            <?php else: ?>
                <form class="hardcipherform" method="POST">
                    <input type="text" name="answer" placeholder="Your answer here" required>
                    <input class="submit" type="submit" value="Submit">
                </form>
                <?php if ($result === 'wrong'): ?>
                    <p class="result-msg">Incorrect</p>
                    <?php if ($hint): ?>
                        <p class="cipher-hint"><?=htmlspecialchars($hint); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
    <?php require_once "_footer.php"; ?>
</body>
</html>