<?php
session_start();
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "cipher";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
function isLevel($level) {
    if (isset($_SESSION['level'])) {
        return intval($_SESSION['level']) >= $level;
    }
    return false;
}
 
/**
 * Award points to a user.
 * For easy ciphers (no cipher_name) points are always awarded.
 * For medium/hard ciphers pass a unique $cipher_name to prevent
 * the same puzzle from being solved multiple times for points.
 *
 * Returns true if points were awarded, false otherwise.
 */
function awardPoints($conn, $userId, $points, $cipher_name = null) {
    $userId = intval($userId);
    $points = intval($points);
 
    if ($cipher_name !== null) {
        // Check if already solved
        $name = mysqli_real_escape_string($conn, $cipher_name);
        $check = mysqli_query($conn, "SELECT id FROM tbl_solved WHERE user_id = $userId AND cipher_name = '$name'");
        if (mysqli_num_rows($check) > 0) {
            return false; // Already solved, no points
        }
        // Mark as solved
        mysqli_query($conn, "INSERT INTO tbl_solved (user_id, cipher_name) VALUES ($userId, '$name')");
    }
 
    mysqli_query($conn, "UPDATE tbl_user SET points = points + $points WHERE id = $userId");
    return true;
}
 
/**
 * Check whether the logged-in user has already solved a named cipher.
 */
function hasSolved($conn, $userId, $cipher_name) {
    $userId = intval($userId);
    $name   = mysqli_real_escape_string($conn, $cipher_name);
    $result = mysqli_query($conn, "SELECT id FROM tbl_solved WHERE user_id = $userId AND cipher_name = '$name'");
    return mysqli_num_rows($result) > 0;
}

function isUserTaken($username){
    global $conn;
    $sql="SELECT username FROM tbl_user WHERE username='$username'";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        return true;
    }else{
        return false;
    }
}
?>