<div style="font-family: Verdana, Arial, sans-serif; font-size: 12px;">

	<?php echo "<a href='".$event->getViewUrl()."' target='_blank' style='font-size: 18px;'>".lang('event invitation response').': ' . $event->getSubject() . ' - ' . lang('date') . ': ' . $date . "</a>" ?><br><br>
	<br />
	<?php
		if ($invitation->getInvitationState() == 1)
			echo lang('user will attend to event', $from_user->getDisplayName());
		else if ($invitation->getInvitationState() == 2)
			echo lang('user will not attend to event', $from_user->getDisplayName());
	?>
	<br><br>
	
	<?php echo lang('workspace') ?>: <span style='<?php echo get_workspace_css_properties($workspace_color); ?>'>
	<?php echo $workspaces ?></span><br><br>
	<br><br>
	<div style="color: #818283; font-style: italic; border-top: 2px solid #818283; padding-top: 2px; font-family: Verdana, Arial, sans-serif; font-size: 12px;">
	<?php echo lang('system notification email'); ?><br>
	<a href="<?php echo ROOT_URL; ?>" target="_blank" style="font-family: Verdana, Arial, sans-serif; font-size: 12px;"><?php echo ROOT_URL; ?></a>
	</div>

</div>