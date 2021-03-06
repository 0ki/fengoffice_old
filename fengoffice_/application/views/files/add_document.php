<?php
include("public/assets/javascript/fckeditor/fckeditor.php");
?>

<?php
	set_page_title($file->isNew() ? lang('new document') : lang('edit document') . ' - ' . $file->getFilename());
	project_tabbed_navigation(PROJECT_TAB_FILES);
	project_crumbs(array(
		array(lang('files'), get_url('files')),
		array($file->isNew() ? lang('add document') : lang('edit document'))
	));
	unset($content_for_sidebar);
	
	//add_stylesheet_to_page('project/documents.css');
	//add_stylesheet_to_page('file/imageChooser.css');
	//add_javascript_to_page('modules/imageChooser.js');
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<script type="text/javascript">
function checkFilename() {
	Ext.getDom('fileContent').value = FCKeditorAPI.GetInstance('FCKInstance').GetHTML();
	if (Ext.getDom('filename').value) {
		return true;
	} else {
		Ext.Msg.prompt('Save', 'Choose a filename:',
			function(btn, text) {
				if (btn == 'ok') {
					Ext.getDom('filename').value = text;
					Ext.getDom('fckform').onsubmit();
				}
			}
		);
		return false;
	}
}
</script>

<form class="internalForm" id="fckform" action="<?php echo get_url('files', 'save_document') ?>" method="post" enctype="multipart/form-data" onsubmit="return checkFilename()">

<?php tpl_display(get_template_path('form_errors')) ?>


<?php
$oFCKeditor = new FCKeditor('FCKInstance');
$oFCKeditor->BasePath = 'public/assets/javascript/fckeditor/';
$oFCKeditor->Width = '100%';
$oFCKeditor->Height = '100%';
$oFCKeditor->Config['SkinPath'] = get_theme_url('fckeditor/');
if($file->isNew()) {
	$oFCKeditor->Value = '';
} else {
	$oFCKeditor->Value = $file->getFileContent();
}
$oFCKeditor->Create();
add_page_action(lang("save"), "javascript:(function(){ var form = document.getElementById('fckform'); form.new_revision_document.value = ''; form.onsubmit(); })()", "save");
add_page_action(lang("save as new revision"), "javascript:(function(){ var form = document.getElementById('fckform'); form.new_revision_document.value = 'checked'; form.onsubmit(); })()", "save_new_revision");
?>



  <div>
    <input type="hidden" id="fileContent" name="fileContent" value="" />
    <input type="hidden" id="fileid" name="file[id]" value="<?php if (!$file->isNew()) echo $file->getId(); ?>" />
	<input type="hidden" id="filename" name="file[name]" value="<?php if (!$file->isNew()) echo $file->getFilename(); ?>" />
    <input type="hidden" name="new_revision_document" value="" />
  </div>
</form>

<script>
og.eventManager.addListener("file saved", function(obj) {
	Ext.getDom('fileid').value = obj.id;
}, null, {single:true});
</script>
