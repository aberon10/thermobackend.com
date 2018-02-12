/**
 * Validations
 * @type Object
 */
var Validations = {};

/**
 * messageForm
 * Objeto con los mensajes utilizados en los formularios.
 *
 * @type Object
 */
Validations.messageForm = {
	error_form: "Por favor, Comprueba los errores.",
	success_form: "Enviado con exito.",
	required: "El campo es requerido.",
	error_name: "El nombre ingresado no es valido.",
	error_value: "El valor ingresado no es valido.",
	error_description: "La descripción, no debe superar los 250 caracteres.",
	password: 'Utiliza al menos una combinación entre 8 y 30 números, letras, guiones y signos de puntuación (como ! y &).',

	// genre
	genre_add: "Genero agregado con exito.",
	genre_exist: "El género, ya existe.",

	// artist
	artist_add: "Artista agregado con exito.",
	artist_exist: "El artista, ya existe.",

	// album
	album_add: "Album agregado con exito.",
	album_exist: "El album, ya existe.",
	quantity_tracks: "El valor ingresado no es valido.",

	// track
	track_add: "Pista agregada con exito.",
	track_exist: "La pista, ya existe."
};

/**
 * username
 * Validate username
 * @param  String username
 * @return Object response
 */
Validations.username = function(username) {
	var response = {
		success: true
	};

	if (username === "") {
		response = {
			success: false,
			message: Validations.messageForm.required
		};
	} else if (!Utilities.regExp.username.test(username)) {
		response = {
			success: false,
			message: Validations.messageForm.error_name
		};
	}

	return response;
};

/**
 * name
 * Validate name and lastname
 * @param  String name
 * @return Object response
 */
Validations.name = function(name) {
	var response = {
		success: true
	};

	if (name === '') {
		response = {
			success: false,
			message: Validations.messageForm.required
		};
	} else if (!Utilities.regExp.name.test(name)) {
		response = {
			success: false,
			message: Validations.messageForm.error_value
		};
	}

	return response;
};

/**
 * email
 * Validate email
 * @param  String email
 * @return Object response
 */
Validations.email = function(email) {
	var response = {
		success: true
	};

	if (email === "") {
		response = {
			success: false,
			message: Validations.messageForm.required
		};
	} else if (!Utilities.regExp.email.test(email)) {
		response = {
			success: false,
			message: "El correo ingresado no es valido"
		};
	}

	return response;
};


/**
 * numberOfDays
 * Esta función devuelve el número de días que tiene un determinado mes
 * considerando también si el año es bisiesto
 *
 * @param  number month
 * @param  number year
 * @return number
 */
Validations.numberOfDays = function(month, year) {
	if (month === 1 && year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) {
		return 29;
	} else {
		return [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
	}
};

/**
 * birthdate
 * Validate birthdate
 * @param  String birthdate
 * @return Object response
 */
Validations.birthdate = function(day, month, year) {
	var response = {
		success: true
	};

	if (day === "" || month === "" || year === "") {
		response = {
			success: false,
			message: Validations.messageForm.required
		};
	} else {
		var birthdate = day + '/' + month + '/' + year;
		if ((!Utilities.regExp.date.test(birthdate)) || (parseInt(day) > Validations.numberOfDays(month - 1, year))) {
			response = {
				success: false,
				message: 'La fecha ingresada no es valida'
			};
		} else if (((new Date()).getFullYear() - year) < 18) {
			response = {
				success: false,
				message: 'Debe ser mayor de edad.'
			};
		}
	}
	return response;
};
