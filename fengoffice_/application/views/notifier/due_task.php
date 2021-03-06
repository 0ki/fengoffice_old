------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
 
------------------------------------------------------------

<?php echo lang('due task email', $due_task->getTitle(), $due_task->getDueDate()->toISO8601()) ?>. <?php echo lang('view due task') ?>:

 <?php echo str_replace('&amp;', '&', $due_task->getViewUrl()) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 

<?php echo lang('workspace') ?>: <?php echo $due_task->getProject()->getName() ?> 


--
<?php echo ROOT_URL ?>