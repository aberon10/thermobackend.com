/**
 * Search
 * @type Object
 */
var Search = {};

/**
 * Fields
 * @type Object
 */
Search.Fields = {
	form: document.getElementById('form-search') || null,
	input: document.getElementById('filter') || null,
	table: document.querySelector('.table') || null,
	limit: document.getElementById('limit') || null,
	panel_left: document.querySelector('#panel-options > .panel-options__left') || null,
	pagination: document.querySelector('#panel-options > .panel-options__right') || null,
	tbody: document.getElementById('tbody') || null
};

/**
 * addFilter
 * Agrega el filtro de Busqueda a los enlaces de la paginacion
 * @param string|null filter
 * @return undefined
 */
Search.addFilter = function(filter, limit) {
	var a = [].slice.apply(document.querySelectorAll('ul.pagination a'));
	var url = null;
	var index = null;

	if (a.length > 0) {
		a.forEach(function(element, index) {
			var s = element.href.split(window.location.pathname);
			if (s.length === 2) {
				if (s[1].search('&filter') === -1) {
					element.href += "&filter=" + filter;
				}
				if (s[1].search('&limit') === -1) {
					element.href += "&limit=" + limit;
				}
			}
		});
	}
};

/**
 * responseServer
 * @param  Object response
 * @return undefined
 */
Search.responseServer = function(response) {
	if (response.hasOwnProperty('data')) {
		var tbody = Search.Fields.tbody;
		tbody.innerHTML = "";

		if (response.hasOwnProperty('entitie')) {
			if (response.data.data.length === 0) {
				Search.Fields.table.style.display = 'none';
				Search.Fields.panel_left.innerHTML = "<h3>No hay resultados disponibles</h3>";
				Search.Fields.pagination.innerHTML = "";
			} else {
				Search.Fields.table.style.display = 'table';
				Search.Fields.panel_left.innerHTML = response.message_panel;
				Search.Fields.pagination.innerHTML = response.pagination;

				// agrego el filtro a la paginacion
				Search.addFilter(response.filter, response.limit);

				// pagination replace
				var pagination = [].slice.call(document.querySelectorAll('ul.pagination a'));

				pagination.forEach(function(element, index) {
					element.href = element.href.replace('search', '');
				});

				if (response.entitie !== 'user') {
					var entitie = response.entitie;

					// values
					var idEntitie = null;
					var nameEntitie = null;
					var urlEdit = null;

					// nameEntitie and idEntitie
					switch (entitie) {
						case "genre":
							nameEntitie = "nombre_genero";
							idEntitie = "id_genero";
							urlEdit = '/genres/edit/';
							break;
						case "artist":
							nameEntitie = "nombre_artista";
							idEntitie = "id_artista";
							urlEdit = '/albums/list/';
							break;
						case "album":
							nameEntitie = "nombre";
							idEntitie = "id_album";
							urlEdit = '/tracks/';
							break;
						default:
							idEntitie = null;
							nameEntitie = null;
							urlEdit = null;
					}

					response.data.data.forEach(function(element, i) {
						var row = null;
						var href = null;
						var aName = urlEdit + element[idEntitie];

						var createdAt = Utilities.DateFormat(element.created_at); // create_at
						var updatedAt = Utilities.DateFormat(element.updated_at); // updated_at

						// agrego las columnas index y nombre
						row = "<td>" + (i + 1) + "</td>" + "<td><a href='" + aName + "'>" + element[nameEntitie] + "</a></td>";

						// columna genero|artista
						if (entitie === 'artist' || entitie === 'album') {
							if (entitie === 'artist') {
								// artist
								href = '/genres/edit/' + element.id_genero;
								row += "<td><a href='" + href + "'>" + element.nombre_genero + "</a></td>";
							} else if (entitie === 'album') {
								// album
								href = '/artists/edit/' + element.id_artista;
								row += "<td><a href='" + href + "'>" + element.nombre_artista + "</a></td>";
							}
						}

						// columnas created_at y updated_at
						row += "<td>" + createdAt + "</td><td>" + updatedAt + "</td>";

						// columna editar artista|album
						if (entitie === 'artist' || entitie === 'album') {
							if (entitie === 'artist') {
								href = '/artist/edit/' + element[idEntitie];
							} else if (entitie === 'album') {
								href = 'albums/edit/' + element[idEntitie];
							}
							row += "<td><a href='" + href + "'><i class='icon-edit'><i/></a></td>";
						}

						// checkbox delete
						row += "<td class='center'><input type='checkbox' name='" + element[nameEntitie] + "' data-music='true' value='" + element[idEntitie] + "'></td>";
						tbody.innerHTML += "<tr>" + row + "</tr>";
					});

					Music.addEventDelete(); // checkbox delete

				} else {
					response.data.data.forEach(function(element, i) {
						var name = (element.nombre) ? element.nombre : '-';
						var lastname = (element.apellido) ? element.apellido : '-';
						var birthdate = (element.fecha_nac) ? element.fecha_nac : '-';
						var createdAt = (element.created_at) ? Utilities.DateFormat(element.created_at) : '-';
						var updatedAt = (element.updated_at) ? Utilities.DateFormat(element.updated_at) : '-';

						tbody.innerHTML += "<tr>" +
							"<td>" + (i + 1) + "</td>" +
							"<td>" + element.usuario + "</td>" +
							"<td>" + element.nombre_tipo + "</td>" +
							"<td>" + name + "</td>" +
							"<td>" + lastname + "</td>" +
							"<td>" + element.correo + "</td>" +
							"<td>" + birthdate + "</td>" +
							"<td>" + element.sexo + "</td>" +
							"<td>" + createdAt + "</td>" +
							"<td>" + updatedAt + "</td>" +
							"<td class='center'><input type='checkbox' name='" + element.usuario + "' data-user='true' value='" + element.id_usuario + "'></td>" +
							"</tr>";
					});

					User.addEventDelete(); // checkbox delete
				}
			}
		}
	}
};

/**
 * filter
 * @param  Object e
 * @return undefined
 */
Search.filter = function(e) {
	var form = Search.Fields.form;
	var input = Search.Fields.input.value.trim();
	var filter = null;
	var limit = (Search.Fields.limit.value) ? Search.Fields.limit.value : 10;
	var code = e.keyCode || e.which;

	if (code !== 16 && code !== 17 && code !== 18 && code !== 225 && code !== 13) { // Shift, Ctrl, Alt, AltGr, Enter
		if (code == 8) { // backspace
			filter = input;
		} else if (input.length > 0) {
			filter = input + String.fromCharCode(code);
		} else {
			filter = String.fromCharCode(code);
		}

		Search.sendForm(filter.trim(), limit);

	}
};

/**
 * sendForm
 * @param  string filter
 * @param  string limit
 * @return undefined
 */
Search.sendForm = function(filter, limit) {
	var formData = new FormData();
	formData.append('filter', filter);
	formData.append('limit', limit);
	Ajax.send(location.pathname + '/search', "POST", "json", Search.responseServer, formData, "FormData");
};

(function(d) {
	if (Search.Fields.input) {
		// agrego el filtro a los enlaces de la paginacion
		Search.addFilter((Search.Fields.input.value) ? Search.Fields.input.value : ' ', Search.Fields.limit.value);
	}

	if (Search.Fields.input) {
		Search.Fields.input.addEventListener('keydown', Search.filter, false);
		Search.Fields.form.addEventListener('submit', function(e) {
			e.preventDefault();
		}, false);
	}

	// limite de registros
	if (Search.Fields.limit) {
		Search.Fields.limit.addEventListener('change', function() {
			Search.sendForm(
				Search.Fields.input.value ? Search.Fields.input.value : "",
				this.value
			);
		});
	}
}(document));
