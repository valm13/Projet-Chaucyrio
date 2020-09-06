<?php
// On inclue les classes nécessaires
require_once('util/Require.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize/sass/materialize.css" media="screen,projection" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />


        <!-- Encodage et favicon -->
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="img/favicon.png" sizes="128x128" />

        <!-- Feuilles de style -->
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Accueil</title>
    </head>

    <body>
        <!--Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre du contenu -->
            <h1 class="center align">Goddhux !</h1>


            <!-- Carte de présentation -->
            <div class="row">
                <div class="row col s12">
                    <div class="col s6 offset-s3 center-align">
                        <div class="card hoverable">
                            <!-- Image de la carte -->
                            <div class="card-image">
                                <img src="img/chromos.jpg">
                                <!-- Légende de l'image -->
                                <span class="card-title"><i>L'authentique Klap</i></span>
                            </div>

                            <!-- Contenu de la carte -->
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


            <!-- Panel de promotion -->
            <div class="row">
                <div class="col s4 center">
                    <a href="blog.php">
                        <div class="card-panel hoverable">
                            <i class="medium material-icons">subject</i>
                            <p class="promo caption">Blog communautaire Chaucyrien</p>
                            <p class="light center">Retrouvez les dernières actualités de l'Académie !</p>
                        </div>
                    </a>
                </div>

                <div class="col s4 center">
                    <a href="dictionnaire.php">
                        <div class="card-panel hoverable">
                            <i class="medium material-icons">import_contacts</i>
                            <p class="promo caption">Grand Dictionnaire du Chaucyrio</p>
                            <p class="light center">Parcourez le Grand Dictionnaire du Chaucyrio en ligne !</p>
                        </div>
                    </a>
                </div>

                <div class="col s4 center">
                    <a href="tchat.php">
                        <div class="card-panel hoverable">
                            <i class="medium material-icons">import_contacts</i>
                            <p class="promo caption">Chaucy T'chat</p>
                            <p class="light center">Rencontrez des chaucyriens du monde entier, en temps réel !</p>
                        </div>
                    </a>
                </div>
            </div>
        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>


        <!--Importation de JQuery avant materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
    </body>
</html>
