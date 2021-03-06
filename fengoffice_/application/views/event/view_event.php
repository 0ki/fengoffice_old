
<?php
$duration = $variables["duration"];
$desc = $variables["desc"];
$attendance = $variables["attendance"];
?>
<br><?php if (isset($attendance) && $attendance != null) {
	echo $attendance;
}
?>
<br><b><?php echo lang('CAL_DURATION')?>:</b> <?php echo $duration?><br>
<br><b><?php echo lang('CAL_DESCRIPTION')?>:</b><br><?php echo $desc?><br>