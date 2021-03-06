<?php
  set_page_title(lang('update picture'));
  
  if($contact->canEdit(logged_user())) {
    add_page_action(array(
      lang('edit contact')  => $contact->getEditUrl(),
      lang('update picture')   => $contact->getUpdatePictureUrl(),
	lang('assign to project')   => $contact->getAssignToProjectUrl()
    ));
  } // if

?>

<form action="<?php echo $contact->getUpdatePictureUrl($redirect_to) ?>" method="post" enctype="multipart/form-data" onsubmit="og.submit(this, '<?php echo $contact->getUpdatePictureUrl() ?>')">

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current picture') ?></legend>
<?php if($contact->hasPicture()) { ?>
    <img src="<?php echo $contact->getPictureUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> picture" />
    <p><a class="internalLink" href="<?php echo $contact->getDeletePictureUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete current picture') ?>')"><?php echo lang('delete current picture') ?></a></p>
<?php } else { ?>
    <?php echo lang('no current picture') ?>
<?php } // if ?>
  </fieldset>
  
  <div>
    <?php echo label_tag(lang('new picture'), 'pictureFormPicture', true) ?>
    <?php echo file_field('new picture', null, array('id' => 'pictureFormPicture')) ?>
<?php if($contact->hasPicture()) { ?>
    <p class="desc"><?php echo lang('new picture notice') ?></p>
<?php } // if ?>
  </div>
  
  <?php echo submit_button(lang('update picture')) ?>
  
</form>