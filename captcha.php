<?php
ini_set("display_errors", "On"); error_reporting(E_ALL);
session_start();

$text = rand(10000,99999);

$_SESSION["vercode"] = $text;

$height = 25;
$width = 65;   
$image = imagecreate($width, $height);

$black = imagecolorallocate($image, 0, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255); 
$font_size = 14;

imagestring($image, $font_size, 5, 5, $text, $white);

imagejpeg($image, null, 80);