<?php
	//add_stylesheet_to_page('project/milestones.css');
	if($milestone->canEdit(logged_user())) {
		add_page_action(lang('edit'), $milestone->getEditUrl(), 'ico-edit');
	} // if
	if($milestone->canDelete(logged_user())) {
		add_page_action(lang('delete'), $milestone->getDeleteUrl(), 'ico-delete');
	} // if
?>

<div style="padding:7px">
<?php if($milestone->isCompleted()) { ?>
	<div class="milestone milestone-completed">
<?php } elseif($milestone->isToday()) { ?>
	<div class="milestone milestone-late">
<?php } elseif($milestone->isLate()) { ?>
	<div class="milestone milestone-late">
<?php } else { ?>
	<div class="milestone">
<?php } // if?>

<div class="coContainer">
<div class="coHeader">
	<div class="coHeaderUpperRow">
		<?php if ($milestone->isPrivate()) { ?>
    		<div class="private" title="<?php echo lang('private milestone') ?>"><span><?php echo lang('private milestone') ?></span></div>
		<?php } // if ?>
		<div class="coTitle">
		<?php if ($milestone->canChangeStatus(logged_user())) { ?>
			<?php if ($milestone->isCompleted()) { ?>
				<?php echo checkbox_link($milestone->getOpenUrl(), true) ?>
			<?php } else { ?>
				<?php echo checkbox_link($milestone->getCompleteUrl(), false) ?>
			<?php } // if ?>
		<?php } // if?>
		<?php echo clean($milestone->getName()) ?>
		</div>
		<div class="coTags"><p><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($milestone) ?></p></div>
	</div>
	<div class="coInfo">
		<?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
			<span class="assignedTo"><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>:</span>
		<?php } // if ?>
		<?php if ($milestone->isUpcoming()) { ?>
 			(<?php echo lang('days left', $milestone->getLeftInDays()) ?>)
		<?php } else if ($milestone->isLate()) { ?>
			(<?php echo lang('days late', $milestone->getLateInDays()) ?>)
		<?php } elseif ($milestone->isToday()) { ?>
			(<?php echo lang('today') ?>)
		<?php } // if ?>
	</div>
</div>
<div class="coMainBlock">
	<div class="coLinkedObjects">
		<?php echo render_object_links($milestone, $milestone->canEdit(logged_user())) ?>
	</div>
<div class="coContent">
	<?php if ($milestone->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
	<div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_date($milestone->getDueDate(), null, 0) ?></div>
	<?php } else { ?>
	<div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_descriptive_date($milestone->getDueDate(), 0) ?></div>
	<?php } // if ?>
	<?php if ($milestone->getDescription()) { ?>
	<div class="description"><?php echo do_textile($milestone->getDescription()) ?></div>
	<?php } // if ?>

	<!-- Task lists -->
	<?php if ($milestone->hasTasks()) { ?>
		<p><?php echo lang('task lists') ?>:</p>
		<ul>
		<?php foreach ($milestone->getTasks() as $task_list) { ?>
			<?php if ($task_list->isCompleted()) { ?>
			<li><del datetime="<?php echo $task_list->getCompletedOn()->toISO8601() ?>"><a class="internalLink" href="<?php echo $task_list->getViewUrl() ?>" title="<?php echo lang('completed task list') ?>"><?php echo clean($task_list->getTitle()) ?></a></del></li>
			<?php } else { ?>
			<li><a class="internalLink" href="<?php echo $task_list->getViewUrl() ?>"><?php echo clean($task_list->getTitle()) ?></a></li>
			<?php } // if ?>
		<?php } // foreach ?>
		</ul>
	<?php } // if ?>

</div>    
</div>
</div>
</div>