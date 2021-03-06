<div style="padding:20px">
<?php 
  set_page_title($milestone->isNew() ? lang('add milestone') : lang('edit milestone'));
  project_tabbed_navigation(PROJECT_TAB_MILESTONES);
  project_crumbs(lang('add milestone'));
  $project = active_or_personal_project();
?>
<?php if($milestone->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('milestone', 'add') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $milestone->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

	<div>
	<?php echo label_tag(lang('name'), 'milestoneFormName', true) ?>
	<?php echo text_field('milestone[name]', array_var($milestone_data, 'name'), array('class' => 'long', 'id' => 'milestoneFormName')) ?>
	</div>

	<div>
	<?php echo label_tag(lang('due date'), null, true) ?>
	<?php echo pick_date_widget('milestone_due_date', array_var($milestone_data, 'due_date')) ?>
	</div>
	
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_milestone_description_div',this)"><?php echo lang('description') ?></legend>
	<div id="add_milestone_description_div" style="display:none">
	<?php echo textarea_field('milestone[description]', array_var($milestone_data, 'description'), array('class' => 'short', 'id' => 'milestoneFormDesc')) ?>
	</div>
	</fieldset>
	
	<?php $projects =  active_projects();
	if (isset ($projects) && count($projects) > 0) { ?>
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_milestone_project_div',this)"><?php echo lang('workspace') ?></legend>
	<?php echo select_project('milestone[project_id]', $projects, ($project instanceof Project)? $project->getId():0, array('id'=>'add_milestone_project_div', 'style' => 'display:none')) ?>
	</fieldset>
	<?php } ?>
  
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_milestone_options_div',this)"><?php echo lang('options') ?></legend>
	<div id="add_milestone_options_div" style="display:none">
	<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
		<div class="objectOptions">
		<div class="optionLabel"><label><?php echo lang('private milestone') ?>: <span class="desc">(<?php echo lang('private milestone desc') ?>)</span></label></div>
		<div class="optionControl"><?php echo yes_no_widget('milestone[is_private]', 'milestoneFormIsPrivate', array_var($milestone_data, 'is_private'), lang('yes'), lang('no')) ?></div>
		</div>
	<?php } // if ?>
		<div class="objectOption">
		<div class="optionLabel"><?php echo label_tag(lang('assign to'), 'milestoneFormAssignedTo') ?></div>
		<div class="optionControl"><?php echo assign_to_select_box('milestone[assigned_to]', active_or_personal_project(), array_var($milestone_data, 'assigned_to'), array('id' => 'milestoneFormAssignedTo')) ?></div>
		<div class="optionControl"><?php echo checkbox_field('milestone[send_notification]', array_var($milestone_data, 'send_notification', true), array('id' => 'milestoneFormSendNotification')) ?> <label for="milestoneFormSendNotification" class="checkbox"><?php echo lang('send milestone assigned to notification') ?></label></div>
		</div>
	</div>
	</fieldset>

	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_milestone_tags_div',this)"><?php echo lang('tags') ?></legend>
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
	<?php echo autocomplete_textfield("milestone[tags]", array_var($milestone_data, 'tags'), 'allTags', array('id'=>'add_milestone_tags_div', 'style'=>'display:none', 'class' => 'long')); ?>
	</fieldset>
	
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_milestone_properties_div',this)"><?php echo lang('properties') ?></legend>
	<div id='add_milestone_properties_div' style="display:none">
	<? echo render_object_properties('milestone', $milestone); ?>
	</div>
	</fieldset>
	
	<?php if ($project instanceof Project && $milestone->canLinkObject(logged_user(), $project)) { ?>
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_milestone_linked_objects_div',this)"><?php echo lang('linked objects') ?></legend>
	<div style="display:none" id="add_milestone_linked_objects_div">
	<?php echo render_object_links($milestone, $milestone->canEdit(logged_user())) ?>
	</div>
	</fieldset>	
	<?php } // if ?>

	<?php echo submit_button($milestone->isNew() ? lang('add milestone') : lang('edit milestone')) ?>
</form>
</div>