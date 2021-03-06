App.modules.addFileForm = {
  
  /**
  * Change state on the upload file click
  *
  * @param void
  * @return null
  */
  updateFileClick: function() {
    if($('fileFormUpdateFile').checked) {
      $('updateFileDescription').style.display = 'none';
      $('updateFileForm').style.display = 'block';
    } else {
      $('updateFileDescription').style.display = 'block';
      $('updateFileForm').style.display = 'none';
    } // if
  }, 
  
  /**
  * Change state on file change checkbox click
  *
  * @param void
  * @return null
  */
  versionFileChangeClick: function() {
    if($('fileFormVersionChange').checked) {
      var display_value = 'block';
    } else {
      var display_value = 'none';
    } // if
    $('fileFormRevisionCommentBlock').style.display = display_value;
  }
};

function submitMe(form) {
	if (addFileVerifyName())
	og.submit(form, function(panel){
		panel.reset();
	});
	else 
		return false;
}
  
addFileVerifyName = function(){
	var fileIsNew = Ext.get("hfFileIsNew").getValue();
	if (fileIsNew)
		if (Ext.get("addFileFilenameDNX").isDisplayed())
			return Ext.get("fileFormFilename").getValue() == Ext.get("fileFormFilenameH").getValue();
		else
			return Ext.get("fileFormNewFilename").getValue() == Ext.get("fileFormNewFilenameH").getValue();
	else
		return true; // Edit, name verification not necessary
}

updateFileName = function() {
	var name = document.getElementById('fileFormFile').value;
	var start = Math.max(0, Math.max(name.lastIndexOf('/'), name.lastIndexOf('\\') + 1));
	name = name.substring(start);
	Ext.get('fileFormFilename').dom.value = name;
	Ext.get('fileFormFilenameH').dom.value = name;
}

checkFileName = function(name) {
    Ext.get("addFileFilenameExists").setDisplayed(false);
    Ext.get("addFileFilenameCheck").setDisplayed(true);
	var eid = 0;
    
	var fileIsNew = Ext.get("hfFileIsNew").getValue();
  	var ws = Ext.get("file[project_id]").getValue();
    if (!name){
    	if(fileIsNew){
    		if (Ext.get('fileFormFilename').dom.value != '')
    			name = Ext.get('fileFormFilename').dom.value;
    		else {
    			//get the name from the file to upload
		    	var fullPath = Ext.get("fileFormFile").getValue();
		    	var lastSlash = Math.max(fullPath.lastIndexOf("/"),fullPath.lastIndexOf("\\"));
		  		name = fullPath.substring(lastSlash+1,fullPath.length);
	  		}
    	} else {
    		name = Ext.get('hfEditFileName').getValue();
    	}
  	}
  	
  	if (fileIsNew){
	  	Ext.get("addFileFilenameDNX").setDisplayed(false);
  	} else {
    	Ext.get("fileSubmitButton").dom.disabled = true;
 		eid = Ext.get('hfFileId').getValue();
  	}
 	
    og.openLink(og.getUrl('files','check_filename', {filename: name, wsid: ws, id: eid}), {caller:this});
}

checkFileNameReturn = function(fileInfo){
	Ext.get("addFileFilenameCheck").setDisplayed(false);
	Ext.get("hfExistingFileId").dom.value = fileInfo.id;
	var fileIsNew = Ext.get("hfFileIsNew").dom.value;
	
	if (fileInfo.id == 0){
		showFileDoesNotExist(fileInfo, fileIsNew);
	} else {
		showFileExists(fileInfo, fileIsNew);
	}
}

showFileDoesNotExist = function(fileInfo, fileIsNew){
	if (fileIsNew){
		Ext.get("addFileFilenameDNX").setDisplayed('inline');
		Ext.get("hfAddFileAddType").dom.value = 'regular';
		Ext.get("fileFormFilename").dom.value = fileInfo.name;
		Ext.get("fileFormFilenameH").dom.value = fileInfo.name;
	} else {
		Ext.get("fileSubmitButton").dom.disabled = false;
	}
}  
  
showFileExists = function(fileInfo, fileIsNew){
 	Ext.get("addFileFilenameExists").setDisplayed(true);
 	
	if (fileIsNew){ //------------------------------------------------ ADD
	 	Ext.get("hfAddFileAddType").dom.value = 'exists';
	 	Ext.get("fileCheckedOut").setDisplayed('none');
	 	Ext.get("fileCheckedOutNoPermission").setDisplayed('none');
	 	Ext.get("fileCheckedOutPermission").setDisplayed('none');
	 	Ext.get("fileNotCheckedOut").setDisplayed('none');
 		Ext.get("fileFormNewFilename").dom.value = fileInfo.suggestedName;
 		Ext.get("fileFormNewFilenameH").dom.value = fileInfo.suggestedName;
 		Ext.get("addFileButton").dom.disabled = false;
	 	
 		Ext.get("radioAddFileNewName").dom.checked = true;
 		Ext.get("addFileExistingFileInfo").update(lang('existing filename info', fileInfo.name, fileInfo.created_by_name, fileInfo.created_on));
 		
 		//Print the second option (checkin or add revision)
 		if(!fileInfo.is_checked_out){
	 		Ext.get("fileNotCheckedOut").setDisplayed(fileInfo.can_edit ? 'inline':'none');
	 		Ext.get("radioAddFileNewName").setDisplayed(fileInfo.can_edit ? 'inline':'none');
	 	} else {
	 		Ext.get("hfAddFileAddType").dom.value = 'checkedout';
	 		var chout = Ext.get("fileCheckedOut");
	 		chout.update('');
	 		chout.insertHtml('afterBegin',lang('add file checked out by', fileInfo.name, fileInfo.checked_out_by_name));
	 		chout.setDisplayed('inline');
	 		Ext.get(fileInfo.can_check_in ? "fileCheckedOutPermission" : "fileCheckedOutNoPermission").setDisplayed('inline');
	 		Ext.get("radioAddFileNewName").setDisplayed(fileInfo.can_check_in ? 'inline':'none');
	 	}
	} else { //------------------------------------------------------- EDIT
		Ext.get("fileSubmitButton").dom.disabled = true;
	}
}