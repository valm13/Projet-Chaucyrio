<?php
class Membre {
	// Caractéristiques du membre
	private $id_membre;						// ID du membre

	private $email;							// E-mail du compte
	private $mot_de_passe;					// Mot de passe du compte

	private $role;							// Rôle du membre (à confirmer, membre, administrateur, etc.)
	private $date_inscription;				// Date d'inscription

	private $nom;							// Nom
	private $prenom;						// Prénom
	private $date_naissance;				// Date de naissance

	private $pays;							// Pays
	private $ville;							// Ville
	private $code_postal;					// Code postal
	private $adresse;						// Adresse

	private $numero_telephone;				// Numéro de téléphone



	/**
	*	[Constructeur] Initialise les variables selon le tableau de valeurs
	*	@version 30/12/2017 17:00
	*
	*	@param array $params Tableau de valeurs
	*	@return void
	*/
	public function __construct(array $params) {
		// On récupère les variables existantes de la classe
		$this_vars = get_object_vars($this);
		
		// On met en null par défaut chaque variable
		foreach ($this_vars as $key => $value)
		{
			$this->$key = null;
		}
		// Compte à confirmer par défaut
		$this->role = -1;


		// On modifie les variables avec les valeurs données
		$this->hydrate($params);
	}


	public function hydrate(array $params) {
		// On récupère les variables existantes de la classe
		$this_vars = get_object_vars($this);


		// On parcourt le paramètre
		foreach ($params as $key => $value)
		{
			// Si la clef existe en tant que variable de classe
			if (array_key_exists($key, $this_vars))
			{
				// La variable de classe prend la valeur donnée
				$this->$key = $value;
			}
		}
	}



	/*
	*	Getters
	*/
	
	/**
	*	Renvoie l'ID du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return int ID
	*/
	public function id() {
		return $this->id_membre;
	}

	/**
	*	Renvoie l'e-mail du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string E-mail
	*/
	public function email() {
		return $this->email;
	}

	/**
	*	Renvoie le rôle du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return int role
	*		-1 : compte à confirmer
	*		0 : membre
	*		1 : administrateur
	*/
	public function role() {
		return $this->role;
	}

	/**
	*	Renvoie la date d'inscription du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return date Date d'inscription
	*/
	public function date_inscription() {
		return $this->date_inscription;
	}

	/**
	*	Renvoie le nom du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Nom
	*/
	public function nom() {
		return $this->nom;
	}

	/**
	*	Renvoie le prénom du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Prénom
	*/
	public function prenom() {
		return $this->prenom;
	}

	/**
	*	Renvoie la date de naissance du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return date Date de naissance
	*/
	public function date_naissance() {
		return $this->date_naissance;
	}

	/**
	*	Renvoie le pays du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Pays
	*/
	public function pays() {
		return $this->pays;
	}

	/**
	*	Renvoie la ville du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Ville
	*/
	public function ville() {
		return $this->ville;
	}

	/**
	*	Renvoie le code postal du membre
	*	@version 14/01/2018 18:00
	*
	*	@param void
	*	@return string Code postal
	*/
	public function code_postal() {
		return $this->code_postal;
	}

	/**
	*	Renvoie l'adresse du membre
	*	@version 14/01/2018 18:00
	*
	*	@param void
	*	@return string Adresse
	*/
	public function adresse() {
		return $this->adresse;
	}

	/**
	*	Renvoie le numéro de téléphone du membre
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Numéro de téléphone
	*/
	public function numero_telephone() {
		return $this->numero_telephone;
	}

	/**
	*	Renvoie le tableau de valeurs de l'objet
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return array Tableau de valeurs de l'objet instancié
	*/
	public function toArray() {
		$this_vars = get_object_vars($this);

		return $this_vars;
	}
}