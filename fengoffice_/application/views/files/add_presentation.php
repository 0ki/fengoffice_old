<?php
	define('SLIMEY_PATH', with_slash(ROOT_URL) . 'library/slimey/');
?>

<?php
	set_page_title($file->isNew() ? lang('new presentation') : lang('edit presentation'). ' - ' . $file->getFilename());
	project_tabbed_navigation(PROJECT_TAB_FILES);
	project_crumbs(array(
		array(lang('files'), get_url('files')),
		array($file->isNew() ? lang('add presentation') : lang('edit presentation'))
	));
	/*add_stylesheet_to_page(get_theme_url('slimey/slimey.css'));
	add_javascript_to_page(SLIMEY_PATH . 'slimey.js');
	add_javascript_to_page(SLIMEY_PATH . 'functions.js');
	add_javascript_to_page(SLIMEY_PATH . 'stack.js');
	add_javascript_to_page(SLIMEY_PATH . 'editor.js');
	add_javascript_to_page(SLIMEY_PATH . 'navigation.js');
	add_javascript_to_page(SLIMEY_PATH . 'actions.js');
	add_javascript_to_page(SLIMEY_PATH . 'tools.js');
	add_javascript_to_page(SLIMEY_PATH . 'toolbar.js');
	add_stylesheet_to_page('file/imageChooser.css');
	add_javascript_to_page('modules/imageChooser.js');*/
?>

<?php
	if (!$file->isNew()) {
		$url = str_replace("&amp;", "&", get_url('files', 'save_presentation', array(
				'id' => $file->getId(), 
				'active_project' =>  $file->getProjectId())));
		$filename = $file->getFilename();
		$slimContent = escapeSLIM($file->getFileContent());
	} else {
		$url = str_replace("&amp;", "&", get_url('files', 'save_presentation'));
		$filename = '';
		$slimContent = escapeSLIM('<div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%;">New Slideshow</div></div><div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%;">Second slide</div></div>');
	}
	$id = time() % 1000000;
?>

<iframe src="" id="frm<?php echo $id ?>" name="frm<?php echo $id ?>" style="width:300px;height:200px;position:absolute;display:none" onload="try {og.endSubmit(this)}catch(e){}">
</iframe>

<div id="slimey<?php echo $id ?>">
</div>

<script type="text/javascript">
	new Slimey({
		container: 'slimey<?php echo $id ?>',
		rootDir: '<?php echo SLIMEY_PATH ?>',
		imagesDir: '<?php echo get_theme_url("slimey/images/") ?>',
		filename: '<?php echo ($file->isNew()?'':$file->getFilename()) ?>',
		slimContent: '<?php echo $slimContent ?>',
		saveUrl: '<?php echo $url ?>'
	});
	// for the image chooser
	imagesUrl = '<?php echo str_replace("&amp;", "&", get_url('files', 'list_files', array('type' => 'image'))) ?>';
</script>

<?php tpl_display(get_template_path('form_errors')) ?>


