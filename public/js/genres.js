/**
 * Genre
 * Namspace for genres
 * @type {Object}
 */
var Genre = {};

Genre.uploadToServer = function() {
	var form = document.getElementById('form-addgenre');
	var nameGenre = document.getElementById('nombre_genero').value;
	var description = document.getElementById('descripcion').value;

	var formData = new FormData();
    formData.append('nombre_genero', nameGenre);
    formData.append('descripcion', description);
    formData.append('file', Validations.file.FILES);

    console.log(formData);

    return false;
};

Genre.add = function() {
	event.preventDefault();

	var isValid         = true;
	var form            = document.getElementById('form-addgenre');
	var inputFile       = document.getElementById('file-genre');
	var errorUploadFile = document.querySelector('.error-uploaded');
	var dropZone        = document.getElementById('drop-zone');
	var nameGenere      = document.getElementById('nombre_genero');
	var helpBlock       = document.getElementById('help-block');

	// reset form
	nameGenere.value = nameGenere.value.trim();
	nameGenere.parentNode.classList.remove('error');
	nameGenere.nextElementSibling.nextElementSibling.classList.add('show');
	nameGenere.nextElementSibling.innerHTML = "";
	dropZone.classList.remove('error');
	helpBlock.classList.remove('error');

	// check name
	// if (!Utilities.checkNameEntities(nameGenere.value)) {
	// 	nameGenere.parentNode.classList.add('error');
	// 	nameGenere.nextElementSibling.nextElementSibling.classList.add('hide');
	// 	nameGenere.nextElementSibling.innerHTML = messageForm.error_name;
	// 	isValid = false;
	// }

	// check files
	if (Validations.file.FILES === null) {
		dropZone.classList.add('error');
		isValid = false;
	}

	if (isValid) {
		// sent to form
		helpBlock.classList.add('success');
		helpBlock.innerHTML = messageForm.success_form;

		Genre.uploadToServer();
	} else {
		helpBlock.classList.add('error');
		helpBlock.innerHTML = messageForm.error_form;
	}
};

(function(window, document, $) {

	var btnAdd = document.getElementById('add_genere');

	btnAdd.addEventListener('click', Genre.add);

	Validations.file.BORDER_COLOR = "#00f0ff";

	// validate upload file
	Validations.file.upload("drop-zone", "image");

}(window, document, jQuery));
