<div style="padding:10px">
<?php $project = active_project();
	$description = active_project()->getDescription();
	if (active_project()->getShowDescriptionInOverview() && $description != ''){?>
	<div class='endSeparatorDiv'>
		<?php echo nl2br(clean($description));?>
	</div>
<?php }	
	if (logged_user()->isMemberOfOwnerCompany()){
		$users = $project->getUsers(false); 
		if (count($users) > 1){
			?><div class='endSeparatorDiv'>
				<table><tr><td style='padding-right:10px'><b><?php echo lang('shared with') ?>:</b></td><td><?php
			$c = 0;
			//echo var_dump($users);
			foreach ($users as $user){
				if ($user instanceof User && $user->getId() != logged_user()->getId()){
					if ($c != 0)
						echo ',&nbsp';
					$c++;
					?><a href="<?php echo $user->getCardUrl()?>" class="internalLink coViewAction ico-user"><?php echo clean($user->getDisplayName()) ?></a><?php
				}
			}
			?></td></tr></table>
			</div>
<?php }} ?>	

<table><?php if ($project->getCreatedBy() instanceof User){ ?>
		<tr><td><?php echo lang('created by') ?>:</td>
		<td style="padding-left:10px"><?php 
				if (logged_user()->getId() == $project->getCreatedById())
					$username = lang('you');
				else
					$username = clean($project->getCreatedByDisplayName());

				if ($project->getCreatedOn()->isToday()){
					$datetime = format_time($project->getCreatedOn());
					echo lang('user date today at', $project->getCreatedByCardUrl(), $username, $datetime, clean($project->getCreatedByDisplayName()));
				} else {
					$datetime = format_datetime($project->getCreatedOn(), lang('date format'), logged_user()->getTimezone());
					echo lang('user date', $project->getCreatedByCardUrl(), $username, $datetime, clean($project->getCreatedByDisplayName()));
				}
			 ?></td></tr>
	<?php } 
		if ($project->getUpdatedBy() instanceof User){ ?>
		<tr><td><?php echo lang('modified by') ?>:</td>
		<td style="padding-left:10px"><?php 
				if (logged_user()->getId() == $project->getUpdatedById())
					$username = lang('you');
				else
					$username = clean($project->getUpdatedByDisplayName());

				if ($project->getUpdatedOn()->isToday()){
					$datetime = format_time($project->getUpdatedOn());
					echo lang('user date today at', $project->getUpdatedByCardUrl(), $username, $datetime, clean($project->getUpdatedByDisplayName()));
				} else {
					$datetime = format_datetime($project->getUpdatedOn(), lang('date format'), logged_user()->getTimezone());
					echo lang('user date', $project->getUpdatedByCardUrl(), $username, $datetime, clean($project->getUpdatedByDisplayName()));
				}
			 ?></td></tr>
	<?php } ?>
	<tr><td colspan="2"><a target="_blank" class="link-ico ico-rss" href="<?php echo get_url('feed', 'project_activities', array('id' => logged_user()->getId(), 'token' => logged_user()->getTwistedToken(), 'project' => $project->getId())) ?>"><?php echo lang("recent project activities feed", clean($project->getName()))?></a></td></tr>
</table>
</div>