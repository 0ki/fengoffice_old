<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<!-- script src="http://www.savethedevelopers.org/say.no.to.ie.6.js"></script -->
	<title><?php echo clean(CompanyWebsite::instance()->getCompany()->getName()) ?> - OpenGoo</title>
	<?php echo stylesheet_tag('website.css') ?>
	<?php echo add_favicon_to_page('favicon.ico') ?>
	<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>

<?php 
	$jss= array('extjs/adapter/ext/ext-base.js',
			'extjs/ext-all.js',
			'app.js',
			'og/og.js',
			'og/HttpProvider.js',
			'og/WorkspaceChooser.js',
			'og/MessageManager.js',
			'og/WebpageManager.js',
			'og/ContactManager.js',
			'og/OverviewManager.js',
			'og/FileManager.js',
			'og/ReportingManager.js',
			'og/swfobject.js',
			'og/ImageChooser.js',
			'og/ObjectPicker.js',
			'og/HtmlPanel.js',
			'og/WorkspacePanel.js',
			'og/TagPanel.js',
			'og/EmailAccountMenu.js',
			'og/TagMenu.js',
			'og/Dashboard.js',
			'og/RowExpander.js',
			'og/TaskViewer.js',
			'og/ContentPanel.js',
			'og/HelpPanel.js',
			'og/layout.js',
			'modules/addTaskForm.js',
			'modules/addMessageForm.js',
			'modules/addFileForm.js',
			'modules/addProjectForm.js',
			'modules/addUserForm.js',
			'modules/massmailerForm.js',
			'modules/updatePermissionsForm.js',
			'modules/updateUserPermissions.js',
			'modules/linkObjects.js',
			'modules/linkToObjectForm.js',
			'slimey/slimey.js',
			'slimey/functions.js',
			'slimey/stack.js',
			'slimey/editor.js',
			'slimey/navigation.js',
			'slimey/actions.js',
			'slimey/tools.js',
			'slimey/toolbar.js',
			'modules/spreadsheet_engine.js',
			'modules/spreadsheet_ui.js',
			'modules/overlib.js',
			'og/TaskItem.js',
			'og/MilestoneItem.js',
			'og/DatePicker.js'
		);
	if(USE_JS_CACHE){
		echo add_javascript_to_page(implode(',',$jss));
	}
	else{
		foreach ($jss as $onejs){
			echo add_javascript_to_page($onejs);
		}
	}
	?>
	<?php echo add_javascript_to_page(with_slash(ROOT_URL) . 'language/' . Localization::instance()->getLocale() . "/lang.js") ?>
	<?php echo add_javascript_to_page(with_slash(ROOT_URL) .  'help/help.js') ?>

		
	<?php echo render_page_links() ?>
	<?php echo render_page_meta() ?>
	<?php echo render_page_inline_css() ?>
	<!--[if IE]>
	<style type="text/css">.viewAsList { visibility: hidden; }</style>
	<![endif]-->
</head>
<body id="body" <?php echo render_body_events() ?>>

<div id="loading">
	<img src="<?php echo get_image_url("layout/loading.gif") ?>" width="32" height="32" style="margin-right:8px;" align="absmiddle"/>Loading...
</div>

<div id="subWsExpander" onmouseover="clearTimeout(og.globalVars['swst']);" onmouseout="og.setSubWsTooltipTimeout(100)" style="display:none;"></div>

<?php echo render_page_javascript() ?>
<?php echo render_page_inline_js() ?>

<!-- header -->
<div id="header">
	<div id="headerContent">
	    <table><tr><td style="width:60px">
		<div id="logodiv"></div></td><td>
		<div id="wsCrumbsDiv"><div style="font-size:150%;display:inline;">
		<a href="#" style="display:inline;line-height:28px" onmouseover="og.expandSubWsCrumbs(0)"><?php echo lang('all') ?></a></div></div>
		</td></tr></table>
		<div id="userboxWrapper"><?php echo render_user_box(logged_user()) ?></div>
		<div id="searchbox">
			<form class="internalForm" action="<?php echo ROOT_URL . '/index.php' ?>" method="get">
				<table><tr><td>
				<?php
				$search_field_default_value = lang('search') . '...';
				$search_field_attrs = array(
				'onfocus' => 'if (value == \'' . $search_field_default_value . '\') value = \'\'',
				'onblur' => 'if (value == \'\') value = \'' . $search_field_default_value . '\'');
				?>
				<?php echo input_field('search_for', $search_field_default_value, $search_field_attrs) ?>
				</td><td>
				<button type="submit"><?php echo lang('search button caption') ?></button>
				</td></tr></table>
				<input type="hidden" name="c" value="search" />
				<input type="hidden" name="a" value="search" />
				<input type="hidden" name="current" value="search" />
				<input type="hidden" id="hfVars" name="vars" value="dashboard" />
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
og.pageSize = <?php echo config_option('files_per_page',10)?>;
og.hostName = '<?php echo ROOT_URL ?>';
og.maxUploadSize = <?php echo get_max_upload_size() ?>;
og.initialGUIState = <?php echo json_encode(GUIController::getState()) ?>;
og.initialURL = '<?php echo ROOT_URL . "?" . $_SERVER['QUERY_STRING'] ?>';

</script>
<?php include_once(Env::getLayoutPath("listeners"));?>

</body>
</html>
