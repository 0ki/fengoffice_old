<?php
	$genid = gen_id();
	$project_id = null;
	if (active_project())
		$project_id = active_project()->getId();
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
					option_tag(lang('today'),1, array('selected' => 'selected')),
					option_tag(lang('this week'),2),
					option_tag(lang('last week'),3),
					option_tag(lang('this month'),4),
					option_tag(lang('last month'),5),
					option_tag(lang('select dates...'),6)
				), array('onchange' => 'og.dateselectchange(this)'));
			?></td>
		</tr>
		<tr class="dateTr" style='display:none'>
			<td><b><?php echo lang("start date") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				echo pick_date_widget('report[start]',DateTimeValueLib::now(), date("Y") - 10 , date("Y") + 10);
			?></td>
		</tr>
		<tr class="dateTr" style='height:30px;display:none'>
			<td ><b><?php echo lang("end date") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				echo pick_date_widget('report[end]',DateTimeValueLib::now(), date("Y") - 10 , date("Y") + 10);
			?></td>
		</tr>
		<tr style='height:30px;'>
			<td><b><?php echo lang("user") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				$options = array();
				$options[] = option_tag('-- ' . lang('anyone') . ' --', 0, array('selected' => 'selected'));
				foreach($users as $user){
					$options[] = option_tag($user->getDisplayName(),$user->getId());
				}
				echo select_box('report[user]', $options);
			?></td>
		</tr>
		<tr style='height:30px;'>
			<td><b><?php echo lang("workspace") ?>:&nbsp;</b></td>
			<td align='left'>
				<?php echo select_project('report[project_id]', $workspaces,$project_id,null,true);
					echo checkbox_field('report[include_subworkspaces]', true, array('id' => 'report[include_subworkspaces]' )) ?> 
	      <label for="<?php echo 'report[include_subworkspaces]' ?>" class="checkbox"><?php echo lang('include subworkspaces') ?></label>
			</td>
		</tr>
		<tr style='height:30px;'>
			<td><b><?php echo lang("group by") ?>:&nbsp;</b></td>
			<td align='left'>
				<span style="display:inline" id="<?= $genid ?>gbspan1">
					<select id="<?= $genid ?>group_by_1" name="report[group_by_1]" )">
						<option value="0" selected="selected">-- None --</option>
						<option value="id"><?php echo lang('task')?></option>
						<option value="user_id"><?php echo lang('user')?></option>
						<option value="project_id"><?php echo lang('workspace')?></option>
						<option value="priority"><?php echo lang('priority')?></option>
						<option value="milestone_id"><?php echo lang('milestone')?></option>
					</select>
				</span>
				<span style="display:inline" id="<?= $genid ?>gbspan2">
					<select id="<?= $genid ?>group_by_2" name="report[group_by_2]" )">
						<option value="0" selected="selected">-- None --</option>
						<option value="id"><?php echo lang('task')?></option>
						<option value="user_id"><?php echo lang('user')?></option>
						<option value="project_id"><?php echo lang('workspace')?></option>
						<option value="priority"><?php echo lang('priority')?></option>
						<option value="milestone_id"><?php echo lang('milestone')?></option>
					</select>
				</span>
				<span style="display:inline" id="<?= $genid ?>gbspan3">
					<select id="<?= $genid ?>group_by_3" name="report[group_by_3]" )">
						<option value="0" selected="selected">-- None --</option>
						<option value="id"><?php echo lang('task')?></option>
						<option value="user_id"><?php echo lang('user')?></option>
						<option value="project_id"><?php echo lang('workspace')?></option>
						<option value="priority"><?php echo lang('priority')?></option>
						<option value="milestone_id"><?php echo lang('milestone')?></option>
					</select>
				</span>
			</td>
		</tr>
	</table>
	
<br/>
<?php echo submit_button(lang('generate report'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?>
</div>
</div>

</form>