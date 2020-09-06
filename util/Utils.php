<?php
/*
*	MEMBRE
*/

/**
*	Renvoie le chemin vers l'avatar du membre
*	@version 11/12/2017 21:00
*
*	@param string $id ID du membre
*	@return string Chemin vers l'image
*
*	@todo Compléter le script avec d'autres formats
*/
function avatar_membre($id) {
	// Chemin de base des avatars
	$chemin = 'img/membre/avatar/';

	// Avatar par défaut s'il n'existe pas
	$chemin .= (file_exists($GLOBALS['_WORK_PATH_PHP'] . $chemin . $id . '.png') ? $id : 'default');
	$chemin .= '.png';

	return $GLOBALS['_WORK_PATH_HTML'] . $chemin;
}


/**
*	Modifier l'avatar du membre
*	@version 20/01/2017 18:00
*
*	@param
*		string $id ID du membre
*		array $fichier Fichier envoyé
*		int $limite_taille Limite de taille du fichier en octets
*	@return boolean
*		true : upload réussi
*		false : upload échoué
*
*	@todo Compléter le script avec d'autres formats
*/
function modifie_avatar_membre($id, $fichier, $limite_taille) {
	// Chemin de destination
	$destination = $GLOBALS['_WORK_PATH_PHP'].'img/membre/avatar/'. $id . '.png';

	// Est-ce une image ?
	if (getimagesize($fichier['tmp_name']))
	{
		// Est-ce trop lourd ?
		if ($fichier['size'] <= $limite_taille)
		{
			// Récupération de l'extension du fichier
			$ext = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

			// Est-ce une bonne extension ?
			if (in_array($ext, array('jpg', 'png', 'jpeg')))
			{
				// Peut-on le déplacer ?
				if (move_uploaded_file($fichier['tmp_name'], $destination))
				{
					return true;	// Upload réussi
				}
			}
		}
	}

	return false;	// Upload échoué
}



/*
*	BOUTIQUE
*/

/**
*	Renvoie le chemin vers l'image du produit
*	@version 22/12/2017 23:00
*
*	@param string $id ID du produit
*	@return string Chemin vers l'image
*
*	@todo Compléter le script
*/
function image_item_boutique($id) {
	// Chemin de base des items de la boutique
	$chemin = 'img/boutique/item/';

	// Image par défaut si elle n'existe pas
	$chemin .= (file_exists($GLOBALS['_WORK_PATH_PHP'] . $chemin . $id . '.png') ? $id : 'default');
	$chemin .= '.png';

	return $GLOBALS['_WORK_PATH_HTML'] . $chemin;
}




/*
*	DIVERS
*/

/**
*	Renvoie l'IP du client
*	@version 11/12/2017 22:00
*
*	@param void
*	@return string IP du client
*/
function get_ip() {
	// IP si internet partagé
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// IP derrière un proxy
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	// Sinon : IP normale
	else
	{
		return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
}


/**
*	Envoie le mail demandé
*	@version 13/01/2018 14:00
*
*	@param
*		string $destinataire Destinataire de l'e-mail
*		string $sujet Objet de l'e-mail
*		string $message Message (au format HTML)
*	@return void
*/
function envoyer_mail($destinataire, $sujet, $message) {
	$entetes = 'From: "Académie Chaucyrienne" <academie@chaucyr.io>' . "\n";	// Expéditeur
	$entetes .= 'Content-Type: text/html; charset="UTF-8"' . "\n";				// Type et encodage
	$entetes .= 'Content-Transfer-Encoding: 8bit';								// Infos d'encodage

	mail($destinataire, $sujet, StripSlashes($message), $entetes);				// Envoi du mail
}