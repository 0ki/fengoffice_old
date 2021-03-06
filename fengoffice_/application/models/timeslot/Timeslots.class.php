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
	static function getTimeslotsByObject(ProjectDataObject $object, User $user = null) {
		$userCondition = '';
		if ($user)
		$userCondition = ' and `user_id` = '. $user->getId();

		return self::findAll(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ?' . $userCondition, $object->getObjectId(), get_class($object->manager())),
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject
	
	static function getOpenTimeslotByObjectAndUser(ProjectDataObject $object, User $user) {
		$userCondition = ' and `user_id` = '. $user->getId();

		return self::findOne(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ? AND `end_time`= ? ' . $userCondition, $object->getObjectId(), get_class($object->manager()), EMPTY_DATETIME), 
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject

	/**
	 * Return number of timeslots for specific object
	 *
	 * @param ProjectDataObject $object
	 * @return integer
	 */
	static function countTimeslotsByObject(ProjectDataObject $object, User $user = null) {
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
	static function getTaskTimeslots(Project $workspace = null, User $user= null, $workspacesCSV=null, DateTimeValue $start_date, DateTimeValue $end_date, $object_id = 0, $group_by = null, $order_by = null){
		$wslevels = 0;
		foreach ($group_by as $gb)
			if ($gb == "project_id")
				$wslevels++;
		
		$wsDepth = 0;
		if ($workspace instanceof Project)
			$wsDepth = $workspace->getDepth();
		
		$wslevels = min(array($wslevels, 10 - $wsDepth));
		if ($wslevels < 0) $wslevels = 0;
		
		$select = "SELECT `" . TABLE_PREFIX . "timeslots`.*";
		for ($i = 0; $i < $wslevels; $i++)
			$select .= ", ws" . $i . ".name as wsName" . $i . ", ws" . $i . ".id as wsId" . $i;
			
		$from = " FROM ";
		for ($i = 0; $i < $wslevels; $i++)
			$from .= "(";
		$from .= "`" . TABLE_PREFIX . "timeslots`, `" . TABLE_PREFIX . "project_tasks`, `" . TABLE_PREFIX ."projects`";
		for ($i = 0; $i < $wslevels; $i++)
			$from .= ") LEFT OUTER JOIN `" . TABLE_PREFIX . "projects` as ws" . $i . " on `" . TABLE_PREFIX . "projects`.p" . ($wsDepth + $i + 1) . " = ws" . $i . ".id";
		
		
		$sql = $select . $from;
		$sql .= " WHERE `object_manager` = 'ProjectTasks'  and " . TABLE_PREFIX . "project_tasks.id = object_id and " . TABLE_PREFIX . "project_tasks.project_id = `" . TABLE_PREFIX . "projects`.id";
		$sql .= DB::prepareString(' and `start_time` > ? and `end_time` < ?', array($start_date, $end_date));
		
		//User condition
		$sql .= $user? ' and `user_id` = '. $user->getId() : '';
		
		//Project condition
		$sql .= $workspacesCSV? ' and ' . TABLE_PREFIX . 'project_tasks.project_id in (' . $workspacesCSV . ')' : '';
		
		//Object condition
		$sql .= $object_id > 0 ? ' and object_id = ' . $object_id : '';
		
		//Group by
		$wsCount = 0;
		$sql .= ' order by ';
		if (is_array($group_by)){
			foreach ($group_by as $gb){
				switch($gb){
					case 'project_id':
						$sql.= "wsName" . $wsCount . " ASC, ";
						$wsCount++;
						break;
					case 'id':
					case 'priority':
					case 'milestone_id':
					case 'state':
						$sql.= "`" . TABLE_PREFIX . "project_tasks`.`$gb` ASC, "; break;
					default:
						$sql.= "`" . TABLE_PREFIX . "timeslots`.`$gb` ASC, "; break;
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
	
	
	static function getTimeslotsByUserWorkspacesAndDate(User $user= null, $workspacesCSV=null, DateTimeValue $start_date, DateTimeValue $end_date, $object_manager, $object_id = 0){
		
		
		$userCondition = '';
		if ($user)
		$userCondition = ' and `user_id` = '. $user->getId();
		
		$projectCondition = '';
		if ($workspacesCSV && $object_manager == 'ProjectTasks')
			$projectCondition = ' and (Select count(*) from '. TABLE_PREFIX . 'project_tasks where '. TABLE_PREFIX . 'project_tasks.id = object_id and '
			. TABLE_PREFIX . 'project_tasks.project_id in (' . $workspacesCSV . ')) > 0';
			
		$objectCondition = '';
		if ($object_id > 0)
			$objectCondition = ' and object_id = ' . $object_id;
		
		return self::findAll(array(
          'conditions' => array('`object_manager` = ? and `start_time` > ? and `end_time` < ?' . $userCondition . $projectCondition . $objectCondition, $object_manager, $start_date, $end_date),
          'order' => '`start_time`'
          )); // array
	
	}
} // Comments

?>