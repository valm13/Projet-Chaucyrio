<?php
// On inclue les classes nécessaires
require_once('util/Require.php');


/*
* Formulaire de contact
*/

// Tableau de retour du formulaire
$values = array(
    'nom' => '',
    'email_contact' => '',
    'sujet' => '',
    'texte' => ''
);

// Booléens de validation du formulaire
$formulaire_envoye = false; // Le formulaire a bien été envoyé, et le message est bien dans la BDD
$formulaire_valide = true; // Formulaire complet et valide
$message_envoye = false; // Le message a été envoyé au site


// Si le formulaire a bien été transmis en POST à la page
if(!empty($_POST)) {
    // On vérifie que toutes les valeurs ont bien été reçues
    foreach($values as $key => $value) {
        if(!isset($_POST[$key])) {
            // Si la valeur de la clé n'a pas été passée
            $formulaire_valide = false;
            // echo "Probleme avec l'input : ".$key."";
        } else {
            // Sinon on récupère la valeur
            $values[$key] = $_POST[$key];
        }
    }
    $values['texte'] = nl2br($values['texte']); // nl2br pour avoir les sauts de ligne  

    // Si le formulaire est complet
    if($formulaire_valide) {
        // On créer un message (mp) que l'admin pourra lire, et répondre par e-mail     DONE
        // Affichage du message envoyé                                                  DONE
        // Envoi d'un email du serveur : Votre demande de contact a bien été enregistrer et sera traitée dans les jours qui suivent
        // Ajout d'un Captcha pour ne pas spammer

        // Objet ChaussureManager (BDD)
        $manager = new ChaussureManager(true);  // On connecte le gérant de chaussures à la BDD


        // Filtrage des valeurs du tableau : éviter les injections SQL


        //  Vérification de l'email
        if(!filter_var($values['email_contact'], FILTER_VALIDATE_EMAIL)){
            echo 'email invalide';
            $formulaire_valide = false;
        }
        //  Vérification du nom
        if(!preg_match("/^[a-zA-Z ]*$/",$values['nom'])){
            echo 'nom invalide, seul les lettres sont autorisées';
            $formulaire_valide = false;
        }

        // On ajoute l'ip de l'utilisateur dans les values

        $values['ip'] = get_ip();

        // On créer le message dans la BDD

        $manager->enregistreMessage($values);

        $message_envoye = true;
    }
} 
else {
    $formulaire_valide = false;
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
        <link rel="stylesheet" type="text/css" href="css/contact.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Contact</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>

        
        <!--Main-->
        <main>
            <!-- Titre du contenu -->
            <h1 class="center align">Contact</h1>

            <!-- Contenu -->
            <div class="row">
                <div class="col s12">
                    <!-- Colonne gauche -->
                    <div class="col s5 offset-s1">
                        <!-- Panneau d'informations -->
                        <div class="card-panel hoverable col s12">
                            <!-- Carte -->
                            <div class="card-content light black-text center-align">
                                <span class="card-title center-align"><h3>À propos</h3></span>
                              
                                <p>Chaucyrio.fr a été créé par les développeurs suivant :</p>

                                <ul>
                                    <li><b>Valentin MAGNAN</b></li>
                                    <li><b>Elio BILISARI</b></li>
                                    <li><b>Antoine SINI</b></li>
                                    <li><b>Mayeul MARSAUT</b></li>
                                </ul>

                                <p>Dans le cadre d'un mini projet de développement Web à l'<b>ISEN Toulon</b> en CIR2</p>
                            </div>
                        </div>
                    
                        <div class="card-panel hoverable col s12">
                            <!-- Icône -->
                            <div class="col s12 center-align">
                                <i class="medium material-icons">info_outline</i>
                            </div>
                        
                            <!-- Contenu promo -->
                            <div class="col s12 light">
                                <!-- Nouveau paragraphe -->
                                <h6 class="promo caption"><b>Objectif :</b></h6>

                                <p class="light center">
                                    L'objectif du projet est de créer un site web dynamique, dôté d'une base de donnée, d'une gestion de connexion, tout en utilisant <i>materialize</i> ou <i>bootstrap</i>.
                                </p>


                                <!-- Nouveau paragraphe -->
                                <h6 class="promo caption" ><b>Présentation du site :</b></h6>

                                <p class="light center">
                                    Le site a pour but de parler et d'améliorer la nouvelle langue que nous avons inventée, le <b>Chaucyrio.</b>
                                </p>

                                <!-- Nouveau paragraphe -->
                                <h6 class="promo caption"><b>Chaucyrio.fr sera donc composé :</b></h6>

                                <ul class="light">
                                    <li >- d'un <b>Blog</b> composé d'article publiés par les utilisateurs et validés par les administrateurs</li>
                                    <li>- d'un <b>Dictionnaire</b> de tous les mots de la langue</li>
                                    <li>- d'une <b>Boutique</b> où l'on pourra acheter de nombreux articles</li>
                                    <li>- d'un <b>T'chat</b> pour discuter avec les membres du site</li>
                                    <li>- d'une page de <b>Contact</b> sur laquelle vous êtes actuellement</li>
                                    <li>- d'une page d' <b>Inscription</b></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="col s5">
                        <!-- Carte -->
                        <div class="card-panel hoverable col s12">
                            <!-- Contenu de la carte -->
                            <div class="card-content light black-text">
                                <?php
                                // Si le message est envoyé on n'affiche plus le formulaire
                                if(!$message_envoye) {
                                ?>
                                    <!-- Titre de la carte -->
                                    <span class="card-title center-align"><h3>Nous contacter</h3></span>


                                    <!-- Formulaire -->
                                    <form action="contact.php" method="post">
                                        <!-- Vérification mail et mot de passe (retour formulaire) -->

                                        <!-- Nom -->
                                        <div class="row">
                                            <!-- Icône -->
                                            <div class="input-field col s1"><i class="material-icons prefix">account_circle</i></div>

                                            <!-- Champ "Nom" -->
                                            <div class="input-field col s9 offset-s1">
                                                <input id="nom" type="text" class="validate tooltipped" name="nom" maxlength="40" data-length="40" data-position="right" data-delay="50" data-tooltip="Caracères alphabétiques" required/>
                                                <label for="nom">Nom</label>
                                            </div>
                                        </div>

                                        <!-- Mail -->
                                        <div class="row">
                                            <!-- Icône -->
                                            <div class="input-field col s1"><i class="material-icons prefix">mail</i></div>

                                            <!-- Champ "Mail" -->
                                            <div class="input-field col s9 offset-s1">
                                                <input id="email_contact" type="email" class="validate tooltipped" name="email_contact" data-position="right" data-delay="50" data-tooltip="Nom@domaine.com" required/>
                                                <label for="email_contact">Mail</label>
                                            </div>
                                        </div>

                                        <!-- Sujet -->
                                        <div class="row">
                                            <!-- Icône -->
                                            <div class="input-field col s1"><i class="material-icons prefix">subject</i></div>

                                            <!-- Champ "Sujet" -->
                                            <div class="input-field col s9 offset-s1">
                                                <input id="sujet" type="text" class="validate" name="sujet" maxlength="40" data-length="40" required />
                                                <label for="sujet">Sujet</label>
                                            </div>
                                        </div>

                                        <!-- Message -->
                                        <div class="row">
                                            <!-- Icône -->
                                            <div class="input-field col s1"><i class="material-icons prefix">textsms</i></div>

                                            <!-- Champ "Message" -->
                                            <div class="input-field col s9 offset-s1">
                                              <textarea id="texte" class="materialize-textarea" name="texte" maxlength="350" data-length="350" required></textarea>
                                              <label for="texte">Message</label>
                                            </div>
                                        </div>

                                        <!-- Boutons de formulaire -->
                                        <div class="row">
                                            <div class="col s12 center-align">
                                                <!--Bouton à desactiver par défaut via JS (DEV)-->
                                                <!-- Bouton d'envoi -->
                                                <button class="btn waves-effect waves-light" type="submit" name="action">Envoyer<i class="material-icons right">send</i></button>

                                                <!-- Bouton "Effacer" -->
                                                <button class="btn waves-effect waves-light" type="reset" name="action">Effacer<i class="material-icons right">backspace</i></button>
                                            </div>
                                        </div>
                                    </form>
                                <?php 
                                }
                                // Sinon on affiche le message envoyé
                                else {
                                ?>
                                    <!-- Titre de la carte -->
                                    <span class="card-title center-align"><h3>Demande envoyée</h3></span>
                                
                                    <p>Bonjour <?php echo $values['nom']?>, votre demande de contact a bien été envoyée !</p>
                                    
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>

        
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>

        <!-- Script du contact -->
        <script type="text/javascript" src="js/contact.js"></script>
    </body>
</html>
