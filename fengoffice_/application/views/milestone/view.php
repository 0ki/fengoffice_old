<?php
  
  if(!$milestone->isCompleted() && $milestone->canEdit(logged_user())) {
    add_page_action(lang('complete milestone'), $milestone->getCompleteUrl(rawurlencode(get_url('milestone','view',array('id'=>$milestone->getId())))) , 'ico-complete');
  } // if
  if($milestone->isCompleted() && $milestone->canEdit(logged_user())) {
    add_page_action(lang('open milestone'), $milestone->getOpenUrl(rawurlencode(get_url('milestone','view',array('id'=>$milestone->getId())))) , 'ico-reopen');
  }
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
	add_page_action(lang('copy milestone'), get_url("milestone", "copy_milestone", array("id" => $milestone->getId())), 'ico-copy');
	
	add_page_action(lang('save as template'), get_url("milestone", "new_template", array("id" => $milestone->getId())), 'ico-template-milestone');

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
	if ($milestone->getDescription()){
		$content .= '<div class="description">' . nl2br(clean($milestone->getDescription())) . '</div>';
	}
	$openSubtasks = $milestone->getOpenSubTasks();
	if (is_array($openSubtasks)) { 
//		$content .= '<p>' . lang('task lists') . ':</p><ul>';
		
		
		
//show open sub task list
		$content .= '<br/><table style="border:1px solid #717FA1;width:100%; padding-left:10px;"><tr><th style="padding-left:10px;padding-top:4px;padding-bottom:4px;background-color:#E8EDF7;font-size:120%;font-weight:bolder;color:#717FA1;width:100%;">' . lang("view open tasks") . '</th></tr><tr><td style="padding-left:10px;">
			  <div class="openTasks">
			  <table class="blank">';
 		foreach($openSubtasks as $task) { 
      		$content .= '<tr>';
      
			// Checkboxes
			if($task->canChangeStatus(logged_user())) { 
			    $content .= '<td class="taskCheckbox">' . checkbox_link($task->getCompleteUrl(rawurlencode(get_url('milestone', 'view', array('id' => $milestone->getId())))), false, lang('mark task as completed')) . '</td>';
			} else { 
				$content .= '<td class="taskCheckbox"><img src="' . icon_url('not-checked.jpg') . '" alt="' . lang('open task') . '" /></td>';
			} // if
			
			// Task text and options -->
			$content .= '<td class="taskText">';
			if($task->getAssignedTo()) { 
				$content .= '  <span class="assignedTo">'. clean($task->getAssignedTo()->getObjectName()) .':</span> ';
			} // if 
			
			$content .= ' <a class="internalLink" href="' . $task->getObjectUrl() . '">' ;
			$content .=  ($task->getTitle() && $task->getTitle()!='' )?clean($task->getTitle()):clean($task->getText()) ;
			$content .='</a> ';
			
				 if($task->canEdit(logged_user())) { 
			 	$content .= '<a class="internalLink blank" href="'. $task->getEditListUrl() .'" title="' . lang('edit task') . '"><img src="' .
			 	icon_url('edit.gif') .'" alt="" /></a>';
			} // if 
			if($task->canDelete(logged_user())) { 
				$content .= '<a class="internalLink blank" href="' . $task->getDeleteUrl() .'" onclick="return confirm(\'' . 
			  		lang('confirm delete task') . '\')" title="' . lang('delete task') . '">
			  		<img src="' . icon_url('cancel_gray.gif') .'" alt="" /></a>';
			} // if 
		    $content .= ' </td>     </tr>';
		} // foreach 
	   $content .= '</table>';
		
	$content .= '</div></td></tr></table><br/>';
	}	
	else { 
		$content .=  '<br/>' . lang('no open task in milestone')  .'<br/><br/>';
	} // if 
	
	
$on_list_page = false;
//show completed tasks for the milestone
	$completed_subtasks	= $milestone->getCompletedSubTasks();
	if(is_array($milestone->getCompletedSubTasks($completed_subtasks))) { 
		$content .= '  <table style="border:1px solid #717FA1;width:100%; padding-left:10px;"><tr><th style="padding-left:10px;padding-top:4px;padding-bottom:4px;background-color:#E8EDF7;font-size:120%;font-weight:bolder;color:#717FA1;width:100%;">' . lang("completed tasks") . '</th></tr><tr><td style="padding-left:10px;">
			  <div class="completedTasks">
			  <table class="blank">';
 		$counter = 0; 
 		foreach($completed_subtasks as $task) { 
			 $counter++; 
			 if($on_list_page || ($counter <= 5)) {
			    $content .= '<tr>';
			 	if($task->canChangeStatus(logged_user())) { 
					$content .= '<td class="taskCheckbox">' . checkbox_link($task->getOpenUrl(rawurlencode(get_url('milestone', 'view', array('id' => $milestone->getId())))), true, lang('mark task as open')) . '</td>';
				} else { 
				    $content .= '<td class="taskCheckbox"><img src="' .  icon_url('checked.jpg') .'" alt="' . lang('completed task') .'" /></td>';
				} // if 
			    $content .= '    <td class="taskText">
			        	<a class="internalLink" href="' . $task->getObjectUrl() .'">'.clean($task->getTitle()) .'</a> ';
	           if($task->canEdit(logged_user())) { 
	           	$content .= '<a class="internalLink" href="' . $task->getEditListUrl() .'" class="blank" title="'. lang('edit task') .
	           		'"><img src="'. icon_url('edit.gif') .'" alt="" /></a> ';
				} // if 
				if($task->canDelete(logged_user())) { 
					$content .= '<a href="'. $task->getDeleteUrl() .'" class="blank internalLink" onclick="return confirm(\'' . 
						lang('confirm delete task') . '\')" title="' . lang('delete task') . '"><img src="' . icon_url('cancel_gray.gif') .
						'" alt="" /></a> ';
				} // if <br />
	          $content .= '<span class="taskCompletedOnBy">(' .lang('completed on by', format_date($task->getCompletedOn()), $task->getCompletedBy()->getCardUrl(), clean($task->getCompletedBy()->getDisplayName())) . ')</span>
				        </td> <td></td>  </tr>';
			 } // if 
		 } // foreach 
		 if(!$on_list_page && $counter > 5) { 
		      $content .= '<tr>
		        <td colspan="2"><a class="internalLink" href="'. $milestone->getViewUrl() .'"> ' . lang('view all completed tasks', $counter) .'</a></td>
		      </tr>';
		 } // if 	   
		$content .= ' </table> </div> </td></tr></table>';
	} // if 	   
	else { 
		$content .=   lang('no closed task in milestone')  .'<br/>';
	} // if 
	   
	tpl_assign("content", $content);
	tpl_assign("object", $milestone);
	
	$this->includeTemplate(get_template_path('view', 'co'));
	?>
</div>
</div>