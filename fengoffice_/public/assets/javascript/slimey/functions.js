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
 *  returns the client area as size.w and size.h
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
	if (ref) {
		/* we subtract the element's position on the screen to get the mouse position relative to the element */
		var offset = getOffsetPosition(ref);
		pos.x -= offset.x;
		pos.y -= offset.y;
	}
	return pos;
}

/**
 *  gets the objects actual position relative to the window.
 *  	elem: element for which to calculate its offset position
 */
function getOffsetPosition(elem) {
	var pos = { x:0, y:0 };
	while (elem.offsetParent) {
		pos.x += elem.offsetLeft;
		pos.y += elem.offsetTop;
		elem = elem.offsetParent;
	}
	return pos;
}

/**
 *  sets an event handler to an element, removing any previous handlers for the event
 *  	elem: element to which to set the event handler (e.g. document)
 *  	ev: event to handle (e.g. mousedown)
 *  	func: function that will handle the event
 */
function setEventHandler(elem, ev, func) {
	elem[ev + "Count"] = 0;
	elem["on" + ev] = func;
}

/**
 *  adds an event handler to an element, keeping the current event handlers.
 *  	elem: element to which to add the event handler (e.g. document)
 *  	ev: event to handle (e.g. mousedown)
 *  	fun: function that will handle the event
 *  	scope: (optional) on which object to run the function
 */
function addEventHandler(elem, ev, fun, scope) {
	if (scope) {
		var func = function(e) {
			fun.call(scope, e);
		};
	} else {
		var func = fun;
	}
	if (elem[ev + "Count"]) {
		elem[ev + elem[ev + "Count"]++] = func;
	} else {
		elem[ev + "Count"] = 0;
		if (typeof elem["on" + ev] == 'function') {
			elem[ev + elem[ev + "Count"]++] = elem["on" + ev];
		}
		elem[ev + elem[ev + "Count"]++] = func;
		elem["on" + ev] = function(event) {
			for (var i=0; i < elem[ev + "Count"]; i++) {
				elem[ev + i](event);
			}
		};
	}
}

/**
 *  returns document.getElementById(id);
 *  	id: id of the element
 *		container: (optional) where to search (default: document.body)
 *  	frame: (optional) frame where the element is (default: window)
 */
function $(id, container, frame) {
	if (!frame) frame = window;
	if (!container) container = document.body;
	
	return frame.document.getElementById(id);
}

/**
 *  escapes the &, <, >, " and ' characters from a SLIM string
 */
function escapeSLIM(rawSLIM) {
	return encodeURIComponent(rawSLIM);
}

/**
 *  unescapes the &, <, >, " and ' characters from an escaped SLIM string
 */
function unescapeSLIM(encodedSLIM) {
	return decodeURIComponent(encodedSLIM);
}

/**
 *  lets the user pick an image and then calls a function passing it the chosen image's URL
 *  	func: function to call when the image is selected (func is passed the image's URL as the first argument)
 */
function chooseImage(func, scope, button) {
	og.ImageChooser.show(imagesUrl, func, scope, button);
}

/**
 *  lets the user pick a color and then calls a function passing it the chosen color's CSS code
 *  	func: function to call when the color is selected (func is passed the color's code as the first argument)
 */
function chooseColor(func, scope, button) {
	var menu = new Ext.menu.ColorMenu({
        handler : function(palette, code) {
			if (typeof(code) == "string") {
				func.call(scope, "#" + code);
			}
		}
	});
	menu.show(button);
}

/**
 *  gets a string input.
 */
function getInput(func, scope, button, defVal) {
	Ext.Msg.prompt('Save', 'Choose a filename:',
		function(btn, text) {
			if (btn == 'ok') {
				func.call(this, text);
			}
		}, scope, false, defVal
	);
}
