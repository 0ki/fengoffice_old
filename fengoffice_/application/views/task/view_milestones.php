<?php
$container_id = gen_id();
?>
<div id="<?php echo $container_id ?>"></div>
<script>
var milestones = [
<?php $first = true;
foreach ($milestones as $milestone) {
if ($first) {
	$first = false;
} else {
	echo ",";
}
?>
{
	id: <?php echo $milestone->getId() ?>,
	title: '<?php echo str_replace("'", "\\'", $milestone->getName()) ?>',
	subtasks: [],
	assignedTo: '<?php echo str_replace("'", "\\'", $milestone->getAssignedTo() == null ? '' : $milestone->getAssignedToName()) ?>',
	workspaces: '<?php echo str_replace("'", "\\'", (active_project() instanceof Project && $milestone->getProject()->getId() == active_project()->getId()) ? '' : $milestone->getProject()->getName()) ?>',
	workspaceids: '<?php echo str_replace("'", "\\'", (active_project() instanceof Project && $milestone->getProject()->getId() == active_project()->getId()) ? '' : $milestone->getProject()->getId()) ?>',
	expanded: false,
	completed: <?php echo $milestone->isCompleted()?"true":"false" ?>,
	completedBy: '<?php echo str_replace("'", "\\'", $milestone->getCompletedByName()) ?>',
	isLate: <?php echo $milestone->isLate()?"true":"false" ?>,
	daysLate: <?php echo $milestone->getLateInDays() ?>,
	duedate: <?php echo $milestone->getDueDate()->getTimestamp() ?>
}
<?php } // foreach ?>
];

var container = document.getElementById('<?php echo $container_id?>');
for (var i=0; i < milestones.length; i++) {
	var m = milestones[i];
	m.container = container;
	new og.MilestoneItem(m);
}

var newMilestoneForm = og.MilestoneItem.createAddMilestoneForm({
	toggleText: lang('add new milestone'),
	container: container
});
container.appendChild(newMilestoneForm);
</script>
