// Teste le pattern de chaque input
function checkForm() {
	var inputs = $('input');
	var condition = true;

	// On teste chaque input
	for(var i = 0; i < inputs.length; i++) {
		if(inputs[i].hasAttribute('required') && !(inputs[i].validity.valid)) {
			condition = false;
		}
	}

	// Si toutes les conditions réunies, on réactive le bouton
	if(condition) {
		$('button[type="submit"]').attr('disabled', null);
	} else {
		$('button[type="submit"]').attr('disabled', '');
	}
}


// Une fois la page chargée
$(document).ready(function() {
	// Permet d'utiliser le Select de Materialize
	$('select').material_select();
	

	// Animation Tooltip
	$('.tooltipped').tooltip({delay: 50});


	// On désactive le bouton Submit par défaut
	$('button[type="submit"]').attr('disabled', '');

	// Pour chaque modification des input, on essaie de réactiver le bouton
	var inputs = $('input');
	for(var i = 0; i < inputs.length; i++) {
		inputs[i].addEventListener("keyup", checkForm);
	}

	// On le lance comme initialisation
	checkForm();
});