/**
 * Animations
 * @type Object
 */
var Animations = {};

/**
 * tooglePreferencesMenu
 * @return undefined
 */
Animations.tooglePreferencesMenu = function() {
	var btnToggle = document.getElementById('dropdown-toggle');

	var toggleDocument = function(e) {
		btnToggle.click();
	};

	if (btnToggle) {
		btnToggle.addEventListener('click', function(e) {
			e.preventDefault();
			if (this.lastElementChild.classList.contains('hide')) {
				this.lastElementChild.classList.remove('hide');
				this.classList.add('dropdown-toggle');
			} else {
				this.lastElementChild.classList.add('hide');
				this.classList.remove('dropdown-toggle');
			}
		}, false);

		// document.addEventListener('click', toggleDocument, false);
	}

};

/**
 * toggleSubmenu
 * @param  Object e
 * @return undefined
 */
Animations.toggleSubmenu = function(e) {
	var btnsToggle = Array.prototype.slice.call(document.querySelectorAll('li.item-submenu > a'));

	if (btnsToggle) {

		btnsToggle.forEach(function(element, index) {
			element.addEventListener('click', function(e) {
				e.preventDefault();
				this.parentNode.classList.toggle('open');
			}, true);
		});
	}
};

/**
 * toggleMenuSecondary
 * @param  Object e
 * @return undefined
 */
Animations.toggleMenuSecondary = function(e) {
	var btnToggle = document.getElementById('toggle-secondary-menu');

	if (btnToggle) {

		var iconArrow = btnToggle.firstElementChild.lastElementChild;
		var menuSecondary = document.querySelector('.menu-secondary');
		var infoUser = document.querySelector('.info-user-container');
		var mainMenu = document.querySelector('.menu-vertical__nav');

		btnToggle.addEventListener('click', function(e) {
			e.preventDefault();
			menuSecondary.classList.toggle('hide');
			infoUser.classList.toggle('hide');
			mainMenu.classList.toggle('hide');

			if (iconArrow.classList.contains('icon-chevron-down')) {
				iconArrow.classList.remove('icon-chevron-down');
				iconArrow.classList.add('icon-chevron-up');
			} else {
				iconArrow.classList.remove('icon-chevron-up');
				iconArrow.classList.add('icon-chevron-down');
			}
		}, false);
	}
};

/**
 * togglePanel
 * @param  Object e
 * @return undefined
 */
Animations.togglePanel = function(e) {
	var btnsToggle = document.querySelectorAll('span[data-toggle="panel"]');

	if (btnsToggle) {

		btnsToggle.forEach(function(element, index) {
			element.addEventListener('click', function(e) {
				e.preventDefault();
				if (this.classList.contains('icon-chevron-down')) {
					this.classList.remove('icon-chevron-down');
					this.classList.add('icon-chevron-up');
				} else {
					this.classList.remove('icon-chevron-up');
					this.classList.add('icon-chevron-down');
				}
				this.parentNode.parentNode.nextElementSibling.classList.toggle('hide');
			}, false);
		});
	}
};

/**
 * toggleMainMenu
 * @param  Object e
 * @return undefined
 */
Animations.toggleMainMenu = function(e) {
	var btnsToggle = Array.prototype.slice.call(document.querySelectorAll('a[data-toggle="main-menu"]'));
	var sidebar = document.querySelector('.sidebar');

	if (btnsToggle.length > 0) {
		btnsToggle.forEach(function(element, index) {
			element.addEventListener('click', function(e) {
				e.preventDefault();
				sidebar.classList.toggle('open');

				if (document.body.style.overflow === "hidden") {
					document.body.style.overflow = "";
				} else {
					document.body.style.overflow = "hidden";
				}

			});
		});
	}

	window.addEventListener('resize', function() {
		if (this.innerWidth >= 768) {
			document.body.style.overflow = "auto";
		}
	});
};

Animations.loader = document.querySelector('.loader');
Animations.loaderMessage = document.querySelector('.loader-message');

/**
 * showHideLoader
 * @return undefined
 */
Animations.showHideLoader = function() {
	if (Animations.loader.classList.contains('show')) {
		Animations.loader.classList.remove('show');
	} else {
		Animations.loader.classList.add('show');
	}
};

Animations.toggleMenuSecondary();
Animations.toggleMainMenu();
Animations.toggleSubmenu();
Animations.togglePanel();
Animations.tooglePreferencesMenu();
