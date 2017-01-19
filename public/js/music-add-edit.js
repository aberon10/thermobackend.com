/**
 * responseServerAdd
 * @param  {String | Object} response
 * @return {undefined}
 */
Music.responseServerAdd = function(response) {
	var messageFooter = document.getElementById('help-block');

	console.log(response);

	if (response) {
		if (response.hasOwnProperty('success') && !response.success) {

			messageFooter.classList.add('error');

			// exist
			if (response.hasOwnProperty('error')) {
				messageFooter.classList.add('error');
				messageFooter.innerHTML = response.error;
			}

			// exist
			if (response.hasOwnProperty('message') && response.hasOwnProperty('exist') && response.exist) {
				Music.Fields.name.parentNode.classList.add('error');
				Music.Fields.name.nextElementSibling.innerHTML = response.message_exist;
			}

			if (response.hasOwnProperty('messages')) {
				// nombre
				if (response.messages.hasOwnProperty('nombre')) {
					Music.Fields.name.parentNode.classList.add('error');
					Music.Fields.name.nextElementSibling.innerHTML = response.messages.nombre[0];
				}

				// descripcion
				if (response.messages.hasOwnProperty('descripcion')) {
					Music.Fields.description.parentNode.classList.add('error');
					Music.Fields.description.nextElementSibling.innerHTML = response.messages.descripcion[0];
				}

				// select
				if (response.messages.hasOwnProperty('select')) {
					Music.Fields.select.parentNode.classList.add('error');
					Music.Fields.select.nextElementSibling.innerHTML = response.messages.select[0];
				}

				// file
				if (response.messages.hasOwnProperty('file')) {
					Music.Fields.drop_zone.classList.add('error');
					Music.Fields.file_error.innerHTML = response.messages.file[0];
				}
			}
		} else {
			if (Music.paths.add.test(Music.PATHNAME)) {
				Music.resetForm(true);
			}
			messageFooter.classList.add('success');
		}

		if (response.hasOwnProperty('message')) {
			messageFooter.innerHTML = response.message;

			// update
			if (Music.paths.edit.test(location.pathname)) {
				Music.Fields.name.value = response.name;

				if (response.description) {
					Music.Fields.description.value = response.description;
				}

				if (response.select) {
					Music.Fields.select.querySelector('option[value="' + response.select + '"]').setAttribute('selected', 'true');
				}

				if (response.src !== "") {
					document.getElementById('preview-element').firstElementChild.src = "http://thermobackend.com/storage/" + response.src + "?r=" +
						Math.floor(Math.random() * 1000);
				}
			}
		}
	}
};

/**
 * uploadToServer
 * @return {undefined}
 */
Music.uploadToServer = function() {
	var formData = null;
	var url = window.location.href;

	// create a formData
	formData = new FormData();
	formData.append("nombre", Music.Fields.name.value);
	formData.append("descripcion", (Music.Fields.description !== null) ? Music.Fields.description.value : '');
	formData.append("select", (Music.Fields.select !== null) ? Music.Fields.select.value : '');
	formData.append("file", Validations.file.FILES);
	formData.append("cant_pistas", (Music.Fields.quantity_tracks) ? Music.Fields.quantity_tracks.value : '');
	formData.append("anio", (Music.Fields.year) ? Music.Fields.year.value : '');

	if (Music.paths.edit.test(Music.PATHNAME)) {
		url = url.replace("edit", "update");
	}

	Ajax.send(url, "POST", "json", Music.responseServerAdd, formData, "FormData");
};

/**
 * resetFormAdd
 * @param {Boolean} all
 * @return {undefined}
 */
Music.resetForm = function(all) {
	var name = Music.Fields.name;
	var description = Music.Fields.description;
	var select = Music.Fields.select;
	var quantityTracks = Music.Fields.quantity_tracks;
	var year = Music.Fields.year;
	var messageFooter = document.getElementById('help-block');

	Music.Fields.drop_zone.classList.remove('error');
	Music.Fields.drop_zone.classList.remove('success');

	name.parentNode.classList.remove('error');
	name.nextElementSibling.innerHTML = "";

	if (select) {
		select.parentNode.classList.remove('error');
		select.nextElementSibling.innerHTML = "";
	}

	if (description) {
		description.parentNode.classList.remove('error');
	}

	if (quantityTracks) {
		quantityTracks.parentNode.classList.remove('error');
		quantityTracks.nextElementSibling.innerHTML = "";
	}

	if (year) {
		year.parentNode.classList.remove('error');
		year.nextElementSibling.innerHTML = "";
	}

	messageFooter.innerHTML = "";
	messageFooter.classList.remove('error');
	messageFooter.classList.remove('success');

	if (all) {
		var preview = document.getElementById('preview-element');
		var nameFile = document.querySelector('.name_file');

		Music.Fields.form.reset();
		Validations.file.FILES = null;

		// preview file
		if (preview) {
			if (preview.tagName === 'DIV') {
				preview.innerHTML = "";
			} else {
				preview.src = "";
			}
			preview.parentNode.removeChild(preview);
		}

		// name file
		if (nameFile) {
			nameFile.innerHTML = "";
		}
	}
};

Music.add = function(e) {
	e.preventDefault();

	var isValid = true;
	var dropZone = Music.Fields.drop_zone;
	var errorUploadFile = Music.Fields.file_error;
	var name = Music.Fields.name;
	var description = Music.Fields.description;
	var select = Music.Fields.select;
	var form = Music.Fields.form;
	var messageFooter = document.getElementById('help-block');
	var quantityTracks = Music.Fields.quantity_tracks;
	var year = Music.Fields.year;

	name.value = name.value.trim();

	// reset form
	Music.resetForm();

	// check name
	if (name.value === "") {
		isValid = false;
		name.parentNode.classList.add('error');
		name.nextElementSibling.innerHTML = Validations.messageForm.required;
	} else if (!Utilities.checkNameEntities(name.value)) {
		isValid = false;
		name.parentNode.classList.add('error');
		name.nextElementSibling.innerHTML = Music.HelpBlocks.name;
	}

	// check select item
	// artist | album | track
	if (select !== null) {
		if (select.selectedOptions[0].value === "") {
			isValid = false;
			select.parentNode.classList.add('error');
			select.nextElementSibling.innerHTML = Validations.messageForm.required;
		}
	}

	// description
	if (description !== null) {
		if (description.value.length > 250) {
			isValid = false;
			description.parentNode.classList.add('error');
			description.nextElementSibling.innerHTML = Validations.messageForm.error_description;
		}
	}

	// quantity tracks
	if (quantityTracks !== null) {
		if (quantityTracks.value === "") {
			isValid = false;
			quantityTracks.parentNode.classList.add('error');
			quantityTracks.nextElementSibling.innerHTML = Validations.messageForm.required;
		} else if (!Utilities.checkNumber(quantityTracks.value)) {
			isValid = false;
			quantityTracks.parentNode.classList.add('error');
			quantityTracks.nextElementSibling.innerHTML = Validations.messageForm.quantity_tracks;
		}
	}

	// year
	if (year !== null) {
		if (year.value === "") {
			isValid = false;
			year.parentNode.classList.add('error');
			year.nextElementSibling.innerHTML = Validations.messageForm.required;
		}
	}

	// check file
	if (Validations.file.FILES === null && Music.paths.add.test(Music.PATHNAME)) {
		dropZone.classList.add('error');
		isValid = false;
	}

	if (isValid) {
		// send form
		Music.uploadToServer();
	} else {
		messageFooter.classList.add('error');
		messageFooter.innerHTML = Validations.messageForm.error_form;
	}
};
