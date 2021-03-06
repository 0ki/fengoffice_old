
<?php
$duration = $variables["duration"];
$desc = $variables["desc"];
$attendance = isset($variables["attendance"]) ? $variables["attendance"] : null;
?>
<br><?php if ($attendance != null) {
	echo $attendance;
}
?>
<br><b><?php echo lang('CAL_DURATION')?>:</b> <?php echo $duration?><br>
<br><b><?php echo lang('CAL_DESCRIPTION')?>:</b><br><?php echo $desc?><br>