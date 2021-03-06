
<form class='internalForm'  method="post" action="<?php echo get_url('administration','assign_task_template_to_ws',array('id'=>$task->getId()))?>">
<div class="adminClients" style="height:100%;background-color:white">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('assign task template to workspace', $task->getTitle()) ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
<?php 
  
  
function print_node($projectsArray, $project, $workspace_templates_data, $level){
	$id_csvs = '';
    $project_id = $project->getId();
	// recursive function to print checkbox tree structure
	echo '<tr><td>&nbsp;	';	
    echo checkbox_field('task_template[' . $project->getId() . ']',array_var($workspace_templates_data,$project->getId()), array('id' => 'task_template_' . $project->getId()));
//    echo '</td><td align=center>';
//    echo checkbox_field('task_template_childs[' . $project->getId() . ']',false); //  array('id' => 'task_template' . $project->getId(), 'onclick' => 'App.modules.updateUserPermissions.projectCheckboxClick(' . $project->getId() . ')')) 
    echo '</td><td>';
	echo str_repeat ('&nbsp;-',$level);
    echo label_tag(clean($project->getName()),'task_template[' . $project->getId() . ']', false, array('class'=>'checkbox')) . '<br>';
    echo '</td><tr>';
    
	if(isset($projectsArray[$project_id]) && $projectsArray[$project_id]){
		foreach ($projectsArray[$project_id] as $project)
			print_node($projectsArray,$project, $workspace_templates_data,$level+1);		
	}
}

	if(isset($projectsArray) && is_array($projectsArray) && count($projectsArray)) { ?>

        <table class="blank">
        <tr><th><?php echo lang('assign'); ?></th> 
<!--	        <th> | <?php echo lang('include subworkspaces'); ?></th>-->
	        <th> | <?php echo lang('workspace'); ?></th></tr>
        
<?php
		foreach ($projectsArray[0] as $project){
			print_node($projectsArray, $project, $workspace_templates_data, 0);
		}
		echo '</table>';
		echo '<br>';
	
		
	    echo submit_button(lang('save'), 's', array('tabindex' => '10')); 
	    echo input_field('commit', 'commit', array('type' => 'hidden'));
	}
?>
</div></div>
   
</form>