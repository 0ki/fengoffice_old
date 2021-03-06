<?php
	require_javascript("og/Permissions.js");
	$genid = gen_id();
	
	set_page_title(lang('update permissions'));
?>
<form style="height:100%;background-color:white" action="<?php echo get_url("account", "update_permissions", array("id" => $user->getId())) ?>" class="internalForm" onsubmit="javascript:og.ogPermPrepareSendData('<?php echo $genid ?>');return true;" method="POST">
<div class="adminClients">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang("permissions for user", clean($user->getObjectName())) ?></div>
  	<span style="margin-left:30px;"><?php echo submit_button(lang('update permissions')); ?></span>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
<input name="submitted" type="hidden" value="submitted" />
<?php

tpl_assign('genid', $genid);
tpl_assign('disable_sysperm_inputs', false);
$this->includeTemplate(get_template_path('system_permissions', 'account'));

echo submit_button(lang('update permissions'));
?>
</div>
</div>
</form>
<?php if ($user->isGuest()) { ?>
<script>
//og.ogPermReadOnly('<?php echo $genid ?>', true);
</script>
<?php } ?>