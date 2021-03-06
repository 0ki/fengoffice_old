
<?php
	set_page_title($file->isNew() ? lang('new presentation') : lang('edit presentation'). ' - ' . $file->getFilename());
	project_tabbed_navigation(PROJECT_TAB_FILES);
	project_crumbs(array(
		array(lang('files'), get_url('files')),
		array($file->isNew() ? lang('add presentation') : lang('edit presentation'))
	));
?>

<?php
	if (!$file->isNew()) {
		$url = str_replace("&amp;", "&", get_url('files', 'save_presentation', array(
				'id' => $file->getId())));
		$filename = $file->getFilename();
		$slimContent = escapeSLIM($file->getFileContent());
	} else {
		$url = str_replace("&amp;", "&", get_url('files', 'save_presentation'));
		$filename = '';
		$slimContent = escapeSLIM('<div class="slide"><div style="font-size: 200%; font-weight: bold; font-family: sans-serif; position: absolute; left: 24%; top: 0%;">New Slideshow</div></div>');
	}
	$id = gen_id();
?>

<div id="<?php echo $id ?>">
</div>

<script type="text/javascript">
	var body = og.getParentContentPanelBody('<?php echo $id ?>');
	var panel = Ext.getCmp(og.getParentContentPanel('<?php echo $id ?>').id);
	var <?php echo $id ?> = new Slimey({
		container: body,
		rootDir: '<?php echo SLIMEY_PATH ?>',
		imagesDir: '<?php echo get_theme_url("slimey/images/") ?>',
		filename: '<?php echo ($file->isNew()?'':$file->getFilename()) ?>',
		fileId: <?php echo ($file->isNew()?0:$file->getId()) ?>,
		slimContent: '<?php echo $slimContent ?>',
		saveUrl: '<?php echo $url ?>'
	});
	<?php echo $id ?>.layout();
	panel.on('resize', <?php echo $id ?>.layout, <?php echo $id ?>);
	
	// for the image chooser
	imagesUrl = '<?php echo get_url('files', 'list_files', array('type' => 'image', 'ajax' => 'true')) ?>';
	
	og.eventManager.addListener("presentation saved", function(obj) {
		this.fileId = obj.id;
	}, <?php echo $id ?>, {replace:true});

</script>

<?php
add_page_action(lang("save"), "javascript:(function(){ $id.submitFile(true); })()", "save");
add_page_action(lang("save as"), "javascript:(function(){ $id.submitFile(true, true); })()", "save_as");
?>

<?php tpl_display(get_template_path('form_errors')) ?>


