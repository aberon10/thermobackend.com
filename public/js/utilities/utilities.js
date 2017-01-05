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


Utilities.checkNameEntities = function(nameEntity) {
	if (/^[A-Za-z-ÁÉÍÓÚÑáéíóúñ0-9\_\&\-\.\s]{2,60}$/.test(nameEntity)) {
		return true;
	} else {
		return false;
	}
};

/**
 * messageForm
 *
 * Objeto con los mensajes utilizados en los formularios.
 * @type {Object}
 */
var messageForm = {
	error_form   : "Por favor, Comprueba los errores",
	success_form : "Enviado con exito.",
	required     : "El campo es requerido.",
	error_name   : "El nombre ingresado no es valido.",
};
