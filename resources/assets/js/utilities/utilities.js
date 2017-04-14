/**
 * Utilities
 * @type {Object}
 */
var Utilities = {};

/**
 * checkColorHEX
 * Comprueba el formato de un color hexadecimal.
 *
 * @param  {String} color
 * @return {Boolean}
 */
Utilities.checkColorHEX = function(color) {
	if (/^(#)+[A-Z0-9]{6}$/.test(color) || /^(#)+[A-Z0-9]{3}$/.test(color)) {
		return true;
	} else {
		return false;
	}
};

/**
 * checkNameEntities
 * @param  {String} nameEntity
 * @return {Boolean}
 */
Utilities.checkNameEntities = function(nameEntity) {
	if (/^[A-Za-z-ÁÉÍÓÚÑáéíóúñ0-9\_\&\-\.\'\"\s]{2,60}$/.test(nameEntity)) {
		return true;
	} else {
		return false;
	}
};

/**
 * checkNameEntities
 * @param  {Number} number
 * @return {Boolean}
 */
Utilities.checkNumber = function(number) {
	if (/^\d+$/.test(parseInt(number))) {
		return true;
	} else {
		return false;
	}
};

Utilities.regExp = {
	name: /^[A-Za-z-ÁÉÍÓÚÑáéíóúñ\s]{2,60}$/,
	username: /^[a-z0-9\_]+$/,
	email: /^([\w_\.\-]{4,60})@(([\w\-]{2,25})+\.)+([\w]{2,20})$/,
	date: /^(\d{1,2})+\/+(\d{1,2})+\/+(\d{4})$/,
	password: /^[A-za-z0-9\_\-\!\&]{8, 30}$/
};

// snackbar
Utilities.Snackbar = function(message, className) {
	// Get the snackbar DIV
	var snackbar = document.getElementById("snackbar");
	var btnAdd = document.getElementById('add');

	// Add message
	snackbar.innerHTML = (message !== '') ? message : '';

	className = (className && className === 'error') ? 'snackbar-error' : 'snackbar-success';

	// Add the "show" class to DIV
	snackbar.classList.add('show');
	snackbar.classList.add(className);

	// After 3 seconds, remove the show class from DIV
	setTimeout(function() {
		snackbar.classList.remove('show');
		snackbar.classList.remove((className !== '') ? className : '');
	}, 3000);
};

Utilities.DateFormat = function(date) {
	var temp_date = date.split(' ');
	var new_format_date = temp_date[0].split('-');
	return new_format_date[2] + '-' + new_format_date[1] + '-' + new_format_date[0] + " " + temp_date[1];
};
