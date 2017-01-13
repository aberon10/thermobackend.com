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
