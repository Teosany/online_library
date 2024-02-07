<?php
// Configuration de la connexion
define('DB_HOST','fra1.clusters.zeabur.com:31929');
define('DB_USER','root');
define('DB_PASS','L7xbU0JPGQtW3VwCv5F9D842Yrnpe61q');
define('DB_NAME','zeabur');

try
{
    // Connexion � la base
//    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
    $dbh = new PDO("mysql://root:L7xbU0JPGQtW3VwCv5F9D842Yrnpe61q@fra1.clusters.zeabur.com:31929/zeabur");
//    $dbh = $DATABASE_URL;
}
catch (PDOException $e)
{
	// Echec de la connexion
    exit("Error: " . $e->getMessage());
}
?>