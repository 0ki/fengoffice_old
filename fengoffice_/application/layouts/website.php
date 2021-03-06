<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<?php if(active_project() instanceof Project) { ?>
		<title><?php echo clean(active_project()->getName()) ?> - <?php echo get_page_title() ?> @ <?php echo clean(owner_company()->getName()) ?></title>
	<?php } else { ?>
		<title><?php echo get_page_title() ?> @ <?php echo clean(owner_company()->getName()) ?></title>
	<?php } // if ?>

	<?php echo stylesheet_tag('../extjs/css/ext-all.css') ?>
	<?php echo stylesheet_tag('website.css') ?>
	<?php echo add_favicon_to_page('favicon.ico') ?>
	<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>
	
	<?php echo add_javascript_to_page('extjs/adapter/ext/ext-base.js') ?>
	<?php echo add_javascript_to_page('extjs/ext-all.js') ?>
	<?php echo add_javascript_to_page('og/extfix.js') ?>
	<?php echo add_javascript_to_page('yui/yahoo/yahoo-min.js') ?>
	<?php echo add_javascript_to_page('yui/dom/dom-min.js') ?>
	<?php echo add_javascript_to_page('yui/event/event-min.js') ?>
	<?php echo add_javascript_to_page('yui/animation/animation-min.js') ?>
	<?php echo add_javascript_to_page('app.js') ?>
	<?php echo add_javascript_to_page('og/og.js') ?>
	<?php echo add_javascript_to_page('og/layout.js') ?>
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
	define('SLIMEY_PATH', with_slash(ROOT_URL) . 'library/slimey/');
	add_stylesheet_to_page(get_theme_url('slimey/slimey.css'));
	add_javascript_to_page(SLIMEY_PATH . 'slimey.js');
	add_javascript_to_page(SLIMEY_PATH . 'functions.js');
	add_javascript_to_page(SLIMEY_PATH . 'stack.js');
	add_javascript_to_page(SLIMEY_PATH . 'editor.js');
	add_javascript_to_page(SLIMEY_PATH . 'navigation.js');
	add_javascript_to_page(SLIMEY_PATH . 'actions.js');
	add_javascript_to_page(SLIMEY_PATH . 'tools.js');
	add_javascript_to_page(SLIMEY_PATH . 'toolbar.js');
	add_stylesheet_to_page('og/imageChooser.css');
	add_javascript_to_page('og/imageChooser.js');
	add_javascript_to_page('og/tabCloseMenu.js');
	add_javascript_to_page('og/fileManager.js');
	add_javascript_to_page('og/uploadFile.js');
	//add_javascript_to_page('og/uploadForm.js');
	add_javascript_to_page('modules/spreadsheet_engine.js');
	add_javascript_to_page('modules/spreadsheet_ui.js'); ?>
	
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
		<?php echo render_system_notices(logged_user()) ?>
	</div>
	<div id="crumbsWrapper">
		<div id="crumbsBlock">
			<div id="crumbs">
				<ul>
					<li><?php echo lang('current project') ?>:
					<select id="active_project" onchange="location.href = '?active_project=' + this.value;this.value = <?php echo active_project()->getId() ?>">
						<?php
						if (isset($active_projects) && is_array($active_projects) && count($active_projects)) {
							foreach($active_projects as $project) {
						?>
						<option value="<?php echo $project->getId() ?>"<?php if (active_project()->getId() == $project->getId()) { echo ' selected="selected"'; } ?>><?php echo clean($project->getName()) ?></option>
						<?php
							}
						}
						?>
					</select>
					</li>
				</ul>
			</div>
			<div id="searchBox">
				<form class="internalForm" action="<?php echo active_project()->getSearchUrl() ?>" method="get">
					<div>
						<?php
						$search_field_default_value = lang('search') . '...';
						$search_field_attrs = array(
							'onfocus' => 'if (value == \'' . $search_field_default_value . '\') value = \'\'',
							'onblur' => 'if (value == \'\') value = \'' . $search_field_default_value . '\'');
						?>
						<?php echo input_field('search_for', array_var($_GET, 'search_for', $search_field_default_value), $search_field_attrs) ?><button type="submit"><?php echo lang('search button caption') ?></button>
						<input type="hidden" name="c" value="project" />
						<input type="hidden" name="a" value="search" />
						<input type="hidden" name="active_project" value="<?php echo active_project()->getId() ?>" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /header -->

<!-- menu -->
<div id="menu">
	<?php
		$result = ProjectFiles::getProjectFiles(null, null, !logged_user()->isMemberOfOwnerCompany(), ProjectFiles::ORDER_BY_MODIFYTIME, 'DESC', 1, 3, false);
		if (is_array($result)) {
			list($recent_files, $pagination) = $result;
		} else {
			$recent_files = null;
			$pagination = null;
		}
		$tags = Tags::getTagNames();
		echo render_menu($tags, logged_user()->getActiveProjects(), $recent_files);
	?>
</div>
<!-- /menu -->

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
og.initialURL = '<?php echo ROOT_URL . "?" . $_SERVER['QUERY_STRING'] ?>';
</script>

</body>
</html>
