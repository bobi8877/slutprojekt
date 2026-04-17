<?php
session_start();
$db_host="localhost";
$db_user="root";
$db_pass="";
$db_name="cipher";
$conn=mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function isLevel($level){
    if(isset($_SESSION['level'])){
        if(intval($_SESSION['level'])>=$level){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
?>