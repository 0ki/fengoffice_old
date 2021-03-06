<?php

/**
 * ProjectTasks, generated on Sat, 04 Mar 2006 12:50:11 +0100 by
 * DataObject generation tool
 *
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class ProjectTasks extends BaseProjectTasks {

	function __construct() {
		parent::__construct();
		$this->object_type_name = 'task';
	}
	
	const ORDER_BY_ORDER = 'order';
	const ORDER_BY_STARTDATE = 'startDate';
	const ORDER_BY_DUEDATE = 'dueDate';
	const PRIORITY_URGENT = 400;
	const PRIORITY_HIGH = 300;
	const PRIORITY_NORMAL = 200;
	const PRIORITY_LOW = 100;
	

	/**
	 * Return tasks on which the user has an open timeslot
	 *
	 * @return array
	 */
	static function getOpenTimeslotTasks($context, Contact $user, $assigned_to_contact = null, $archived = false) {
		
		$archived_cond = " AND `o`.`archived_on` " . ($archived ? "<>" : "=") . " 0 ";
		
		$open_timeslot = " AND `e`.`object_id` IN (SELECT `t`.`rel_object_id` FROM " . Timeslots::instance()->getTableName(true) . " `t` WHERE `t`.`contact_id` = " . $user->getId () . " AND `t`.`end_time` = '" . EMPTY_DATETIME . "')";
		
		$assigned_to_str = "";
		if ($assigned_to_contact) {
			if ($assigned_to_contact == - 1)
				$assigned_to_contact = 0;
			$assigned_to_str = " AND `e`.`assigned_to_contact_id` = " . DB::escape ( $assigned_to_contact ) . " ";
		}
			
		$result = self::getContentObjects($context, ObjectTypes::findById(self::instance()->getObjectTypeId()), 'due_date', 'ASC', ' AND `is_template` = false' . $archived_cond . $assigned_to_str . $open_timeslot);
		$objects = $result->objects;

		return $objects;
	}
	
	/**
	 * Returns all task templates
	 *
	 */
	static function getAllTaskTemplates($only_parent_task_templates = false, $archived = false) {
		if ($archived)
			$archived_cond = "AND `archived_on` <> 0";
		else
			$archived_cond = "AND `archived_on` = 0";
		
		$conditions = " `is_template` = true $archived_cond";
		if ($only_parent_task_templates)
			$conditions .= "  and `parent_id` = 0  ";
		$order_by = "`title` ASC";
		$tasks = ProjectTasks::find ( array ('conditions' => $conditions, 'order' => $order_by ) );
		if (! is_array ( $tasks ))
			$tasks = array ();
		return $tasks;
	}
	
	function maxOrder($parentId = null, $milestoneId = null) {
		$condition = "`trashed_on` = 0 AND `is_template` = false AND `archived_on` = 0";
		if (is_numeric ( $parentId )) {
			$condition .= " AND ";
			$condition .= " `parent_id` = " . DB::escape ( $parentId );
		}
		if (is_numeric ( $milestoneId )) {
			$condition .= " AND ";
			$condition .= " `milestone_id` = " . DB::escape ( $milestoneId );
		}
		$res = DB::execute ( "
			SELECT max(`order`) as `max` 
			FROM `" . TABLE_PREFIX . "project_tasks` t  
			INNER JOIN `" . TABLE_PREFIX . "objects` o" . " ON t.object_id = o.id  
			WHERE " . $condition );
		if ($res->numRows () < 1) {
			return 0;
		} else {
			$row = $res->fetchRow ();
			return $row ["max"] + 1;
		}
	}
	
	/**
	 * Return Day tasks this user have access on
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getRangeTasksByUser(DateTimeValue $date_start, DateTimeValue $date_end, $assignedUser, $tags = '', $project = null, $archived = false) {
		//FIXME 
		
		$from_date = new DateTimeValue ( $date_start->getTimestamp () );
		$from_date = $from_date->beginningOfDay ();
		$to_date = new DateTimeValue ( $date_end->getTimestamp () );
		$to_date = $to_date->endOfDay ();
		
		$assignedFilter = '';
		if ($assignedUser instanceof Contact) {
			$assignedFilter = ' AND (`assigned_to_contact_id` = ' . $assignedUser->getId () . ' OR `assigned_to_contact_id` = ' . $assignedUser->getCompanyId () . ') ';
		}
		$rep_condition = " (`repeat_forever` = 1 OR `repeat_num` > 0 OR (`repeat_end` > 0 AND `repeat_end` >= '" . $from_date->toMySQL () . "')) ";
		
		if ($archived)
			$archived_cond = " AND `archived_on` <> 0";
		else
			$archived_cond = " AND `archived_on` = 0";
		
		$conditions = DB::prepareString(' AND `is_template` = false AND `completed_on` = ? AND ((`due_date` >= ? AND `due_date` < ?) OR (`start_date` >= ? AND `start_date` < ?) OR ' . $rep_condition . ') ' . $archived_cond . $assignedFilter, array(EMPTY_DATETIME, $from_date, $to_date, $from_date, $to_date));

		$result = self::getContentObjects(active_context(), ObjectTypes::findById(ProjectTasks::instance()->getObjectTypeId()), null, null, $conditions);
		
		return $result->objects;
	} // getDayTasksByUser
	

	/**
	 * Returns an unsaved copy of the task. Copies everything except open/closed state,
	 * anything that needs the task to have an id (like tags, properties, subtask),
	 * administrative info like who created the task and when, etc.
	 *
	 * @param ProjectTask $task
	 * @return ProjectTask
	 */
	function createTaskCopy(ProjectTask $task) {
		$new = new ProjectTask ();
		$new->setMilestoneId ( $task->getMilestoneId () );
		$new->setParentId ( $task->getParentId () );
		//$new->setTitle ( $task->getTitle () );
		$new->setObjectName($task->getObjectName()) ;
		$new->setAssignedToContactId ( $task->getAssignedToContactId () );
		$new->setPriority ( $task->getPriority () );
		$new->setTimeEstimate ( $task->getTimeEstimate () );
		$new->setText ( $task->getText () );
		$new->setOrder ( ProjectTasks::maxOrder ( $new->getParentId (), $new->getMilestoneId () ) );
		$new->setStartDate ( $task->getStartDate () );
		$new->setDueDate ( $task->getDueDate () );
		return $new;
	}
	
	/**
	 * Copies subtasks from taskFrom to taskTo.
	 *
	 * @param ProjectTask $taskFrom
	 * @param ProjectTask $taskTo
	 */
	function copySubTasks(ProjectTask $taskFrom, ProjectTask $taskTo, $as_template = false) {
		foreach ( $taskFrom->getSubTasks () as $sub ) {
			$new = ProjectTasks::createTaskCopy ( $sub );
			$new->setIsTemplate ( $as_template );
			$new->setParentId ( $taskTo->getId () );
			$new->setMilestoneId ( $taskTo->getMilestoneId () );
			$new->setOrder ( ProjectTasks::maxOrder ( $new->getParentId (), $new->getMilestoneId () ) );
			if ($sub->getIsTemplate ()) {
				$new->setFromTemplateId ( $sub->getId () );
			}
			$new->save ();
			
			$object_controller = new ObjectController();
			if (count($taskFrom->getMemberIds())) {
				$object_controller->add_to_members($new, $taskFrom->getMemberIds());
			}
			$new->copyCustomPropertiesFrom ( $sub );
			$new->copyLinkedObjectsFrom ( $sub );
			ProjectTasks::copySubTasks ( $sub, $new, $as_template );
		}
	}
	


	static function getOverdueAndUpcomingObjects($limit = null) {
		$today = DateTimeValueLib::now();
		$next_week = $today->beginningOfDay()->add('d', 7);

		$conditions = " AND `e`.`completed_by_id` = 0 AND `e`.`due_date` > 0 AND `e`.`due_date` < " . DB::escape($next_week);
		$tasks_result = ProjectTasks::instance()->getContentObjects(active_context(), ObjectTypes::findById(ProjectTasks::instance()->getObjectTypeId()), array('due_date', 'priority'), "ASC", $conditions, null, false, false, 0, $limit);
		$tasks = $tasks_result->objects;
		
		$conditions = " AND `e`.`completed_by_id` = 0 AND `e`.`due_date` > 0 AND `e`.`due_date` < " . DB::escape($next_week);
		$milestones_result = ProjectMilestones::instance()->getContentObjects(active_context(), ObjectTypes::findById(ProjectMilestones::instance()->getObjectTypeId()), array('due_date'), "ASC", $conditions, null, false, false, 0, $limit);
		$milestones = $milestones_result->objects;
		
		$ordered = array();
		foreach ($tasks as $task) {
			if (!isset($ordered[$task->getDueDate()->getTimestamp()])) $ordered[$task->getDueDate()->getTimestamp()] = array();
			$ordered[$task->getDueDate()->getTimestamp()][] = $task;
		}
		foreach ($milestones as $milestone) {
			if (!isset($ordered[$milestone->getDueDate()->getTimestamp()])) $ordered[$milestone->getDueDate()->getTimestamp()] = array();
			$ordered[$milestone->getDueDate()->getTimestamp()][] = $milestone;
		}
		
		ksort($ordered, SORT_NUMERIC);
		
		$ordered_flat = array();
		foreach ($ordered as $k => $values) {
			foreach ($values as $v) $ordered_flat[] = $v;
		}
		
		return $ordered_flat;
	}
	
	
	
	static function getContentObjects($context, $object_type, $order=null, $order_dir=null, $extra_conditions=null, $join_params=null, $trashed=false, $archived=false, $start = 0 , $limit=null){
		
		if (is_null($extra_conditions)) $extra_conditions = "";
		
		$extra_conditions .= " AND `e`.`is_template` = 0";
		
		return parent::getContentObjects($context, $object_type, $order, $order_dir, $extra_conditions, $join_params, $trashed, $archived, $start, $limit);
	}
	
} // ProjectTasks
