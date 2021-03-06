<?php
$genid = gen_id();
$limit = 20;
$total = $limit;
$page = 10;

$task_assignment_conditions = "";
if (!SystemPermissions::userHasSystemPermission(logged_user(), 'can_see_assigned_to_other_tasks')) {
	$task_assignment_conditions = " AND assigned_to_contact_id = ".logged_user()->getId();
}

$tasks_result = ProjectTasks::instance()->listing(array(
	"order" => "completed_on",
	"order_dir" => "DESC",
	"extra_conditions" => " AND is_template = 0 AND completed_by_id > 0 $task_assignment_conditions",
	"limit" => $limit + 1,
));

$tasks = $tasks_result->objects;

$cmember = current_member();
if($cmember != NULL){
	$widget_title = lang("completed tasks") . " " . lang("in") . " " . $cmember->getName();
}

if ($tasks_result->total > 0) {
	include 'template.php';
}