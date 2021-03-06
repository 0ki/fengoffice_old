<?php
$links = array();
/*
$links[] = array(
	'ico' => 'ico-large-group',
	'url' => 'http://wiki.fengoffice.com/doku.php#part_5users_and_rights',
	'name' => lang('about users, groups and permissions'),
	'target' => '_blank',
);
$links[] = array(
		'ico' => 'ico-large-template',
		'url' => 'http://wiki.fengoffice.com/doku.php/templates:templates',
		'name' => lang('about process templates'),
		'target' => '_blank',
);
if (Plugins::instance()->isActivePlugin('crpm')) {
	$links[] = array(
		'ico' => 'ico-large-projects',
		'url' => 'http://wiki.fengoffice.com/doku.php/clientsandprojects:clientsandprojects',
		'name' => lang('about clients and projects'),
		'target' => '_blank',
	);
}
$links[] = array(
	'ico' => 'ico-large-tabs',
	'url' => 'http://wiki.fengoffice.com/doku.php#part_3modules',
	'name' => lang('about modules and dimensions'),
	'target' => '_blank',
);
$links[] = array(
	'ico' => 'ico-large-tasks',
	'url' => 'http://wiki.fengoffice.com/doku.php/tasks',
	'name' => lang('about tasks'),
	'target' => '_blank',
);
*/

$right_links = array();
$right_links[] = array(
	'ico' => 'ico-large-help',
	'url' => 'http://wiki.fengoffice.com/',
	'name' => lang('more help'),
	'target' => '_blank',
);
$right_links[] = array(
	'ico' => 'ico-large-comment',
	'url' => 'http://www.fengoffice.com/web/support/tickets.php',
	'name' => lang('open a support ticket'),
	'target' => '_blank',
);

?>
<div class="left-section">
<?php
foreach ($links as $link) {
?>
	<div class="link">
		<a href="<?php echo $link['url'] ?>" <?php echo isset($link['target']) ? 'target="'.$link['target'].'"' : '' ?> <?php echo isset($icon['onclick']) ? 'onclick="'.$icon['onclick'].'"' : '' ?>>
    		<div class="coViewIconImage <?php echo $link['ico']?>"></div>
    	</a>
		<a href="<?php echo $link['url'] ?>" <?php echo isset($link['target']) ? 'target="'.$link['target'].'"' : '' ?>><?php echo $link['name'] ?></a>
	</div>
	
<?php
}
?>
	<div class="clear"></div>
</div>


<div class="right-section">
<?php
foreach ($right_links as $link) {
?>
	<div class="link">
		<a href="<?php echo $link['url'] ?>" <?php echo isset($link['target']) ? 'target="'.$link['target'].'"' : '' ?> <?php echo isset($icon['onclick']) ? 'onclick="'.$icon['onclick'].'"' : '' ?>>
    		<div class="coViewIconImage <?php echo $link['ico']?>"></div>
    	</a>
		<a href="<?php echo $link['url'] ?>" <?php echo isset($link['target']) ? 'target="'.$link['target'].'"' : '' ?>><?php echo $link['name'] ?></a>
	</div>
	
<?php
}
?>
</div>

<div class="clear"></div>