<?php
// On demarre ou on recupere la session courante
// On inclue le fichier de configuration et de connexion � la base de donn�es
// On invalide le cache de session $_SESSION['alogin'] = ''
// A faire :
// Apres la soumission du formulaire de login (plus bas dans ce fichier)
// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
// $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas
// Le code est correct, on peut continuer
// On recupere le nom de l'utilisateur saisi dans le formulaire
// On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
// On construit la requete qui permet de retrouver l'utilisateur a partir de son nom et de son mot de passe
// depuis la table admin
// Si le resultat de recherche n'est pas vide
// On stocke le nom de l'utilisateur  $_POST['username'] en session $_SESSION
// On redirige l'utilisateur vers le tableau de bord administration (n'existe pas encore)
// sinon le login est refuse. On le signal par une popup

global $dbh;
session_start();

include('includes/config.php');

if (isset($_SESSION['alogin']) && $_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}

if (TRUE === isset($_POST['alogin'])) {
    if ($_POST['vercode'] != $_SESSION['vercode']) {
        echo "<script>alert('Code de vérification incorrect')</script>";
    } else {
        $emailid = $_POST['emailid'];
        $sql = "SELECT AdminEmail, Password FROM admin WHERE UserName = :emailid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result) && password_verify($_POST['password'], $result->Password)) {
            $_SESSION['alogin'] = $_POST['emailid'];

            header('location:admin/dashboard.php');
        } else {
            echo "<script>alert('Utilisateur inconnu')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

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

<body>
<!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <div class="mb-3 mt-3">
                <h3>ADMIN LOGIN</h3>
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <form method="post" action="adminlogin.php">
                <div class="mb-3">
                    <label for="emailid" class="form-label">Login</label>
                    <input type="text" class="form-control" name="emailid" required>
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
                <button type="submit" name="alogin" id="button" class="btn btn-info mb-3">LOGIN</button>
            </form>
        </div>
    </div>
</div>
<!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php'); ?>
<!-- FOOTER SECTION END-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="admin/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>
</html>