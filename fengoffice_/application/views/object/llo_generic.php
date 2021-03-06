<?php 
$icon_class = $linked_object->getObjectTypeName();
if ($linked_object instanceof ProjectFile)
	$icon_class = 'file ico-' . str_replace(".", "_", str_replace("/", "-", $linked_object->getTypeString()));
?>
<tr class="<?php echo $counter % 2 ? 'even' : 'odd' ?>">
	<td style="padding-left:1px;vertical-align:middle;width:22px">
		<a class="internalLink" href="<?php echo $linked_object->getObjectUrl() ?>">
		<div class="db-ico unknown ico-<?php echo clean($icon_class) ?>" title="<?php echo clean($linked_object->getObjectTypeName()) ?>"></div>
	</a></td>
	
	<td><a class="internalLink" href="<?php echo $linked_object->getObjectUrl() ?>" title="<?php echo $linked_object->getObjectName() ?>">
	<span><?php echo clean($linked_object->getObjectName()) ?></span></a></td>
	
	<td style="text-align:right;">
	<?php if ($linked_object instanceof ProjectFile){ ?>
		<a target="_self" href="<?php echo $linked_object->getDownloadUrl() ?>"><?php echo lang('download') . ' (' . format_filesize($linked_object->getFilesize()) . ')'?></a> | 
	<?php }
	if ($linked_object instanceof ProjectWebpage) { ?>
		<a target="_blank" href="<?php echo $linked_object->getUrl() ?>"><?php echo lang('open weblink')?></a> |
	<?php }
	if ($linked_objects_object->canUnlinkObject(logged_user(), $linked_object)) { 
		echo '<a class="internalLink" href="' . $linked_objects_object->getUnlinkObjectUrl($linked_object) . '" onclick="return confirm(\'' . escape_single_quotes(lang('confirm unlink object')) . '\')" title="' . lang('unlink object') . '">' . lang('unlink') . '</a>';
	} ?>
	</td>
</tr>