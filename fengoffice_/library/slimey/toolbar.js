/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Toolbar class definition
 */

function createSeparator() {
	var sep = document.createElement('img');
	sep.src = imagesDir + 'sep.png';
	sep.style.marginLeft = '8px';
	sep.style.marginRight = '4px';
	sep.style.verticalAlign = 'middle';
	return sep;
}


/**
 *  class SlimeyToolbar - implements functionality for the toolbar
 *  	container: div where the toolbar will reside
 */
var SlimeyToolbar = function(container) {
	this.container = container;
	this.tools = new Array();
	this.addTool(new SlimeySaveTool());
	this.addSeparator();
	this.addTool(new SlimeyInsertTextTool());
	this.addTool(new SlimeyInsertImageTool());
	this.addTool(new SlimeyInsertOrderedListTool());
	this.addTool(new SlimeyInsertUnorderedListTool());
	this.addTool(new SlimeyDeleteTool());
	this.addSeparator();
	this.addTool(new SlimeyUndoTool());
	this.addTool(new SlimeyRedoTool());
	this.addSeparator();
	this.addTool(new SlimeyFontColorTool());
	this.addTool(new SlimeyFontFamilyTool());
	this.addTool(new SlimeyFontSizeTool());
	this.addSeparator();
	this.addTool(new SlimeyStyleToggleTool('bold', 'Bold Text', 'fontWeight', 'bold', 'normal'));
	this.addTool(new SlimeyStyleToggleTool('underline', 'Underline Text', 'textDecoration', 'underline', 'none'));
	this.addTool(new SlimeyStyleToggleTool('italic', 'Italic Text', 'fontStyle', 'italic', 'normal'));
	this.addSeparator();
	this.addTool(new SlimeySendToBackTool());
	this.addTool(new SlimeyBringToFrontTool());
	this.addSeparator();
	this.addTool(new SlimeyViewSourceTool());
	this.addTool(new SlimeyPreviewTool());
	this.addBreak();
	this.addTool(new SlimeyEditContentTool());
}

/** singleton */
SlimeyToolbar.instance = null;

/**
 *  returns the single SlimeyToolbar instance
 */
SlimeyToolbar.getInstance = function() {
	if (SlimeyToolbar.instance == null) {
		SlimeyToolbar.instance = new SlimeyToolbar($('slimeyToolbar'));
	}
	return SlimeyToolbar.instance;
}

/**
 *  adds a SlimeyTool to the toolbar.
 *  	tool: SlimeyTool to add
 */
SlimeyToolbar.prototype.addTool = function(tool) {
	this.tools[this.tools.length++] = tool;
	this.container.appendChild(tool.getElement());
}

/**
 *  adds a separator between tools in the toolbar.
 */
SlimeyToolbar.prototype.addSeparator = function() {
	this.container.appendChild(createSeparator());
}

/**
 *  adds a line break between tools in the toolbar.
 */
SlimeyToolbar.prototype.addBreak = function() {
	this.container.appendChild(document.createElement('br'));
}