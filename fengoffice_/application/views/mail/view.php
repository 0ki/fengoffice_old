<?php
  set_page_title(lang('email message').': '.$email->getSubject());
  
  if($email->canDelete(logged_user())) {
    add_page_action(array(lang('delete email')  => $email->getDeleteUrl()));
  }

  if ($email->canEdit(logged_user())){
    add_page_action(array(lang('classify')  => $email->getClassifyUrl()));
  }
  $c = 0;
?>

<?php if ($email instanceof MailContent) {?>
<h2><?php echo $email->getSubject() ?></h2>
<table>
	<tr><td style="width:100px"><?php echo lang('from') ?>:</td><td><?php echo MailUtilities::displayMultipleAddresses($email->getFrom()); ?></td></tr>
	<tr><td><?php echo lang('to') ?>:</td><td><?php echo MailUtilities::displayMultipleAddresses($email->getTo()); ?></td></tr>
	<tr><td><?php echo lang('date') ?>:</td><td><?php echo $email->getSentDate()->format('D, d M Y H:i:s') ?></td></tr>
	<?php if (isset($project)) { ?><tr><td><?php echo lang('project') ?>:</td>
	<td><h2><?php echo $project->getName() ?></h2></td></tr><?php } ?>
	
	<?php if ($email->getHasAttachments()) {?>
	<tr><td colspan=2>
	<fieldset>
		<legend><?php echo lang('attachments') ?></legend>
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
	</fieldset>
	</td></tr>
	<?php } //if?>
</table>
<hr/>
<div id="emailBody" class="">
<?php if($email->getBodyHtml() != ''){
	echo $email->getBodyHtml();
} else {
	if ($email->getBodyPlain() != ''){
		echo "<pre>". clean($email->getBodyPlain()) . "</pre>";
	} else {
		echo "<pre>". clean($email->getContent()) . "</pre>";
	}
}
 ?>
<?php } else { echo lang('email not available'); } //if ?>
</div> 
