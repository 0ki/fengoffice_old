<?php
  //add_stylesheet_to_page('project/task_list.css');
  
  if($task_list->canEdit(logged_user())) {
    add_page_action(lang('edit'), $task_list->getEditListUrl(), 'ico-edit');
  } // if
  if($task_list->canDelete(logged_user())) {
    add_page_action(lang('delete'), $task_list->getDeleteListUrl(), 'ico-delete');
  } // if
  if($task_list->canReorderTasks(logged_user())) {
    add_page_action(lang('reorder sub tasks'), $task_list->getReorderTasksUrl($on_list_page), 'ico-properties');
  } // if
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


<div style="padding:7px">
<div class="task">
<div class="coContainer">
  <div class="coHeader">
  <div class="coHeaderUpperRow">
  <?php if($task_list->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private task list') ?>"><span><?php echo lang('private task list') ?></span></div>
<?php } // if ?>
	<div class="coTitle"><?php echo $task_list->getTitle() != '' ? $task_list->getTitle() : $task_list->getText() ?></div>
	<div class="coTags"><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($task_list) ?></div>
  </div>
  <div class="coInfo">
  	<?php if ($task_list->getParent() instanceof ProjectTask) {
  		$parent = $task_list->getParent(); ?>
  		<?php echo lang('subtask of', $parent->getViewUrl(), $parent->getTitle() != ''? $parent->getTitle() : $parent->getText()) ?>
  	<?php }?>
  </div>
  </div>
  
  <div class="coMainBlock">
  <div class="coLinkedObjects">
  <?php echo render_object_links($task_list, $task_list->canEdit(logged_user())) ?>
  </div>
  <div class="coContent">
  
<?php if($task_list->getText()) { ?>
  <div class="desc"><?php echo clean($task_list->getText()) ?></div>
<?php } // if ?>
  <div class="openTasks">
<?php if(is_array($task_list->getOpenSubTasks())) { ?>
    <table class="blank">
<?php foreach($task_list->getOpenSubTasks() as $task) { ?>
      <tr>
      
<!-- Checkbox -->
<?php if($task->canChangeStatus(logged_user())) { ?>
    <td class="taskCheckbox"><?php echo checkbox_link($task->getCompleteUrl(), false, lang('mark task as completed')) ?></td>
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
<?php } // if ?>
  </div>
  
  <div class="addTask">
<?php if($task_list->canAddSubTask(logged_user())) { ?>
    <div id="addTaskForm<?php echo $task_list->getId() ?>ShowLink"><a class="internalLink" href="<?php echo $task_list->getAddTaskUrl($on_list_page) ?>" onclick="App.modules.addTaskForm.showAddTaskForm(<?php echo $task_list->getId() ?>); return false"><?php echo lang('add sub task') ?></a></div>
  
    <div id="addTaskForm<?php echo $task_list->getId() ?>" style="display:none">
      <form class="internalForm" action="<?php echo $task_list->getAddTaskUrl($on_list_page) ?>" method="post">
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
  
<?php if(is_array($task_list->getCompletedSubTasks())) { ?>
  <div class="completedTasks">
    <table class="blank">
<?php $counter = 0; ?>
<?php foreach($task_list->getCompletedSubTasks() as $task) { ?>
<?php $counter++; ?>
<?php if($on_list_page || ($counter <= 5)) { ?>
      <tr>
<?php if($task->canChangeStatus(logged_user())) { ?>
    <td class="taskCheckbox"><?php echo checkbox_link($task->getOpenUrl(), true, lang('mark task as open')) ?></td>
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
<?php } // if ?>
	</div>
  
  <?php echo render_object_comments($task_list) ?>
  </div>
</div>
  </div>
</div>