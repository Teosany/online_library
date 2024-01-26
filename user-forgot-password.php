<?php
// On récupère la session courante
// On inclue le fichier de configuration et de connexion à la base de données
// Après la soumission du formulaire de login ($_POST['change'] existe
// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
// $_POST["vercode"] et la valeur initialisee $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas)
// Si le code est incorrect on informe l'utilisateur par une fenetre pop_up
// Sinon on continue
// on recupere l'email et le numero de portable saisi par l'utilisateur
// et le nouveau mot de passe que l'on encode (fonction password_hash)
// On cherche en base le lecteur avec cet email et ce numero de tel dans la table tblreaders
// Si le resultat de recherche n'est pas vide
// On met a jour la table tblreaders avec le nouveau mot de passe
// On informa l'utilisateur par une fenetre popup de la reussite ou de l'echec de l'operation
//        $sql = "INSERT INTO tblreaders (ReaderId, FullName, EmailId, MobileNumber, Password, Status)
//        VALUES ('$ressourceIncr', :name, :email, :tel, '$password', '$status')";
//        $query = $dbh->prepare($sql);
//        $query->bindParam(':name', $name, PDO::PARAM_STR);
//        $query->bindParam(':email', $email, PDO::PARAM_STR);
//        $query->bindParam(':tel', $tel, PDO::PARAM_INT);
//        $query->execute() or die(print_r($dbh->errorInfo(), true));
//        $last_id = $dbh->lastInsertId();

global $dbh;
session_start();
include('includes/config.php');


if (TRUE === isset($_POST['change'])) {
    if ($_POST['vercode'] != $_SESSION['vercode']) {
        echo "<script>alert('Code de vérification est incorrect')</script>";
    } else {
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "SELECT id FROM tblreaders WHERE EmailId = :email AND MobileNumber = :tel";

        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':tel', $tel, PDO::PARAM_STR);
        $query->execute();

        $emailQuery = $query->fetch();

        if ($emailQuery != '') {
            $sql = "UPDATE tblreaders SET Password = '$password' WHERE EmailId = :email AND MobileNumber = :tel";
            $queryU = $dbh->prepare($sql);
            $queryU->bindParam(':email', $email, PDO::PARAM_STR);
            $queryU->bindParam(':tel', $tel, PDO::PARAM_STR);
            $queryU->execute();
            $succes = true;
        } else {
            $succes = NULL;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <title>Gestion de bibliotheque en ligne | Recuperation de mot de passe </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"defer></script>    <script type="text/javascript" src="script.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
<!--On inclue ici le menu de navigation includes/header.php-->
<?php include('includes/header.php'); ?>
<!-- On insere le titre de la page (RECUPERATION MOT DE PASSE -->

<!--On insere le formulaire de recuperation-->
<!--L'appel de la fonction valid() se fait dans la balise <form> au moyen de la propri�t� onSubmit="return valid();"-->
<div id="succes" class="alert alert-success d-none" role="alert">Succes!</div>
<div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <div class="mb-3 mt-3">
                <h3>RECUPERATION MOT DE PASSE</h3>
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <form method="post" action="user-forgot-password.php" onSubmit="return valid()">
                <div class="mb-3">
                    <label for="tel" class="form-label">Portable:</label>
                    <input type="tel" onkeyup="this.value = this.value.replace(/[^\d]/g,'')" class="form-control"
                           id="tel" name="tel" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <span id="error" class="btn-danger mb-3"></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="passwordConf" class="form-label">Confirmez le mot de passe:</label>
                    <input type="password" class="form-control" id="passwordConf" name="passwordConf" required>
                    <span id="passwordError" class="btn-danger mb-3"></span>
                </div>
                <label for="vercode" class="form-label">Code de vérification:</label>
                <div class="mb-3">
                    <input type="text" onkeyup="this.value = this.value.replace(/[^\d]/g,'')"
                           class="form-control col"
                           id="vercode" name="vercode" required
                    >
                    <img class="form-text col-3" style="height:35px; width: auto" src="captcha.php" alt="captcha">
                </div>
                <button type="submit" name="change" id="button" class="btn btn-info mb-3">CHANGE PASSWORD</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<!-- FOOTER SECTION END-->
<?php
if (isset($succes)) {
    echo('<script>window.addEventListener("load", succes);</script>');
}
if (TRUE === isset($_POST['change'])) {
    if ($_POST['vercode'] == $_SESSION['vercode']) {
        if ($succes === null) {
            echo('<script>window.addEventListener("load", insucces);</script>');
        }
    }
}
?>
</body>

</html>