/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Slides navigation
 */

/**
 *  class SlimeyNavigation - implements functionality for navigating through slides
 *  	container: div where the navigation will reside
 */
var SlimeyNavigation = function(container) {
	this.container = container;
	this.slides = new Array();
	this.doms = new Array();

	// initialize slides content
    var file = unescapeSLIM($("slimContent").value);
    var divslides = file.split('<div class="slide">');
    this.slides[0] = '';
    for (var i=1; i < divslides.length; i++) {
        this.slides[i] = divslides[i].substr(0, divslides[i].lastIndexOf("</div>"));
    }

    // initialize html
    var spacer = this.createSpacerDiv(1);
    container.appendChild(spacer);
    for (i=1; i < this.slides.length; i++) {
        var slide = this.createSlideDiv(i);
        container.appendChild(slide);
        var spacer = this.createSpacerDiv(i + 1);
        container.appendChild(spacer);
    }

	this.currentSlide = 0;
    if (this.slides.length > 1) {
        // select first slide
        this.getSlide(1);
    }
}

/** singleton */
SlimeyNavigation.instance = null;

/**
 *  initialize the navigation's instance
 */
SlimeyNavigation.initInstance = function(containerID) {
	SlimeyNavigation.instance = new SlimeyNavigation($(containerID));
}

/**
 *  returns the single SlimeyNavigation instance
 */
SlimeyNavigation.getInstance = function() {
	if (SlimeyNavigation.instance == null) {
		SlimeyNavigation.instance = new SlimeyNavigation($('slimeyNavigation'), window);
	}
	return SlimeyNavigation.instance;
}

/**
 *  returns the navigation's container
 */
SlimeyNavigation.prototype.getContainer = function() {
	return this.container;
}

SlimeyNavigation.prototype.getSlide = function(num) {
    if (num == this.currentSlide) {
        return;
    }

    // save current slide and view clicked slide
    if (this.currentSlide != 0) {
        var html = SlimeyEditor.getInstance().getHTML();
        $('slide' + this.currentSlide).className = 'slidePreview';
		$('slide' + this.currentSlide).parentNode.className = 'slideBorder';
        this.slides[this.currentSlide] = html;

		this.doms[this.currentSlide] = document.createElement('div');
		SlimeyEditor.getInstance().getDOM(this.doms[this.currentSlide]);
		
        $('slide' + this.currentSlide).innerHTML = html;
    }
	if (this.doms[num]) {
		SlimeyEditor.getInstance().setDOM(this.doms[num]);
	} else {
		SlimeyEditor.getInstance().setHTML(this.slides[num]);
	}

    this.currentSlide = num;
    $('slide' + this.currentSlide).className = 'slidePreviewSel';
	$('slide' + this.currentSlide).parentNode.className = 'slideBorderSel';

    return false;
}

SlimeyNavigation.prototype.saveCurrentSlide = function() {
	var html = SlimeyEditor.getInstance().getHTML();
	this.slides[this.currentSlide] = html;
	var previewDiv = $('slide' + this.currentSlide);
	if (previewDiv) {
		previewDiv.innerHTML = html;
	}
}

SlimeyNavigation.prototype.insertNewSlide = function(num, html, dom) {
	if (!html) {
		html = '<div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 40%; top: 0%;">Edit Me!</div>';
	}

    var thisSpacer = $('spacer' + num);

    // shift all slides
    var slide = $('slide' + num);
    for (i=num + 1; slide; i++) {
        var slideAux = slide;
        slide = $('slide' + i);
        slideAux.id = 'slide' + i;
        slideAux.title = 'Slide ' + i;
    }

    // shift all spacers including this one
    var spacer = $('spacer' + num);
    for (i=num + 1; spacer; i++) {
        var spacerAux = spacer;
        spacer = $('spacer' + i);
        spacerAux.id = 'spacer' + i;
    }

    // shift slide data
    for (i=this.slides.length - 1; i >= num; i--) {
        this.slides[i + 1] = this.slides[i];
		this.doms[i + 1] = this.doms[i];
    }
    this.slides[num] = html;
	this.doms[num] = dom;

    // add new slide and spacer to DOM
    var parent = thisSpacer.parentNode;
    var newSpacer = this.createSpacerDiv(num);
    parent.insertBefore(newSpacer, thisSpacer);
    var newSlide = this.createSlideDiv(num);
    parent.insertBefore(newSlide, thisSpacer);

    // select newly added slide
    if (this.currentSlide >= num) {
        this.currentSlide++;
    }
    this.getSlide(num);
}

SlimeyNavigation.prototype.deleteSlide = function(num) {
    if (num < 1 || num > this.slides.length) {
        alert("No slide to delete!");
        return;
    }
    var thisSpacer = $('spacer' + num);

    // delete slide and spacer from DOM
    var slide = $('slide' + num);
    slide.parentNode.parentNode.removeChild(slide.parentNode);
    var spacer = $('spacer' + num);
    spacer.parentNode.removeChild(spacer);

    // shift all slides
    var slide = $('slide' + (num + 1));
    for (i=num + 1; slide; i++) {
        slide.id = 'slide' + (i - 1);
        slide.title = 'Slide' + (i - 1);
        slide = $('slide' + (i + 1));
    }
    // shift all spacers
    var spacer = $('spacer' + (num + 1));
    for (i=num + 1; spacer; i++) {
        spacer.id = 'spacer' + (i - 1);
        spacer = $('spacer' + (i + 1));
    }
    // shift slide data
    for (i=num; i < this.slides.length - 1; i++) {
        this.slides[i] = this.slides[i + 1];
		this.doms[i] = this.doms[i + 1];
    }
    this.slides.length--;
	this.doms.length--;

    // select another slide
    this.currentSlide = 0;
    if (num < this.slides.length && num > 0) {
        slide = $('slide' + num);
        this.getSlide(num);
    } else if (this.slides.length > 1) {
        slide = $('slide' + (this.slides.length - 1));
        this.getSlide(this.slides.length - 1);
    } else {
		SlimeyEditor.getInstance().setHTML('<h1 align="center" style="color: #999999"><i>Click "Add New" to add a slide.</i><h1>');
	}
}

SlimeyNavigation.prototype.getSLIMContent = function() {
    // save current edited text
    var html = SlimeyEditor.getInstance().getHTML();
    this.slides[this.currentSlide] = html;

    // generate SLIM content
    var slim = '';
    for (i=1; i < this.slides.length; i++) {
        slim += '<div class="slide">' + this.slides[i] + '</div>';
    }
	
	return slim;
}

SlimeyNavigation.prototype.createSlideDiv = function(num) {
    var slide = document.createElement('div');
    slide.className = 'slidePreview';
    slide.id = 'slide' + num;
    slide.title = "Slide " + num;
	slide.style.position = 'relative';
    slide.innerHTML = this.slides[num];
    slide.onclick = function() {
		var num = parseInt(this.id.substring(5));
		var action = new SlimeyChangeSlideAction(num);
		SlimeyEditor.getInstance().performAction(action);
	};
	slide.onmouseover = function() {
		this.className = 'slidePreviewH';
		this.parentNode.className = 'slideBorderH';
	};
    slide.onmouseout = function() {
		var num = parseInt(this.id.substring(5));
		var sel = (num == SlimeyNavigation.getInstance().currentSlide?'Sel':'');
		this.className = 'slidePreview' + sel;
		this.parentNode.className = 'slideBorder' + sel;
	};

	var border = document.createElement('div');
	border.className = 'slideBorder';
	border.appendChild(slide);
    return border;
}

SlimeyNavigation.prototype.createSpacerDiv = function(num) {
    var spacer = document.createElement('div');
    spacer.className = 'previewSpacer';
    spacer.id = 'spacer' + num;
    spacer.title = "Click to insert a new slide";
    spacer.onclick = function() {
		var action = new SlimeyInsertSlideAction(parseInt(this.id.substring(6)));
		SlimeyEditor.getInstance().performAction(action);
		this.className = 'previewSpacer';
	};
    spacer.onmouseover = function() { this.className = 'previewSpacerH'; };
    spacer.onmouseout = function() { this.className = 'previewSpacer'; };
    return spacer;
}

SlimeyNavigation.prototype.addNewSlide = function() {
	var action = new SlimeyInsertSlideAction(this.currentSlide + 1);
	SlimeyEditor.getInstance().performAction(action);
}

SlimeyNavigation.prototype.deleteCurrentSlide = function() {
	if (this.currentSlide > 0) {
		var action = new SlimeyDeleteSlideAction(this.currentSlide);
		SlimeyEditor.getInstance().performAction(action);
	}
}
