<?php
// On demarre ou on recupere la session courante
global $dbh;
session_start();

// On inclue le fichier de configuration et de connexion a la base de donnees
include('includes/config.php');

// On invalide le cache de session
if (isset($_SESSION['login']) && $_SESSION['login'] != '') {
    $_SESSION['login'] = '';
}

if (TRUE === isset($_POST['login'])) {
    // Après la soumission du formulaire de login ($_POST['login'] existe - voir pourquoi plus bas)
    // On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
    // $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
    if ($_POST['vercode'] != $_SESSION['vercode']) {
        // Le code est incorrect on informe l'utilisateur par une fenetre pop_up
        echo "<script>alert('Code de vérification incorrect')</script>";
    } else {
        // Le code est correct, on peut continuer
        // On recupere le mail de l'utilisateur saisi dans le formulaire
        $mail = $_POST['emailid'];
        // On construit la requete SQL pour recuperer l'id, le readerId et l'email du lecteur � partir des deux variables ci-dessus
        // dans la table tblreaders
        $sql = "SELECT EmailId, Password, ReaderId, Status FROM tblreaders  WHERE EmailId = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $mail, PDO::PARAM_STR);
        // On execute la requete
        $query->execute();
        // On stocke le resultat de recherche dans une variable $result
        $result = $query->fetch(PDO::FETCH_OBJ);
        // Si il y a qqchose dans result
        // et si le mot de passe saisi est correct

        if (!empty($result) && password_verify($_POST['password'], $result->Password)) {
            // On stocke l'identifiant du lecteur (ReaderId dans $_SESSION)
            $_SESSION['rdid'] = $result->ReaderId;

            if ($result->Status == 1) {
                // Si le statut du lecteur est actif (egal a 1)
                // On stocke l'email du lecteur dans $_SESSION['login']
                $_SESSION['login'] = $_POST['emailid'];
                // l'utilisateur est redirige vers dashboard.php

                header('location:dashboard.php');
            } else {
                // Sinon le compte du lecteur a ete bloque. On informe l'utilisateur par un popu
                echo "<script>alert('Votre compte à été bloqué')</script>";
            }
        } else {
            echo "<script>alert('Utilisateur inconnu')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title>Gestion de bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>
</head>

<body class="d-flex flex-column min-vh-100">
<!--On inclue ici le menu de navigation includes/header.php-->
<?php include('includes/header.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <div class="mb-3 mt-3">
                <h3>LOGIN LECTEUR</h3>
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <form method="post" action="index.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="emailid" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Entrez votre mot de passe</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <p>
                        <a href="user-forgot-password.php">Mot de passe oublié ?</a>
                    </p>
                </div>
                    <label for="vercode" class="form-label">Code de vérification:</label>
                <div class="mb-3">
                    <input type="text" onkeyup="this.value = this.value.replace(/[^\d]/g,'')"
                           class="form-control col"
                           id="vercode" name="vercode" required
                    >
                    <img class="form-text col-3" style="height:35px; width: auto" src="captcha.php" alt="captcha">
                </div>
                <button type="submit" name="login" id="button" class="btn btn-info mb-3">LOGIN</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<!-- FOOTER SECTION END-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script></body>

</html>
<?php
ini_set("display_errors", "On"); error_reporting(E_ALL);

phpinfo();
?>