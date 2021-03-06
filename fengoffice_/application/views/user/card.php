<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('user card of', $user->getDisplayName()));
  dashboard_tabbed_navigation();
  dashboard_crumbs($user->getDisplayName());
  if($user->canUpdateProfile(logged_user())) {
  	add_page_action(lang('update profile'),$user->getEditProfileUrl(), 'ico-edit');
  	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
  	add_page_action(lang('change password'), $user->getEditPasswordUrl(), 'ico-password');
  } // if
  
  if($user->canUpdatePermissions(logged_user())) {
    add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-permissions');
  } // if

?>
<?php 
  $this->includeTemplate(get_template_path('user_card', 'user')) 
?>