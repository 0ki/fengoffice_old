<?php
	set_page_title(lang('edit file') . ' - ' . $file->getFilename());
	$iname = 'textedit' . $file->getId();
?>
<form class="internalForm" id="<?php echo $iname ?>" action="<?php echo get_url('files', 'text_edit') ?>" method="post" enctype="multipart/form-data">

	<div>
		<input type="hidden" name="file[id]" value="<?php echo $file->getId(); ?>" />
		<input type="hidden" name="file[name]" value="<?php echo $file->getFilename(); ?>" />
		<input type="hidden" name="new_revision_document" value="" />
 	</div>

	<textarea class="textedit" name="fileContent"><?php
	echo htmlentities($file->getFileContent());
	?></textarea>
<?php
add_page_action(lang("save"), "javascript:(function(){ var form = document.getElementById('$iname'); form.new_revision_document.value = ''; form.onsubmit(); })()", "save");
add_page_action(lang("save as new revision"), "javascript:(function(){ var form = document.getElementById('$iname'); form.new_revision_document.value = 'checked'; form.onsubmit(); })()", "save_new_revision");
?>
</form>
