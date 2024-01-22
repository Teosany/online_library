<?php
// On récupère la session courante

// On inclue le fichier de configuration et de connexion à la base de données

// Si l'utilisateur n'est pas connecte, on le dirige vers la page de login
// Sinon on peut continuer
//	Si le bouton de suppression a ete clique($_GET['del'] existe)
//On recupere l'identifiant du livre
// On supprime le livre en base
// On redirige l'utilisateur vers issued-book.php
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Gestion des livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
    <!--On insere ici le menu de navigation T-->
    <?php include('includes/header.php'); ?>
    <!-- On affiche le titre de la page : LIVRES SORTIS -->

    <!-- On affiche le titre de la page : LIVRES SORTIS -->
    <!-- On affiche la liste des sorties contenus dans $results sous la forme d'un tableau -->
    <!-- Si il n'y a pas de date de retour, on affiche non retourne -->


    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>