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
        <link rel="stylesheet" type="text/css" href="css/admin.boutique.css" />

        <title>Académie Chaucyrienne > Administration : Boutique</title>
    </head>

    <body>
        <!--Navbar-->
        <?php include('include/admin.nav.php'); ?>


        <!--Main-->
        <main>
            <h1 class="center-align">Administration de la boutique</h1>

            <br />

            <div class="row center-align">
                <!-- Ajout d'un produit -->
                <div class="row">
                    <div class="col s10 offset-s1 center-align">
                        <div class="card-panel">
                            <!-- Titre de la partie -->
                            <h3 class="sous_titre">Ajouter un produit</h3>


                            <!-- Contenu de la carte -->
                            <div class="row">
                                <!-- Formulaire d'ajout -->
                                <form method="post" action="admin.boutique.php">
                                    <div class="row">
                                        <!-- Icône -->
                                        <div class="col s1 offset-s3 input-field">
                                            <i class="material-icons prefix">description</i>
                                        </div>


                                        <!-- Nom du produit -->
                                        <div class="col s4 input-field">
                                            <input type="text" name="nom_produit" class="validate" />
                                            <label for="nom_produit">Nom du produit</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col s8 offset-s2">
                                            <!-- Description du produit -->
                                            <label for="">Description du produit</label>
                                            <textarea id="champ" name="texte" rows="10" cols="30" style="width:90%; height:100px"></textarea>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <!-- Icône -->
                                        <div class="col s1 offset-s4 input-field">
                                            <i class="material-icons prefix">store</i>
                                        </div>


                                        <!-- Stock du produit -->
                                        <div class="col s2 input-field">
                                            <input type="text" name="nom_produit" class="validate" />
                                            <label for="nom_produit">Stock du produit</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <!-- Icône -->
                                        <div class="col s1 offset-s4 input-field">
                                            <i class="material-icons prefix">euro_symbol</i>
                                        </div>


                                        <!-- Prix unitaire du produit -->
                                        <div class="col s2 input-field">
                                            <input type="text" name="nom_produit" class="validate" />
                                            <label for="nom_produit">Prix unitaire du produit</label>
                                        </div>
                                    </div>


                                    <!-- Bouton d'action -->
                                    <div class="row">
                                        <button type="submit" class="btn waves-effect waves-light" name="action" value="ajouter">Ajouter le produit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Gestion du stock -->
                <div class="row">
                    <div class="col s10 offset-s1 center-align">
                        <div class="card-panel">
                            <!-- Titre de la partie -->
                            <h3 class="sous_titre">Gestion des stocks</h3>
                        </div>
                    </div>
                </div>


                <!-- Suppression d'un produit -->
                <div class="row">
                    <div class="col s10 offset-s1 center-align">
                        <div class="card-panel">
                            <!-- Titre de la partie -->
                            <h3 class="sous_titre">Supprimer un produit</h3>


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