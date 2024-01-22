<?php
// On recupere la session courante
// On inclue le fichier de configuration et de connexion a la base de donn�es
// Si l'utilisateur est déconnecté
// L'utilisateur est renvoyé vers la page de login : index.php
// On récupère l'identifiant du lecteur dans le tableau $_SESSION
// On veut savoir combien de livres ce lecteur a emprunte
// On construit la requete permettant de le savoir a partir de la table tblissuedbookdetails
// On stocke le résultat dans une variable
// On veut savoir combien de livres ce lecteur n'a pas rendu
// On construit la requete qui permet de compter combien de livres sont associ�s � ce lecteur avec le ReturnStatus � 0
// On stocke le résultat dans une variable
//     On affiche le titre de la page : Tableau de bord utilisateur-->
//     On affiche la carte des livres emprunt�s par le lecteur-->
//     On affiche la carte des livres non rendus le lecteur-->
//    <!--On inclue ici le menu de navigation includes/header.php-->

global $dbh;
session_start();

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
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <title>Gestion de librairie en ligne | Tableau de bord utilisateur</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <h3>TABLEAU DE BORD UTILISATEUR</h3>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home-tab-pane"
                                type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Livres
                            empruntés <span class="badge bg-secondary"><?php echo $quantity; ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#profile-tab-pane"
                                type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Livres
                            non encore rendus <span class="badge bg-danger"><?php echo $nonrendu; ?></span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                     tabindex="0">
                    <p></p>
                    <?php foreach ($results as $result) : ?>
                        <p class="h5"><?php echo $result->BookId ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                     tabindex="1">
                    <p></p>
                    <?php foreach ($results as $result) : ?>
                        <p class="h5"><?php if ($result->ReturnStatus === 0) :
                                echo $result->BookId;
                            endif ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>
    </html>
<?php } ?>