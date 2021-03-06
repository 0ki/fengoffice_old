/*
 *  Slimey - SLIdeshow Microformat Editor, part of the OpenGoo weboffice suite - http://www.opengoo.org
 *  Copyright (C) 2007 Ignacio de Soto
 *
 *  Slides navigation
 */

// load data
var slides = new Array();
var doms = new Array();

var currentSlide;

function clickSlide() {
	// get clicked slide number
    var num = parseInt(this.id.substring(5));

	var action = new SlimeyChangeSlideAction(num);
	SlimeyEditor.getInstance().performAction(action);
}

function getSlide(num) {
    if (num == currentSlide) {
        return;
    }

    // save current slide and view clicked slide
    if (currentSlide != 0) {
        var html = SlimeyEditor.getInstance().getHTML();
        $('slide' + currentSlide).className = 'slidePreview';
		$('slide' + currentSlide).parentNode.className = 'slideBorder';
        slides[currentSlide] = html;

		doms[currentSlide] = document.createElement('div');
		SlimeyEditor.getInstance().getDOM(doms[currentSlide]);
		
        $('slide' + currentSlide).innerHTML = html;
    }
   	//SlimeyEditor.getInstance().setHTML(slides[num]);
	if (doms[num]) {
		SlimeyEditor.getInstance().setDOM(doms[num]);
	} else {
		SlimeyEditor.getInstance().setHTML(slides[num]);
	}

    currentSlide = num;
    $('slide' + currentSlide).className = 'slidePreviewSel';
	$('slide' + currentSlide).parentNode.className = 'slideBorderSel';

    return false;
}

function insertNewSlide(num, html, dom) {
	if (!html) {
		html = '<div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 40%; top: 0%; border: 2px solid transparent;">Edit Me!</div>';
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
    for (i=slides.length - 1; i >= num; i--) {
        slides[i + 1] = slides[i];
		doms[i + 1] = doms[i];
    }
    slides[num] = html;
	doms[num] = dom;

    // add new slide and spacer to DOM
    var parent = thisSpacer.parentNode;
    var newSpacer = createSpacerDiv(num);
    parent.insertBefore(newSpacer, thisSpacer);
    var newSlide = createSlideDiv(num);
    parent.insertBefore(newSlide, thisSpacer);

    // select newly added slide
    if (currentSlide >= num) {
        currentSlide++;
    }
    getSlide(num);
}

function deleteSlide(num) {
    if (num < 1 || num > slides.length) {
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
    for (i=num; i < slides.length - 1; i++) {
        slides[i] = slides[i + 1];
		doms[i] = doms[i + 1];
    }
    slides.length--;
	doms.length--;

    // select another slide
    currentSlide = 0;
    if (num < slides.length && num > 0) {
        slide = $('slide' + num);
        getSlide(num);
    } else if (slides.length > 1) {
        slide = $('slide' + (slides.length - 1));
        getSlide(slides.length - 1);
    } else {
		SlimeyEditor.getInstance().setHTML('<h1 align="center" style="color: #999999"><i>Click "Add New" to add a slide.</i><h1>');
	}
}

function getSLIMContent() {
    // save current edited text
    var html = SlimeyEditor.getInstance().getHTML();
    slides[currentSlide] = html;

    // generate SLIM content
    var slim = '';
    for (i=1; i < slides.length; i++) {
        slim += '<div class="slide">' + slides[i] + '</div>';
    }
	
	return slim;
}

function createSlideDiv(num) {
    var slide = document.createElement('div');
    slide.className = 'slidePreview';
    slide.id = 'slide' + num;
    slide.title = "Slide " + num;
	slide.style.position = 'relative';
    slide.innerHTML = slides[num];
    slide.onclick = clickSlide;

	slide.onmouseover = function() {
		this.className = 'slidePreviewH';
		this.parentNode.className = 'slideBorderH';
	};
    slide.onmouseout = function() {
		var num = parseInt(this.id.substring(5));
		var sel = (num == currentSlide?'Sel':'');
		this.className = 'slidePreview' + sel;
		this.parentNode.className = 'slideBorder' + sel;
	};

	var border = document.createElement('div');
	border.className = 'slideBorder';
	border.appendChild(slide);
    return border;
}

function createSpacerDiv(num) {
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

function initNavigation() {
    // initialize slides content
    var file = unescapeSLIM($("slimContent").value);
    var divslides = file.split('<div class="slide">');
    slides[0] = '';
    for (var i=1; i < divslides.length; i++) {
        slides[i] = divslides[i].substr(0, divslides[i].lastIndexOf("</div>"));
    }

    // initialize html
    var container = $('previewContainer');
    var spacer = createSpacerDiv(1);
    container.appendChild(spacer);
    for (i=1; i < slides.length; i++) {
        var slide = createSlideDiv(i);
        container.appendChild(slide);
        var spacer = createSpacerDiv(i + 1);
        container.appendChild(spacer);
    }

	currentSlide = 0;
    if (slides.length > 1) {
        // select first slide
        getSlide(1);
    }
}
