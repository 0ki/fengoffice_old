
<form class='internalForm'  method="post" action="<?php echo get_url('administration','assign_task_template_to_ws',array('id'=>$task->getId()))?>">
<div class="adminClients" style="height:100%;background-color:white">
	<div class="adminHeader">
  		<div class="adminTitle"><?php echo lang('assign task template to workspace', $task->getTitle()) ?></div>
	</div>
	<div class="adminSeparator"></div>
	<div class="adminMainBlock">
<?php 

	echo select_workspaces("ws_ids", $workspaces, $selected, gen_id());
	echo submit_button(lang('save'), 's', array('tabindex' => '10')); 
?>
	</div>
</div>
   
</form>