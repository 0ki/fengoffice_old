<?php
if (is_array($logs) && count($logs) > 0) {
?>

<div class="commentsTitle"><?php echo lang('latest activity'); ?> </div>

<table style="min-width:400px;margin-top:10px;" class='dashActivity'>
<tbody>
<?php 

$isAlt = true;
if (is_array($logs)) {
	foreach ($logs as $log) {
		$isAlt = !$isAlt;
		echo '<tr' . ($isAlt? ' class="dashAltRow"' : '') . '><td  style="padding:5px;padding-right:15px;">';
		if ($log->getCreatedOn()->getYear() != DateTimeValueLib::now()->getYear())
			$date = format_time($log->getCreatedOn(), "M d Y, H:i");
		else{
			if ($log->isToday())
				$date = lang('today') . format_time($log->getCreatedOn(), ", H:i:s");
			else
				$date = format_time($log->getCreatedOn(), "M d, H:i");
		}
		echo $date . ' </td><td style="padding:5px;padding-right:15px;"> ' . $log->getActivityData();
		echo '</td></tr>';
	}
}

?>
</tbody>
</table>

<a style="display:block" class="internalLink" href='<?php echo $object->getViewHistoryUrl() ?>' ><?php echo lang('view all activity'); ?></a>
<?php			 		
}
?>

<br>
