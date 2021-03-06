<?php //Functions
	function has_value($array, $value){
		foreach ($array as $val)
			if ($val == $value)
				return true;
		return false;
	}

	function has_difference($previousTSRow, $tsRow, $field){
		
		if (is_array($previousTSRow))
			$previousTS = $previousTSRow["ts"];
		$ts = $tsRow["ts"];
		
		return !isset($previousTS) || $previousTS == null ||
				($field == 'id' && $previousTS->getObject()->getId() != $ts->getObject()->getId()) ||
				($field == 'user_id' && $previousTS->getUserId() != $ts->getUserId()) ||
				($field == 'state' && $previousTS->getObject()->getState() != $ts->getObject()->getState()) ||
				($field == 'project_id_0' && $previousTSRow["wsId0"] != $tsRow["wsId0"]) ||
				($field == 'project_id_1' && $previousTSRow["wsId1"] != $tsRow["wsId1"]) ||
				($field == 'project_id_2' && $previousTSRow["wsId2"] != $tsRow["wsId2"]) ||
				($field == 'priority' && $previousTS->getObject()->getPriority() != $ts->getObject()->getPriority()) ||
				($field == 'milestone_id' && $previousTS->getObject()->getMilestoneId() != $ts->getObject()->getMilestoneId());
	}

	function getGroupTitle($field, $tsRow){
		$ts = $tsRow["ts"];
		switch($field){
			case 'id': return $ts->getObject()->getTitle();
			case 'user_id': return $ts->getUser()->getDisplayName();
			/*case 'state': 
				switch ($ts->getObject()->getState()){
					case 100: return lang('low priority');
					case 200: return lang('normal priority');
					case 300: return lang('high priority');
					default: return $ts->getObject()->getState();
				}*/
			case 'project_id_0': return $tsRow["wsId0"] != 0 ? Projects::findById($tsRow["wsId0"])->getName() : '';
			case 'project_id_1': return $tsRow["wsId1"] != 0 ? Projects::findById($tsRow["wsId1"])->getName() : '';
			case 'project_id_2': return $tsRow["wsId2"] != 0 ? Projects::findById($tsRow["wsId2"])->getName() : '';
			case 'priority' : 
				switch ($ts->getObject()->getPriority()){
					case 100: return lang('low priority');
					case 200: return lang('normal priority');
					case 300: return lang('high priority');
					default: return $ts->getObject()->getPriority();
				}
			case 'milestone_id': return $ts->getObject()->getMilestoneId() != 0? $ts->getObject()->getMilestone()->getTitle() : '';
		}
		return '';
	}
?>
<?php if ($start_time) { ?><span style="font-weight:bold"><?php echo lang('from')?></span>:&nbsp;<?php echo format_datetime($start_time, 'd/m/Y') ?><?php } // if ?>
<?php if ($end_time) { ?><span style="font-weight:bold; padding-left:10px"><?php echo lang('to')?></span>:&nbsp;<?php echo format_datetime($end_time, 'd/m/Y') ?><?php } // if ?>

<?php if(!isset($task_title)) 
	$task_title = null;
if ($task_title) { ?><div style="font-size:120%"><span style="font-weight:bold"><?php echo lang('title')?></span>:&nbsp;<?php echo $task_title ?></div> <?php } ?>

<br/><br/>
<?php if ($user instanceof User) { ?>
	<span style="font-weight:bold"><?php echo lang('user')?></span>:&nbsp;<?php echo $user->getDisplayName(); ?>
	<br/><br/>
<?php }	?>
<?php if ($workspace instanceof Project) { ?>
	<span style="font-weight:bold"><?php echo lang('workspace')?></span>:&nbsp;<?php echo $workspace->getName(); ?>
	<br/><br/>
<?php }	?>

<table style="min-width:564px">
<?php 
	if (!is_array($timeslotsArray) || count($timeslotsArray) == 0){?>
<tr><td colspan = 4><div style="font-size:120%; padding:10px;"><?php echo lang('no data to display') ?></div></td></tr>
<?php } else { 
	
	//Initialize
	$gbvals = array('','','');
	$sumTimes = array(0,0,0);
	$sectionDepth = is_array($group_by) ? count($group_by) : 0;
	$c = 0;
	for ($i = 0; $i < $sectionDepth; $i++)
		if ($group_by[$i] == 'project_id'){
			$group_by[$i] = 'project_id_' . $c;
			$c++;
		}
	$totCols = 5;
	$showUserCol = !has_value($group_by, 'user_id');
	$showTitleCol = !has_value($group_by, 'id');
	if (!$showUserCol) $totCols--;
	if (!$showTitleCol) $totCols--;
	
	$previousTSRow = null;
	foreach ($timeslotsArray as $tsRow)
	{
		$ts = $tsRow["ts"];
		$showHeaderRow = false;
		
		//Footers
		for ($i = $sectionDepth - 1; $i >= 0; $i--){
			$has_difference = false;
			for ($j = 0; $j <= $i; $j++)
				$has_difference = $has_difference || has_difference($previousTSRow,$tsRow, $group_by[$j]);
				
			if ($has_difference){
				if ($previousTSRow != null) {?>
<tr style="padding-top:2px;font-weight:bold;">
	<td style="padding:4px;border-top:2px solid #888;font-size:90%;color:#AAA;text-align:left;font-weight:normal"><?php echo getGroupTitle($group_by[$i], $previousTSRow) ?></td>
	<td colspan=<?php echo $totCols -1 ?> style="padding:4px;border-top:2px solid #888;text-align:right;"><?php echo lang('total') ?>:&nbsp;<?php echo DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($sumTimes[$i] * 60), "hm", 60) ?></td>
</tr></table></div></td></tr><?php 		}
				$sumTimes[$i] = 0;
				$isAlt = true;
			}
		}
		
		//Headers
		$has_difference = false;
		for ($i = 0; $i < $sectionDepth; $i++){
			$colspan = 3 - $i;
			$has_difference = $has_difference || has_difference($previousTSRow,$tsRow, $group_by[$i]);
			$showHeaderRow = $has_difference || $showHeaderRow;
			
			if ($has_difference){?>
			<tr><td colspan=<?php echo $totCols ?>><div style="width=100%;<?php echo $i > 0 ? 'padding-left:20px;padding-right:10px;' : '' ?>padding-top:10px;padding-bottom:5px;"><table style="width:100%">
<tr><td colspan=<?php echo $totCols ?> style="border-bottom:2px solid #888;font-size:<?php echo (150 - (15 * $i)) ?>%;font-weight:bold;">
	<?php echo getGroupTitle($group_by[$i], $tsRow) ?></td></tr>

<?php 		}
			$sumTimes[$i] += $ts->getMinutes();
		}
		
		$isAlt = !$isAlt;
		$previousTSRow = $tsRow;
		
		if ($showHeaderRow) {
		?><tr><th style="padding:4px;border-bottom:1px solid #666666"><?php echo lang('date') ?></th>
	<?php if ($showTitleCol) { ?><th style="padding:4px;border-bottom:1px solid #666666"><?php echo lang('task title') ?></th><?php } ?>
	<th style="padding:4px;border-bottom:1px solid #666666"><?php echo lang('description') ?></th>
	<?php if ($showUserCol) { ?><th style="padding:4px;border-bottom:1px solid #666666"><?php echo lang('user') ?></th><?php } ?>
	<th style="padding:4px;text-align:right;border-bottom:1px solid #666666"><?php echo lang('time') ?></th></tr><?php }
		
		//Print row info
?>
<tr>
	<td style="padding:4px;<?php echo $isAlt? 'background-color:#F2F2F2':'' ?>"><?php echo format_datetime($ts->getStartTime(), 'd/m/y')?></td>
	<?php if ($showTitleCol) { ?><td style="padding:4px;max-width:250px;<?php echo $isAlt? 'background-color:#F2F2F2':'' ?>"><?php echo $ts->getObject()->getTitle() ?></td><?php } ?>
	<td style="padding:4px; width:250px;<?php echo $isAlt? 'background-color:#F2F2F2':'' ?>"><?php echo $ts->getDescription() ?></td>
	<?php if ($showUserCol) { ?><td style="padding:4px;<?php echo $isAlt? 'background-color:#F2F2F2':'' ?>"><?php echo $ts->getUser()->getDisplayName() ?></td><?php } ?>
	<td style="padding:4px;text-align:right;<?php echo $isAlt? 'background-color:#F2F2F2':'' ?>"><?php echo DateTimeValue::FormatTimeDiff($ts->getStartTime(), $ts->getEndTime(), "hm", 60) ?>
</td></tr>
<?php } // foreach
} // if 

		for ($i = $sectionDepth - 1; $i >= 0; $i--){?>
<tr style="padding-top:2px;text-align:right;font-weight:bold;">
	<td style="padding:4px;border-top:2px solid #888;font-size:90%;color:#AAA;text-align:left;font-weight:normal"><?php echo getGroupTitle($group_by[$i], $previousTSRow) ?></td>
	<td colspan=<?php echo $totCols -1 ?> style="padding:4px;border-top:2px solid #888;text-align:right;"><?php echo lang('total') ?>:&nbsp;<?php echo DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($sumTimes[$i] * 60), "hm", 60) ?></td>
</tr></table></div></td></tr><?php }?>
</table>