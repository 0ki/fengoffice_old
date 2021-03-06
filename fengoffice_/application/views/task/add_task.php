<?php

set_page_title($task->isNew() ? lang('add task') : lang('edit task'));
project_tabbed_navigation(PROJECT_TAB_TASKS);
project_crumbs(array(
array(lang('tasks'), get_url('task')),
array($task_list->getTitle(), $task_list->getViewUrl()),
array($task->isNew() ? lang('add task') : lang('edit task'))
));
add_page_action(lang('add task list'), get_url('task', 'add_list'));

?>
<?php if($task->isNew()) { ?>
<form class="internalForm"
	action="<?php echo $task_list->getAddTaskUrl($back_to_list) ?>"
	method="post"><?php } else { ?>
<form class="internalForm" action="<?php echo $task->getEditUrl() ?>"
	method="post"><?php } // if ?> <?php tpl_display(get_template_path('form_errors')) ?>

<?php if(!$task->isNew()) { ?>
	<div><?php echo label_tag(lang('task list'), 'addTaskTaskList', true) ?>
<?php echo select_task_list('task[task_list_id]', active_project(), array_var($task_data, 'task_list_id'), false, array('id' => 'addTaskTaskList')) ?>
	</div>
<?php } // if ?>

	<div><?php echo label_tag(lang('text'), 'addTaskText', true) ?> <?php echo textarea_field("task[text]", array_var($task_data, 'text'), array('id' => 'addTaskText', 'class' => 'short')) ?>
	</div>
	<div><label><?php echo lang('assign to') ?>:</label> <?php echo assign_to_select_box("task[assigned_to]", active_project(), array_var($task_data, 'assigned_to')) ?>
	</div>
	<fieldset>
		<legend class="toggle_collapsed"
			onclick="og.toggle('add_task_tags_div',this)"><?php echo lang('tags') ?></legend>
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
	    </script> <?php echo autocomplete_textfield("task[tags]", array_var($task_data, 'tags'), 'allTags', array('id'=>'add_task_tags_div', 'style'=>'display:none', 'class' => 'long')); ?>
	</fieldset>
	<fieldset>
		<legend class="toggle_collapsed"
			onclick="og.toggle('add_task_properties_div',this)"><?php echo lang('properties') ?></legend>
		<div id='add_task_properties_div' style="display: none"><? echo render_object_properties('task',$task); ?>
		</div>
	</fieldset>
    	<?php if($task->canLinkObject(logged_user(), active_project())) { ?>
	<fieldset>
		<legend class="toggle_collapsed"
			onclick="og.toggle('add_task_linked_objects_div',this)"><?php echo lang('linked objects') ?></legend>
		<div style="display: none" id="add_task_linked_objects_div"><?php echo render_object_links($task, $task->canEdit(logged_user())) ?>
		</div>
	</fieldset>
    	<?php } // if ?>
    <?php //echo render_object_comments($task) ?>
    <?php echo submit_button($task->isNew() ? lang('add task') : lang('edit task')) ?>
</form>
