<?php
// Dossier de travail (à changer selon l'hébergement)
// !! ATTENTION !!
// Il faut activer l'option allow_url_include sur PHP
$_DOSSIER_TRAVAIL = '/projet-webdev-cir2-chaucyrio/';

$_WORK_PATH_PHP = $_SERVER['DOCUMENT_ROOT'] . $_DOSSIER_TRAVAIL;
$_WORK_PATH_HTML = 'http://localhost' . $_DOSSIER_TRAVAIL;


// Variables globales pour les chemins (à utiliser pour inclure des fichiers depuis d'autres pages)
$GLOBALS['_DOSSIER_TRAVAIL'] = $_DOSSIER_TRAVAIL; // Dossier relatif du projet
$GLOBALS['_WORK_PATH_PHP'] = $_WORK_PATH_PHP; // Chemin pour include en PHP
$GLOBALS['_WORK_PATH_HTML'] = $_WORK_PATH_HTML; // Chemin pour include en HTML


// Liste des fichiers nécessaires au fonctionnement des pages
require_once($_WORK_PATH_PHP . 'util/Utils.php'); // Fonctions diverses
require_once($_WORK_PATH_PHP . 'class/ChaussureManager.php'); // Base de données

// Pour gérer les membres
require_once($_WORK_PATH_PHP . 'class/Membre.php'); // Membre

// Pour la boutique
require_once($_WORK_PATH_PHP . 'class/Item.php'); // Item
require_once($_WORK_PATH_PHP . 'class/Panier.php'); // Panier



// On démarre la session
session_start();



// On vérifie que les sorties HTML ne soient pas bloqués (cas des fonctions AJAX par exemple)
if(!isset($GLOBALS['NO_HTML']) || $GLOBALS['NO_HTML'] != true)
{
	?>
	
	<!-- On insère le script pour l'AJAX -->
	<script src=<?php echo $_WORK_PATH_HTML . 'js/ajax.js' ?> type="text/javascript"></script>

	<script type="text/javascript">
		<?php
		// Page vers laquelle les requêtes sont envoyées
		echo 'const page_requete = "' . $GLOBALS['_WORK_PATH_HTML'] . 'js/ajax.php";';
		?>
	</script>

	<?php
}
?>