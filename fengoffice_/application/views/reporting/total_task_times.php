<?php
	
	function total_task_times_print_group($group_obj, $grouped_objects, $options, $skip_groups = array(), $level = 0, $prev = "", &$total = 0) {
		
		$margin_left = 15 * $level;
		$cls_suffix = $level > 2 ? "all" : $level;
		$next_level = $level + 1;
			
		$group_name = $group_obj['group']['name'];
		echo '<div style="margin-left:' . $margin_left.'px;" class="report-group-heading-'.$cls_suffix.'">' . $group_name . '</div>';
		
		$mem_index = $prev . $group_obj['group']['id'];
		
		$group_total = 0;
		
		$table_total = 0;
		// draw the table for the values
		if (isset($grouped_objects[$mem_index]) && count($grouped_objects[$mem_index]) > 0) {
			total_task_times_print_table($grouped_objects[$mem_index], $margin_left, $options, $group_name, $table_total);
			$group_total += $table_total;
		}
		
		if (!is_array($group_obj['subgroups'])) return;
		
		$subgroups = order_groups_by_name($group_obj['subgroups']);
		
		foreach ($subgroups as $subgroup) {
			$sub_total = 0;
			total_task_times_print_group($subgroup, $grouped_objects, $options, $skip_groups, $next_level, $prev . $group_obj['group']['id'] . "_", $sub_total);
			$group_total += $sub_total;
		}
		
		$total += $group_total;
		
		echo '<div style="margin-left:' . $margin_left . 'px;" class="report-group-footer">' . $group_name .
			'<div style="float:right" class="bold">' . lang('total'). ': ' . DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($group_total * 60), "hm", 60) . '</div></div>';
	}
	
	
	function total_task_times_print_table($objects, $left, $options, $group_name, &$sub_total = 0) {
		
		echo '<div style="padding-left:'. $left .'px;">';
		echo '<table class="report-table"><tr class="report-table-heading">';
		echo '<th>' . lang('date') . '</th>';
		echo '<th>' . lang('title') . '</th>';
		echo '<th>' . lang('description') . '</th>';
		echo '<th>' . lang('person') . '</th>';
		echo '<th class="right">' . lang('time') . '</th>';
		echo '</tr>';
		
		$sub_total = 0;
		
		$alt_cls = "";
		foreach ($objects as $ts) {
			echo "<tr $alt_cls>";
			echo "<td class='date'>" . format_date($ts->getStartTime()) . "</td>";
			echo "<td class='name'>" . ($ts->getRelObjectId() == 0 ? clean($ts->getObjectName()) : clean($ts->getRelObject()->getObjectName())) ."</td>";
			echo "<td class='name'>" . clean($ts->getDescription()) ."</td>";
			echo "<td class='person'>" . clean($ts->getUser()->getObjectName()) ."</td>";
			$lastStop = $ts->getEndTime() != null ? $ts->getEndTime() : ($ts->isPaused() ? $ts->getPausedOn() : DateTimeValueLib::now());
			echo "<td class='time nobr right'>" . DateTimeValue::FormatTimeDiff($ts->getStartTime(), $lastStop, "hm", 60, $ts->getSubtract()) ."</td>";
			echo "</tr>";
			
			$sub_total += $ts->getMinutes();
			$alt_cls = $alt_cls == "" ? 'class="alt-row"' : "";
		}
		
		echo '</table></div>';
	}
		
	foreach ($context as $selected_member) {
		/* var Member $selected_member */
		if ($selected_member instanceof Member) {
			$ot = ObjectTypes::findById($selected_member->getObjectTypeId());
			$dimension_filters[lang($ot->getName())] = $selected_member->getName();
		}
	}
	
	$dimension_filters = array();
	$skip_groups = array();
	$context = active_context();
	foreach ($context as $selection) {
		if ($selection instanceof Member) {
			$sel_parents = $selection->getAllParentMembersInHierarchy();
			foreach ($sel_parents as $sp) $skip_groups[] = $sp->getId();
			
			$ot = ObjectTypes::findById($selection->getObjectTypeId());
			$dimension_filters[lang($ot->getName())] = $selection->getName();
		}
	}
	
	foreach ($dimension_filters as $type => $name) { ?>
		<div><span class="bold"><?php echo $type ?>:</span><span style="margin-left:5px;"><?php echo $name ?></span></div>
	<?php }

	if ($start_time) { ?>
		<span class="bold"><?php echo lang('from')?></span>:&nbsp;<?php echo format_date($start_time) ?>
	<?php }
	if ($end_time) { ?>
		<span class="bold" style="padding-left:10px"><?php echo lang('to')?></span>:&nbsp;<?php echo format_date($end_time) ?>
	<?php } ?>
	
	<?php if ($user instanceof Contact) { ?>
		<br />
		<span class="bold"><?php echo lang('reporting user')?></span>:&nbsp;<?php echo clean($user->getObjectName()); ?>
	<?php }	?>
		
	
	<div class="timeslot-report-container"><?php
	
	$groups = order_groups_by_name($grouped_timeslots['groups']);
	$total = 0;
	foreach ($groups as $gid => $group_obj) {
		total_task_times_print_group($group_obj, $grouped_timeslots['grouped_objects'], array_var($_SESSION, 'total_task_times_parameters'), $skip_groups, 0, "", $total);
	}

	?>
		<div class="report-group-footer" style="margin-top:10px;">
			<div style="float:right" class="bold"><?php echo lang('total'). ': ' . DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($total * 60), "hm", 60) ?></div>
		</div>
	</div><?php
	
	
