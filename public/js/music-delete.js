/**
 * checkAll
 * Selecciona todos los elementos de la lista.
 *
 * @return {undefined}
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
 * @return {undefined}
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

Music.responseServerDelete = function(response) {
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

Music.delete = function(e) {
	e.preventDefault();

	var itemsSelectes = Array.prototype.slice.call(document.querySelectorAll('input[data-music="true"]:checked'));
	var count = itemsSelectes.length;
	var messageFooter = document.getElementById('help-block');

	if (count === 0) {
		this.classList.add('hide');
		messageFooter.innerHTML = "Por favor, Selecciona un género";
		messageFooter.classList.add('error');
	} else {

		var json = {};
		json.items = [];

		itemsSelectes.forEach(function(e, i) {
			json.items.push(e.value);
		});

		Ajax.send(location.href + "/delete", "POST", "json", Music.responseServerDelete, JSON.stringify(json), "json");
	}
};
