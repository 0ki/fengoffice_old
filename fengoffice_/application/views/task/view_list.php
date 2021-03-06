<?php

  set_page_title($task_list->getName());
  project_tabbed_navigation(PROJECT_TAB_TASKS);
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName())
  ));
  if(ProjectTaskList::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add task list'), get_url('task', 'add_list'));
  } // if
//add_javascript_to_page('modules/addTaskForm.js');  

?>

<?php $this->assign('on_list_page', true); ?>
<?php $this->includeTemplate(get_template_path('task/task_list')); ?>
<script type="text/javascript">
  App.modules.addTaskForm.hideAllAddTaskForms();
</script>