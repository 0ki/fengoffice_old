<?php echo lang('hi john doe', $user->getDisplayName()) ?>,<?php echo "\r\n"
?><?php echo "\r\n"
?><?php echo lang('user password reseted desc') ?><?php echo "\r\n"
?><?php echo "\r\n"
?>
<?php echo get_url('access','reset_password',array('t' => $token, 'uid' => $user->getId()))?>
<?php echo "\r\n" ?>
<?php echo "\r\n"
?><?php echo "\r\n"
?>--<?php echo "\r\n"
?><?php echo ROOT_URL ?><?php echo "\r\n\r\n\r\n"
?> 