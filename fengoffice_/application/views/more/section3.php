<?php

$links = array(
	array(
		'ico' => 'ico-large-user',
		'url' => get_url('contact', 'edit', array('id' => logged_user()->getId())),
		'name' => lang('edit your profile'),
	),
	array(
		'ico' => 'ico-large-config',
		'url' => get_url('contact', 'list_user_categories'),
		'name' => lang('edit preferences'),
	),
	array(
		'ico' => 'ico-large-change-password',
		'url' => get_url('account', 'edit_password', array('id' => logged_user()->getId())),
		'name' => lang('change password'),
	),
);


foreach ($links as $link) {
?>
	<div class="link">
		<a class="internalLink" href="<?php echo $link['url'] ?>" <?php echo isset($link['target']) ? 'target="'.$link['target'].'"' : '' ?> <?php echo isset($icon['onclick']) ? 'onclick="'.$icon['onclick'].'"' : '' ?>>
    		<div class="coViewIconImage <?php echo $link['ico']?>"></div>
    	</a>
		<a class="internalLink" href="<?php echo $link['url'] ?>" <?php echo isset($link['target']) ? 'target="'.$link['target'].'"' : '' ?>><?php echo $link['name'] ?></a>
	</div>
	
<?php
}
?>
	<div class="clear"></div>