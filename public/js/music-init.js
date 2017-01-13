(function(window, document) {
	var create = false;

	if (Music.Fields.form) {
		Music.Fields.form.addEventListener('submit', function(e) {
			e.preventDefault();
			Music.Fields.btn_add.click();
		});
	}

	// add or edit
	if (Music.paths.add.test(Music.PATHNAME) || Music.paths.edit.test(Music.PATHNAME)) {
		// mimetype
		var mime = (Music.paths.add_track.test(Music.PATHNAME) || Music.paths.edit_track.test(Music.PATHNAME)) ? "audio" : "image";

		if (Music.paths.add.test(Music.PATHNAME)) {
			create = true;
		}

		// validat upload file
		Validations.file.upload("drop-zone", mime, create);
		Music.Fields.btn_add.addEventListener('click', Music.add);

	} else {
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
	}

}(window, document));
