<?php $file = $object;
	$revisions = $file->getRevisions();
	$last_revision = $file->getLastRevision();
	$genid = gen_id();
	
	if(($file->getDescription())) { ?>
      <div id="fileDescription"><?php echo convert_to_links(nl2br(clean($file->getDescription()))) ?></div>
<?php } // if ?>

<?php if($file->isCheckedOut()) { ?>
	<div id="fileCheckedOutBy">
	<?php if($file->getCheckedOutBy() instanceof User) { ?>
      <?php echo lang('file checkout info long', $file->getCheckedOutBy()->getCardUrl(), clean($file->getCheckedOutBy()->getDisplayName()), format_descriptive_date($file->getCheckedOutOn()). ", " . format_time($file->getCheckedOutOn())); ?>
<?php } else { ?>
      <?php echo lang('file checkout info short', format_descriptive_date($file->getCheckedOutOn()). ", " . format_time($file->getCheckedOutOn())) ?>
<?php } // if ?>
	</div>
<?php } ?>


<?php if ($file->isDisplayable()) {?>
<iframe style="width:100%;height:200px;border:1px solid #ddd;" src="<?php echo get_url("files", "display_content", array("id" => $file->getId())) ?>"></iframe>
<?php } // if ?> 

<?php if(($ftype = $file->getFileType()) instanceof FileType && $ftype->getIsImage()){?>
	<div>
		<a href="<?php echo get_url('files', 'download_image', array('id' => $file->getId(), 'inline' => true)); ?>" target="_blank" title="<?php echo lang('show image in new page') ?>">
			<img id="<?php echo $genid ?>Image" src="<?php echo get_url('files', 'download_image', array('id' => $file->getId(), 'inline' => true)); ?>" style="max-width:450px;max-height:500px"/>
		</a>
	</div>
<?php }?>

<fieldset>
  <legend class="toggle_collapsed" onclick="og.toggle('revisions',this)"><?php echo lang('revisions'); ?> (<?php echo count($revisions);?>)</legend>
<div id="revisions" style="display:none">
<table class="revisions">
<?php  $counter = 0;
	foreach($revisions as $revision) { 
		$hasComments = trim($revision->getComment());
		$counter++; 
		$bgColor = $counter % 2 ? ($counter == 1? '#FFD39F' : '#DDD') : '#EEE';
?>
	<tr>
		<td rowspan=2 class='number' style="background-color:<?php echo $bgColor ?>">
			<?php if ($file->canDownload(logged_user())){?>
				<a class="downloadLink" href="<?php echo $revision->getDownloadUrl() ?>" title="<?php echo lang('download') . ' (' . format_filesize($revision->getFileSize()) .')'?>">
					<span style="font-size:12px">#</span><?php echo $revision->getRevisionNumber() ?>
				</a>
			<?php } else {?>
				<span style="font-size:12px">#</span><?php echo $revision->getRevisionNumber() ?>
			<?php } // if ?>
		</td>
		<td class='line_header' style="background-color:<?php echo $bgColor ?>;">
			<?php if($revision->getCreatedBy() instanceof User) { ?>
			    <?php echo lang('file revision title long', $revision->getCreatedBy()->getCardUrl(), clean($revision->getCreatedBy()->getDisplayName()), format_datetime($revision->getCreatedOn())) ?>
			<?php } else { ?>
			    <?php echo lang('file revision title short', format_datetime($revision->getCreatedOn())) ?>
			<?php } // if ?>
		</td>
		<td class='line_header_icons' style="background-color:<?php echo $bgColor ?>;">
			<?php if ($file->canDownload(logged_user())){?>
				<a class="downloadLink coViewAction ico-download" href="<?php echo $revision->getDownloadUrl() ?>" title="<?php echo lang('download') . ' (' . format_filesize($revision->getFileSize()) .')'?>">&nbsp;</a>
			<?php } ?>
			<?php if ($file->canDelete(logged_user()) && !$file->isTrashed()) {?>
				<a onclick="return confirm('<?php echo escape_single_quotes(lang('confirm move to trash'))?>')" href="<?php echo $revision->getDeleteUrl() ?>" class="internalLink coViewAction ico-trash" title="<?php echo lang('move to trash')?>"></a>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td class='line_comments'>
			<div style="padding:2px;padding-left:6px;padding-right:6px;min-height:24px;">
		<?php if($hasComments) {?>
			 <?php echo nl2br(clean($revision->getComment()))?>
		<?php } ?>
			&nbsp;</div>
		</td>
		<td class="line_comments_icons">
			<?php if ($file->canEdit(logged_user()) && !$file->isTrashed()){?>
				<a href="<?php echo $revision->getEditUrl() ?>" class="internalLink coViewAction ico-edit" title="<?php echo lang('edit revision comment')?>"></a>
			<?php }?>
		</td>
	</tr>
<?php } // foreach ?>
</table>
</div>
</fieldset>

<?php if(($ftype = $file->getFileType()) instanceof FileType && $ftype->getIsImage()){?>
	<script type="text/javascript">
	function resizeImage(genid){
		var image = document.getElementById(genid + 'Image');
		if (image){
			var width = (Ext.isIE)? image.parentNode.parentNode.offsetWidth : image.parentNode.parentNode.clientWidth;
			
			image.style.maxWidth = (width - 20) + "px";
			image.style.maxHeight = (width - 20) + "px";
		}
	}
	resizeImage('<?php echo $genid ?>');
	function resizeSmallImage(genid){
		var image = document.getElementById(genid + 'Image');
		if (image){
			image.style.maxWidth = "1px";
			image.style.maxHeight = "1px";
		}
	}
	function resizeImage<?php echo $genid ?>(){
		resizeSmallImage('<?php echo $genid ?>');
		setTimeout('resizeImage("<?php echo $genid ?>")',50);
	}
	og.addDomEventHandler(window, 'resize', resizeImage<?php echo $genid ?>);
	</script>
<?php } ?>
