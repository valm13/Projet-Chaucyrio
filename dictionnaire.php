<?php
// On inclue les classes nécessaires
require_once('util/Require.php');

$manager = new ChaussureManager(true);

//Tableau de valeurs, récupérant les infos de recherche et de tri
$values = array(
    'mot' => '',
    'langue' => '',
    'lettre' => '',
    'nombre' => ''
);

    /**
     * Sélectionne le type de recherche
     * @version 13/01/2018 16:46
     *
     * @param void
     * @return void
     */
    function dictionnaire($manager, &$values) {
        //Lorsqu'on charge la page
        if(!isset($_GET['typeRecherche']) && !isset($_GET['lettre'])) {
            afficheFormulaireRecherche();
        }

        //On vérifie quel type de recherche veut l'utilisateur
        if(isset($_GET['typeRecherche'])) {
            if($_GET['typeRecherche'] == 'hasard') { // Cas "mot au hasard"
                $manager->motHasard(); // Envoi de la requête SQL
            }
            if($_GET['typeRecherche'] == 'unique') { // Cas "recherche unique"
                afficheFormulaireRecherche(); // Affiche le moteur de recherche du dictionnaire
            }
            if($_GET['typeRecherche'] == 'lexique') { // Cas "lexique entier"
                $values['lettre'] = $_GET['lettre'];
                // Si le nombre correspondant à la pagination n'existe pas, on l'initialise à 1. Sinon on garde la valeur existante
                $values['nombre'] = (isset($_GET['nombre']) ? $_GET['nombre'] : 1);
                afficheLexique($manager, $values); // Traitement de l'affichage du lexique
            }
        }
    }

    /**
     * Affiche le formulaire de remplissage pour le système de recherche individuelle
     * @version 15/01/2018 9:42
     * 
     * @param void
     * @return void
     */
    function afficheFormulaireRecherche() {
        //Affichage du formulaire
        ?>

        <form class="col s10 offset-s1" method="get">
            <div class="input-field">
                <i id="i_search" class="material-icons prefix small">search</i>
                <input class="" type="text" name="recherche" required/>
                <label id="label_search" for="search">Cherchez une traduction...</label></div>
                <div class="input-field center">
                	<button type="submit" class="waves-effect waves-light btn-large" name="action" value="frchy">FRANÇAIS - CHAUCYRIO</button>
                	<button type="submit" class="waves-effect waves-light btn-large" name="action" value="chyfr">CHAUCYRIO - FRANÇAIS</button>
            	</div>                     
        </form>

        <?php
    }

    function testRecherche($manager) {
        // Si un type de recherche a été choisi
    	if(isset($_GET['recherche'])) {
        	$values['mot'] = $_GET['recherche']; // Récupération du mot

            if(isset($_GET['action'])) {
                $values['langue'] = $_GET['action']; // Récupération de la langue
            }
            $manager->chercheMot($values); // Envoi de la requête SQL
        }
    }

    function afficheLexique($manager, $values) {
		// Si une lettre a été donnée en paramètre
		if (isset($_GET['lettre']))
		{
	        $x = $manager->calculeNbPages($_GET); // Calcul du nombre de pages
	        affichePagination($x,$values); // Crée la pagination numérotée
	        $manager->afficheListeMots($values,$values['nombre']-1); // Envoie la requête SQL
	        ?>
	        <div class="col s6 offset-s3">
		        <?php
		        affichePagination($x,$values); // Crée la pagination numérotée
		        ?>
	    	</div>
	        <?php
	        afficheListeLettre($values); // Crée la pagination lettrée
        }
    }

    /**
     * Affiche la pagination du lexique trié lettre par lettre
     * @version 13/01/2018	14:54
     *
     * @param values tableau de valeur (notamment pour la lettre sélectionnée)
     * @return void
     */
    function afficheListeLettre($values) {
    	?>
    	<div class="col s12">
    	<ul class="pagination center-align">
    	<?php
        $lettre = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        //Index de lettre HTML
        foreach($lettre as $value) {
            echo "<li name=\"lettre\" class=\"waves-effect ";
            if($values['lettre'] == $value) {
                echo "active";
            }
         	echo "\"><a href=\"?typeRecherche=lexique&lettre=$value&nombre=1\">$value</a></li>";
        }
        echo "</ul></div>";
    }

function affichePagination($pages, $values) {
	?>

	<ul class="pagination center-align">
    	<?php

    	$l = $values['lettre'];

    	// On affiche la pagination (pages de résultats)
    	for ($i = 1; $i <= $pages; $i ++)
    	{
    		?>
    		<li name="nombre" class="waves-effect
    			<?php
    			if($values['nombre'] == $i) {
    				echo " active\">";
    			} else {
    				echo '\">';
    			}

	    		echo '<a href="?typeRecherche=lexique&lettre='.$l.'&nombre='.$i.'">'.$i.'</a>';
	    		?>
    		</li>
    		<?php
    	}
    	?>
    </ul>

    <?php
}

?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize/sass/materialize.css"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


        <!-- Encodage et favicon -->
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="img/favicon.png" sizes="128x128">

        <!-- Feuilles de style -->
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/dictionnaire.css">

        <!-- Titre de la page -->
        <title>Académie Chaucyrienne > Dictionnaire</title>
    </head>

    <body>
        <!--Header/Navbar-->
        <?php include('include/nav.php'); ?>


        <!--Main-->
        <main>
            <h1 class="center align">Dictionnaire</h1>

            <!--Tableau principal (12 col)-->
            <div class="row">
                <div class="col s6 offset-s3">
                    <!--AFfichage des filtres-->
                    <div class="card-panel">
                    	<div class="row">
                    		<div class="col s8">
		                        <ul class="filtres">
                                    <!-- Bouton rechercher -->
		                            <h5><li name="typeRecherche" class="waves-effect"><a href="?typeRecherche=unique">&bull; Rechercher</a></li></h5>
                                    <!-- Bouton "mot au hasard" -->
		                            <h5><li name="typeRecherche" class="waves-effect"><a href="?typeRecherche=hasard">&bull; Je veux un mot au hasard</a></li></h5>
                                    <!-- Bouton d'affichage du lexique -->
		                            <h5><li name="lettre" class="Waves-effect"><a href="?typeRecherche=lexique&lettre=A&nombre=1">&bull; Afficher le lexique</a></li></h5>
		                        </ul>
		                    </div>
                            <!-- Option d'enrichissement du dictionnaire -->
		                    <div class="col s4">
		                    	<a href="contribution.php">
		                    	<div class="card-panel hoverable grey lighten-4 center-align">
		                    		<h5><u>Enrichir le dictionnaire</u></h5>
		                    	</a>
		                    </div>
		                </div>
		            </div>
                </div>
	            <?php
	            //On vérifie le type de recherche
	            dictionnaire($manager, $values);
	            ?>
		            <?php
		            //L'entrée de recherche
		            testRecherche($manager);
		            ?>
	        </div>
        </main>


        <!--Footer-->
        <?php include('include/footer.php'); ?>


        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
    </body>
</html>
