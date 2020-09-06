<?php
// On inclue les classes nécessaires
require_once('util/Require.php');
// 2 problème : Gérer les post de commentaire selon les articles (on découpe le name du textarea et on a l'id article.)
// Differencier un post de nouvel article ? --> Création de l'article sur une autre page.
// // Si il est admin on valide automatiquement
/*
* Systeme du Blog
*/
$values = array(
'id_membre' => '',
'sujet' => '',
'texte' => '',
'role' => ''
);
$article_cree = 0;
$manager = new ChaussureManager(true);
// Si l'internaute est connecté et que les champs sont remplis lors d'un envoi.
if(isset($_POST['sujet']) && isset($_POST['texte']) && isset($_SESSION['membre'])){
$values['sujet'] = $_POST['sujet'];
$values['texte'] = nl2br($_POST['texte']); // nl2br pour avoir les sauts de ligne
$values['id_membre'] = $_SESSION['membre']->id();
$values['role'] = $_SESSION['membre']->role();
$manager->ajouteArticle($values);
$article_cree = 1;
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
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/blog.css" />
        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Blog communautaire</title>
    </head>
    <body>

        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>
        <!--Main-->
        <main>
            <h1 class="center align">Poster un article</h1>
            <?php
            if (empty($_SESSION['membre'])){
            ?>
            
            <div class="row ">
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
                                <p class=" center-block">Si vous souhaitez poster des articles, veuillez vous connecter !</p>
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
            if (!empty($_SESSION['membre']) && $article_cree == 0){
            ?>
            
            <div class="row">
                <form action="new_article.php" method="post">
                    <div class="row">
                        <!-- Icône -->
                        <div class="input-field col s2 offset-s3 center-align"><i class="material-icons prefix">subject</i></div>
                        <!-- Champ "Sujet" -->
                        <div class="input-field col s3">
                            <input id="sujet" type="text" class="validate" name="sujet" required /><label for="sujet">Sujet</label>
                        </div>
                        
                    </div>
                    <div class="row">
                        <!-- Icône -->
                        <div class="input-field col s2 offset-s3 center-align"><i class="material-icons prefix">text_fields</i></div>
                        <!-- Champ "Texte" -->
                        <div class="input-field col s3">
                            <textarea id="texte" class="materialize-textarea tooltipped" name="texte" maxlength="10000" data-length="10000" data-position="right" data-tooltip="Minimum de caractère : 100" required></textarea>
                            <label for="texte">Message</label>
                        </div>
                    </div>
                    <!-- Boutons -->
                    <div class="row">
                        <!-- Boutons de formulaire -->
                        <div class="center-align">
                            <!--Bouton à desactiver par défaut via JS (DEV)-->
                            <!-- Bouton d'envoi -->
                            <button class="btn waves-effect waves-light" type="submit" name="action">Poster<i class="material-icons right">send</i></button>
                            <!-- Bouton "Effacer" -->
                            <button class="btn waves-effect waves-light" type="reset" name="action">Effacer<i class="material-icons right">backspace</i></button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            }
            ?>
            <?php
            if ($article_cree == 1){
            ?>
            <span class="card-title center-align"><h3>Demande envoyée</h3></span>
            
            <p>Votre article a été créé, il devra être validé par un administrateur pour apparaître sur le site !</p>
            
            <h4 class="center-align">Récapitulatif :</h4>
            <br />
            <h7><b>Sujet :</b> <i><?php echo $values['sujet']?></i></h7><br>
            <h7><b>Message :</b></h7>
            <div class="row" id="message">
                <p id="message">
                    <?php echo $values['texte']; ?>
                </p>
            </div>
            <?php
            }
            ?>
            
        </main>
        <!--Footer-->
        <?php include('include/footer.php'); ?>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
        
        <script type="text/javascript" src="js/new_article.js"></script>
            
    </body>
</html>