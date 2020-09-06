<?php

// On inclue les classes nécessaires
require_once('util/Require.php');



/*
* Systeme de Tchat
*/

$manager = new ChaussureManager(true);
$values = array(
    'nom' => '',
    'prenom' => '',
    'id_membre' => '',
    'message' => ''
    );
if(!empty($_SESSION['membre'])){
    $values = array(
    'nom' => $_SESSION['membre']->nom(),
    'prenom' => $_SESSION['membre']->prenom(),
    'id_membre' => $_SESSION['membre']->id(),
    'message' => ''
    );
    
    if(!empty($_POST)) {
    // On vérifie que toutes les valeurs ont bien été reçues
    
        if(!isset($_POST['message'])) {
            // Si la valeur de la clé n'a pas été passée
            $formulaire_envoye = false;
        } else {
            // Sinon on récupère la valeur
            $values['message'] = $_POST['message'];
        }
    $manager->ajouteMessageTchat($values);
}

}





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
        <link rel="stylesheet" type="text/css" href="css/tchat.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > T'chat</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <h1 class="center align">T'chat</h1>
            <form action="tchat.php" method="post">
                <?php
                    if(empty($_SESSION['membre']) || $_SESSION['membre']->role() == -1){
                ?>
                <div class="row">                

                    <div class="col s8 offset-s2 center-align">
                        <div class="card-panel col s12 center-align">
                            <div class="card-content light black-text">
                                <span class="card-title center-align">
                                    <h3>
                                        <i class="material-icons medium">warning</i>
                                        <span class="paddock">Attention</span>
                                        <i class="material-icons medium">warning</i>
                                    </h3>
                                </span>
                                
                                <div class="valign-wrapper">
                                    <p class=" center-block">Si vous souhaitez participer au T'chat, inscrivez et/ou connectez-vous !</p>

                                    <a href="connexion.php"><i class="material-icons medium">group_add</i></a>
                                </div>
                            </div>
                        </div>
                    
                    </div> 
                </div>

                <?php
                    }
                ?>

                <?php 
                    if(!empty($_SESSION['membre']) && $_SESSION['membre']->role() != -1){
                ?>
                <div class="row">
                    <div class="input-field col s1 offset-s2 center-align">
                        <i class="material-icons prefix">create</i>
                    </div> 
                    
                    <div class="input-field col s6">
                    <input id="message" type="text" class="validate" name="message" required /><label for="icon_prefix2">Votre message : </label>
                    </div>
                </div>
                <div class="button center">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Envoyer
                        <i class="material-icons right">send</i>
                    </button>
                </div>
                <?php
                    }
                ?>
                <div class="row">
                    <div class="col s8 offset-s2">
                        <div class="scrollbar" id="tchat">
                            <?php $manager->afficheMessageTchat($values); ?>
                        </div>
                        
                    </div>
                </div>
            </form>
            


            
        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>


        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="js/tchat.js"></script>
    </body>
</html>
