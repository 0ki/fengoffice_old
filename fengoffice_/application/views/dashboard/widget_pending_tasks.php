<div style="padding:10px">
<table id="dashTablePT" style="width:100%">
<?php
$c = 0;
foreach ($dashtasks as $task){
	$stCount = $task->countAllSubTasks();
	$c++;
	$text = $task->getText();
	if ($text != '')
		$text = ": " . $text;
	if(strlen_utf($text)>100)
		$text = substr_utf($text,0,100) . " ...";
	$text = clean($text);
	?>
		<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMTC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
		<td class="db-ico ico-task<?php echo $task->getPriority() == 300? '-high-priority' : ($task->getPriority() == 100? '-low-priority' : '') ?>"></td><td style="padding-left:5px;padding-bottom:2px">
	<?php 
	$dws = $task->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
	$projectLinks = array();
	foreach ($dws as $ws) {
		$projectLinks[] = $ws->getId();
	}
	echo '<span class="project-replace">' . implode(',',$projectLinks) . '</span>';?>
	<a class="internalLink" href="<?php echo $task->getViewUrl() ?>">
	<?php if($task->getAssignedTo() instanceof ApplicationDataObject) { ?>
	    <span style="font-weight:bold"> <?php echo clean($task->getAssignedTo()->getObjectName()) ?>: </span><?php echo clean($task->getTitle()) ?>
	<?php } else { ?>
	    <?php echo clean($task->getTitle()) ?>
	<?php } // if ?>
	</a></td>
	<td><?php if ($stCount > 0) echo "(" . lang('subtask count all open', $stCount, $task->countOpenSubTasks()) . ')'?></td>
	<td><?php if (!is_null($task->getDueDate())){
		if ($task->getRemainingDays() >= 0)
			if ($task->getRemainingDays() == 0)
				echo lang('due today');
			else
				echo lang('due in x days', $task->getRemainingDays());
		else
			echo lang('overdue by x days', -$task->getRemainingDays());
		}?></td>
	<td style="text-align:right"><a class='internalLink' href='<?php echo $task->getCompleteUrl() ?>' title="<?php echo lang('complete task')?>"><?php echo lang('do complete')?></a></td>
	</tr>
<?php } // foreach ?>
</table>
<?php if ($c > 5) { ?>
<div id="dashSMTT" style="width:100%; text-align:right">
	<a href="#" onclick="og.hideAndShowByClass('dashSMTT', 'dashSMTC', 'dashTablePT'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
</div>
<?php } //if ?>
</div>