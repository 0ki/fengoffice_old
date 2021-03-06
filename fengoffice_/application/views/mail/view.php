<?php
if($email->canDelete(logged_user())) {
    add_page_action(lang('delete email'), $email->getDeleteUrl(), 'db-ico-delete');
  }
  if ($email->canEdit(logged_user())){
    add_page_action(lang('classify'), $email->getClassifyUrl(), 'mm-ico-classify');
  }
  $c = 0;
?>

<?php if ($email instanceof MailContent) {?>
<div style="padding:7px">
<div class="email">
<div class="coContainer">
  <div class="coHeader">
  <div class="coHeaderUpperRow">
  <?php if($email->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private email') ?>"><span><?php echo lang('private email') ?></span></div>
<?php } // if ?>
	<div class="coTitle"><?php echo $email->getSubject() ?></div>
	<?php if (isset($project)) { ?>
		<div class="coTags"><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($email, $project) ?></div>
	<?php } ?>
  </div>
  <div class="coInfo">
	<table>
	<tr><td style="width:100px"><?php echo lang('from') ?>:</td><td><?php echo MailUtilities::displayMultipleAddresses($email->getFrom()); ?></td></tr>
	<tr><td><?php echo lang('to') ?>:</td><td><?php echo MailUtilities::displayMultipleAddresses($email->getTo()); ?></td></tr>
	<tr><td><?php echo lang('date') ?>:</td><td><?php echo $email->getSentDate()->format('D, d M Y H:i:s') ?></td></tr>
	<?php if (isset($project)) { ?><tr><td><?php echo lang('project') ?>:</td>
	<td><h2><?php echo $project->getName() ?></h2></td></tr><?php } ?>
	
	<?php if ($email->getHasAttachments()) {?>
	<tr><td colspan=2>
	<fieldset>
		<legend class="toggle_collapsed" onclick="og.toggle('mv_attachments',this)"><?php echo lang('attachments') ?></legend>
		<div id="mv_attachments" style="display:none">
		<table>
		<?php 
		    foreach($parsedEmail["Attachments"] as $att)
			{?>
				<tr>
				<td style="padding-right: 10px">
					<?php 
      					$ext = substr($att["FileName"],strrpos($att["FileName"],'.') + 1);
						$fileType = FileTypes::getByExtension($ext);
						if (isset($fileType))
							$icon = $fileType->getIcon();
						else
							$icon = "unknown.png";
      					?>
      					<img src="<?php echo get_image_url("filetypes/".$icon) ?>">
				</td>
				<td><a href="<?php echo get_url('mail', 'download_attachment', array('email_id' => $email->getId(), 'attachment_id' => $c)) ?>">
				<?php echo clean($att["FileName"]) ?></a></td>
				</tr><?php 	$c++;
			}?>
		</table>
		</div>
	</fieldset>
	</td></tr>
	<?php } //if?>
  </table>
  </div>
  </div>
  <div class="coMainBlock">
  <?php if (isset($project)) { ?>
  	<div class="coLinkedObjects">
  		<?php echo render_object_links($email, $email->canEdit(logged_user())) ?>
  	</div>
  <?php } ?>
  <div class="coContent">
  <?php if($email->getBodyHtml() != ''){
	echo $email->getBodyHtml();
} else {
	if ($email->getBodyPlain() != ''){
		echo do_textile($email->getBodyPlain());
	} else {
		echo do_textile($email->getContent());
	}
}
 ?>
  </div>
  
  </div>
  <div style="clear:both"></div>
</div>
</div>
<?php } else { echo lang('email not available'); } //if ?>
