<?php 
  set_page_title(lang('change password'));
  
  if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update profile'), $user->getEditProfileUrl(), 'ico-edit');
	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
  } // if
  
  if($user->canUpdatePermissions(logged_user())) {
  	add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-properties');
  } // if

?>
<form class="internalForm" action="<?php echo $user->getEditPasswordUrl($redirect_to) ?>" method="post">

  <?php tpl_display(get_template_path('form_errors')) ?>
  
<?php if(!logged_user()->isAdministrator()) { ?>
  <div>
    <?php echo label_tag(lang('old password'), 'passwordFormOldPassword', true) ?>
    <?php echo password_field('password[old_password]') ?>
  </div>
<?php } // if ?>
  
  <div>
    <?php echo label_tag(lang('password'), 'passwordFormOldPassword', true) ?>
    <?php echo password_field('password[new_password]') ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('password again'), 'passwordFormOldPassword', true) ?>
    <?php echo password_field('password[new_password_again]') ?>
  </div>
  
  <?php echo submit_button(lang('change password')) ?>
  
</form>