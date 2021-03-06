/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Editor variables and functions
 */

/**
 *  class SlimeyEditor - implements functionality for the editor
 *  	container: div where the editor will reside
 */
var SlimeyEditor = function(container) {
	/* initialize variables */
	this.current = null;
	this.selected = null;
	this.container = container;
	this.undoStack = new SlimeyStack();
	this.redoStack = new SlimeyStack();
	this.selectionChangeListeners = new Array();
	this.actionPerformedListeners = new Array();

	/* create content editor */
	this.contentEditor = document.createElement('textarea');
	this.contentEditor.id = 'contentEditor';
	this.contentEditor.style.position = 'absolute';
	this.contentEditor.style.zIndex = '20000';
	this.contentEditor.style.overflow = 'visible';
	this.contentEditor.style.visibility = 'hidden';
	this.contentEditor.style.top = -1000;
	this.contentEditor.style.backgroundColor = '#FFFFEE';
	this.contentEditor.onblur = function() {
		var val = this.value;
		if (this.editElement.tagName == 'UL' || this.editElement.tagName == 'OL') {
			val = '<li>' + val + '</li>';
			val = val.replace(/\n/g, '</li><li>');
		} else if (this.editElement.tagName == 'DIV') {
			val = val.replace(/\n/g, '<br>');
		}
		var action = new SlimeyEditContentAction(val);
		SlimeyEditor.getInstance().performAction(action);
		this.style.visibility = 'hidden';
		this.style.top = -1000;
	};
	this.contentEditor.onkeyup = function(e) {
		if (!e) var e = window.event;
		if (e.keyCode == 27) {
			this.onblur();
		}
	};
	this.contentEditor.onclick = function(e) {
		if (!e) e = window.event;
		stopPropagation(e);
		return false;
	}
	this.contentEditor.systemElement = true;
	container.appendChild(this.contentEditor);

	/* create resize handle */
	this.resizeHandle = document.createElement('div');
	this.resizeHandle.id = 'resizeHandle';
	this.resizeHandle.style.zIndex = 100000000;
	this.resizeHandle.style.position = 'absolute';
	this.resizeHandle.style.visibility = 'hidden';
	this.resizeHandle.onmousedown = slimeyDrag;
	this.resizeHandle.systemElement = true;
	container.appendChild(this.resizeHandle);

	/* define container's style */
	container.style.width = '100%';
	container.style.height = '100%';
	container.style.position = 'relative';
	container.style.padding = '0px';
	container.style.border = '1px solid black';
	container.style.overflow = 'hidden';
	container.style.fontSize = '25px';
	container.style.cursor = 'default';

	/* add event handlers */
	addEventHandler(container, "mousemove", slimeyMove);
	addEventHandler(container, "mouseup", slimeyDrop);
	addEventHandler(container, "click", slimeyDeselect);
	addEventHandler(window, "resize", slimeyResize);
	addEventHandler(window, "load", slimeyResize);
}

/** singleton */
SlimeyEditor.instance = null;

/**
 *  initialize the editor's instance
 */
SlimeyEditor.initInstance = function(containerID) {
	SlimeyEditor.instance = new SlimeyEditor($(containerID));
}

/**
 *  returns the single SlimeyEditor instance
 */
SlimeyEditor.getInstance = function() {
	if (SlimeyEditor.instance == null) {
		SlimeyEditor.instance = new SlimeyEditor($('slimeyEditor'), window);
	}
	return SlimeyEditor.instance;
}

/**
 *  returns the editor's container
 */
SlimeyEditor.prototype.getContainer = function() {
	return this.container;
}

/**
 *  returns the generated HTML
 */
SlimeyEditor.prototype.getHTML = function() {
	if (this.selected) {
		this.selected.className = 'slimeyElement';
	}

	var html = '';
	for (var elem=this.container.firstChild; elem; elem = elem.nextSibling) {
		if (elem.nodeType == 1 && !elem.systemElement) {
			/* starting tag */
			html += '<' + elem.tagName.toLowerCase();
			if (elem.src) {
				html += ' src="' + elem.src + '"';
			}
			html += ' style="' + elem.style.cssText + '"';
			html += '>\n';
			
			if (elem.innerHTML) {
				/* inner HTML */
				html += elem.innerHTML + '\n';
			}
			
			/* closing tag */
			html += '</' + elem.tagName.toLowerCase() + '>\n';
		}
	}

	if (this.selected) {
		this.selected.className = 'slimeySelectedElement';
	}

	return html;
}

/**
 *  sets the editor's content as HTML
 */
SlimeyEditor.prototype.setHTML = function(html) {
	this.deselect();
	this.container.innerHTML = html;
	for (var elem=this.container.firstChild; elem; elem = elem.nextSibling) {
		if (elem.nodeType == 1) {
			elem.onmousedown = slimeyDrag;
			elem.onclick = slimeyClick;
			elem.onmouseover = slimeyHighlight;
			elem.onmouseout = slimeyLowshadow;
			elem.ondblclick = slimeyEdit;
			if (elem.tagName == 'IMG') {
				elem.resizable = true;
				elem.title = 'Drag the bottom right corner to resize';
			} else {
				elem.editable = true;
				elem.title = 'Double click to edit content';
			}
			elem.className = 'slimeyElement';
			if (!elem.style.zIndex) {
				elem.style.zIndex = 10000;
			}
			elem.style.cursor = 'move';
		}
	}
	this.container.appendChild(this.resizeHandle);
	this.container.appendChild(this.contentEditor);
}

/**
 *  moves the editor's DOM to another container
 */
SlimeyEditor.prototype.getDOM = function(container) {
	for (var i=0; i < this.container.childNodes.length; i++) {
		var elem = this.container.childNodes.item(i);
		if (!elem.systemElement) {
			this.container.removeChild(elem);
			i--;
			container.appendChild(elem);
		}
	}

	return container;
}

/**
 *  sets the editor's content as DOM
 */
SlimeyEditor.prototype.setDOM = function(container) {
	this.deselect();
	for (var i=0; i < this.container.childNodes.length; i++) {
		var elem = this.container.childNodes.item(i);
		if (!elem.systemElement) {
			this.container.removeChild(elem);
			i--;
		}
	}
	for (var i=0; i < container.childNodes.length; i++) {
		var elem = container.childNodes.item(i);
		container.removeChild(elem);
		i--;
		this.container.appendChild(elem);
	}
}

/**
 *  returns the currently selected element
 */
SlimeyEditor.prototype.getSelected = function() {
	return this.selected;
}

/**
 *  selects an element in the editor
 *  	obj: element to be selected
 */
SlimeyEditor.prototype.select = function(obj) {
	if (this.selected) {
		this.deselect();
	}
	this.selected = obj;
	obj.className = 'slimeySelectedElement';
	this.notifySelectionChange();
	if (obj.resizable) {
		this.resizeHandle.style.visibility = 'visible';
		this.resizeHandle.style.left = (getPercentValue(obj.style.left) + getPercentValue(obj.style.width)) + '%';
		this.resizeHandle.style.top = (getPercentValue(obj.style.top) + getPercentValue(obj.style.height)) + '%';
	}
}

/**
 *  deselects the currently selected element
 */
SlimeyEditor.prototype.deselect = function() {
	if (this.selected) {
		this.selected.className = 'slimeyElement';
	}
	this.selected = null;
	this.resizeHandle.style.visibility = 'hidden';
	this.notifySelectionChange();
}

/**
 *  performs an actions and adds it to the undo stack
 */
SlimeyEditor.prototype.performAction = function(action) {
	action.perform();
	this.undoStack.push(action);
	this.redoStack.clear();
	this.notifyActionPerformed();

	/* save the current slide's content after performing an action */
	SlimeyNavigation.getInstance().saveCurrentSlide();
}

/**
 *  undoes last action
 */
SlimeyEditor.prototype.undo = function() {
	var action = this.undoStack.pop();
	if (action) {
		action.undo();
		this.redoStack.push(action);
	}
	this.notifyActionPerformed();

	/* save the current slide's content after performing an action */
	SlimeyNavigation.getInstance().saveCurrentSlide();
}

/**
 *  redoes last action
 */
SlimeyEditor.prototype.redo = function() {
	var action = this.redoStack.pop();
	if (action) {
		action.perform();
		this.undoStack.push(action);
	}
	this.notifyActionPerformed();

	/* save the current slide's content after performing an action */
	SlimeyNavigation.getInstance().saveCurrentSlide();
}

/*--- SlimeyEditor listener ---*/
SlimeyEditor.prototype.addSelectionChangeListener = function(listener) {
	this.selectionChangeListeners[this.selectionChangeListeners.length++] = listener;
}

SlimeyEditor.prototype.removeSelectionChangeListener = function(listener) {
	for (var i=0; i < this.selectionChangeListeners.length; i++) {
		if (this.selectionChangeListeners[i] == listener) {
			this.selectionChangeListeners[i] = this.selectionChangeListeners[--this.selectionChangeListeners.length];
		}
	}
}

SlimeyEditor.prototype.notifySelectionChange = function() {
	for (var i=0; i < this.selectionChangeListeners.length; i++) {
		this.selectionChangeListeners[i].notifySelectionChange();
	}
}

SlimeyEditor.prototype.addActionPerformedListener = function(listener) {
	this.actionPerformedListeners[this.actionPerformedListeners.length++] = listener;
}

SlimeyEditor.prototype.removeActionPerformedListener = function(listener) {
	for (var i=0; i < this.actionPerformedListeners.length; i++) {
		if (this.actionPerformedListeners[i] == listener) {
			this.actionPerformedListeners[i] = this.actionPerformedListeners[--this.actionPerformedListeners.length];
		}
	}
}

SlimeyEditor.prototype.notifyActionPerformed = function() {
	for (var i=0; i < this.actionPerformedListeners.length; i++) {
		this.actionPerformedListeners[i].notifyActionPerformed();
	}
}

/*--- SlimeyEditor events ---*/

/**
 *  handles click events - selects the clicked element in the editor
 *  	obj: clicked element
 *  	e: mouseclick event
 */
SlimeyEditor.prototype.click = function(obj, e) {
	if (obj != this.selected) {
		this.select(obj);
	}
}


/**
 *  handles double click events - begins editing of an element's content
 *  	obj: clicked element
 *  	e: mouseclick event
 */
SlimeyEditor.prototype.dblclick = function(obj, e) {
	if (obj != this.selected) {
		this.select(obj);
	}
	if (!obj.editable) {
		return;
	}
	this.contentEditor.editElement = obj;
	this.contentEditor.style.visibility = 'visible';
	this.contentEditor.style.fontFamily = obj.style.fontFamily;
	this.contentEditor.style.color = obj.style.color;
	this.contentEditor.style.fontSize = obj.style.fontSize;
	this.contentEditor.style.fontWeight = obj.style.fontWeight;
	this.contentEditor.style.fontStyle = obj.style.fontStyle;
	this.contentEditor.style.textDecoration = obj.style.textDecoration;
	this.contentEditor.style.left = obj.style.left;
	this.contentEditor.style.top = obj.style.top;
	this.contentEditor.style.width = obj.offsetWidth + 50 + 'px';
	this.contentEditor.style.height = obj.offsetHeight + 20 + 'px';
	var val = obj.innerHTML;
	if (obj.tagName == 'UL' || obj.tagName == 'OL') {
		val = val.replace(/<\/li><li>/gi, '\n');
		val = val.replace(/<li>|<\/li>/gi, '');
	} else if (obj.tagName == 'DIV') {
		val = val.replace(/<br>/gi, '\n');
	}
	this.contentEditor.value = val;
	this.contentEditor.focus();
}

/**
 *  handles dragging events - the dragged element becomes movable with the mouse
 *  	obj: dragged element
 *  	e: mousedown event
 */
SlimeyEditor.prototype.drag = function(obj, e) {
	this.current = obj;
	if (!obj.systemElement) {
		this.select(obj);
	}
	var pos = getMousePosition(e, this.container);
	this.hSize = this.container.offsetWidth;
	this.vSize = this.container.offsetHeight;
	var xpercent = getPercentValue(obj.style.left);
	var ypercent = getPercentValue(obj.style.top);
	if (xpercent > 100) xpercent = 50;
	if (ypercent > 100) ypercent = 50;
	var w = Math.round(xpercent * this.hSize / 100);
	var h = Math.round(ypercent * this.vSize / 100);
	this.difx = pos.x - w;
	this.dify = pos.y - h;
	this.dragx = this.movex = xpercent;
	this.dragy = this.movey = ypercent;
}

/**
 *  handles mousemove events - moves the currently dragged element
 *  	e: mousemove event
 */
SlimeyEditor.prototype.move = function(e) {
	if (this.current) {
		var pos = getMousePosition(e, this.container);
		this.movex = Math.round((pos.x - this.difx) * 100 / this.hSize);
		this.movey = Math.round((pos.y - this.dify) * 100 / this.vSize);
		this.current.style.left = this.movex + '%';
		this.current.style.top = this.movey + '%';
		this.printDebug("(" + this.current.style.left + ", " + this.current.style.top + ")");
		if (this.current.resizable) {
			this.resizeHandle.style.left = (getPercentValue(this.current.style.left) + getPercentValue(this.current.style.width)) + '%';
			this.resizeHandle.style.top = (getPercentValue(this.current.style.top) + getPercentValue(this.current.style.height)) + '%';
		}
	}
	if (this.current == this.resizeHandle) {
		this.selected.style.width = (getPercentValue(this.resizeHandle.style.left) - getPercentValue(this.selected.style.left)) + '%';
		this.selected.style.height = (getPercentValue(this.resizeHandle.style.top) - getPercentValue(this.selected.style.top)) + '%';
	}
}

/**
 *  handles mouseup events - drops the currently dragged element
 */
SlimeyEditor.prototype.drop = function() {
	if (this.current) {
		if (!this.current.systemElement) {
			/* an item was moved */
			if (this.current.style.position == 'absolute' && (this.dragx != this.movex || this.dragy != this.movey)) {
				var action = new SlimeyMoveAction(this.movex + '%', this.movey + '%', this.dragx + '%', this.dragy + '%');
				this.performAction(action);
			}
		} else {
			/* an item was resized */
			var neww = (getPercentValue(this.resizeHandle.style.left) - getPercentValue(this.selected.style.left)) + '%';
			var newh = (getPercentValue(this.resizeHandle.style.top) - getPercentValue(this.selected.style.top)) + '%';
			var oldw = (this.dragx - getPercentValue(this.selected.style.left)) + '%';
			var oldh = (this.dragy - getPercentValue(this.selected.style.top)) + '%';
			if (neww != oldw || newh != oldh) {
				var action = new SlimeyResizeAction(neww, newh, oldw, oldh);
				this.performAction(action);
			}
		}
	}
	this.current = null;
}

/**
 *  called when the containing window is resized. Adjusts the editor's size to the window.
 */
SlimeyEditor.prototype.resized = function() {
	this.container.style.fontSize = this.container.offsetWidth / 32 + 'px';
	this.container.style.height = (this.container.offsetWidth * 3/4) + 'px';
}

SlimeyEditor.prototype.printDebug = function(text) {
	/*if (! this.debug) {
		this.debug = document.createElement('div');
		this.debug.style.position = 'absolute';
		this.debug.style.right = '0px';
		this.debug.style.top = '0px';
		this.container.appendChild(this.debug);
	}
	this.debug.innerHTML = text;*/
}

/*--------------- GLOBAL EVENTS -------------------------------------------------------*/

function slimeyClick(e) {
	SlimeyEditor.getInstance().click(this);
	
	stopPropagation(e);
	return false;
}

function slimeyHighlight() {
	this.className = 'slimeyHighlightedElement';
}

function slimeyLowshadow() {
	if (this == SlimeyEditor.getInstance().getSelected()) {
		this.className = 'slimeySelectedElement';
	} else {
		this.className = 'slimeyElement';
	}
}

function slimeyDrag(e) {
	if (!e) var e = window.event;
	SlimeyEditor.getInstance().drag(this, e);
	
	stopPropagation(e);
	return false;
}

function slimeyMove(e) {
	if (!e) var e = window.event;
	try {
		SlimeyEditor.getInstance().move(e);
		
		stopPropagation(e);
	} catch(e) {}
	return false;
}

function slimeyDrop(e) {
	SlimeyEditor.getInstance().drop();
}

function slimeyDeselect(e) {
	try {
		SlimeyEditor.getInstance().deselect();
	} catch (e) {}
}

function slimeyResize() {
	try {
		SlimeyEditor.getInstance().resized();
	} catch (e) {}
}

function slimeyEdit(e) {
	SlimeyEditor.getInstance().dblclick(this, e);
	
	stopPropagation(e);
	return false;
}