<?php $file = $object;
	$revisions = $file->getRevisions();
	$last_revision = $file->getLastRevision();
	$genid = gen_id(); ?>

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
	</div>
<?php } ?>


<?php if ($file->isDisplayable()) {?>
	<fieldset><legend class="toggle_collapsed" onclick="og.toggle('<?php echo $genid ?>file_contents',this)"><?php echo lang('file contents') ?></legend>
	<div id="<?php echo $genid ?>file_contents" style="display:none">
		<?php if ($file->getTypeString() == "text/html"){
			echo $file->getFileContent();
		} else {
			$filecontent = $file->getFileContent();
			echo nl2br(htmlEntities(iconv(mb_detect_encoding($filecontent, array('UTF-8','ISO-8859-1')),'UTF-8',$filecontent), null, 'UTF-8'));
}?></div>
	</fieldset><br/>
<?php } // if ?> 
	
    
    <fieldset>
  <legend class="toggle_expanded" onclick="og.toggle('revisions',this)"><?php echo lang('revisions'); ?> (<?php echo count($revisions);?>)</legend>
<div id="revisions">
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
  if($file->canDownload(logged_user())) $options[] = '<a href="' . $revision->getDownloadUrl() . '" class="downloadLink">' . lang('download') . ' <span>(' . format_filesize($revision->getFileSize()) . ')</span></a>';
  if($file->canEdit(logged_user())) $options[] = '<a class="internalLink" href="' . $revision->getEditUrl() . '">' . lang('edit') . '</a>';
  if($file->canDelete(logged_user())) $options[] = '<a class="internalLink" href="' . $revision->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete revision') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($revisions)) { ?>
    <div class="revisionOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
<?php } // foreach ?>
</div>
</fieldset>