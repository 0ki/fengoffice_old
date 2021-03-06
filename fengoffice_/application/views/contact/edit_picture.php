<?php
  set_page_title(lang('edit picture'));
  
  if($contact->canEdit(logged_user())) {
    add_page_action(lang('edit contact'), $contact->getEditUrl(), 'ico-edit');
	add_page_action(lang('assign to project'), $contact->getAssignToProjectUrl(), 'ico-workspace');
  } // if

?>

<form style='height:100%;background-color:white' action="<?php echo $contact->getUpdatePictureUrl($redirect_to) ?>" method="post" enctype="multipart/form-data" onsubmit="og.submit(this, {callback:{type:'back'}})">
  
<div class="avatar">
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
  
  <fieldset>
    <legend><?php echo lang('current picture') ?></legend>
<?php if($contact->hasPicture()) { ?>
    <img src="<?php echo $contact->getPictureUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> picture" />
    <p><a class="internalLink" href="<?php echo $contact->getDeletePictureUrl() ?>" onclick="return confirm('<?php echo escape_single_quotes(lang('confirm delete current picture')) ?>')"><?php echo lang('delete current picture') ?></a></p>
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
  
  <?php echo submit_button(lang('save')) ?>
 
 </div>
 </div>
</form>