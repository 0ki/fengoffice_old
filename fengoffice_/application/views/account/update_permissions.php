<?php
	require_javascript("og/Permissions.js");
	$genid = gen_id();
	
	set_page_title(lang('update permissions'));
?>
<form style="height:100%;background-color:white" action="<?php echo get_url("account", "update_permissions", array("id" => $user->getId())) ?>" class="internalForm" onsubmit="javascript:og.ogPermPrepareSendData('<?php echo $genid ?>');return true;" method="POST">
<div class="adminClients">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang("permissions for user", clean($user->getUsername())) ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
<input name="submitted" type="hidden" value="submitted" />
<?php echo submit_button(lang('update permissions'));?>

<?php if (logged_user()->isAdministrator()) { ?>
<fieldset class=""><legend class="toggle_expanded" onclick="og.toggle('<?php echo $genid ?>userSystemPermissions',this)"><?php echo lang("system permissions") ?></legend>
	<div id="<?php echo $genid ?>userSystemPermissions" style="display:block">
		<div>
	      <?php echo checkbox_field('user[can_edit_company_data]',array_var($user_data,'can_edit_company_data'), array('id' => 'user[can_edit_company_data]' )) ?> 
	      <label for="<?php echo 'user[can_edit_company_data]' ?>" class="checkbox"><?php echo lang('can edit company data') ?></label>
	      <a href="javascript:og.toggle('can_edit_company_data_help')">?</a>
	    </div>
	    <div id="can_edit_company_data_help" class="permissions-help" style="display:none"><?php echo lang('can_edit_company_data description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_security]', array_var($user_data,'can_manage_security'), array('id' => 'user[can_manage_security]' )) ?> 
	      <label for="<?php echo 'user[can_manage_security]' ?>" class="checkbox"><?php echo lang('can manage security') ?></label>
	      <a href="javascript:og.toggle('can_manage_security_help')">?</a>
	    </div>
	    <div id="can_manage_security_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_security description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_workspaces]', array_var($user_data,'can_manage_workspaces'), array('id' => 'user[can_manage_workspaces]' )) ?> 
	      <label for="<?php echo 'user[can_manage_workspaces]' ?>" class="checkbox"><?php echo lang('can manage workspaces') ?></label>
	      <a href="javascript:og.toggle('can_manage_workspaces_help')">?</a>
	    </div>
	    <div id="can_manage_workspaces_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_workspaces description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_configuration]', array_var($user_data,'can_manage_configuration'), array('id' => 'user[can_manage_configuration]' )) ?> 
	      <label for="<?php echo 'user[can_manage_configuration]' ?>" class="checkbox"><?php echo lang('can manage configuration') ?></label>
	      <a href="javascript:og.toggle('can_manage_configuration_help')">?</a>
	    </div>
	    <div id="can_manage_configuration_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_configuration description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_contacts]', array_var($user_data,'can_manage_contacts'), array('id' => 'user[can_manage_contacts]' )) ?> 
	      <label for="<?php echo 'user[can_manage_contacts]' ?>" class="checkbox"><?php echo lang('can manage contacts') ?></label>
	      <a href="javascript:og.toggle('can_manage_contacts_help')">?</a>
	    </div>
	    <div id="can_manage_contacts_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_contacts description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_templates]', array_var($user_data,'can_manage_templates'), array('id' => 'user[can_manage_templates]' )) ?> 
	      <label for="<?php echo 'user[can_manage_templates]' ?>" class="checkbox"><?php echo lang('can manage templates') ?></label>
	      <a href="javascript:og.toggle('can_manage_templates_help')">?</a>
	    </div>
	    <div id="can_manage_templates_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_templates description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_reports]', array_var($user_data,'can_manage_reports'), array('id' => 'user[can_manage_reports]' )) ?> 
	      <label for="<?php echo 'user[can_manage_reports]' ?>" class="checkbox"><?php echo lang('can manage reports') ?></label>
	      <a href="javascript:og.toggle('can_manage_reports_help')">?</a>
	    </div>
	    <div id="can_manage_reports_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_reports description') ?></div>
	    <div>
	      <?php echo checkbox_field('user[can_manage_time]', array_var($user_data,'can_manage_time'), array('id' => 'user[can_manage_time]' )) ?> 
	      <label for="<?php echo 'user[can_manage_time]' ?>" class="checkbox"><?php echo lang('can manage time') ?></label>
	      <a href="javascript:og.toggle('can_manage_time_help')">?</a>
	    </div>
	    <div id="can_manage_time_help" class="permissions-help" style="display:none"><?php echo lang('can_manage_time description') ?></div>
		<div>
	      <?php echo checkbox_field('user[can_add_mail_accounts]', array_var($user_data,'can_add_mail_accounts'), array('id' => 'user[can_add_mail_accounts]' )) ?> 
	      <label for="<?php echo 'user[can_add_mail_accounts]' ?>" class="checkbox"><?php echo lang('can add mail accounts') ?></label>
	      <a href="javascript:og.toggle('can_add_mail_accounts_help')">?</a>
		</div>
		<div id="can_add_mail_accounts_help" class="permissions-help" style="display:none"><?php echo lang('can_add_mail_accounts description') ?></div>
	</div>
</fieldset>
<?php } ?>


<fieldset class="">
<legend><?php echo lang("project permissions") ?></legend>
<?php 
	tpl_assign('genid', $genid);
	$this->includeTemplate(get_template_path('user_permissions_control', 'account'));
?>
</fieldset>
<?php echo submit_button(lang('update permissions'));?>
</div>
</form>