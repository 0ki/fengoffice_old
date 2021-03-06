------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
 
------------------------------------------------------------

<?php echo lang('new task created', $new_task->getTitle(), $new_task->getProject()->getName()) ?>. <?php echo lang('view new task') ?>:

 <?php echo str_replace('&amp;', '&', $new_task->getViewUrl()) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 

<?php echo lang('workspace') ?>: <?php echo $new_task->getProject()->getName() ?> 


--
<?php echo ROOT_URL ?>