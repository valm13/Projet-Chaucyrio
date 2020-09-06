// Renvoie le nombre de caractère du textarea donné
function nbCarac(selecteur) {
	return $(selecteur)[0].value.length;
}


// Teste le pattern de chaque input
function checkForm() {
	var inputs = $('input');		// On sélectionne les input
	var condition = true;			// Booléen de test des champs

	// On teste chaque input
	for (var i = 0; i < inputs.length; i++)
	{
		if (inputs[i].hasAttribute('required') && !(inputs[i].validity.valid))
		{
			condition = false;
		}
	}

	if (nbCarac("#texte") < 100)
	{
    	condition = false;
    }
    else
    {
    	condition = true;
    }

	// Si toutes les conditions réunies, on réactive le bouton
	if (condition)
	{
		console.log('condition true');
		$('button[type="submit"]').attr('disabled', null);
	}
	else
	{
		console.log('condition false');
		$('button[type="submit"]').attr('disabled', '');
	}

}

// Une fois la page chargée
$(document).ready(function() {
	// Animation Tooltip
	$('.tooltipped').tooltip({delay: 50});

	// On désactive le bouton Submit par défaut
	$('button[type="submit"]').attr('disabled', '');

	// Pour chaque modification des input, on essaie de réactiver le bouton
	var inputs = $('input, textarea');
	for (var i = 0; i < inputs.length; i++)
	{
		inputs[i].addEventListener("keyup", checkForm);
	}

	// On le lance comme initialisation
	checkForm();
});