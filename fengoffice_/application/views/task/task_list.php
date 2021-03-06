<?php
require_javascript("og/modules/addTaskForm.js");
$task_list = $object;
$genid = gen_id();
?>
<script>
  if(App.modules.addTaskForm) {
    App.modules.addTaskForm.task_lists[<?php echo $task_list->getId() ?>] = {
      id               : <?php echo $task_list->getId() ?>,
	  can_add_task     : <?php echo ($task_list->canAddSubTask(logged_user()) && !$task_list->isTrashed()) ? 'true' : 'false' ?>,
      add_task_link_id : 'addTaskForm<?php echo $task_list->getId() ?>ShowLink',
      task_form_id     : 'addTaskForm<?php echo $task_list->getId() ?>',
      text_id          : 'addTaskText<?php echo $task_list->getId() ?>',
      assign_to_id     : 'addTaskAssignTo<?php echo $task_list->getId() ?>',
      submit_id        : 'addTaskSubmit<?php echo $task_list->getId() ?>'
    };
  } // if
</script>

<?php if ($task_list->getStartDate() instanceof DateTimeValue) { ?>
	<?php if ($task_list->getStartDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?> 
	  <div class="startDate"><span class="bold"><?php echo lang('start date') ?>: </span><?php echo format_datetime($task_list->getStartDate(), null) ?></div>
	<?php } else { ?> 
	  <div class="startDate"><span class="bold"><?php echo lang('start date') ?>: </span>
	  <?php 
	  	echo format_descriptive_date($task_list->getStartDate());
	  	if ($task_list->getUseStartTime()) {
	  		echo ", " . format_time($task_list->getStartDate(), user_config_option('time_format_use_24') ? 'G:i' : 'g:i A');
	  	}
	  ?>
	  </div>
	<?php } // if ?>
<?php } // if ?>

<?php if ($task_list->getDueDate() instanceof DateTimeValue) { ?>
	<?php if ($task_list->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?> 
	  <div class="dueDate"><span class="bold"><?php echo lang('due date') ?>: </span><?php echo format_datetime($task_list->getDueDate(), null, 0) ?></div>
	<?php } else { ?> 
	  <div class="dueDate"><span class="bold"><?php echo lang('due date') ?>: </span>
	  <?php 
	  	echo format_descriptive_date($task_list->getDueDate());
	  	if ($task_list->getUseDueTime()) {
	  		echo ", " . format_time($task_list->getDueDate(), user_config_option('time_format_use_24') ? 'G:i' : 'g:i A');
	  	}
	  ?>
	  </div>
	<?php } ?>
<?php } ?>
		
<?php if ($task_list->getObjectSubtype() > 0) {
		$subType = ProjectCoTypes::findById($task_list->getObjectSubtype());
		if ($subType instanceOf ProjectCoType ) {
			echo "<div><span class='bold'>" . lang('object type') . ":</span> " . $subType->getName() . "</div>";
		}
	  }
?>

<?php if($task_list->getText()) { ?>
  <fieldset><legend><?php echo lang('description') ?></legend>
	<div class="wysiwyg-description"><?php
		if($task_list->getTypeContent() == "text"){
			echo escape_html_whitespace(convert_to_links(clean($task_list->getText())));
		}else{
			echo purify_html(nl2br($task_list->getText()));
		}
	?></div>
  </fieldset>
<?php } // if 


$showOpenSubtasksDiv = is_array($task_list->getOpenSubTasks()) && count($task_list->getOpenSubTasks()) > 0;
$showCompletedSubtasksDiv = is_array($task_list->getCompletedSubTasks()) && count($task_list->getCompletedSubTasks()) > 0;

if($showOpenSubtasksDiv) { ?>
<table style="border:1px solid #717FA1;width:100%; padding-left:10px;">
<tr><th style="padding-left:10px;padding-top:4px;padding-bottom:4px;background-color:#E8EDF7;font-size:120%;font-weight:bolder;color:#717FA1;width:100%;"><?php echo lang("open subtasks") ?></th></tr>
<tr><td style="padding-left:10px;">
  <div class="openTasks">
    <table class="blank">
<?php foreach($task_list->getOpenSubTasks() as $task) { ?>
      <tr>
<!-- Checkbox -->
<?php if($task->canChangeStatus(logged_user()) && !$task_list->isTrashed()) { ?>
    <td class="taskCheckbox"><?php echo checkbox_link($task->getCompleteUrl(rawurlencode(get_url('task', 'view', array('id' => $task_list->getId())))), false, lang('mark task as completed')) ?></td>
<?php } else { ?>
        <td class="taskCheckbox"><img src="<?php echo icon_url('not-checked.jpg') ?>" alt="<?php echo lang('open task') ?>" /></td>
<?php } // if?>

<!-- Task text and options -->
        <td class="taskText">
<?php if($task->getAssignedTo()) { ?>
          <span class="assignedTo"><?php echo clean($task->getAssignedTo()->getObjectName()) ?>:</span> 
<?php } // if{ ?>
          <a class="internalLink" href="<?php echo $task->getObjectUrl() ?>"><?php echo ($task->getObjectName() && $task->getObjectName()!='' )?clean($task->getObjectName()):clean($task->getText()) ?></a> 
          <?php if($task->canEdit(logged_user()) && !$task->isTrashed()) { ?>
          	<a class="internalLink blank" href="<?php echo $task->getEditListUrl() ?>" title="<?php echo lang('edit task') ?>">
          	<img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a>
          <?php } // if ?>
          <?php if($task->canDelete(logged_user()) && !$task->isTrashed()) { ?>
          	<a class="internalLink blank" href="<?php echo $task->getDeleteUrl() ?>&taskview=true" onclick="return confirm('<?php echo escape_single_quotes(lang('confirm delete task')) ?>')" title="<?php echo lang('delete task') ?>">
          	<img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a>
          <?php } // if ?>
        </td>
      </tr>
      <!-- start timeslot subtask-->
      <?php
	$timeslots = $task->getTimeslots();
	$countTimeslots = 0;
	if (is_array($timeslots) && count($timeslots))
		$countTimeslots = count($timeslots);
	$random = rand();
	$open_timeslot = null;
        if($countTimeslots > 0){
      ?>
      <tr>
          <td>&nbsp;</td>
          <td colspan="4">
              <table style="width:100%;max-width:700px" class="objectTimeslots" style="<?php echo $countTimeslots > 0? '':'display:none'?>">
                <?php           
                $counter = 0;
		foreach($timeslots as $timeslot) {
			$counter++;
			$options = array();
			if (!$task->isTrashed() && $timeslot->canEdit(logged_user())) {
				$options[] = '<a class="internalLink" href="' . $timeslot->getEditUrl() . '"><img src="'. icon_url('edit.gif') .'" alt="" /></a>';
			}
			if (!$task->isTrashed() && $timeslot->canDelete(logged_user())) 
				$options[] = '<a class="internalLink" href="' . $timeslot->getDeleteUrl() . '" onclick="return confirm(\'' . escape_single_quotes(lang('confirm delete timeslot')) . '\')"><img src="'. icon_url('cancel_gray.gif') .'" alt="" /></a>';
				
			if (!$task->isTrashed() && $timeslot->isOpen() && $timeslot->getContactId() == logged_user()->getId() && $timeslot->canEdit(logged_user())){
				$open_timeslot = $timeslot;
				$counter --;
			} else {
                ?>
                            <tr class="timeslot <?php echo $counter % 2 ? 'even' : 'odd'; echo $timeslot->isOpen() ? ' openTimeslot' : '' ?>" id="timeslot<?php echo $timeslot->getId() ?>">
                            <td style="padding-right:10px"><b><?php echo $counter ?>.</b></td>
                            <?php if ($timeslot->getUser() instanceof Contact) { ?>
                                    <td style="padding-right:10px"><b><a class="internalLink" href="<?php echo $timeslot->getUser()->getCardUserUrl()?>" title=" <?php echo lang('user card of', clean($timeslot->getUser()->getObjectName())) ?>"><?php echo clean($timeslot->getUser()->getObjectName()) ?></a></b></td>
                            <?php } else {?>
                                    <td style="padding-right:10px"><b><?php echo lang("n/a") ?></b></td>
                            <?php } ?>
                            <td style="padding-right:10px"><?php echo format_datetime($timeslot->getStartTime())?>
                                    &nbsp;-&nbsp;<?php echo $timeslot->isOpen() ? ('<b>' . lang('work in progress') . '</b>') : 
                                    ( (format_date($timeslot->getEndTime()) != format_date($timeslot->getStartTime()))?  format_datetime($timeslot->getEndTime()): format_time($timeslot->getEndTime())) ?></td>
                            <td style="padding-right:10px">
                                    <?php 
                                            echo DateTimeValue::FormatTimeDiff($timeslot->getStartTime(), $timeslot->getEndTime(), "hm", 60, $timeslot->getSubtract());
                                            if ($timeslot->getSubtract() > 0) {
                                                    $now = DateTimeValueLib::now();
                                                    echo " <span class='desc'>(" . lang('paused time') . ": " . DateTimeValue::FormatTimeDiff($now, $now, "hm", 60, $timeslot->getSubtract()) .")</span>";
                                            }
                                    ?>
                            </td>
                            <td align="right">
                            <?php if(count($options)) { ?>
                                            <?php echo implode(' ', $options) ?>
                            <?php } // if ?>
                            </td>
                            </tr>

                            <?php if ($timeslot->getDescription() != '') {?>
                                    <tr class="timeslot <?php echo $counter % 2 ? 'even' : 'odd'; echo $timeslot->isOpen() ? ' openTimeslot' : '' ?>" ><td></td>
                                    <td colspan=6 style="color:#666666"><?php echo clean($timeslot->getDescription()) ?></td></tr>
                            <?php } //if ?>
                    <?php } //if 
		} // foreach ?>
		</table>
          </td>
      </tr>
      <!-- end timeslot subtask-->
    <?php } //if countTimeslot} ?>
    <?php } // foreach ?>
   </table>
<?php } // if?>
  
  <div class="addTask">
<?php if($task_list->canAddSubTask(logged_user()) && !$task_list->isTrashed()) { ?>
    <div id="addTaskForm<?php echo $task_list->getId() ?>ShowLink"><a class="internalLink" href="<?php echo $task_list->getAddTaskUrl(false) ?>" onclick="App.modules.addTaskForm.showAddTaskForm(<?php echo $task_list->getId() ?>); return false"><?php echo lang('add sub task') ?></a></div>
  
    <div id="addTaskForm<?php echo $task_list->getId() ?>" style="display:none">
      <form class="internalForm" action="<?php echo $task_list->getAddTaskUrl(false) ?>" method="post">
        <div class="taskListAddTaskFields">
          <label for="addTaskTitle<?php echo $task_list->getId() ?>"><?php echo lang('name') ?>:</label>
          <?php echo text_field("task[name]", null, array('class' => 'title', 'id' => 'addTaskTitle' . $task_list->getId())) ?>
          <label for="addTaskText<?php echo $task_list->getId() ?>"><?php echo lang('description') ?>:</label>
          <?php echo textarea_field("task[text]", null, array('class' => 'short', 'id' => 'addTaskText' . $task_list->getId())) ?>
        </div>
        <div style="padding-top:4px">   
	      <?php /*echo label_tag(lang('dates'))*/ ?>
	      <table><tbody><tr><td style="padding-right: 10px">
	      <?php echo label_tag(lang('start date')) ?>            
	      </td><td>
	      	<div style="float:left;"><?php echo pick_date_widget2('task_start_date', array_var($task_data, 'start_date'),$genid, 60) ?></div>
	      	<?php if (config_option('use_time_in_task_dates')) { ?>
	      	<div style="float:left;margin-left:10px;"><?php echo pick_time_widget2('task_start_time', array_var($task_data, 'start_date'), $genid, 65); ?></div>
	      	<?php } ?>
	      </td></tr><tr><td style="padding-right: 10px">
	      <?php echo label_tag(lang('due date')) ?>
	      </td><td>
	      	<div style="float:left;"><?php echo pick_date_widget2('task_due_date', array_var($task_data, 'due_date'),$genid, 70) ?></div>
	      	<?php if (config_option('use_time_in_task_dates')) { ?>
	      	<div style="float:left;margin-left:10px;"><?php echo pick_time_widget2('task_due_time', array_var($task_data, 'due_date'), $genid, 65); ?></div>
	      	<?php } ?>
	      </td></tr><tr><td style="padding-right: 10px">
	      	<label><?php echo lang('assign to') ?>:</label>
	      </td><td>
	       	<div class="taskListAddTaskAssignedTo" style="margin-top:1px;">
	      	<?php
	      		echo assign_to_select_box('task[assigned_to_contact_id]', $task_list->getMembers(), $task_list->getAssignedToContactId());
	      	?>
	      	</div>
	      </td></tr></tbody></table>
		</div>
		<input type="hidden" id="addTaskMilestoneId<?php echo $task_list->getId() ?>" name="task[milestone_id]" value="<?php echo $task_list->getMilestoneId() ?>"/>
		<input type="hidden" id="addTaskPriority<?php echo $task_list->getId() ?>" name="task[priority]" value="<?php echo $task_list->getPriority() ?>"/>
		<input type="hidden" id="addTaskInputType<?php echo $task_list->getId() ?>" name="task[inputtype]" value="taskview"/>
        <?php echo submit_button(lang('add sub task'), 's', array('id' => 'addTaskSubmit' . $task_list->getId(), 'fromTaskView' => 'true')) ?> <?php echo lang('or') ?> <a href="#" onclick="App.modules.addTaskForm.hideAddTaskForm(<?php echo $task_list->getId() ?>); return false;"><?php echo lang('cancel') ?></a>
      </form>
    </div>
<?php } // if ?>
  </div>
  <?php if(is_array($task_list->getOpenSubTasks()) && count($task_list->getOpenSubTasks()) > 0) { ?>
</div></td></tr></table>
<?php } // if


if($showCompletedSubtasksDiv) { ?>
<br/>
  <table style="border:1px solid #717FA1;width:100%; padding-left:10px;">
  <tr><th style="padding-left:10px;padding-top:4px;padding-bottom:4px;background-color:#E8EDF7;font-size:120%;font-weight:bolder;color:#717FA1;width:100%;"><?php echo lang("completed subtasks") ?></th></tr>
  <tr><td style="padding-left:10px;">
  <div class="completedTasks">
    <table class="blank">
<?php $counter = 0; ?>
<?php foreach($task_list->getCompletedSubTasks() as $task) { ?>
<?php $counter++; ?>
<?php if($on_list_page || ($counter <= 5)) { ?>
      <tr>
<?php if($task->canChangeStatus(logged_user()) && !$task->isTrashed()) { ?>
    <td class="taskCheckbox"><?php echo checkbox_link($task->getOpenUrl(rawurlencode(get_url('task', 'view', array('id' => $task_list->getId())))), true, lang('mark task as open')) ?></td>
<?php } else { ?>
        <td class="taskCheckbox"><img src="<?php echo icon_url('checked.jpg') ?>" alt="<?php echo lang('completed task') ?>" /></td>
<?php } // if ?>
        <td class="taskText">
        	<a class="internalLink" href="<?php echo $task->getObjectUrl() ?>"><?php echo clean($task->getObjectName()) ?></a> 
          <?php if($task->canEdit(logged_user()) && !$task->isTrashed()) { ?>
          	<a class="internalLink" href="<?php echo $task->getEditListUrl() ?>" class="blank" title="<?php echo lang('edit task') ?>">
          	<img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a>
          <?php } // if ?> 
          <?php if($task->canDelete(logged_user()) && !$task->isTrashed()) { ?>
          	<a href="<?php echo $task->getDeleteUrl() ?>" class="blank internalLink" onclick="return confirm('<?php echo escape_single_quotes(lang('confirm delete task')) ?>')" title="<?php echo lang('delete task') ?>">
          	<img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a>
          <?php } // if ?>
          <br />
          <?php if ($task->getCompletedBy() instanceof Contact) {?>
          	<span class="taskCompletedOnBy">(<?php echo lang('completed on by', format_date($task->getCompletedOn()), $task->getCompletedBy()->getCardUserUrl(), clean($task->getCompletedBy()->getObjectName())) ?>)</span>
          <?php } else { ?>
          <span class="taskCompletedOnBy">(<?php echo lang('completed on by', format_date($task->getCompletedOn()), "#", lang("n/a")) ?>)</span>
          <?php } ?>
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
<?php } // if 


$time_estimate = $task_list->getTimeEstimate();
$total_minutes = $task_list->getTotalMinutes();

if ($time_estimate >= 0 || $total_minutes >=0){?>
<br/>
<table>
<tr>
	<td><div style="font-weight:bold"><?php echo lang('percent completed'). ':&nbsp;'?></div></td>
	<td><?php echo taskPercentCompletedBar($task_list) //$task_list->getPercentCompleted() . "%"; ?></td>
</tr>

<?php if ($time_estimate > 0) {?>
<tr><td>
	<div style="font-weight:bold"><?php echo lang('estimated time'). ':&nbsp;'?></div></td><td> 
		<?php echo DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($time_estimate * 60), 'hm', 60) ?></td></tr>
<?php } ?>

<?php if ($total_minutes > 0) {?>
	<tr><td><div style="font-weight:bold"><?php echo lang('total time worked'). ':&nbsp;' ?></div></td><td>
		<span style="font-size:120%;font-weight:bold;<?php echo ($time_estimate > 0 && $total_minutes > $time_estimate) ? 'color:#FF0000':'' ?>">
			<?php echo DateTimeValue::FormatTimeDiff(new DateTimeValue(0), new DateTimeValue($total_minutes * 60), 'hm', 60) ?>
		</span></td></tr>
<?php } ?>
</table>

<div class="desc"><?php echo lang('percent completed detail', isset($counter) ? $counter : '0') ?></div>

<?php } ?>

<?php if ($task_list->isRepetitive()) { ?>
	<div style="font-weight:bold">
	<?php 
		echo '<br>' . lang('this task repeats'). '&nbsp;';
		if ($task_list->getRepeatForever()) echo lang('forever');
		else if ($task_list->getRepeatNum()) echo lang('n times', $task_list->getRepeatNum());
		else if ($task_list->getRepeatEnd()) echo lang('until x', format_date($task_list->getRepeatEnd()));
		echo ", " . lang ('every') . " ";
		if ($task_list->getRepeatD() > 0) echo lang('n days', $task_list->getRepeatD()) . ".";
		else if ($task_list->getRepeatM() > 0) echo lang('n months', $task_list->getRepeatM()) . ".";
		else if ($task_list->getRepeatY() > 0) echo lang('n years', $task_list->getRepeatY()) . ".";
	?>
	</div>
<?php }



if (config_option('use tasks dependencies')) {
	echo '<div style="margin-top:10px">';
	$this->includeTemplate(get_template_path('previous_task_list', 'task'));
	echo '<div>';
}
?>
<script>
var parent_width = $(".wysiwyg-description").parent().parent().width() - 20;
$(".wysiwyg-description").css("word-wrap", "break-word").css("width", parent_width);
</script>