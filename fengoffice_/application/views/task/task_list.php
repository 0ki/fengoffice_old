<?php  $task_list = $object;
		//$on_list_page = $variables["on_list_page"];
	
?>

<script type="text/javascript">
  if(App.modules.addTaskForm) {
    App.modules.addTaskForm.task_lists[<?php echo $task_list->getId() ?>] = {
      id               : <?php echo $task_list->getId() ?>,
	      can_add_task     : <?php echo $task_list->canAddSubTask(logged_user()) ? 'true' : 'false' ?>,
      add_task_link_id : 'addTaskForm<?php echo $task_list->getId() ?>ShowLink',
      task_form_id     : 'addTaskForm<?php echo $task_list->getId() ?>',
      text_id          : 'addTaskText<?php echo $task_list->getId() ?>',
      assign_to_id     : 'addTaskAssignTo<?php echo $task_list->getId() ?>',
      submit_id        : 'addTaskSubmit<?php echo $task_list->getId() ?>'
    };
  } // if
</script>
  
<?php if($task_list->getText()) { ?>
  <pre style="padding-bottom:15px;color:#666666"><?php echo $task_list->getText() ?></pre>
<?php } // if ?>




  <table style="border:1px solid #B1BFAC;width:100%; padding-left:10px;"><tr><th style="padding-left:10px;padding-top:4px;padding-bottom:4px;background-color:#B1BFAC;font-size:120%;font-weight:bolder;color:white;width:100%;"><?php echo lang("open tasks") ?></th></tr><tr><td style="padding-left:10px;">
  <div class="openTasks">
<?php if(is_array($task_list->getOpenSubTasks())) { ?>
    <table class="blank">
<?php foreach($task_list->getOpenSubTasks() as $task) { ?>
      <tr>
      
<!-- Checkbox -->
<?php if($task->canChangeStatus(logged_user())) { ?>
    <td class="taskCheckbox"><?php echo checkbox_link($task->getCompleteUrl(rawurlencode(get_url('task', 'view_task', array('id' => $task_list->getId())))), false, lang('mark task as completed')) ?></td>
<?php } else { ?>
        <td class="taskCheckbox"><img src="<?php echo icon_url('not-checked.jpg') ?>" alt="<?php echo lang('open task') ?>" /></td>
<?php } // if?>

<!-- Task text and options -->
        <td class="taskText">
<?php if($task->getAssignedTo()) { ?>
          <span class="assignedTo"><?php echo clean($task->getAssignedTo()->getObjectName()) ?>:</span> 
<?php } // if{ ?>
          <a class="internalLink" href="<?php echo $task->getObjectUrl() ?>"><?php echo ($task->getTitle() && $task->getTitle()!='' )?clean($task->getTitle()):clean($task->getText()) ?></a> <?php if($task->canEdit(logged_user())) { ?><a class="internalLink blank" href="<?php echo $task->getEditListUrl() ?>" title="<?php echo lang('edit task') ?>"><img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a><?php } // if ?> <?php if($task->canDelete(logged_user())) { ?><a class="internalLink blank" href="<?php echo $task->getDeleteUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete task') ?>')" title="<?php echo lang('delete task') ?>"><img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a><?php } // if ?>
        </td>
      </tr>
<?php } // foreach ?>
   </table>
<?php } else { ?>
  <?php echo lang('no open task in task list') ?>
<?php } // if ?></div>
  
  
    
  <div class="addTask">
<?php if($task_list->canAddSubTask(logged_user())) { ?>
    <div id="addTaskForm<?php echo $task_list->getId() ?>ShowLink"><a class="internalLink" href="<?php echo $task_list->getAddTaskUrl(false) ?>" onclick="App.modules.addTaskForm.showAddTaskForm(<?php echo $task_list->getId() ?>); return false"><?php echo lang('add sub task') ?></a></div>
  
    <div id="addTaskForm<?php echo $task_list->getId() ?>" style="display:none">
      <form class="internalForm" action="<?php echo $task_list->getAddTaskUrl(false) ?>" method="post">
        <div class="taskListAddTaskText">
          <label for="addTaskText<?php echo $task_list->getId() ?>"><?php echo lang('name') ?>:</label>
          <?php echo textarea_field("task[title]", null, array('class' => 'short', 'id' => 'addTaskText' . $task_list->getId())) ?>
        </div>
        <div class="taskListAddTaskAssignedTo">
          <label for="addTaskAssignTo<?php echo $task_list->getId() ?>"><?php echo lang('assign to') ?>:</label>
          <?php echo assign_to_select_box("task[assigned_to]", $task_list->getProject(), null, array('id' => 'addTaskAssignTo' . $task_list->getId())) ?>
        </div>
        
        <?php echo submit_button(lang('add sub task'), 's', array('id' => 'addTaskSubmit' . $task_list->getId())) ?> <?php echo lang('or') ?> <a href="#" onclick="App.modules.addTaskForm.hideAddTaskForm(<?php echo $task_list->getId() ?>); return false;"><?php echo lang('cancel') ?></a>
        
      </form>
    </div>
<?php } else { ?>
	<?php if($on_list_page) { ?>
	<?php echo lang('completed tasks') ?>:
	<?php } else { ?>
	<?php echo lang('recently completed tasks') ?>:
	<?php } // if ?>
<?php } // if ?>
  </div>
</td></tr></table>

<br/>


  
<?php if(is_array($task_list->getCompletedSubTasks())) { ?>
<table style="border:1px solid #B1BFAC;width:100%; padding-left:10px;"><tr><th style="padding-left:10px;padding-top:4px;padding-bottom:4px;background-color:#B1BFAC;font-size:120%;font-weight:bolder;color:white;width:100%;"><?php echo lang("completed tasks") ?></th></tr><tr><td style="padding-left:10px;">
  
  <div class="completedTasks">
    <table class="blank">
<?php $counter = 0; ?>
<?php foreach($task_list->getCompletedSubTasks() as $task) { ?>
<?php $counter++; ?>
<?php if($on_list_page || ($counter <= 5)) { ?>
      <tr>
<?php if($task->canChangeStatus(logged_user())) { ?>
    <td class="taskCheckbox"><?php echo checkbox_link($task->getOpenUrl(rawurlencode(get_url('task', 'view_task', array('id' => $task_list->getId())))), true, lang('mark task as open')) ?></td>
<?php } else { ?>
        <td class="taskCheckbox"><img src="<?php echo icon_url('checked.jpg') ?>" alt="<?php echo lang('completed task') ?>" /></td>
<?php } // if ?>
        <td class="taskText">
        	<a class="internalLink" href="<?php echo $task->getObjectUrl() ?>"><?php echo clean($task->getTitle()) ?></a> 
          <?php if($task->canEdit(logged_user())) { ?><a class="internalLink" href="<?php echo $task->getEditListUrl() ?>" class="blank" title="<?php echo lang('edit task') ?>"><img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a><?php } // if ?> <?php if($task->canDelete(logged_user())) { ?><a href="<?php echo $task->getDeleteUrl() ?>" class="blank internalLink" onclick="return confirm('<?php echo lang('confirm delete task') ?>')" title="<?php echo lang('delete task') ?>"><img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a><?php } // if ?><br />
          <span class="taskCompletedOnBy">(<?php echo lang('completed on by', format_date($task->getCompletedOn()), $task->getCompletedBy()->getCardUrl(), clean($task->getCompletedBy()->getDisplayName())) ?>)</span>
        </td>
        <td></td>
      </tr>
<?php } // if ?>
<?php } // foreach ?>
<?php if(!$on_list_page && $counter > 5) { ?>
      <tr>
        <td colspan="2"><a class="internalLink" href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('view all completed tasks', $counter) ?></a></td>
      </tr>
<?php } // if ?>
    </table>
  </div>
</td></tr></table>
<?php } // if ?>

  