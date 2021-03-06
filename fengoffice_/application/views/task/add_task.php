<script type="text/javascript">
		var allTags = [<?php
			$coma = false;
			$tags = Tags::getTagNames();
			foreach ($tags as $tag) {
				if ($coma) {
					echo ",";
				} else {
					$coma = true;
				}
				echo "'" . $tag . "'";
			}
		?>];
	</script>
<?php
  $genid = gen_id();
  set_page_title($task->isNew() ? lang('add task list') : lang('edit task list'));
  $project = active_or_personal_project();
  $projects =  active_projects();
?>
<?php if($task->isNew()) { ?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo get_url('task', 'add_task') ?>" method="post">
<?php } else { ?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $task->getEditListUrl() ?>" method="post">
<?php } // if ?>

<div class="task">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php echo $task->isNew() ? lang('new task list') : lang('edit task list') ?>
	</td><td style="text-align:right"><?php echo submit_button($task->isNew() ? lang('add task list') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
		<?php echo label_tag(lang('name'), $genid . 'taskListFormName', true) ?>
    	<?php echo text_field('task[title]', array_var($task_data, 'title'), 
    		array('class' => 'title', 'id' => $genid . 'taskListFormName', 'tabindex' => '1')) ?>
    </div>
	
	<div style="padding-top:5px">
		<?php if (isset ($projects) && count($projects) > 0) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_select_workspace_div', this)"><?php echo lang('workspace') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_milestone_div', this)"><?php echo lang('milestone') ?></a> - 
		<?php if($task->isNew()) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_tasks_div', this)"><?php echo lang('subtasks') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_handins_div', this)"><?php echo lang('handins') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_properties_div', this)"><?php echo lang('properties') ?></a> -
		<?php if($task->isNew() || $task->canLinkObject(logged_user())) { ?>  
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_linked_objects_div', this)"><?php echo lang('linked objects') ?></a> -
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_list_dates_div', this)"><?php echo lang('dates') ?></a>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<?php if (isset ($projects) && count($projects) > 0) { ?>
	<div id="<?php echo $genid ?>add_list_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project('task[project_id]', $projects, ($project instanceof Project)? $project->getId():0) ?>
	</fieldset>
	</div>
	<?php } ?>

	<div id="<?php echo $genid ?>add_list_tags_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('tags') ?></legend>
		<?php echo autocomplete_textfield("task[tags]", array_var($task_data, 'tags'), 'allTags', array('class' => 'long')); ?>
	</fieldset>
	</div>

	
	<div id="<?php echo $genid ?>add_list_milestone_div" style="display:none">
  	<fieldset>
    <legend><?php echo lang('milestone') ?></legend>
    
	    <label><?php echo lang('milestone') ?>: <span class="desc">(<?php echo lang('assign milestone task list desc') ?>)</span></label>
    	<?php echo select_milestone('task[milestone_id]', $project, array_var($task_data, 'milestone_id'), array('id' => $genid . 'taskListFormMilestone')) ?>
  	</fieldset>
  	</div>

<?php if($task->isNew()) { ?>
 	<div id="<?php echo $genid ?>add_list_tasks_div" style="display:none">
 	<fieldset>
    <legend><?php echo lang('subtasks') ?></legend>
	  <table class="blank">
	    <tr>
	      <th><?php echo lang('task') ?>:</th>
	      <th><?php echo lang('assign to') ?>:</th>
	    </tr>
	<?php for($i = 0; $i < 6; $i++) { ?>
	    <tr style="background: <?php echo $i % 2 ? '#fff' : '#e8e8e8' ?>">
	      <td>
	        <?php echo textarea_field("task[task$i][title]", array_var($task_data["task$i"], 'title'), array('class' => 'short')) ?>
	      </td>
	      <td>
	        <?php echo assign_to_select_box("task[task$i][assigned_to]", active_or_personal_project(), array_var($task_data["task$i"], 'assigned_to')) ?>
	      </td>
	    </tr>
	<?php } // for ?>
	  </table>
  	</fieldset>
	</div>
<?php } // if ?>
  
	<div style="display:none" id="<?php echo $genid ?>add_list_handins_div">
	<fieldset>
    <legend><?php echo lang('handins') ?></legend>
	  <table class="blank">
	    <tr>
	      <th><?php echo lang('handin') ?>:</th>
	      <th><?php echo lang('assign to') ?>:</th>
	    </tr>
		<?php for($i = 0; $i < 4; $i++) { ?>
	    <tr style="background: <?php echo $i % 2 ? '#fff' : '#e8e8e8' ?>">
	      <td>      
	        <?php 
	        if($task->isNew())
	        	$attr =  array('class' => 'long');
	        else 
	        	 $attr = array('class' => 'long', 'disabled' => 'true');
	        echo text_field("task[handin$i][title]", array_var($task_data["handin$i"], 'title'), $attr) ?>
	      </td>
	      <td>
	        <?php echo assign_to_select_box("task[handin$i][assigned_to]", active_or_personal_project(), array_var($task_data["handin$i"], 'assigned_to'), $task->isNew()?null:array( 'disabled' => 'true')) ?>
	      </td>
	    </tr>
		<?php } // for ?>
	  </table>
	</fieldset>
  	</div>
  
	
	<div id='<?php echo $genid ?>add_list_properties_div' style="display:none">
	<fieldset>
    <legend><?php echo lang('properties') ?></legend>
      <? echo render_object_properties('task',$task); ?>
  	</fieldset>
 	</div>
  
    <?php if($task->isNew() || $task->canLinkObject(logged_user())) { ?>
    <div style="display:none" id="<?php echo $genid ?>add_task_linked_objects_div">
	<fieldset>
	  	  <table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
	   	<tbody></tbody>
		</table>
    <legend><?php echo lang('linked objects') ?></legend>
    	<?php echo render_object_links($task) ?>
	</fieldset>
	</div>
	<?php } // if ?>
	
	
	
	
	<div id="<?php echo $genid ?>add_list_dates_div" style="display:none">
 	<fieldset>
    <legend><?php echo lang('dates') ?></legend>
		<div>		
		<script language="javascript">
		function toggle_start_date(){ 
			if(document.getElementById('start_date_div').style.display =='none')
				document.getElementById('start_date_div').style.display='block';
			else
				document.getElementById('start_date_div').style.display='none';
		}
		</script>
		<?php echo checkbox_field('use_start_date',(array_var($task_data, 'start_date')!='')?true:false,array('onclick'=>"javascript:toggle_start_date();") ) ?>
		<?php echo lang('use start date') ?> <br> 
			<div id="start_date_div" <?php  if (array_var($task_data, 'start_date')=='') echo " style ='display:none;' "?> >
			<?php echo pick_date_widget('task_start_date', array_var($task_data, 'start_date',mktime()),null,null,array('id'=>'task_start_date')) ?>
			</div>	
		</div>
		
		<div>		
		<script language="javascript">
		function toggle_due_date(){ 
			if(document.getElementById('due_date_div').style.display =='none')
				document.getElementById('due_date_div').style.display='block';
			else
				document.getElementById('due_date_div').style.display='none';
		}
		</script>
		<?php echo checkbox_field('use_due_date',(array_var($task_data, 'due_date')!='')?true:false,array('onclick'=>"javascript:toggle_due_date();") ) ?>
		<?php echo lang('use due date')  ?> <br> 
			<div id="due_date_div" <?php  if (array_var($task_data, 'due_date')=='') echo " style = 'display:none;' "?> >
			<?php echo pick_date_widget('task_due_date', array_var($task_data, 'due_date',mktime()),null,null,array('id'=>'task_due_date')) ?>
			</div>	
		</div>
 	</fieldset>
   	</div>	
   	
	<div><?php echo label_tag(lang('description'), $genid . 'taskListFormDescription') ?>
	<?php echo textarea_field('task[text]', array_var($task_data, 'text'), array('class' => 'short', 'id' => $genid . 'taskListFormDescription')) ?>
	</div>
	
	<div><?php echo label_tag(lang('parent task'), $genid . 'addTaskTaskList') ?>
	<?php echo select_task_list('task[parent_id]', active_project(), array_var($task_data, 'parent_id'), false, array('id' => $genid . 'addTaskTaskList')) ?>
	</div>

	<div>
		<label><?php echo lang('assign to') ?>:</label> 
		<?php echo assign_to_select_box("task[assigned_to]", active_project(), array_var($task_data, 'assigned_to')) ?>
	</div>

  <?php echo submit_button($task->isNew() ? lang('add task list') : lang('save changes'), 's', array('tabindex' => '1')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>taskListFormName').focus();
</script>