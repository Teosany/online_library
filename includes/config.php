<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'library');

try {
    if (empty($_ENV["DB_HOST"])) {
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
    if (!empty($_ENV["DB_HOST"])) {
        $dbh = new PDO("mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);
    }
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}