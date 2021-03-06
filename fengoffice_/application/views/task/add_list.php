<?php

  set_page_title($task_list->isNew() ? lang('add task list') : lang('edit task list'));
  project_tabbed_navigation(PROJECT_TAB_TASKS);
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->isNew() ? lang('add task list') : lang('edit task list'))
  ));
  add_page_action(lang('add task list'), get_url('task', 'add_list'));

?>
<?php if($task_list->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('task', 'add_list') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $task_list->getEditListUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>
  <fieldset>
  <div>
    <?php echo label_tag(lang('name'), 'taskListFormName', true) ?>
    <?php echo text_field('task_list[title]', array_var($task_list_data, 'title'), array('class' => 'long', 'id' => 'taskListFormName')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('description'), 'taskListFormDescription',true) ?>
    <?php echo textarea_field('task_list[text]', array_var($task_list_data, 'text'), array('class' => 'short', 'id' => 'taskListFormDescription')) ?>
  </div>
  </fieldset>
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_list_project_div',this)"><?php echo lang('workspace') ?></legend>
	<?php echo select_project('task_list[project_id]', active_projects(), active_or_personal_project()->getId(), array('id'=>'add_list_project_div', 'style' => 'display:none')) ?>
	</fieldset>
  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_list_milestone_div',this)"><?php echo lang('milestone') ?></legend>
	<div style="display:none" id="add_list_milestone_div">
    <?php //echo label_tag(lang('milestone'), 'taskListFormMilestone') ?>
    <?php echo select_milestone('task_list[milestone_id]', active_or_personal_project(), array_var($task_list_data, 'milestone_id'), array('id' => 'taskListFormMilestone')) ?>
  	</div>
  </fieldset>
  
<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_list_options_div',this)"><?php echo lang('options') ?></legend>
	  <div style="display:none" id="add_list_options_div">
	    <label><?php echo lang('private task list') ?>: <span class="desc">(<?php echo lang('private task list desc') ?>)</span></label>
	    <?php echo yes_no_widget('task_list[is_private]', 'taskListFormIsPrivate', array_var($task_list_data, 'is_private'), lang('yes'), lang('no')) ?>
	  </div>
   </fieldset>
<?php } // if ?>
  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_tasklist_tags_div',this)"><?php echo lang('tags') ?></legend>
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
    </script>
	<?php echo autocomplete_textfield("task_list[tags]", array_var($task_list_data, 'tags'), 'allTags', array('id'=>'add_tasklist_tags_div', 'style'=>'display:none', 'class' => 'long')); ?>
  </fieldset> 
  <!--div class="formBlock">
    <?php /* echo label_tag(lang('tags'), 'taskListFormTags') ;
    	echo show_project_tags_option(active_project(), 'allTagsCombo', array('id' => 'allTagsCombo','style'=> 'width:100px'));
    	 echo show_addtag_button('allTagsCombo','taskListFormTags',array('style'=> 'width:20px')); 
    	 echo project_object_tags_widget('task_list[tags]', active_project(), array_var($task_list_data, 'tags'), array('id' => 'taskListFormTags'))//, 'class' => 'long')) 
    	 */ ?>
  </div-->
  
  
  
<?php if($task_list->isNew()) { ?>
 <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_list_tasks_div',this)"><?php echo lang('tasks') ?></legend>
	  <div style="display:none" id="add_list_tasks_div">
  
	  <table class="blank">
	    <tr>
	      <th><?php echo lang('task') ?>:</th>
	      <th><?php echo lang('assign to') ?>:</th>
	    </tr>
	<?php for($i = 0; $i < 6; $i++) { ?>
	    <tr style="background: <?php echo $i % 2 ? '#fff' : '#e8e8e8' ?>">
	      <td>
	        <?php echo textarea_field("task_list[task$i][text]", array_var($task_list_data["task$i"], 'text'), array('class' => 'short')) ?>
	      </td>
	      <td>
	        <?php echo assign_to_select_box("task_list[task$i][assigned_to]", active_or_personal_project(), array_var($task_list_data["task$i"], 'assigned_to')) ?>
	      </td>
	    </tr>
	<?php } // for ?>
	  </table>
	  </div>
  </fieldset>
<?php } // if ?>
  
	<fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_list_handins_div',this)"><?php echo lang('handins') ?></legend>
	  <div style="display:none" id="add_list_handins_div">
  
    <?php //echo label_tag(lang('handins'), 'taskListFormHandins') ?>
    
	  <table class="blank">
	    <tr>
	      <th><?php echo lang('handin') ?>:</th>
	      <th><?php echo lang('assign to') ?>:</th>
	    </tr>
		<?php for($i = 0; $i < 4; $i++) { ?>
	    <tr style="background: <?php echo $i % 2 ? '#fff' : '#e8e8e8' ?>">
	      <td>      
	        <?php 
	        if($task_list->isNew())
	        	$attr =  array('class' => 'long');
	        else 
	        	 $attr = array('class' => 'long', 'disabled' => 'true');
	        echo text_field("task_list[handin$i][title]", array_var($task_list_data["handin$i"], 'title'), $attr) ?>
	      </td>
	      <td>
	        <?php echo assign_to_select_box("task_list[handin$i][assigned_to]", active_or_personal_project(), array_var($task_list_data["handin$i"], 'assigned_to'), $task_list->isNew()?null:array( 'disabled' => 'true')) ?>
	      </td>
	    </tr>
		<?php } // for ?>
	  </table>
  	  </div>
	</fieldset>
	  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_list_properties_div',this)"><?php echo lang('properties') ?></legend>
      <div id='add_list_properties_div' style="display:none">
	  <? echo render_object_properties('task_list',$task_list); ?>
  </div>
  </fieldset>
 <?php if(!$task_list->isNew() && $task_list->canLinkObject(logged_user(), active_or_personal_project())) { ?>
<fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_task_list_linked_objects_div',this)"><?php echo lang('linked objects') ?></legend>
    <div style="display:none" id="add_task_list_linked_objects_div">
    <?php echo render_object_links($task_list) ?>
</div>
</fieldset>
<?php } // if ?>
 

  <?php echo submit_button($task_list->isNew() ? lang('add task list') : lang('edit task list')) ?>

</form>