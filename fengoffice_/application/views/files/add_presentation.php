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
	add_stylesheet_to_page(get_theme_url('slimey/slimey.css'));
	add_javascript_to_page(SLIMEY_PATH . 'slimey.js');
	add_javascript_to_page(SLIMEY_PATH . 'functions.js');
	add_javascript_to_page(SLIMEY_PATH . 'stack.js');
	add_javascript_to_page(SLIMEY_PATH . 'editor.js');
	add_javascript_to_page(SLIMEY_PATH . 'navigation.js');
	add_javascript_to_page(SLIMEY_PATH . 'actions.js');
	add_javascript_to_page(SLIMEY_PATH . 'tools.js');
	add_javascript_to_page(SLIMEY_PATH . 'toolbar.js');
	add_stylesheet_to_page('file/imageChooser.css');
	add_javascript_to_page('modules/imageChooser.js');
?>

<!-- slides -->
<div id="slimeyNavigation" style="width: 195px; float: left;">
	<div id="slimeyPreviewToolbar">
		<div class="slimeyPreviewToolbarButton">
			<a title="Add a new slide after the selected one" href="javascript:SlimeyNavigation.getInstance().addNewSlide();">
				<img src="<?php echo SLIMEY_PATH . 'images/newslide.png'?>"> Add New
			</a>
		</div>
		<div class="slimeyPreviewToolbarButton">
			<a title="Delete selected slide" href="javascript:SlimeyNavigation.getInstance().deleteCurrentSlide();">
				<img src="<?php echo SLIMEY_PATH . 'images/delslide.png'?>"> Delete
			</a>
		</div>
	</div>
</div>

<!-- editor -->
<div style="position: relative; margin-left: 200px; margin-right: 2px; height: 100%;">
	<div id="slimeyToolbar">
	</div>
	<div id="slimeyEditor">
	</div>
</div>

<?php
	if (!$file->isNew()) {
?>
<form name="slimeyForm" id="slimeyForm" method="POST" action="<?php echo get_url('files', 'save_presentation', array(
		'id' => $file->getId(), 
		'active_project' =>  $file->getProjectId())) ?>">
	<input id="filename" type="hidden" name="file[name]" value="<?php echo $file->getFilename() ?>">
	<input id="revision" type="hidden" name="new_revision_document" value="checked">
	<input id="slimContent" type="hidden" name="slimContent" value='<?php echo escapeSLIM($file->getFileContent()) ?>'>
</form>
<?php
	} else {
?>
<form name="slimeyForm" id="slimeyForm" method="POST" action="<?php echo get_url('files', 'save_presentation') ?>">
	<input id="filename" type="hidden" name="file[name]" value="">
	<input id="slimContent" type="hidden" name="slimContent" value="<?php echo escapeSLIM('<div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%;">New Slideshow</div></div><div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%;">Second slide</div></div>') ?>">
</form>
<?php
	}
?>

<script type="text/javascript">
	slimeyRootDir = '<?php echo SLIMEY_PATH ?>';
	slimeyImagesDir = '<?php echo get_theme_url("slimey/images/") ?>';
	preloadSlimeyImages();
	SlimeyEditor.initInstance('slimeyEditor');
	SlimeyToolbar.initInstance('slimeyToolbar');
	SlimeyNavigation.initInstance('slimeyNavigation');
	imagesUrl = '<?php echo str_replace("&amp;", "&", get_url('files', 'list_files', array('type' => 'image'))) ?>';
</script>

<?php tpl_display(get_template_path('form_errors')) ?>


