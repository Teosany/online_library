<?php

// On inclue le fichier de configuration et de connexion a la base de donnees
// On recupere dans $_GET l email soumis par l'utilisateur
// On verifie que l'email est un email valide (fonction php filter_var)
// Si ce n'est pas le cas, on fait un echo qui signale l'erreur
// Si c'est bon
// On prepare la requete qui recherche la presence de l'email dans la table tblreaders
// On execute la requete et on stocke le resultat de recherche
// Si le resultat n'est pas vide. On signale a l'utilisateur que cet email existe deja et on desactive le bouton
// de soumission du formulaire
// Sinon on signale a l'utlisateur que l'email est disponible et on active le bouton du formulaire

global $dbh;
require_once("includes/config.php");

if (isset($_GET)) {

    $email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL);

    if ($email != '') {
        $sql = "SELECT EmailId FROM tblreaders WHERE EmailId = :email";

        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $emailQuery = $query->fetch();

        if ($emailQuery != '') {
            echo '{"rep" : "Un compte avec cette adresse e-mail déjà existe!"}';
        } else {
            echo '{"rep" : ""}';
        }
    } else {
        echo '{"rep" : "Vous devez saisir votre adresse e-mail!"}';
        exit();
    }
} else {
    echo '{"rep" : "Error!"}';
}