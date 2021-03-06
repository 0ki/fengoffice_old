<?php

/**
 * class Timeslots
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class Timeslots extends BaseTimeslots {

	/**
	 * Return object timeslots
	 *
	 * @param ProjectDataObject $object
	 * @return array
	 */
	static function getTimeslotsByObject(ProjectDataObject $object, $user = null) {
		$userCondition = '';
		if ($user)
			$userCondition = ' and `user_id` = '. $user->getId();

		return self::findAll(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ?' . $userCondition, $object->getObjectId(), get_class($object->manager())),
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject
	
	
	static function getOpenTimeslotByObject(ProjectDataObject $object, $user = null) {
		$userCondition = '';
		if ($user)
			$userCondition = ' and `user_id` = '. $user->getId();

		return self::findOne(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ? AND `end_time`= ? ' . $userCondition, $object->getObjectId(), get_class($object->manager()), EMPTY_DATETIME), 
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject
	
	
	static function getOpenTimeslotsByObject(ProjectDataObject $object) {
		return self::findAll(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ? AND `end_time`= ? ', $object->getObjectId(), get_class($object->manager()), EMPTY_DATETIME), 
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject

	/**
	 * Return number of timeslots for specific object
	 *
	 * @param ProjectDataObject $object
	 * @return integer
	 */
	static function countTimeslotsByObject(ProjectDataObject $object, $user = null) {
		$userCondition = '';
		if ($user)
		$userCondition = ' and `user_id` = '. $user->getId();

		return self::count(array('`object_id` = ? AND `object_manager` = ?' . $userCondition, $object->getObjectId(), get_class($object->manager())));
	} // countTimeslotsByObject

	/**
	 * Drop timeslots by object
	 *
	 * @param ProjectDataObject
	 * @return boolean
	 */
	static function dropTimeslotsByObject(ProjectDataObject $object) {
		return self::delete(array('`object_manager` = ? AND `object_id` = ?', get_class($object->manager()), $object->getObjectId()));
	} // dropTimeslotsByObject

	/**
	 * Returns timeslots based on the set query parameters
	 *
	 * @param User $user
	 * @param string $workspacesCSV
	 * @param DateTimeValue $start_date
	 * @param DateTimeValue $end_date
	 * @param string $object_manager
	 * @param string $object_id
	 * @param array $group_by
	 * @param array $order_by
	 * @return array
	 */
	static function getTaskTimeslots($workspace = null, $user = null, $workspacesCSV = null, $start_date = null, $end_date = null, $object_id = 0, $group_by = null, $order_by = null, $limit = 0, $offset = 0, $timeslot_type = 0){
		$wslevels = 0;
		foreach ($group_by as $gb)
			if ($gb == "project_id")
				$wslevels++;
		
		$wsDepth = 0;
		if ($workspace instanceof Project)
			$wsDepth = $workspace->getDepth();
		
		$wslevels = min(array($wslevels, 10 - $wsDepth));
		if ($wslevels < 0) $wslevels = 0;
		
		$select = "SELECT `ts`.*";
		for ($i = 0; $i < $wslevels; $i++)
			$select .= ", `ws" . $i . "`.`name` AS `wsName" . $i . "`, `ws" . $i . "`.`id` AS `wsId" . $i . "`";
			
		$preFrom = " FROM ";
		for ($i = 0; $i < $wslevels; $i++)
			$preFrom .= "(";
		$postFrom = "";
		for ($i = 0; $i < $wslevels; $i++)
			$postFrom .= ") LEFT OUTER JOIN `pr` AS `ws" . $i . "` ON `pr`.`p" . ($wsDepth + $i + 1) . "` = `ws" . $i . "`.`id`";
		
		$commonConditions = "";
		if ($start_date)
			$commonConditions .= DB::prepareString(' AND `ts`.`start_time` >= ? ', array($start_date));
		if ($end_date)
			$commonConditions .= DB::prepareString(' AND (`ts`.`paused_on` <> 0 OR `ts`.`end_time` <> 0 AND `ts`.`end_time` < ?) ', array($end_date));
			
		//User condition
		$commonConditions .= $user? ' AND `ts`.`user_id` = '. $user->getId() : '';
		
		//Object condition
		$commonConditions .= $object_id > 0 ? ' AND `ts`.`object_manager` = "ProjectTasks" AND `ts`.`object_id = ' . $object_id : ''; //Only applies to tasks
		
		$sql = '';
		switch($timeslot_type){
			case 0: //Task timeslots
				$from = "`" . TABLE_PREFIX . "timeslots` AS `ts`, `" . TABLE_PREFIX . "project_tasks` AS `pt`, `" . TABLE_PREFIX ."projects` AS `pr`";
				$conditions = " WHERE `ts`.`object_manager` = 'ProjectTasks'  AND `pt`.`id` = `ts`.`object_id` AND `pt`.`trashed_by_id` = 0 AND `wo`.`object_manager` = 'ProjectTasks' AND `wo`.`object_id` = `ts`.`object_id` AND `wo`.`workspace_id` = `pr`.`id`";
				//Project condition
				$conditions .= $workspacesCSV ? ' AND `pr`.`id` IN (' . $workspacesCSV . ')' : '';
				
				$sql = $select . $preFrom . $from . $postFrom . $conditions . $commonConditions;
				break;
			case 1: //Time timeslots
				$from = "`" . TABLE_PREFIX . "timeslots` AS `ts`, `" . TABLE_PREFIX ."projects` AS `pr`";
				$conditions = " WHERE `ts`.`object_manager` = 'Projects'";
				$conditions .= $workspacesCSV ? ' AND `ts`.`object_id` IN (' . $workspacesCSV . ") AND `ts`.`object_id` = `pr`.`id`" : " AND `ts`.`object_id` = `pr`.`id`";
				
				$sql = $select . $preFrom . $from . $postFrom . $conditions . $commonConditions;
				break;
			case 2: //All timeslots
				$from1 = "`" . TABLE_PREFIX . "timeslots` AS `ts`, `" . TABLE_PREFIX . "project_tasks` AS `pt`, `" . TABLE_PREFIX ."projects` AS `pr`";
				$from2 = "`" . TABLE_PREFIX . "timeslots` AS `ts`, `" . TABLE_PREFIX ."projects` AS `pr`";
				
				$conditions1 = " WHERE `ts`.`object_manager` = 'ProjectTasks'  AND `pt`.`id` = `ts`.`object_id` AND `pt`.`trashed_by_id` = 0 AND `wo`.`object_manager` = 'ProjectTasks' AND `wo`.`object_id` = `ts`.`object_id` AND `wo`.`workspace_id` = `pr`.`id`";
				//Project condition
				$conditions1 .= $workspacesCSV ? ' AND `pr`.`id` IN (' . $workspacesCSV . ')' : '';
				
				$conditions2 = " WHERE `object_manager` = 'Projects'";
				$conditions2 .= $workspacesCSV ? ' AND `ts`.`object_id` IN (' . $workspacesCSV . ") AND `ts`.`object_id` = `pr`.`id`" : " AND `ts`.`object_id` = `pr`.`id`";
				
				
				$sql = $select . $preFrom . $from1 . $postFrom . $conditions1 . $commonConditions . ' UNION ' . $select . $preFrom . $from2 . $postFrom . $conditions2 . $commonConditions;
				break;
			default:
				throw new Error("Timeslot type not recognised: " . $timeslot_type);
		}
		
		//Group by
		$wsCount = 0;
		$sql .= ' ORDER BY ';
		if (is_array($group_by)){
			foreach ($group_by as $gb){
				switch($gb){
					case 'project_id':
						$sql.= "`wsName" . $wsCount . "` ASC, ";
						$wsCount++;
						break;
					case 'id':
					case 'priority':
					case 'milestone_id':
					case 'state':
						if ($timeslot_type == 0)
							$sql.= "`pt`.`$gb` ASC, "; 
						break;
					default:
						$sql.= "`$gb` ASC, "; break;
				}
			}
		}
		
		//Order by
		if (is_array($order_by)){
			foreach ($order_by as $ob){
				$sql.= "`$ob` ASC, ";
			}
		}
		
		$sql .= " `start_time`";
		if ($limit > 0 && $offset > 0)
			$sql .= " LIMIT $offset, $limit";

		$timeslots = array();
		$rows = DB::executeAll($sql);
		if(is_array($rows)) {
			foreach($rows as $row) {
				$tsRow = array("ts" => Timeslots::instance()->loadFromRow($row));
				for ($i = 0; $i < $wslevels; $i++)
					$tsRow["wsId".$i] = $row["wsId" . $i];
				$timeslots[] = $tsRow;
			} // foreach
		} // if
		
    	return count($timeslots) ? $timeslots : null;
	}
	
	static function getTimeslotsByUserWorkspacesAndDate(DateTimeValue $start_date, DateTimeValue $end_date, $object_manager, $user = null, $workspacesCSV = null, $object_id = 0){
		$userCondition = '';
		if ($user)
			$userCondition = ' AND `user_id` = '. $user->getId();
		
		$projectCondition = '';
		if ($workspacesCSV && $object_manager == 'ProjectTasks')
			$projectCondition = ' AND (SELECT count(*) FROM `'. TABLE_PREFIX . 'project_tasks` as `pt`, `' . TABLE_PREFIX . 'workspace_objects` AS `wo` WHERE `pt`.`id` = `object_id` AND `pt`.`trashed_by_id` = 0 AND ' .
			"`wo`.`object_manager` = 'ProjectTasks' AND `wo`.`object_id` = `object_id` AND `wo`.`workspace_id` IN (" . $workspacesCSV . ')) > 0';
			
		$objectCondition = '';
		if ($object_id > 0)
			$objectCondition = ' AND `object_id` = ' . $object_id;
		
		return self::findAll(array(
          'conditions' => array('`object_manager` = ? and `start_time` > ? and `end_time` < ?' . $userCondition . $projectCondition . $objectCondition, $object_manager, $start_date, $end_date),
          'order' => '`start_time`'
          )); // array
	
	}

	static function getAllProjectTimeslots($project) {
		return Timeslots::findAll(array(
			'conditions' => "object_manager = 'Projects' AND `object_id` = " . $project->getId() 
		));
	}
	
	static function getProjectTimeslots($allowedWorkspaceIdsCSV = null, $user = null, $project = null, $offset = 0, $limit = 20) {
		$project_sql = "";
		if ($allowedWorkspaceIdsCSV != null) {
			$project_sql .= " AND `object_id` IN ($allowedWorkspaceIdsCSV)";
		}
		if ($project instanceof Project) {
			$pids = $project->getAllSubWorkspacesQuery();
			$project_sql .= " AND `object_id` IN ($pids)";
		}
			
		$user_sql = "";
		if ($user instanceof User)
			$user_sql = " AND user_id = " . $user->getId();
		
		return Timeslots::findAll(array(
			'conditions' => "object_manager = 'Projects'" . $project_sql . $user_sql, 
			'order' => 'start_time DESC, id DESC',
			'offset' => $offset,
			'limit' => $limit));
	}
} // Comments

?>