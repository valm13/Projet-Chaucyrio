<?php
class ChaussureManager {
	// Informations BDD
	private $__host = 'localhost';				// Host de la BDD
	private $__dbname = 'miniprojet';			// Nom de la base
	private $__user = 'root';					// Nom d'utilisateur
	private $__pass = '';						// Mot de passe


	// Objet PDO
	private $_db;								// Objet PDO


	// Boutique
	private $_CHAMPS_BOUTIQUE;					// Liste des champs de la table 'boutique'
	private $_CHAMPS_MEMBRES;					// Liste des champs de la table 'membres'
	private $_CHAMPS_COMMANDES;					// Liste des champs de la table 'commandes'



	/**
	*	[Constructeur] Initialise la connexion selon le paramètre
	*	@version 30/12/2017 17:45
	*
	*	@param boolean $auto_connect Connexion automatique à la base de données
	*	@return void
	*/
	public function __construct($auto_connect) {
		// Si un booléen est passé en paramètre
		if (isset($auto_connect))
		{
			// Si ce booléen est TRUE, on se connecte directement à la BDD
			if ($auto_connect)
			{
				$this->connexionBDD();
			}
		}
	}



	/*
	*	GESTION DE LA BASE DE DONNÉES
	*/

	/**
	*	Connexion à la base de données
	*	@version 11/12/2017 18:00
	*
	*	@param void
	*	@return void
	*/
	private function connexionBDD() {
		try
		{
			// On essaie de se connecter à la BDD
			$this->_db = new PDO('mysql:host=' . $this->__host . ';dbname=' . $this->__dbname . ';charset=utf8', $this->__user, $this->__pass);

			// On initialise les variables de la classe
			$this->initialisation();
		}
		catch (PDOException $e)
		{
			echo 'Erreur connexion BDD : ';
			die($e->getMessage());
		}
	}


	/**
	*	Initialise les variables de classe
	*	@version 24/12/2017 18:00
	*
	*	@param void
	*	@return void
	*/
	private function initialisation() {
		/*  BOUTIQUE  */

		// On récupère les colonnes de la table 'boutique'
		$req = $this->_db->query('SHOW COLUMNS FROM boutique');
		
		// On parcourt les résultats
		$this->_CHAMPS_BOUTIQUE = array();
		foreach ($req->fetchAll() as $value)
		{
			// On ajoute le nom du champ dans le tableau
			$this->_CHAMPS_BOUTIQUE[] = $value['Field'];
		}


		/*  MEMBRES  */

		// On récupère les colonnes de la table 'membres'
		$req = $this->_db->query('SHOW COLUMNS FROM membres');
		
		// On parcourt les résultats
		$this->_CHAMPS_MEMBRES = array();
		foreach ($req->fetchAll() as $value)
		{
			// On ajoute le nom du champ dans le tableau
			$this->_CHAMPS_MEMBRES[] = $value['Field'];
		}


		/*  COMMANDES  */

		// On récupère les colonnes de la table 'membres'
		$req = $this->_db->query('SHOW COLUMNS FROM commandes');
		
		// On parcourt les résultats
		$this->_CHAMPS_COMMANDES = array();
		foreach ($req->fetchAll() as $value)
		{
			// On ajoute le nom du champ dans le tableau
			$this->_CHAMPS_COMMANDES[] = $value['Field'];
		}
	}




	/*
	*	GESTION MEMBRE
	*/

	/**
	*	Vérifie les informations de connexion et procède à la connexion du membre si celles-ci sont correctes
	*	@version 11/12/2017 18:00
	*
	*	@param string $email E-mail du membre
	*	@param string $mot_de_passe Mot de passe du membre [en sha1]
	*	@return integer Indique l'état du compte
	*		0 : inexistant
	*		1 : connecté
	*		2 : à confirmer par e-mail
	*/
	public function connexion_membre($email, $mot_de_passe) {
		// On compte combien d'utilisateurs correspondent à ce couple (email, mot_de_passe)
		$req = $this->_db->prepare("SELECT * FROM membres WHERE email = :email AND mot_de_passe = :mot_de_passe");
		$req->bindParam(":email", $email);
		$req->bindParam(":mot_de_passe", $mot_de_passe);
		$req->execute();

		// On récupère les résultats
		$res = $req->fetchAll();

		// Si un utilisateur correspond à ce couple, c'est que l'authentification est réussie
		if (sizeof($res) == 1)
		{
			// Si l'e-mail a été confirmé
			if ($res[0]['role'] >= 0)
			{
				// On copie les informations du compte dans la variable SESSION
				$_SESSION['membre'] = new Membre($res[0]);
				
				return 1; // Renvoie que la connexion est réussie
			}
			else
			{
				// On s'assure de déconnecter l'utilisateur
				unset($_SESSION['membre']);

				return 2; // Renvoie qu'il faut valider le compte
			}
		}
		// Aucun utilisateur correspondant
		else {
			// On s'assure de déconnecter l'utilisateur
			unset($_SESSION['membre']);

			return 0; // Renvoie que la connexion a raté
		}
	}
    

    /**
	*	Indique si l'e-mail est déjà utilisé par un membre
	*	@version 11/12/2017 18:00
	*
	*	@param string $email
	*	@return boolean
	*		TRUE : E-mail déjà utilisé
	*		FALSE : E-mail non utilisé
	*/
    public function email_deja_utilise($email) {
    	// Préparation de la requête
        $req = $this->_db->prepare("SELECT id_membre FROM membres WHERE email = :email");
        $req->bindParam(":email", $email);
        $req->execute();

        // On récupère le résultat
        $res = $req->fetchAll();

        // Si le tableau de résultat est vide
        if (empty($res))
        {
            return false; // E-mail non utilisé
        }
        else
        {
            return true; // E-mail déjà utilisé
        }
    }


	/**
	*	Indique l'état du compte associé à l'e-mail donné
	*	@version 11/12/2017 18:00
	*
	*	@param string $email
	*	@return integer
	*		-2 : l'e-mail n'est pas utilisé
	*		-1 : e-mail à valider
	*		> -1 : e-mail validé
	*/
    public function verifie_confirmation_email($email) {
    	// Préparation de la requête
    	$req = $this->_db->prepare('SELECT role FROM membres WHERE email = :email');
    	$req->bindParam(':email', $email);
    	$req->execute();

    	// On récupère le résultat
    	$res = $req->fetchAll();

    	// Si le tableau est vide
    	if (!empty($res))
    	{
    		return $res[0]['role']; // Renvoie l'état de l'e-mail
    	}
    	else
    	{
    		return -2; // E-mail non utilisé
    	}
    }


    /**
	*	Confirme le compte associé à un e-mail
	*	@version 11/12/2017 18:00
	*
	*	@param string $email E-mail à confirmer
	*	@return void
	*/
    public function confirme_email($email) {
    	// Modifie l'attribut "email_confirmation" lié à l'e-mail donné afin de valider le compte
    	$req = $this->_db->prepare("UPDATE membres SET role = 0 WHERE email = :email");
    	$req->bindParam(':email', $email);
    	$req->execute();
    }


    /**
	*	Renvoie un nouveau mot de passe par e-mail
	*	@version 11/12/2017 18:00
	*
	*	@param string $email E-mail du compte associé
	*	@return integer
	*		-2 : E-mail non associé
	*		-1 : E-mail à valider, renvoie de la confirmation
	*		> -1 : E-mail validé, renvoie d'un mot de passe
	*
	*	@todo Compléter le script
	*/
    public function renvoie_mot_de_passe($email) {
    	// On récupère l'état du compte
    	$etat_confirmation = $this->verifie_confirmation_email($email);

    	// Si le compte est confirmé, on renvoie un mot de passe
    	if ($etat_confirmation >= 0)
    	{
    		// ...
    	}
    	// Si le compte existe mais n'est pas confirmé, on renvoie une confirmation
    	else if ($etat_confirmation == -1)
    	{
    		// ...
    	}

    	return $etat_confirmation;
    }
    

    /**
	*	Ajoute un nouveau membre dans la base de données
	*	@version 11/12/2017 18:00
	*
	*	@param array $values Tableau de valeurs du membre
	*	@return void
	*/
    public function ajoute_membre(array $values) {
        // Préparation de la requête
        $req = $this->_db->prepare("INSERT INTO membres(id_membre, email, mot_de_passe, role, date_inscription, nom, prenom, pays, ville, date_naissance, numero_telephone) VALUES(:id_membre, :email, :mot_de_passe, :role, :date_inscription, :nom, :prenom, :pays, :ville, :date_naissance, :numero_telephone)");

        // On rajoute les paramètres du tableau
        foreach ($this->_CHAMPS_MEMBRES as $key => $val)
        {
            if (isset($values[$val]))
            {
            	$req->bindValue(':'.$val, $values[$val]);
            }
            else
            {
            	$req->bindValue(':'.$val, null);
            }
        }

        // On exécute la requête (l'utilisateur est inscrit)
        $req->execute();
    }


    public function modifie_membre(array $params) {
    	// Si les données sont vides
    	if (empty($params))
    	{
    		return false;
    	}


    	// Liste des champs à modifier
    	$champs = '';
    	foreach ($params as $key => $value)
    	{
    		if (in_array($key, $this->_CHAMPS_MEMBRES) && $key != 'id_membre')
    		{
    			$champs .= ' ' . $key . ' = :' . $key . ',';
    		}
    	}
    	$champs = substr($champs, 0, -1); // On enlève la dernière virugle

    	// Prépération de la requête
    	$req = $this->_db->prepare("UPDATE membres SET".$champs." WHERE id_membre = :id_membre");

    	// On rajoute les paramètres du tableau
    	foreach ($params as $key => $value)
    	{
    		if (in_array($key, $this->_CHAMPS_MEMBRES))
    		{
    			$req->bindValue(':'.$key, $value);
    		}
    	}

    	// Exécution de la requête
    	$req->execute();
    	// Mise à jour de la variable SESSION
    	$_SESSION['membre']->hydrate($params);

    	return true;
    }



    /*
	*	GESTION DICTIONNAIRE
	*/

	/**
	*	Cherche le mot correspondant dans le dictionnaire
	*	@version 11/12/2017 18:00
	*
	*	@param array $values Tableau des valeurs du mot recherché / type de recherche
	*	@return void
	*/
    public function chercheMot(array $values) {
        $values['mot'] = "%".$values['mot']."%";
    	if($values['langue'] == 'frchy') { //Cas du français au chaucyrio
    		//Préparation de la requête
    		$req = $this->_db->prepare("SELECT ortho_chy,definition,cat_gram,genre FROM lexique WHERE officiel = 1 AND ortho_fr LIKE :mot");
    		//Attribution de la variable
    		$req->bindValue(':mot',$values['mot']);
    		//Exécution de la requête
    		$req->execute();
    	}
    	else { //Cas du chaucyrio au français
    		$req = $this->_db->prepare("SELECT ortho_fr,definition,cat_gram,genre FROM lexique WHERE officiel = 1 AND ortho_chy LIKE :mot");
    		$req->bindValue(':mot',$values['mot']);
    		$req->execute();
    	}

    	//Affichage du (ou des) mot(s)
        while($res = $req->fetch()) {
        	if($res[0]) {
        		$res[0] = ucfirst($res[0]);
	            echo '<table class="col s6 offset-s3">';
	            echo '<tr><td>';
	            echo '<h4><b>'.$res[0].'</b></h4></td>';
	            echo '<td>';
	            echo '<i>('.$res['cat_gram'].')  ';
	            if($res['genre'] != ' ') {
	            	echo '('.$res['genre'].')';
	            }
	            echo '</i></td>';
	            echo '</tr>';
	            echo '</table>';
	            echo '<p id="def" class="col s8 offset-s2">';
	            echo ''.$res['definition'].'</p>';
        	}
        }
    }


    /**
     * Affiche un mot au hasard, Français ou Chaucyrio
     * @version 13/01/2018 16:22
     * 
     * @param  void
     * @return void
     *
     * @todo Compléter les conditions
     */
    public function motHasard(){
    		$langue = rand(1,2); //Langue au hasard

    		//Préparation des requêtes.
    		if($langue == 1) {
    			$req = $this->_db->prepare("SELECT ortho_chy,definition,cat_gram,genre FROM lexique WHERE officel = 1 ORDER BY rand() LIMIT 1");
    		}
    		if($langue == 2) {
    			$req = $this->_db->prepare("SELECT ortho_fr,definition,cat_gram,genre FROM lexique WHERE officiel = 1 ORDER BY rand() LIMIT 1");
    		}
    		$req->execute();

    	//Affichage du mot
    	while($res = $req->fetch()) {
        	//if($res[0]) {
        		$res[0] = ucfirst($res[0]);
	            echo '<table class="col s6 offset-s3">';
	            echo '<tr><td>';
	            echo '<h4><b>'.$res[0].'</b></h4></td>';
	            echo '<td>';
	            echo '<i>('.$res['cat_gram'].')  ';
	            echo '('.$res['genre'].')</i></td>';
	            echo '</tr>';
	            echo '</table>';
	            echo '<p id="def" class="col s8 offset-s2">';
	            echo ''.$res['definition'].'</p>';
        	//}
        }
    }

    /**
     * Calcule le nombre de pages à créer pour le lexique
     * @version
     *
     * @param      $values tableau de valeurs, notamment 
     * @return
     */
    public function calculeNbPages($values) {
    	$nbPages = -1;

    	if($values['lettre'] != '') {
    		$requete =  'SELECT count(id) FROM lexique WHERE officiel = 1 AND ortho_fr LIKE \'';
    		$requete .= $values['lettre'];
    		$requete .= '%\'';
    		$req = $this->_db->prepare($requete);
    		$req->execute();

    		$totalMots = $req->fetch()[0];
    		if($totalMots == 0) {
    			$nbPages = -1;
    		}
    		else if($totalMots > 10) {
    			$nbPages = ceil($totalMots / 10);
    		}
    		else {
    			$nbPages = 1;
    		}
    	}
    	return $nbPages;
    }

    /**
     * Tri du dico, lettre par lettre
     * @version 15/01/2018 11:49
     * 
     * @param  array  $values Tableau contenant la lettre
     * @return void
     */
    public function afficheListeMots(array $values,$offset) {

    	$i = 0;
		//Requête des mots
		if($values['lettre'] != '') {
		   	$requete = 'SELECT ortho_fr, ortho_chy, definition, cat_gram, genre FROM lexique WHERE officiel = 1 AND ortho_fr LIKE \'';
			$requete .= $values['lettre'];
			$requete .= '%\' ORDER BY ortho_fr ASC LIMIT 10';
			$requete .= ' OFFSET ' . $offset*10;
			$req = $this->_db->prepare($requete);
		   	$req->execute();

		while($res = $req->fetch()) {
			$res[0] = ucfirst($res[0]);
		    $res[1] = ucfirst($res[1]);
		    echo '<table class="section col s6">';
		    echo '<tr><td><h4><b>'.$res[0].'  </b></h4></td>';
		    echo '<td><i>'.$res['cat_gram'].'  ';
		    if($res['genre'] != ' ')
			   	echo '('.$res['genre'].')';
			echo '</i></td></tr>';
			echo '</table>';
		    echo '<br>';
			echo '<div class="section col s12 offset-s1">';
			echo '<h5><u>'.$res[1].'</u></h5>';
			echo '</div>';
			echo '<p id="def" class="col s10">';
			echo ''.$res['definition'].'</p>';
		}
		?>
		</div>
		<?php
		}
    }

    /**
     * Vérifie si la proposition est valide
     *@version 20/01/2018 17:45
     * 
     * @param  array  $formulaire Ensemble des informations sur la proposition du membre
     * @return $resultat
     */
    public function verifieMot(array $formulaire) {
    	$req = $this->_db->prepare('SELECT ortho_fr,officiel FROM lexique WHERE ortho_fr = :mot AND cat_gram = :cat AND officiel = 1');
    	$req->bindValue(':mot',$formulaire['mot']);
    	$req->bindValue(':cat',$formulaire['cat_gram']);
    	$req->execute();
    	$res = $req->fetchAll();
    	if(empty($res)) {
    		return 0;
    	} else {
    		return 1;
    	}
    }

    /**
     * Ajoute un mot en propoition pour le dictionnaire
     * @version 20/01/2018 17:30
     * 
     * @param  array  $formulaire Ensemble des informations sur la proposition du membre
     * @return void
     */
    public function proposeMot(array $formulaire) {
    	// Si les champs sont bien remplis
    	if($formulaire['mot'] != '' && $formulaire['traduction'] != 0) {
    		// Les string s'écrivent en minuscules
    		$formulaire['mot'] = strtolower($formulaire['mot']);
    		$formulaire['traduction'] = strtolower($formulaire['traduction']);

    		// Calcul de la taille du mot chaucyrio
    		$taille = strlen($formulaire['traduction']);

    		// Requete
    		$req = $this->_db->prepare("INSERT INTO lexique (ortho_fr,ortho_chy,nb_lettre_chy,description,date_contribution,en_cours) VALUES (:mot,:trad,:taille,:des,:d,1);");
    		$req->bindValue(':mot',$formulaire['mot']);
    		$req->bindValue(':trad',$formulaire['traduction']);
    		$req->bindValue(':taille',$taille);
    		$req->bindValue(':des',$formulaire['description']);
    		$req->bindValue(':d',$formulaire['date_contribution']);
    		$req->execute(); // Exécution
    	}
	}

    /*
    *	GESTION BLOG
    */

    /**
	*	DESCRIPTION
	*	@version JJ/MM/YYYY HH:MM
	*
	*	@param void
	*	@return void
	*
	*	@todo À FAIRE
	*/



    /*
    *	GESTION T'CHAT
    */

    /**
	*	Ajoute un message
	*	@version 11/12/2017 18:00
	*
	*	@param void
	*	@return void
	*
	*	@todo Compléter la doc
	*/
   	public function ajouteMessageTchat($values){
        $req = $this->_db->prepare('INSERT INTO tchat (id_membre, message) VALUES(?, ?)');
        //$req->bindParam(1,$values['nom']);
        //$req->bindParam(2,$values['prenom']);
        $req->bindParam(1,$values['id_membre']);
        $req->bindParam(2,$values['message']);
        $req->execute();
        
        $req = $this->_db->query('SELECT id FROM tchat ORDER BY id DESC LIMIT 51');
        $res = $req->fetchAll();
        if(count($res) > 50) {
            $limitelul = $res[49]['id'];
            $req2 = $this->_db->query('DELETE FROM tchat WHERE id < ' . $limitelul);
        }
        
    }
   
   
   public function afficheMessageTchat($values){
        $requete1 = $this->_db->query('SELECT prenom, nom, id_membre, message FROM tchat INNER JOIN membres USING (id_membre) ORDER BY ID ASC');
        while ($donnees = $requete1->fetch())
        {
            echo '<p><strong>' . htmlspecialchars($donnees['prenom']) .' '.htmlspecialchars($donnees['nom']).' (#'. htmlspecialchars($donnees['id_membre']) .')'.  '</strong> : ' . htmlspecialchars($donnees['message']) . '</p>';
        }
        /*$requete2 = $this->_db->query('SELECT MIN(id) FROM tchat');

        $donnees_id = $requete2->fetch();
        $minimum = $donnees_id[0];
        $requete3 = $this->_db->query('SELECT count(id) FROM tchat');
        $donnees_cpt = $requete3->fetch();
        if ($donnees_cpt[0] > 5){
            $requete4 = $this->_db->query('DELETE FROM tchat WHERE id <= '.$minimum);
        }*/

        /*  $req2 = $this->_db->prepare('SELECT count(message) FROM tchat');
        $req2->execute();
        $res2 = fetch();*/
   
    }



    /*
    *	GESTION BOUTIQUE
    */

    /**
	*	Retourne un objet Item correspondant à l'ID donné
	*	@version 01/01/2018 17:00
	*
	*	@param int $id_item ID de l'item à retourner
	*	@return Item Item correspondant
	*/
    public function item($id_item) {
    	$req = $this->_db->prepare('SELECT * FROM boutique WHERE id_item = :id_item');
    	$req->bindParam(':id_item', $id_item);
    	$req->execute();

    	$res = new Item($req->fetch());

    	return $res;
    }


    /**
	*	Retourne le tableau de tous les produits de la boutique
	*	@version 18/12/2017 12:30
	*
	*	@param
	*		string $tri Champ de tri
	*		int $ordre Ascendant (0) - Descendant (!= 0)
	*	@return array Liste des produits
	*/
	public function affiche_boutique($tri, $ordre) {
		// Si le champ de tri n'est pas correct, on en met un par défaut
		if (!in_array($tri, $this->_CHAMPS_BOUTIQUE))
		{
			$tri = 'id_item';
			$ordre = 0;
		}
		// Si l'ordre n'est pas un entier, on le met à 0 par défaut
		if (!is_int($ordre))
		{
			$ordre = 0;
		}

		$req = $this->_db->prepare('SELECT * FROM boutique ORDER BY ' . $tri . ' ' . ($ordre ? 'DESC' : 'ASC'));
		$req->execute();

		return $req->fetchAll();
	}


	public function ajoute_commande($panier) {
		$somme = 0;
		// Calcul du prix total de la commande
		foreach ($panier as $key => $value) {
			$somme += $value->prix();
		}

		// On rajoute la commande à l'utilisateur
		$req = $this->_db->prepare('INSERT INTO a_commande VALUES(:id_commande, :id_membre, :date_commande, :prix_commande, 1)');
		$req->bindValue(':id_commande', null);
		$req->bindValue(':id_membre', 1);
		$req->bindValue(':date_commande', date('Y-m-d', time()));
		$req->bindValue(':prix_commande', $somme);
		$req->execute();

		// On récupère l'ID de la nouvelle commande
		$req = $this->_db->prepare('SELECT LAST_INSERT_ID()');
		$req->execute();
		$id = $req->fetch()[0];

		// On ajoute tous les items dans la commande
		foreach ($panier as $key => $value)
		{
			$req = $this->_db->prepare('INSERT INTO commandes VALUES(:id_commande, :id_item, :quantite)');
			$req->bindValue(':id_commande', $id);
			$req->bindValue(':id_item', $value->id());
			$req->bindValue(':quantite', $value->quantite());
			$req->execute();
		}


		// On retourne l'ID de la commande
		return sprintf('%04d', $id);
	}


	public function historique_commandes($id_membre) {
		// On récupère les ID des commandes de l'utilisateur donné
		$req = $this->_db->prepare('SELECT * FROM a_commande INNER JOIN etat_commande USING(id_etat_commande) WHERE id_membre = :id_membre');
		$req->bindValue(':id_membre', $id_membre);
		$req->execute();

		return $req->fetchAll();
	}


	public function recupere_commande($id_commande) {
		// On récupère les items de la commande donnée
		$req = $this->_db->prepare('SELECT id_item, nom_item, quantite, prix_unitaire FROM commandes INNER JOIN boutique USING(id_item) WHERE id_commande = :id_commande');
		$req->bindValue(':id_commande', $id_commande);
		$req->execute();

		return $req->fetchAll();
	}



    /*
    *	GESTION ADMINISTRATION
    */

    /**
	*	DESCRIPTION
	*	@version JJ/MM/YYYY HH:MM
	*
	*	@param void
	*	@return void
	*
	*	@todo À FAIRE
	*/



    /*
	*	GESTION CONTACT
	*/

	/**
	*	Envoie un message de contact
	*	@version 11/12/2017 18:00
	*
	*	@param void
	*	@return void
	*
	*	@todo Faire la doc
	*/
	public function enregistreMessage(array $values) {
		$anti_spam_active = true;	// L'anti spam est il activé ?
		$send_mail_active = false;	// L'envoi de mail est-il activé ?
		$spam = false; // Variable de spam

		$values['date_contact'] = date('Y-m-d', time());	// Rajout de la date d'envoi de demande de contact
		$values['horaire_contact'] = date('H:i:s', time());	// Rajout de l'heure d'envoi de demande de contact

		// Anti Spam --> On considère comme du spam, un message envoyé dans la même minute.

		$req = $this->_db->prepare("SELECT id_message, date_contact, horaire_contact FROM contact WHERE ip = :ip ORDER BY id_message DESC LIMIT 1 ");	// On récupère la derniere date et horaire envoyée par cette ip
		$req->bindParam(":ip", $values['ip']);
		$req->execute();
		$res = $req->fetchAll();
		// print_r($res);
		if($res != null){
			// On décompose les dates et horaires

			$orderdate = explode('-',$values['date_contact']); // On explose la date actuelle
			$year_act = $orderdate[0];
			$month_act   = $orderdate[1];
			$day_act  = $orderdate[2];

			$orderdate = explode(':',$values['horaire_contact']); // On explose l'horaire actuel
			$hour_act = $orderdate[0];
			$min_act   = $orderdate[1];
			$sec_act  = $orderdate[2];

			$orderdate = explode('-',$res[0]['date_contact']); // On explose la dernière date d'envoi d'un message par cette ip
			$year_last = $orderdate[0];
			$month_last   = $orderdate[1];
			$day_last  = $orderdate[2];

			$orderdate = explode(':',$res[0]['horaire_contact']); // On explose le dernier horaired'envoi d'un message par cette ip
			$hour_last = $orderdate[0];
			$min_last   = $orderdate[1];
			$sec_last  = $orderdate[2];

			if($year_act == $year_last)
				if($month_act == $month_last)
					if($day_act == $day_last) 
						if($hour_act == $hour_last) 
							if($min_act == $min_last)
						$spam = true; // L'envoi est dans la même minute, c'est donc du spam, on bloque le message

		}
		




		if($anti_spam_active){
			if(!$spam){ // Si c'est pas du spam alors on rajoute le message dans la table
			$req = $this->_db->prepare("INSERT INTO contact(nom, email_contact, sujet, texte, date_contact, horaire_contact, ip) VALUES(:nom, :email_contact, :sujet, :texte, :date_contact, :horaire_contact, :ip)");

		// On rajoute les paramètres du tableau
			foreach ($values as $key => &$val){
				$req->bindParam(':'.$key, $values[$key]);
			}
			$in_bdd = $req->execute();
			}
			else{
				$in_bdd = false;
			}

		}
		else{
			
			$req = $this->_db->prepare("INSERT INTO contact(nom, email_contact, sujet, texte, date_contact, horaire_contact, ip) VALUES(:nom, :email_contact, :sujet, :texte, :date_contact, :horaire_contact, :ip)");

		// On rajoute les paramètres du tableau
			foreach ($values as $key => &$val){
				$req->bindParam(':'.$key, $values[$key]);
			}
			$in_bdd = $req->execute();
		}
		

        // On exécute la requête (la demande de contact a été envoyée)
			
			if($in_bdd && $send_mail_active){
				$to      = $values['email_contact'];
				$subject = 'Votre demande a bien été prise en compte';
				$message = 'Bonjour cher internaute, votre demande de contact a bien été prise en compte' ."\n".'
							Nous serons trés heureux d\'y répondre dans les jours qui suivent.';
				$headers = 'From: valentin.magnan13008@gmail.com' . "\r\n" .
				'Reply-To: valentin.magnan13008@gmail.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

				$mail_envoye = mail($to, $subject, $message, $headers);
				echo $mail_envoye;
			}
	}

		// RETURN TRUE si c'est du spam, sinon FALSE
		// public function Antispam($ip, $table){ 

		// }
	    /*
		*	GESTION BLOG
		*/

		public function ajouteArticle(array $values){
			$req = $this->_db->prepare("INSERT INTO article(id_membre, date, horaire, sujet, texte, valide) VALUES(:id_membre, :date, :horaire, :sujet, :texte, :valide)");
			$req->bindValue(':id_membre', $values['id_membre']);
			$req->bindValue(':date', date('Y-m-d', time()));
			$req->bindValue(':horaire', date('H:i:s', time()));
			$req->bindValue(':sujet', $values['sujet']);
			$req->bindValue(':texte', $values['texte']);
			if($values['role'] == 1) // Si l'admin crée l'article
				$req->bindValue(':valide', 1);
			else
				$req->bindValue(':valide', 0);
			$req->execute();
		}

		public function supprimerArticle($id_article, $role){
			if($role = 1){
				$req = $this->_db->prepare("DELETE FROM article WHERE id_article = :id_article ");
				$req->bindValue(':id_article', $id_article);
				$req->execute();
			}
			
		}

		public function validerArticle($id_article, $role){
			if($role = 1){
				$req = $this->_db->prepare("UPDATE article SET valide = 1 WHERE id_article = :id_article ");
				$req->bindValue(':id_article', $id_article);
				$req->execute();
			}	
		}

		public function desactiverArticle($id_article, $role){
			if($role = 1){
				$req = $this->_db->prepare("UPDATE article SET valide = 0 WHERE id_article = :id_article ");
				$req->bindValue(':id_article', $id_article);
				$req->execute();
			}	
		}

		public function ajouteCommentaire(array $values){
			$req = $this->_db->prepare("INSERT INTO commentaire(id_article, id_membre, date, horaire, texte) VALUES(:id_article, :id_membre, :date, :horaire, :texte)");
			$req->bindValue(':id_article', $values['id_article']);
			$req->bindValue(':id_membre', $values['id_membre']);
			$req->bindValue(':date', date('Y-m-d', time()));
			$req->bindValue(':horaire', date('H:i:s', time()));
			$req->bindValue(':texte', $values['texte']);
			$req->execute();
		}
		public function supprimeCommentaire($id_commentaire){
			$req = $this->_db->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire ");
			$req->bindValue(':id_commentaire', $id_commentaire);
			$req->execute();
		}

		public function listeArticleValide(){
			$req = $this->_db->prepare("SELECT * FROM article LEFT JOIN membres USING(id_membre) WHERE valide = 1 ORDER BY id_article DESC"); // Récupère la liste des articles validés
			$req->execute();
			return $req->fetchAll();

		}

		public function listeArticleInvalide(){
			$req = $this->_db->prepare("SELECT * FROM article LEFT JOIN membres USING(id_membre) WHERE valide = 0 ORDER BY id_article DESC"); // Récupère la liste des articles validés
			$req->execute();
			return $req->fetchAll();

		}

		public function listeAllArticle(){
			$req = $this->_db->prepare("SELECT * FROM article LEFT JOIN membres USING(id_membre) ORDER BY id_article DESC");
			$req->execute();
			return $req->fetchAll();

		}

		public function listeComentaire($id_article){
			$req = $this->_db->prepare("SELECT * FROM commentaire INNER JOIN membres USING(id_membre) WHERE id_article = :id_article ORDER BY id_commentaire DESC");
			$req->bindValue(':id_article', $id_article);
			$req->execute();
			return $req->fetchAll();

		}

		
}