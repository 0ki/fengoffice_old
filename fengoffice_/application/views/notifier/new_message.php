------------------------------------------------------------
 <?php echo lang('dont reply wraning') ?> 
 
------------------------------------------------------------

 <?php echo lang('new message posted', $new_message->getTitle()) ?>. <?php echo lang('view new message') ?>:

 <?php echo str_replace('&amp;', '&', $new_message->getViewUrl()) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 

<?php  if(false && count($new_message->getWorkspaces() == 1)){ echo lang('workspaces'); ?>: <?php echo $new_message->getWorkspacesNamesCSV(); } // Not executed because of permissions issues, cannot show workspaces to people who cannot see them?> 

--
<?php echo ROOT_URL ?>