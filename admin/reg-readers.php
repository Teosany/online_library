<?php
// On démarre ou on récupère la session courante
session_start();

// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

// Si l'utilisateur n'est logué ($_SESSION['alogin'] est vide)
// On le redirige vers la page d'accueil
// Sinon on affiche la liste des lecteurs de la table tblreaders

// Lors d'un click sur un bouton "inactif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['inid']
// et on met à jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "actif", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['id']
// et on met à jour le statut (1) dans  table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "supprimer", on récupère la valeur de l'identifiant
// du lecteur dans le tableau $_GET['del']
// et on met à jour le statut (2) dans la table tblreaders pour cet identifiant de lecteur

// On récupère tous les lecteurs dans la base de données
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Reg lecteurs</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!--On inclue ici le menu de navigation includes/header.php-->
    <?php include('includes/header.php'); ?>
    <!-- Titre de la page (Gestion du Registre des lecteurs) -->

    <!--On insère ici le tableau des lecteurs.
       On gère l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
</body>

</html>