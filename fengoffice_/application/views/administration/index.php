<?php 
set_page_title(lang('administration'));
$icons = array();
if (can_edit_company_data(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-company',
		'url' => get_url('administration', 'company'),
		'name' => lang('organization data'),
		'extra' => '',
	);
}
/*FIXME FENG2 if (can_manage_security(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-company',
		'url' => get_url('administration', 'clients'),
		'name' => lang('client companies'),
		'extra' => '<a class="internalLink coViewAction ico-add" href="' . get_url('contact', 'add_company') . '">' . lang('add company') . '</a>'
	);
}*/
if (logged_user()->isExecutiveGroup()) {
	$icons[] = array(
		'ico' => 'ico-large-user',
		'url' => get_url('administration', 'members'),
		'name' => lang('users'),
		'extra' => '<a class="internalLink coViewAction ico-add" href="' . owner_company()->getAddUserUrl() . '">' . lang('add user') . '</a>',
	);
} 
if (can_manage_security(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-group',
		'url' => get_url('administration', 'groups'),
		'name' => lang('groups'),
		'extra' => '<a class="internalLink coViewAction ico-add" href="' . owner_company()->getAddGroupUrl() . '">' . lang('add group') . '</a>',
	);
}
/*FIXME if (can_manage_security(logged_user()) && Plugins::instance()->isActivePlugin('mail')) {
	$icons[] = array(
		'ico' => 'ico-large-email',
		'url' => get_url('administration', 'mail_accounts'),
		'name' => lang('mail accounts'),
		'extra' => '<a class="internalLink coViewAction ico-add" href="' . get_url('mail', 'add_account') . '">' . lang('add mail account') . '</a>',
	);
}*/

if (can_manage_templates(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-template',
		'url' => get_url('template', 'index'),
		'name' => lang('templates'),
		'extra' => '<a class="internalLink coViewAction ico-add" href="' . get_url('template','add') . '">' . lang('add template') . '</a>',
	);
}


/*FIXME if (can_manage_security(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-billing',
		'url' => get_url('billing', 'index'),
		'name' => lang('billing'),
		'extra' => '<a class="internalLink coViewAction ico-add" href="' . get_url('billing', 'add') . '">' . lang('add billing category') . '</a>',
	);	
}*/

if (can_manage_configuration(logged_user())) {
	/*FIXME FENG 2$icons[] = array(
		'ico' => 'ico-large-custom-properties',
		'url' => get_url('administration', 'custom_properties'),
		'name' => lang('custom properties'),
		'extra' => '',
	);
	$icons[] = array(
		'ico' => 'ico-large-object-subtypes',
		'url' => get_url('administration', 'object_subtypes'),
		'name' => lang('object subtypes'),
		'extra' => '',
	);*/
	
	$icons[] = array(
		'ico' => 'ico-large-configuration',
		'url' => get_url('administration', 'configuration'),
		'name' => lang('configuration'),
		'extra' => '',
	);
	$icons[] = array(
		'ico' => 'ico-large-tools',
		'url' => get_url('administration', 'tools'),
		'name' => lang('administration tools'),
		'extra' => '',
	);
	/*FIXME if (!defined('ALLOW_UPGRADING') || ALLOW_UPGRADING) {
		$icons[] = array(
			'ico' => 'ico-large-upgrade',
			'url' => get_url('administration', 'upgrade'),
			'name' => lang('upgrade'),
			'extra' => '',
		);
	}*/
	if (!defined('ALLOW_CONFIGURING_CRON') || ALLOW_CONFIGURING_CRON) {
		$icons[] = array(
			'ico' => 'ico-large-cron',
			'url' => get_url('administration', 'cron_events'),
			'name' => lang('cron events'),
			'extra' => '',
		);
	}
}
if (can_manage_dimensions(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-workspace',
		'url' => get_url('administration', 'edit_members'),
		'name' => lang('dimensions'),
		'extra' => '',
	);
}

if (can_manage_tabs(logged_user())) {
	$icons[] = array(
		'ico' => 'ico-large-tabs',
		'url' => get_url('administration', 'tabs'),
		'name' => lang('tabs'),
		'extra' => '',
	);
}
Hook::fire('render_administration_icons', null, $icons);
if (count($icons > 0)) {}
?>
<div class="adminIndex" style="height:100%;background-color:white">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('administration') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
    <?php //FIXME FENG2 echo lang('welcome to administration info') ?>
    <br/>
    <br/>
    <?php 
		$show_help_option = user_config_option('show_context_help'); 
		if ($show_help_option == 'always' || ($show_help_option == 'until_close' && user_config_option('show_administration_context_help', true, logged_user()->getId()))) {?>
		<div id="administrationPanelContextHelp" style="padding-left:7px;padding:15px;background-color:white;">
			<?php render_context_help($this, 'chelp administrator panel','administration'); ?>
		</div>
	<?php }?>
<div style="width:100%;max-width:700px; text-align:center;position:relative">

<?php
// print administration icons
if (count($icons > 0)) {?>
<table><tr>
<?php $count = 0;
foreach ($icons as $icon) {
	if ($count % 4 == 0) { ?>
		</tr><tr>
	<?php }
	$count++;?>
<td align="center">
    <div style="width:150px;display:block; margin-right:10px;margin-bottom:40px">
    <table width="100%" align="center"><tr><td align="center">
    	<a class="internalLink" href="<?php echo $icon['url'] ?>" <?php echo isset($icon['target']) ? 'target="'.$icon['target'].'"' : '' ?> <?php echo isset($icon['onclick']) ? 'onclick="'.$icon['onclick'].'"' : '' ?>>
    		<span style="display: block;" class="coViewIconImage <?php echo $icon['ico']?>"></span>
    	</a>
        </td></tr><tr><td align="center"><b><a class="internalLink" href="<?php echo $icon['url'] ?>" <?php echo isset($icon['target']) ? 'target="'.$icon['target'].'"' : '' ?>><?php echo $icon['name'] ?></a></b>
    <?php if (isset($icon['extra'])) { ?>
    </td></tr><tr><td align="center"><?php echo $icon['extra']; ?>
    <?php } ?>
    </td></tr></table>
    </div>
</td>
<?php } ?>
</tr></table>
<?php } ?>

</div>
    
  </div>
</div>