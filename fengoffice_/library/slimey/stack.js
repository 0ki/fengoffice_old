/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  A simple stack
 */

var SlimeyStack = function() {
	this.stack = new Array();
	this.size = 0;
}

SlimeyStack.prototype.push = function(obj) {
	this.stack[this.size++] = obj;
}

SlimeyStack.prototype.pop = function() {
	if (this.size == 0) {
		return null;
	}
	return this.stack[--this.size];
}

SlimeyStack.prototype.peek = function() {
	if (this.size == 0) {
		return null;
	}
	return this.stack[this.size - 1];
}

SlimeyStack.prototype.getSize = function() {
	return this.size;
}

SlimeyStack.prototype.isEmpty = function() {
	return this.size == 0;
}

SlimeyStack.prototype.clear = function() {
	this.size = 0;
}