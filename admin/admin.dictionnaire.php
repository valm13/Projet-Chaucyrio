<?php
// On inclue les classes nécessaires
require_once('../util/Require.php');

// Si l'utilisateur n'a pas les droits d'administrateur
if((!isset($_SESSION['membre'])) || ($_SESSION['membre']->role() != 1)) {
    header("Location: ../index.php");
}

$manager = new ChaussureManager(true);
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize/sass/materialize.css"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


        <!-- Encodage et favicon -->
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="../img/favicon.png" sizes="128x128">

        <!-- Feuilles de style -->
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/dictionnaire.css">

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Dictionnaire</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/admin.nav.php'); ?>


        <!--Main-->
        <main>
            <h1 class="center align">Administration du dictionnaire</h1>

            <!--Tableau principal (12 col)-->
            <div class="row">
                <div class="col s8 offset-s2">
                    <div class="card-panel center-align">
                    	<h3>Propositions en attente</h3>
                        <ul class="collapsible" data-collapside="accordion">
                            <?php
                            $propositions = $manager->listeMotPropose();
                            foreach($propositions as $key => $value) {

                            }
                            ?>
                            <li></li>
                        </ul>
		            </div>
                </div>
	        </div>
        </main>


        <!--Footer-->
        <?php include('../include/footer.php'); ?>


        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
    </body>
</html>
