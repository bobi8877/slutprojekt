<!DOCTYPE html>
<?php require_once("asset.php"); ?>
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
    <div class="row">
        <div class="about">
            <h1>About The Site</h1> <br>
            <div>
                This website is a challenge site meant to challenge yourself and improve your skills in solving ciphers. You need an account to start solving ciphers, create one by pressing the register button. 
                <br><br>There are three different difficulties of ciphers to solve, easy, medium, and hard. The easy ciphers are automatically generated with javascript, they are always five words long. The medium ciphers are usually longer and are all handmade, these should take more time. The most difficult ciphers usually have more than one layer of encryption and aren't as easy to bruteforce. Expect these to take many hours.
                <br><br>You can see where you stand compared to other people by checking the leaderboards. Solving ciphers gives you points on the leaderboard. The easy ciphers give you 1 point, the medium ciphers give you 25 points and the hard ciphers give you 750 points, therefore, it is worth it to spend the time on the more difficult ciphers if you have enought experience.
            </div>
        </div>
        <div class="learn">
            <h1>Learn to solve</h1> <br>
            <div>
                There are hundreds, if not thousands of different ways to encrypt a message, so it can be very daunting to get into it. To get started try reading about <a href="https://en.wikipedia.org/wiki/Cryptography">Cryptography in general</a>, and also some of the most common classic ways of encrypting messages, such as <a href="https://en.wikipedia.org/wiki/Vigen%C3%A8re_cipher">vigenére ciphers</a> or <a href="https://en.wikipedia.org/wiki/Caesar_cipher">caesar shift</a>. There are of course many more but there are good places to start.
                <br><br> Once you have a basic understanding you should be aware of some great online tools for encryption and decryption, such as <a href="https://gchq.github.io/CyberChef/">CyberChef</a> and <a href="https://cryptii.com/">Cryptii</a>. AI chatbots are also great at the start, don't be afraid to use them if you need help.
            </div>
        </div>
    </div> 
    </main>
    <?php require_once "_footer.php"; ?>
</body>
</html>