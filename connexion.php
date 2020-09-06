<?php
// Gère les dépendances de la page
require_once('util/Require.php');




/*
*   Vérification utilisateur
*/

// Si l'utilisateur est connecté
if (isset($_SESSION['membre']))
{
    header('Location: connexion.php');      // Redirection subite vers l'accueil
}




/*
*   FORMULAIRE [POST] - Mot de passe oublié
*/

// Valeurs nécessaires à la validation du formulaire
$formulaire = array(
    'email' => '',
    'mot_de_passe' => ''
);


// Booléens de vérification du formulaire
$formulaire_valide = false;     // Formulaire complet et valide
$formulaire_envoye = true;      // Données reçues en POST

$pas_de_correspondance = true; // Indication d'action {true : combinaison non trouvée, false : combinaison existante}
$email_non_confirme = false; // Indication d'action {true : email à confirmer, false : compte confirmé}


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



        // On hash le mot de passe
        $formulaire['mot_de_passe'] = sha1($formulaire['mot_de_passe']);

        // Connexion à la BDD
        $man = new ChaussureManager(TRUE);


        // Si la connexion est possible, on valide la connexion
        switch ($man->connexion_membre($formulaire['email'], $formulaire['mot_de_passe']))
        {
            // Utilisateur trouvé, connexion réussie
            case 1:
                $formulaire_valide = true;
                $pas_de_correspondance = false;
                $email_non_confirme = false;
                
                // On redirige au bout de 5 secondes
                header("Refresh:5; url=index.php");
                break;
            

            // Utilisateur trouvé, mais l'e-mail n'a pas été confirmé
            case 2: 
                $pas_de_correspondance = false;
                $email_non_confirme = true;
                break;


            // Utilisateur non trouvé, pas de correspondance pour le couple (email/mot de passe)
            default: 
                $pas_de_correspondance = true;
                $email_non_confirme = false;
                break;
        }
    }
    // Formulaire incomplet
    else
    {
        $pas_de_correspondance = false;
    }
}
// Formulaire incomplet
else
{
    $formulaire_envoye = false;
    $pas_de_correspondance = false;
}



/*
*   Vérification inscription
*/

// Si l'on reçoit un paramètre depuis la page d'inscription
if (isset($_POST['auto_email']))
{
    $formulaire['email'] = $_POST['auto_email'];
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
        <title>Académie Chaucyrienne > Connexion</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre du contenu -->
            <h1 class="center align">Connexion</h1>


            <?php

            // Si invalide
            if (!$formulaire_valide)
            {
                ?>

                <div class="row">
                    <!-- Vérification mail et mot de passe (retour formulaire) -->

                    <?php

                    // Si le formulaire est complet
                    if ($formulaire_envoye)
                    {
                        // Si la combinaison n'a pas de résultat
                        if ($pas_de_correspondance)
                        {
                            ?>

                            <div class="row">
                                <div class="col s6 offset-s3 center-align">
                                    <!-- Carte -->
                                    <div class="card horizontal">
                                        <div class="card-stacked">
                                            <!-- Contenu de la carte -->
                                            <div class="card-content">
                                                <p class="center-align">
                                                    Ce couple e-mail/mot de passe ne renvoie aucun résultat
                                                </p>
                                            </div>

                                            <!-- Action de la carte -->
                                            <div class="card-action">
                                                <a href="mot_de_passe_oublie.php">J'ai oublié mes identifiants</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        // Si l'e-mail n'a pas été confirmé
                        else if ($email_non_confirme)
                        {
                            ?>

                            <div class="row">
                                <div class="col s6 offset-s3 center-align">
                                    <!-- Carte -->
                                    <div class="card horizontal">
                                        <div class="card-stacked">
                                            <!-- Contenu de la carte -->
                                            <div class="card-content">
                                                <p class="center-align">
                                                    Votre compte n'a pas encore été confirmé !
                                                    <br /><br />
                                                    Merci de valider celui-ci par mail afin de pouvoir vous connecter.
                                                </p>
                                            </div>

                                            <!-- Action de la carte -->
                                            <div class="card-action">
                                                <a href="mot_de_passe_oublie.php">Vous n'avez pas reçu de mail ?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    
                    ?>


                    <!-- Formulaire de connexion -->
                    <form class="col s12" action="connexion.php" method="post">
                        <!-- E-mail -->
                        <div class="row">
                            <!-- Icône -->
                            <div class="input-field col s1 offset-s3 center-align"><i class="material-icons prefix">email</i></div>
                            

                            <!-- Champ "E-mail" -->
                            <div class="input-field col s4">
                                <input id="email" type="email" class="validate" name="email" <?php echo "value='" . $formulaire['email'] . "'"; ?> required /><label for="email">E-mail</label>
                            </div>
                        </div>


                        <!-- Mot de passe -->
                        <div class="row">
                            <!-- Icône -->
                            <div class="input-field col s1 offset-s3 center-align"><i class="material-icons prefix">vpn_key</i></div>
                            

                            <!-- Champ "Mot de passe" -->
                            <div class="input-field col s4">
                                <input id="password" type="password" class="validate" name="mot_de_passe"><label for="mot_de_passe">Mot de passe</label>
                            </div>
                        </div>

                       
                        <!-- Boutons -->
                        <div class="row">
                            <!-- Bouton d'envoi -->
                            <div class="center-align">
                                 <!--Bouton à desactiver par défaut via JS <DEV>-->
                                <button class="btn waves-effect waves-light" type="submit" name="action">Connexion<i class="material-icons right">send</i></button>
                            </div>


                            <!-- Bouton "Je n'ai pas de compte" -->
                            <p class="center-align">
                                <br />
                                <a href="mot_de_passe_oublie.php">Mot de passe oublié ?</a>
                                <br /><br />
                                <a href="inscription.php">Je ne possède pas de compte</a>
                            </p>
                        </div>
                    </form>
                </div>
                
                <?php
            }
            // Si le formulaire est complet et valide
            else
            {
                ?>

                <div class="row">
                    <div class="col s12 center-align">
                        <p>
                            Bienvenue <?php echo $_SESSION['membre']->prenom(); ?>.
                            <div class="progress col s6 offset-s3">
                                <div class="indeterminate"></div>
                            </div>
                            <br><br>
                            <a href="index.php">Si vous n'êtes pas redirigé d'ici 5 secondes, cliquez ici</a>.
                        </p>
                    </div>
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


        <!--
            Script local
        -->

        <!-- Gestion du formulaire -->
        <script type="text/javascript" src="js/form.js"></script>
    </body>
</html>