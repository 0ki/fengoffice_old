<?php
	$genid = gen_id();
	$project_id = 0;
	$report_data = array_var($_SESSION, 'total_task_times_report_data', array());
	if (array_var($report_data, "project_id") != null) {
		$project_id = array_var($report_data, "project_id", 0);
	} else if (active_project() instanceof Project) {
		$project_id = active_project()->getId();
	}
	if (!array_var($report_data, 'date_type'))
		$report_data['date_type'] = 1;
?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo get_url('reporting', 'total_task_times') ?>" method="post" enctype="multipart/form-data">

<div class="reportTotalTimeParams">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
		<div class="coInputTitle"><?php echo lang('task time report') ?></div>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<div style="width:600px;padding-bottom:20px"><?php echo lang('task time report description') ?></div>

	<table>
		<tr style='height:30px;'>
			<td><b><?php echo lang("date") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				echo select_box('report[date_type]', array(
					option_tag(lang('today'),1, array_var($report_data, "date_type") == 1? array('selected' => 'selected'):null),
					option_tag(lang('this week'),2, array_var($report_data, "date_type") == 2? array('selected' => 'selected'):null),
					option_tag(lang('last week'),3, array_var($report_data, "date_type") == 3? array('selected' => 'selected'):null),
					option_tag(lang('this month'),4, array_var($report_data, "date_type") == 4? array('selected' => 'selected'):null),
					option_tag(lang('last month'),5, array_var($report_data, "date_type") == 5? array('selected' => 'selected'):null),
					option_tag(lang('select dates...'),6, array_var($report_data, "date_type") == 6? array('selected' => 'selected'):null)
				), array('onchange' => 'og.dateselectchange(this)'));
			?></td>
		</tr>
		<tr style='height:30px;'>
			<td><b><?php echo lang("timeslots") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				echo select_box('report[timeslot_type]', array(
					option_tag(lang('task timeslots'),0, array_var($report_data, "timeslot_type") == 0? array('selected' => 'selected'):null),
					option_tag(lang('time timeslots'),1, array_var($report_data, "timeslot_type") == 1? array('selected' => 'selected'):null),
					option_tag(lang('all timeslots'),2, array_var($report_data, "timeslot_type") == 2? array('selected' => 'selected'):null)
				), array('onchange' => 'og.timeslotTypeSelectChange(this, \'' . $genid . '\')'));
			?></td>
		</tr>
		<?php
			if (array_var($report_data, "date_type") == 6) {
				//echo var_dump($_SESSION); die();
				$style = "";
				$startval = explode('/', array_var($report_data, 'start_value'));
		       	$st = DateTimeValueLib::make(0, 0, 0, $startval[0], $startval[1], $startval[2]);
		       	$end = explode('/', array_var($report_data, 'end_value'));
		       	$et = DateTimeValueLib::make(23,59,59, $end[0], $end[1], $end[2]);
			} else {
				$style = 'display:none';
				$st = DateTimeValueLib::now();
				$et = $st;
			} 
		?>
		<tr class="dateTr"  style="<?php echo $style ?>">
			<td><b><?php echo lang("start date") ?>:&nbsp;</b></td>
			<td align='left'><?php echo pick_date_widget2('report[start_value]', $st, $genid);?></td>
		</tr>
		<tr class="dateTr"  style="<?php echo $style ?>">
			<td style="padding-bottom:18px"><b><?php echo lang("end date") ?>:&nbsp;</b></td>
			<td align='left'><?php echo pick_date_widget2('report[end_value]', $et, $genid);?></td>
		</tr>
		<tr style='height:30px;'>
			<td><b><?php echo lang("user") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				$options = array();
				$options[] = option_tag('-- ' . lang('anyone') . ' --', 0, array_var($report_data, "user") == null?array('selected' => 'selected'):null);
				foreach($users as $user){
					$options[] = option_tag($user->getDisplayName(),$user->getId(), array_var($report_data, "user") == $user->getId()?array('selected' => 'selected'):null);
				}
				echo select_box('report[user]', $options);
			?></td>
		</tr>
		<tr style='height:30px;'>
			<td><b><?php echo lang("workspace") ?>:&nbsp;</b></td>
			<td align='left'><table><tr><td>
				<?php echo select_project2('report[project_id]', $project_id, $genid, true);?></td><td style="padding-left:25px">
				<?php echo checkbox_field('report[include_subworkspaces]', array_var($report_data, "include_subworkspaces", true), array('id' => 'report[include_subworkspaces]' )) ?>
	      <label for="<?php echo 'report[include_subworkspaces]' ?>" class="checkbox"><?php echo lang('include subworkspaces') ?></label>
				</td></tr></table> 
			</td>
		</tr>
		<tr style='height:30px;' id="<?php echo $genid ?>repGroupBy">
			<td><b><?php echo lang("group by") ?>:&nbsp;</b></td>
			<td align='left'>
				<span id="<?php echo $genid ?>gbspan" style="<?php echo array_var($report_data, "timeslot_type") == 0 ? 'display:inline':'display:none' ?>">
					<?php for ($i = 1; $i <= 3; $i++){ 
						$gbVal = array_var($report_data, "group_by_$i");
						?>
					<select id="<?php echo $genid ?>group_by_<?php echo $i ?>" name="report[group_by_<?php echo $i ?>]" )">
						<option value="0"<?php if ($gbVal == null) echo ' selected="selected"' ?>>-- None --</option>
						<option value="id"<?php if ($gbVal == "id") echo ' selected="selected"' ?>><?php echo lang('task')?></option>
						<option value="user_id"<?php if ($gbVal == "user_id") echo ' selected="selected"' ?>><?php echo lang('user')?></option>
						<option value="project_id"<?php if ($gbVal == "project_id") echo ' selected="selected"' ?>><?php echo lang('workspace')?></option>
						<option value="priority"<?php if ($gbVal == "priority") echo ' selected="selected"' ?>><?php echo lang('priority')?></option>
						<option value="milestone_id"<?php if ($gbVal == "milestone_id") echo ' selected="selected"' ?>><?php echo lang('milestone')?></option>
					</select>
					<?php } // for ?>
				</span>
				<span id="<?php echo $genid ?>altgbspan" style="<?php echo array_var($report_data, "timeslot_type") == 0 ? 'display:none':'display:inline' ?>">
					<?php for ($i = 1; $i <= 3; $i++){ 
						$gbVal = array_var($report_data, "alt_group_by_$i");
						?>
					<select id="<?php echo $genid ?>alt_group_by_<?php echo $i ?>" name="report[alt_group_by_<?php echo $i ?>]" )">
						<option value="0"<?php if ($gbVal == null) echo ' selected="selected"' ?>>-- None --</option>
						<option value="user_id"<?php if ($gbVal == "user_id") echo ' selected="selected"' ?>><?php echo lang('user')?></option>
						<option value="project_id"<?php if ($gbVal == "project_id") echo ' selected="selected"' ?>><?php echo lang('workspace')?></option>
					</select>
					<?php } // for ?>
				</span>
			</td>
		</tr>
		<tr style='height:30px;'>
			<td>&nbsp;</td>
			<td align='left'>
				<?php echo checkbox_field('report[include_unworked]', array_var($report_data, 'include_unworked', false), array("id" => "report[include_unworked]")); ?> 
	      		<label for="<?php echo 'report[include_unworked]' ?>" class="checkbox"><?php echo lang('include unworked pending tasks') ?></label>
			</td>
		</tr>
	</table>
	
<br/>
<?php echo submit_button(lang('generate report'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?>
</div>
</div>

</form>