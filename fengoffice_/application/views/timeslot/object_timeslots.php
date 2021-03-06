<?php
	$timeslots = $__timeslots_object->getTimeslots();
	$countTimeslots = 0;
	if (is_array($timeslots) && count($timeslots))
		$countTimeslots = count($timeslots);
	$random = rand();
	$open_timeslot = null;
?>

<?php if ($countTimeslots > 0) { ?>
    <div class="commentsTitle"><?php echo lang('object time slots')?> </div>
		<table style="width:100%;max-width:700px" class="objectTimeslots" id="<?php echo $random ?>objectTimeslots" style="<?php echo $countTimeslots > 0? '':'display:none'?>">

<?php $counter = 0;
		foreach($timeslots as $timeslot) {
			$counter++;
			$options = array();
			if ($timeslot->canEdit(logged_user())) {
				$options[] = '<a class="internalLink" href="' . $timeslot->getEditUrl() . '">' . lang('edit') . '</a>';
			}
			if ($timeslot->canDelete(logged_user())) 
				$options[] = '<a class="internalLink" href="' . $timeslot->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete timeslot') . '\')">' . lang('delete') . '</a>';
				
			if ($timeslot->isOpen() && $timeslot->getUserId() == logged_user()->getId() && $timeslot->canEdit(logged_user())){
				$open_timeslot = $timeslot;
				$counter --;
			} else {
?>
			<tr class="timeslot <?php echo $counter % 2 ? 'even' : 'odd'; echo $timeslot->isOpen() ? ' openTimeslot' : '' ?>" id="timeslot<?php echo $timeslot->getId() ?>">
			<td style="padding-right:10px"><b><?php echo $counter ?>.</b></td>
			<td style="padding-right:10px"><b><a class="internalLink" href="<?php echo $timeslot->getUser()->getCardUrl()?>" title=" <?php echo lang('user card of', $timeslot->getUser()->getDisplayName()) ?>"><?php echo $timeslot->getUser()->getDisplayName() ?></a></b></td>
			<td style="padding-right:10px"><?php echo format_datetime($timeslot->getStartTime(), 'M d, H:i')?>
				&nbsp;-&nbsp;<?php echo $timeslot->isOpen() ? ('<b>' . lang('work in progress') . '</b>') : 
				( (format_date($timeslot->getEndTime()) != format_date($timeslot->getStartTime()))?  format_datetime($timeslot->getEndTime(), 'M d, H:i'): format_time($timeslot->getEndTime())) ?></td>
			<td style="padding-right:10px"><?php echo DateTimeValue::FormatTimeDiff($timeslot->getStartTime(), $timeslot->getEndTime(), "hm", 60)?></td>
			<td align="right">
			<?php if(count($options)) { ?>
					<?php echo implode(' | ', $options) ?>
			<?php } // if ?>
			</td>
			</tr>
			
			<?php if ($timeslot->getDescription() != '') {?>
				<tr class="timeslot <?php echo $counter % 2 ? 'even' : 'odd'; echo $timeslot->isOpen() ? ' openTimeslot' : '' ?>" ><td></td>
				<td colspan=6 style="color:#666666"><?php echo $timeslot->getDescription() ?></td></tr>
			<?php } //if ?>
		<?php } //if 
		} // foreach ?>
		</table>
<?php } // if ?>


<?php if ($open_timeslot) {
		echo render_open_timeslot_form($__timeslots_object, $open_timeslot);
	} else { 
		if($__timeslots_object->canAddTimeslot(logged_user())) { 
			echo render_timeslot_form($__timeslots_object);
		} // if
	} // if ?>
<br/>