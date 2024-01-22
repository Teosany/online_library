<?php
session_start(); 
$_SESSION = array();
session_destroy(); // destroy session
header("location:index.php"); 
?>

