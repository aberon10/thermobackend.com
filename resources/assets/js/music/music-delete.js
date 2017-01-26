/**
 * checkAll
 * Selecciona todos los elementos de la lista.
 *
 * @return undefined
 */
Music.checkAll = function() {
	var allItems = Array.prototype.slice.call(document.querySelectorAll('input[data-music="true"]'));
	var itemsSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-music="true"]:checked'));
	var count = 0;
	var i = 0;

	// si existe un item seleccionado le quito el check
	if (itemsSelectes.length > 0) {
		count = itemsSelectes.length;
		for (i = 0; i < count; i++) {
			itemsSelectes[i].checked = false;
		}
	}

	count = 0;
	if (this.checked) {
		allItems.forEach(function(element, index) {
			if (!element.checked) {
				element.checked = true;
			} else {
				element.setAttribute("checked", "true");
			}
			count++;
		});
	} else {
		allItems.forEach(function(element, index) {
			element.removeAttribute("checked");
		});
	}

	// hide - show button delete
	if (count > 0) {
		if (Music.Fields.delete.classList.contains('hide')) {
			Music.Fields.delete.classList.remove('hide');
		}
	} else {
		if (!Music.Fields.delete.classList.contains('hide')) {
			Music.Fields.delete.classList.add('hide');
		}
	}
};

/**
 * selectItemDelete
 * Cuando se marca/desmarca de a un genero, esta funcion comprueba
 * si existen otros generos marcados para mostrar o ocultar el boton de eliminar.
 *
 * @return undefined
 */
Music.selectItemDelete = function() {
	var allItems = Array.prototype.slice.call(document.querySelectorAll('input[data-music="true"]'));
	var count = 0;

	allItems.forEach(function(element, index) {
		if (element.checked) {
			count++;
		}
	});

	// hide - show button delete
	if (count > 0) {
		if (Music.Fields.delete.classList.contains('hide')) {
			Music.Fields.delete.classList.remove('hide');
		}
	} else {
		Music.Fields.deleteAll.checked = false;
		if (!Music.Fields.delete.classList.contains('hide')) {
			Music.Fields.delete.classList.add('hide');
		}
	}
};

/**
 * responseServerDelete
 * @param  Object response
 * @return undefined
 */
Music.responseServerDelete = function(response) {
	if (response.hasOwnProperty('success')) {
		if (response.success) {
			window.location.reload();
		} else {
			Utilities.Snackbar(response.message, 'error');
			Animations.showHideLoader();
			Animations.loaderMessage.innerHTML = '';
		}
	}
};

/**
 * delete
 * @param  Object e
 * @return undefined
 */
Music.delete = function(e) {
	e.preventDefault();

	var itemsSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-music="true"]:checked'));
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

		Animations.loaderMessage.innerHTML = 'Procesando solicitud...';
		Animations.showHideLoader();

		Ajax.send(location.pathname + "/delete", "POST", "json", Music.responseServerDelete, JSON.stringify(json), "json");
	}
};

/**
 * addEventDelete
 * @return undefined
 */
Music.addEventDelete = function() {
	// delete
	[].slice.call(document.querySelectorAll('input[data-music="true"]')).forEach(function(element, index) {
		element.addEventListener('click', Music.selectItemDelete);
	});

	if (Music.Fields.deleteAll && Music.Fields.delete) {
		// checkbox delete
		Music.Fields.deleteAll.addEventListener('change', Music.checkAll);

		// button delete
		Music.Fields.delete.addEventListener('click', Music.delete);
	}
};
