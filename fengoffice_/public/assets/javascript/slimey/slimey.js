/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Inclusion to a webpage.
 */

/**
 *  Initializes and writes an instance of Slimey
 *
 *  config options:
 *  	container: Where Slimey will be written to
 *  	rootDir: Slimey classes root dir
 *  	imagesDir: Slimey images dir
 *  	filename: name of the file that's going to be edited
 *  	slimContent: content of the file
 *  	saveUrl: where the modified file will be submited
 */
var Slimey = function(config) {
	if (config.rootDir) Slimey.rootDir = config.rootDir;
	if (config.imagesDir) Slimey.imagesDir = config.imagesDir;
	if (config.filename) this.filename = config.filename;
	if (config.slimContent) this.slimContent = config.slimContent;
	if (config.saveUrl) this.saveUrl = config.saveUrl;
	this.config = config;
	Slimey.preloadImages();
	this.editor = new SlimeyEditor(this);
	this.navigation = new SlimeyNavigation(this);
	this.toolbar = new SlimeyToolbar(this);
	
	var div = document.createElement('div');
	div.style.position = 'relative';
	div.style.marginLeft = '200px';
	div.style.marginRight = '2px';
	div.style.height = '100%';
	div.appendChild(this.toolbar.container);
	div.appendChild(this.editor.container);
	this.container = $(config.container);
	this.container.appendChild(this.navigation.container);
	this.container.appendChild(div);
}

Slimey.prototype.submitFile = function(newRevision) {
	var form, nr;
	if (!form) {
		form = document.createElement('form');
		form.target = 'frm' + this.config.container.substring(6);
		form.method = 'POST';
		form.action = this.saveUrl;
		var fn = document.createElement('input');
		fn.type = 'hidden';
		fn.name = 'file[name]';
		fn.value = this.filename;
		form.appendChild(fn);
		var sc = document.createElement('input');
		sc.type = 'hidden';
		sc.name = 'slimContent';
		sc.value = this.slimContent;
		form.appendChild(sc);
		document.body.appendChild(form);
	}
	if (!nr) {
		nr = document.createElement('input');
		nr.type = 'hidden';
		nr.name = 'new_revision_document';
		form.appendChild(nr);
	}
	if (newRevision) {
		nr.value = 'checked';
	} else {
		nr.value = "";
	}
	og.submit(form);
}

Slimey.imagesDir = 'images/';

Slimey.rootDir = '';

Slimey.preloadedImages = new Array();

Slimey.includeScripts = function() {
	document.write('<script language="javascript" src="' + slimeyRootDir + 'functions.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'stack.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'editor.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'navigation.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'actions.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'tools.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'toolbar.js"></script>');
}

Slimey.preloadImage = function(filename) {
	var ims = Slimey.preloadedImages;
	var i = ims.length;
	ims[i] = new Image(); ims[i].src = Slimey.imagesDir + filename;
}

Slimey.preloadToolbarImage = function(name) {
	Slimey.preloadImage(name + '.png');
	Slimey.preloadImage(name + 'h.png');
	Slimey.preloadImage(name + 'x.png');
	Slimey.preloadImage(name + 'd.png');
}

Slimey.preloadImages = function() {
	if (!Image) {
		return;
	}
	Slimey.preloadToolbarImage('bold');
	Slimey.preloadToolbarImage('bringToFront');
	Slimey.preloadToolbarImage('color');
	Slimey.preloadToolbarImage('delete');
	Slimey.preloadToolbarImage('empty');
	Slimey.preloadToolbarImage('insertImage');
	Slimey.preloadToolbarImage('insertOList');
	Slimey.preloadToolbarImage('insertUList');
	Slimey.preloadToolbarImage('insertText');
	Slimey.preloadToolbarImage('italic');
	Slimey.preloadToolbarImage('preview');
	Slimey.preloadToolbarImage('redo');
	Slimey.preloadToolbarImage('save');
	Slimey.preloadToolbarImage('sendToBack');
	Slimey.preloadToolbarImage('underline');
	Slimey.preloadToolbarImage('undo');
	Slimey.preloadToolbarImage('viewSource');
	
	Slimey.preloadImage('newslide.png');
	Slimey.preloadImage('delslide.png');
	Slimey.preloadImage('sep.png');
}

