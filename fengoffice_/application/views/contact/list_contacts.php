<?php add_stylesheet_to_page('admin/user_list.css') ?>
<?php if(isset($contacts) && is_array($contacts) && count($contacts)) { ?>
<div id="contactsList">
<?php $counter = 0; ?>
<?php foreach($contacts as $contact) { ?>
<?php $counter++; ?>
  <div class="listedContact <?php echo $counter % 2 ? 'even' : 'odd' ?>">
    <div class="contactPicture"><img src="<?php echo $contact->getPictureUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> <?php echo lang('picture') ?>" /></div>
    <div class="contactDetails">
      <div class="contactName"><a class="internalLink" href="<?php echo $contact->getCardUrl() ?>"><?php echo clean($contact->getDisplayName()) ?></a></div>
<?php
  $options = array();
  if($contact->canEdit(logged_user())) {
    $options[] = '<a class="internalLink" href="' . $contact->getEditUrl($company->getViewUrl()) . '">' . lang('update contact') . '</a>';
    $options[] = '<a class="internalLink" href="' . $contact->getUpdatePictureUrl($company->getViewUrl()) . '">' . lang('update picture') . '</a>';
  } // if
  if($contact->canDelete(logged_user())) {
    $options[] = '<a class="internalLink" href="' . $contact->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete contact') . '\')">' . lang('delete') . '</a>';
  } // if
?>
      <div class="contactOptions"><?php echo implode(' | ', $options) ?></div>
      <div class="clear"></div>
    </div>
  </div>  
<?php } // foreach ?>
</div>

<?php } else { ?>
<p><?php echo lang('no contacts in company') ?></p>
<?php } // if ?>