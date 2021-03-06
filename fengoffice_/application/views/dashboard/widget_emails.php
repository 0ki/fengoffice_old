<div style="padding:10px">
<table id="dashTableEmails" style="width:100%">
<?php $c = 0;
	$emails = $unread_emails?$unread_emails:$ws_emails;
	foreach ($emails as $email){ 
		if (!$email->getIsDeleted()) {
			$c++;?>
			<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMUC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
			<td class="db-ico ico-email"></td>
			<td style="padding-left:5px">
			<?php 
				$mws = $email->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
				$projectLinks = array();
				foreach ($mws as $ws) {
					$projectLinks[] = $ws->getId();
				}
				echo  '<span class="project-replace">' . implode(',',$projectLinks) . '</span>';  //Commented as unread emails are not yet assignable to workspaces*/?>
			<a class="internalLink" style="font-weight:bold" href="<?php echo get_url('mail','view', array('id' => $email->getId()))?>"
				title="">
			<?php echo clean($email->getSubject()) ?>
			</a><br/><table width="100%" style="color:#888"><tr><td><?php echo clean($email->getFrom())?></td><td align=right><?php echo $email->getSentDate()->isToday() ? format_time($email->getSentDate()) : format_date($email->getSentDate())?></td></tr></table></td></tr>
	<?php } // if?>
<?php } // foreach?>
	<?php if ($c >= 10) {?>
		<tr class="dashSMUC" style="display:none"><td></td>
		<td style="text-align:right"><a href="#" onclick="Ext.getCmp('tabs-panel').activate('mails-panel');"><?php echo lang('show all') ?>...</a>
		</td></tr>
	<?php } ?>
</table>
<?php if ($c > 5) { ?>
<div id="dashSMUT" style="width:100%;text-align:right">
	<a href="#" onclick="og.hideAndShowByClass('dashSMUT', 'dashSMUC', 'dashTableEmails'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
</div>
<?php } // if ?>
</div>