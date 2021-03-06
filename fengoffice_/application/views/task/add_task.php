<?php
	$genid = gen_id();
?>

<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $task->isNew() ? get_url('task', 'add_task', array("copyId" => array_var($task_data, 'copyId'))) : $task->getEditListUrl() ?>" method="post">

<div class="task">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php
		if ($task->isNew()) {
			if (array_var($task_data, 'is_template', false)) {
				echo lang('new task template');
			} else if (isset($base_task) && $base_task instanceof ProjectTask) {
				echo lang('new task from template');
			} else {
				echo lang('new task list');
			}
		} else if ($task->getIsTemplate()) {
			echo lang('edit task template');
		} else {
			echo lang('edit task list');
		}
	?>
	</td><td style="text-align:right"><?php echo submit_button($task->isNew() ? (array_var($task_data, 'is_template', false) ? lang('save template') : lang('add task list')) : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
		<?php echo label_tag(lang('name'), $genid . 'taskListFormName', true) ?>
    	<?php echo text_field('task[title]', array_var($task_data, 'title'), 
    		array('class' => 'title', 'id' => $genid . 'taskListFormName', 'tabindex' => '1')) ?>
    </div>
	
	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_select_workspace_div', this)"><?php echo lang('workspace') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_more_div', this)"><?php echo lang('task data') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_mail_notif_div', this)"><?php echo lang('email notification') ?></a> - 
		<?php /*<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_handins_div', this)"><?php echo lang('handins') ?></a> - */ ?> 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_properties_div', this)"><?php echo lang('custom properties') ?></a>
		<?php if($task->isNew() || $task->canLinkObject(logged_user())) { ?>  
			 - <a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_task_linked_objects_div', this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

	<div id="<?php echo $genid ?>add_task_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project2('task[project_id]', (array_var($task_data, 'project_id') > 0) ? array_var($task_data, 'project_id'):active_or_personal_project()->getId(), $genid) ?>
	</fieldset>
	</div>

	<div id="<?php echo $genid ?>add_task_tags_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('tags') ?></legend>
		<?php echo autocomplete_tags_field("task[tags]", array_var($task_data, 'tags')); ?>
	</fieldset>
	</div>

	
	<div id="<?php echo $genid ?>add_task_more_div" style="display:none">
  	<fieldset>
    <legend><?php echo lang('task data') ?></legend>
    
	    <label><?php echo lang('milestone') ?>: <span class="desc">(<?php echo lang('assign milestone task list desc') ?>)</span></label>
    	<?php echo select_milestone('task[milestone_id]', null, array_var($task_data, 'milestone_id'), array('id' => $genid . 'taskListFormMilestone')) ?>
    	
    	<div style="padding-top:4px">
    		<?php echo label_tag(lang('parent task'), $genid . 'addTaskTaskList') ?>
			<?php echo select_task_list('task[parent_id]', active_or_personal_project(), array_var($task_data, 'parent_id'), false, array('id' => $genid . 'addTaskTaskList')) ?>
    	</div>
    	
    	<div style="padding-top:4px">	
    	<?php /*echo label_tag(lang('dates'))*/ ?>
    	<table><tbody><tr><td style="padding-right: 10px">
    	<?php echo label_tag(lang('start date')) ?>
    	</td><td>
		<?php echo pick_date_widget2('task_start_date', array_var($task_data, 'start_date'),$genid) ?>
		</td></tr><tr><td style="padding-right: 10px">
		<?php echo label_tag(lang('due date')) ?>
    	</td><td>
		<?php echo pick_date_widget2('task_due_date', array_var($task_data, 'due_date'),$genid) ?>
		</td></tr></tbody></table>
		</div>
		
		<div id='<?php echo $genid ?>add_task_time_div' style="padding-top:6px">
		<?php echo label_tag(lang('time estimate')) ?>
      	<?php $totalTime = array_var($task_data, 'time_estimate', 0); 
      		$minutes = $totalTime % 60;
			$hours = ($totalTime - $minutes) / 60;
      		?>
      		<table>
		<tr>
			<td align="right"><?php echo lang("hours") ?>:&nbsp;</td>
			<td align='left'><?php echo text_field("task[time_estimate_hours]", $hours, array('style' => 'width:30px')) ?></td>
			<td align="right" style="padding-left:10px"><?php echo lang("minutes") ?>:&nbsp;</td>
			<td align='left'><select name="task[time_estimate_minutes]" size="1">
			<?php
				$minutes = ($totalTime % 60);
				$minuteOptions = array(0,5,10,15,20,30,45);
				for($i = 0; $i < 7; $i++) {
					echo "<option value=\"" . $minuteOptions[$i] . "\"";
					if($minutes == $minuteOptions[$i]) echo ' selected="selected"';
					echo ">" . $minuteOptions[$i] . "</option>\n";
				}
			?></select>
			</td>
		</tr></table>
 	</div>
		
		<div style="padding-top:4px">
		<?php echo label_tag(lang('task priority')) ?>
		<?php echo select_task_priority('task[priority]', array_var($task_data, 'priority', ProjectTasks::PRIORITY_NORMAL)) ?>
		</div>
  	</fieldset>
  	</div>

<?php if($task->isNew()) { ?>
	<?php if (isset($base_task) && $base_task instanceof ProjectTask && $base_task->getIsTemplate()) { ?>
		<input type="hidden" name="task[from_template_id]" value="<?php echo $base_task->getId() ?>" />
	<?php } ?>
<?php } // if ?>
	<div id="<?php echo $genid ?>add_task_mail_notif_div" style="display:none">
	<fieldset id="emailNotification">
	<legend><?php echo lang('email notification') ?></legend>
	<p><?php echo lang('email notification desc') ?></p>
	<?php 
		$companies = Companies::findAll();
		foreach($companies as $company) {
			if ($company->getClientOfId() > 0 || $company->getId() == 1){
			$users = $company->getUsers();
			if(is_array($users) && count($users)) { ?>
		<script type="text/javascript">
			App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?> = {
				id          : <?php echo $company->getId() ?>,
				checkbox_id : 'notifyCompany<?php echo $company->getId() ?>',
				users       : []
			};
		</script>
		<div class="companyDetails">
			<div class="companyName">
				<?php echo checkbox_field('task[notify_company_' . $company->getId() . ']', 
					array_var($task_data, 'notify_company_' . $company->getId()), 
					array('id' => $genid.'notifyCompany' . $company->getId(), 
						'onclick' => 'App.modules.addMessageForm.emailNotifyClickCompany(' . $company->getId() . ',"' . $genid. '")')) ?> 
				<label for="<?php echo $genid ?>notifyCompany<?php echo $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
			</div>
			
			<div class="companyMembers">
			<ul>
			<?php foreach($users as $user) { ?>
				<li><?php echo checkbox_field('task[notify_user_' . $user->getId() . ']', 
					array_var($task_data, 'notify_user_' . $user->getId()), 
					array('id' => $genid.'notifyUser' . $user->getId(), 
						'onclick' => 'App.modules.addMessageForm.emailNotifyClickUser(' . $company->getId() . ', ' . $user->getId() . ',"' . $genid. '")')) ?> 
					<label for="<?php echo $genid ?>notifyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?></label>
				<script type="text/javascript">
					App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?>.users.push({
						id          : <?php echo $user->getId() ?>,
						checkbox_id : 'notifyUser<?php echo $user->getId() ?>'
					});
				</script></li>
			<?php } // foreach ?>
			</ul>
			</div>
			</div>
		<?php } // if ?>
		<?php } // if ?>
	<?php } // foreach ?>
	</fieldset>
	</div>

  
	<?php /*<div style="display:none" id="<?php echo $genid ?>add_task_handins_div">
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
  	</div> */ ?>
  
	
	<div id='<?php echo $genid ?>add_task_properties_div' style="display:none">
	<fieldset>
    <legend><?php echo lang('custom properties') ?></legend>
      <?php echo render_object_properties('task',$task); ?>
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
		
   	
	<div><?php echo label_tag(lang('description'), $genid . 'taskListFormDescription') ?>
	<?php echo textarea_field('task[text]', array_var($task_data, 'text'), array('class' => 'short', 'id' => $genid . 'taskListFormDescription')) ?>
	</div>

	<div>
		<label><?php echo lang('assign to') ?>:</label> 
		<table><tr><td><?php echo assign_to_select_box("task[assigned_to]", null, array_var($task_data, 'assigned_to'), array('id' => $genid . 'taskFormAssignedTo', "onchange" => "og.addTaskUserChanged('" . $genid . "')")) ?>
		</td><td style="padding-left:10px"><div  id="<?php echo $genid ?>taskFormSendNotificationDiv">
			<?php echo checkbox_field('task[send_notification]', array_var($task_data, 'send_notification'), array('id' => $genid . 'taskFormSendNotification')) ?>
			<label for="<?php echo $genid ?>taskFormSendNotification" class="checkbox"><?php echo lang('send task assigned to notification') ?></label>
		</div>
		</td></tr></table>
		
	</div>
	
	<?php echo input_field("task[is_template]", array_var($task_data, 'is_template', false), array("type" => "hidden")); ?>

  <?php echo submit_button($task->isNew() ? (array_var($task_data, 'is_template', false) ? lang('save template') : lang('add task list')) : lang('save changes'), 's', array('tabindex' => '1')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>taskListFormName').focus();
</script>