<?php

    set_page_title($group->isNew() ? lang('add group') : lang('edit group'));
    administration_tabbed_navigation(ADMINISTRATION_TAB_GROUPS);
?>
<?php if($group->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('group', 'add_group') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $group->getEditUrl() ?>" method="post">
<?php } // if ?>


<div class="adminAddGroup">
  <div class="adminHeader">
  	<div class="adminHeaderUpperRow">
  		<div class="adminTitle"><table style="width:535px"><tr><td>
  			<?php echo $group->isNew() ? lang('new group') : lang('edit group') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button($group->isNew() ? lang('add group') : lang('save changes'), '', array('style'=>'margin-top:0px;margin-left:10px')) ?>
  		</td></tr></table>
  		</div>
  	</div>
  	
  <div>
    <?php echo label_tag(lang('name'), 'groupFormName', true) ?>
    <?php echo text_field('group[name]', array_var($group_data, 'name'), array('class' => 'title', 'id' => 'groupFormName')) ?>
  </div>
  
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">

  <fieldset>
    <legend><?php echo lang('permissions') ?></legend>    
    <div>
      <?php echo checkbox_field('group[can_edit_company_data]',array_var($group_data,'can_edit_company_data'), array('id' => 'group[can_edit_company_data]' )) ?> 
      <label for="<?php echo 'group[can_edit_company_data]' ?>" class="checkbox"><?php echo lang('can edit company data') ?></label>
    </div>    
    <div>
      <?php echo checkbox_field('group[can_manage_security]', array_var($group_data,'can_manage_security'), array('id' => 'group[can_manage_security]' )) ?> 
      <label for="<?php echo 'group[can_manage_security]' ?>" class="checkbox"><?php echo lang('can manage security') ?></label>
    </div>  
    <div>
      <?php echo checkbox_field('group[can_manage_workspaces]', array_var($group_data,'can_manage_workspaces'), array('id' => 'group[can_manage_workspaces]' )) ?> 
      <label for="<?php echo 'group[can_manage_workspaces]' ?>" class="checkbox"><?php echo lang('can manage workspaces') ?></label>
    </div>  
    <div>
      <?php echo checkbox_field('group[can_manage_configuration]', array_var($group_data,'can_manage_configuration'), array('id' => 'group[can_manage_configuration]' )) ?> 
      <label for="<?php echo 'group[can_manage_configuration]' ?>" class="checkbox"><?php echo lang('can manage configuration') ?></label>
    </div>  
    <div>
      <?php echo checkbox_field('group[can_manage_contacts]', array_var($group_data,'can_manage_contacts'), array('id' => 'group[can_manage_contacts]' )) ?> 
      <label for="<?php echo 'group[can_manage_contacts]' ?>" class="checkbox"><?php echo lang('can manage contacts') ?></label>
    </div>     
  </fieldset>
  
  <fieldset>
    <legend><?php echo lang('group users') ?></legend>  
    <?php foreach (Users::getAll() as $user) { 
    	$ctrl_name ='user['.$user->getId().']'; ?>
	    <div>
	      <?php echo checkbox_field($ctrl_name , array_var($group_data, $ctrl_name), array('id' => $ctrl_name  )) ?> 
	      <label for="<?php echo $ctrl_name  ?>" class="checkbox"><?php echo $user->getUsername() ?></label>
	    </div>  
    <?php } // for ?>
  </fieldset>
  
  <?php echo submit_button($group->isNew() ? lang('add group') : lang('save changes')) ?>
</div>
</div>
</form>