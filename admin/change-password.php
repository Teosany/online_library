<?php
global $dbh;
session_start();

include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:../index.php');
} else {
    if (isset($_POST['change'])) {
        $passwordNew = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_SESSION['alogin'];

        $sql = "SELECT AdminEmail, Password FROM admin WHERE AdminEmail = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($result->Password) && password_verify($_POST['passwordActuel'], $result->Password)) {
            $sql = "UPDATE admin SET Password = :password WHERE AdminEmail = :email";
            $queryU = $dbh->prepare($sql);
            $queryU->bindParam(':email', $email, PDO::PARAM_STR);
            $queryU->bindParam(':password', $passwordNew, PDO::PARAM_STR);
            $queryU->execute();
            $success = true;
        } else {
            $success = NULL;
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="FR">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <title>Gestion de bibliothèque en ligne | Changer le mot de passe</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <link href="assets/css/style.css" rel="stylesheet"/>
    </head>

    <body class="d-flex flex-column min-vh-100">
    <?php include('includes/header.php'); ?>
    <div id="succes" class="alert alert-success d-none" role="alert">Succes!</div>
    <div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
                <div class="mb-3 mt-3">
                    <h3>CHANGER LE MOT DE PASSE</h3>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>

    </html>
    <?php     if (isset($success)) {
        echo('<script>window.addEventListener("load", succes);</script>');
    }
    if (TRUE === isset($_POST['change'])) {
        if ($success == NULL) {
            echo('<script>window.addEventListener("load", insucces);</script>');
        }
    }
}?>
