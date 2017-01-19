/**
 * file
 * Namespace utilizado para manejo de archivos.
 *
 * @type {Object}
 */
Validations.file = {};

/**
 * BYTE
 * @type {Number}
 */
Validations.file.BYTE = 1048576;

/**
 * MAX_FILE_SIZE
 * Tamaño máximo del archivo, en MegaBytes.
 * Default 2MB.
 *
 * @type {Number}
 */
Validations.file.MAX_FILE_SIZE = 2;

/**
 * BORDER_COLOR
 * Color del borde de la zona donde se sueltan los archivos
 * en caso de usar la API Drag & Drop.
 *
 * @type {String}
 */
Validations.file.BORDER_COLOR = '#00f0ff';

/**
 * mimeType
 * Objetos con los mimetypes soportados por la app.
 *
 * @type {Object}
 */
Validations.file.mimeType = {
	"text": "text/plain",
	"image": {
		"jpg": "image/jpg",
		"jpeg": "image/jpeg",
		"png": "image/png",
		"gif": "image/gif"
	},
	"audio": {
		"mp3": "audio/mp3",
		"audio_ogg": "audio/ogg",
		"wav": "audio/wav"
	},
	"video": {
		"mp4": "video/mp4",
		"video_ogg": "video/ogg"
	}
};

/**
 * message
 * Objeto con los mensajes de error utilizados durante la validacion.
 *
 * @type {Object}
 */
Validations.file.message = {
	"require": "El campo es requerido.",
	"max_size": "El archivo no debe superara los " + Validations.file.MAX_FILE_SIZE + " MB.",
	"invalid_type_file": "Tipo de archivo no permitido.",
	"API_nosupport": "No se pudo generar la vista previa. La API  no esta soportada por tu navegador."
};

/**
 * elements
 * Elementos por defecto utilizados en el upload.
 *
 * @type {Object}
 */
Validations.file.drop_zone = "drop-zone";

Validations.file.FILES = null;

Validations.file.createElements = function(dropZone) {
	// TITLE
	var title = document.createElement('H2');
	title.innerHTML = "Arrastra tu archivo aquí";
	title.classList.add('preview__title');

	// BUTTON
	var buttonFile = document.createElement('A');
	buttonFile.setAttribute('href', '#');
	buttonFile.setAttribute('id', "button-file");
	buttonFile.classList.add('button');
	buttonFile.classList.add('button-alice');
	buttonFile.classList.add('preview__button');
	buttonFile.innerHTML = "Seleccionar archivo";

	// INPUT FILE
	var inputFile = document.createElement('input');
	inputFile.setAttribute('type', 'file');
	inputFile.setAttribute('name', 'file');
	inputFile.setAttribute('multiple', false);
	inputFile.setAttribute('id', "file");
	inputFile.classList.add('hide');

	// ERROR
	var errorUploadFile = document.createElement('P');
	errorUploadFile.classList.add('error-uploaded');

	// NAME FILE
	var nameFile = document.createElement('H4');
	nameFile.classList.add('name_file');
	nameFile.classList.add('hide');

	// LOADING
	var loadingBar = document.createElement('DIV');
	loadingBar.classList.add('loading');

	// Append elements
	dropZone.appendChild(buttonFile);
	dropZone.appendChild(inputFile);
	dropZone.appendChild(errorUploadFile);
	dropZone.appendChild(title);
	dropZone.appendChild(nameFile);
	dropZone.parentNode.appendChild(loadingBar);
};

/**
 * upload
 *
 * uploadFile, se encarga de validar el upload de archivos.
 * Comprobando tamaño, tipo de archivo, entre otros.
 * Por ultimo ejecuta una vista previa del archivo.
 *
 * @param {Object} element Lugar donde se soltaran los archivos. Si se indica null Default es "drop-zone".
 * @param {String} mime    Tipo de archivo. Ej image, audio, video. Si se indica null por Default es "image".
 * @param {Boolean} create Indica si se deben crear los elementos de la drop zone.
 * @return {Boolean || undefined}
 */
Validations.file.upload = function(element, mime, create) {

	element = element || Validations.file.drop_zone;
	var dropZone = document.getElementById(element);

	/********************************************************
	 * 				CREO LOS ELEMENTOS                      *
	 *********************************************************/
	if (create) {
		Validations.file.createElements(dropZone);
	}

	var buttonFile = document.getElementById('button-file');
	var inputFile = document.getElementById('file');
	var loadingBar = document.querySelector('.loading');
	var nameFile = document.querySelector('.name_file');
	var errorUploadFile = document.querySelector('.error-uploaded');
	var previewIcon = document.querySelector('.preview__icon');
	var bcolorDropZone = dropZone.style.borderColor;
	var errorInput = true;
	var droppedFiles = false;
	var fileList = null;

	/**
	 * borderColor
	 *
	 * Color del borde cuando el archivo es arrastrado
	 * dentro de la drop zone.
	 *
	 * @type {string}
	 */
	var borderColor = String(Validations.file.BORDER_COLOR).toUpperCase();

	if (!Utilities.checkColorHEX(borderColor)) {
		console.log("El color " + borderColor + " no es un color hexadecimal valido.");
		return false;
	}

	// Por defecto el mimetype es image
	if (mime === null) {
		mime = "image";
	} else if (!Validations.file.mimeType.hasOwnProperty(mime) &&
		!Validations.file.mimeType.audio.hasOwnProperty(mime) &&
		!Validations.file.mimeType.video.hasOwnProperty(mime) &&
		!Validations.file.mimeType.image.hasOwnProperty(mime)) {
		console.log("El tipo de mime indicado no es valido");
		return false;
	}

	/**
	 * maxFileSize
	 * Tamaño maximo del archivo (Bytes).
	 *
	 * @type {Number}
	 */
	var maxFileSize = Validations.file.MAX_FILE_SIZE * Validations.file.BYTE;

	/**
	 * reset
	 * Reseteo la zona donde se sueltan los archivos y los mensajes.
	 *
	 * @return {undefined}
	 */
	var reset = function() {
		dropZone.classList.remove('error');
		errorUploadFile.innerHTML = "";
		nameFile.innerHTML = "";
		loadingBar.style.display = 'block';
		loadingBar.style.width = 0;
	};

	/**
	 * animateLoadingFile
	 *
	 * @param  {Object}  event
	 * @param  {Object}  fileList archivos
	 * @return {undefined}
	 */
	var animateLoadingFile = function(event, fileList) {
		// reset drop zone and messages
		reset();

		var width = 0; // ancho de la barra
		var preview = document.getElementById('preview-element') || null;

		if (preview) {
			preview.remove();
		}

		// icon cloud
		if (!previewIcon.classList.contains('zoom', 'alice')) {
			previewIcon.classList.add('alice', 'zoom');
		}

		function loading() {
			width += 10;
			loadingBar.style.width = width + "%";
			if (width >= 100) {
				// icon cloud
				previewIcon.classList.remove('alice', 'zoom');
				// llamo a la funcion encargada de validar el archivo
				upload(event, fileList);
				clearInterval(setInt);
			}
		}

		var setInt = setInterval(loading, 180);
	};

	/**
	 * checkFile
	 * Realiza las validaciones correspondientes al archivo.
	 *
	 * @param  {Object} file
	 * @return {Boolean}
	 */
	var checkFile = function(file) {
		var isValid = true;
		var validType = false; // utilizada salir del bucle
		var i = 0;
		var type = file[0].type; // tipo del archivo a subir
		var countMime = Object.keys(Validations.file.mimeType).length; // cantidad de mimes

		// comprueba que el tipo mime sea valido
		while (validType === false && i < countMime) {
			if (mime === "audio" || mime === "video" || mime === "image") {
				for (var item in Validations.file.mimeType[mime]) {
					if (Validations.file.mimeType[mime][item] === type) {
						validType = true;
					}
				}
			} else if (Validations.file.mimeType.audio[mime] === type) {
				validType = true;
			} else if (Validations.file.mimeType.video[mime] === type) {
				validType = true;
			} else if (Validations.file.mimeType.image[mime] === type) {
				validType = true;
			} else if (Validations.file.mimeType[mime] === type) {
				validType = true;
			}

			i++;
		}

		if (validType) {
			// tamaño del archivo
			if (file[0].size > maxFileSize) {
				errorUploadFile.innerHTML = Validations.file.message.max_size;
				isValid = false;
			} else {
				errorUploadFile.innerHTML = '';
				isValid = true;
			}
			// tipo de archivo
		} else {
			errorUploadFile.innerHTML = Validations.file.message.invalid_type_file;
			isValid = false;
		}

		// API Drag & Drop
		if (!isValid) {
			dropZone.classList.add('error');
		}

		return isValid;
	};

	/**
	 * upload
	 * Inicia la validacion del archivo utilizando
	 * el metodo checkFile y por ultimo si el archivo es
	 * valido realiza una vista previa utilizando la API FileReader.
	 *
	 * @param  {Object} event
	 * @param  {Object} files archivos subidos via Drag & Drop
	 * @return {undefined}
	 */
	var upload = function(event, files) {
		loadingBar.style.display = "none";
		dropZone.style.borderColor = bcolorDropZone;

		// comprueba si el archivo fue subido via Drag & Drop o el boton file
		if (!droppedFiles) {
			fileList = event.target.files;
		} else {
			fileList = files;
		}

		if (fileList.length === 0 || fileList.length > 1) {
			errorUploadFile.innerHTML = Validations.file.message.require;
		} else if (checkFile(fileList)) {

			// Guardo los archivos a subir
			Validations.file.FILES = fileList[0];

			// Compruebo si la API esta soportada por el navegador
			if (window.File && window.FileReader && window.FileList && window.Blob) {
				// creo un objeto lector
				var objectReader = new FileReader();
				var preview = null;

				// elimino la vista previa anterior
				if (document.getElementById('preview-element')) {
					dropZone.removeChild(document.getElementById('preview-element'));
				}

				// dependiendo del tipo de archivo creo el elemento para la vista previa
				if (mime === "audio" || Validations.file.mimeType.audio.hasOwnProperty(mime)) {
					preview = document.createElement('AUDIO');
					preview.setAttribute('controls', true);
				} else if (mime === "video" || Validations.file.mimeType.video.hasOwnProperty(mime)) {
					preview = document.createElement('VIDEO');
					preview.setAttribute('controls', true);
					preview.style.width = 560 + "px";
					preview.style.height = "auto";
				} else if (mime === "image" || Validations.file.mimeType.image.hasOwnProperty(mime)) {
					preview = document.createElement('IMG');
				} else if (mime === "text") {
					preview = document.createElement('DIV');
				}

				// una vez que el FileReader esta listo muestro la vista previa
				objectReader.addEventListener('load', function() {
					preview.id = "preview-element";
					nameFile.innerHTML = fileList[0].name;
					nameFile.classList.remove('hide');

					if (mime === "text") {
						preview.innerHTML = this.result;
					} else {
						preview.src = this.result;
					}

					dropZone.appendChild(preview);
					window.document.body.scrollTop = window.document.body.scrollHeight;
				});

				// El metodo readAsDataURL, comienza la lectura del contenido del objeto Blob,
				// una vez terminada, el atributo result contiene un dataURL que representa los datos del archivo.

				if (mime === "text") {
					objectReader.readAsText(fileList[0]);
				} else {
					objectReader.readAsDataURL(fileList[0]);
				}

			} else {
				// Si la API no es soportada por el navegador muestro el nombre del archivo
				nameFile.innerHTML = fileList[0].name;
			}
		}
	};

	/********************************************************************
	 * 							DRAG & DROP                             *
	 ********************************************************************/

	/**
	 * handleFileSelect
	 * Se ejecuta cuando el elemento es soltado dentro del area especificada.
	 *
	 * @param  {Object} event
	 * @return {undefined}
	 */
	var handleFileSelect = function(event) {
		event.stopPropagation();
		event.preventDefault();

		// Accedo a la propiedad dataTransfer del evento drop
		var filesList = event.dataTransfer.files; // FileList object.

		if (filesList.length > 0) {
			errorUploadFile.innerHTML = "";
			droppedFiles = true;
			animateLoadingFile(event, filesList);
		}
	};

	/**
	 * handleDragOver
	 * Se ejecuta cuando el elemento entra en el area determinada para soltar
	 * dicho elemento.
	 *
	 * @param  {Object} event
	 * @return {undefined}
	 */
	var handleDragOver = function(event) {
		event.stopPropagation();
		event.preventDefault();

		// Explicitly show this is a copy.
		event.dataTransfer.dropEffect = 'copy';

		this.style.borderColor = borderColor;
		previewIcon.classList.add('alice', 'zoom');
	};

	var handleDragLeave = function(event) {
		event.stopPropagation();
		event.preventDefault();

		this.style.borderColor = bcolorDropZone;
		previewIcon.classList.remove('alice', 'zoom');
	};

	// Listeners para el dragover & drop de imágenes
	dropZone.addEventListener('dragover', handleDragOver, false);
	dropZone.addEventListener('drop', handleFileSelect, false);
	dropZone.addEventListener('dragleave', handleDragLeave, false);

	/********************************************************************
	 * 						 EVENT LISTENERS                            *
	 ********************************************************************/

	// Trigger
	// Al hacer click en el enlace ejecuto el evento click del input file
	// que se encuentra oculto.
	buttonFile.addEventListener('click', function(event) {
		event.preventDefault();
		inputFile.click();
	});

	// Observa los cambios del campo file y obtiene información
	inputFile.addEventListener('change', function(event) {
		droppedFiles = false;
		animateLoadingFile(event);
	});
};
