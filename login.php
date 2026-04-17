<!DOCTYPE html>
<?php require_once("asset.php");?>
<?php
if(isLevel(10)){ 
    header("Location: index.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="app.js" defer></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    <main>
        <form id="loginform" method="POST">
            <label for="user">Username</label>
            <input type="text" name="user" placeholder="Username" required>
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="Password" required>
            <input class="submit" type="submit" name="btn_login" value="Log in">
        </form>
        <?php
        if(isset($_POST['btn_login'])){
            $user=$_POST['user'];
            $pass=md5($_POST['pass']);
            $sql="SELECT * FROM tbl_user WHERE ((username='$user') AND (password='$pass'))";
            $result=mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)===1){
                $row=mysqli_fetch_assoc($result);
                $_SESSION['mess']="Login successful!";
                $_SESSION['level']=$row['userlevel'];
                $_SESSION['id']=$row['id'];
            }else{
                $_SESSION['mess']="Login failed! Wrong username or password.";

            }
            header("Location: index.php");
        }
        if(isset($_GET['logout'])){
            $_SESSION['name']="";
            $_SESSION['level']="";
            $_SESSION['id']="";
            header("Location: index.php");
        }
        ?>
    </main>
</body>
</html>