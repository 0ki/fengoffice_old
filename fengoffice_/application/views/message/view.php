<?php
  if(!active_project() || (active_project() && ProjectMessage::canAdd(logged_user(), active_project()))) {
    add_page_action(lang('add message'), get_url('message', 'add'), 'mm-ico-message');
  } // if
  if($message->canEdit(logged_user())) {
  	add_page_action(lang('edit'), $message->getEditUrl(), 'ico-edit');
  } // if
  if($message->canDelete(logged_user())) {
  	add_page_action(lang('delete'), $message->getDeleteUrl(), 'ico-delete');
  } // if

?>

<div style="padding:7px">
<div class="message">
<div class="coContainer">
  <div class="coHeader">
  <div class="coHeaderUpperRow">
<?php if($message->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private message') ?>"><span><?php echo lang('private message') ?></span></div>
<?php } // if ?>
	<div class="coTitle"><?php echo $message->getTitle() ?></div>
	<div class="coTags"><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($message, $message->getProject()) ?></div>
	</div>
    <div class="coInfo">
    	<?php if($message->getCreatedBy() instanceof User) { ?>
    		<?php echo lang('message posted on by', format_datetime($message->getCreatedOn()), $message->getCreatedBy()->getCardUrl(), clean($message->getCreatedBy()->getDisplayName())) ?>
		<?php } // if ?>
	</div>
  </div>
  <div class="coMainBlock">
  <div class="coLinkedObjects">
  <?php echo render_object_links($message, $message->canEdit(logged_user())) ?>
  </div>
  <div class="coContent">
    <?php echo do_textile($message->getText()) ?>
<?php if(trim($message->getAdditionalText())) { ?>
    <div class="messageSeparator"><?php echo lang('message separator') ?></div>
    <?php echo do_textile($message->getAdditionalText()) ?>
<?php } // if?>
  </div>
  
  </div>
  <div style="clear:both">
  <?php echo render_object_comments($message, $message->getViewUrl()) ?></div>

  
</div>
</div>