// helper functions
function escapeS5(rawS5) {
	var encodedS5 = rawS5
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;');
	return encodedS5;
}

function unescapeS5(encodedS5) {
	var rawS5 = encodedS5
			.replace(/\&#39;/g, '\'')
			.replace(/\&quot;/g, '"')
			.replace(/\&gt;/g, '>')
			.replace(/\&lt;/g, '<')
			.replace(/\&amp;/g, '&');
	return rawS5
}

// load data
var slides = new Array();

var fckSlideMenu;

var currentSlide;
var tempCurrent = 0;

function getSlide() {
    if (tempCurrent != 0) {
        // currently the slide is being changed
        return;
    }
    // get clicked slide number and current slide number
    var num = parseInt(this.id.substring(5));
    if (num == currentSlide) {
        return;
    }

    // save current slide and view clicked slide
    var fck = FCKeditorAPI.GetInstance('FCKeditor1');
    if (currentSlide != 0) {
        var html = fck.GetHTML();
        document.getElementById('slide' + currentSlide).className = 'slidePreview';
        slides[currentSlide] = html;
        document.getElementById('slide' + currentSlide).innerHTML = html;
    }
    fck.SetHTML(slides[num]);
    tempCurrent = num;
    
	// if not in WYSIWYG mode then update current slide status immediately,
	// otherwise it will be updated by the OnAfterSetHTML event
    if (fck.EditMode != FCK_EDITMODE_WYSIWYG) {
        endGetSlide();
    }
    
    return false;
}

function endGetSlide() {
    if (tempCurrent != 0) {
        // only set the current slide after the HTML has been set in the editor
        currentSlide = tempCurrent;
        document.getElementById('slide' + currentSlide).className = 'slidePreviewSel';
        tempCurrent = 0;
    }
}

function insertNewSlide(num) {
    var thisSpacer = document.getElementById('spacer' + num);

    // shift all slides
    var slide = document.getElementById('slide' + num);
    for (i=num + 1; slide; i++) {
        var slideAux = slide;
        slide = document.getElementById('slide' + i);
        slideAux.id = 'slide' + i;
        slideAux.title = 'Slide ' + i;
    }
    // shift all spacers including this one
    var spacer = document.getElementById('spacer' + num);
    for (i=num + 1; spacer; i++) {
        var spacerAux = spacer;
        spacer = document.getElementById('spacer' + i);
        spacerAux.id = 'spacer' + i;
    }
    // shift slide data
    for (i=slides.length - 1; i >= num; i--) {
        slides[i + 1] = slides[i];
    }
    slides[num] = '<h1 align="center">Edit Me!</h1>';
    
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
    newSlide.onclick();
}

function deleteSlide(num) {
    if (num < 1 || num > slides.length) {
        alert("No slide to delete!");
        return;
    }
    var thisSpacer = document.getElementById('spacer' + num);

    // delete slide and spacer from DOM
    var slide = document.getElementById('slide' + num);
    slide.parentNode.removeChild(slide);
    var spacer = document.getElementById('spacer' + num);
    spacer.parentNode.removeChild(spacer);

    // shift all slides
    var slide = document.getElementById('slide' + (num + 1));
    for (i=num + 1; slide; i++) {
        slide.id = 'slide' + (i - 1);
        slide.title = 'Slide' + (i - 1);
        slide = document.getElementById('slide' + (i + 1));
    }
    // shift all spacers
    var spacer = document.getElementById('spacer' + (num + 1));
    for (i=num + 1; spacer; i++) {
        spacer.id = 'spacer' + (i - 1);
        spacer = document.getElementById('spacer' + (i + 1));
    }
    // shift slide data
    for (i=num; i < slides.length - 1; i++) {
        slides[i] = slides[i + 1];
    }
    slides.length--;
    
    // select another slide
    var fck = FCKeditorAPI.GetInstance('FCKeditor1');
    fck.SetHTML('<h1 align="center" style="color: #999999"><i>Click "Add New" to add a slide.</i><h1>');
    currentSlide = 0;
    if (num < slides.length && num > 0) {
        slide = document.getElementById('slide' + num);
        slide.onclick();
    } else if (slides.length > 1) {
        slide = document.getElementById('slide' + (slides.length - 1));
        slide.onclick();
    }
}

function getS5Content() {
    // save current edited text
    var fck = FCKeditorAPI.GetInstance('FCKeditor1');
    var html = fck.GetHTML();
    slides[currentSlide] = html;

    // generate s5 content
    var s5 = '';
    for (i=1; i < slides.length; i++) {
        s5 += '<div class="slide">' + slides[i] + '</div>';
    }
    document.getElementById("s5content").value = escapeS5(s5);
}

function createSlideDiv(num) {
    var slide = document.createElement('div');
    slide.className = 'slidePreview';
    slide.id = 'slide' + num;
    slide.title = "Slide " + num;
    slide.innerHTML = slides[num];
    slide.onclick = getSlide;
    /* TODO
    slide.oncontextmenu = frames['0'].FCKContextMenu_Document_OnContextMenu;
    slide._FCKContextMenu = fckSlideMenu;
    */
    slide.onmouseover = function() { this.className = 'slidePreviewH'; };
    slide.onmouseout = function() { var num = parseInt(this.id.substring(5));this.className = (num == currentSlide?'slidePreviewSel':'slidePreview'); };
    return slide;
}

function createSpacerDiv(num) {
    var spacer = document.createElement('div');
    spacer.className = 'previewSpacer';
    spacer.id = 'spacer' + num;
    spacer.title = "Click to insert new slide";
    spacer.onclick = function() { insertNewSlide(parseInt(this.id.substring(6))); };
    spacer.onmouseover = function() { this.className = 'previewSpacerH'; };
    spacer.onmouseout = function() { this.className = 'previewSpacer'; };
    return spacer;
}

function FCKeditor_OnComplete(editorInstance) {
    if (slides.length >= 2) {
        FCKeditorAPI.GetInstance('FCKeditor1').SetHTML(slides[1]);
    }
    editorInstance.Events.AttachEvent('OnAfterSetHTML', endGetSlide) ;
}

window.onload = function() {
    // initialize context menu
    /*
    TODO: Slide Preview context menu (Insert, Copy, Paste, Delete, Cut)
    fckSlideMenu = new frames['0'].FCKContextMenu(window, "es");
    fckSlideMenu.AddItem('Copy', frames['0'].FCKLang.Copy, '');
    fckSlideMenu.AddItem('Save', frames['0'].FCKLang.Save, '');*/

    // initialize slides content
    var file = unescapeS5(document.getElementById("s5content").value);
    var divslides = file.split('<div class="slide">');
    slides[0] = '';
    for (var i=1; i < divslides.length; i++) {
        slides[i] = divslides[i].substr(0, divslides[i].lastIndexOf("</div>"));
    }

    // initialize html
    var container = document.getElementById('previewContainer');
    var spacer = createSpacerDiv(1);
    container.appendChild(spacer);
    for (i=1; i < slides.length; i++) {
        var slide = createSlideDiv(i);
        container.appendChild(slide);
        var spacer = createSpacerDiv(i + 1);
        container.appendChild(spacer);
    }
    if (slides.length < 2) {
        currentSlide = 0;
    } else {
        document.getElementById('slide1').className = "slidePreviewSel";
        tempCurrent = 1;
    }
}