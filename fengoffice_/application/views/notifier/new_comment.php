------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
 
------------------------------------------------------------

<?php echo lang('new comment posted', $new_comment->getObject()->getObjectName()) ?>.

<?php echo lang('view new comment') ?>: <?php echo str_replace('&amp;', '&', $new_comment->getViewUrl()) ?> 


<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?>
  
<?php echo lang('author') ?>: <?php echo $new_comment->getCreatedByDisplayName() ?>
<?php /* if(count($new_comment->getWorkspaces() == 1)){ echo lang('workspaces'); ?>: <?php echo $new_comment->getWorkspacesNamesCSV(); } // Not executed because of permissions issues, cannot show workspaces to people who cannot see them */?> 


--
<?php echo ROOT_URL ?>