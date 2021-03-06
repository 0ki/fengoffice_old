function addApplicationAPI(self){
	
    self.editActiveCell = function(value){
    	self.model.editActiveCell(value);
    };
    
    self.bookLoaded = function(responseData){
    	var book = self.JsonManager.importBook(self.configs.sheet,responseData);
    	self.activeBook = book;
    	self.activeSheet = book.getSheet();
    	self.setBookName(book.name); //doing this will refresh application title
    	self.model.setDataModel(self.activeSheet);
    	self.model.refresh();
    };
    
    self.loadBook = function(bookId){
    	self.CommManager.loadBook(bookId,self.bookLoaded);
    };
    
    self.setBookName = function(bookName){
		self.activeBook.setName(bookName);
		document.title = self.configs.application.titlePrefix +" - " + bookName;
	};

    /**
     * Save As..
     */
	self.saveBook = function(bookName) {
		var bookId = "null";
		
		//var bookId = self.activeBook.getId(); 
		if(bookName == undefined) { //if not save as...
			if(window.ogID) {
				bookName = self.activeBook.getName();
			} else {
				saveBookConfirm();
				return;
			}
		}
		
		if(bookName == undefined) bookName = self.activeBook.getName();
		self.setBookName(bookName);
		
		var json = JsonManager.exportBook(self.activeBook,self.activeSheet); //on the future will not be needed to pass activeSheet
	    self.CommManager.sendBook(json, 'json');
	};
	
	self.exportBook = function(format){
		var json = JsonManager.exportBook(self.activeBook,self.activeSheet); //on the future will not be needed to pass activeSheet
	    self.CommManager.exportBook(json, format);
	};
	
	self.newBook = function(){
		self.activeBook = new Book(self.configs.book.defaultName);
		self.activeSheet = new Sheet(self.configs);
		self.setBookName(self.configs.book.defaultName);
		self.model.setDataModel(self.activeSheet);
		self.model.refresh();
		window.ogID = undefined; //if integrated, reset ogId
	};
	
	self.openFiles  = function(data){
		if(!self.openFileDialog)
			self.openFileDialog = new OpenFileDialog(50,50,300,300);
		for(var i=0 ;i < data.files.length;i++){
			self.openFileDialog.addFile(data.files[i]);
		}
		self.container.appendChild(self.openFileDialog);
	}

}