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

<?php 
  $genid = gen_id();
  set_page_title($milestone->isNew() ? lang('add milestone') : lang('edit milestone'));
  $project = active_or_personal_project();
  $projects =  active_projects();
?>

<?php if($milestone->isNew()) { ?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo get_url('milestone', 'add') ?>" method="post">
<?php } else { ?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $milestone->getEditUrl() ?>" method="post">
<?php } // if ?>

<div class="milestone">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php echo $milestone->isNew() ? lang('new milestone') : lang('edit milestone') ?>
	</td><td style="text-align:right"><?php echo submit_button($milestone->isNew() ? lang('add milestone') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
	<?php echo label_tag(lang('name'), $genid. 'milestoneFormName', true) ?>
	<?php echo text_field('milestone[name]', array_var($milestone_data, 'name'), 
		array('class' => 'title', 'id' => $genid .'milestoneFormName', 'tabindex' => '1')) ?>
	</div>
	
	<div style="padding-top:5px">
		<?php if (isset ($projects) && count($projects) > 0) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_select_workspace_div', this)"><?php echo lang('workspace') ?></a> - 
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_description_div', this)"><?php echo lang('description') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_options_div', this)"><?php echo lang('options') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_properties_div', this)"><?php echo lang('properties') ?></a>
		<?php if(!$milestone->isNew() && $project instanceof Project && $milestone->canLinkObject(logged_user(), $project)) { ?> - 
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_linked_objects_div', this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
	
	<?php if (isset ($projects) && count($projects) > 0) { ?>
	<div id="<?php echo $genid ?>add_milestone_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project('milestone[project_id]', $projects, ($project instanceof Project)? $project->getId():0) ?>
	</fieldset>
	</div>
	<?php } ?>

	<div id="<?php echo $genid ?>add_milestone_tags_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('tags') ?></legend>
		<?php echo autocomplete_textfield("milestone[tags]", array_var($milestone_data, 'tags'), 'allTags', array('class' => 'long')); ?>
	</fieldset>
	</div>
	
	<div id="<?php echo $genid ?>add_milestone_description_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('description') ?></legend>
		<?php echo textarea_field('milestone[description]', array_var($milestone_data, 'description'), array('class' => 'short', 'id' => $genid . 'milestoneFormDesc')) ?>
	</fieldset>
	</div>
  
	<div id="<?php echo $genid ?>add_milestone_options_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('options') ?></legend>
	<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
		<div class="objectOptions">
		<div class="optionLabel"><label><?php echo lang('private milestone') ?>: <span class="desc">(<?php echo lang('private milestone desc') ?>)</span></label></div>
		<div class="optionControl"><?php echo yes_no_widget('milestone[is_private]', $genid . 'milestoneFormIsPrivate', array_var($milestone_data, 'is_private'), lang('yes'), lang('no')) ?></div>
		</div>
	<?php } // if ?>
		<div class="objectOption">
		<div class="optionLabel"><?php echo label_tag(lang('assign to'), $genid . 'milestoneFormAssignedTo') ?></div>
		<div class="optionControl"><?php echo assign_to_select_box('milestone[assigned_to]', active_or_personal_project(), array_var($milestone_data, 'assigned_to'), array('id' => $genid . 'milestoneFormAssignedTo')) ?></div>
		<div class="optionControl"><?php echo checkbox_field('milestone[send_notification]', array_var($milestone_data, 'send_notification', true), array('id' => $genid . 'milestoneFormSendNotification')) ?> 
		<label for="<?php echo $genid ?>milestoneFormSendNotification" class="checkbox"><?php echo lang('send milestone assigned to notification') ?></label></div>
		</div>
	</fieldset>
	</div>
	
	<div id='<?php echo $genid ?>add_milestone_properties_div' style="display:none">
	<fieldset>
	<legend><?php echo lang('properties') ?></legend>
		<? echo render_object_properties('milestone', $milestone); ?>
	</fieldset>
	</div>
	
	<?php if ($project instanceof Project && $milestone->canLinkObject(logged_user(), $project)) { ?>
	<div style="display:none" id="<?php echo $genid ?>add_milestone_linked_objects_div">
	<fieldset>
	<legend><?php echo lang('linked objects') ?></legend>
		<?php echo render_object_links($milestone, $milestone->canEdit(logged_user())) ?>
	</fieldset>	
	</div>
	<?php } // if ?>
	
	<div>
	<?php echo label_tag(lang('due date'), null, true) ?>
	<?php echo pick_date_widget('milestone_due_date', array_var($milestone_data, 'due_date')) ?>
	</div>

	<?php echo submit_button($milestone->isNew() ? lang('add milestone') : lang('save changes'), 's', array('tabindex' => '10')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>milestoneFormName').focus();
</script>