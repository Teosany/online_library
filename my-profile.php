<?php
// On récupère la session courante
// On inclue le fichier de configuration et de connexion à la base de données
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
//<!--On affiche le titre de la page : EDITION DU PROFIL-->
//<!--On affiche le formulaire-->
//<!--On affiche l'identifiant - non editable-->
//
//<!--On affiche la date d'enregistrement - non editable-->
//
//<!--On affiche la date de derniere mise a jour - non editable-->
//
//<!--On affiche la statut du lecteur - non editable-->
//
//<!--On affiche le nom complet - editable-->
//
//<!--On affiche le numero de portable- editable-->
//
//<!--On affiche l'email- editable-->

global $dbh;
session_start();
include('includes/config.php');

if (strlen($_SESSION['rdid']) == 0) {
    header('location:index.php');
} else {
    $user = $_SESSION['rdid'];

    $sql = "SELECT * FROM tblreaders WHERE ReaderID = :user";

    $query = $dbh->prepare($sql);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();

    $results = $query->fetch(PDO::FETCH_OBJ);

    if (isset($_POST['name']) && isset($_POST['data'])) {
        $nameVar = $_POST['name'];
        $data = $_POST['data'];

        switch ($nameVar) {
            case 'name' :
                $column = 'FullName';
                break;
            case 'tel' :
                $column = 'MobileNumber';
                break;
            case 'email' :
                $column = 'EmailId';
                break;
        }

        $sql = $dbh->query("SELECT $column FROM tblreaders WHERE ReaderId = '$user'");

        $oldData = $sql->fetch();
        $oldData = $oldData[0];

        if ($oldData != $data) {
            $sql = "UPDATE tblreaders SET $column = :data WHERE ReaderId = :user";

            $query = $dbh->prepare($sql);
            $query->bindParam(':user', $user, PDO::PARAM_STR);
            $query->bindParam(':data', $data);
            $query->execute();

            $sql = $dbh->query("SELECT updateDate FROM tblreaders WHERE ReaderId = '$user'");
            $updateTime = $sql->fetch();

            echo $updateTime[0];
            exit();
        } else {
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <title>Gestion de bibliotheque en ligne | Profil</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>
</head>

<body class="d-flex flex-column min-vh-100">
<!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php'); ?>

<div id="succes" class="alert alert-success d-none" role="alert">Succes</div>
<div id="insucces" class="alert alert-danger d-none" role="alert">Insucces!</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <div class="mb-3 mt-3">
                <h3>EDITION DU PROFIL</h3>
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8 offset-md-3">
            <form method="post" action="signup.php" onSubmit="return valid()">
                <div class="mb-3">
                    <label for="name" class="form-label">Votre identidiant:</label>
                    <input type="text" class="form-control" placeholder="<?php echo $_SESSION['rdid'] ?>"
                           id="disabledTextInput" name="name" required disabled>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">La date d'enregistrement</label>
                    <input type="text" class="form-control" id="disabledTextInput" name="name" disabled
                           placeholder="<?php echo($results->RegDate); ?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">La date de derniere mise a jour</label>
                    <input type="text" class="form-control update-date" id="disabledTextInput1" name="name" required disabled
                           placeholder="<?php if ($results->UpdateDate != "") : echo($results->UpdateDate); endif; ?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Le status de member</label>
                    <input type="text" class="form-control" id="disabledTextInput" name="name" required disabled
                           placeholder="<?php if ($results->Status != 0) : echo 'Active member'; endif; ?>">
                </div>
                <div class="mb-3">
                    <label for="TextInput" class="form-label">Le nom complet</label>
                    <input type="text" class="form-control blurControl" id="TextInput" name="name" required
                           value="<?php echo $results->FullName; ?>">
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Portable:</label>
                    <input type="tel" onkeyup="this.value = this.value.replace(/[^\d]/g,'')"
                           class="form-control blurControl"
                           id="tel" name="tel" required value="<?php echo $results->MobileNumber; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control blurControl" id="email" name="email"
                           onBlur="checkAvailability(this.value)" required value="<?php echo $results->EmailId; ?>">
                    <span id="error" class="btn-danger mb-3"></span>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
<script type="text/javascript" src="admin/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>

</html>