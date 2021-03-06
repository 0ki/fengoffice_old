/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Toolbar class definition
 */

function createSeparator() {
	var sep = document.createElement('img');
	sep.src = Slimey.imagesDir + 'sep.png';
	sep.style.marginLeft = '8px';
	sep.style.marginRight = '4px';
	sep.style.verticalAlign = 'middle';
	return sep;
}


/**
 *  class SlimeyToolbar - implements functionality for the toolbar
 *  	container: div where the toolbar will reside
 */
var SlimeyToolbar = function(slimey) {
	this.slimey = slimey;
	this.container = document.createElement('div');
	this.container.className = 'slimeyToolbar';
	this.tools = new Array();
	/*this.addTool(new SlimeySaveTool(this.slimey));
	this.addSeparator();*/
	this.addTool(new SlimeyInsertTextTool(this.slimey));
	this.addTool(new SlimeyInsertImageTool(this.slimey));
	this.addTool(new SlimeyInsertOrderedListTool(this.slimey));
	this.addTool(new SlimeyInsertUnorderedListTool(this.slimey));
	this.addTool(new SlimeyDeleteTool(this.slimey));
	this.addSeparator();
	this.addTool(new SlimeyUndoTool(this.slimey));
	this.addTool(new SlimeyRedoTool(this.slimey));
	this.addSeparator();
	this.addTool(new SlimeyFontColorTool(this.slimey));
	this.addTool(new SlimeyFontFamilyTool(this.slimey));
	this.addTool(new SlimeyFontSizeTool(this.slimey));
	this.addSeparator();
	this.addTool(new SlimeyStyleToggleTool(this.slimey, 'bold', 'Bold Text', 'fontWeight', 'bold', 'normal'));
	this.addTool(new SlimeyStyleToggleTool(this.slimey, 'underline', 'Underline Text', 'textDecoration', 'underline', 'none'));
	this.addTool(new SlimeyStyleToggleTool(this.slimey, 'italic', 'Italic Text', 'fontStyle', 'italic', 'normal'));
	this.addSeparator();
	this.addTool(new SlimeySendToBackTool(this.slimey));
	this.addTool(new SlimeyBringToFrontTool(this.slimey));
	this.addSeparator();
	this.addTool(new SlimeyViewSourceTool(this.slimey));
	this.addTool(new SlimeyPreviewTool(this.slimey));
	this.addBreak();
	//this.addTool(new SlimeyEditContentTool());
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