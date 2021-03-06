<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<!-- script src="http://www.savethedevelopers.org/say.no.to.ie.6.js"></script -->
	<title><?php echo clean(CompanyWebsite::instance()->getCompany()->getName()) ?> - OpenGoo</title>

	<?php echo stylesheet_tag('website.css') ?>
	<?php echo add_favicon_to_page('favicon.ico') ?>
	<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>

	<?php echo add_javascript_to_page('extjs/adapter/ext/ext-base.js') ?>
	<?php echo add_javascript_to_page('extjs/ext-all.js') ?>
	<?php echo add_javascript_to_page('app.js') ?>
	<?php echo add_javascript_to_page('og/og.js') ?>
	<?php echo add_javascript_to_page('og/HttpProvider.js') ?>
	<?php echo add_javascript_to_page('og/MessageManager.js') ?>
	<?php echo add_javascript_to_page('og/WebpageManager.js') ?>
	<?php echo add_javascript_to_page('og/ContactManager.js') ?>
	<?php echo add_javascript_to_page('og/FileManager.js') ?>
	<?php echo add_javascript_to_page('og/ImageChooser.js') ?>
	<?php echo add_javascript_to_page('og/ObjectPicker.js') ?>
	<?php echo add_javascript_to_page('og/HtmlPanel.js') ?>
	<?php echo add_javascript_to_page('og/WorkspacePanel.js') ?>
	<?php echo add_javascript_to_page('og/TagPanel.js') ?>
	<?php echo add_javascript_to_page('og/EmailAccountMenu.js') ?>
	<?php echo add_javascript_to_page('og/TagMenu.js') ?>
	<?php echo add_javascript_to_page('og/Dashboard.js') ?>
	<?php echo add_javascript_to_page('og/TaskViewer.js') ?>
	<?php echo add_javascript_to_page('og/ContentPanel.js') ?>
	<?php echo add_javascript_to_page('og/HelpPanel.js') ?>
	<?php echo add_javascript_to_page('og/layout.js') ?>
	<?php echo add_javascript_to_page(with_slash(ROOT_URL) . 'help/help.js') ?>
	<?php echo add_javascript_to_page(with_slash(ROOT_URL) . 'language/' . Localization::instance()->getLocale() . "/lang.js") ?>
	<?php add_javascript_to_page('modules/addTaskForm.js');
	add_javascript_to_page('modules/addMessageForm.js');
	add_javascript_to_page('modules/addFileForm.js');
	add_javascript_to_page('modules/addProjectForm.js');
	add_javascript_to_page('modules/addUserForm.js');
	add_javascript_to_page('modules/addTaskForm.js');
	add_javascript_to_page('modules/attachFiles.js');
	add_javascript_to_page('modules/attachToObjectForm.js');
	add_javascript_to_page('modules/massmailerForm.js');
	add_javascript_to_page('modules/updatePermissionsForm.js');
	add_javascript_to_page('modules/updateUserPermissions.js');
	add_javascript_to_page('modules/linkObjects.js');
	add_javascript_to_page('modules/linkToObjectForm.js');
	add_javascript_to_page(SLIMEY_PATH . 'slimey.js');
	add_javascript_to_page(SLIMEY_PATH . 'functions.js');
	add_javascript_to_page(SLIMEY_PATH . 'stack.js');
	add_javascript_to_page(SLIMEY_PATH . 'editor.js');
	add_javascript_to_page(SLIMEY_PATH . 'navigation.js');
	add_javascript_to_page(SLIMEY_PATH . 'actions.js');
	add_javascript_to_page(SLIMEY_PATH . 'tools.js');
	add_javascript_to_page(SLIMEY_PATH . 'toolbar.js');
	add_javascript_to_page('modules/spreadsheet_engine.js');
	add_javascript_to_page('modules/spreadsheet_ui.js'); 
	add_javascript_to_page('modules/overlib.js');?>
	
	<?php echo render_page_links() ?>
	<?php echo render_page_meta() ?>
	<?php echo render_page_inline_css() ?>
</head>
<body id="body" <?php echo render_body_events() ?>>

<div id="loading">
	<img src="<?php echo get_image_url("layout/loading.gif") ?>" width="32" height="32" style="margin-right:8px;" align="absmiddle"/>Loading...
</div>

<?php echo render_page_javascript() ?>
<?php echo render_page_inline_js() ?>

<!-- header -->
<div id="header">
	<div id="headerContent">
		<div id="userboxWrapper"><?php echo render_user_box(logged_user()) ?></div>
		<div id="searchbox">
			<form class="internalForm" action="<?php echo ROOT_URL . '/index.php' ?>" method="get">
				<?php
				$search_field_default_value = lang('search') . '...';
				$search_field_attrs = array(
					'onfocus' => 'if (value == \'' . $search_field_default_value . '\') value = \'\'',
					'onblur' => 'if (value == \'\') value = \'' . $search_field_default_value . '\'');
				?>
				<?php echo input_field('search_for', $search_field_default_value, $search_field_attrs) ?>
				<button type="submit"><?php echo lang('search button caption') ?></button>
				<input type="hidden" name="c" value="search" />
				<input type="hidden" name="a" value="search" />
				<input type="hidden" name="current" value="search" />
			</form>
		</div>
		<?php echo render_system_notices(logged_user()) ?>
	</div>
</div>
<!-- /header -->

<!-- footer -->
<div id="footer">
	<div id="copy">
		<?php if(is_valid_url($owner_company_homepage = owner_company()->getHomepage())) { ?>
			<?php echo lang('footer copy with homepage', date('Y'), $owner_company_homepage, clean(owner_company()->getName())) ?>
		<?php } else { ?>
			<?php echo lang('footer copy without homepage', date('Y'), clean(owner_company()->getName())) ?>
		<?php } // if ?>
	</div>
	<div id="productSignature"><?php echo product_signature() ?></div>
</div>
<!-- /footer -->

<script>

// OG config options
og.pageSize = <?php echo config_option('files_per_page')?config_option('files_per_page'):10 ?>;
og.hostName = '<?php echo ROOT_URL ?>';
og.maxUploadSize = <?php echo get_max_upload_size() ?>;
og.initialGUIState = <?php echo json_encode(GUIController::getState()) ?>;
//og.initialURL = '<?php //echo ROOT_URL . "?" . $_SERVER['QUERY_STRING'] ?>';
//og.initialURL = 'prueba.php';

</script>

<?php include_once(Env::getLayoutPath("listeners"));?>


</body>
</html>
