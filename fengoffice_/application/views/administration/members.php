<?php
  set_page_title(lang('members'));
  
  if(User::canAdd(logged_user(), owner_company())) {
    add_page_action(lang('add user'), owner_company()->getAddUserUrl(), 'ico-add');
  } // if

?>

<div class="adminUsersList">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('users') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
  
  <?php $this->includeTemplate(get_template_path('list_users', 'administration')); ?>
  
  </div>
 </div>