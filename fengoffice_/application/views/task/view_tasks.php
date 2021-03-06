<?php
$container_id = gen_id();
?>
<div id="<?php echo $container_id ?>"></div>
<script>
var tasks = [
<?php $first = true;
foreach ($tasks as $task) {
if ($task->getMilestoneId() != 0) {
	// don't show in tasks tasks that will also be listed under milestones.
	// if this is removed, tasks will appear twice. something needs to be done
	// so that updates on one of them reflects on the other.
	continue;
}
if ($first) {
	$first = false;
} else {
	echo ",";
}
?>
{
	id: <?php echo $task->getId() ?>,
	title: '<?php echo str_replace("\n"," ",str_replace("'", "\\'", $task->getTitle())) ?>',
	parent: <?php echo $task->getParentId() ?>,
	milestone: <?php echo $task->getMilestoneId() ?>,
	subtasks: [],
	assignedTo: '<?php echo str_replace("'", "\\'", $task->getAssignedTo() == null ? '' : $task->getAssignedToName()) ?>',
	workspaces: '<?php echo str_replace("'", "\\'", (active_project() instanceof Project && $task->getProject()->getId() == active_project()->getId()) ? '' : $task->getProject()->getName()) ?>',
	workspaceids: '<?php echo str_replace("'", "\\'", (active_project() instanceof Project && $task->getProject()->getId() == active_project()->getId()) ? '' : $task->getProject()->getId()) ?>',
	workspacecolors: '<?php echo str_replace("'", "\\'", (active_project() instanceof Project && $task->getProject()->getId() == active_project()->getId()) ? '' : $task->getWorkspaceColorsCSV()) ?>',
	expanded: false,
	completed: <?php echo $task->isCompleted()?"true":"false" ?>,
	completedBy: '<?php echo str_replace("'", "\\'", $task->getCompletedByName()) ?>',
	isLate: <?php echo $task->isLate()?"true":"false" ?>,
	daysLate: <?php echo $task->getLateInDays() ?>,
	priority: <?php echo $task->getPriority() ?>,
	duedate: <?php echo ($task->getDueDate() ? $task->getDueDate()->getTimestamp() : '0') ?>,
	order: <?php echo $task->getOrder() ?>
	
}
<?php } // foreach ?>
];

var pepe = new og.TaskItem({
	id: 0,
	title: 'pepito',
	expanded: true,
	subtasks: tasks,
	container: document.getElementById('<?php echo $container_id ?>'),
	showOnlySubtasks: true
});
</script>

