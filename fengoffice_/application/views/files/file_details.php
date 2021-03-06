<?php

  set_page_title($file->getFilename());
  project_tabbed_navigation(PROJECT_TAB_FILES);
  
  $files_crumbs = array(
    0 => array(lang('files'), get_url('files'))
  ); // array
/*  if($folder instanceof ProjectFolder) {
    $files_crumbs[] = array($folder->getName(), $folder->getBrowseUrl());
  } // if*/
  $files_crumbs[] = lang('file details');
  
  project_crumbs($files_crumbs);
  
//  if(ProjectFolder::canAdd(logged_user(), active_project())) {
//    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
//  } // if
//  
  add_stylesheet_to_page('project/files.css');
  add_javascript_to_page('file/slideshow.js');
?>
<div style="padding-left:10px; padding-right:10px">
<div id="fileDetails" class="block" >
<?php if($file->isPrivate()) { ?>
  <div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
<?php } // if ?>
  <div class="header"><?php echo clean($file->getFilename()) ?></div>
  <div class="content">
  <table><tr><td>
    <div id="fileIcon"><img src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getFilename() ?>" /></div></td>
    <td style="padding-left:10px; width:540px"><div id="fileInfo">
<?php if(($file->getDescription())) { ?>
      <div id="fileDescription"><?php echo do_textile($file->getDescription()) ?></div>
<?php } // if ?>
<!--
<?php if($folder instanceof ProjectFolder) { ?>
      <div id="fileFolder"><span class="propertyName"><?php echo lang('folder') ?>:</span> <a class="internalLink" href="<?php echo $folder->getBrowseUrl() ?>"><?php echo clean($folder->getName()) ?></a></div>
<?php } // if ?>
-->


<?php if($file->isCheckedOut()) { ?>
	<div id="fileCheckedOutBy">
	<?php if($file->getCheckedOutBy() instanceof User) { ?>
      <?php echo lang('file checkout info long', $file->getCheckedOutBy()->getCardUrl(), $file->getCheckedOutBy()->getDisplayName(), format_descriptive_date($file->getCheckedOutOn()). ", " . format_time($file->getCheckedOutOn())); ?>
<?php } else { ?>
      <?php echo lang('file checkout info short', format_descriptive_date($file->getCheckedOutOn()). ", " . format_time($file->getCheckedOutOn())) ?>
<?php } // if ?>
<?php } ?>


<?php if($last_revision instanceof ProjectFileRevision) { ?>
      <div id="fileLastRevision"><span class="propertyName"><?php echo lang('last revision') ?>:</span> 
<?php if($last_revision->getCreatedBy() instanceof User) { ?>
      <?php echo lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), $last_revision->getCreatedBy()->getDisplayName(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } else { ?>
      <?php echo lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } // if ?>
      </div>
<?php } // if ?>

      <div id="fileTags"><span class="propertyName"><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($file, $file->getProject()) ?></div>
<?php
$options = array();

	if ($file->isCheckedOut()){
		if ($file->canCheckin(logged_user())) $options[] = '<a class="internalLink" href="' . $file->getCheckinUrl() . '">' . lang('checkin file') . '</a>'; 
	} else {
		if ($file->canCheckout(logged_user())) $options[] = '<a href="' . $file->getCheckoutUrl() . '">' . lang('checkout file') . '</a>';
	}
	
if($file->canDownload(logged_user())) $options[] = '<a target="_blank" href="' . $file->getDownloadUrl() . '" class="downloadLink ">' . lang('download') . ' <span>(' . format_filesize($file->getFilesize()) . ')</span></a>';
if($file->canEdit(logged_user())) { $options[] = '<a class="internalLink" href="' . $file->getEditUrl() . '">' . lang('file properties') . '</a>'; }
if($file->canDelete(logged_user())) $options[] = '<a class="internalLink" href="' . $file->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete file') . '\')">' . lang('delete') . '</a>';
if(strcmp($file->getTypeString(),'txt')==0 || strcmp($file->getTypeString(),'sprd')==0 || strcmp($file->getTypeString(),'prsn')==0 ) 
$options[] = '<a class="internalLink" href="' . 	$file->getModifyUrl()	. '">' . lang('edit') . '</a>';
if(strcmp($file->getTypeString(),'prsn')==0 ) 
$options[] = '<a href="javascript:slideshow(\'' . 	$file->getSlideshowUrl()	. '\')">' . lang('slideshow') . '</a>';
?>
<?php if(count($options)) { ?>
        <div id="fileOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
    <?php if(isset($revisions) && is_array($revisions) && count($revisions)) { ?>

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
<?php } // if ?>

<?php echo render_object_comments($file) ?>
    </td></tr></table>
  </div>
  <div class="clear"></div>
</div>
</div>

