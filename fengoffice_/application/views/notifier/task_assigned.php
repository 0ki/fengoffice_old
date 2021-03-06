<?php echo lang('task assigned', $task_assigned->getTitle()) ?>. <?php echo lang('view assigned tasks') ?>:

- <?php echo str_replace('&amp;', '&', $task_assigned->getViewUrl()) ?> 

Company: <?php echo owner_company()->getName() ?> 
Project: <?php echo $task_assigned->getProject()->getName() ?> 

--
<?php echo ROOT_URL ?>