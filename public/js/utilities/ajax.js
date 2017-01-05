/**
 * Ajax
 * @type {Object}
 */
var Ajax = {};

/**
 * headers
 * @type {Object}
 */
Ajax.headers = {
	form     : "application/x-www-form-urlencoded",
	form_data: "multipart/form-data"
};

/**
 * State
 * States of an ajax request.
 * @type {Object}
 */
Ajax.State = {
	UNSET           : 0, //	The object has been constructed.
	OPENED          : 1, // The open() method has been successfully invoked.
	HEADERS_RECEIVED: 2, // All redirects (if any) have been followed and all HTTP headers of the response have been received.
	LOADING         : 3, // The response's body is being received.
	DONE            : 4 // The data transfer has been completed or something went wrong during the transfer (e.g. infinite redirects).
};

/**
 * init
 * Create new object XMLHttpRequest.
 *
 * @return {object}
 */
Ajax.init = function() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        return new ActiveXObject('Microsoft.XMLHTTP');
    }
};

/**
 * send
 * Send request AJAX
 *
 * @param  {String}   			url
 * @param  {String}   			method
 * @param  {String}   			responseType
 * @param  {Function} 			callback
 * @param  {String || Object}   data
 * @param  {Boolean}   		    file
 * @return {undefined}
 */
Ajax.send = function(url, method, responseType, callback, data, file) {

	// create new object XMLHttpRequest
	var http = Ajax.init();

	console.log("UNSET: " + http.readyState);

	try {
		// check url
		if (!url) {
			throw "La url indicada no es valida.";
		}

		// check method
		if (!method || method === null || (method.toString() !== 'POST' && method.toString() !== 'GET')) {
			method = 'GET';
		} else if ((typeof data === 'object' && data.constructor === 'FormData') || (typeof data !== 'string')) {
           	method = 'POST';

           	// send file
           	if (file) {
           		http.setRequestHeader('Content-Type', Ajax.FormData);
			} else if (typeof data !== 'string') {
				http.setRequestHeader('Content-Type', Ajax.form);
			}
        }

		// check callback
		if (!callback || callback.constructor !== Function) {
            throw 'La función no es valida';
		}

		// check data
		if (!data || (typeof data !== 'string' && data.constructor !== FormData)) {
			data = null;
		}

		// create request
		http.open(method, url, true);
		http.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        console.log("OPENED: " + this.readyState);


		if (!responseType) {
			responseType = "text";
		} else if (responseType !== "arraybuffer" && responseType !== "blob" && responseType !== "document" && responseType !== "json") {
			throw "El tipo de respuesta indicado no es valido.";
		}

		http.responseType = "text"; // set a responseType

        // An EventHandler that is called whenever the readyState attribute changes
        http.onreadystatechange = function() {
        	if (this.readyState === this.HEADERS_RECEIVED) {
        		console.log("HEADERS: " + this.getAllResponseHeaders());
        	} else if (this.readyState.DONE && this.status === 200) {

        		console.log("DONE: " + this.readyState);
        		console.log("RESPONSE: " + this.response);
        		console.log("RESPONSE TEXT: " + this.responseText);


        	} else if (this.readyState.DONE && this.status !== 200) {
        		console.log("RESPONSE: " + this.responseText);
        		console.log("STATUS: " + this.status);
        		console.log("STATUS TEXT: " + this.statusText);
        	}
        };

        //
        http.onprogress = function() {
        	console.log("LOADING: " + this.readyState);
        };

        //
        http.onabort = function() {

        };

        //
        http.onerror = function() {

        };

        http.send(data);

	} catch(error) {
		// statements
		console.log(error);
	}
};
