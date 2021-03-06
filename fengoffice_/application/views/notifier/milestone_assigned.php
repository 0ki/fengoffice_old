<?php echo lang('milestone assigned', $milestone_assigned->getName()) ?>. <?php echo lang('view assigned milestones') ?>:

 <?php echo str_replace('&amp;', '&', $milestone_assigned->getViewUrl()) ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() ?> 

<?php echo lang('workspace') ?>: <?php echo $milestone_assigned->getProject()->getName() ?> 


--
<?php echo ROOT_URL ?>