<?php
$options = array();

	if ($file->isCheckedOut()){
		if ($file->canCheckin(logged_user()))
			add_page_action(lang('checkin file'), $file->getCheckinUrl(), 'ico-checkin'); 
	} else {
		if ($file->canCheckout(logged_user())) 
			add_page_action(lang('checkout file'), $file->getCheckoutUrl(), 'ico-checkout');
	}
	
	if($file->canDownload(logged_user())) 
		add_page_action(lang('download') . ' (' . format_filesize($file->getFilesize()) . ')', $file->getDownloadUrl(), 'ico-download', "_blank");
	
	if($file->canEdit(logged_user()))
		add_page_action(lang('file properties'), $file->getEditUrl(), 'ico-properties');
	
	if($file->canDelete(logged_user())) 
		add_page_action(lang('delete'), $file->getDeleteUrl(), 'ico-delete');
	
	if (strcmp($file->getTypeString(),'txt')==0 || strcmp($file->getTypeString(),'sprd')==0 || strcmp($file->getTypeString(),'prsn')==0 || substr($file->getTypeString(), 0, 4) == "text") 
		add_page_action(lang('edit'), $file->getModifyUrl(), 'ico-edit');
		
	if (strcmp($file->getTypeString(), 'prsn')==0) {
		add_page_action(lang('slideshow'), "javascript:og.slideshow(".$file->getId().")", 'ico-slideshow');
	}

// Arreglar el slideshow!!!!
//	if(strcmp($file->getTypeString(),'prsn')==0 ) 
//		add_page_action($options[] = '<a href="javascript:og.slideshow(' . 	$file->getId()	. ')">' . lang('slideshow') . '</a>';

  //add_javascript_to_page('file/slideshow.js');
?>
<div style="padding:7px">
<div class="file">
<div class="coContainer">
  <div class="coHeader">
  <div class="coHeaderUpperRow">
	<?php if($file->isPrivate()) { ?>
  	<div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
	<?php } // if ?>
  <div class="coTitle"><?php echo clean($file->getFilename()) ?></div>
  <div class="coTags"><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($file) ?></div>
  </div>
  
  <div class="coInfo">
  <?php if($last_revision instanceof ProjectFileRevision) { ?>
      <div id="fileLastRevision"><span class="propertyName"><?php echo lang('last revision') ?>:</span> 
<?php if($last_revision->getCreatedBy() instanceof User) { ?>
      <?php echo lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), $last_revision->getCreatedBy()->getDisplayName(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } else { ?>
      <?php echo lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } // if ?>
      </div>
<?php } // if ?>
  </div>
  </div>
  
  
  
  <div class="coMainBlock">
  <div class="coLinkedObjects">
  <?php echo render_object_links($file, $file->canEdit(logged_user())) ?>
  </div>
  <div class="coContent">
  
  <table><tr><td>
    <div id="fileIcon"><img src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getFilename() ?>" /></div></td>
    <td style="padding-left:10px;"><div id="fileInfo">
<?php if(($file->getDescription())) { ?>
      <div id="fileDescription"><?php echo do_textile($file->getDescription()) ?></div>
<?php } // if ?>

<?php if($file->isCheckedOut()) { ?>
	<div id="fileCheckedOutBy">
	<?php if($file->getCheckedOutBy() instanceof User) { ?>
      <?php echo lang('file checkout info long', $file->getCheckedOutBy()->getCardUrl(), $file->getCheckedOutBy()->getDisplayName(), format_descriptive_date($file->getCheckedOutOn()). ", " . format_time($file->getCheckedOutOn())); ?>
<?php } else { ?>
      <?php echo lang('file checkout info short', format_descriptive_date($file->getCheckedOutOn()). ", " . format_time($file->getCheckedOutOn())) ?>
<?php } // if ?>
<?php } ?>
    </td></tr></table>
  </div>
  <div style="clear:both">
  <fieldset>
  <legend class="toggle_collapsed" onclick="og.toggle('revisions',this)"><?php echo lang('revisions'); ?> (<?php echo count($revisions);?>)</legend>
<div id="revisions" style="display:none">
<?php $counter = 0; ?>
<?php foreach($revisions as $revision) { ?>
<?php $counter++; ?>
  <div class="revision <?php echo $counter % 2 ? 'even' : 'odd' ?> <?php echo $counter == 1 ? 'lastRevision' : '' ?>" id="revision<?php echo $revision->getId() ?>">
    <div class="revisionName">
<?php if($revision->getCreatedBy() instanceof User) { ?>
    <?php echo lang('file revision title long', $revision->getDownloadUrl(), $revision->getRevisionNumber(), $revision->getCreatedBy()->getCardUrl(), $revision->getCreatedBy()->getDisplayName(), format_datetime($revision->getCreatedOn())) ?>
<?php } else { ?>
    <?php echo lang('file revision title short', $revision->getDownloadUrl(), $revision->getRevisionNumber(), format_datetime($revision->getCreatedOn())) ?>
<?php } // if ?>
    </div>
<?php if(trim($revision->getComment())) { ?>
    <div class="revisionComment"><?php echo do_textile($revision->getComment()) ?></div>
<?php } // if ?>
<?php 
  $options = array();
  if($revision->canDownload(logged_user())) $options[] = '<a target="_blank" href="' . $revision->getDownloadUrl() . '" class="downloadLink">' . lang('download') . ' <span>(' . format_filesize($revision->getFileSize()) . ')</span></a>';
  if($revision->canEdit(logged_user())) $options[] = '<a class="internalLink" href="' . $revision->getEditUrl() . '">' . lang('edit') . '</a>';
  if($revision->canDelete(logged_user())) $options[] = '<a class="internalLink" href="' . $revision->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete revision') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($revisions)) { ?>
    <div class="revisionOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
<?php } // foreach ?>
</div>
</fieldset>


<?php echo render_object_comments($file) ?>
  </div>
  
</div>
</div>
</div>