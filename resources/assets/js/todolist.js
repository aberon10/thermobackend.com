/**
 * Task
 * @type Object
 */
let Task = {};

/**
 * Fields
 * @type Object
 */
Task.Fields = {
	form: document.getElementById('form-task') || null,
	title: document.getElementById('titlek') || null,
	task: document.getElementById('task') || null,
	todo_list: document.getElementById('todo-list') || null,
	delete: document.getElementById('delete-task') || null,
	error_message: document.getElementById('error-message-task') || null
};

/**
 * responseServerCreate
 * @param  Object response
 * @return undefined
 */
Task.responseServerCreate = function(response) {
	if (response.hasOwnProperty('success')) {
		if (!response.success) {
			if (response.hasOwnProperty('messages')) {
				for (var msg in response.messages) {
					Task.Fields[msg].classList.add('error');
					Task.Fields[msg].parentNode.nextElementSibling.innerHTML = response.messages[msg][0];
				}
			}
		} else {
			// agrego la tarea a la lista
			let li = document.createElement('li');
			let a = document.createElement('a');
			let aText = document.createTextNode((response.task.title.length > 20) ? response.task.title.substring(0, 18) + '...' : response.task.title);
			let span = document.createElement('span');

			span.classList.add('icon-check');
			a.setAttribute('href', '#');
			a.setAttribute('data-task', response.task.id);
			a.appendChild(span);
			a.appendChild(aText);

			li.classList.add('todo-list__item');
			li.appendChild(a);

			if (Task.Fields.todo_list.children.length === 0) {
				Task.Fields.todo_list.appendChild(li);
			} else {
				Task.Fields.todo_list.insertBefore(li, Task.Fields.todo_list.firstElementChild);
			}

			Task.AddEventOK();

			document.getElementById('todo-list-container').parentNode.classList.remove('hide');

			Task.Fields.form.reset();
		}
	}
};

/**
 * create
 * @param  Object e
 * @return undefined
 */
Task.create = function(e) {
	e.preventDefault();
	let isValid = true;
	let title = document.getElementById('title');
	let task = document.getElementById('task');

	title.classList.remove('error');
	title.parentNode.nextElementSibling.innerHTML = '';

	Task.Fields.error_message.innerHTML = '';

	if (title.value === '') {
		title.classList.add('error');
		title.parentNode.nextElementSibling.innerHTML = Validations.messageForm.required;
		isValid = false;
	}

	if (isValid) {
		let formData = new FormData(Task.Fields.form);
		Ajax.send('/task/create', "POST", "json", Task.responseServerCreate, formData, "FormData");
	}
};

/**
 * responseServerDelete
 * @param  Object response
 * @return undefined
 */
Task.responseServerDelete = function(response) {
	if (response.hasOwnProperty('success')) {
		let tasks = [].slice.call(document.querySelectorAll('.todo-list__item.active'));

		if (!response.success) {
			Task.Fields.error_message.innerHTML = response.message;
			// Elimino los elementos de la lista
			tasks.forEach(function(element, index) {
				element.classList.remove('active');
			});
		} else {
			// Elimino los elementos de la lista
			tasks.forEach(function(element, index) {
				Task.Fields.todo_list.removeChild(element);
			});
		}
	}
};


/**
 * delete
 * @param  Object e
 * @return undefined
 */
Task.delete = function(e) {
	e.preventDefault();
	let tasksActives = [].slice.call(document.querySelectorAll('.todo-list__item.active a'));

	Task.Fields.error_message.innerHTML = '';

	if (tasksActives.length > 0) {
		let formData = new FormData();
		let json = {};
		json.tasks = [];

		tasksActives.forEach(function(element, index) {
			json.tasks.push(element.getAttribute('data-task'));
		});

		this.classList.add('hide');
		Ajax.send('/task/delete', "POST", "json", Task.responseServerDelete, JSON.stringify(json), "json");
	}
};

/**
 * taskOk
 * @param  Object e
 * @return undefined
 */
Task.taskOk = function(e) {
	e.preventDefault();
	this.parentNode.classList.toggle('active');
	Task.Fields.error_message.innerHTML = '';

	let countTaskActive = document.querySelectorAll('.todo-list__item.active').length;

	if (countTaskActive > 0) {
		if (Task.Fields.delete.classList.contains('hide')) {
			Task.Fields.delete.classList.remove('hide');
		}
	} else {
		if (!Task.Fields.delete.classList.contains('hide')) {
			Task.Fields.delete.classList.add('hide');
		}
	}
};

/**
 * AddEventOK
 * @return undefined
 */
Task.AddEventOK = function() {
	let tasks = [].slice.call(document.querySelectorAll('.todo-list__item a'));

	if (tasks.length > 0) {
		tasks.forEach(function(element, index) {
			element.removeEventListener('click', Task.taskOk, false);
			element.addEventListener('click', Task.taskOk, false);
		});
	}
};

(function(d) {
	let form = document.getElementById('form-task');
	if (form) {
		form.addEventListener('submit', Task.create);
	}

	if (Task.Fields.delete) {
		Task.Fields.delete.addEventListener('click', Task.delete);
	}

	Task.AddEventOK();
})(document);
