var layoutMenuVisible = true;
var layoutCurrent = null;

function layoutToggleMenu(obj) {
	if (layoutMenuVisible) {
		document.getElementById('menuContainer').style.display = 'none';
		obj.className = 'toggleShow';
	} else {
		document.getElementById('menuContainer').style.display = 'block';
		obj.className = 'toggleHide';
	}
	layoutMenuVisible = !layoutMenuVisible;
}

function layoutSelectMenu(obj) {
	if (layoutCurrent) {
		layoutCurrent.style.display = 'none';
	}
	var id = obj.id + "cont";
	var elem = document.getElementById(id);
	elem.style.display = 'block';
	layoutCurrent = elem;
}

function layoutMenuOver(obj) {
	/* for browsers that don't support the css ":hover" pseudo class (<= IE 6) */
	obj.className = 'menuhandleHover';
}

function layoutMenuOut(obj) {
	obj.className = 'menuhandle';
}
