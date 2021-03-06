------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
------------------------------------------------------------

<?php echo lang('new message posted', $new_message->getTitle(), $new_message->getProject()->getName()) ?>. <?php echo lang('view new message') ?>:

- <?php echo str_replace('&amp;', '&', $new_message->getViewUrl()) ?> 

Company: <?php echo owner_company()->getName() ?> 
Project: <?php echo $new_message->getProject()->getName() ?> 

--
<?php echo ROOT_URL ?>