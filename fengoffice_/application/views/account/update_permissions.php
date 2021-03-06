<?php
	$genid = gen_id();
  set_page_title(lang('update permissions'));
  
  if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update profile'), $user->getEditProfileUrl(), 'ico-edit');
	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
	add_page_action(lang('change password'),$user->getEditPasswordUrl(), 'ico-password');
  } // if
  
?>
<form style="height:100%;background-color:white" action="<?php echo get_url("account", "update_permissions", array("id" => $user->getId())) ?>" class="internalForm" onsubmit="javascript:ogPermPrepareSendData('<?php echo $genid ?>');return true;" method="POST">
<div class="adminClients">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang("permissions for user", $user->getUsername()) ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
<input name="submitted" type="hidden" value="submitted" />
<?php echo submit_button(lang('update permissions'));?>

<fieldset class=""><legend class="toggle_expanded" onclick="og.toggle('<?php echo $genid ?>userSystemPermissions',this)"><?php echo lang("system permissions") ?></legend>
	<div id="<?php echo $genid ?>userSystemPermissions" style="display:block">
		<div>
	      <?php echo checkbox_field('user[can_edit_company_data]',array_var($user_data,'can_edit_company_data'), array('id' => 'user[can_edit_company_data]' )) ?> 
	      <label for="<?php echo 'user[can_edit_company_data]' ?>" class="checkbox"><?php echo lang('can edit company data') ?></label>
	    </div>    
	    <div>
	      <?php echo checkbox_field('user[can_manage_security]', array_var($user_data,'can_manage_security'), array('id' => 'user[can_manage_security]' )) ?> 
	      <label for="<?php echo 'user[can_manage_security]' ?>" class="checkbox"><?php echo lang('can manage security') ?></label>
	    </div>  
	    <div>
	      <?php echo checkbox_field('user[can_manage_workspaces]', array_var($user_data,'can_manage_workspaces'), array('id' => 'user[can_manage_workspaces]' )) ?> 
	      <label for="<?php echo 'user[can_manage_workspaces]' ?>" class="checkbox"><?php echo lang('can manage workspaces') ?></label>
	    </div>  
	    <div>
	      <?php echo checkbox_field('user[can_manage_configuration]', array_var($user_data,'can_manage_configuration'), array('id' => 'user[can_manage_configuration]' )) ?> 
	      <label for="<?php echo 'user[can_manage_configuration]' ?>" class="checkbox"><?php echo lang('can manage configuration') ?></label>
	    </div>  
	    <div>
	      <?php echo checkbox_field('user[can_manage_contacts]', array_var($user_data,'can_manage_contacts'), array('id' => 'user[can_manage_contacts]' )) ?> 
	      <label for="<?php echo 'user[can_manage_contacts]' ?>" class="checkbox"><?php echo lang('can manage contacts') ?></label>
	    </div>  
	</div>
</fieldset>


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