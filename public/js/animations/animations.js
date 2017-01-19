var Animations = {};

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

Animations.toggleMenuSecondary = function(e) {
	var btnToggle = document.getElementById('toggle-secondary-menu');
	var iconArrow = btnToggle.firstElementChild.lastElementChild;
	var menuSecondary = document.querySelector('.menu-secondary');
	var infoUser = document.querySelector('.info-user-container');
	var mainMenu = document.querySelector('.menu-vertical__nav');

	if (btnToggle) {
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

Animations.toggleMainMenu = function(e) {
	var btnsToggle = Array.prototype.slice.call(document.querySelectorAll('a[data-toggle="main-menu"]'));
	var sidebar = document.querySelector('.sidebar');
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

	window.addEventListener('resize', function() {
		if (this.innerWidth >= 768) {
			document.body.style.overflow = "auto";
		}
	});
};

Animations.toggleMenuSecondary();
Animations.toggleMainMenu();
Animations.toggleSubmenu();
Animations.togglePanel();
Animations.tooglePreferencesMenu();
