<?php
global $dbh;
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (TRUE === isset($_POST['add'])) {
        $name = $_POST['name'];

        if (($_POST['status'] == 'active')) {
            $status = 1;
        } else {
            $status = 0;
        }

        $sql = "INSERT INTO tblcategory (CategoryName, Status) VALUES ('$name', '$status')";

        $query = $dbh->query($sql);

        if ($query === false) {
            $_SESSION['addCategory'] = "Error: " . $dbh->error;
        } else {
            $_SESSION['addCategory'] = "Done";
        }
        error_log($_SESSION['addCategory']);
    }
// Si l'utilisateur n'est plus logué
// On le redirige vers la page de login
// Sinon on peut continuer. Après soumission du formulaire de creation
// On recupere le nom et le statut de la categorie
// On prepare la requete d'insertion dans la table tblcategory
// On execute la requete
// On stocke dans $_SESSION le message correspondant au resultat de loperation
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Ajout de categories</title>
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
                    <h3>AJOUTER UNE CATEGORIE</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="card border-primary-subtle rounded-3">
            <h5 class="card-header text-primary-emphasis bg-primary-subtle">Information categorie</h5>
            <div class="card-body">
                <form method="post" action="add-category.php">
                    <div class="mb-4">
                        <label for="inputText" class="form-label"><h5>Nom</h5></label>
                        <input type="text" class="form-control" name="name" id="inputText" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <h5>Statut</h5>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="active"
                               checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Active
                        </label>
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="inactive">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Inactive
                        </label>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Creer</button>
                </form>
            </div>
        </div>

    </div>
    <?php include('includes/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>