<?php
// On récupère la session courante
global $dbh;
session_start();
// On inclue le fichier de configuration et de connexion à la base de données
include('includes/config.php');

if (strlen($_SESSION['rdid']) == 0) {
    header('location:index.php');
} else {
    $user = $_SESSION['rdid'];

    $sql = "SELECT * FROM tblissuedbookdetails WHERE ReaderID = :user";
    $query = $dbh->prepare($sql);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $quantity = count($results);

    $i = 0;
    foreach ($results as $result) {
        if ($result->ReturnStatus === 0) {
            $i++;
        }
    }
    $nonrendu = $i;

// Si l'utilisateur n'est plus logué
// On le redirige vers la page de login
// Sinon on peut continuer. Après soumission du formulaire de profil

// On recupere l'id du lecteur (cle secondaire)

// On recupere le nom complet du lecteur

// On recupere le numero de portable

// On update la table tblreaders avec ces valeurs
// On informe l'utilisateur du resultat de l'operation


// On souhaite voir la fiche de lecteur courant.
// On recupere l'id de session dans $_SESSION

// On prepare la requete permettant d'obtenir 
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <title>Gestion de bibliotheque en ligne | Profil</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>

</head>

<body>
<!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php'); ?>
<!--On affiche le titre de la page : EDITION DU PROFIL-->

<!--On affiche le formulaire-->
<!--On affiche l'identifiant - non editable-->

<!--On affiche la date d'enregistrement - non editable-->

<!--On affiche la date de derniere mise a jour - non editable-->

<!--On affiche la statut du lecteur - non editable-->

<!--On affiche le nom complet - editable-->

<!--On affiche le numero de portable- editable-->

<!--On affiche l'email- editable-->

<?php include('includes/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>