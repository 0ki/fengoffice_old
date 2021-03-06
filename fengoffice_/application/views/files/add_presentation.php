
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
		$slimContent = escapeSLIM('<div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%;">New Slideshow</div></div>');
	}
	$id = time() % 1000000;
?>

<div id="slimey<?php echo $id ?>">
</div>

<script type="text/javascript">
	slimeyInstance = new Slimey({
		container: 'slimey<?php echo $id ?>',
		rootDir: '<?php echo SLIMEY_PATH ?>',
		imagesDir: '<?php echo get_theme_url("slimey/images/") ?>',
		filename: '<?php echo ($file->isNew()?'':$file->getFilename()) ?>',
		fileId: <?php echo ($file->isNew()?0:$file->getId()) ?>,
		slimContent: '<?php echo $slimContent ?>',
		saveUrl: '<?php echo $url ?>'
	});
	// for the image chooser
	imagesUrl = '<?php echo get_url('files', 'list_files', array('type' => 'image', 'ajax' => 'true')) ?>';
	
	og.eventManager.addListener("file saved", function(obj) {
		slimeyInstance.fileId = obj.id;
	}, null, {single:true});
</script>

<?php
add_page_action(lang("save"), "javascript:(function(){ slimeyInstance.submitFile(false); })()", "save");
add_page_action(lang("save as new revision"), "javascript:(function(){ slimeyInstance.submitFile(true); })()", "save_new_revision");
?>

<?php tpl_display(get_template_path('form_errors')) ?>


