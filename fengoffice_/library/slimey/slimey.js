/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Inclusion to a webpage.
 */


//var slimeyRootDir = 'library/slimey/';
//var slimeyImagesDir = slimeyRootDir + 'images/';
var slimeyPreloadedImages = new Array();

function includeSlimeyScripts() {
	document.write('<script language="javascript" src="' + slimeyRootDir + 'functions.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'stack.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'editor.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'navigation.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'actions.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'tools.js"></script>');
	document.write('<script language="javascript" src="' + slimeyRootDir + 'toolbar.js"></script>');
}

function preloadSlimeyImage(filename) {
	var ims = slimeyPreloadedImages;
	var i = ims.length;
	ims[i] = new Image(); ims[i].src = slimeyImagesDir + filename;
}

function preloadSlimeyToolbarImage(name) {
	preloadSlimeyImage(name + '.png');
	preloadSlimeyImage(name + 'h.png');
	preloadSlimeyImage(name + 'x.png');
	preloadSlimeyImage(name + 'd.png');
}

function preloadSlimeyImages() {
	if (!Image) {
		return;
	}
	preloadSlimeyToolbarImage('bold');
	preloadSlimeyToolbarImage('bringToFront');
	preloadSlimeyToolbarImage('color');
	preloadSlimeyToolbarImage('delete');
	preloadSlimeyToolbarImage('empty');
	preloadSlimeyToolbarImage('insertImage');
	preloadSlimeyToolbarImage('insertOList');
	preloadSlimeyToolbarImage('insertUList');
	preloadSlimeyToolbarImage('insertText');
	preloadSlimeyToolbarImage('italic');
	preloadSlimeyToolbarImage('preview');
	preloadSlimeyToolbarImage('redo');
	preloadSlimeyToolbarImage('save');
	preloadSlimeyToolbarImage('sendToBack');
	preloadSlimeyToolbarImage('underline');
	preloadSlimeyToolbarImage('undo');
	preloadSlimeyToolbarImage('viewSource');
	
	preloadSlimeyImage('newslide.png');
	preloadSlimeyImage('delslide.png');
	preloadSlimeyImage('sep.png');
}

//includeSlimeyScripts();
