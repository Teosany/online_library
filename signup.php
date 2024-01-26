<?php
// On récupère la session courante
// On inclue le fichier de configuration et de connexion à la base de données
// Après la soumission du formulaire de compte (plus bas dans ce fichier)
// On vérifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
// $_POST["vercode"] et la valeur initialisée $_SESSION["vercode"] lors de l'appel à captcha.php (voir plus bas)
// Le code est incorrect on informe l'utilisateur par une fenetre pop_up
//On lit le contenu du fichier readerid.txt au moyen de la fonction 'file'. Ce fichier contient le dernier identifiant lecteur cree.
// On incrémente de 1 la valeur lue
// On ouvre le fichier readerid.txt en écriture
// On écrit dans ce fichier la nouvelle valeur
// On referme le fichier
// On récupère le nom saisi par le lecteur
// On récupère le numéro de portable
// On récupère l'email
// On récupère le mot de passe
// On fixe le statut du lecteur à 1 par défaut (actif)
// On prépare la requete d'insertion en base de données de toutes ces valeurs dans la table tblreaders
// On éxecute la requete
// On récupère le dernier id inséré en bd (fonction lastInsertId)
// On cree une fonction valid() sans paramètre qui renvoie
// TRUE si les mots de passe saisis dans le formulaire sont identiques
// FALSE sinon
// On cree une fonction avec l'email passé en paramêtre et qui vérifie la disponibilité de l'email
// Cette fonction effectue un appel fetch vers check_availability.php
// Le mail est passé dans l'url
//<!-- On inclue le fichier header.php qui contient le menu de navigation-->
//<!--On affiche le titre de la page : CREER UN COMPTE-->
//<!--On affiche le formulaire de creation de compte-->
//<!--A la suite de la zone de saisie du captcha, on insère l'image créée par captcha.php : <img src="captcha.php">  -->
//<!-- On appelle la fonction valid() dans la balise <form> onSubmit="return valid(); -->
//<!-- On appelle la fonction checkAvailability() dans la balise <input> de l'email onBlur="checkAvailability(this.value)" -->

global $dbh;
session_start();

include('includes/config.php');

if (TRUE === isset($_POST['enrgister'])) {
    if ($_POST['vercode'] != $_SESSION['vercode']) {
        echo "<script>alert('Code de vérification est incorrect')</script>";
    } else {
        $ressourceLue = file('readerid.txt');
        $ressourceIncr = ++$ressourceLue[0];
        $ressource = fopen('readerid.txt', 'c+');
        fwrite($ressource, $ressourceIncr);
        fclose($ressource);

        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $status = 1;

        $sql = "INSERT INTO tblreaders (ReaderId, FullName, EmailId, MobileNumber, Password, Status) 
        VALUES ('$ressourceIncr', :name, :email, :tel, '$password', '$status')";

        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':tel', $tel, PDO::PARAM_INT);

        $query->execute() or die(print_r($dbh->errorInfo(), true));

        $last_id = $dbh->lastInsertId();
        if ($last_id != NULL) {
            $last_id = $dbh->lastInsertId();
        } else {
            $last_id = NULL;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Gestion de bibliotheque en ligne | Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous defer"></script>
    <script type="text/javascript" src="script.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
<?php include('includes/header.php'); ?>
<div id="succes" class="alert alert-success d-none" role="alert">Succes! votre
    identifiant: <?php if (TRUE === isset($_POST['enrgister'])) {
        if ($_POST['vercode'] != $_SESSION['vercode']) {
            echo "<script>alert('Code de vérification est incorrect')</script>";
        } else {
            echo $ressourceIncr;
        }
    } ?></div>
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
            <form method="post" action="signup.php" onSubmit="return valid()">
                <div class="mb-3">
                    <label for="name" class="form-label">Entrez votre nom complet</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Portable:</label>
                    <input type="tel" onkeyup="this.value = this.value.replace(/[^\d]/g,'')" class="form-control"
                           id="tel" name="tel" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"
                           onBlur="checkAvailability(this.value)" required>
                    <span id="error" class="btn-danger mb-3"></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe:</label>
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
                <button type="submit" name="enrgister" id="button" class="btn btn-info mb-3">ENREGISTER</button>
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php');
if (isset($last_id)) {
    echo('<script>window.addEventListener("load", succes);</script>');
}
if (TRUE === isset($_POST['enrgister'])) {
    if ($_POST['vercode'] == $_SESSION['vercode']) {
        if ($last_id === null) {
            echo('<script>window.addEventListener("load", insucces);</script>');
        }
    }
}
?>
</body>

</html>