/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Base Action definitions.
 */

/**
 *  abstract class SlimeyAction - Actions on the editor
 *  	name: name of the action
 */
var SlimeyAction = function(name) {
	this.name = name;
}

/**
 *  returns the action's name.
 */
SlimeyAction.prototype.getName = function() {
	return this.name;
}

/**
 *  base perform() implementation
 */
SlimeyAction.prototype.perform = function() {
}

/**
 *  base undo() implementation
 */
SlimeyAction.prototype.undo = function() {

}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertAction - Handles insertion of new elements
 *  	tagname: HTML tagname of the element to be inserted
 */
var SlimeyInsertAction = function(tagname) {
	SlimeyAction.call(this, 'insert');

	var elem = SlimeyEditor.getInstance().getContainer().ownerDocument.createElement(tagname);
	/* set element attributes */
	elem.className = 'slimeyElement';
	elem.style.position = 'absolute';
	elem.style.left = '40%';
	elem.style.top = '30%';
	elem.style.lineHeight = '1.';
	elem.style.cursor = 'move';
	elem.onmousedown = slimeyDrag;
	elem.onclick = slimeyClick;
	elem.ondblclick = slimeyEdit;
	elem.onmouseover = slimeyHighlight;
	elem.onmouseout = slimeyLowshadow;
	elem.style.fontFamily = 'sans-serif';
	elem.style.fontSize = '160%';
	elem.style.margin = '0px';
	elem.style.padding = '0px';
	elem.style.border = '0px';
	elem.style.zIndex = 10000;
	if (elem.tagName == 'DIV') {
		//elem.style.width = '20%';
		//elem.style.height = '20%';
		elem.innerHTML = 'Some Text';
		//elem.resizable = true;
		elem.editable = true;
	} else if (elem.tagName == 'IMG') {
		elem.style.width = '20%';
		elem.style.height = '20%';
		elem.resizable = true;
		elem.title = 'Drag the bottom right corner to resize';
	} else {
		if (elem.tagName == 'UL') {
			elem.innerHTML = '<li>Some Text</li>';
		} else if (elem.tagName == 'OL') {
			elem.innerHTML = '<li>Some Text</li>';
		} else {
			elem.innerHTML = 'Some Text';
		}
		elem.editable = true;
		elem.title = 'Double click to edit content';
	}

	this.element = elem;
}

/**
 *  SlimeyInsertAction extends SlimeyAction
 */
SlimeyInsertAction.prototype = new SlimeyAction();

/**
 *  returns the element created by this action
 */
SlimeyInsertAction.prototype.getElement = function() {
	return this.element;
}

/**
 *  adds the created element to the editor
 */
SlimeyInsertAction.prototype.perform = function() {
	SlimeyEditor.getInstance().getContainer().appendChild(this.element);
}

/**
 *  removes the created element from the editor
 */
SlimeyInsertAction.prototype.undo = function() {
	SlimeyEditor.getInstance().getContainer().removeChild(this.element);
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected == this.element) {
		SlimeyEditor.getInstance().deselect();
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyEditContentAction - edits the contents of the selected element in the editor
 *  	content: HTML content to set to the element
 */
var SlimeyEditContentAction = function(content) {
	SlimeyAction.call(this, 'editContent');

	this.element = SlimeyEditor.getInstance().getSelected();
	this.content = content;
}

/**
 *  SlimeyInsertAction extends SlimeyAction
 */
SlimeyEditContentAction.prototype = new SlimeyAction();


/**
 *  edits the contents of the selected item in the editor
 */
SlimeyEditContentAction.prototype.perform = function() {
	this.previousContent = this.element.innerHTML;
	this.element.innerHTML = this.content;
}

/**
 *  restores the elements original content
 */
SlimeyEditContentAction.prototype.undo = function() {
	this.element.innerHTML = this.previousContent;
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyEditStyleAction - edits a style property of the selected element in the editor
 *  	property: CSS property to be modified (i.e. fontFamily)
 *  	value: Value to set to the property (i.e. sans-serif)
 */
var SlimeyEditStyleAction = function(property, value) {
	SlimeyAction.call(this, 'editStyle');

	this.element = SlimeyEditor.getInstance().getSelected();
	this.property = property;
	this.value = value;
}

/**
 *  SlimeyInsertAction extends SlimeyAction
 */
SlimeyEditStyleAction.prototype = new SlimeyAction();


/**
 *  edits the contents of the selected item in the editor
 */
SlimeyEditStyleAction.prototype.perform = function() {
	this.previousValue = this.element.style[this.property];
	this.element.style[this.property] = this.value;
}

/**
 *  restores the elements original content
 */
SlimeyEditStyleAction.prototype.undo = function() {
	this.element.style[this.property] = this.previousValue;
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyDeleteAction - Deletes the selected element
 */
var SlimeyDeleteAction = function() {
	SlimeyAction.call(this, 'delete');

	var selected = SlimeyEditor.getInstance().getSelected();
	this.element = selected;
}

/**
 *  SlimeyDeleteAction extends SlimeyAction
 */
SlimeyDeleteAction.prototype = new SlimeyAction();

/**
 *  removes the selected element from the editor
 */
SlimeyDeleteAction.prototype.perform = function() {
	SlimeyEditor.getInstance().getContainer().removeChild(this.element);
	SlimeyEditor.getInstance().deselect();
}

/**
 *  adds the previously deleted element to the editor
 */
SlimeyDeleteAction.prototype.undo = function() {
	SlimeyEditor.getInstance().getContainer().appendChild(this.element);
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyMoveAction - Moves the selected element
 *  	newx: new horizontal position
 *  	newy: new vertical position
 *  	oldx: (optional) previous horizontal position if different than current
 *  	oldy: (optional) previous vertical position if different than current
 */
var SlimeyMoveAction = function(newx, newy, oldx, oldy) {
	SlimeyAction.call(this, 'move');

	var selected = SlimeyEditor.getInstance().getSelected();
	this.newx = newx;
	this.newy = newy;
	if (oldx) {
		this.oldx = oldx;
	} else {
		this.oldx = selected.style.left;
	}
	if (oldy) {
		this.oldy = oldy;
	} else {
		this.oldy = selected.style.top;
	}
	this.element = selected;
}

/**
 *  SlimeyMoveAction extends SlimeyAction
 */
SlimeyMoveAction.prototype = new SlimeyAction();

/**
 *  moves the selected element to the new position
 */
SlimeyMoveAction.prototype.perform = function() {
	this.element.style.left = this.newx;
	this.element.style.top = this.newy;
}

/**
 *  returns the moved element to its original position
 */
SlimeyMoveAction.prototype.undo = function() {
	this.element.style.left = this.oldx;
	this.element.style.top = this.oldy;
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyResizeAction - Resizes the selected element
 *  	neww: new width
 *  	newh: new height
 *  	oldw: (optional) previous width if different than current
 *  	oldh: (optional) previous height if different than current
 */
var SlimeyResizeAction = function(neww, newh, oldw, oldh) {
	SlimeyAction.call(this, 'resize');

	var selected = SlimeyEditor.getInstance().getSelected();
	this.neww = neww;
	this.newh = newh;
	if (oldw) {
		this.oldw = oldw;
	} else {
		this.oldw = selected.style.width;
	}
	if (oldh) {
		this.oldh = oldh;
	} else {
		this.oldh = selected.style.height;
	}
	this.element = selected;
}

/**
 *  SlimeyResizeAction extends SlimeyAction
 */
SlimeyResizeAction.prototype = new SlimeyAction();

/**
 *  resizes the selected element
 */
SlimeyResizeAction.prototype.perform = function() {
	this.element.style.width = this.neww;
	this.element.style.height = this.newh;
}

/**
 *  returns the element to its original size
 */
SlimeyResizeAction.prototype.undo = function() {
	this.element.style.width = this.oldw;
	this.element.style.height = this.oldh;
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeySendToBackAction - Sends the selected element to the back
 */
var SlimeySendToBackAction = function() {
	SlimeyAction.call(this, 'sendToBack');

	var selected = SlimeyEditor.getInstance().getSelected();
	this.element = selected;
}

/**
 *  SlimeySendToBackAction extends SlimeyAction
 */
SlimeySendToBackAction.prototype = new SlimeyAction();

/**
 *  sends the selected element to the back
 */
SlimeySendToBackAction.prototype.perform = function() {
	var minZ = 100000000;
	for (var elem = SlimeyEditor.getInstance().getContainer().firstChild; elem; elem = elem.nextSibling) {
		if (elem.nodeType == 1) {
			thisZ = parseInt(elem.style.zIndex);
			if (thisZ < minZ) {
				minZ = thisZ;
			}
		}
	}
	this.oldZ = this.element.style.zIndex;
	this.element.style.zIndex = minZ - 1;
}

/**
 *  sends the selected element back ot the previous z-index
 */
SlimeySendToBackAction.prototype.undo = function() {
	this.element.style.zIndex = this.oldZ;
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyBringToFrontAction - Brings the selected element to the front
 */
var SlimeyBringToFrontAction = function() {
	SlimeyAction.call(this, 'bringToFront');

	var selected = SlimeyEditor.getInstance().getSelected();
	this.element = selected;
}

/**
 *  SlimeyBringToFrontAction extends SlimeyAction
 */
SlimeyBringToFrontAction.prototype = new SlimeyAction();

/**
 *  brings the selected element to the front
 */
SlimeyBringToFrontAction.prototype.perform = function() {
	var maxZ = 0;
	for (var elem = SlimeyEditor.getInstance().getContainer().firstChild; elem; elem = elem.nextSibling) {
		if (elem.nodeType == 1) {
			thisZ = parseInt(elem.style.zIndex);
			if (thisZ > maxZ) {
				maxZ = thisZ;
			}
		}
	}
	this.oldZ = this.element.style.zIndex;
	this.element.style.zIndex = maxZ + 1;
}

/**
 *  returns the element to its original z-index
 */
SlimeyBringToFrontAction.prototype.undo = function() {
	this.element.style.zIndex = this.oldZ;
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyChangeSlideAction - Changes the current slide
 *  	num: Slide number to change to
 */
var SlimeyChangeSlideAction = function(num) {
	SlimeyAction.call(this, 'changeSlide');

	this.num = num;
}

/**
 *  SlimeyChangeSlideAction extends SlimeyAction
 */
SlimeyChangeSlideAction.prototype = new SlimeyAction();

/**
 *  changes the current slide
 */
SlimeyChangeSlideAction.prototype.perform = function() {
	this.previousSlide = SlimeyNavigation.getInstance().currentSlide;
	SlimeyNavigation.getInstance().getSlide(this.num);
}

/**
 *  returns to the previous slide
 */
SlimeyChangeSlideAction.prototype.undo = function() {
	SlimeyNavigation.getInstance().getSlide(this.previousSlide);
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertSlideAction - Inserts a new slide
 *  	num: Position where to insert the new slide
 */
var SlimeyInsertSlideAction = function(num) {
	SlimeyAction.call(this, 'changeSlide');

	this.num = num;
}

/**
 *  SlimeyInsertSlideAction extends SlimeyAction
 */
SlimeyInsertSlideAction.prototype = new SlimeyAction();

/**
 *  insert the new slide
 */
SlimeyInsertSlideAction.prototype.perform = function() {
	SlimeyNavigation.getInstance().insertNewSlide(this.num);
}

/**
 *  remove the inserted slide
 */
SlimeyInsertSlideAction.prototype.undo = function() {
	SlimeyNavigation.getInstance().deleteSlide(this.num);
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyDeleteSlideAction - Deletes the current slide
 *  	num: Number of the slide to be deleted
 */
var SlimeyDeleteSlideAction = function(num) {
	SlimeyAction.call(this, 'changeSlide');

	this.num = num;
}

/**
 *  SlimeyDeleteSlideAction extends SlimeyAction
 */
SlimeyDeleteSlideAction.prototype = new SlimeyAction();

/**
 *  delete the current slide
 */
SlimeyDeleteSlideAction.prototype.perform = function() {
	this.html = SlimeyEditor.getInstance().getHTML();
	this.dom = document.createElement('div');
	SlimeyEditor.getInstance().getDOM(this.dom);
	SlimeyNavigation.getInstance().deleteSlide(this.num);
}

/**
 *  reinsert the deleted slide
 */
SlimeyDeleteSlideAction.prototype.undo = function() {
	SlimeyNavigation.getInstance().insertNewSlide(this.num, this.html, this.dom);
}

/*---------------------------------------------------------------------------*/