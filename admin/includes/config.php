<?php
// Configuration de la connexion
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','root');
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
    if ($query === false) {
        $_SESSION['addAuthor'] = "Error: " . $dbh->error;
    } else {
        $_SESSION['addAuthor'] = 1;
    }
}

function verifSucces () {
    if (isset($_SESSION['addAuthor'])) {
        if ($_SESSION['addAuthor'] === 1) {
            $_SESSION['addAuthor'] = 2;
        } elseif ($_SESSION['addAuthor'] === 2) {
            echo('<script>succes();</script>');
            $_SESSION['addAuthor'] = '';
        } elseif ($_SESSION['addAuthor'] === '') {
            $_SESSION['addAuthor'] = '';
        } else {
            echo('<script>window.addEventListener("load", insucces);</script>');
            $_SESSION['addAuthor'] = '';
        }
    }
}


?>