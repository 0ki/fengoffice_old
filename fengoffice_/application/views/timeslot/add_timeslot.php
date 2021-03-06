<?php $genid = gen_id(); ?>

<form style="height:100%;background-color:white" class="internalForm" action="<?php echo $timeslot->getEditUrl() ?>" method="post">

<div class="timeslot">
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px"><tr><td><?php echo $timeslot->isNew() ? lang('new timeslot') : lang('edit timeslot') ?>
	</td><td style="text-align:right"><?php echo submit_button($timeslot->isNew() ? lang('add timeslot') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
  <div class="formAddTimeslotDescription">
    <?php echo label_tag(lang('end work description'), 'addTimeslotDescription', false) ?>
    <?php echo textarea_field("timeslot[description]", array_var($timeslot_data, 'description'), array('class' => 'short', 'id' => 'addTimeslotDescription')) ?>
  </div>
	<table>
		<tr>
			<td><b><?php echo lang("start date") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				$start_time = new DateTimeValue($timeslot->getStartTime()->getTimestamp() + logged_user()->getTimezone() * 3600) ;
				echo pick_date_widget2('timeslot[start_value]',$start_time, $genid);
			?></td>
		</tr>
		
		<tr>
			<td><b><?php echo lang("start time") ?>:&nbsp;</b></td>
			<td align='left'><select name="timeslot[start_hour]" size="1">
			<?php
			for($i = 0; $i < 24; $i++) {
					echo "<option value=\"$i\"";
					if($start_time->getHour() == $i) echo ' selected="selected"';
					echo ">$i</option>\n";
				}
			?>
			</select> <b>:</b> <select name="timeslot[start_minute]" size="1">
			<?php
			$minute = $start_time->getMinute();
			for($i = 0; $i < 60; $i++) {
				echo "<option value='$i'";
				if($minute == $i) echo ' selected="selected"';
				echo sprintf(">%02d</option>\n", $i);
			}
			?>
			</select></td>
		</tr><tr><td>&nbsp;</td></tr>
		<tr>
			<td ><b><?php echo lang("end date") ?>:&nbsp;</b></td>
			<td align='left'><?php 
				if ($timeslot->getEndTime() == null){
					$dt = DateTimeValueLib::now();
					$end_time = new DateTimeValue($dt->getTimestamp() + logged_user()->getTimezone() * 3600);
				} else
					$end_time = new DateTimeValue($timeslot->getEndTime()->getTimestamp() + logged_user()->getTimezone() * 3600) ;
			echo pick_date_widget2('timeslot[end_value]',$end_time, $genid);
			?></td>
		</tr>
		
		<tr>
			<td><b><?php echo lang("end time") ?>:&nbsp;</b></td>
			<td align='left'><select name="timeslot[end_hour]" size="1">
			<?php
			for($i = 0; $i < 24; $i++) {
					echo "<option value=\"$i\"";
					if($end_time->getHour() == $i) echo ' selected="selected"';
					echo ">$i</option>\n";
				}
			?>
			</select> <b>:</b> <select name="timeslot[end_minute]" size="1">
			<?php
			$minute = $end_time->getMinute();
			for($i = 0; $i < 60; $i++) {
				echo "<option value='$i'";
				if($minute == $i) echo ' selected="selected"';
				echo sprintf(">%02d</option>\n", $i);
			}
			?>
			</select></td>
		</tr>
	</table>


    <?php echo submit_button($timeslot->isNew() ? lang('add timeslot') : lang('save changes')) ?>
</div>
</div>

</form>