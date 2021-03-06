<?php
include("public/assets/javascript/fckeditor/fckeditor.php");
?>

<?php
	set_page_title($file->isNew() ? lang('new document') : lang('edit document') . ' - ' . clean($file->getFilename()));
	project_tabbed_navigation(PROJECT_TAB_FILES);
	project_crumbs(array(
		array(lang('files'), get_url('files')),
		array($file->isNew() ? lang('add document') : lang('edit document'))
	));

?>

<?php
	$instanceName = "fck" . gen_id();
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<script type="text/javascript">
og._checkFilename = function(iname) {
	var form = Ext.getDom(iname);
	form['fileContent'].value = FCKeditorAPI.GetInstance(iname).GetHTML();
	if (form['file[name]'].value && !form.rename) {
		return true;
	} else {
		Ext.Msg.prompt(lang('save'), lang('choose a filename') + ':',
			function(btn, text) {
				if (btn == 'ok') {
					if (text.substring(text.length - 5) != ".html" && text.substring(text.length - 7) != ".eyedoc") {
						text += ".html";
					}
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

<form class="internalForm" id="<?php echo $instanceName ?>" action="<?php echo get_url('files', 'save_document') ?>" method="post" enctype="multipart/form-data" onsubmit="return og._checkFilename('<?php echo $instanceName ?>')">
<input type="hidden" name="instanceName" value="<?php echo $instanceName ?>" />
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

//add_page_action(lang("save"), "javascript:(function(){ var form = document.getElementById('$instanceName'); form.new_revision_document.value = ''; form.rename = false; form.onsubmit(); })()", "save");
add_page_action(lang("save"), "javascript:(function(){ var form = document.getElementById('$instanceName'); form.new_revision_document.value = 'checked'; form.rename = false; form.onsubmit(); })()", "save");
add_page_action(lang("save as"), "javascript:(function(){ var form = document.getElementById('$instanceName'); form.new_revision_document.value = 'checked'; form.rename = true; form.onsubmit(); })()", "save_as");
?>

<script>

function FCKeditor_OnComplete(fck) {
	fck.ResetIsDirty();
	fck.Events.AttachEvent('OnSelectionChange', function(fck) {
		var p = og.getParentContentPanel(Ext.get(fck.Name));
		if (fck.IsDirty()) {
			Ext.getCmp(p.id).setPreventClose(true);
		} else {
			Ext.getCmp(p.id).setPreventClose(false);
		}
	});
}

</script>

 	<div>
		<input type="hidden" id="fileContent" name="fileContent" value="" />
		<input type="hidden" id="fileid" name="file[id]" value="<?php if (!$file->isNew()) echo $file->getId(); ?>" />
		<input type="hidden" id="filename" name="file[name]" value="<?php if (!$file->isNew()) echo clean($file->getFilename()); ?>" />
		<input type="hidden" name="new_revision_document" value="" />
	</div>
</form>

<script>
og.eventManager.addListener("document saved", function(obj) {
	var form = Ext.getDom(obj.instance);
	if (!form) return;
	form['file[id]'].value = obj.id;
	var fck = FCKeditorAPI.GetInstance(obj.instance);
	if (fck) {
		fck.ResetIsDirty();
		var p = og.getParentContentPanel(Ext.get(fck.Name));
		Ext.getCmp(p.id).setPreventClose(false);
	}
}, null, {replace:true});
</script>
