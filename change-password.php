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

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />

	<!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

</head>
<script type="text/javascript">
	/* On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques 
	Cette fonction retourne un booleen*/
</script>

<body>
	<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
	<?php include('includes/header.php'); ?>
	<!--On affiche le titre de la page : CHANGER MON MOT DE PASSE-->
	<!--  Si on a une erreur, on l'affiche ici -->
	<!--  Si on a un message, on l'affiche ici -->

	<!--On affiche le formulaire-->
	<!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"-->


	<?php include('includes/footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>