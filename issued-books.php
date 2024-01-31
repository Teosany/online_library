<?php
// On récupère la session courante
// On inclue le fichier de configuration et de connexion à la base de données
// Si l'utilisateur n'est pas connecte, on le dirige vers la page de login
// Sinon on peut continuer
//	Si le bouton de suppression a ete clique($_GET['del'] existe)
//On recupere l'identifiant du livre
// On supprime le livre en base
// On redirige l'utilisateur vers issued-book.php
//    <!--On insere ici le menu de navigation T-->
//    <!-- On affiche le titre de la page : LIVRES SORTIS -->
//    <!-- On affiche la liste des sorties contenus dans $results sous la forme d'un tableau -->
//    <!-- Si il n'y a pas de date de retour, on affiche non retourne -->

global $dbh;
session_start();

include('includes/config.php');

if (strlen($_SESSION['rdid']) == 0) {
    header('location:index.php');
} else {
    $user = $_SESSION['rdid'];

    $sql = "SELECT ReaderID, BookId, BookName, IssuesDate, ReturnDate FROM tblissuedbookdetails
    JOIN tblbooks ON BookId = ISBNNumber WHERE ReaderID = :user";
    $query = $dbh->prepare($sql);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_OBJ);

    foreach ($results as $result) {
        if ($result->ReturnDate == '') {
            error_log('234');
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliotheque en ligne | Gestion des livres</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet"/>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <?php include('includes/header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>LIVRES SORTIS</h3>
                </div>
                <hr>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">ISBN</th>
                <th scope="col">Date de sortie</th>
                <th scope="col">Date de retour</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($results as $result) : ?>
                <tr>
                    <th scope="row"><?php echo $i;?></th>
                    <td><?php echo $result->BookName;?></td>
                    <td><?php echo $result->BookId;?></td>
                    <td><?php echo $result->IssuesDate;?></td>
                    <?php if($result->ReturnDate != "") : ?><td class="table-success"><?php echo $result->ReturnDate; else : ?><td class="table-danger"><?php echo 'Non retourne'; endif?></td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include('includes/footer.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="admin/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>
    </html>
<?php } ?>