<?php
// On inclue les classes nécessaires
require_once('../util/Require.php');


// Redirection si l'utilisateur n'est pas admin
if((!isset($_SESSION['membre'])) || ($_SESSION['membre']->role() != 1)) {
    header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <!--Google Icons Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!--Importation de materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize/sass/materialize.css" media="screen,projection" />

        <!--Informe le navigateur que le site est optimisé pour mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="img/favicon.png" sizes="128x128" />

        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/index.css" />

        <title>Académie Chaucyrienne > Panel d'administration</title>
    </head>

    <body>
        <!--Navbar-->
        <?php include('include/admin.nav.php'); ?>


        <!--Main-->
        <main>
            <h1 class="center align">Goddhux !</h1>

            <div class="row">
                <div class="row col s12">
                    <div class="col s6 offset-s3 center-align">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img src="../img/chromos.jpg">
                                <span class="card-title"><i>L'authentique Klap</i></span>
                            </div>

                            <div class="card-content">
                                <p>
                                    <b>Bienvenue sur le site officiel du Chaucyrio</b>, une langue pleine de promesses, qui s'engage à devenir la langue universelle <b>la plus facile à apprendre</b> !
                                    <br /><br />
                                    Alors <b>rejoins notre aventure</b>, et <b>deviens un vrai chaucyrien</b> !
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <!--Footer-->
        <?php include('../include/footer.php'); ?>


        <!--Importation de JQuery avant materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../css/materialize/js/materialize.min.js"></script>
    </body>
</html>
