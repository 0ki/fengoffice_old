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

<?php
	if ($file->isNew()) {
		$instanceName = "fck" . (time() % 1000000);
	} else {
		$instanceName = "fck" . $file->getId();
	}
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<script type="text/javascript">
function checkFilename(iname) {
	var form = Ext.getDom(iname);
	form['fileContent'].value = FCKeditorAPI.GetInstance(iname).GetHTML();
	if (form['file[name]'].value && !form.rename) {
		return true;
	} else {
		Ext.Msg.prompt('Save', 'Choose a filename:',
			function(btn, text) {
				if (btn == 'ok') {
					this['file[name]'].value = text;
					this.rename = false;
					this.onsubmit();
				}
			}, form, false, this.filename || ''
		);
		return false;
	}
}
</script>

<form class="internalForm" id="<?php echo $instanceName ?>" action="<?php echo get_url('files', 'save_document') ?>" method="post" enctype="multipart/form-data" onsubmit="return checkFilename('<?php echo $instanceName ?>')">

<?php tpl_display(get_template_path('form_errors')) ?>


<?php
$oFCKeditor = new FCKeditor($instanceName);
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
add_page_action(lang("save"), "javascript:(function(){ var form = document.getElementById('$instanceName'); form.new_revision_document.value = ''; form.rename = false; form.onsubmit(); })()", "save");
add_page_action(lang("save as new revision"), "javascript:(function(){ var form = document.getElementById('$instanceName'); form.new_revision_document.value = 'checked'; form.rename = false; form.onsubmit(); })()", "save_new_revision");
add_page_action(lang("save as"), "javascript:(function(){ var form = document.getElementById('$instanceName'); form.new_revision_document.value = 'checked'; form.rename = true; form.onsubmit(); })()", "save_as");
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
	this['file[id]'].value = obj.id;
}, Ext.getDom('<?php echo $instanceName ?>'), {single:true});
</script>
