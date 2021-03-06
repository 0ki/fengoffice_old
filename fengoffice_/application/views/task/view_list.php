<?php

  set_page_title($task_list->getTitle());
  project_tabbed_navigation(PROJECT_TAB_TASKS);
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getTitle())
  ));
  if(!$task_list->isCompleted() && $task_list->canEdit(logged_user())) {
    add_page_action(lang('complete task'), $task_list->getCompleteUrl(), 'ico-complete');
  } // if
  
  if(active_project() && ProjectTask::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task list'), get_url('task', 'add_list'), 'ico-task');
  } // if
//add_javascript_to_page('modules/addTaskForm.js');  
  if($task_list->canEdit(logged_user())) {
    add_page_action(lang('edit'), $task_list->getEditListUrl(), 'ico-edit');
  } // if
  if($task_list->canDelete(logged_user())) {
    add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete task list'))) og.openLink('" . $task_list->getDeleteListUrl() ."');", 'ico-delete');
  } // if
  
  //TODO Fix reorder subtasks
  /*if($task_list->canReorderTasks(logged_user()) && is_array($task_list->getOpenSubTasks())) {
    add_page_action(lang('reorder sub tasks'), $task_list->getReorderTasksUrl($on_list_page), 'ico-properties');
  } // if*/
?>

<?php $this->assign('on_list_page', true); ?>




<div style="padding:7px">
<div class="tasks">
<?php
	$title = $task_list->getTitle() != '' ? $task_list->getTitle() : $task_list->getText();
	
	if ($task_list->getParent() instanceof ProjectTask) {
  		$parent = $task_list->getParent();
  		$description = lang('subtask of', $parent->getViewUrl(), $parent->getTitle() != ''? $parent->getTitle() : $parent->getText());
  		tpl_assign('description', $description);
	}
	
	$variables = array();
	//$variables['on_list_page'] = $on_list_page;
	
	tpl_assign("variables", $variables);
	tpl_assign("content_template", array('task_list', 'task'));
	tpl_assign('object', $task_list);
	tpl_assign('title', $title);
	tpl_assign('iconclass', 'ico-large-tasks');

	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>

<script type="text/javascript">
  App.modules.addTaskForm.hideAllAddTaskForms();
</script>