<?php
// Gère les dépendances de la page
require_once('util/Require.php');




/*
*   Vérification utilisateur
*/

// Si l'utilisateur est connecté
if(isset($_SESSION['membre']))
{
    unset($_SESSION['membre']);            // On supprime la variable 'membre' 
	session_destroy();                     // On détruit la session

	header('Refresh:5; url=index.php');    // Redirection au bout de 5 secondes
}
// Si l'utilisateur est déconnecté
else
{
	header('Location: index.php');         // Redirection subite
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize/sass/materialize.css"  media="screen,projection" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />


        <!-- Encodage et favicon -->
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="img/favicon.png" sizes="128x128" / >

        <!-- Feuilles de style -->
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Déconnexion</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre du contenu -->
            <h1 class="center align">Déconnexion</h1>


            <!-- Message d'informations -->
            <div class="row">
            	<div class="col s12 center-align">
            		<p>
            			Vous avez été déconnecté.
            			<br /><br />
            			<a href="index.php">Si vous n'êtes pas redirigé d'ici 5 secondes, cliquez ici</a>.
            		</p>
            	</div>
            </div>
        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>



        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
    </body>
</html>
