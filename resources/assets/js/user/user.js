var User = {};

/**
 * Fields
 * @type Object
 */
User.Fields = {
	form: document.getElementById('form-user') || null,
	username: document.getElementById('usuario') || null,
	account: document.getElementById('cuenta') || null,
	name: document.getElementById('nombre') || null,
	lastname: document.getElementById('apellido') || null,
	email: document.getElementById('correo') || null,
	sex: document.getElementById('sexo') || null,
	day: document.getElementById('day') || null,
	month: document.getElementById('month') || null,
	year: document.getElementById('year') || null,
	password: document.getElementById('pass') || null,
	confirm_password: document.getElementById('confirm_password') || null,
	items_delete: document.querySelectorAll('input[data-user="true"]') || null,
	delete: document.getElementById('delete-user') || null
};

User.resetForm = function(all) {
	var inputs = [].slice.call(document.querySelectorAll('.input'));
	document.getElementById('tooltip-date').classList.remove('show');

	inputs.forEach(function(element, index) {
		if (element.classList.contains('error')) {
			element.classList.remove('error');

			if (!element.classList.contains('select')) {
				element.previousElementSibling.innerHTML = '';
				element.previousElementSibling.classList.remove('show');
			}
		}
	});
};

/**
 * add
 */
User.add = function() {
	var username = User.Fields.username;
	var account = User.Fields.account;
	var name = User.Fields.name;
	var lastname = User.Fields.lastname;
	var day = User.Fields.day;
	var month = User.Fields.month;
	var year = User.Fields.year;
	var tooltipDate = document.getElementById('tooltip-date');
	var email = User.Fields.email;
	var sex = User.Fields.sex;
	var password = User.Fields.password;
	var confirm_password = User.Fields.confirm_password;
	var valid = true;
	var response = null;

	User.resetForm();

	// validate username
	response = Validations.username(username.value.toLowerCase().trim());
	if (!response.success) {
		username.classList.add('error');
		username.previousElementSibling.classList.add('show');
		username.previousElementSibling.innerHTML = response.message;
		valid = false;
	}

	// validate account
	if (account.value === '') {
		account.classList.add('error');
		account.previousElementSibling.classList.add('show');
		account.previousElementSibling.innerHTML = Validations.messageForm.required;
		valid = false;
	}

	// validate name
	response = Validations.name(name.value.trim());
	if (!response.success) {
		name.classList.add('error');
		name.previousElementSibling.classList.add('show');
		name.previousElementSibling.innerHTML = response.message;
		valid = false;
	}

	// validate lastname
	response = Validations.name(lastname.value.trim());
	if (!response.success) {
		lastname.classList.add('error');
		lastname.previousElementSibling.classList.add('show');
		lastname.previousElementSibling.innerHTML = response.message;
		valid = false;
	}

	// validate birthdate
	if (lastname.value !== '') {
		response = Validations.name(lastname.value.trim());
		if (!response.success) {
			lastname.classList.add('error');
			lastname.previousElementSibling.classList.add('show');
			lastname.previousElementSibling.innerHTML = response.message;
			valid = false;
		}
	}

	// validate birthdate
	response = Validations.birthdate(day.value, month.value, year.value);
	if (!response.success) {
		day.classList.add('error');
		month.classList.add('error');
		year.classList.add('error');
		tooltipDate.classList.add('show');
		tooltipDate.innerHTML = response.message;
		valid = false;
	}

	// validate email
	response = Validations.email(email.value.toLowerCase().trim());
	if (!response.success) {
		email.classList.add('error');
		email.previousElementSibling.classList.add('show');
		email.previousElementSibling.innerHTML = response.message;
		valid = false;
	}

	// validate sex
	if (sex.value === '') {
		sex.classList.add('error');
		sex.previousElementSibling.classList.add('show');
		sex.previousElementSibling.innerHTML = Validations.messageForm.required;
		valid = false;
	}

	if (!valid) {
		Utilities.Snackbar('Por favor, Comprueba los errores.', 'error');
	} else {
		var formData = new FormData(User.Fields.form);

		Animations.loaderMessage.innerHTML = 'Procesando solicitud...';
		Animations.showHideLoader();

		Ajax.send(location.href, "POST", "json", User.responseServerAdd, formData, "FormData");
	}
};

/**
 * responseServerAdd
 * @param  Object response
 * @return undefined
 */
User.responseServerAdd = function(response) {
	if (response.hasOwnProperty('success')) {
		if (!response.success) {
			if (response.hasOwnProperty('messages')) {
				for (var msg in response.messages) {
					User.Fields[msg].classList.add('error');
					User.Fields[msg].previousElementSibling.innerHTML = response.messages.username;
					User.Fields[msg].previousElementSibling.classList.add('show');
				}
			}
		} else {
			Utilities.Snackbar("Usuario Registrado con exito. <span class='icon-check'></span>");
			User.Fields.form.reset();
			Animations.loaderMessage.innerHTML = '';
			Animations.showHideLoader();
		}
	}
};

/**
 * selectItemDelete
 * @return undefined
 */
User.selectItemDelete = function() {
	var allItems = Array.prototype.slice.call(document.querySelectorAll('input[data-user="true"]'));
	var count = 0;

	allItems.forEach(function(element, index) {
		if (element.checked) {
			count++;
		}
	});

	// hide - show button delete
	if (count > 0) {
		if (User.Fields.delete.classList.contains('hide')) {
			User.Fields.delete.classList.remove('hide');
		}
	} else {
		if (!User.Fields.delete.classList.contains('hide')) {
			User.Fields.delete.classList.add('hide');
		}
	}
};

/**
 * responseServerDelete
 * @param  Object response
 * @return undefined
 */
User.responseServerDelete = function(response) {
	if (response.hasOwnProperty('success')) {
		if (response.success) {
			window.location.reload();
		} else {
			Utilities.Snackbar((response.hasOwnProperty('message')) ? response.message : 'Lo sentimos, ocurrio un error', 'error');
			Animations.loaderMessage.innerHTML = '';
			Animations.showHideLoader();
		}
	}
};

/**
 * delete
 * @param  Object e
 * @return undefined
 */
User.delete = function(e) {
	e.preventDefault();

	var itemsSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-user="true"]:checked'));
	var count = itemsSelectes.length;

	if (count === 0) {
		this.classList.add('hide');
		Utilities.Snackbar('Por favor, selecciona un usuario.', 'error');
	} else {

		var json = {};
		json.items = [];

		itemsSelectes.forEach(function(e, i) {
			json.items.push(e.value);
		});

		Animations.loaderMessage.innerHTML = 'Procesando solicitud...';
		Animations.showHideLoader();

		Ajax.send(location.href + "/delete", "POST", "json", User.responseServerDelete, JSON.stringify(json), "json");
	}
};

/**
 * addEventDelete
 * @return undefined
 */
User.addEventDelete = function() {
	if (User.Fields.items_delete) {
		// delete
		[].slice.call(document.querySelectorAll('input[data-user="true"]')).forEach(function(element, index) {
			element.addEventListener('click', User.selectItemDelete);
		});

		if (User.Fields.delete) {
			User.Fields.delete.addEventListener('click', User.delete);
		}
	}
};

(function(d) {
	var btnAdd = d.getElementById('add');

	if (User.Fields.form) {
		User.Fields.form.addEventListener('submit', function(e) {
			e.preventDefault();
			btnAdd.click();
		});
	}

	if (btnAdd) {
		btnAdd.addEventListener('click', function(e) {
			e.preventDefault();

			if (User.Fields.form) {
				User.add();
			}
		});
	}

	User.addEventDelete();
}(document));
