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
	<?php echo add_javascript_to_page('yui/yahoo/yahoo-min.js') ?>
	<?php echo add_javascript_to_page('yui/dom/dom-min.js') ?>
	<?php echo add_javascript_to_page('yui/event/event-min.js') ?>
	<?php echo add_javascript_to_page('yui/animation/animation-min.js') ?>
	<?php echo add_javascript_to_page('layout.js') ?>
	<?php echo add_javascript_to_page('app.js') ?>
	<?php echo use_widget('UserBoxMenu') ?>
	<?php echo render_page_head() ?>
</head>
<body id="body" <?php echo render_body_events() ?>>

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
					<li><a href="<?php echo active_project()->getOverviewUrl() ?>"><?php echo clean(active_project()->getName()) ?></a></li>
					<li>&raquo;</li>
					<li><span><?php echo get_page_title() ?></span></li>
				</ul>
			</div>
			<div id="searchBox">
				<form action="<?php echo active_project()->getSearchUrl() ?>" method="get">
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

<!-- content -->
<div id="content">
	<?php if(!is_null(flash_get('success'))) { ?>
	<div id="success" onclick="this.style.display = 'none'"><?php echo clean(flash_get('success')) ?></div>
	<?php } ?>
	<?php if(!is_null(flash_get('error'))) { ?>
	<div id="error" onclick="this.style.display = 'none'"><?php echo clean(flash_get('error')) ?></div>
	<?php } ?>
	<h1 id="pageTitle" class="pageTitle"><?php echo get_page_title() ?></h1>
	<div id="pageContent">
		<div id="mainContent">
			<?php if(is_array(page_actions())) { ?>
			<div id="page_actions">
				<ul>
					<?php foreach(page_actions() as $page_action) { ?>
					<li><a href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?></a></li>
					<?php } // foreach ?>
				</ul>
			</div>
			<?php } // if ?>
			<!-- content -->
			<?php echo $content_for_layout ?>
			<!-- /content -->
		</div>
		<?php if (isset($content_for_sidebar)) { ?>
		<div id="sidebar"><?php echo $content_for_sidebar ?></div>
		<?php } // if ?>
		<div class="clear"></div>
	</div>
</div>
<!-- /content -->

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

</body>
</html>
