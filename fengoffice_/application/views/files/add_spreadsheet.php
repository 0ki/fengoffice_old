<?php
  set_page_title($file->isNew() ? lang('New spreadsheet') : lang('edit spreadsheet'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($file->isNew() ? lang('add spreadsheet') : lang('edit document'))
  ));
    if(ProjectFile::canAdd(logged_user(), active_project())) {
    if($current_folder instanceof ProjectFolder) {
      add_page_action(lang('add document'), $current_folder->getAddDocumentUrl());
      add_page_action(lang('add spreadsheet'), $current_folder->getAddSpreadsheetUrl());
      add_page_action(lang('add presentation'), $current_folder->getAddPresentationUrl());
      add_page_action(lang('upload file'), $current_folder->getAddFileUrl());
    } else {
      add_page_action(lang('add document'), get_url('files', 'add_document'));
      add_page_action(lang('add spreadsheet'), get_url('files', 'add_spreadsheet'));
      add_page_action(lang('add presentation'), get_url('files', 'add_presentation'));
      add_page_action(lang('upload file'), get_url('files', 'add_file'));
    } // if
  } // if
  add_stylesheet_to_page('project/documents.css');
  add_stylesheet_to_page('project/spreadsheet.css');
  add_stylesheet_to_page('project/spreadsheet_grey.css');
  
  add_javascript_to_page('modules/spreadsheet.js');
	
?>

<?php add_body_event_to_page('onload','TrimPath.spreadsheet.initDocument();') ?>

<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<?php if($file->isNew()) { ?>
<form action="<?php echo get_url('files', 'save_spreadsheet') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo get_url('files', 'save_spreadsheet',array(
	        'id' => $file->getId(), 
	        'active_project' =>  $file->getProjectId())) ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

<div class="spreadsheetEditor">

  <div class="spreadsheetScroll">
   <div class="spreadsheetBars" id="eldiv">      
        <?php 
		if(!($file->isNew()))
		{ //edit document
		   echo $file->getFileContent();
		}
		else 
		{
			echo '		
        <table class="spreadsheet" width="700" border="1">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">

        <col width="100"><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>

        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr> 
      </table>' ; 
		}?>
   </div>

  </div>
 </div>
   


  
      <div>
    <?php 
    if($file->isNew())
    {
    	echo label_tag(lang('name'), 'fileFormName');    
    	echo text_field('file[name]', array_var($file_data, 'name'), array('id' => 'fileFormName'));
    }
    else 
    { 
    	echo input_field('new_revision_spreadsheet','checked', array('type' => 'checkbox' , 'width' => '20' )) . lang('create new revision');
    } 
    ?>
    
  </div>
  <button class="submit" type="submit" accesskey="s" 
onclick="javascript:document.getElementById('TrimSpreadsheet').value =document.getElementById('eldiv').innerHTML.replace('\n',' ')">Save</button>
  <?php //echo submit_button(lang('Save'),'p', "onclick='javascript:alert(eldiv)'") ?>
  <input type="hidden"  id="TrimSpreadsheet"  name="TrimSpreadsheet" /> 
</form> 

