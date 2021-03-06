/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Tool class definitions
 */

var rootDir = '';
var imagesDir = rootDir + 'images/';

function createImageButton(name, title, slimeyTool) {
	var img = document.createElement('img');
	img.src = imagesDir + name + '.png';
	img.className = 'slimeyTool';
	img.title = title;
	img.slimeyTool = slimeyTool;
	img.style.marginLeft = '4px';
	img.style.marginBottom = '4px';
	img.style.verticalAlign = 'middle';
	img.style.cursor = 'pointer';
	img.onmouseover = function() {
		if (this.slimeyTool.enabled && !this.slimeyTool.toggled) {
			this.src = imagesDir + name + 'h.png';
		}
	};
	img.onmouseout = function() {
		if (this.slimeyTool.enabled) {
			if (this.slimeyTool.toggled) {
				this.src = imagesDir + name + 'd.png';
			} else {
				this.src = imagesDir + name + '.png';
			}
		}
	};
	img.onmousedown = function() {
		if (this.slimeyTool.enabled) {
			this.src = imagesDir + name + 'd.png';
		}
	};
	img.onmouseup = function() {
		if (this.slimeyTool.enabled) {
			this.src = imagesDir + name + 'h.png';
		}
	};
	img.onclick = function() {
		if (this.slimeyTool.enabled) {
			this.slimeyTool.execute();
		}
	};
	return img;
}


/*---------------------------------------------------------------------------*/
/**
 *  class SlimeyTool - tools that affect the editor's content
 */
var SlimeyTool = function(name, element) {
	this.name = name;
	this.element = element;
	this.enabled = true;
}

/**
 *  returns the tool's name
 */
SlimeyTool.prototype.getName = function() {
	return this.name;
}

/**
 *  returns the tool's DOM element
 */
SlimeyTool.prototype.getElement = function() {
	return this.element;
}

/**
 *  executes its corresponding action
 */
SlimeyTool.prototype.execute = function() {
	alert('Generic Tool');
}

/**
 *  this function is called when the selection changes in the editor
 */
SlimeyTool.prototype.notifySelectionChange = function() {
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertTool - this tool inserts new elements into the editor
 */
var SlimeyInsertTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('insert', 'Insert an element', this);

	SlimeyTool.call(this, 'insert', img);
}

/**
 *  SlimeyInsertTool extends SlimeyTool
 */
SlimeyInsertTool.prototype = new SlimeyTool();

/**
 *  inserts a new element into the editor
 */
SlimeyInsertTool.prototype.execute = function() {
	var tag = prompt('What element do you wish to insert?');
	if (tag) {
		var action = new SlimeyInsertAction(tag);
		SlimeyEditor.getInstance().performAction(action);
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertTextTool - this tool inserts new text into the editor
 */
var SlimeyInsertTextTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('insertText', 'Insert text', this);

	SlimeyTool.call(this, 'insertText', img);
}

/**
 *  SlimeyInsertTextTool extends SlimeyTool
 */
SlimeyInsertTextTool.prototype = new SlimeyTool();

/**
 *  inserts a new text element into the editor
 */
SlimeyInsertTextTool.prototype.execute = function() {
	var action = new SlimeyInsertAction('div');
	SlimeyEditor.getInstance().performAction(action);
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertImageTool - this tool inserts new images into the editor
 */
var SlimeyInsertImageTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('insertImage', 'Insert image', this);

	SlimeyTool.call(this, 'insertImage', img);
}

/**
 *  SlimeyInsertImageTool extends SlimeyTool
 */
SlimeyInsertImageTool.prototype = new SlimeyTool();

/**
 *  inserts a new image into the editor
 */
SlimeyInsertImageTool.prototype.execute = function() {
	chooseImage(this.imageChosen);
}

SlimeyInsertImageTool.prototype.imageChosen = function(url) {
	if (url) {
		var action = new SlimeyInsertAction('img');
		action.getElement().src = url;
		SlimeyEditor.getInstance().performAction(action);
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertOrderedListTool - this tool inserts new ordered list into the editor
 */
var SlimeyInsertOrderedListTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('insertOList', 'Insert ordered list', this);

	SlimeyTool.call(this, 'insertOList', img);
}

/**
 *  SlimeyInsertOrderedListTool extends SlimeyTool
 */
SlimeyInsertOrderedListTool.prototype = new SlimeyTool();

/**
 *  inserts a new orderd list into the editor
 */
SlimeyInsertOrderedListTool.prototype.execute = function() {
	var action = new SlimeyInsertAction('ol');
	SlimeyEditor.getInstance().performAction(action);
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyInsertUnorderedListTool - this tool inserts new ordered list into the editor
 */
var SlimeyInsertUnorderedListTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('insertUList', 'Insert unordered list', this);

	SlimeyTool.call(this, 'insertUList', img);
}

/**
 *  SlimeyInsertUnorderedListTool extends SlimeyTool
 */
SlimeyInsertUnorderedListTool.prototype = new SlimeyTool();

/**
 *  inserts a new unordered list into the editor
 */
SlimeyInsertUnorderedListTool.prototype.execute = function() {
	var action = new SlimeyInsertAction('ul');
	SlimeyEditor.getInstance().performAction(action);
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyEditContentTool - this tool edits the content of an element in the editor
 */
var SlimeyEditContentTool = function() {
	var textarea = document.createElement('textarea');
	textarea.slimeyTool = this;
	textarea.style.height = '25px';
	textarea.style.width = '100%';
	textarea.style.backgroundColor = 'lightYellow';
	textarea.style.marginBottom = '4px';
	textarea.title = 'Edit the element\'s content';
	textarea.onkeyup = function() {
		this.slimeyTool.execute();
	};

	SlimeyTool.call(this, 'editContent', textarea);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);
	//SlimeyEditor.getInstance().addActionPerformedListener(this);

	this.element.disabled = true;
}

/**
 *  SlimeyEditContentTool extends SlimeyTool
 */
SlimeyEditContentTool.prototype = new SlimeyTool();

/**
 *  edits the content of an element in the editor
 */
SlimeyEditContentTool.prototype.execute = function() {
	var val = this.element.value;
	var selected = SlimeyEditor.getInstance().getSelected();

	if (selected.tagName == 'UL' || selected.tagName == 'OL') {
		val = '<li>' + val + '</li>';
		val = val.replace(/\n/g, '</li><li>');
	} else if (selected.tagName == 'P') {
		val = val.replace(/\n/g, '<br>');
	}
	var action = new SlimeyEditContentAction(val);
	SlimeyEditor.getInstance().performAction(action);
}

SlimeyEditContentTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		var val = selected.innerHTML;
	
		if (selected.tagName == 'UL' || selected.tagName == 'OL') {
			val = val.replace(/<\/li><li>/gi, '\n');
			val = val.replace(/<li>|<\/li>/gi, '');
		} else if (selected.tagName == 'P') {
			val = val.replace(/<br>/gi, '\n');
		}
		if (val != this.element.value) {
			this.element.value = val;
		}
		if (selected.editable) {
			this.element.disabled = false;
		} else {
			this.element.disabled = true;
		}
	} else {
		this.element.value = '';
		this.element.disabled = true;
	}
}

//SlimeyEditContentTool.prototype.notifyActionPerformed = SlimeyEditContentTool.prototype.notifySelectionChange;
/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyFontColorTool - this tool lets you choose the font color of an element in the editor
 */
var SlimeyFontColorTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('color', 'Change font color', this);

	SlimeyTool.call(this, 'color', img);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeyFontColorTool extends SlimeyTool
 */
SlimeyFontColorTool.prototype = new SlimeyTool();

/**
 *  changes the font color of the selected element in the editor
 */
SlimeyFontColorTool.prototype.execute = function() {
	chooseColor(this.colorChosen);
}

SlimeyFontColorTool.prototype.colorChosen = function(color) {
	if (color) {
		var action = new SlimeyEditStyleAction('color', color);
		SlimeyEditor.getInstance().performAction(action);
	}
}

SlimeyFontColorTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected && selected.editable) {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	} else {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyFontSizeTool - this tool lets you choose the font size of an element in the editor
 */
var SlimeyFontSizeTool = function() {
	var select = document.createElement('select');
	select.style.height = '20px';
	select.style.width = '80px';
	select.style.marginLeft = '4px';
	select.title = 'Change font family';

	var option = document.createElement('option');
	option.value = option.style.fontSize = '';
	option.appendChild(document.createTextNode('-- Size --'));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '80%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '100%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '120%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '140%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '160%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '200%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '300%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontSize = '400%';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	select.slimeyTool = this;
	select.onchange = function() {
		this.slimeyTool.execute();
	};

	SlimeyTool.call(this, 'fontsize', select);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);
	SlimeyEditor.getInstance().addActionPerformedListener(this);

	this.element.disabled = true;
}

/**
 *  SlimeyFontSizeTool extends SlimeyTool
 */
SlimeyFontSizeTool.prototype = new SlimeyTool();

/**
 *  edits the font size of the selected element in the editor
 */
SlimeyFontSizeTool.prototype.execute = function() {
	var action = new SlimeyEditStyleAction('fontSize', this.element.value);
	SlimeyEditor.getInstance().performAction(action);
}

SlimeyFontSizeTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected && selected.style.fontSize && selected.editable) {
		this.element.value = selected.style.fontSize;
		this.element.disabled = false;
	} else if (selected && selected.editable) {
		this.element.value = '';
		this.element.disabled = false;
	} else {
		this.element.disabled = true;
	}
}

SlimeyFontSizeTool.prototype.notifyActionPerformed = SlimeyFontSizeTool.prototype.notifySelectionChange;

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyFontFamilyTool - this tool lets you choose the font family of an element in the editor
 */
var SlimeyFontFamilyTool = function() {
	var select = document.createElement('select');
	select.style.height = '20px';
	select.style.width = '140px';
	select.style.marginLeft = '4px';
	select.title = 'Change font size';

	var option = document.createElement('option');
	option.value = option.style.fontFamily = '';
	option.appendChild(document.createTextNode('-- Font Family --'));
	select.appendChild(option);
	
	var optgroup = document.createElement('optgroup');
	optgroup.setAttribute('label', 'Generic Fonts');
	select.appendChild(optgroup);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'serif';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'sans-serif';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'cursive';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'fantasy';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'monospace';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	optgroup = document.createElement('optgroup');
	optgroup.setAttribute('label', 'Specific Fonts');
	select.appendChild(optgroup);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Arial';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Book Antigua';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Comic Sans';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Courier New';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Tahoma';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Times New Roman';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	option = document.createElement('option');
	option.value = option.style.fontFamily = 'Verdana';
	option.appendChild(document.createTextNode(option.value));
	select.appendChild(option);

	select.slimeyTool = this;
	select.onchange = function() {
		this.slimeyTool.execute();
	};

	SlimeyTool.call(this, 'fontfamily', select);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);
	SlimeyEditor.getInstance().addActionPerformedListener(this);
}

/**
 *  SlimeyFontFamilyTool extends SlimeyTool
 */
SlimeyFontFamilyTool.prototype = new SlimeyTool();

/**
 *  edits the font family of the selected element in the editor
 */
SlimeyFontFamilyTool.prototype.execute = function() {
	var action = new SlimeyEditStyleAction('fontFamily', this.element.value);
	SlimeyEditor.getInstance().performAction(action);
}

SlimeyFontFamilyTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected && selected.style.fontFamily && selected.editable) {
		this.element.value = selected.style.fontFamily;
		this.element.disabled = false;
	} else if (selected && selected.editable) {
		this.element.value = '';
		this.element.disabled = false;
	} else {
		this.element.disabled = true;
	}
}

SlimeyFontFamilyTool.prototype.notifyActionPerformed = SlimeyFontFamilyTool.prototype.notifySelectionChange;

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyDeleteTool - this tool deletes the selected element in the editor
 */
var SlimeyDeleteTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('delete', 'Delete element', this);

	SlimeyTool.call(this, 'delete', img);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);

	this.enabled = false;
	img.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeyDeleteTool extends SlimeyTool
 */
SlimeyDeleteTool.prototype = new SlimeyTool();

/**
 *  deletes the selected element in the editor
 */
SlimeyDeleteTool.prototype.execute = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		var action = new SlimeyDeleteAction();
		SlimeyEditor.getInstance().performAction(action);
	}
}

SlimeyDeleteTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	} else {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyUndoTool - this tool undoes last action
 */
var SlimeyUndoTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('undo', 'Undo', this);

	SlimeyTool.call(this, 'undo', img);

	SlimeyEditor.getInstance().addActionPerformedListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeyUndoTool extends SlimeyTool
 */
SlimeyUndoTool.prototype = new SlimeyTool();

/**
 *  undoes the selected element in the editor
 */
SlimeyUndoTool.prototype.execute = function() {
	SlimeyEditor.getInstance().undo();
}

SlimeyUndoTool.prototype.notifyActionPerformed = function() {
	if (SlimeyEditor.getInstance().undoStack.isEmpty()) {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	} else {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyRedoTool - this tool redoes last undone action
 */
var SlimeyRedoTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('redo', 'Redo', this);

	SlimeyTool.call(this, 'redo', img);

	SlimeyEditor.getInstance().addActionPerformedListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeyRedoTool extends SlimeyTool
 */
SlimeyRedoTool.prototype = new SlimeyTool();

/**
 *  redoes the selected element in the editor
 */
SlimeyRedoTool.prototype.execute = function() {
	SlimeyEditor.getInstance().redo();
}

SlimeyRedoTool.prototype.notifyActionPerformed = function() {
	if (SlimeyEditor.getInstance().redoStack.isEmpty()) {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	} else {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyStyleToggleTool - this tool toggles one of the selected element's style properties
 *  	name: Tool's name
 *  	title: Tool's description (tooltip)
 *  	property: Propety to toggle (e.g.: fontWeight)
 *  	value1: Value when button is down (e.g.: bold)
 *  	value2: Value when button is up (e.g.: normal)
 */
var SlimeyStyleToggleTool = function(name, title, property, value1, value2) {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton(name, title, this);

	this.property = property;
	this.value1 = value1;
	this.value2 = value2;

	SlimeyTool.call(this, name, img);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);
	SlimeyEditor.getInstance().addActionPerformedListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeyStyleToggleTool extends SlimeyTool
 */
SlimeyStyleToggleTool.prototype = new SlimeyTool();

/**
 *  toggles the selected element's style property
 */
SlimeyStyleToggleTool.prototype.execute = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		var action;
		if (selected.style[this.property] == this.value1) {
			action = new SlimeyEditStyleAction(this.property, this.value2);
			this.toggled = false;
			this.element.src = imagesDir + this.name + '.png';
		} else {
			action = new SlimeyEditStyleAction(this.property, this.value1);
			this.toggled = true;
			this.element.src = imagesDir + this.name + 'd.png';
		}
		SlimeyEditor.getInstance().performAction(action);
	}
}

SlimeyStyleToggleTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected && selected.editable) {
		this.enabled = true;
		if (selected.style[this.property] == this.value1) {
			this.toggled = true;
			this.element.src = imagesDir + this.name + 'd.png';
		} else {
			this.toggled = false;
			this.element.src = imagesDir + this.name + '.png';
		}
		this.element.style.cursor = 'pointer';
	} else {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	}
}

SlimeyStyleToggleTool.prototype.notifyActionPerformed = SlimeyStyleToggleTool.prototype.notifySelectionChange;

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeySendToBackTool - this tool sends the selected element to the back of the editor
 */
var SlimeySendToBackTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('sendToBack', 'Send element to the back', this);

	SlimeyTool.call(this, 'sendToBack', img);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeySendToBackTool extends SlimeyTool
 */
SlimeySendToBackTool.prototype = new SlimeyTool();

/**
 *  sends the selected element to the back of the editor
 */
SlimeySendToBackTool.prototype.execute = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		var action = new SlimeySendToBackAction();
		SlimeyEditor.getInstance().performAction(action);
	}
}

SlimeySendToBackTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	} else {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyBringToFrontTool - this tool brings the selected element to the front of the editor
 */
var SlimeyBringToFrontTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('bringToFront', 'Bring element to the front', this);

	SlimeyTool.call(this, 'bringToFront', img);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeyBringToFrontTool extends SlimeyTool
 */
SlimeyBringToFrontTool.prototype = new SlimeyTool();

/**
 *  brings the selected element to the front of the editor
 */
SlimeyBringToFrontTool.prototype.execute = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		var action = new SlimeyBringToFrontAction();
		SlimeyEditor.getInstance().performAction(action);
	}
}

SlimeyBringToFrontTool.prototype.notifySelectionChange = function() {
	var selected = SlimeyEditor.getInstance().getSelected();
	if (selected) {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	} else {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyViewSourceTool - view HTML source code
 */
var SlimeyViewSourceTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('viewSource', 'View source code', this);

	SlimeyTool.call(this, 'viewSource', img);

	SlimeyEditor.getInstance().addSelectionChangeListener(this);
}

/**
 *  SlimeyViewSourceTool extends SlimeyTool
 */
SlimeyViewSourceTool.prototype = new SlimeyTool();

/**
 *  view HTML source code
 */
SlimeyViewSourceTool.prototype.execute = function() {
	var html = SlimeyEditor.getInstance().getHTML();
	var ta = $('slimeyViewSource');
	if (!ta) {
		ta = document.createElement('textarea');
		ta.id = 'slimeyViewSource';
		ta.style.border = '4px solid deepskyblue';
		ta.style.width = '80%';
		ta.style.height = '80%';
		ta.style.position = 'absolute';
		ta.style.left = '10%';
		ta.style.top = '10%';
		ta.style.zIndex = '100000';
		ta.style.visibility = 'hidden';
		ta.slimeyTool = this;
		ta.onkeyup = function(e) {
			if (!e) {
				e = event;
				e.which = e.keyCode;
			}
			if (e.which == 27) {
				this.style.visibility = 'hidden';
				this.slimeyTool.toggled = false;
				this.slimeyTool.element.src = imagesDir + this.slimeyTool.name + '.png';
				this.blur();
			}
		}
		document.body.appendChild(ta);
	}
	if (!this.toggled) {
		ta.value = html;
		ta.style.visibility = 'visible';
		this.toggled = true;
		this.element.src = imagesDir + this.name + 'd.png';
		ta.focus();
	} else {
		ta.style.visibility = 'hidden';
		this.toggled = false;
		this.element.src = imagesDir + this.name + '.png';
		ta.blur();
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeySaveTool - saves the current slideshow
 */
var SlimeySaveTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('save', 'Save slideshow', this);

	SlimeyTool.call(this, 'save', img);

	SlimeyEditor.getInstance().addActionPerformedListener(this);

	this.enabled = false;
	this.element.src = imagesDir + this.name + 'x.png';
	this.element.style.cursor = 'default';
}

/**
 *  SlimeySaveTool extends SlimeyTool
 */
SlimeySaveTool.prototype = new SlimeyTool();

/**
 *  saves the current slideshow
 */
SlimeySaveTool.prototype.execute = function() {
	var filename = $('filename').value;
	if (!filename) {
		filename = prompt('Enter a name for the slideshow:', '');
		if (!filename) {
			return;
		} else {
			$('filename').value = filename;
		}
	}
	
	var slim = getSLIMContent();
	$('slimContent').value = escapeSLIM(slim);
	$('slimeyForm').submit();
}

SlimeySaveTool.prototype.notifyActionPerformed = function() {
	if (!SlimeyEditor.getInstance().undoStack.isEmpty()) {
		this.enabled = true;
		this.element.src = imagesDir + this.name + '.png';
		this.element.style.cursor = 'pointer';
	} else {
		this.enabled = false;
		this.element.src = imagesDir + this.name + 'x.png';
		this.element.style.cursor = 'default';
	}
}

/*---------------------------------------------------------------------------*/

/**
 *  class SlimeyPreviewTool - previews the current slideshow
 */
var SlimeyPreviewTool = function() {
	/* create the DOM element that represents the tool (a clickable image) */
	var img = createImageButton('preview', 'Preview slideshow', this);

	SlimeyTool.call(this, 'preview', img);
}

/**
 *  SlimeyPreviewTool extends SlimeyTool
 */
SlimeyPreviewTool.prototype = new SlimeyTool();

/**
 *  previews the current slideshow
 */
SlimeyPreviewTool.prototype.execute = function() {
	/* fullscreen windows are annoying so let's size it 80% of the screen size */
	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;
	window.open(rootDir + 'slime.html', 'slimePreview', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')
}

/*---------------------------------------------------------------------------*/