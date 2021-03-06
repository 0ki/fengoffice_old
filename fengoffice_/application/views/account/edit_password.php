<?php 
  set_page_title(lang('change password'));
  
  if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update profile'), $user->getEditProfileUrl(), 'ico-edit');
	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture');
  } // if
  
  if($user->canUpdatePermissions(logged_user())) {
  	add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-permissions');
  } // if

?>
<form class="internalForm" action="<?php echo $user->getEditPasswordUrl($redirect_to) ?>" method="post">

  <?php tpl_display(get_template_path('form_errors'));
  		$first_tab = 1; 
  ?>
  
<?php if(!logged_user()->isAdministrator()) { ?>
  <div>
    <?php echo label_tag(lang('old password'), 'passwordFormOldPassword', true) ?>
    <?php echo password_field('password[old_password]', null, array('tabindex' => $first_tab)) ?>
    <?php $first_tab = '100' ?>
  </div>
<?php } // if ?>
  
  <div>
    <?php echo label_tag(lang('password'), 'passwordFormNewPassword', true) ?>
    <?php echo password_field('password[new_password]', null, array('tabindex' => $first_tab)) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('password again'), 'passwordFormNewPasswordAgain', true) ?>
    <?php echo password_field('password[new_password_again]', null, array('tabindex' => $first_tab + 100)) ?>
  </div>
  
  <?php echo submit_button(lang('change password'), 'C', array('tabindex' => $first_tab + 200)) ?>
  
</form>

<script type="text/javascript">
	
</script>