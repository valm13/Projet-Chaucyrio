<?php
// Gère les dépendances de la page
require_once('util/Require.php');




// Connexion à la BDD
$man = new ChaussureManager(TRUE);


/*
*   GESTION PANIER
*/

// Si le panier n'est pas défini pour cette session
if (!isset($_SESSION['panier']) || is_null($_SESSION['panier']) || !is_a($_SESSION['panier'], 'Panier'))
{
    $_SESSION['panier'] = new Panier();             // On déclare un nouveau panier
}


// Affiche lr prix total du panier
function html_prix_panier()
{
    $panier = $_SESSION['panier']->affiche();
    $prix = 0;

    // On calcule le prix final
    foreach($panier as $key => $value)
    {
        $prix += $value->prix();
    }

    echo $prix . ' €';
}


// TODO : désactiver les boutons si panier vide (et JS activé)
// Affiche le panier de manière formatée
function html_affiche_panier()
{
    $panier = $_SESSION['panier']->affiche();


    // Si le panier n'est pas vide
    if (!$_SESSION['panier']->est_vide())
    {
        ?>
        
        <form id="form_panier" method="post" action="boutique.php">
            <!-- Titre de la carte -->
            <h3 class="sous_titre">Votre panier</h3>
                                
            <!-- Séparateur -->
            <hr /><br />

            <!-- Nouvelle ligne -->
            <div class="row center">
                <!-- Nom du produit -->
                <div class="col s5"><b>Nom du produit</b></div>
                <!-- Prix unitaire du produit -->
                <div class="col s2"><b>Prix unitaire</b></div>
                <!-- Quantité du produit -->
                <div class="col s1"><b>Quantité</b></div>
                <!-- Prix total du produit -->
                <div class="col s2"><b>Prix</b></div>
                <!-- Produit à supprimer -->
                <div class="col s2"><b>À supprimer</b></div>


                <!-- Séparation -->
                <br /><br />


                <?php

                // On parcourt le panier
                foreach ($panier as $key => $value)
                {
                    ?>

                    <!-- Produit sur une nouvelle ligne -->
                    <div class="row">
                        <!-- Nom du produit -->
                        <div class="col s5">
                            <label class="normal_label" <?php echo 'for="num_id_item_'.$value->id().'"'; ?>><?php echo $value->nom(); ?></label>
                        </div>

                        <!-- Prix du produit -->
                        <div class="col s2">
                            <?php echo '<span id="prix_unitaire_id_item_'. $value->id() .'">' . $value->prix_unitaire() . '</span> €'; ?>
                        </div>

                        <!-- Quantité du produit -->
                        <div class="col s1 quantite">
                            <input type="number" min="0" <?php echo 'max="'.$value->stock().'" value="'.$value->quantite().'" name="num_id_item_'.$value->id().'" id="num_id_item_'.$value->id().'"'; ?> />
                        </div>

                        <!-- Prix du produit -->
                        <div class="col s2">
                            <?php echo '<span id="prix_id_item_' . $value->id() .'">' . $value->prix() . '</span> €'; ?>
                        </div>

                        <!-- Produit à supprimer -->
                        <div class="col s2">
                            <!-- Case à cocher -->
                            <input type="checkbox" <?php echo 'id="box_id_item_'.$value->id().'"' . ' name="box_id_item_'.$value->id().'"' ?> />
                            <!-- ! Label obligatoire (Materialize) -->
                            <label class="a_supprimer" <?php echo 'for="box_id_item_'.$value->id().'"' ?> ></label>
                        </div>
                    </div>

                    <?php
                }

                ?>

            </div>


            <!-- Séparateur -->
            <hr /><br />


            <!-- Bouton "modifier_items" -->
            <button type="submit" id="btn_modifier_items" class="btn waves-effect waves-light" name="action" value="modifier_items">
                Modifier
                <i class="material-icons right">edit</i>
            </button>

            <!-- Bouton "supprimer-item" -->
            <button type="submit" id="btn_supprimer_item" class="btn small waves-effect waves-light" name="action" value="supprimer_item">
                Supprimer
                <i class="material-icons right">remove_shopping_cart</i>
            </button>

            <!-- Nouvelle ligne -->
            <br /><br />

            <div class="center">
                Prix final : <span id="prix_panier"><?php echo html_prix_panier(); ?></span>
            </div>

            <!-- Bouton "acheter_items" -->
            <button type="submit" id="btn_acheter_items" class="btn waves-effect waves-light" name="action" value="acheter_items">
                Passer en caisse
                <i class="material-icons right">shopping_cart</i>
            </button>
        </form>

        <?php
    }
    // Si le panier est vide
    else
    {
        ?>

        <!-- Titre de la carte -->
        <form id="form_panier" method="post" action="boutique.php">
            <h3 class="sous_titre">Votre panier est vide</h3>
        </form>

        <?php
    }
}





/*
*   GESTION BOUTIQUE
*/

// Affiche la boutique de manière formatée
function html_affiche_boutique(array $items, $tri, $ordre)
{
    ?>
    
    <div id="boutique">
        <!-- Système de pagination de la boutique (caractère de tri) -->
        <ul class="pagination center">

            <?php

            // Les différents tris
            $pagination = array('ID' => 'id_item', 'Nom' => 'nom_item', 'Description' => 'description_item', 'Stock' => 'stock');


            // Chevron gauche
            echo '<li class="pagination_boutique ' . ($tri == reset($pagination) ? 'disabled' : 'waves-effect') . '">';
            // On récupère la clef précédent l'actuelle
            while (!is_null(current($pagination)) && current($pagination) != $tri)
            {
                next($pagination);
            }
            echo '<a href="boutique.php?tri=' . prev($pagination) . '&ordre='.$ordre.'">';
            echo '<i class="material-icons">chevron_left</i></a></li>';


            // Les autres paginations
            foreach ($pagination as $key => $value)
            {
                echo '<li class="pagination_boutique ' . ($tri == $value ? 'active' : 'waves-effect') . '">';
                echo '<a href="boutique.php?tri=' . $value . '&ordre='.$ordre.'">';
                echo $key . '</a></li>';
            }


            // Chevron droite
            echo '<li class="pagination_boutique ' . ($tri == end($pagination) ? 'disabled' : 'waves-effect') . '">';
            // On récupère la clef suivant l'actuelle
            while (!is_null(current($pagination)) && current($pagination) != $tri)
            {
                prev($pagination);
            }
            echo '<a href="boutique.php?tri=' . next($pagination) . '&ordre='.$ordre.'">';
            echo '<i class="material-icons">chevron_right</i></a></li>';

            ?>

            <br /><br />

            <!-- Ordre de tri -->
            <?php
            echo '<li class="pagination_boutique_ordre pagination_boutique waves-effect' . ($ordre ? ' active' : '') . '">';
            ?>
                <?php
                echo '<a href="boutique.php?tri='.$tri.'&ordre='.($ordre ? 0 : 1).'">';
                ?>
                    <i <?php echo 'class="material-icons' . ($ordre ? ' force-icons' : '') . '"'; ?>>sort_by_alpha</i>
                </a>
            </li>
        </ul>


        <?php

        echo '<div class="col s4">';

        // On vérifie que le tableau ne soit pas vide
        if (!empty($items))
        {
            // Affichage des objets sur 3 colonnes

            $n = count($items); // Nombre d'items
            $i = 0; // N° de l'item sur la colonne actuelle
            $column = 0; // N° de la colonne actuelle


            // On parcourt la liste des items
            for ($iter = 0; $iter < $n; $iter++)
            {
                // Si on a atteint un tiers des produits, on passe sur la colonne suivante
                if ($iter*(3/$n) >= $column+1)
                {
                    echo '</div><div class="col s4">';
                    $column++;
                    $i = 0;
                }

                // On récupère l'item et on passe au suivant
                $value = $items[($column)+3*$i];
                $i++;

                ?>

                <form class="form_item" method="post" action="boutique.php">
                    <div class="card-panel hoverable center">
                        <!-- Image du produit -->
                        <img class="image-item" <?php echo 'src="'.image_item_boutique($value['id_item']).'" alt="Item #'.$value['id_item'].'"'; ?> />

                        <!-- Nom du produit -->
                        <p class="promo caption">
                            <b><?php echo $value['nom_item']; ?></b> <?php echo '<input type="hidden" name="id_item" value="'.$value['id_item'].'" />'; ?>
                        </p>

                        <!-- Description du produit -->
                        <p class="light">
                            <?php echo $value['description_item']; ?>
                        </p>

                        <!-- Stock du produit et bouton acheter -->
                        <?php

                        // Si le produit est en stock
                        if ($value['stock'] > 0)
                        {
                            ?>

                            <!-- Bouton acheter -->
                            <button class="btn waves-effect waves-light btn_acheter" type="submit" name="action" value="ajouter_item">
                                    Acheter
                                    <i class="material-icons right">add_shopping_cart</i>
                            </button>

                            <br /><br />

                            <!-- Stock -->
                            <span class="new badge teal" data-badge-caption=" en stock">
                                <?php echo $value['stock']; ?>
                            </span>

                            <?php
                        }
                        // S'il n'est pas disponible, on l'annonce
                        else
                        {
                            echo '<p><span class="new badge red" data-badge-caption="Non disponible"></span></p>';
                        }

                        ?>

                    </div>
                </form>

                <?php
            }
            echo '</div></div>';
        }
        // Si la boutique est vide, on le signale
        else
        {
            ?>

            </div>
            <div class="col s12 card-panel center">
                <h3>Oups</h3>

                <p>La boutique est fermée pour le moment, repassez plus tard !</p>
            </div>

            <?php
        }
    echo '</div></div>';
}



// Traite les données POST pour les actions sur le panier
function traitement_formulaire_panier(ChaussureManager $man)
{
    // On vérifie si notre panier doit être changé
    if (!empty($_POST))
    {
        // On vérifie qu'une action soit bien définie
        if (isset($_POST['action']))
        {
            // On traite l'action demandée
            switch ($_POST['action'])
            {
                // Suppression d'items du panier
                case 'supprimer_item':
                    // On parcourt les paramètres
                    foreach ($_POST as $key => $value)
                    {
                        // On vérifie que le paramètre soit bien la checkbox box_id_item_
                        if (strpos($key, 'box_id_item_') === 0)
                        {
                            // Si l'item est à supprimer
                            if ($value === 'on')
                            {
                                // On récupère l'id de l'item
                                $id_item = substr($key, 12);

                                // On met sa quantité à 0 (donc suppression)
                                $_SESSION['panier']->supprime($id_item);
                            }
                        }
                    }
                    return true;
                

                // Ajout d'item au panier
                case 'ajouter_item':
                    // On rajoute l'item au panier
                    // TODO : gestion quantité
                    return $_SESSION['panier']->ajoute($_POST['id_item'], 1);
                

                // Modifier les quantités du panier
                case 'modifier_items':
                    // On parcourt les paramètres
                    $return = true;

                    foreach ($_POST as $key => $value)
                    {
                        // On vérifie que le paramètre soit bien le champ num_id_item_
                        if (strpos($key, 'num_id_item_') === 0)
                        {
                            // On récupère l'id de l'item
                            $id_item = substr($key, 12);
                            
                            // On modifie sa quantité dans le panier
                            $tmp = $_SESSION['panier']->modifie($id_item, (int)$value);
                            
                            $r = (!$return) ? $return : $tmp;
                        }
                    }
                    return $return;


                // Passer en caisse (non-disponible par AJAX)
                case 'acheter_items':
                    // Redirection subite vers la page de paiement
                    if (!$_SESSION['panier']->est_vide())
                    {
                        header('Location: paiement.php');
                    }
                    return false;


                // Mauvaise valeur
                default:
                    return false;
            }
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}




// Si le fichier a été importé pour ses traitements
if (isset($GLOBALS['NO_HTML']) && $GLOBALS['NO_HTML'])
{
    // On s'arrête ici
    return;
}


// On récupère les options de tri de la boutique
$tri = (isset($_GET['tri']) ? $_GET['tri'] : (isset($_POST['tri']) ? $_POST['tri'] : 'id_item'));
$ordre = (isset($_GET['ordre']) ? (int)$_GET['ordre'] : (isset($_POST['ordre']) ? (int)$_POST['ordre'] : 0));


// Traitement du formulaire
traitement_formulaire_panier($man);
// Récupération de la boutique
$boutique = $man->affiche_boutique($tri, $ordre);

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
        <link rel="stylesheet" type="text/css" href="css/boutique.css" />

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Boutique</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <!-- Titre de contenu -->
            <h1 class="center align">Boutique</h1>

            <!-- Ligne d'affichage du panier -->
            <div class="row">
                <div class="col s8 offset-s2">
                    <div class="card-panel center">
                        <?php

                        // On affiche le panier
                        html_affiche_panier();

                        ?>
                    </div>
                </div>
            </div>


            <!-- Ligne d'affichage des produits -->
            <div class="row">
                <div class="col s8 offset-s2">
                    <?php

                    // On affiche la boutique
                    html_affiche_boutique($boutique, $tri, $ordre);

                    ?>
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

        <!-- Gestion du panier (+ AJAX) -->
        <script type="text/javascript" src="js/boutique.js"></script>
    </body>
</html>
