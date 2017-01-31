/**
 * Advertising
 * @type Object
 */
var Advertising = {};

/**
 * Fields
 * @type Object
 */
Advertising.Fields = {
	form: document.getElementById('form-advertising') || null,
	name: document.getElementById('name') || null,
	type: document.getElementById('type-advetising') || null,
	btn_file: document.querySelector('#button-file') || null,
	error_file: document.querySelector('.error-uploaded') || null
};

/**
 * responseServerAdd
 * @param  Object response
 * @return undefined
 */
Advertising.responseServerAdd = function(response) {
	console.log(response);

	if (response.hasOwnProperty('success')) {
		if (!response.success) {
			if (response.hasOwnProperty('messages')) {
				for (var msg in response.messages) {
					User.Fields[msg].classList.add('error');
					User.Fields[msg].nextElementSibling.innerHTML = response.messages[msg][0];
					User.Fields[msg].nextElementSibling.classList.add('show');
				}
			} else if (response.hasOwnProperty('message')) {
				Utilities.Snackbar(response.smessage, 'error');
			}
		} else {
			var message = (window.location.pathname === '/advertising/add') ? 'Publicidad agregada con éxito.' : 'Publicidad actualizada con éxito.';
			Utilities.Snackbar(message);

			setTimeout(function() {
				if (window.location.pathname === '/advertising/add') {
					Advertising.Fields.form.reset();
					window.location.reload();
				}
			}, 2000);
		}
	}
};

/**
 * add
 * @param  Object response
 * @return undefined
 */
Advertising.add = function(e) {
	e.preventDefault();
	var isValid = true;
	var name = Advertising.Fields.name;
	var type = Advertising.Fields.type;

	// reset form
	[].slice.call(document.querySelectorAll('.input')).forEach(function(element, index) {
		element.classList.remove('error');
		element.nextElementSibling.innerHTML = '';
	});

	if (name.value === '') {
		name.classList.add('error');
		name.nextElementSibling.innerHTML = Validations.messageForm.required;
	}

	if (type.value === '' && location.pathname === '/advertising/add') {
		type.classList.add('error');
		type.nextElementSibling.innerHTML = Validations.messageForm.required;
	}

	if (Validations.file.FILES === null && location.pathname === '/advertising/add') {
		document.getElementById('drop-zone').classList.add('error');
		isValid = false;
	}

	if (isValid) {
		var url = (window.location.pathname === '/advertising/add') ? window.location.pathname : window.location.pathname.replace('edit', 'update');
		var formData = new FormData(Advertising.Fields.form);
		formData.append("file", Validations.file.FILES);
		Ajax.send(url, "POST", "json", Advertising.responseServerAdd, formData, "FormData");
	} else {
		Utilities.Snackbar(Validations.messageForm.error_form, 'error');
	}
};

/**
 * selectedItemsDelete
 * @return undefined
 */
Advertising.selectedItemsDelete = function() {
	var buttonDelete = document.getElementById('delete-advertising');
	var allItems = Array.prototype.slice.call(document.querySelectorAll('input[data-advertising="true"]'));
	var count = 0;

	allItems.forEach(function(element, index) {
		if (element.checked) {
			count++;
		}
	});

	// hide - show button delete
	if (count > 0) {
		if (buttonDelete.classList.contains('hide')) {
			buttonDelete.classList.remove('hide');
		}
	} else if (!buttonDelete.classList.contains('hide')) {
		buttonDelete.classList.add('hide');
	}
};

/**
 * delete
 * @param  Object response
 * @return undefined
 */
Advertising.responseServerDelete = function(response) {
	if (response.hasOwnProperty('success')) {
		if (response.success) {
			window.location.reload();
		} else {
			Utilities.Snackbar(response.message, 'error');
		}
	}
};

/**
 * delete
 * @param  Object e
 * @return undefined
 */
Advertising.delete = function(e) {
	e.preventDefault();

	var itemsSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-advertising="true"]:checked'));
	var count = itemsSelectes.length;

	if (count === 0) {
		this.classList.add('hide');
		Utilities.Snackbar('Por favor, Selecciona un elemento de la lista.', 'error');
	} else {
		var json = {};
		json.items = [];

		itemsSelectes.forEach(function(e, i) {
			json.items.push(e.value);
		});

		Ajax.send(window.location.pathname + "/delete", "POST", "json", Advertising.responseServerDelete, JSON.stringify(json), "json");
	}
};

(function(d) {
	if (Advertising.Fields.form) {
		Advertising.Fields.form.addEventListener('submit', Advertising.add);
		Advertising.Fields.type.addEventListener('change', function() {
			this.nextElementSibling.innerHTML = '';
			this.classList.remove('error');

			// reset drop zone
			document.getElementById('drop-zone').innerHTML = '';

			if (this.value === '') {
				this.nextElementSibling.innerHTML = Validations.messageForm.required;
				this.classList.add('error');
			} else {
				Validations.file.MAX_FILE_SIZE = 20;
				Validations.file.upload('drop-zone', this.value, true);
				document.getElementById('drop-zone').parentNode.classList.remove('hide');
			}
		});
	} else if (window.location.pathname === '/advertising') {
		var allItems = Array.prototype.slice.call(document.querySelectorAll('input[data-advertising="true"]'));
		allItems.forEach(function(element, index) {
			element.addEventListener('change', Advertising.selectedItemsDelete);
		});

		// button delete
		document.getElementById('delete-advertising').addEventListener('click', Advertising.delete);
	}
})(document);
