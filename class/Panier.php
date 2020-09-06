<?php
class Panier {
	// Tableau d'items (items dans le panier)
	private $items;



	/**
	*	[Constructeur] Initialise le tableau d'items
	*	@version 11/12/2017 18:00
	*
	*	@param void
	*	@return void
	*/
	public function __construct() {
		$this->items = array();
	}



	/**
	*	Renvoie le tableau d'items du panier
	*	@version 30/12/2017 16:00
	*
	*	@param void
	*	@return array Tableau d'items du panier
	*/
	public function affiche() {
		return $this->items;
	}



	/**
	*	Vide le panier
	*	@version 30/12/2017 16:00
	*
	*	@param void
	*	@return void
	*/
	public function vide() {
		$this->items = array();
	}



	/**
	*	Indique si l'item est présent dans le panier
	*	@version 30/12/2017 16:00
	*
	*	@param string $id_item ID de l'item à vérifier
	*	@return int Quantité de l'objet (0 si non-présent)
	*/
	public function est_dans($id_item) {
		foreach ($this->items as $key => $value)
		{
			if ($value->id() == $id_item)
			{
				return $value->quantite();
			}
		}

		return 0;
	}



	/**
	*	Indique si le panier est vide
	*	@version 05/01/2017 16:00
	*
	*	@param void
	*	@return boolean
	*		true : panier vide
	*		false : panier non vide
	*/
	public function est_vide() {
		return ( count($this->items) > 0 ) ? false : true;
	}



	/**
	*	Supprime l'item donné du panier
	*	@version 30/12/2017 16:00
	*
	*	@param string $id_item ID de l'item à supprimer
	*	@return boolean
	*		true : item supprimé
	*		false : suppresion ratée (non-présent ou erreur)
	*/
	public function supprime($id_item) {
		// On cherche l'index de la valeur à supprimer
		foreach ($this->items as $key => $value)
		{
			// Si l'ID est trouvé
			if ($value->id() == $id_item)
			{
				// On supprime la valeur
				unset($this->items[$key]);

				return true;
			}
		}

		return false;
	}



	/**
	*	Modifie l'item donné du panier
	*	@version 30/12/2017 16:00
	*
	*	@param
	*		string $id_item ID de l'item à modifier
	*		int $quantite Nouvelle quantité de l'item
	*	@return boolean
	*		true : item modifié
	*		false : item non trouvé ou erreur
	*/
	public function modifie($id_item, $quantite) {
		// On parcourt le panier
		foreach ($this->items as $key => $value) {
			// Si l'id est trouvé
			if ($value->id() == $id_item)
			{
				// Si la nouvelle quantité est négative
				if ($quantite <= 0)
				{
					// On supprime l'item
					unset($this->items[$key]);
				}
				else
				{
					// Sinon on modifie la quantité
					return $this->items[$key]->modifie_quantite($quantite);
				}

				return true;
			}
		}

		// Si l'item n'est pas présent et que la nouvelle quantité est strictement postive
		if ($quantite > 0)
		{
			// On essaie d'ajouter l'item
			return $this->ajoute($id_item, $quantite);
		}

		// L'item n'est pas dans le panier, mais sa quantité étant négative, on présume que la modification s'est bien déroulée
		return true;
	}



	/**
	*	Ajoute un item dans le panier
	*	@version 30/12/2017 16:00
	*
	*	@param
	*		string $id_item ID de l'item à ajouter
	*		int $quantite Quantité de l'item
	*	@return boolean
	*		true : ajout réussi
	*		false : erreur survenue
	*/
	public function ajoute($id_item, $quantite) {
		// Si l'item est déjà présent dans le panier (quantité > 0)
		if ($ancien = $this->est_dans($id_item))
		{
			// On ajoute la nouvelle quantité à l'ancienne
			return $this->modifie($id_item, $ancien+$quantite);
		}

		// On se connecte à la BDD
		$man = new ChaussureManager(true);

		// On récupère l'item correspond depuis la BDD
		$item = $man->item($id_item);

		// Si l'item est récupéré
		if (is_a($item, 'Item') && !is_null($item))
		{
			// On rajoute la bonne quantité
			$item->modifie_quantite($quantite);
			// On ajoute l'item au panier
			array_push($this->items, $item);

			return true;
		}

		return false;
	}
}