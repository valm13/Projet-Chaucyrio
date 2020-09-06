<?php
class Item {
	// Caractéristiques de l'item
	private $id_item;						// ID de l'item
	private $nom_item;						// Nom de l'item
	private $description_item;				// Description de l'item
	private $stock;							// Stock disponible de l'item
	private $prix_unitaire;					// Prix unitaire de l'item

	private $quantite;						// Quantité dans le panier



	/**
	*	[Constructeur] Initialise l'item avec le tableau de valeurs en paramètre
	*	@version 30/12/2017 17:00
	*
	*	@param array $params Tableau de valeurs
	*	@return void
	*/
	public function __construct(array $params) {
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
	*	Renvoie l'ID de l'item
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return int ID
	*/
	public function id() {
		return $this->id_item;
	}

	/**
	*	Renvoie le nom de l'item
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Nom
	*/
	public function nom() {
		return $this->nom_item;
	}

	/**
	*	Renvoie la description de l'item
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return string Description
	*/
	public function description() {
		return $this->description_item;
	}

	/**
	*	Renvoie le stock disponible de l'item
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return int Stock disponible
	*/
	public function stock() {
		return $this->stock;
	}

	/**
	*	Renvoie le prix unitaire de l'item
	*	@version 30/12/2017 16:00
	*
	*	@param void
	*	@return int Prix unitaire
	*/
	public function prix_unitaire() {
		return $this->prix_unitaire;
	}

	/**
	*	Renvoie la quantité de l'item
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return int Quantité
	*/
	public function quantite() {
		return $this->quantite;
	}

	/**
	*	Renvoie le prix (selon la quantité) de l'item
	*	@version 30/12/2017 17:00
	*
	*	@param void
	*	@return int Prix
	*/
	public function prix() {
		return $this->quantite*$this->prix_unitaire;
	}



	/*
	*	Setters
	*/

	/**
	*	Modifie la quantité
	*	@version 30/12/2017 17:00
	*
	*	@param int $quantite Nouvelle quantité de l'item
	*	@return boolean
	*		true : modification réussie
	*		false : erreur survenue
	*/
	public function modifie_quantite($quantite) {
		// On vérifie qu'il s'agisse bien d'un nombre
		if (is_int($quantite)) {
			// Si la quantité est supérieure au stock
			if ($quantite > $this->stock)
			{
				// On limite la quantité au stock disponible
				$this->quantite = $this->stock;

				return true;
			}
			else
			{
				// On modifie la quantité
				$this->quantite = $quantite;

				return true;
			}
		}

		return false;
	}
}