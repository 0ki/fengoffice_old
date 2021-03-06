<?php

  set_page_title(lang('emails'));
  project_crumbs(lang('emails'));
  
  $c = 0;
  
?>

<?php
if($emails) { 
?>
<div id="divEmails">
<table>
<tr>
    <th style="width:120px"><?php echo lang('user') ?></th>
    <th style="width:18px"></th>
	<th style="width:300px"><?php echo lang('subject') ?></th>
	<th style="width:224px"><?php echo lang('from') ?></th>
	<th style="width:90px"><?php echo lang('date') ?></th>
</tr>
<?php foreach($emails as $email) { 
	$email_owner = $email->getAccount()->getOwner();
	?> 
	<tr>
	    <td>
	    	<a class="internalLink" href="<?php echo $email_owner->getCardUrl() ?>" title="<?php echo $email->getAccount()->getEmail() ?>"><?php echo $email_owner->getDisplayName() ?></a>
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
<div id="emailsPaginationBottom"><?php echo advanced_pagination($emails_pagination, get_url('email', 'index_project', array('page' => '#PAGE#'))) ?></div>
  </div>
<?php } else { ?>
<p><?php echo clean(lang('no emails in this project')) ?></p>
<?php } // if ?>