<?php
// Gère les dépendances de la page
require_once('util/Require.php');




// Si le panier est vide
if (!isset($_SESSION['panier']) || !is_a($_SESSION['panier'], 'Panier') || $_SESSION['panier']->est_vide())
{
    header('Location: boutique.php');      // Redirection subite vers la boutique
}




/*
*   FORMULAIRE [POST] - Paiement
*/


// Booléens de vérification du formulaire
$formulaire_valide = false;     // Formulaire complet et valide
$formulaire_envoye = false;      // Données reçues en POST


// Vérification des données POST
if (!empty($_POST))
{
    $formulaire_envoye = true;

    // Si le formulaire est complet
    if ($formulaire_envoye)
    {
        /*
        *   TODO : REGEX
        */


        // Connexion à la BDD
        $man = new ChaussureManager(TRUE);

        // On enregistre la commande en récupérant le numéro de celle-ci
        $numero_commande = $man->ajoute_commande($_SESSION['panier']->affiche());

        // On supprime le panier maintenant
        unset($_SESSION['panier']);


        // Préparation du mail récaputilatif de la commande effectuée
        $destinataire = $_SESSION['membre']->email();
        $sujet = "[Académie CHY] Récapitulatif de la commande n°" . $numero_commande;
        // TODO : récapitulatif complet de la commande
        $message = "<html><body>Merci de votre commande !</body></html>";

        // Envoi du mail
        envoyer_mail($destinataire, $sujet, $message);


        // Le formulaire est validé
        $formulaire_valide = true;
    }
    // Formulaire incomplet
    else
    {
        $formulaire_valide = false;
    }
}
// Formulaire incomplet
else
{
    $formulaire_envoye = false;
    $pas_de_correspondance = false;
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
        <title>Académie Chaucyrienne > Paiement</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre de contenu -->
            <h1 class="center align">Formulaire de paiement</h1>


            <?php

            // Si le formulaire a été envoyé et est complet et valide
            if ($formulaire_valide)
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
                                        <?php echo 'Votre commande n°' . $numero_commande . ' a été confirmée !'; ?>
                                        <br />
                                        <br />
                                        Vous recevrez un récapitulatif de celle-ci par e-mail.
                                    </p>
                                </div>

                                <!-- Action de la carte -->
                                <div class="card-action">
                                    <a href="membre.php">Accéder à mon profil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
            // Si le formulaire n'est pas complet ou valide
            else
            {
                ?>

                <!-- Ligne d'affichage du panier -->
                <div class="row">
                    <div class="col s8 offset-s2">
                        <div class="card-panel center">
                            <!-- Titre du formulaire -->
                            <h3 class="center-align sous_titre">Vos articles</h3>
                            

                            <!-- Nouvelle ligne -->
                            <div class="row center">
                                <!-- Nom du produit -->
                                <div class="col s5 offset-s1"><b>Nom du produit</b></div>
                                <!-- Prix unitaire du produit -->
                                <div class="col s2"><b>Prix unitaire</b></div>
                                <!-- Quantité du produit -->
                                <div class="col s1"><b>Quantité</b></div>
                                <!-- Prix total du produit -->
                                <div class="col s2"><b>Prix</b></div>
                            </div>


                            <?php
                            // On récupère les articles du panier
                            $panier = $_SESSION['panier']->affiche();

                            // Somme des prix
                            $somme = 0;

                            // On parcourt les articles
                            foreach ($panier as $key => $value)
                            {
                                $somme += $value->prix();
                                ?>

                                <!-- Nouvelle ligne du produit -->
                                <div class="row center">
                                    <!-- Nom du produit -->
                                    <div class="col s5 offset-s1"><?php echo $value->nom(); ?></div>
                                    <!-- Prix unitaire du produit -->
                                    <div class="col s2"><?php echo $value->prix_unitaire(); ?> €</div>
                                    <!-- Quantité du produit -->
                                    <div class="col s1"><?php echo $value->quantite(); ?></div>
                                    <!-- Prix total du produit -->
                                    <div class="col s2"><?php echo $value->prix(); ?> €</div>
                                </div>

                                <?php
                            }

                            ?>

                            <!-- Prix total -->
                            <div class="row center">
                                <b>Prix total : </b>

                                <?php

                                echo $somme . ' €';

                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Ligne d'affichage du formulaire -->
                <div class="row">
                    <div class="col s8 offset-s2">
                        <div class="card-panel center">
                            
                            <?php
                            // Si l'utilisateur n'est pas connecté, on lui indique
                            if (!isset($_SESSION['membre']) || $_SESSION['membre']->email() == null)
                            {
                                ?>

                                <h4>Merci de vous connecter pour continuer votre commande</h4>

                                <?php
                            }
                            else
                            {
                                ?>

                                <form method="post" action="paiement.php">
                                    <!-- Titre du formulaire -->
                                    <h3 class="center-align sous_titre">Informations de livraison</h3>


                                    <!-- Nom et prénom -->
                                    <div class="row">
                                        <!-- Icône -->
                                        <div class="input-field col s1 offset-s2 center-align"><i class="material-icons prefix">account_circle</i></div>


                                        <!-- Champ "Prénom" -->
                                        <div class="input-field col s3">
                                            <?php echo $_SESSION['membre']->prenom() ?>
                                        </div>

                                        <!-- Champ "Nom" -->
                                        <div class="input-field col s3">
                                            <?php echo $_SESSION['membre']->nom() ?>
                                        </div>
                                    </div>


                                    <!-- Pays et ville -->
                                    <div class = "row">
                                        <!-- Icône -->
                                        <div class="input-field col s1 offset-s2 center-align"><i class="material-icons prefix">public</i></div>


                                        <!-- Champ "Pays" -->
                                        <div class="input-field col s3">
                                            <?php echo $_SESSION['membre']->pays() ?>        
                                        </div>

                                        <!-- Champ "Ville" -->
                                        <div class="input-field col s3">
                                            <?php echo $_SESSION['membre']->ville() ?>
                                        </div>
                                    </div>


                                    <!-- Adresse et code postal -->
                                    <div class = "row">
                                        <!-- Icône -->
                                        <div class="input-field col s1 offset-s2 center-align"><i class="material-icons prefix">location_city</i></div>


                                        <!-- Champ "Adresse" -->
                                        <div class="input-field col s3">
                                            <?php echo $_SESSION['membre']->ville() ?>
                                        </div>

                                        <!-- Champ "Code postal" -->
                                        <div class="input-field col s3">
                                            <?php echo $_SESSION['membre']->ville() ?>
                                        </div>
                                    </div>


                                    <!-- Numéro de téléphone -->
                                    <div class="row">
                                        <!-- Icône -->
                                        <div class="input-field col s1  offset-s2 center-align"><i class="material-icons prefix">contact_phone</i></div>


                                        <?php echo $_SESSION['membre']->numero_telephone() ?>
                                    </div>


                                    <!-- Bouton d'action du formulaire (validation de la commande) -->
                                    <button class="btn waves-effect waves-light" type="submit" name="action" value="finalisation_achat">Confirmer l'achat</button>
                                </form>

                                <?php
                            }
                            ?>
                        </div>
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

        <!-- Gestion du bouton d'envoi -->
        <script type="text/javascript" src="js/form.js"></script>
    </body>
</html>