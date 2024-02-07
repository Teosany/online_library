<?php
// Configuration de la connexion
const DB_HOST = 'fra1.clusters.zeabur.com:31929';
const DB_USER = 'root';
//const DB_PASS = 'L7xbU0JPGQtW3VwCv5F9D842Yrnpe61q';
const DB_NAME = 'library';

try
{
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
	// Echec de la connexion
    exit("Error: " . $e->getMessage());
}