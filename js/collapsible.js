// Remplace l'icône à l'ouverture du collapsible
function collapsible_ouverture(el) {
	// On récupère la partie de l'icône
	var chevron = $(el).find(".collapsible-chevron")[0];

	// Si l'élément est trouvé
	if (chevron)
	{
		// On change d'icône
		chevron.innerHTML = 'expand_less';
	}		
}

// Remplace l'icône à la fermeture du collapsible
function collapsible_fermeture(el) {
	// On récupère la partie de l'icône
	var chevron = $(el).find(".collapsible-chevron")[0];

	// Si l'élément est trouvé
	if (chevron)
	{
		// On change d'icône
		chevron.innerHTML = 'expand_more';
	}	
}


// Au chargement de la page
$(document).ready(function() {
	// On ajoute des événements à l'ouverture et à la fermeture d'un collapsible
	$('.collapsible').collapsible({
		onOpen: collapsible_ouverture,
		onClose: collapsible_fermeture
	});
});