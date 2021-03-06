<?php $type = $object->getObjectTypeName();
$trashedBy = Users::findById($object->getTrashedById());
$trashedByDisplayName = $trashedBy instanceof User ? $trashedBy->getDisplayName() : lang("n/a");
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo lang('dont reply wraning') ?><?php echo "\r\n"
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('deleted notification '.$type.' desc', $object->getObjectName(), $trashedByDisplayName) ?>.<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('view '.$type) ?>: <?php echo str_replace('&amp;', '&', $object->getViewUrl()) ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('company') ?>: <?php echo owner_company()->getName() ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?>--<?php echo "\r\n"
?><?php echo ROOT_URL ?><?php echo "\r\n"
?>