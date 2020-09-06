// Une fois la page chargée
$(document).ready(function () {
	// Permet d'utiliser le Select de Materialize
	$('select').material_select();
	

	// Animation Tooltip
	$('.tooltipped').tooltip({delay: 50});
	

	// Calendrier
	var d = new Date();
	d.setFullYear(d.getFullYear() - 100);
	// Bornes du calendrier
	$('.datepicker').pickadate({
		selectMonths: true,
		selectYears: 99,
		min: d,
		max: new Date()
	});
});