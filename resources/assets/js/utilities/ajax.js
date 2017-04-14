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
    form: "application/x-www-form-urlencoded",
    json: "application/json"
};

/**
 * State
 * States of an ajax request.
 * @type {Object}
 */
Ajax.State = {
    UNSET: 0, //	The object has been constructed.
    OPENED: 1, // The open() method has been successfully invoked.
    HEADERS_RECEIVED: 2, // All redirects (if any) have been followed and all HTTP headers of the response have been received.
    LOADING: 3, // The response's body is being received.
    DONE: 4 // The data transfer has been completed or something went wrong during the transfer (e.g. infinite redirects).
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
 * @param  {String}   			typeData
 * @return {undefined}
 */
Ajax.send = function(url, method, responseType, callback, data, typeData) {

    // create new object XMLHttpRequest
    var http = Ajax.init();

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
        }

        // check callback
        if (!callback || callback.constructor !== Function) {
            throw 'La función no es valida';
        }

        // create request
        http.open(method, url, true);
        http.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        if (typeData) {
            switch (typeData) {
                case "json":
                    http.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                    break;
                default:
            }
        } else {
            throw "No se indico el tipo de dato a enviar";
        }

        if (responseType !== "arraybuffer" &&
            responseType !== "blob" &&
            responseType !== "document" &&
            responseType !== "json" &&
            responseType !== "text") {
            throw "El tipo de respuesta indicado no es valido.";
        }

        http.responseType = responseType; // set a responseType

        // An EventHandler that is called whenever the readyState attribute changes
        http.onreadystatechange = function() {
            if (this.status === 422 || (this.readyState === this.DONE && this.status === 200)) {
                callback(this.response);
            }
        };

        //
        http.onprogress = function() {
            // console.log("LOADING: " + this.readyState);
        };

        //
        http.onabort = function() {};

        //
        http.onerror = function() {};

        http.send(data);

    } catch (error) {
        console.log(error);
    }
};