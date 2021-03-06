<?php
  if($account->canEdit(logged_user())) {
    add_page_action(lang('edit mail account', $account->getName()), $account->getEditUrl());
  } // if
?>

<?php
if(isset($emails)) { 
?>
<div id="divEmails">
<table>
<tr>
    <th style="width:18px"></th>
    <th style="width:18px"></th>
	<th style="width:300px"><?php echo lang('subject') ?></th>
	<th style="width:224px"><?php echo lang('from') ?></th>
	<th style="width:90px"><?php echo lang('date') ?></th>
</tr>
<?php foreach($emails as $email) { ?> 
	<tr>
		<td><?php if (!$email->getIsClassified()) {?>
			<a class="internalLink" href="<?php echo $email->getClassifyUrl() ?>" title="<?php echo lang('classify') ?>">
			<img src="<?php echo get_image_url('icons/classify.png')?>"/></a><?php } ?>
		</td>
		<td><?php if ($email->getHasAttachments()) {?>
			<img class="menu_place_ico" src="<?php echo get_image_url('icons/attach.png')?>"/><?php } ?>
		</td>
		<td style="padding-left:4px">
    		<div><a class="internalLink" href="<?php echo $email->getViewUrl() ?>"><?php echo clean($email->getSubject()) ?></a></div>
    	</td>
		<td style="padding-left:4px">
    		<div><?php echo MailUtilities::displayMultipleAddresses($email->getFrom()); ?></div>
    	</td>
		<td style="padding-left:4px">
    		<div><?php echo clean($email->getSentDate()->format('d M - H:i')) ?></div>
    	</td>
    </tr>
<?php } // foreach ?>
</table>
<div id="emailsPaginationBottom"><?php echo advanced_pagination($emails_pagination, get_url('email', 'view_account', array('page' => '#PAGE#', 'id' => $account->getId()))) ?></div>
  </div>
<?php } else { ?>
<p><?php echo clean(lang('no emails in this account')) ?></p>
<?php } // if ?>