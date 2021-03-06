<?php 
if (!$object->isNew()) {
?>
	<span style="color:#333333;font-weight:bolder;"><?php echo lang('object subscribers') ?>:</span>
	<div class="objectFiles">
	<div class="objectFilesTitle"></div>
	<table style="width:100%;margin-left:2px;margin-right:3px">
	<?php if (!$object->isSubscriber(logged_user())) {
		echo "<tr><td colspan=\"2\">";
		echo lang("user not subscribed to object");
		echo " (";
		echo '<a class="internalLink" href="'.$object->getSubscribeUrl().'" onclick="return confirm(\''.lang("confirm subscribe").'\')">'.lang("subscribe to object").'</a>';
		echo ")";
		echo "</td></tr>";
	} else {
	?>
		<tr class="subscriber<?php echo $counter % 2 ? 'even' : 'odd' ?>">
		<td style="padding-left:1px;vertical-align:middle;width:22px">
		<a class="internalLink" href="<?php echo logged_user()->getCardUrl() ?>">
		<div class="db-ico unknown ico-user"></div>
		</a></td><td><b><a class="internalLink" href="<?php echo logged_user()->getCardUrl() ?>">
		<span><?php echo lang("you") ?></span> </a></b> (<a class="internalLink" href="<?php echo $object->getUnsubscribeUrl() ?>" onclick="return confirm('<?php echo lang("confirm unsubscribe") ?>')"><?php echo lang("unsubscribe from object") ?></a>) </td></tr>
	<?php } ?>
	<?php $counter = 0;
	$subscribers = $object->getSubscribers();
	foreach ($subscribers as $subscriber) {
		if (!$subscriber instanceof User || $subscriber->getId() == logged_user()->getId()) continue;
		$counter++;?>
		<tr class="subscriber<?php echo $counter % 2 ? 'even' : 'odd' ?>">
		<td style="padding-left:1px;vertical-align:middle;width:22px">
		<a class="internalLink" href="<?php echo $subscriber->getCardUrl() ?>">
		<div class="db-ico unknown ico-user"></div>
		</a></td><td><b><a class="internalLink" href="<?php echo $subscriber->getCardUrl() ?>">
		<span><?php echo clean($subscriber->getDisplayName()) ?></span> </a></b> </td></tr>
	<?php 	} // foreach ?>
	</table>
	</div>
<?php } // if ?>