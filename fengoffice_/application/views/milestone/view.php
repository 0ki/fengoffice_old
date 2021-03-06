<?php

  if(!$milestone->isCompleted()) {    
    if(ProjectTask::canAdd(logged_user(), $milestone->getProject())) 
    	add_page_action(lang('add task list'), $milestone->getAddTaskUrl(), 'ico-task');
  } // if
  
  if($milestone->canEdit(logged_user())) {
		add_page_action(lang('edit'), $milestone->getEditUrl(), 'ico-edit');
	} // if
	if($milestone->canDelete(logged_user())) {
		add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete milestone'))) og.openLink('" . $milestone->getDeleteUrl() ."');", 'ico-delete');
	} // if

?>

<div style="padding:7px">
<div class="milestone">
<?php 
	$content = '';
	if ($milestone->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { 
		$content = '<div class="dueDate"><span>'.lang('due date').':</span> ' . format_date($milestone->getDueDate(), null, 0) . '</div>';
	} else { 
		$content = '<div class="dueDate"><span>' . lang('due date') . ':</span> ' . format_descriptive_date($milestone->getDueDate(), 0) . '</div>';
	} // if 
	if ($milestone->getDescription())
		$content .= '<pre class="description">' . $milestone->getDescription() . '</pre>';

	if ($milestone->hasTasks()) { 
		$content .= '<p>' . lang('task lists') . ':</p><ul>';
		foreach ($milestone->getTasks() as $task_list) { 
			if ($task_list->isCompleted()) {
				$content .= '<li><del datetime="' . $task_list->getCompletedOn()->toISO8601() . 
					'"><a class="internalLink" href="' . $task_list->getViewUrl() . '" title="' .
					lang('completed task list') . '">' . clean($task_list->getTitle()) . '</a></del></li>';
			} else {
				$content .= '<li><a class="internalLink" href="' . $task_list->getViewUrl() . '">' .
				clean($task_list->getTitle()) . '</a></li>';
			}
		}
		$content .= '</ul>';
	}
	
	tpl_assign("content", $content);
	tpl_assign("object", $milestone);
	
	$this->includeTemplate(get_template_path('view', 'co'));
	?>
</div>
</div>