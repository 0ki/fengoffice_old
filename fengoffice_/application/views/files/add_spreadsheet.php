<?php
  set_page_title($file->isNew() ? lang('new spreadsheet') : lang('edit spreadsheet'). ' - ' . $file->getFilename());
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($file->isNew() ? lang('add spreadsheet') : lang('edit document'))
  ));
  //add_stylesheet_to_page('project/documents.css');
  //add_stylesheet_to_page('project/spreadsheet.css');
  //add_stylesheet_to_page('project/spreadsheet_grey.css');
  
  //add_javascript_to_page('modules/spreadsheet_engine.js');
  //add_javascript_to_page('modules/spreadsheet_ui.js');
	
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>

<form class="internalForm" action="<?php echo $file->isNew()? get_url('files', 'save_spreadsheet') : get_url('files', 'save_spreadsheet',array('id' => $file->getId())) ?>" method="post" enctype="multipart/form-data">


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
    if($file->isNew()) {
    	echo label_tag(lang('name'), 'fileFormName');    
    	echo text_field('file[name]', array_var($file_data, 'name'), array('id' => 'fileFormName'));
    } else { 
    	echo input_field('new_revision_spreadsheet','checked', array('type' => 'checkbox' , 'width' => '20' )) . lang('create new revision');
    } 
    ?>
    
  </div>
  <button class="submit" type="submit" accesskey="s" 
onclick="javascript:document.getElementById('TrimSpreadsheet').value =document.getElementById('eldiv').innerHTML.replace('\n',' ')">Save</button>
  <?php //echo submit_button(lang('Save'),'p', "onclick='javascript:alert(eldiv)'") ?>
  <input type="hidden"  id="TrimSpreadsheet"  name="TrimSpreadsheet" /> 
</form>

<script type="text/javascript">
	TrimPath.spreadsheet.initDocument();
</script>

