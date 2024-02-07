<?php
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'root';
const DB_NAME = 'library';

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