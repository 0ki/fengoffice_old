<div class="history" style="height:100%;background-color:white">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><?php echo lang('view history for') . ' ' . $object->getObjectName(); ?></div>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock adminMainBlock">

<table style="min-width:400px;margin-top:10px;">
<tr><th><?php echo lang('date')?></th>
<th><?php echo lang('user')?></th>
<th><?php echo lang('details')?></th>
</tr>
<?php
$isAlt = true;
foreach ($logs as $log) {
	$isAlt = !$isAlt;
	echo '<tr' . ($isAlt? ' class="altRow"' : '') .  '><td>';
	echo  $log->getCreatedOn()->format("M d Y H:i:s") . ' </td><td> '  . $log->getTakenByDisplayName() . '  </td><td> ' . $log->getText();
	echo '</td></tr>';
}

?>
</table>
</div>
</div>