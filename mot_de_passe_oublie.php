<?php
// Gère les dépendances de la page
require_once('util/Require.php');




/*
*   FORMULAIRE [POST] - Mot de passe oublié
*/

// Valeurs nécessaires à la validation du formulaire
$formulaire = array(
    'email' => '',
    'email_confirm' => ''
);


// Booléens de vérification du formulaire
$formulaire_valide = false;     // Formulaire complet et valide
$formulaire_envoye = true;      // Données reçues en POST

$mot_de_passe_renvoye = -2;     // Indication d'action {-2 : pas de compte, -1 : à confirmer, > -1 : renvoyé}


// Vérification des données POST
if (!empty($_POST))
{
    // On vérifie que toutes les valeurs attendues soient bien reçues
    foreach ($formulaire as $key => $value)
    {
        // Si la clef n'est pas retrouvée
        if (!isset($_POST[$key]))
        {
            // On signale que le formulaire n'est pas complet
            $formulaire_envoye = false;
        }
        else
        {
            // On récupère la valeur
            $formulaire[$key] = $_POST[$key];
        }
    }


    // Si le formulaire est complet
    if ($formulaire_envoye)
    {
        /*
        *   TODO : REGEX
        */


        // Vérification de la non-correspondance des e-mails
        if (strcmp($formulaire['email'], $formulaire['email_confirm']) == 0)
        {
            // Le formulaire n'est pas valide
            $formulaire_valide = true;
        }


        // Si le formulaire est complet et valide
        if ($formulaire_valide)
        {
            $man = new ChaussureManager(TRUE);                                          // Connexion à la BDD
            $mot_de_passe_renvoye = $man->renvoie_mot_de_passe($formulaire['email']);   // Test de la combinaison reçue
        }
    }
    // Formulaire incomplet
    else
    {
        // Le formulaire n'est pas valide car incomplet
        $formulaire_valide = false;
    }
}
// Pas de données POST reçues
else
{
    // Formulaire incomplet et invalide par extension
    $formulaire_envoye = false;
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

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Mot de passe oublié</title>
    </head>



    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre du contenu -->
            <h1 class="center align">Mot de passe oublié</h1>


            <!-- Formulaire de renvoi de mot de passe -->
            <form id="formulaire" action="mot_de_passe_oublie.php" method="post">
                <!-- Message de réponse du formulaire -->
                <?php

                // Si le formulaire est complet
                if($formulaire_envoye)
                {
                    // Si le formulaire est valide
                    if($formulaire_valide)
                    {
                        // On teste le renvoi du MDP
                        switch($mot_de_passe_renvoye)
                        {
                            // Pas de compte associé à cet e-mail
                            case -2:
                                ?>

                                <div class="row">
                                    <div class="col s6 offset-s3 center-align">
                                        <!-- Titre de la carte -->
                                        <h4 class="header">Compte non existant</h4>
                                        

                                        <!-- Contenu de la carte -->
                                        <div class="card horizontal">
                                            <div class="card-stacked">
                                                <!-- Message d'informations -->
                                                <div class="card-content">
                                                    <p class="center-align">
                                                        Ce mail n'a pas l'air d'être associé à un compte.
                                                        <br /><br />
                                                        Vous pouvez vous inscrire afin de profiter au maximum des fonctionnalités du site.
                                                    </p>
                                                </div>


                                                <!-- Bouton d'action (inscription) -->
                                                <div class="card-action center-align">
                                                    <a href="inscription.php" class="btn waves-effect waves-light">
                                                        <i class="right material-icons">person_add</i>Je m'inscris !
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                break;


                            // Compte à confirmer
                            case -1:
                                ?>

                                <div class="row">
                                    <div class="col s6 offset-s3 center-align">
                                        <!-- Titre de la carte -->
                                        <h4 class="header">Compte à confirmer</h4>
                                        

                                        <!-- Contenu de la carte -->
                                        <div class="card horizontal">
                                            <div class="card-stacked">
                                                <!-- Message d'informations -->
                                                <div class="card-content">
                                                    <p class="center-align">
                                                        Votre compte n'a toujours pas été confirmé.
                                                        <br /><br />
                                                        Un mail de confirmation vous a été renvoyé, veillez à le valider afin de pouvoir utiliser votre compte.
                                                    </p>
                                                </div>


                                                <!-- Bouton d'action (boîte mail) -->
                                                <div class="card-action">
                                                    <!-- TODO : lien vers la boîte mail -->
                                                    <a href="#">Accéder à ma boîte mail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                break;


                            // Mot de passe renvoyé
                            default:
                                ?>

                                <div class="row">
                                    <div class="col s6 offset-s3 center-align">
                                        <!-- Titre de la carte -->
                                        <h4 class="header">Mot de passe renvoyé</h4>
                                        

                                        <!-- Contenu de la carte -->
                                        <div class="card horizontal">
                                            <div class="card-stacked">
                                                <!-- Message d'informations -->
                                                <div class="card-content">
                                                    <p class="center-align">
                                                        Pas de problème !
                                                        <br /><br />
                                                        Un mail vous a été envoyé afin de réinitialiser votre mot de passe.
                                                    </p>
                                                </div>


                                                <!-- Bouton d'action (boîte mail) -->
                                                <div class="card-action">
                                                    <!-- TODO : lien vers la boîte mail -->
                                                    <a href="#">Accéder à ma boîte mail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                break;
                        }
                    }
                    // Formulaire invalide
                    else
                    {
                        ?>

                        <div class="row">
                            <div class="col s6 offset-s3 center-align">
                                <!-- Titre de la carte -->
                                <h4 class="header">E-mails non conformes</h4>
                                

                                <!-- Contenu de la carte -->
                                <div class="card horizontal">
                                    <div class="card-stacked">
                                        <!-- Message d'informations -->
                                        <div class="card-content">
                                            <p class="center-align">
                                                Veillez à entrer deux fois un même e-mail conforme.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }

                ?>

                <!-- Email -->
                <div class="row">
                    <!-- Icône -->
                    <div class="input-field col s1 offset-s3 center-align"><i class="material-icons prefix">email</i></div>
                    

                    <!-- Champ "E-mail" -->
                    <div class="input-field col s4">
                        <input id="email" type="email" class="validate" name="email" <?php echo "value='" . $formulaire['email'] . "'"; ?> required /><label for="email">E-mail</label>
                    </div>
                </div>


                <!-- Confirmation Email -->
                <div class="row">
                    <!-- Icône -->
                    <div class="input-field col s1 offset-s3 center-align"><!--<i class="material-icons prefix">email</i>--></div>
                    

                    <!-- Champ confirmation "E-mail" -->
                    <div class="input-field col s4">
                        <input id="email" type="email" class="validate" name="email_confirm" required /><label for="email_confirm">Confirmation de l'e-mail</label>
                    </div>
                </div>

               
                <!-- Boutons -->
                <div class="row">
                    <!-- Bouton d'envoi -->
                    <div class="center-align">
                        <button class="btn waves-effect waves-light" type="submit" name="action"><i class="material-icons right">send</i>Renvoyer le mot de passe</button>
                    </div>


                    <!-- Bouton de connexion et d'inscription -->
                    <p class="center-align">
                        <br />
                        <a href="connexion.php">Je me souviens de mes identifiants</a>
                        <br /><br />
                        <a href="inscription.php">Je ne possède pas de compte</a>
                    </p>
                </div>
            </form>            
        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>



        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>


        <!--
            Script local
        -->

        <!-- Gestion formulaire -->
        <script type="text/javascript" src="js/form.js"></script>
    </body>
</html>