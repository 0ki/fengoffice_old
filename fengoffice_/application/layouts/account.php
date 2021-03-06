<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title><?php echo get_page_title() ?> @ <?php echo clean(owner_company()->getName()) ?></title>
	<?php echo add_favicon_to_page('favicon.ico') ?>
	<?php echo stylesheet_tag('project_website.css') ?> 
	<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?> 
	<?php echo add_javascript_to_page('yui/yahoo/yahoo-min.js') ?>
	<?php echo add_javascript_to_page('yui/dom/dom-min.js') ?>
	<?php echo add_javascript_to_page('yui/event/event-min.js') ?>
	<?php echo add_javascript_to_page('yui/animation/animation-min.js') ?>
	<?php echo add_javascript_to_page('app.js') ?>
	<?php echo add_javascript_to_page('layout.js') ?>
	<?php echo use_widget('UserBoxMenu') ?>
	<?php echo render_page_head() ?>
</head>
<body id="body">

<table id="global_layout" class="layout">
<tbody>
<tr id="global_layout_header">
<td>

	<?php echo render_system_notices(logged_user()) ?>
    
	<!-- header -->
	<div id="headerWrapper">
		<div id="header">
			<!--h1><a href="<?php echo get_url('account') ?>"><?php echo lang('my account') ?></a></h1-->
			<div id="userboxWrapper"><?php echo render_user_box(logged_user()) ?></div>
		</div>
	</div>
	<!-- /header -->

	<div id="tabsWrapper">
		<div id="tabs">
			<?php if(is_array(tabbed_navigation_items())) { ?>
			<ul>
				<?php foreach(tabbed_navigation_items() as $tabbed_navigation_item) { ?>
				<li id="tabbed_navigation_item_<?php echo $tabbed_navigation_item->getID() ?>" <?php if($tabbed_navigation_item->getSelected()) { ?> class="active" <?php } ?>><a href="<?php echo $tabbed_navigation_item->getUrl() ?>"><?php echo clean($tabbed_navigation_item->getTitle()) ?></a></li>
				<?php } // foreach ?>
			</ul>
			<?php } // if ?>
		</div>
	</div>

	<div id="crumbsWrapper">
		<div id="crumbsBlock">
			<div id="crumbs">
				<?php if(is_array(bread_crumbs())) { ?>
				<ul>
					<?php foreach(bread_crumbs() as $bread_crumb) { ?>
						<?php if($bread_crumb->getUrl()) { ?>
					<li>&raquo; <a href="<?php echo $bread_crumb->getUrl() ?>"><?php echo clean($bread_crumb->getTitle()) ?></a></li>
						<?php } else {?>
					<li>&raquo; <span><?php echo clean($bread_crumb->getTitle()) ?></span></li>
						<?php } // if {?>
					<?php } // foreach ?>
				</ul>
				<?php } // if ?>
			</div>
		</div>
	</div>

</td>
</tr>
<tr id="global_layout_body">
<td>
	<table id="body_layout" class="layout">
	<tbody>
	<tr>
	<td id="body_layout_menu">
		<table id="menu_layout" class="layout">
		<tbody>
		<tr>
		<td>
			<div id="menuContainer">
				<?php echo render_menu('overview', logged_user()->getActiveProjects(), ApplicationLogs::getProjectLogs(logged_user()->getPersonalProject(), true)) ?>
			</div>
		</td>
		<td>
			<div id="menuToggle" class="toggleHide" onclick="layoutToggleMenu(this)" title="Show/Hide Menu">
			</div>
		</td>
		</tr>
		</tbody>
		</table>
	</td>
	<td id="body_layout_content">

	<!-- content wrapper -->
	<div id="outerContentWrapper">
		<table id="content_layout" class="layout">
		<tr id="content_layout_header">
		<td>
			<?php if(!is_null(flash_get('success'))) { ?>
			<div id="success" onclick="this.style.display = 'none'"><?php echo clean(flash_get('success')) ?></div>
			<?php } ?>
			<?php if(!is_null(flash_get('error'))) { ?>
			<div id="error" onclick="this.style.display = 'none'"><?php echo clean(flash_get('error')) ?></div>
			<?php } ?>
			<h1 id="pageTitle"><?php echo get_page_title() ?></h1>
		</td>
		</tr>
		<tr id="content_layout_body">
		<td>
			<div id="pageContent">
				<table id="pagecontent_layout" class="layout">
				<tr>
				<td id="pagecontent_layout_content">
					<div id="content">
						<?php if(is_array(page_actions())) { ?>
						<div id="page_actions">
							<ul>
								<?php foreach(page_actions() as $page_action) { ?>
								<li><a href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?></a></li>
								<?php } // foreach ?>
							</ul>
						</div>
						<?php } // if ?>
						<!-- Content -->
						<?php echo $content_for_layout ?>
						<!-- /Content -->
					</div>
				</td>
				<td id="pagecontent_layout_sidebar">
					<?php if(isset($content_for_sidebar)) { ?>
					<div id="sidebar"><?php echo $content_for_sidebar ?></div>
					<?php } // if ?>
					<div class="clear"></div>
				</td>
				</tr>
				</table>
			</div>
		</td>
		</tr>
		<tr id="content_layout_footer">
		<td>
			<!--Footer -->
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
		</td>
		</tr>
		</table>
	</div>
	<!-- /content wrapper -->
	
	</td>
	</tr>
	</tbody>
	</table>

</td>
</tr>
</tbody>
</table>

</body>
</html>