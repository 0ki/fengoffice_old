<?php $type = $object->getObjectTypeName();
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo lang('dont reply wraning') ?><?php echo "\r\n"
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('share notification '.$type.' desc', $object->getObjectName(), logged_user()->getDisplayName()) ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('view '.$type) ?>: <?php echo str_replace('&amp;', '&', $object->getViewUrl()) ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('company') ?>: <?php echo owner_company()->getName() ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?>--<?php echo "\r\n"
?><?php echo ROOT_URL ?><?php echo "\r\n"
?>