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
	add_stylesheet_to_page(SLIMEY_PATH . 'slimey.css');
	add_javascript_to_page(SLIMEY_PATH . 'functions.js');
	add_javascript_to_page(SLIMEY_PATH . 'stack.js');
	add_javascript_to_page(SLIMEY_PATH . 'editor.js');
	add_javascript_to_page(SLIMEY_PATH . 'navigation.js');
	add_javascript_to_page(SLIMEY_PATH . 'actions.js');
	add_javascript_to_page(SLIMEY_PATH . 'tools.js');
	add_javascript_to_page(SLIMEY_PATH . 'toolbar.js');
?>

<table style="width: 100%; height: 100%; table-layout: fixed">
<tr valign="top">
<td width="195">
	<!-- slides -->
	<div id="previewContainer" class="previewContainer">
		<div id="previewToolbar" class="previewToolbar">
			<table><tr>
				<td>
					<a title="Add a new slide after the selected one" href="javascript:var action = new SlimeyInsertSlideAction(currentSlide + 1);SlimeyEditor.getInstance().performAction(action);">
						<img src="<?php echo SLIMEY_PATH . 'images/newslide.png'?>"> Add New
					</a>
				</td><td>
					<a title="Delete selected slide" href="javascript:if (currentSlide > 0) {var action = new SlimeyDeleteSlideAction(currentSlide);SlimeyEditor.getInstance().performAction(action);}">
						<img src="<?php echo SLIMEY_PATH . 'images/delslide.png'?>"> Delete
					</a>
				</td>
			</tr></table>
		</div>
	</div>
</td>
<td>
	<!-- editor -->
	<?php
		if (!$file->isNew()) {
	?>
	<form name="slimeyForm" id="slimeyForm" method="POST" action="<?php echo get_url('files', 'save_presentation', array(
			'id' => $file->getId(), 
			'active_project' =>  $file->getProjectId())) ?>">
		<input id="filename" type="hidden" name="file[name]" value="<?php echo $file->getFilename() ?>">
		<input id="revision" type="hidden" name="new_revision_document" value="">
		<input id="slimContent" type="hidden" name="slimContent" value='<?php echo escapeSLIM($file->getFileContent()) ?>'>
	</form>
	<?php
		} else {
	?>
	<form name="slimeyForm" id="slimeyForm" method="POST" action="<?php echo get_url('files', 'save_presentation') ?>">
		<input id="filename" type="hidden" name="file[name]" value="">
		<input id="slimContent" type="hidden" name="slimContent" value="<?php echo escapeSLIM('<div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%; border: 2px solid transparent;">New Slideshow</div></div><div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 30%; top: 0%; border: 2px solid transparent;">Second slide</div></div>') ?>">
	</form>
	<?php
		}
	?>

	<div id="slimeyToolbar">
	</div>
	
	<div id="slimeyEditor">
	</div>
	
	<script>
		rootDir = '<?php echo SLIMEY_PATH ?>';
		imagesDir = rootDir + 'images/';
		SlimeyEditor.initInstance('slimeyEditor', window);
		SlimeyToolbar.getInstance();
		initNavigation();
	</script>

</td>
</tr>
</table>

<?php tpl_display(get_template_path('form_errors')) ?>


