------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
 
------------------------------------------------------------

<?php
	if ($is_new) {
		echo lang('new event created');
	} else {
		echo lang('event changed');
	}
	echo ': ' . $event->getSubject() . ' - ' . $event->getProject()->getName();
	echo lang('date') . ' ' . Localization::instance()->formatDescriptiveDate($event->getStart());
?>
.
<?php echo lang('view event') ?>:

<?php echo str_replace('&amp;', '&', $event->getViewUrl()) ?> 
<?php echo "" ?>
<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 

<?php echo lang('workspace') ?>: <?php echo $event->getProject()->getName() ?> 


--
<?php echo ROOT_URL ?>