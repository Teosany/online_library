<?php
// Configuration de la connexion
//define('DB_HOST','localhost');
//define('DB_USER','root');
//define('DB_PASS','root');
//define('DB_NAME','library');

try
{
    // Connexion � la base
//    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
    $dbh = new PDO("mysql:host=fra1.clusters.zeabur.com;dbname=zeabur",'root', 'L7xbU0JPGQtW3VwCv5F9D842Yrnpe61q');
//    $dbh = new PDO("mysql://root:L7xbU0JPGQtW3VwCv5F9D842Yrnpe61q@fra1.clusters.zeabur.com:31929/zeabur");
//    $dbh = $DATABASE_URL;
}
catch (PDOException $e)
{
	// Echec de la connexion
    exit("Error: " . $e->getMessage());
}
?>