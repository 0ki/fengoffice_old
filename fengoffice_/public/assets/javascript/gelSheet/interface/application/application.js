/*  Gelsheet Project, version 0.0.1 (Pre-alpha)
 *  Copyright (c) 2008 - Ignacio Vazquez, Fernando Rodriguez, Juan Pedro del Campo
 *
 *  Ignacio "Pepe" Vazquez <elpepe22@users.sourceforge.net>
 *  Fernando "Palillo" Rodriguez <fernandor@users.sourceforge.net>
 *  Juan Pedro "Perico" del Campo <pericodc@users.sourceforge.net>
 *
 *  Gelsheet is free distributable under the terms of an GPL license.
 *  For details see: http://www.gnu.org/copyleft/gpl.html
 *
 */
function Application(container){
    var self = window;
    
    self.constructor = function(container){
    	var configs = loadConfigs();
    	self.configs = configs;
    	this.container = container;
    	this.JsonManager = new JsonHandler();
    	
		this.Fonts = loadFonts(); //Function getted from server in fonts.js.php
    	this.activeBook = new Book(configs.book.defaultName);
    	this.sheets = new Array();
		var sheet = new Sheet(configs.sheet);

		this.namesStore = new Ext.data.SimpleStore({ 
	    		fields: ['name', 'range']
	    });
	  
		this.sheets.push(sheet);
		this.activeSheet = sheet;
//		
		
		//TODO: fix when multi books supported this.books = new Array();
		/*this.activeBook = new Book();
		*/
		//--------------Load Handlers------------------//
		//Style Handler
		this.Styler = new StyleHandler(configs.style);
		this.CommManager = new CommHandler(configs.communication);
		
		createToolbars();
		
		var dataSection = new Ext.Viewport({
		    layout: 'border',
		    renderTo:'body',
		    items: [{
		        region: 'north',
		        el:'north',
		        autoHeight: true,
		        border: false,
		        margins: '0 0 5 0'
		    }, {
		        region: 'west',
		        el:'west',
		        hidden:true,
		        collapsible: true,
		        title: 'Navigation'
		        
		    }, {
		        region: 'center',
		        el:'center',
		        xtype: 'tabpanel',
		        items: {
		            title: 'sheet1'
//		            html: 'The first tab\'s content. Others may be added dynamically'
		        }
		    }, {
		        region: 'south',
		        el:'south',
		        hidden:true,
		        title: 'Information',
		        collapsible: true,
		        html: 'Information goes here',
		        split: true,
		        height: 100,
		        minHeight: 100
		    }]
		});

		
		var center = document.getElementById("center");
		this.grid = new Grid({width:center.offsetWidth,height:center.offsetHeight});
    	center.appendChild(this.grid);
    	this.grid.inicialize();

    	//		Model Definition
		this.model = new GridModel(this.grid);
		this.model.setDataModel(this.activeSheet);
		
		this.model.on('Error',function(caller,e){
//			alert(e.toSource());
			Ext.Msg.alert('Error', e.description);
		});
		
		this.model.on('NameChanged',function(){
			var data = self.model.getNames();
			self.namesStore.loadData(data);
		});
		
//		this.model.on('ActiveCellChanged',function(obj,address){
		this.model.on('SelectionChanged',function(obj,address){
			nameSelector.setValue(address);
		});
		
		this.model.on('ActiveCellChanged',function(obj,value){
			FormulaBar.setValue(value);
		});
		
		this.model.refresh();
		
		//Create Key Manager
		this.gridShortCuts = new KeyHandler();
		
		this.gridShortCuts.addAction(this.model.goToHome,false, CH_CTRL + CH_HOME);
		//this.keyManager.addAction(navBar.goToEnd,false, CH_END);
		this.gridShortCuts.addAction(this.model.moveRight,false, CH_TAB);
		this.gridShortCuts.addAction(this.model.moveDown,false, CH_ENTER);
		this.gridShortCuts.addAction(this.model.moveLeft,false, CH_LEFT_ARROW);
		this.gridShortCuts.addAction(this.model.moveRight,false, CH_RIGHT_ARROW);
		this.gridShortCuts.addAction(this.model.moveUp,false, CH_UP_ARROW);
		this.gridShortCuts.addAction(this.model.moveDown,false, CH_DOWN_ARROW);
		this.gridShortCuts.addAction(this.model.undo,false, CH_CTRL + CH_Z);
		this.gridShortCuts.addAction(this.model.redo,false, CH_CTRL + CH_SHIFT + CH_Z);
		this.gridShortCuts.addAction(model.deleteSelection,false, CH_DELETE);
		this.gridShortCuts.addAction(model.setValueToSelection,false, CH_CTRL + CH_ENTER);
		this.grid.onkeydown = gridShortCuts.keyHandler;
		
		this.documentShortCuts = new KeyHandler();
		
		this.documentShortCuts.addAction(this.model.pageUp,false, CH_PAGE_UP);
		this.documentShortCuts.addAction(this.model.pageDown,false, CH_PAGE_DOWN);
		
		this.documentShortCuts.addAction(self.saveBook,false, CH_CTRL + CH_S);
		this.documentShortCuts.addAction(saveBookConfirm,false, CH_CTRL + CH_SHIFT + CH_S);
		

		this.documentShortCuts.addAction(cmdSetBoldStyle,false, CH_CTRL + CH_B);
		this.documentShortCuts.addAction(cmdSetItalicStyle,false, CH_CTRL + CH_I);
		this.documentShortCuts.addAction(cmdSetUnderlineStyle,false, CH_CTRL + CH_U);
		
		this.window.onkeydown = documentShortCuts.keyHandler;
		
		//Disable Text Selection
		this.grid.onselectstart = function() {return false;}; // ie
		this.grid.onmousedown = function() {return false;}; // mozilla

		//Capture Resize Event
		window.onresize = function (){
			this.grid.resize(center.offsetWidth,center.offsetHeight);
		}
    }
    
    self.nameSelectorChanged = function(name){
    	if(self.model.existsName(name))
    		self.model.goToName(name);
    	else
    		if(true){ //TODO:Change to check if is a valid name
    			self.model.addName(name);
    		}
    }

   
//    self.bookLoaded = function(data){
//    	var sheet =  JsonManager.importSheet(self.con, data);
//    	this.model.refresh();
//    }
    
    addApplicationAPI(self);
    self.constructor(container);
    window.application = self;
    
    return self;
}
    

/** This is high-level function.
 * It must react to delta being more/less than zero.
 * http://adomas.org/javascript-mouse-wheel/
 */
function handle(delta) {
        if (delta < 0)
        	grid.scrollDown(2);
        else
        	grid.scrollDown(-2);
}

/** Event handler for mouse wheel event.
 */
function wheel(event){
        var delta = 0;
        if (!event) /* For IE. */
                event = window.event;
        if (event.wheelDelta) { /* IE/Opera. */
                delta = event.wheelDelta/120;
                /** In Opera 9, delta differs in sign as compared to IE.
                 */
                if (window.opera)
                        delta = -delta;
        } else if (event.detail) { /** Mozilla case. */
                /** In Mozilla, sign of delta is different than in IE.
                 * Also, delta is multiple of 3.
                 */
                delta = -event.detail/3;
        }
        /** If delta is nonzero, handle it.
         * Basically, delta is now positive if wheel was scrolled up,
         * and negative, if wheel was scrolled down.
         */
        if (delta)
                handle(delta);
        /** Prevent default actions caused by mouse wheel.
         * That might be ugly, but we handle scrolls somehow
         * anyway, so don't bother here..
         */
        if (event.preventDefault)
                event.preventDefault();
	event.returnValue = false;
}

/** Initialization code. 
 * If you use your own event management code, change it as required.
 */
if (window.addEventListener)
        /** DOMMouseScroll is for mozilla. */
        window.addEventListener('DOMMouseScroll', wheel, false);
/** IE/Opera. */
window.onmousewheel = document.onmousewheel = wheel;


