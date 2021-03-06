<?php
	$genid = gen_id();
	$tasks_array = array();
	$timeslots_array = array();
	if (isset($tasks))
		foreach($tasks as $task)
			$tasks_array[] = $task->getArrayInfo();
	if (isset($timeslots))
		foreach($timeslots as $timeslot)
			$timeslots_array[] = $timeslot->getArrayInfo();
	if (isset($users))
		foreach($users as $user)
			$users_array[] = $user->getArrayInfo();
	if (isset($companies))
		foreach($companies as $company)
			$companies_array[] = $company->getArrayInfo();
?>

<div id="timePanel" class="ogContentPanel" style="background-color:#F0F0F0;height:100%;">
<div style="padding:7px;max-width:929px;">
<input type="hidden" id="<?php echo $genid ?>hfTasks" value="<?php echo clean(str_replace('"',"'", str_replace("'", "\'", json_encode($tasks_array)))) ?>"/>
<input type="hidden" id="<?php echo $genid ?>hfTimeslots" value="<?php echo clean(str_replace('"',"'", str_replace("'", "\'", json_encode($timeslots_array)))) ?>"/>
<input type="hidden" id="<?php echo $genid ?>hfUsers" value="<?php echo clean(str_replace('"',"'", str_replace("'", "\'", json_encode($users_array)))) ?>"/>
<input type="hidden" id="<?php echo $genid ?>hfCompanies" value="<?php echo clean(str_replace('"',"'", str_replace("'", "\'", json_encode($companies_array)))) ?>"/>

<table style="width:100%;max-width:924px">
	<col width=12/><col /><col width=12/><tr>
	<td colspan=2 class="TMActiveTasksHeader">
<?php echo lang('all active tasks') ?>
</td><td class="coViewTopRight">&nbsp;&nbsp;</td></tr>
<tr>
	<td colspan=2 class="coViewBody" style="background-color:white;">
<div id="<?php echo $genid ?>TMActiveTasksContents" class="TMActiveTasksContents">

</div>

</td><td class="coViewRight"></td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom">&nbsp;&nbsp;</td>
		<td class="coViewBottomRight"></td></tr>
</table>



<table style="width:100%;max-width:924px">
	<col width=12/><col /><col width=12/><tr>
	<td colspan=2 style="padding-right:14px">
<div id="<?php echo $genid ?>TMTimespanHeader" class="TMTimespanHeader">
<table style="width:100%"><tr><td>
<?php echo lang('time timeslots') ?>
</td><td align="right" style="font-size:80%;font-weight:normal">
<a href="<?php echo get_url("reporting",'total_task_times_p') ?>" class="internalLink coViewAction ico-print" style="color:white;font-weight:bold"><?php echo lang('print report') ?></a>
</td></tr></table>
</div>
<div id="<?php echo $genid ?>TMTimespanAddNew" class="TMTimespanAddNew">
	<table style="width:100%"><tr><td>
	   <?php echo label_tag(lang('date')) ?>
		<?php echo pick_date_widget2('timeslot[date]', DateTimeValueLib::now(),$genid, false) ?>
	</td><td style="padding-right: 25px">
		<?php echo label_tag(lang('workspace')) ?>
		<?php echo select_project2('timeslot[project_id]', active_or_personal_project()->getId(), $genid) ?>
	</td><td style="padding-right: 10px">
		<?php echo label_tag(lang('user')) ?>
		<?php echo user_select_box("timeslot[user_id]", logged_user()->getId(),array('id' => $genid . 'tsUser')) ?>
	</td><td style="padding-right: 10px">
		<?php echo label_tag(lang('time')) ?>
		<?php echo text_field('timeslot[hours]', 0, 
    		array('style' => 'width:28px', 'tabindex' => '100', 'id' => $genid . 'tsHours')) ?>
    		<br/><span class="desc" style="font-style:normal;font-size:80%">(<?php echo lang('hours') ?>)</span>
	</td><td style="padding-right: 10px">
		<?php echo label_tag(lang('description')) ?>
		<?php echo textarea_field('timeslot[description]', '', array('class' => 'short', 'style' => 'height:30px;width:100%', 'tabindex' => '200', 'id' => $genid . 'tsDesc')) ?>
	</td><td style="padding-left: 10px">
		<br/><?php echo submit_button(lang('save'),'s',array('style'=>'margin-top:0px;margin-left:0px', 'tabindex' => '300', 'onclick' => 'ogTimeManager.SubmitNewTimeslot(\'' .$genid . '\');return false;')) ?>
	</td></tr></table>
</div></td><td class="coViewTopRight">&nbsp;&nbsp;</td></tr>
<tr>
	<td colspan=2 class="coViewBody" style="padding-right:14px">
<div id="<?php echo $genid ?>TMTimespanContents" style="width:100%" class="TMTimespanContents">
<table style="width:100%" id="<?php echo $genid ?>TMTimespanTable">
<tr>
	<td width='70px'><b><?php echo lang('date') ?></b></td>
	<td width='15%'><b><?php echo lang('workspace') ?></b></td>
	<td width='15%'><b><?php echo lang('user') ?></b></td>
	<td width='60px'><b><?php echo lang('time') ?></b></td>
	<td><b><?php echo lang('description') ?></b></td>
	<td></td></tr>
</table>
</div>

</td><td class="coViewRight"></td></tr>
		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom">&nbsp;</td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>

<script type="text/javascript">
ogTimeManager.loadDataFromHF('<?php echo $genid ?>');
ogTimeManager.drawTasks('<?php echo $genid ?>');
ogTimeManager.drawTimespans('<?php echo $genid ?>');
</script>
</div>
