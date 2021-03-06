<?php
include("fckeditor/fckeditor.php");
//include("application/helpers/util.php");
?>

<?php
	set_page_title($file->isNew() ? lang('New presentation') : lang('edit presentation'));
	project_tabbed_navigation(PROJECT_TAB_FILES);
	project_crumbs(array(
		array(lang('files'), get_url('files')),
		array($file->isNew() ? lang('add presentation') : lang('edit presentation'))
	));
	if (ProjectFile::canAdd(logged_user(), active_project())) {
		if ($current_folder instanceof ProjectFolder) {
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
	add_stylesheet_to_page('project/slime.css');
?>

<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/slime.js') ?>"></script>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/slime.config.js') ?>"></script>

<table style="width: 100%; height: 600px; table-layout: fixed">
<tr valign="top">
<td width="200"  style="padding-right: 7px">
	<!-- slides -->
	<div id="previewContainer" class="previewContainer">
	</div>
	<div id="previewToolbar" class="previewToolbar">
		<table><tr>
			<span>
				<td><a title="Add a new slide after the selected one" href="javascript:insertNewSlide(currentSlide + 1)"><img src="<?php echo get_image_url('icons/newslide.png') ?>"> Add New</a></td>
			</span>
			<span>
				<td><a title="Delete selected slide" href="javascript:deleteSlide(currentSlide)"><img src="<?php echo get_image_url('icons/delslide.png') ?>"> Delete</a></td>
			</span>
		</tr></table>
	</div>
</td>
<td>
	<!-- editor -->
	<?php if($file->isNew()) { ?>
		<form  action="<?php echo get_url('files', 'save_presentation') ?>" method="post" onsubmit="getS5Content()" enctype="multipart/form-data">
	<?php } else { ?>
		<form  action="<?php echo get_url('files', 'save_presentation',array(
			'id' => $file->getId(), 
			'active_project' =>  $file->getProjectId())) ?>" method="post" onsubmit="getS5Content()" enctype="multipart/form-data">
	<?php } // if ?>
	<?php
		if ($file->isNew()) {
			$valor = '<div class="slide"><h1 align="center">New Slide</h1></div>';
		} else {
			$valor = $file->getFileContent();
		}
	?>
	<input id="s5content" type="hidden" name="s5content" value='<?php echo escapeS5($valor) ?>'>

	<?php
		$oFCKeditor = new FCKeditor('FCKeditor1');
		$oFCKeditor->BasePath = 'fckeditor/';
		$oFCKeditor->Width = '800';
		$oFCKeditor->Height = '600';
		$oFCKeditor->Config['CustomConfigurationsPath'] = '../../public/assets/javascript/modules/slime.config.js';
		$oFCKeditor->ToolbarSet = 'Slides';
		$sSkin = 'office2003';
		$sSkinPath = '../../fckeditor/editor/skins/' + $sSkin + '/';
		// $oFCKeditor->Config['SkinPath'] = $sSkinPath;
		$oFCKeditor->Value = '';
		$oFCKeditor->Create();
	?>
	<?php
		if ($file->isNew()) {
			echo label_tag(lang('name'), 'fileFormName');
			echo text_field('file[name]', array_var($file_data, 'name'), array('id' => 'fileFormName'));
		} else  { 
			echo input_field('new_revision_document','checked', array('type' => 'checkbox' , 'width' => '20' )) . lang('create new revision');
		}
	?>
  	</div>
  	<?php echo submit_button(lang('Save')) ?>
    </form>
</td>
</tr>
</table>

<?php tpl_display(get_template_path('form_errors')) ?>


