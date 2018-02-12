(function(window, document) {
	if (Music.Fields.form) {
		Music.Fields.form.addEventListener('submit', function(e) {
			e.preventDefault();
			Music.Fields.btn_add.click();
		});
	}

	// add or edit
	if (Music.paths.add.test(Music.PATHNAME) || Music.paths.edit.test(Music.PATHNAME)) {
		Music.addEvent();
	} else {
		Music.addEventDelete();
	}
}(window, document));
