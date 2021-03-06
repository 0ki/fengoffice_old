<?php echo lang('task assigned', $task_assigned->getTitle()) ?>. <?php echo lang('view assigned tasks') ?>:

 <?php echo str_replace('&amp;', '&', $task_assigned->getViewUrl()) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 

<?php echo lang('workspace') ?>: <?php echo $task_assigned->getProject()->getName() ?> 


--
<?php echo ROOT_URL ?>