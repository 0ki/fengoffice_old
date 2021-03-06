------------------------------------------------------------<?php echo "\r\n"
?><?php echo lang('dont reply wraning') ?><?php echo "\r\n"
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo "\r\n"
?><?php
if (!isset($is_deleted) || !$is_deleted) {
	if ($is_new) {
		echo lang('new event created');
	} else {
		echo lang('event changed');
	}
	$projectName = $event->getProject()->getName();
	echo ': ' . $event->getSubject() . ' - ' . $projectName . ' - ';
	echo lang('date') . ': ' . Localization::instance()->formatDescriptiveDate($event->getStart());

?>.<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('view event') ?>: <?php echo str_replace('&amp;', '&', $event->getViewUrl()) ?><?php 
} else {
	echo lang('event deleted') . ': ' . $eventSubject . ' - ' . $projectName . ' - ';
	echo lang('date') . ' ' . Localization::instance()->formatDescriptiveDate($eventStart);
}  ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('company') ?>: <?php echo owner_company()->getName() ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('workspace') ?>: <?php echo $projectName ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?> --<?php echo "\r\n"
?><?php echo ROOT_URL ?><?php echo "\r\n"
?> 