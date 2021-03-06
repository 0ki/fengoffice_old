<?php
include("library/fckeditor/fckeditor.php");
?>

<?php
	set_page_title($file->isNew() ? lang('new document') : lang('edit document') . ' - ' . $file->getFilename());
	project_tabbed_navigation(PROJECT_TAB_FILES);
	project_crumbs(array(
		array(lang('files'), get_url('files')),
		array($file->isNew() ? lang('add document') : lang('edit document'))
	));
	unset($content_for_sidebar);
	
	add_stylesheet_to_page('project/documents.css');
	add_stylesheet_to_page('file/imageChooser.css');
	add_javascript_to_page('modules/imageChooser.js');
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<script type="text/javascript">
function checkFilename() {
	if (Ext.getDom('filename').value) {
		return true;
	} else {
		Ext.Msg.prompt('Save', 'Choose a filename:',
			function(btn, text) {
				if (btn == 'ok') {
					Ext.getDom('filename').value = text;
					Ext.getDom('fckform').submit();
				}
			}
		);
		return false;
	}
}
</script>
<?php if($file->isNew()) { ?>
<form id="fckform" action="<?php echo get_url('files', 'save_document') ?>" method="post" enctype="multipart/form-data" onsubmit="return checkFilename()">
<?php } else { ?>
<form id="fckform" action="<?php echo get_url('files', 'save_document',array(
	        'id' => $file->getId(), 
	        'active_project' =>  $file->getProjectId())) ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>


<?php
$oFCKeditor = new FCKeditor('FCKeditor1');
$oFCKeditor->BasePath = 'library/fckeditor/';
$oFCKeditor->Width = '100%';
$oFCKeditor->Height = '80%';
$oFCKeditor->Config['SkinPath'] = get_theme_url('fckeditor/');
if($file->isNew()) {
	$oFCKeditor->Value = '<h1>Edit Me!</h1>';
} else {
	$oFCKeditor->Value = $file->getFileContent();
}
$oFCKeditor->Create();
?>



  <div>
    <?php if($file->isNew()){
    	echo '<input type="hidden" id="filename" name="file[name]" value="" />';
    } else {
		echo '<input type="hidden" id="filename" name="file[name]" value="' . $file->getFilename() . '" />';
    	echo '<input type="hidden" name="new_revision_document" value="checked" />';
    } 
    ?>
  </div>
  <?php echo submit_button(lang('save document')) ?>
</form>

<script type="text/javascript">
imagesUrl = "<?php echo str_replace("&amp;", "&", get_url('files', 'list_files', array('type' => 'image'))) ?>";
</script>
