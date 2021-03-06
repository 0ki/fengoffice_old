<?php
    set_page_title(lang('update avatar'));
  
  if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update profile'), $user->getEditProfileUrl(), 'ico-edit');
	add_page_action(lang('change password'),$user->getEditPasswordUrl(), 'ico-password');
  } // if
  
  if($user->canUpdatePermissions(logged_user())) {
  	add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-permissions');
  } // if

?>


<form action="<?php echo $user->getUpdateAvatarUrl($redirect_to) ?>" method="post" enctype="multipart/form-data" onsubmit="og.submit(this, '<?php echo get_url("account", "index") ?>')">

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current avatar') ?></legend>
<?php if($user->hasAvatar()) { ?>
    <img src="<?php echo $user->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> avatar" />
    <p><a class="internalLink" href="<?php echo $user->getDeleteAvatarUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete current avatar') ?>')"><?php echo lang('delete current avatar') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current avatar') ?>
<?php } // if ?>
  </fieldset>
  
  <div>
    <?php echo label_tag(lang('new avatar'), 'avatarFormAvatar', true) ?>
    <?php echo file_field('new avatar', null, array('id' => 'avatarFormAvatar')) ?>
<?php if($user->hasAvatar()) { ?>
    <p class="desc"><?php echo lang('new avatar notice') ?></p>
<?php } // if ?>
  </div>
  
  <?php echo submit_button(lang('update avatar')) ?>
  
</form>