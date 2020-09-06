<?php
// On signale que l'on ne veut pas d'autres sorties HTML que nos echo
$GLOBALS['NO_HTML'] = true;

// Gère les dépendances de la page
require_once('../util/Require.php');
// Inclusion des fonctions "boutique"
require_once('../boutique.php');


// Texte affiché lors d'une erreur requête
$erreur_key = 'Erreur';

// Connexion à la BDD
$man = new ChaussureManager(TRUE);


// Si le type est défini
if(isset($_POST['type']))
{
	// On traite la requête selon son type
	switch($_POST['type'])
	{
		// Fonctions du panier
		case 'panier':
			// Si le traitement est validé
			if(traitement_formulaire_panier($man))
			{
				// On actualise le panier
				html_affiche_panier();
			}
			else {
				// Sinon on signale l'erreur
				echo $erreur_key;
			}
			break;

		// Fonctions de la boutique
		case 'boutique':
			// Gestion des requêtes POST et GET
			if((isset($_GET['action']) && $_GET['action'] == 'tri') || (isset($_POST['action']) && $_POST['action'] == 'tri'))
			{
				$tri = (isset($_GET['tri']) ? $_GET['tri'] : (isset($_POST['tri']) ? $_POST['tri'] : 'stock'));
				$ordre = (isset($_GET['ordre']) ? (int)$_GET['ordre'] : (isset($_POST['ordre']) ? (int)$_POST['ordre'] : 0));

				// On affiche la boutique triée
				html_affiche_boutique($man->affiche_boutique($tri, $ordre), $tri, $ordre);
			}
			else
			{
				echo $erreur_key;
			}
			break;


		// Type inconnu
		default:
			echo $erreur_key;
			break;
	}
}
else
{
	echo $erreur_key;
}