------------------------------------------------------------<?php echo "\r\n"
?><?php echo lang('dont reply wraning') ?><?php echo "\r\n"
?>------------------------------------------------------------<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('new message posted', $new_message->getTitle()) ?>.<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('text') ?>:<?php echo "\r\n"
?><?php echo "\r\n"
?><?php
$text = '> '.$new_message->getText();
$text = str_replace("\r\n", "\n", $text);
$text = str_replace("\r", "\n", $text);
$text = str_replace("\n", "\r\n> ", $text);
echo $text ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('view new message') ?>: <?php echo str_replace('&amp;', '&', $new_message->getViewUrl()) ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('company') ?>: <?php echo owner_company()->getName() ?><?php echo "\r\n"
?><?php echo "\r\n"
?><?php  /*if(false && count($new_message->getWorkspaces() == 1)){ echo lang('workspaces'); ?>: <?php echo $new_message->getWorkspacesNamesCSV(); } // Not executed because of permissions issues, cannot show workspaces to people who cannot see them */?><?php echo "\r\n"
?>--<?php echo "\r\n"
?><?php echo ROOT_URL ?><?php echo "\r\n"
?>