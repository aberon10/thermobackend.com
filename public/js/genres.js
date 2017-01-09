/**
 * Genre
 * Namspace for genres.
 * @type {Object}
 */
var Genre = {};

Genre.paths = {
	add: /^(\/genres\/add)$/,
	edit: /^(\/genres\/edit\/)+[0-9]{1,}$/
};

/**
 * Fields
 * @type {Object}
 */
Genre.Fields = {
	form_add   : document.getElementById('form-addgenre')   || null,
	delete     : document.getElementById('delete')  		|| null,
	deleteAll  : document.getElementById('delete-all')      || null,
	name_genre : document.getElementById('nombre_genero')   || null,
	description: document.getElementById('descripcion')     || null,
	file       : document.getElementById('file-genre')      || null,
	btn_add    : document.getElementById('add_genere')      || null,
	drop_zone  : document.getElementById('drop-zone')       || null,
	file_error : document.querySelector('p.error-uploaded') || null,
};

/**
 * helpBlocks
 * @type {Object}
 */
Genre.helpBlocks = {
	name_genre: "Utiliza sólo: letras, números, guiones, puntos, espacios y el signo &."
};

/**
 * responseServerAdd
 * @param  {String | Object} response
 * @return {undefined}
 */
Genre.responseServerAdd = function(response) {
	var messageFooter = document.getElementById('help-block');

	if (response) {
		if (response.hasOwnProperty('success') && !response.success) {

			messageFooter.classList.add('error');

			if (response.hasOwnProperty('message') && response.hasOwnProperty('exist') && response.exist) {
				Genre.Fields.name_genre.parentNode.classList.add('error');
				Genre.Fields.name_genre.nextElementSibling.innerHTML = Validations.messageForm.genre_exist;
			}

			if (response.hasOwnProperty('messages')) {
				// name genre
				if (response.messages.hasOwnProperty('nombre_genero')) {
					console.log("asd");
					Genre.Fields.name_genre.parentNode.classList.add('error');
					Genre.Fields.name_genre.nextElementSibling.innerHTML = response.messages.nombre_genero[0];
				}

				// description
				if (response.messages.hasOwnProperty('descripcion')) {
					Genre.Fields.description.parentNode.classList.add('error');
					Genre.Fields.description.nextElementSibling.innerHTML = response.messages.descripcion[0];
				}

				// image
				if (response.messages.hasOwnProperty('file')) {
					Genre.Fields.drop_zone.classList.add('error');
					Genre.Fields.file_error.innerHTML = response.messages.file[0];
				}
			}
		} else {
			if (Genre.paths.add.test(location.pathname)) {
				Genre.resetFormAdd(true);
			}
			messageFooter.classList.add('success');
		}

		if (response.hasOwnProperty('message')) {
			messageFooter.innerHTML = response.message;

			if (Genre.paths.edit.test(location.pathname)) {
				Genre.Fields.name_genre.value = response.nombre_genero;
				Genre.Fields.description.value = response.descripcion;
				if (response.src_img !== "") {
					document.getElementById('preview-element').src = "http://thermobackend.com/storage/"+response.src_img;
				}
			}
		}
	}
};

/**
 * uploadToServer
 * @return {undefined}
 */
Genre.uploadToServer = function() {
	var formData = null;
	var url      = window.location.href;

	// create a formData
	formData = new FormData();
    formData.append("nombre_genero", Genre.Fields.name_genre.value);
    formData.append("descripcion", Genre.Fields.description.value);
    formData.append("file", Validations.file.FILES);

    if (/^(\/genres\/edit\/)+[0-9]{1,}$/.test(location.pathname)) {
	    url = url.replace("edit", "update");
    }

    Ajax.send(url, "POST", "json", Genre.responseServerAdd, formData, "FormData");
};

/**
 * resetFormAdd
 * @param {Boolean} all
 * @return {undefined}
 */
Genre.resetFormAdd = function(all) {
	var nameGenre   = Genre.Fields.name_genre;
	var description = Genre.Fields.description;
	var messageFooter = document.getElementById('help-block');

	Genre.Fields.drop_zone.classList.remove('error');
	Genre.Fields.drop_zone.classList.remove('success');
	nameGenre.parentNode.classList.remove('error');
	nameGenre.nextElementSibling.innerHTML = "";
	description.parentNode.classList.remove('error');
	messageFooter.innerHTML = "";
	messageFooter.classList.remove('error');
	messageFooter.classList.remove('success');

	if (all) {
		Genre.Fields.form_add.reset();
		Validations.file.FILES = null;
		var preview     = document.getElementById('preview-element');
		var nameFile    = document.querySelector('.name_file');

		// preview file
		if (preview) {
			if (preview.tagName === 'DIV') {
				preview.innerHTML = "";
			} else {
				preview.src = "";
			}
		}

		// name file
		if (nameFile) {
			nameFile.innerHTML = "";
		}
	}
};

/**
 * add - update
 * @return {undefined}
 */
Genre.add = function() {
	event.preventDefault();

	var isValid         = true;
	var dropZone 		= Genre.Fields.drop_zone;
	var errorUploadFile = Genre.Fields.file_error;
	var nameGenre       = Genre.Fields.name_genre;
	var form            = Genre.Fields.form_add;
	var messageFooter   = document.getElementById('help-block');

	nameGenre.value = nameGenre.value.trim();

	// reset form
	Genre.resetFormAdd();

	// check name
	if (nameGenre.value === "") {
		nameGenre.nextElementSibling.innerHTML = Validations.messageForm.required;
		nameGenre.parentNode.classList.add('error');
		isValid = false;
	} else if (!Utilities.checkNameEntities(nameGenre.value)) {
		nameGenre.nextElementSibling.innerHTML = Genre.helpBlocks.name_genre;
		nameGenre.parentNode.classList.add('error');
		isValid = false;
	}

	// check files
	if (Validations.file.FILES === null && location.pathname === "/genres/add") {
		dropZone.classList.add('error');
		isValid = false;
	}

	if (isValid) {
		// send to form
		Genre.uploadToServer();
	} else {
		messageFooter.classList.add('error');
		messageFooter.innerHTML = Validations.messageForm.error_form;
	}
};

/**
 * checkAll
 * Selecciona todos los generos de la lista.
 *
 * @return {undefined}
 */
Genre.checkAll = function() {
	var allGenres      = Array.prototype.slice.call(document.querySelectorAll('input[data-genre="genre"]'));
	var genresSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-genre="genre"]:checked'));
	var count          = 0;
	var i              = 0;

	// si existe algun genero seleccionado le quito el check
	if (genresSelectes.length > 0) {
		count = genresSelectes.length;
		for (i = 0; i < count; i++) {
			genresSelectes[i].checked = false;
		}
	}

	count = 0;
	if (this.checked) {
		allGenres.forEach(function(element, index) {
			if (!element.checked) {
				element.checked = true;
			} else {
				element.setAttribute("checked", "true");
			}
			count++;
		});
	} else {
		allGenres.forEach(function(element, index) {
			element.removeAttribute("checked");
		});
	}

	// hide - show button delete
	if (count > 0) {
		if (Genre.Fields.delete.classList.contains('hide')) {
			Genre.Fields.delete.classList.remove('hide');
		}
	} else {
		if (!Genre.Fields.delete.classList.contains('hide')) {
			Genre.Fields.delete.classList.add('hide');
		}
	}

};

/**
 * SelectGenreToDelete
 * Cuando se marca/desmarca de a un genero, esta funcion comprueba
 * si existen mas generos marcados para mostrar o ocultar el boton de eliminar.
 *
 * @return {undefined}
 */
Genre.SelectGenreToDelete = function() {
	var allGenres = Array.prototype.slice.call(document.querySelectorAll('input[data-genre="genre"]'));
	var count = 0;

	allGenres.forEach(function(element, index) {
		if (element.checked) {
			count++;
		}
	});

	// hide - show button delete
	if (count > 0) {
		if (Genre.Fields.delete.classList.contains('hide')) {
			Genre.Fields.delete.classList.remove('hide');
		}
	} else {
		Genre.Fields.deleteAll.checked = false;
		if (!Genre.Fields.delete.classList.contains('hide')) {
			Genre.Fields.delete.classList.add('hide');
		}
	}
};

Genre.responseServerDelete = function(response) {
	var messageFooter = document.getElementById('help-block');

	if (response.hasOwnProperty('success')) {
		if (response.success) {
			window.location.reload();
		} else {
			messageFooter.innerHTML = response.message;
			messageFooter.classList.add('error');
		}
	}
};

Genre.delete = function(event) {
	event.preventDefault();
	var genresSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-genre="genre"]:checked'));
	var count          = genresSelectes.length;
	var messageFooter  = document.getElementById('help-block');

	if (count === 0) {
		this.classList.add('hide');
		messageFooter.innerHTML = "Por favor, Selecciona un género";
		messageFooter.classList.add('error');
	} else {

		var json = {};
		json.genres = [];

		genresSelectes.forEach(function(e, i) {
			json.genres.push(e.value);
		});

		Ajax.send(location.href+"/delete", "POST", "json", Genre.responseServerDelete, JSON.stringify(json), "json");
	}
};

(function(window, document) {

	var pathname = window.location.pathname;
	var create = true;

	// edit or add
	if (Genre.paths.edit.test(pathname) || Genre.paths.add.test(pathname)) {
		if (Genre.paths.edit.test(pathname)) {
			create = false;
		} else if (Genre.paths.add.test(pathname)) {
			create = true;
		}

		// validate upload file
		Validations.file.upload("drop-zone", "image", create);
		Genre.Fields.btn_add.addEventListener('click', Genre.add);
	} else {

		[].slice.call(document.querySelectorAll('input[data-genre="genre"]')).forEach(function(element, index) {
			element.addEventListener('click', Genre.SelectGenreToDelete);
		});

		// checkbox delete
		Genre.Fields.deleteAll.addEventListener('change', Genre.checkAll);

		// button delete
		Genre.Fields.delete.addEventListener('click', Genre.delete);
	}

}(window, document));
