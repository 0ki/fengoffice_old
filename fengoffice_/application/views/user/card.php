<?php 

  // Set page title and set crumbs to index
  if($user->canUpdateProfile(logged_user())) {
  	add_page_action(lang('update profile'),$user->getEditProfileUrl(), 'ico-edit');
  	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
  	add_page_action(lang('change password'), $user->getEditPasswordUrl(), 'ico-password');
  } // if
  
  if($user->canUpdatePermissions(logged_user())) {
    add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-permissions');
  } // if

?>



<div style="padding:7px">
<div class="user">
<?php

	tpl_assign('title', $user->getDisplayName());
	tpl_assign('show_linked_objects', false);
	tpl_assign('object', $user);
	tpl_assign('iconclass', 'ico-large-user');
	tpl_assign("content_template", array('user_card', 'user'));
	
	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>