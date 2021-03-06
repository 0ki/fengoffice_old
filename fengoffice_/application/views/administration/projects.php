<?php 
  set_page_title(lang('projects'));
  
  if(Project::canAdd(logged_user())) {
    add_page_action(lang('add project'), get_url('project', 'add'), 'ico-add');
  } // if
?>



<div class="adminProjects" style="height:100%;background-color:white">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('projects') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
  
<?php if(isset($projects) && is_array($projects) && count($projects)) { ?>
<table id="projects" style="min-width:400px;margin-top:10px;">
  <tr>
    <?php if (false) { ?><th></th><?php } ?>
    <th><?php echo lang('name') ?></th>
    <th><?php echo lang('options') ?></th>
  </tr>

<?php 
	$isAlt = true;
foreach($projects as $project) {  
	$isAlt = !$isAlt;?>
  <tr class="<?php echo $isAlt? 'altRow' : ''?>">
    <?php if (false) { //Remove to enable closing workspaces?>
    <td class="middle">
<?php if($project->canChangeStatus(logged_user())) { ?>
<?php echo checkbox_link($project->isActive() ? $project->getCompleteUrl() : $project->getOpenUrl(), !$project->isActive(), $project->isActive() ? lang('mark project as finished') : lang('mark project as active')) ?>
<?php } else { ?>
<img src="<?php echo $project->isActive() ? icon_url('not-checked.jpg') : icon_url('checked.jpg') ?>" alt="" title="<?php echo $project->isActive() ? lang('active project') : lang('finished project') ?>" />
<?php } // if ?>
    </td>
    <?php } // if ?>
    <td class="long middle"><!-- a class="internalLink" href="<?php echo $project->getOverviewUrl() ?>"-->
    	<?php echo clean($project->getName()) ?>
    <!-- /a --></td>
<?php
  $options = array();
  if($project->canEdit(logged_user())) $options[] = '<a class="internalLink" href="' . $project->getEditUrl() .'">' . lang('edit') . '</a>';
  if($project->canDelete(logged_user())) $options[] = '<a class="internalLink" href="' . $project->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete project') . '\')">' . lang('delete') . '</a>';
?>
    <td class="middle" style="font-size:80%;"><?php echo implode(' | ', $options) ?></td>
  </tr>
<?php } // foreach ?>
</table>
<?php } else { ?>
<?php echo lang('no projects owned by company') ?>
<?php } // if ?>
</div>
</div>