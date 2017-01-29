/**
 * User
 * @type Object
 */
var User = {};

/**
 * Fields
 * @type Object
 */
User.Fields = {
	form: document.getElementById('form-user') || null,
	form_change_image: document.getElementById('form-change-image') || null,
	form_change_password: document.getElementById('form-change-password') || null,
	drop_zone: document.getElementById('drop-zone') || null,
	error_uploaded: document.querySelector('.error-uploaded') || null,
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


/*******************************************************************
						ADD - UPDATE
 *******************************************************************/

/**
 * resetForm
 * @param  Boolean all
 * @return undefined
 */
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
			var message = null;

			if (location.pathname === '/users/add') {
				message = "Usuario Registrado con exito. <span class='icon-check'></span>";
			} else if (location.pathname === '/users/edit') {
				message = "Cuenta actualizada con exito. <span class='icon-check'></span>";
			}

			Utilities.Snackbar(message);
			User.Fields.form.reset();
			Animations.loaderMessage.innerHTML = '';
			Animations.showHideLoader();
		}
	}
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

	if (account) {
		// validate account
		if (account.value === '') {
			account.classList.add('error');
			account.previousElementSibling.classList.add('show');
			account.previousElementSibling.innerHTML = Validations.messageForm.required;
			valid = false;
		}
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
		var url = (location.pathname === '/users/edit') ? location.href.replace('edit', 'update') : location.pathname;

		Animations.loaderMessage.innerHTML = 'Procesando solicitud...';
		Animations.showHideLoader();

		Ajax.send(url, "POST", "json", User.responseServerAdd, formData, "FormData");
	}
};

/*******************************************************************
							DELETE
 *******************************************************************/

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

/*******************************************************************
						CHANGE IMAGE
 *******************************************************************/

/**
 * responseServerUpdate
 * @param  Object response
 * @return undefined
 */
User.responseServerUpdate = function(response) {
	if (response.hasOwnProperty('success')) {
		Animations.loaderMessage.innerHTML = '';
		Animations.showHideLoader();
		if (response.success) {
			Utilities.Snackbar("Imágen cambiada con éxito. <span class='icon-check'></span>");
			// Actualizo la ruta de la imagen
			// date = new Date();
			// document.querySelector('.info-user__avatar img').src = response.src + '?' + date.getTime();
			// document.querySelector('#dropdown-toggle img').src = response.src + '?' + date.getTime();
			setTimeout(function() {
				window.location.reload();
			}, 2000);
		} else {
			if (response.hasOwnProperty('message')) {
				User.Fields.drop_zone.classList.add('error');
				Utilities.Snackbar(response.message, 'error');
			}
		}
	}
};

/**
 * changeImage
 * @return undefined
 */
User.changeImage = function() {
	var isValid = true;

	User.Fields.drop_zone.classList.remove('error');

	// check image
	if (Validations.file.FILES === null) {
		User.Fields.drop_zone.classList.add('error');
		isValid = false;
	}

	if (isValid) {
		var formData = new FormData();
		var url = (location.pathname === '/users/edit') ? location.href.replace('edit', 'updateimage') : location.pathname;

		formData.append("file", Validations.file.FILES);

		Animations.loaderMessage.innerHTML = 'Procesando solicitud...';
		Animations.showHideLoader();
		Ajax.send(url, "POST", "json", User.responseServerUpdate, formData, "FormData");
	} else {
		Utilities.Snackbar(Validations.messageForm.error_form, 'error');
	}
};

/*******************************************************************
						CHANGE PASSWORD
 *******************************************************************/

/**
 * responseServerChangePassword
 * @param  Object response
 * @return undefined
 */
User.responseServerChangePassword = function(response) {
	if (response.hasOwnProperty('success')) {
		Animations.showHideLoader();
		if (response.success) {
			Utilities.Snackbar(response.message + "<span class='icon-check'></span>");
			User.Fields.form_change_password.reset();
		} else {
			if (response.hasOwnProperty('messages')) {
				for (var msg in response.messages) {
					document.getElementById(msg).classList.add('error');
					document.getElementById(msg).nextElementSibling.innerHTML = response.messages[msg][0];
				}
			}
		}
	}
};

/**
 * changePassword
 * @return undefined
 */
User.changePassword = function() {
	var currentPassword = document.getElementById('current_password');
	var newPassword = document.getElementById('new_password');
	var confirmPassword = document.getElementById('confirm_password');
	var isValid = true;

	// reset form
	var elements = [].slice.call(document.querySelectorAll('input[type="password"]'));
	elements.forEach(function(e, i) {
		e.classList.remove('error');
		e.nextElementSibling.innerHTML = '';
	});

	if (currentPassword.value === "") {
		currentPassword.classList.add('error');
		currentPassword.nextElementSibling.innerHTML = Validations.messageForm.required;
		isValid = false;
	}

	if (newPassword.value === "") {
		newPassword.classList.add('error');
		newPassword.nextElementSibling.innerHTML = Validations.messageForm.required;
		isValid = false;
	} else if (!/([A-Za-z\_\.\-]+\d+\W+)/gi.test(newPassword.value) && (newPassword.value.length < 8 || newPassword.value.length > 30)) {
		newPassword.classList.add('error');
		newPassword.nextElementSibling.innerHTML = "Utiliza entre 8 y 30 caracteres, incluyendo letras, números y signos de puntuación (ejemplo & y -).";
		isValid = false;
	}

	if (confirmPassword.value === "") {
		confirmPassword.classList.add('error');
		confirmPassword.nextElementSibling.innerHTML = Validations.messageForm.required;
		isValid = false;
	} else if (confirmPassword.value !== newPassword.value) {
		confirmPassword.classList.add('error');
		confirmPassword.nextElementSibling.innerHTML = "La contraseña no coincide.";
		isValid = false;
	}

	if (!isValid) {
		Utilities.Snackbar('Por favor, Comprueba los errores.', 'error');
	} else {
		var formData = new FormData(User.Fields.form_change_password);
		var url = (location.pathname === '/users/edit') ? location.href.replace('edit', 'changepassword') : location.pathname;

		Animations.showHideLoader();
		Ajax.send(url, "POST", "json", User.responseServerChangePassword, formData, "FormData");
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

	// change image
	if (User.Fields.form_change_image) {
		// validate upload file
		Validations.file.MAX_FILE_SIZE = 8;
		Validations.file.upload("drop-zone", "image", true);

		User.Fields.form_change_image.addEventListener('submit', function(e) {
			e.preventDefault();
			User.changeImage();
		});
	}

	// change password
	if (User.Fields.form_change_password) {
		User.Fields.form_change_password.addEventListener('submit', function(e) {
			e.preventDefault();
			User.changePassword();
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
