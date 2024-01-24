<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logué
// On le redirige vers la page de login
// Sinon on peut continuer. Après soumission du formulaire de modification du mot de passe
// Si le formulaire a bien ete soumis
// On recupere le mot de passe courant
// On recupere le nouveau mot de passe
// On recupere le nom de l'utilisateur stocké dans $_SESSION

// On prepare la requete de recherche pour recuperer l'id de l'administrateur (table admin)
// dont on connait le nom et le mot de passe actuel
// On execute la requete

// Si on trouve un resultat
// On prepare la requete de mise a jour du nouveau mot de passe de cet id
// On execute la requete
// On stocke un message de succès de l'operation
// On purge le message d'erreur
// Sinon on a trouve personne	
// On stocke un message d'erreur

// Sinon le formulaire n'a pas encore ete soumis
// On initialise le message de succes et le message d'erreur (chaines vides)
?>

<!DOCTYPE html>
<html lang="FR">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Gestion bibliotheque en ligne</title>
	<!-- BOOTSTRAP CORE STYLE  -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- FONT AWESOME STYLE  -->
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- CUSTOM STYLE  -->
	<link href="assets/css/style.css" rel="stylesheet" />
	<!-- Penser a mettre dans la feuille de style les classes pour afficher le message de succes ou d'erreur  -->
</head>
<script type="text/javascript">
	// On cree une fonction JS valid() qui renvoie
	// true si les mots de passe sont identiques
	// false sinon
	function valid() {

	}
</script>

<body>
	<!------MENU SECTION START-->
	<?php include('includes/header.php'); ?>
	<!-- MENU SECTION END-->
	<!-- On affiche le titre de la page "Changer de mot de passe"  -->
	<!-- On affiche le message de succes ou d'erreur  -->

	<!-- On affiche le formulaire de changement de mot de passe-->
	<!-- La fonction JS valid() est appelee lors de la soumission du formulaire onSubmit="return valid();" -->

	<!-- CONTENT-WRAPPER SECTION END-->
	<?php include('includes/footer.php'); ?>
	<!-- FOOTER SECTION END-->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
</body>

</html>