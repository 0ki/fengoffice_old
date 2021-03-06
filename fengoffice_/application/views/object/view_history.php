<br>
<h1><?php echo lang('view history for') . ' ' . $object->getObjectName(); ?></h1>

<br>
<table>
<tr><th><?php echo lang('date')?></th>
<th><?php echo lang('user')?></th>
<th><?php echo lang('details')?></th>
</tr>
<?php

foreach ($logs as $log) {
	echo '<tr><td>';
	echo  $log->getCreatedOn()->format("M d Y H:i:s") . ' </td><td> '  . $log->getTakenByDisplayName() . '  </td><td> ' . $log->getText();
	echo '</td></tr><br>';
}

?>
</table>