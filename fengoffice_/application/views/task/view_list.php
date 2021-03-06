<?php

  set_page_title($task_list->getTitle());
  project_tabbed_navigation(PROJECT_TAB_TASKS);
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getTitle())
  ));
  if(!$task_list->isCompleted() && $task_list->canEdit(logged_user())) {
    add_page_action(lang('do complete'), $task_list->getCompleteUrl(rawurlencode(get_url('task','view_task',array('id'=>$task_list->getId())))) , 'ico-complete');
  } // if
  if($task_list->isCompleted() && $task_list->canEdit(logged_user())) {
    add_page_action(lang('open task'), $task_list->getOpenUrl(rawurlencode(get_url('task','view_task',array('id'=>$task_list->getId())))) , 'ico-reopen');
  } // if
  
  if(active_project() && ProjectTask::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task'), get_url('task', 'add_task'), 'ico-task');
  } // if
//add_javascript_to_page('modules/addTaskForm.js');  
  if($task_list->canEdit(logged_user())) {
    add_page_action(lang('edit'), $task_list->getEditListUrl(), 'ico-edit');
  } // if
  if($task_list->canDelete(logged_user())) {
    add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete task list'))) og.openLink('" . $task_list->getDeleteListUrl() ."');", 'ico-delete');
  } // if
  add_page_action(lang('copy task'), get_url("task", "copy_task", array("id" => $task_list->getId())), 'ico-copy');
  
  add_page_action(lang('save as template'), get_url("task", "new_template", array("id" => $task_list->getId())), 'ico-template-task');

  
  //TODO Fix reorder subtasks
  /*if($task_list->canReorderTasks(logged_user()) && is_array($task_list->getOpenSubTasks())) {
    add_page_action(lang('reorder sub tasks'), $task_list->getReorderTasksUrl($on_list_page), 'ico-properties');
  } // if*/
	$this->assign('on_list_page', true); 
?>

<div style="padding:7px">
<div class="tasks">
<?php
	$title = $task_list->getTitle() != '' ? $task_list->getTitle() : $task_list->getText();
	$description = '';
	
	if ($task_list->getParent() instanceof ProjectTask) {
  		$parent = $task_list->getParent();
  		$description = lang('subtask of', $parent->getViewUrl(), $parent->getTitle() != ''? clean($parent->getTitle()) : clean($parent->getText()));
	}
	
	$status = '<div class="taskStatus">';
	if(!$task_list->isCompleted()) {
		if ($task_list->canEdit(logged_user()))
			$status .= '<a class=\'internalLink og-ico ico-delete\' style="color:white;" href=\'' . $task_list->getCompleteUrl(rawurlencode(get_url('task','view_task',array('id'=>$task_list->getId())))) . '\' title=\'' 
			.lang('complete task') . '\'>' . lang('incomplete') . '</a>';
		else
			$status .= '<div style="display:inline;" class="og-ico ico-delete">' . lang('incomplete') . '</div>';
	}
	else {
		if ($task_list->canEdit(logged_user()))
			$status .= '<a class=\'internalLink og-ico ico-complete\' style="color:white;" href=\'' . $task_list->getOpenUrl(rawurlencode(get_url('task','view_task',array('id'=>$task_list->getId())))) . '\' title=\'' 
			. lang('open task') . '\'>' . lang('complete') . '</a>';
		else
			$status .= '<div style="display:inline;" class="og-ico ico-complete">' . lang('complete') . '</div>';
	}
	$status.= '</div>';
	
	if ($task_list->getAssignedTo()){
		$description .= '<span style="font-weight:bold">' . lang("assigned to") . ': </span><a class=\'internalLink\' style="color:white" href=\'' 
		. $task_list->getAssignedTo()->getCardUrl() . '\' title=\'' . lang('user card of', clean($task_list->getAssignedToName())). '\'>' 
		. clean($task_list->getAssignedToName()) . '</a>';
		if ($task_list->getAssignedBy() instanceof User) {
			$description .= ' <span style="font-weight:bold">' . lang("by") . ': </span> <a class=\'internalLink\' style="color:white" href=\''
			. $task_list->getAssignedBy()->getCardUrl() . '\' title=\'' . lang('user card of', clean($task_list->getAssignedBy()->getDisplayName())). '\'>'
			. clean($task_list->getAssignedBy()->getDisplayName()) . '</a>';
			if ($task_list->getAssignedOn() instanceof DateTimeValue) {
				$description .= ' <span style="font-weight:bold">' . lang("on") . ': </span>'
				. format_date($task_list->getAssignedOn());	
			}
		}
	}
	
	$milestone = '';
	if ($task_list->getMilestone() instanceof ProjectMilestone){
		$m = $task_list->getMilestone();
		$milestone .= '<div><div class="og-ico ico-milestone"><a class=\'internalLink\' style="color:white" href=\'' 
		. $m->getViewUrl() . '\' title=\'' . lang('view milestone') . '\'>' . clean($m->getName()) . '</a></div>';
	}
	
	$priority = '';
	if ($task_list->getPriority() >= ProjectTasks::PRIORITY_HIGH) {
		$priority = '<div class="og-task-priority-high"><span style="font-weight:bold">'.lang('task priority').": </span>".lang('high priority').'</div>';
	} else if ($task_list->getPriority() <= ProjectTasks::PRIORITY_LOW) {
		$priority = '<div class="og-task-priority-low"><span style="font-weight:bold">'.lang('task priority').": </span>".lang('low priority').'</div>';
	}
	
	$variables = array();
	//$variables['on_list_page'] = $on_list_page;
	
	tpl_assign("description", $status . $milestone . $priority . $description);
	tpl_assign("variables", $variables);
	tpl_assign("content_template", array('task_list', 'task'));
	tpl_assign('object', $task_list);
	tpl_assign('title', clean($title));
	tpl_assign('iconclass', 'ico-large-tasks');
	

	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>

<script type="text/javascript">
  App.modules.addTaskForm.hideAllAddTaskForms();
</script>