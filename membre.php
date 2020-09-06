<?php
// Gère les dépendances de la page
require_once('util/Require.php');




/*
*   Vérification utilisateur
*/

// Si l'utilisateur n'est pas connecté
if (!isset($_SESSION['membre']))
{
    // Redirection vers la page de connexion
    header('Location: connexion.php');
}


// Connexion à la BDD
$man = new ChaussureManager(true);



/*
*   Image de profil [POST]
*/

$formulaire_fichier = true;
if (isset($_FILES['avatar_upload']))
{
    if (!isset($_FILES['avatar_upload']) || $_FILES['avatar_upload']['error'] != 4)
    {
        $formulaire_fichier = modifie_avatar_membre($_SESSION['membre']->id(), $_FILES['avatar_upload'], 1000000);
    }
}


/*
*   Formulaire Coordonnées [POST]
*/

$formulaire = array(
    'adresse' => '',
    'code_postal' => '',
    'ville' => '',
    'pays' => ''
);

// Booléens de vérification du formulaire
$formulaire_valide = false;     // Formulaire complet et valide
$formulaire_envoye = true;      // Données reçues en POST

$code_postal_valide = false;    // Code postal est valide


// Vérification des données POST
if (!empty($_POST))
{
    // On vérifie que toutes les valeurs attendues soient bien reçues
    foreach ($formulaire as $key => $value)
    {
        // Si la clef n'est pas retrouvée
        if (!isset($_POST[$key]) || $_POST[$key] == '')
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


        // On vérifie le code postal
        /*if (strcmp($formulaire['email'], $formulaire['email_confirm']) == 0)
        {
            $email_valide = true;
        }*/


        // Si tous les champs sont valides, on procède aux dernières vérifications
        if (true)
        {
            $formulaire['id_membre'] = $_SESSION['membre']->id();   // On rajoute l'id du membre
            $man = new ChaussureManager(TRUE);                      // Connexion à la BDD

            $man->modifie_membre($formulaire);                      // Modification du membre

            $formulaire_valide = true;
        }
        // Si les champs ne sont pas valides
        else
        {
            $formulaire_valide = false;
        }
    }
    // Si le formulaire n'est pas complet
    else
    {
        $formulaire_valide = false;
        $formulaire_envoye = false;
    }
}
// Si le formulaire n'a pas été transmis
else {
    $formulaire_valide = false;
    $formulaire_envoye = false;
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
        <link rel="stylesheet" type="text/css" href="css/membre.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Interface membre</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>

        
        <!--Main-->
        <main>
            <!-- Informations du membre -->
            <div class="row">
                <div class="col s8 offset-s2">
                    <div class="card-panel center">
                        <!-- Profil -->
                        <div class="row valign-wrapper">
                            <!-- Photo du membre -->
                            <div class="col s4">
                                <?php

                                $avatar = avatar_membre($_SESSION['membre']->id());

                                ?>
                                <img <?php echo 'src="'.$avatar.'?='.time().'"' ?> class="avatar" alt="Avatar" />
                            </div>

                            <div class="col s8 center-align">
                                <!-- Nom du membre -->
                                <h2 class="">
                                    <?php
                                    echo $_SESSION['membre']->prenom() . ' ' . $_SESSION['membre']->nom();
                                    ?>
                                </h2>

                                <span id="role_membre">
                                    <i>
                                        <?php

                                        $roles = array(0 => 'Membre', 1 => 'Administrateur');
                                        $role_membre = $_SESSION['membre']->role();

                                        echo (isset($roles[$role_membre]) ? $roles[$role_membre] : 'Membre')

                                        ?>
                                    </i>
                                </span>
                            </div>
                        </div>


                        <!-- Séparateur -->
                        <br /><hr />


                        <!-- Informations de livraison -->
                        <div class="row">
                            <form action="membre.php" method="post" enctype="multipart/form-data">
                                <!-- Titre de la section -->
                                <h4>Vos coordonnées</h4>


                                <!-- Avatar du membre -->
                                <label for="avatar_upload">Avatar</label>
                                <br />
                                <input type="file" name="avatar_upload" id="avatar_upload" /><br />
                                <label for="avatar_upload">Format PNG/JPG/JPEG. Limite de taille : 1 Mo.</label>


                                <!-- Adresse et Code postal-->
                                <div class="row input-field">
                                    <!-- Icône -->
                                    <div class="col s1 offset-s1 input-field">
                                        <i class="material-icons prefix">location_city</i>
                                    </div>


                                    <!-- Champ de saisie Adresse -->
                                    <div class="col s6 input-field">
                                        <input type="text" id="adresse" name="adresse" class="validate" <?php echo 'value="'.$_SESSION['membre']->adresse().'"'; ?> required />
                                        <label for="adresse">Adresse</label>
                                    </div>


                                    <!-- Champ de saisie Code postal-->
                                    <div class="col s3 input-field">
                                        <input type="text" id="code_postal" name="code_postal" class="validate" <?php echo 'value="'.$_SESSION['membre']->code_postal().'"'; ?> required />
                                        <label for="code_postal">Code postal</label>
                                    </div>
                                </div>


                                <!-- Ville et Pays-->
                                <div class="row">
                                    <!-- Icône -->
                                    <div class="col s1 offset-s1 input-field">
                                        <i class="material-icons prefix">public</i>
                                    </div>


                                    <!-- Champ de saisie Ville -->
                                    <div class="col s6 input-field">
                                        <input type="text" id="ville" name="ville" class="validate" <?php echo 'value="'.$_SESSION['membre']->ville().'"'; ?> required />
                                        <label for="ville">Ville</label>
                                    </div>


                                    <!-- Champ de saisie Pays -->
                                    <div class="col s3 input-field">
                                        <select id="pays" name="pays" required>
                                            <option value="" disabled>Choisissez votre pays</option>

                                            <?php

                                            // Affiche la liste des pays (et re-sélectionne lors d'une erreur formulaire)
                                            $liste_pays = array("France", "Suisse", "Belgique", "Québec");

                                            foreach ($liste_pays as $value)
                                            {
                                                echo '<option value="' . $value . '" ' . (($value == $_SESSION['membre']->pays() ? 'selected' : '')) .'>' . $value . '</option>';
                                            }

                                            ?>
                                        </select>

                                        <label for="pays">Pays</label>
                                    </div>
                                </div>


                                <!-- Bouton d'envoi du formulaire -->
                                <button type="submit" name="action" value="modifier_infos" class="btn waves-effect waves-light">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Historique des commandes -->
            <div class="row">
                <div class="col s8 offset-s2">
                    <div class="card-panel center">
                        <!-- Titre de la carte -->
                        <h2 class="center-align sous_titre">
                            Historique des commandes
                        </h2>


                        <!-- Contenu de la carte -->
                        <?php

                        // On récupère la liste des commandes
                        $historique = $man->historique_commandes($_SESSION['membre']->id());

                        // Si aucune commande n'a été passée
                        if (empty($historique))
                        {
                            // On l'indique
                            echo "Vous n'avez pas encore effectué de commandes<br /><br />";
                        }
                        // Si l'historique existe
                        else {
                            ?>

                            <ul class="collapsible" data-collapsible="accordion">
                                <?php

                                // On parcourt la liste des commandes
                                foreach ($historique as $key => $value)
                                {
                                    // On récupère le contenu de la commande
                                    $commande = $man->recupere_commande($value['id_commande']);
                                    ?>

                                    <li>
                                        <div class="collapsible-header">
                                            <i class="collapsible-chevron material-icons">expand_more</i>
                                            
                                            <?php
                                            echo 'Commande n°' . sprintf('%04d', $value['id_commande']) . ' | ' . $value['nom_etat_commande'];
                                            ?>

                                            <span class="right"><?php echo $value['prix_commande'] . ' € | ' . $value['date_commande']; ?></span>
                                        </div>

                                        <div class="collapsible-body">
                                            <span>
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

                                                // On parcourt la liste des items
                                                foreach ($commande as $key2 => $value2)
                                                {
                                                    $item = new Item($value2);
                                                    ?>

                                                    <!-- Nouvelle ligne du produit -->
                                                    <div class="row center">
                                                        <!-- Nom du produit -->
                                                        <div class="col s5 offset-s1"><?php echo $item->nom(); ?></div>
                                                        <!-- Prix unitaire du produit -->
                                                        <div class="col s2"><?php echo $item->prix_unitaire(); ?> €</div>
                                                        <!-- Quantité du produit -->
                                                        <div class="col s1"><?php echo $item->quantite(); ?></div>
                                                        <!-- Prix total du produit -->
                                                        <div class="col s2"><?php echo $item->prix(); ?> €</div>
                                                    </div>

                                                    <?php
                                                }

                                                ?>

                                            </span>
                                        </div>
                                    </li>

                                    <?php
                                }

                                ?>
                            </ul>

                            <?php
                        }

                        ?>

                        <a href="boutique.php"><button type="button" class="btn waves-effect waves-light">Accéder à la boutique</button></a>
                    </div>
                </div>
            </div>
        </main>

        
        <!--Footer-->
        <?php include('include/footer.php'); ?>

        

        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>


        <!--
            Script local
        -->

        <!-- Événements du collapsible -->
        <script type="text/javascript" src="js/collapsible.js"></script>
        <!-- Événements du formulaire -->
        <script type="text/javascript" src="js/form.js"></script>
    </body>
</html>