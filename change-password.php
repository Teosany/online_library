<?php
// On recupere la session courante

// On inclue le fichier de configuration et de connexion à la base de données

// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
// sinon, on peut continuer,
// si le formulaire a ete envoye : $_POST['change'] existe
// On recupere le mot de passe et on le crypte (fonction php password_hash)
// On recupere l'email de l'utilisateur dans le tabeau $_SESSION
// On cherche en base l'utilisateur avec ce mot de passe et cet email
// Si le resultat de recherche n'est pas vide
// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur
// On stocke le message d'operation reussie
// sinon (resultat de recherche vide)
// On stocke le message "mot de passe invalide"
global $dbh;
session_start();
include('includes/config.php');

if (strlen($_SESSION['rdid']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['change'])) {
        $passwordNew = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_SESSION['login'];

        $sql = "SELECT EmailId, Password FROM tblreaders WHERE EmailId = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result->Password) && password_verify($_POST['passwordActuel'], $result->Password)) {
            $sql = "UPDATE tblreaders SET Password = :password WHERE EmailId = :email";
            $queryU = $dbh->prepare($sql);
            $queryU->bindParam(':email', $email, PDO::PARAM_STR);
            $queryU->bindParam(':password', $passwordNew, PDO::PARAM_STR);
            $queryU->execute();
            $succes = true;
        } else {
            $succes = NULL;
        }
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet"/>

        <!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

    </head>
    <script type="text/javascript">
        /* On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques
        Cette fonction retourne un booleen*/
    </script>

    <body class="d-flex flex-column min-vh-100">
    <!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
    <?php include('includes/header.php'); ?>
    <!--On affiche le titre de la page : CHANGER MON MOT DE PASSE-->
    <!--  Si on a une erreur, on l'affiche ici -->
    <!--  Si on a un message, on l'affiche ici -->

    <!--On affiche le formulaire-->
    <!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"-->

    <div id="succes" class="alert alert-success d-none" role="alert">Succes!</div>
    <div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>CREER UN COMPTE</h3>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <form method="post" action="change-password.php" onSubmit="return valid()">
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="passwordActuel" name="passwordActuel"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordConf" class="form-label">Confirmez le mot de passe:</label>
                        <input type="password" class="form-control" id="passwordConf" name="passwordConf" required>
                        <span id="passwordError" class="btn-danger mb-3"></span>
                    </div>
                    <button type="submit" name="change" id="button" class="btn btn-info mb-3">CHANGER</button>
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
    <?php
    if (isset($succes)) {
        echo('<script>window.addEventListener("load", succes);</script>');
    }
    if (TRUE === isset($_POST['change'])) {
            if ($succes == NULL) {
                echo('<script>window.addEventListener("load", insucces);</script>');
            }
    }
} ?>