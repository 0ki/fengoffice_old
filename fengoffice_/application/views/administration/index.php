<?php 
  set_page_title(lang('administration'));
?>
<div class="adminIndex" style="height:100%;background-color:white">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('administration') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
    <?php echo lang('welcome to administration info') ?>
    <br/>
    <br/>
    <ul>
<?php if(can_edit_company_data(logged_user())){ ?>
      <li><a class="internalLink" href="<?php echo get_url('administration', 'company') ?>"><?php echo lang('company') ?></a></li>
<?php }
 	if(can_edit_company_data(logged_user())){ 
?>    <li><a class="internalLink" href="<?php echo get_url('administration', 'members') ?>"><?php echo lang('users') ?></a> (<a class="internalLink" href="<?php echo owner_company()->getAddUserUrl() ?>"><?php echo lang('add user') ?></a>)</li>
<?php }
 	if(can_manage_security(logged_user())){ 
?>      <li><a class="internalLink" href="<?php echo get_url('administration', 'clients') ?>"><?php echo lang('clients') ?></a> (<a class="internalLink" href="<?php echo get_url('company', 'add_client') ?>"><?php echo lang('add client') ?></a>)</li>
<?php }
	if(can_manage_security(logged_user())){ 
?>		<li><a class="internalLink" href="<?php echo get_url('administration', 'groups') ?>"><?php echo lang('groups') ?></a> (<a class="internalLink" href="<?php echo owner_company()->getAddGroupUrl() ?>"><?php echo lang('add group') ?></a>)</li>
<?php }
	if(can_manage_workspaces(logged_user())){ 
?>      <li><a class="internalLink" href="<?php echo get_url('administration', 'projects') ?>"><?php echo lang('projects') ?></a> (<a class="internalLink" href="<?php echo get_url('project', 'add') ?>"><?php echo lang('add project') ?></a>)</li>
<?php }
	if(can_manage_configuration(logged_user())){ 
?>      <li><a class="internalLink" href="<?php echo get_url('administration', 'configuration') ?>"><?php echo lang('configuration') ?></a></li>
<?php }
	if(can_manage_configuration(logged_user())){ 
?>      <li><a class="internalLink" href="<?php echo get_url('administration', 'upgrade') ?>"><?php echo lang('upgrade') ?></a></li>
<?php } ?>
</ul>
  </div>
</div>