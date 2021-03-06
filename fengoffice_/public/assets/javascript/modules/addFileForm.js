App.modules.addFileForm = {
  
  /**
  * Change state on the upload file click
  *
  * @param void
  * @return null
  */
  updateFileClick: function(genid) {
    if($(genid+'fileFormUpdateFile').checked) {
      $(genid+'updateFileDescription').style.display = 'none';
      $(genid+'updateFileForm').style.display = 'block';
    } else {
      $(genid+'updateFileDescription').style.display = 'block';
      $(genid+'updateFileForm').style.display = 'none';
    } // if
  }, 
  
  /**
  * Change state on file change checkbox click
  *
  * @param void
  * @return null
  */
  versionFileChangeClick: function(genid) {
    if($(genid+'fileFormVersionChange').checked) {
      var display_value = 'block';
    } else {
      var display_value = 'none';
    } // if
    $(genid+'fileFormRevisionCommentBlock').style.display = display_value;
  }
};

function submitMe(genid) {
	form = document.getElementById(genid + 'addfile');
	og.submit(form, {
		callback: og.getUrl('files', 'check_upload', {upload_id: genid})
	});
}

og.onBlurFileName = function() {
	var submitIntent = false;
}

og.updateFileName = function(genid) {
	var name = document.getElementById(genid + 'fileFormFile').value;
	var start = Math.max(0, Math.max(name.lastIndexOf('/'), name.lastIndexOf('\\') + 1));
	name = name.substring(start);
	var fff = document.getElementById(genid + 'fileFormFilename');
	fff.value = name;
}

og.checkFileName = function(genid, name) {
	allowSubmit = false;
	var fff = document.getElementById(genid + 'fileFormFilename');
	name = fff.value;
	//Disable Add file buttons and show corresponding divs
	Ext.get(genid + 'add_file_submit1').dom.disabled = true;
	Ext.get(genid + 'add_file_submit2').dom.disabled = true;
    Ext.get(genid + "addFileFilenameCheck").setDisplayed(true);
    Ext.get(genid + "addFileFilenameExists").setDisplayed(false);
    
	var eid = 0;
	var fileIsNew = Ext.get(genid + "hfFileIsNew").getValue();
  	if (!fileIsNew){
 		eid = Ext.get(genid + 'hfFileId').getValue();
  	}
  	var ws = Ext.get(genid + "ws_ids").getValue();
 	
    og.openLink(og.getUrl('files','check_filename', {filename: escape(name), wsid: ws, id: eid}), {
    	caller:this,
    	callback: function(success, data) {
    		if (success) {
    			
    			Ext.get(genid + "addFileFilenameCheck").setDisplayed(false);
				Ext.get(genid + "addFileFilename").setDisplayed('inline');
    			Ext.get(genid + 'add_file_submit1').dom.disabled = false;
				Ext.get(genid + 'add_file_submit2').dom.disabled = false;
	
				if (data.files && Ext.get(genid + "hfFileIsNew").dom.value)
					og.showFileExists(genid, data);
    		}
    	}
    });
}
  
og.showFileExists = function(genid, fileInfo){
 	Ext.get(genid + "addFileFilenameExists").setDisplayed(true);
 	var table = Ext.getDom(genid + 'upload-table');
 	table.innerHTML = '';
 	
 	for (var i = 0; i < fileInfo.files.length; i++)
 		og.addFileOption(table, fileInfo.files[i]);
}

og.addFileOption = function(table, file){
	var row = table.insertRow(table.rows.length);
	var cell = row.insertCell(0);
	cell.style.paddingRight='4px';

	if (file.can_edit && (!file.is_checked_out || file.can_check_in)){
		var el = document.createElement('input');
		el.type="radio";
		el.className = "checkbox";
		el.name='file[upload_option]';
		el.value=file.id;
		el.checked = false;
		el.enabled = file.can_edit && (!file.is_checked_out || (file.is_checked_out && file.can_check_in));
		cell.appendChild(el);
	}
	
	var cell = row.insertCell(1);
	cell.style.height = '20px';
	var div = document.createElement('div');
	div.className = 'ico-link ico-' + file.type;
	
	var addMessage = lang('add as new revision to') + ":&nbsp;";
	if(file.is_checked_out){
		if (file.can_check_in)
			addMessage = lang('check in') + ":&nbsp;";
		else
			addMessage = lang('cannot check in') + "&nbsp;";
	}
		
	var classes = "db-ico ico-unknown ico-" + file.type;
	if (file.type) {
		var path = file.type.replace(/\//ig, "-").split("-");
		var acc = "";
		for (var i=0; i < path.length; i++) {
			acc += path[i];
			classes += " ico-" + acc;
			acc += "-";
		}
	}
	var fileLink = "<a style='padding-left:18px;line-height:16px' class=\""+ classes + "\" href=\"" + og.getUrl('files','download_file',{id : file.id}) + "\" title=\"" + lang('download') + "\">" + file.name + "</a>";
	var workspaces = '';
	
	if (file.workspace_ids != ''){
		workspaces = "&nbsp;(";
		var ids = String(file.workspace_ids).split(',');
		var names = file.workspace_names.split(',');
		var colors = String(file.workspace_colors).split(',');
		for (var idi = 0; idi < ids.length; idi++){
			workspaces +=  "<a href=\"#\" class=\"og-wsname og-wsname-color-" + colors[idi].trim() + "\" onclick=\"Ext.getCmp('workspace-panel').select(" + ids[idi] + ")\">" + names[idi].trim() + "</a>";
			if (idi < ids.length - 1)
				workspaces+="&nbsp;";
		}
		workspaces += ')';
	}
	div.innerHTML = addMessage + fileLink + workspaces;
	cell.appendChild(div);
	
	var cell = row.insertCell(2);
	cell.style.paddingLeft = '10px';
	var div = document.createElement('div');
	var dateToShow = '';
	var newDate = new Date(file.created_on*1000).add("d", 1);
	var currDate = new Date();
	if (newDate.getFullYear() != currDate.getFullYear())
		dateToShow = newDate.format("j M Y");
	else
		dateToShow = newDate.format("j M");
	cell.innerHTML = lang("created by on", file.created_by_name, dateToShow);
	
	var cell = row.insertCell(3);
	cell.style.paddingLeft = '10px';
	if (file.is_checked_out){
		cell.innerHTML = lang('checked out by', file.checked_out_by_name); 
	}
}

