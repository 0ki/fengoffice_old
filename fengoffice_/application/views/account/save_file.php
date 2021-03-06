{
    success: <?php echo $success ?>,
    error: '<?php echo str_replace(array("'", "\n"), array("\\'", ""), $error) ?>',
    forward: '<?php echo $forward ?>'
}