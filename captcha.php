<?php 
// D�marrage ou r�cup�ration de la session
session_start();

// Un nombre al�atoire entre 10000 et 99999
$text = rand(10000,99999);

// On stocke ce nombre dans le tableau $_SESSION.
// Cette valeur sera � comparer avec la valeur saisie par l'utilisateur dans le formulaire de login ($_POST['vercode']
$_SESSION["vercode"] = $text;

// On cr�e un objet image
$height = 25; 
$width = 65;   
$image = imagecreate($width, $height);

// On associe les couleurs noire et blanche � cette image
$black = imagecolorallocate($image, 0, 0, 0); 
$white = imagecolorallocate($image, 255, 255, 255); 
$font_size = 14;

// On affiche le nombre al�atoire dans cette image en blanc sur fond noir
imagestring($image, $font_size, 5, 5, $text, $white);

// On cr�e une image jpeg � partir de l'objet image cr�� ci-dessus
imagejpeg($image, null, 80); 
?>