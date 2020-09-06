<?php
// On inclue les classes nécessaires
require_once('util/Require.php');

// Redirection à la page de connexion si l'utilisateur n'est pas connecté
if(!isset($_SESSION['membre'])) {
    header('Location: connexion.php');
}
// Initialisations
$proposition_mot = 0;
$manager = new ChaussureManager(true);
$formulaire = array(
    'id_membre' => '',
    'role' => '',
    'mot' => '',
    'cat_gram' => '',
    'traduction' => '',
    'commentaire' => '',
    'date_contribution' => ''
);

// Si l'utilisateur est connecté, et que les champts requis sont remplis
if(isset($_POST['mot']) && isset($_POST['traduction']) && isset($_SESSION['membre'])) {
$formulaire['mot'] = $_POST['mot'];
$formulaire['traduction'] = $_POST['traduction'];
$formulaire['cat_gram'] = $_POST['cat_gram'];
$formulaire['commentaire'] = ($_POST['commentaire']) ? str_replace('<br />', '\n', $_POST['commentaire']) : "Je ne suis pas très bavard"; // Commentaire rempli ou non.
$formulaire['id_membre'] = $_SESSION['membre']->id();
$formulaire['role'] = $_SESSION['membre']->role();
$formulaire['date_contribution'] = date('Y-m-d', time());

// On vérifie la BDD
$verification = $manager->verifieMot($formulaire);

if($verification == 0) { // Si le mot est déjà traduit / n'existe pas...
    $proposition_mot = 2;
} else { // Sinon
    // On écrit dans la BDD
    $manager->proposeMot($formulaire);
    // L'article vient d'être créé
    $proposition_mot = 1;
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
        <link rel="stylesheet" type="text/css" href="css/contribution.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Accueil</title>
    </head>

    <body>
        <!--Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre du contenu -->
            <h1 class="center-align">Contribution au dictionnaire</h1>
            <br>
            <?php
            // Si l'utilisateur est connecté et que la proposition de mot n'est pas encore faite
            if(isset($_SESSION['membre']) && $proposition_mot == 0) {
            ?>
            <div class="card-panel center-align">
                <h4 class="center align">Vous voulez participer à l'élaboration du dictionnaire Chaucyrio ?</h4>
            </div>

            <!--Formulaire-->
            <div class="row">
                <div class="card-panel col s6 offset-s3">
                    <br>
                    <form action="contribution.php" method="post">
                      <div class="row">
                        <!-- Section mot (Français) -->
                        <div class="input-field col s6">
                          <input placeholder="Enchanté" id="mot_fr" type="text" class="validate" name="mot">
                          <label for="first_name">VOTRE MOT FRANCAIS</label>
                      </div>
                      <!-- Section traduction (Chaucyrio) -->
                      <div class="input-field col s6">
                          <input placeholder="Goddhux" id="mot_chy" type="text" class="validate" name="traduction">
                          <label for="last_name">SA TRADUCTION</label>
                      </div>
                    </div>
                    <!-- Section catégorie -->
                    <div class="row">
                        <div class="input-field col s8 offset-s2">
                            <select name="cat_gram">
                                    <option value="" disabled selected>Catégorie grammaticale du mot (français)</option>
                                    <option value="nom">Nom</option>
                                    <option value="ver">Verbe</option>
                                    <option value="adj">Adjectif</option>
                                    <option value="conj">Conjonction</option>
                                    <option value="adv">Adverbe</option>
                                    <option value="ono">Onopatopée</option>
                                    <option value="det">Déterminant</option>
                                    <option value="pro">Pronom</option>
                                    <option value="pre">Préposition</option>
                                    <option value="int">Interjection</option>
                                    <option value="aux">Auxiliaire</option>
                                </select>
                                <label>Materialize Select</label>
                        </div>
                    </div>
                    <!-- Section commentaire -->
                    <div class="row">
                        <div class="input-field col s8 offset-s2">
                            <textarea placeholder="Je vous adore...<3" id="commentaire" class="materialize-textarea" name="commentaire" maxlenght="500"></textarea>
                            <label for="text">Précisions</label>
                        </div>
                    </div>
                    <br>
                    <!-- Bouton d'envoi -->
                    <div class="center-align">
                        <button class="waves-effect waves-orange darken-2 btn-flat large orange-text" type="submit" name="action">Envoyer votre proposition<i class="material-icons right">send</i></button>
                    </div>
                </form>
            </div>
        </div>
        <?php 
        }
        // Si l'usilisateur est connecté et que la proposition de mota été envoyée
        if(isset($_SESSION['membre']) && $proposition_mot == 1) {
        ?>
        <div class="row">
            <div class="col s8 offset-s2">
                <div class="card-panel">
                    <h4 class="center-align">Votre proposition a été envoyée !</h4>
                    <p class="center-align"><u>L'administration va considérer votre demande, peut-être que votre idée sera ajoutée au dictionnaire officiel !</u></p>
                    <br>
                    <h4 class="center-align"><u> Résumé :</u></h4>
                    <br>
                    <!-- Affichage du résultat à l'utilisateur -->
                    <div class="row"> 
                        <div class="col s6 offset-s3">
                            <b>Mot français :</b> <?php echo $formulaire['mot'] ?>
                            <br>
                            <b>Mot Chaucyrio (traduction) :</b> <?php echo $formulaire['traduction'] ?>
                            <br>
                            <!-- S'il a mis un commentaire -->
                            <?php if($formulaire['commentaire'] != "Je ne suis pas très bavard") { ?>
                            <b>Commentaire : </b> <?php echo $formulaire['commentaire'] ?>
                            <?php 
                            } else { // Sinon
                            ?>
                            <b>Commentaire : </b><i>Pas de commentaire</i>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <?php
        }
        ?>

        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>


        <!--Importation de JQuery avant materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
    </body>
</html>
