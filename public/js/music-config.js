/**
 * Music
 * Namspace for music entities.
 * @type {Object}
 */
var Music = {};

/**
 * PATHNAME
 * Current route.
 * @type {String}
 */
Music.PATHNAME = window.location.pathname;

/**
 * paths - Routes
 * @type {Object}
 */
Music.paths = {
	add: /^(\/(genres|artists|albums|tracks)\/add)$/,
	edit: /^(\/(genres|artists|albums|tracks)\/edit\/)+[0-9]{1,}$/,
	add_genre: /^(\/genres\/add)$/,
	add_artist: /^(\/artists\/add)$/,
	add_album: /^(\/albums\/add)$/,
	add_track: /^(\/tracks\/add)$/,
	edit_genre: /^(\/genres\/edit\/)+[0-9]{1,}$/,
	edit_artist: /^(\/artists\/edit\/)+[0-9]{1,}$/,
	edit_album: /^(\/albums\/edit\/)+[0-9]{1,}$/,
	edit_track: /^(\/tracks\/edit\/)+[0-9]{1,}$/
};

/**
 * Fields
 * @type {Object}
 */
Music.Fields = {
	form: document.getElementById('form-add') || null,
	delete: document.getElementById('delete') || null,
	deleteAll: document.getElementById('delete-all') || null,
	name: document.getElementById('nombre') || null,
	description: document.getElementById('descripcion') || null,
	select: document.getElementById('select-item') || null,
	quantity_tracks: document.getElementById('cantidad_pistas') || null,
	year: document.getElementById('anio') || null,
	file: document.getElementById('file') || null,
	btn_add: document.getElementById('add') || null,
	btn_frm: document.getElementById('button-form') || null,
	drop_zone: document.getElementById('drop-zone') || null,
	file_error: document.querySelector('p.error-uploaded') || null,
};

/**
 * HelpBlocks
 * @type {Object}
 */
Music.HelpBlocks = {
	name: "Utiliza sólo caracteres alfanumericos, guiones, puntos, espacios, comillas y el signo &."
};
