------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
------------------------------------------------------------

<?php echo lang('new comment posted', $new_comment->getObject()->getTitle()) ?>. <?php echo lang('view new comment') ?>:

- <?php echo str_replace('&amp;', '&', $new_comment->getViewUrl()) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 
<?php echo lang('project') ?>: <?php echo $new_comment->getProject()->getName() ?> 
<?php echo lang('author') ?>: <?php echo $new_comment->getCreatedByDisplayName() ?> 

--
<?php echo ROOT_URL ?>