/**
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Common utility functions
 */

/**
 *  cancels event propagation
 */
function stopPropagation(e) {
	if (!e) e = window.event;
	e.cancelBubble = true;
	if (e.stopPropagation) {
		e.stopPropagation();
	}
}

/**
 *  convenience function that returns the number on a percental value (removes the '%' sign)
 *  	val: value to be converted (e.g. 57% returns 57)
 */
function getPercentValue(val) {
	return parseInt(val.substring(0, val.length - 1));
}

/**
 *  returns the client area in the variables hSize and vSize
 */
function getClientArea(frame) {
	var size = { w:0, h:0 };

	if (frame.innerHeight) {
		size.w = frame.innerWidth;
		size.h = frame.innerHeight;
	} else if (frame.document.documentElement.clientHeight) {
		size.w = frame.document.documentElement.clientWidth;
		size.h = frame.document.documentElement.clientHeight;
	} else if (frame.document.body.clientHeight) {
		size.w = frame.document.body.clientWidth;
		size.h = frame.document.body.clientHeight;
	}
	
	return size;
}

/**
 *  returns the mouse position from an event as pos.x and pos.y
 *  	e: a javascript mouse event
 *  	ref: (optional) mouse coordinates are given relative to this element (default: window)
 */
function getMousePosition(e, ref) {
	var pos = { x:0, y:0 };
	
	if (e.pageX || e.pageY) {
		pos.x = e.pageX;
		pos.y = e.pageY;
	}
	else if (e.clientX || e.clientY) {
		pos.x = e.clientX + document.body.scrollLeft
			+ document.documentElement.scrollLeft;
		pos.y = e.clientY + document.body.scrollTop
			+ document.documentElement.scrollTop;
	}
	if (ref && ref.offsetParent && ref.offsetLeft && ref.offsetTop) {
		/* we subtract the element's position on the screen to get the mouse position relative to the element */
		var elem = ref;
		while (elem.offsetParent) {
			pos.x -= elem.offsetLeft;
			pos.y -= elem.offsetTop;
			elem = elem.offsetParent;
		}
	}
	return pos;
}

/**
 *  adds an event to an element. Returns wether the event was added successfully.
 *  	elem: element to which to add the event (e.g. document)
 *  	ev: event to add (e.g. mousedown)
 *  	func: function that will handle the event
 */
function addEvent(elem, ev, func) {
	if (elem.addEventListener) {
		elem.addEventListener(ev, func, true);
		return true;
	} else if (elem.attachEvent) {
		return elem.attachEvent("on" + ev, func);
	} else {
		return false;
	}
}

/**
 *  returns document.getElementById(id);
 *  	id: id of the element
 *  	frame: frame where the element is (default: window)
 */
function $(id, frame) {
	if (!frame) {
		frame = window;
	}
	return frame.document.getElementById(id);
}

/**
 *  escapes the &, <, >, " and ' characters from a SLIM string
 */
function escapeSLIM(rawSLIM) {
	var encodedSLIM = rawSLIM
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;');
	return encodedSLIM;
}

/**
 *  unescapes the &, <, >, " and ' characters from an escaped SLIM string
 */
function unescapeSLIM(encodedSLIM) {
	var rawSLIM = encodedSLIM
			.replace(/\&#39;/g, '\'')
			.replace(/\&quot;/g, '"')
			.replace(/\&gt;/g, '>')
			.replace(/\&lt;/g, '<')
			.replace(/\&amp;/g, '&');
	return rawSLIM
}

/**
 *  lets the user pick an image and then calls a function passing it the chosen image's URL
 *  	func: function to call when the image is selected (func is passed the image's URL as the first argument)
 */
function chooseImage(func) {
	// stub implementation
	var url = prompt('What is the URL of the image?', imagesDir + 'sample.png');
	func(url);
}

/**
 *  lets the user pick a color and then calls a function passing it the chosen color's CSS code
 *  	func: function to call when the color is selected (func is passed the color's code as the first argument)
 */
function chooseColor(func) {
	// stub implementation
	var code = prompt('Enter a color:', 'blue');
	func(code);
}