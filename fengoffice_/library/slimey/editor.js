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
var SlimeyEditor = function(container, frame) {
	this.frame = frame;
	this.current = null;
	this.selected = null;
	this.container = container;
	this.undoStack = new SlimeyStack();
	this.redoStack = new SlimeyStack();
	this.selectionChangeListeners = new Array();
	this.actionPerformedListeners = new Array();

	/* create resize handle */
	this.resizeHandle = frame.document.createElement('div');
	this.resizeHandle.id = 'resizeHandle';
	this.resizeHandle.style.zIndex = 100000000;
	this.resizeHandle.style.position = 'absolute';
	this.resizeHandle.style.width = '8px';
	this.resizeHandle.style.height = '8px';
	this.resizeHandle.style.fontSize = '1px';
	this.resizeHandle.style.lineHeight = '1px';
	this.resizeHandle.style.backgroundColor = 'blue';
	this.resizeHandle.style.cursor = 'se-resize';
	this.resizeHandle.style.visibility = 'hidden';
	this.resizeHandle.onmousedown = slimeyDrag;
	this.resizeHandle.systemElement = true;
	container.appendChild(this.resizeHandle);

	container.onmousemove = slimeyMove;
	container.onmouseup = slimeyDrop;
	container.onclick = slimeyDeselect;
	
	container.style.width = '100%';
	container.style.height = '100%';
	container.style.position = 'relative';
	container.style.padding = '0px';
	container.style.border = '1px solid black';
	container.style.overflow = 'hidden';
	container.style.fontSize = '25px';
	container.style.cursor = 'default';
	
	window.onresize = window.onload = slimeyResize;
}

/** singleton */
SlimeyEditor.instance = null;

/**
 *  initialize the editor's instance
 */
SlimeyEditor.initInstance = function(containerID, frame) {
	SlimeyEditor.instance = new SlimeyEditor($(containerID, frame), frame);
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
		this.selected.style.border = this.selected.originalBorder;
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
		this.selected.style.border = '2px dotted green';
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
			if (elem.tagName == 'IMG') {
				elem.resizable = true;
			} else {
				elem.editable = true;
			}
			elem.originalBorder = elem.style.border;
			if (!elem.style.zIndex) {
				elem.style.zIndex = 10000;
			}
			elem.style.cursor = 'move';
		}
	}
	this.container.appendChild(this.resizeHandle);
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
	obj.style.border = '2px dotted green';
	obj.previousBorder = obj.style.border;
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
		this.selected.style.border = this.selected.originalBorder;
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
	var html = this.getHTML();
    slides[currentSlide] = html;
	var previewDiv = $('slide' + currentSlide);
	if (previewDiv) {
		previewDiv.innerHTML = html;
	}
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
	var html = this.getHTML();
    slides[currentSlide] = html;
	var previewDiv = $('slide' + currentSlide);
	if (previewDiv) {
		previewDiv.innerHTML = html;
	}
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
	var html = this.getHTML();
    slides[currentSlide] = html;
	var previewDiv = $('slide' + currentSlide);
	if (previewDiv) {
		previewDiv.innerHTML = html;
	}
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
		this.debug = this.frame.document.createElement('div');
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
	this.previousBorder = this.style.border;
	this.style.border = '2px solid orange';
}

function slimeyLowshadow() {
	this.style.border = this.previousBorder;
}

function slimeyDrag(e) {
	if (!e) var e = window.event;
	SlimeyEditor.getInstance().drag(this, e);
	
	stopPropagation(e);
	return false;
}

function slimeyMove(e) {
	if (!e) var e = window.event;
	SlimeyEditor.getInstance().move(e);
	
	stopPropagation(e);
	return false;
}

function slimeyDrop(e) {
	SlimeyEditor.getInstance().drop();
}

function slimeyDeselect(e) {
	SlimeyEditor.getInstance().deselect();
}

function slimeyResize() {
	SlimeyEditor.getInstance().resized();
}