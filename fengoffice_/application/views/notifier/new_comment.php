------------------------------------------------------------<?php echo "\r\n"
?><?php echo lang('dont reply wraning') ?><?php echo "\r\n"
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('new comment posted', $new_comment->getObject()->getObjectName()) ?>.<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('text') ?>:<?php echo "\r\n"
?><?php echo "\r\n"
?><?php
$text = '> '.$new_comment->getText();
$text = str_replace("\r\n", "\n", $text);
$text = str_replace("\r", "\n", $text);
$text = str_replace("\n", "\r\n> ", $text);
echo $text ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('view new comment') ?>: <?php echo str_replace('&amp;', '&', $new_comment->getViewUrl()) ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('company') ?>: <?php echo owner_company()->getName() ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('author') ?>: <?php echo $new_comment->getCreatedByDisplayName() ?><?php echo "\r\n"
?><?php /* if(count($new_comment->getWorkspaces() == 1)){ echo lang('workspaces'); ?>: <?php echo $new_comment->getWorkspacesNamesCSV(); } // Not executed because of permissions issues, cannot show workspaces to people who cannot see them */
?> <?php echo "\r\n"
?><?php echo "\r\n"
?>--<?php echo "\r\n"
?><?php echo ROOT_URL ?><?php echo "\r\n"
?>