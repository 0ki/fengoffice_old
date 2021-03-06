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
  set_page_title($task_list->isNew() ? lang('add task list') : lang('edit task list'));
  $project = active_or_personal_project();
  $projects =  active_projects();
?>
<?php if($task_list->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('task', 'add_list') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $task_list->getEditListUrl() ?>" method="post">
<?php } // if ?>

<div class="task">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php echo $task_list->isNew() ? lang('new task list') : lang('edit task list') ?>
	</td><td style="text-align:right"><?php echo submit_button($task_list->isNew() ? lang('add task list') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
		<?php echo label_tag(lang('name'), 'taskListFormName', true) ?>
    	<?php echo text_field('task_list[title]', array_var($task_list_data, 'title'), 
    		array('class' => 'title', 'id' => 'taskListFormName', 'tabindex' => '1')) ?>
    </div>
	
	<div style="padding-top:5px">
		<?php if (isset ($projects) && count($projects) > 0) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('add_list_select_workspace_div', this)"><?php echo lang('workspace') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_description_div', this)"><?php echo lang('description') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_milestone_div', this)"><?php echo lang('milestone') ?></a> - 
		<?php if($task_list->isNew()) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('add_list_tasks_div', this)"><?php echo lang('tasks') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_handins_div', this)"><?php echo lang('handins') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_options_div', this)"><?php echo lang('options') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_properties_div', this)"><?php echo lang('properties') ?></a> -
		<?php if(!$task_list->isNew() && $project instanceof Project && $task_list->canLinkObject(logged_user(), $project)) { ?>  
			<a href="#" class="option" onclick="og.toggleAndBolden('add_task_list_linked_objects_div', this)"><?php echo lang('linked objects') ?></a> -
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_list_dates_div', this)"><?php echo lang('dates') ?></a>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<?php if (isset ($projects) && count($projects) > 0) { ?>
	<div id="add_list_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project('task_list[project_id]', $projects, ($project instanceof Project)? $project->getId():0) ?>
	</fieldset>
	</div>
	<?php } ?>

	<div id="add_list_tags_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('tags') ?></legend>
		<?php echo autocomplete_textfield("task_list[tags]", array_var($task_list_data, 'tags'), 'allTags', array('class' => 'long')); ?>
	</fieldset>
	</div>

	<div id="add_list_description_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('description') ?></legend>
		<?php echo textarea_field('task_list[text]', array_var($task_list_data, 'text'), array('class' => 'short', 'id' => 'taskListFormDescription')) ?>
	</fieldset>
	</div>
	
	<div id="add_list_milestone_div" style="display:none">
  	<fieldset>
    <legend><?php echo lang('milestone') ?></legend>
    	<?php echo select_milestone('task_list[milestone_id]', $project, array_var($task_list_data, 'milestone_id'), array('id' => 'taskListFormMilestone')) ?>
  	</fieldset>
  	</div>

<?php if($task_list->isNew()) { ?>
 	<div id="add_list_tasks_div" style="display:none">
 	<fieldset>
    <legend><?php echo lang('tasks') ?></legend>
	  <table class="blank">
	    <tr>
	      <th><?php echo lang('task') ?>:</th>
	      <th><?php echo lang('assign to') ?>:</th>
	    </tr>
	<?php for($i = 0; $i < 6; $i++) { ?>
	    <tr style="background: <?php echo $i % 2 ? '#fff' : '#e8e8e8' ?>">
	      <td>
	        <?php echo textarea_field("task_list[task$i][title]", array_var($task_list_data["task$i"], 'title'), array('class' => 'short')) ?>
	      </td>
	      <td>
	        <?php echo assign_to_select_box("task_list[task$i][assigned_to]", active_or_personal_project(), array_var($task_list_data["task$i"], 'assigned_to')) ?>
	      </td>
	    </tr>
	<?php } // for ?>
	  </table>
  	</fieldset>
	</div>
<?php } // if ?>
  
	<div style="display:none" id="add_list_handins_div">
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
	        if($task_list->isNew())
	        	$attr =  array('class' => 'long');
	        else 
	        	 $attr = array('class' => 'long', 'disabled' => 'true');
	        echo text_field("task_list[handin$i][title]", array_var($task_list_data["handin$i"], 'title'), $attr) ?>
	      </td>
	      <td>
	        <?php echo assign_to_select_box("task_list[handin$i][assigned_to]", active_or_personal_project(), array_var($task_list_data["handin$i"], 'assigned_to'), $task_list->isNew()?null:array( 'disabled' => 'true')) ?>
	      </td>
	    </tr>
		<?php } // for ?>
	  </table>
	</fieldset>
  	</div>
  
<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
	<div id="add_list_options_div" style="display:none">
  	<fieldset>
    <legend><?php echo lang('options') ?></legend>
	    <label><?php echo lang('private task list') ?>: <span class="desc">(<?php echo lang('private task list desc') ?>)</span></label>
	    <?php echo yes_no_widget('task_list[is_private]', 'taskListFormIsPrivate', array_var($task_list_data, 'is_private'), lang('yes'), lang('no')) ?>
	</fieldset>
   	</div>
<?php } // if ?>
	
	<div id='add_list_properties_div' style="display:none">
	<fieldset>
    <legend><?php echo lang('properties') ?></legend>
      <? echo render_object_properties('task_list',$task_list); ?>
  	</fieldset>
 	</div>
  
    <?php if(!$task_list->isNew() && $task_list->canLinkObject(logged_user(), $projects)) { ?>
    <div style="display:none" id="add_task_list_linked_objects_div">
	<fieldset>
    <legend><?php echo lang('linked objects') ?></legend>
    	<?php echo render_object_links($task_list) ?>
	</fieldset>
	</div>
	<?php } // if ?>
	<div id="add_list_dates_div" style="display:none">
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
		<?php echo checkbox_field('use_start_date',(array_var($task_list_data, 'start_date')!='')?true:false,array('onclick'=>"javascript:toggle_start_date();") ) ?>
		<?php echo lang('use start date') ?> <br> 
			<div id="start_date_div" <?php  if (array_var($task_list_data, 'start_date')=='') echo " style ='display:none;' "?> >
			<?php echo pick_date_widget('task_start_date', array_var($task_list_data, 'start_date',mktime()),null,null,array('id'=>'task_start_date')) ?>
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
		<?php echo checkbox_field('use_due_date',(array_var($task_list_data, 'due_date')!='')?true:false,array('onclick'=>"javascript:toggle_due_date();") ) ?>
		<?php echo lang('use due date')  ?> <br> 
			<div id="due_date_div" <?php  if (array_var($task_list_data, 'due_date')=='') echo " style = 'display:none;' "?> >
			<?php echo pick_date_widget('task_due_date', array_var($task_list_data, 'due_date',mktime()),null,null,array('id'=>'task_due_date')) ?>
			</div>	
		</div>
 	</fieldset>
   	</div>	
	
	<?php if(!$task_list->isNew()) { ?>
		<div><?php echo label_tag(lang('parent task'), 'addTaskTaskList') ?>
	<?php echo select_task_list('task_list[parent_id]', active_project(), array_var($task_list_data, 'parent_id'), false, array('id' => 'addTaskTaskList')) ?>
		</div>
	<?php } // if ?>

	<div>
		<label><?php echo lang('assign to') ?>:</label> 
		<?php echo assign_to_select_box("task_list[assigned_to]", active_project(), array_var($task_list_data, 'assigned_to')) ?>
	</div>
	
  <?php echo submit_button($task_list->isNew() ? lang('add task list') : lang('save changes'), 's', array('tabindex' => '1')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('taskListFormName').focus();
</script>