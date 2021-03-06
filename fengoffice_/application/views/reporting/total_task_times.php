<?php
	
	function total_task_times_print_group($group_obj, $grouped_objects, $options, $skip_groups = array(), $level = 0, $prev = "", &$total = 0, &$billing_total = 0) {
		
		$margin_left = 15 * $level;
		$cls_suffix = $level > 2 ? "all" : $level;
		$next_level = $level + 1;
			
		$group_name = $group_obj['group']['name'];
		echo '<div style="margin-left:' . $margin_left.'px;" class="report-group-heading-'.$cls_suffix.'">' . $group_name . '</div>';
		
		$mem_index = $prev . $group_obj['group']['id'];
		
		$group_total = 0;
		$group_billing_total = 0;
		
		$table_total = 0;
		$table_billing_total = 0;
		// draw the table for the values
		if (isset($grouped_objects[$mem_index]) && count($grouped_objects[$mem_index]) > 0) {
			total_task_times_print_table($grouped_objects[$mem_index], $margin_left, $options, $group_name, $table_total, $table_billing_total);
			$group_total += $table_total;
			$group_billing_total += $table_billing_total;
		}
		
		if (!is_array($group_obj['subgroups'])) return;
		
		$subgroups = order_groups_by_name($group_obj['subgroups']);
		
		foreach ($subgroups as $subgroup) {
			$sub_total = 0;
			$sub_total_billing = 0;
			total_task_times_print_group($subgroup, $grouped_objects, $options, $skip_groups, $next_level, $prev . $group_obj['group']['id'] . "_", $sub_total, $sub_total_billing);
			$group_total += $sub_total;
			$group_billing_total += $sub_total_billing;
		}
		
		$total += $group_total;
		$billing_total += $group_billing_total;
		
		
		echo '<div style="margin-left:' . $margin_left . 'px;" class="report-group-footer">' . $group_name;
		echo '<div style="float:right;width:140px;" class="bold right">' . DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($group_total * 60), "hm", 60) . '</div>';
		if (array_var($options, 'show_billing') == 'checked') {
			echo '<div style="float:right;" class="bold">' . config_option('currency_code', '$') . " " . number_format($billing_total, 2) . '</div>';
		}
		echo '</div>';
		
	}
	
	
	function total_task_times_print_table($objects, $left, $options, $group_name, &$sub_total = 0, &$sub_total_billing = 0) {
		
		echo '<div style="padding-left:'. $left .'px;">';
		echo '<table class="report-table"><tr class="report-table-heading">';
		echo '<th>' . lang('date') . '</th>';
		echo '<th>' . lang('title') . '</th>';
		echo '<th>' . lang('description') . '</th>';
		echo '<th>' . lang('person') . '</th>';
		if (array_var($options, 'show_billing') == 'checked') {
			echo '<th class="right">' . lang('billing') . '</th>';
		}
		echo '<th class="right">' . lang('time') . '</th>';
		echo '</tr>';
		
		$sub_total = 0;
		
		$alt_cls = "";
		foreach ($objects as $ts) { /* @var $ts Timeslot */
			echo "<tr $alt_cls>";
			echo "<td class='date'>" . format_date($ts->getStartTime()) . "</td>";
			echo "<td class='name'>" . ($ts->getRelObjectId() == 0 ? clean($ts->getObjectName()) : clean($ts->getRelObject()->getObjectName())) ."</td>";
			echo "<td class='name'>" . clean($ts->getDescription()) ."</td>";
			echo "<td class='person'>" . clean($ts->getUser()->getObjectName()) ."</td>";
			if (array_var($options, 'show_billing') == 'checked') {
				echo "<td class='nobr right'>" . config_option('currency_code', '$') . " " . number_format($ts->getFixedBilling(), 2) . "</td>";
				$sub_total_billing += $ts->getFixedBilling();
			}
			$lastStop = $ts->getEndTime() != null ? $ts->getEndTime() : ($ts->isPaused() ? $ts->getPausedOn() : DateTimeValueLib::now());
			echo "<td class='time nobr right'>" . DateTimeValue::FormatTimeDiff($ts->getStartTime(), $lastStop, "hm", 60, $ts->getSubtract()) ."</td>";
			echo "</tr>";
			
			$sub_total += $ts->getMinutes();
			$alt_cls = $alt_cls == "" ? 'class="alt-row"' : "";
		}
		
		echo '</table></div>';
	}
	
	$context = active_context();
	foreach ($context as $selected_member) {
		/* var Member $selected_member */
		if ($selected_member instanceof Member) {
			$ot = ObjectTypes::findById($selected_member->getObjectTypeId());
			$dimension_filters[lang($ot->getName())] = array('name' => $selected_member->getName(), 'icon' => $selected_member->getIconClass());
		}
	}
	
	$dimension_filters = array();
	$skip_groups = array();
	foreach ($context as $selection) {
		if ($selection instanceof Member) {
			$sel_parents = $selection->getAllParentMembersInHierarchy();
			foreach ($sel_parents as $sp) $skip_groups[] = $sp->getId();
			
			$ot = ObjectTypes::findById($selection->getObjectTypeId());
			$dimension_filters[lang($ot->getName())] = array('name' => $selection->getName(), 'icon' => $selection->getIconClass());
		}
	}
	
	foreach ($dimension_filters as $type => $filter) { ?>
		<div><span class="bold"><?php echo $type ?>:</span><span style="margin-left:10px;" class="coViewAction <?php echo $filter['icon']?>"><?php echo $filter['name'] ?></span></div>
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
	
	$total = 0;
	$billing_total = 0;
	
	$groups = order_groups_by_name($grouped_timeslots['groups']);
	foreach ($groups as $gid => $group_obj) {
		$tmp_total = 0;
		$tmp_billing_total = 0;
		total_task_times_print_group($group_obj, $grouped_timeslots['grouped_objects'], array_var($_SESSION, 'total_task_times_report_data'), $skip_groups, 0, "", $tmp_total, $tmp_billing_total);
		$total += $tmp_total;
		$billing_total += $tmp_billing_total;
	}

	?>
		<div class="report-group-footer" style="margin-top:20px;">
			<span class="bold" style="font-size:150%;"><?php echo lang('total').": "; ?></span>
			<div style="float:right;width:127px;" class="bold right"><?php echo DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($total * 60), "hm", 60) ?></div>
		<?php if (array_var(array_var($_SESSION, 'total_task_times_report_data'), 'show_billing') == 'checked') { ?>
			<div style="float:right;" class="bold"><?php echo config_option('currency_code', '$') . " " . number_format($billing_total, 2) ?></div>
		<?php }?>
		</div>
	</div><?php
	
	
