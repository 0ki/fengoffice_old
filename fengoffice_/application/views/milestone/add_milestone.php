<?php 
  $genid = gen_id();
  if (isset($base_milestone) && $base_milestone instanceof ProjectMilestone && $base_milestone->getIsTemplate()) {
  	add_page_action(lang("delete template"), "javascript:if(confirm('".lang('confirm delete template')."')) og.openLink('" . get_url("milestone", "delete", array("id" => $base_milestone->getId())) ."');", "ico-delete");
  }
  $project = $milestone->getProject();
?>
<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $milestone->isNew() ? get_url('milestone', 'add', array("copyId" => array_var($milestone_data, 'copyId'))) : $milestone->getEditUrl() ?>" method="post">

<div class="milestone">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php
		if ($milestone->isNew()) {
			if (array_var($milestone_data, 'is_template', false)) {
				echo lang('new milestone template');
			} else if (isset($milestone_task ) && $milestone_task instanceof ProjectTask) {
				echo lang('new milestone from template');
			} else {
				echo lang('new milestone');
			}
		} else {
			echo lang('edit milestone');
		}
	?>
	</td><td style="text-align:right"><?php echo submit_button($milestone->isNew() ? (array_var($milestone_data, 'is_template', false) ? lang('save template') : lang('add milestone')) : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
	<?php echo label_tag(lang('name'), $genid. 'milestoneFormName', true) ?>
	<?php echo text_field('milestone[name]', array_var($milestone_data, 'name'), 
		array('class' => 'title', 'id' => $genid .'milestoneFormName', 'tabindex' => '1')) ?>
	</div>
	
	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_select_workspace_div', this)"><?php echo lang('workspace') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_description_div', this)"><?php echo lang('description') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_options_div', this)"><?php echo lang('options') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_properties_div', this)"><?php echo lang('properties') ?></a>
		<?php if($milestone->isNew() || $milestone->canLinkObject(logged_user())) { ?> - 
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_milestone_linked_objects_div', this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">
	
	<?php if ($milestone->isNew() && isset($base_milestone) && $base_milestone instanceof ProjectMilestone && $base_milestone->getIsTemplate()) { ?>
		<input type="hidden" name="milestone[from_template_id]" value="<?php echo $base_milestone->getId() ?>" />
	<?php } ?>
	
	<div id="<?php echo $genid ?>add_milestone_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project2('milestone[project_id]', ($project instanceof Project)? $project->getId():active_or_personal_project()->getId(), $genid) ?>
	</fieldset>
	</div>

	<div id="<?php echo $genid ?>add_milestone_tags_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('tags') ?></legend>
		<?php echo autocomplete_textfield("milestone[tags]", array_var($milestone_data, 'tags'), Tags::getTagNames(), lang("enter tags desc"), array("class" => "long")); ?>
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
		<?php echo render_object_properties('milestone', $milestone); ?>
	</fieldset>
	</div>
	
	<?php if ($milestone->isNew() || $milestone->canLinkObject(logged_user())) { ?>
	<div style="display:none" id="<?php echo $genid ?>add_milestone_linked_objects_div">
	<fieldset>
	<legend><?php echo lang('linked objects') ?></legend>
	  	  <table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
	   	<tbody></tbody>
		</table>
		<?php echo render_object_links($milestone, $milestone->canEdit(logged_user())) ?>
	</fieldset>	
	</div>
	<?php } // if ?>
	
	<div>
	<?php echo label_tag(lang('due date'), null, true) ?>
	<?php echo pick_date_widget2('milestone[due_date_value]', array_var($milestone_data, 'due_date'),$genid) ?>
	</div>

	<?php echo input_field("milestone[is_template]", array_var($milestone_data, 'is_template', false), array("type" => "hidden")); ?>

	<?php echo submit_button($milestone->isNew() ? (array_var($milestone_data, 'is_template', false) ? lang('save template') : lang('add milestone')) : lang('save changes'), 's', array('tabindex' => '10')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('<?php echo $genid ?>milestoneFormName').focus();
</script>