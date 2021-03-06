<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<?php echo render_page_head() ?>
</head>
<body>
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
					<li><a class="internalLink" href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?></a></li>
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
</body>
</html>
