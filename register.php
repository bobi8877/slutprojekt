<!DOCTYPE html>
<?php require_once ("asset.php"); ?>
<?php
if(isLevel(10)){ 
    header("Location: index.php");
}
if(isset($_POST['btn_reg'])){
    $username=$_POST['username'];
    $mail=$_POST['mail'];
    $password=md5($_POST['password']);
    $sql="INSERT INTO tbl_user(username, password, mail) VALUES ('$username', '$password', '$mail')";
    $result=mysqli_query($conn, $sql);
    header("Location: register.php?reg=RWFoYW1nayBjancgZm1penF2ayBuYXR2IHZnIGhrd2l3ZWwgYWduZGpvc2xid2MgdGEgbGp0dmh4cWplYnZ2IGpnc3Z0amF3IHZ3cG0gcWNscSBzZiB4dnJnZnd2IHl3Z2UuIFZ6amhjdnpxbWwgYXFobHFqcSwgbXB0cSBqc254IHB0ZHJ3diBsbXJtdHcgZWJ0eGxjanEgZm1oa2N5d2wsIHh0anVnZnR0IHJndGp3bHhkZmZ3ZnZtLCBwZmYga3dnYXhsa253IHdpaXMuIEhqZ2YgYXhlcmR3IGxjcWt2YWxuYnhncCB1YWlwdGp1IGxnIGZ3c3d0ZiB1a2dlbHF5anR4d2FlIHNkendnYXZ6ZWwsIGt4aGp3amwgeGFzYSBzIG5iYnBkIHRnZHggcWMgY2d3aGJ2diB1cWVlbnZ4dWNsYWh2IGVqa25zbW0gcGZmIGtzeW12bWNqdmJ2diBhcHhna3VwbGtnZiBidiBpemcgdmF6cWlzbiBzeXgu");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
    <script src="app.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'auto');
    </script>
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    <main>
        <?php if(isset($_GET['reg'])): ?>
        <div class="regdone">           
            <h1>Thank you for registering a user!</h1>
            <a href="index.php">Return to home</a>
        </div>
    <?php else: ?>    
    <form id="regform" action="register.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Preferred username" required >
        <label for="mail">Email</label>
        <input type="email" name="mail" id="mail" placeholder="Your email adress" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password (min 8 chars)" required  pattern=".{8,}">
        <input class="submit" type="submit" name="btn_reg" value="Create user">
    </form>
    <?php endif; ?>
    </main>
    
    <?php require_once "_footer.php"; ?>
</body>
</html>