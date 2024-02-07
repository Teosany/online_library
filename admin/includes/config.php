<?php
define('DB_HOST','fra1.clusters.zeabur.com:31929');
define('DB_USER','root');
define('DB_PASS','L7xbU0JPGQtW3VwCv5F9D842Yrnpe61q');
define('DB_NAME','library');

try
{
    // Connexion � la base
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
    // Echec de la connexion
    exit("Error: " . $e->getMessage());
}

function succesOrNot () {
    global $query;
    global $dbh;
    global $success;

    if ($query === false) {
        $_SESSION['successOrNot'] = "Error: " . $dbh->error;
    } else {
        $_SESSION['successOrNot'] = 1;
    }
}

function verifSucces () {
    if (isset($_SESSION['successOrNot'])) {
        if ($_SESSION['successOrNot'] === 1) {
            $_SESSION['successOrNot'] = 2;
        } elseif ($_SESSION['successOrNot'] === 2) {
            echo('<script>succes();</script>');
            $_SESSION['successOrNot'] = '';
        } elseif ($_SESSION['successOrNot'] === '') {
            $_SESSION['successOrNot'] = '';
        } else {
            echo('<script>window.addEventListener("load", insucces);</script>');
            $_SESSION['successOrNot'] = '';
        }
    }
}