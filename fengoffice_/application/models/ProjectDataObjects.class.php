<?php

/**
 * Abstract class that implements methods that share all projectlists (find, paginate, trash, etc)
 *
 * Project objects is data manager with few extra functions
 *
 * @version 1.0
 * @author Ignacio de Soto <ignacio.desoto@gmail.com>
 */
abstract class ProjectDataObjects extends DataManager {
	private function check_include_trashed(& $arguments = null) {
		if (!array_var($arguments, 'include_trashed', false)) {
			$columns = $this->getColumns();
			if (array_search("trashed_by_id", $columns) != false) {
				$conditions = array_var($arguments, 'conditions', '');
				if (is_array($conditions)) {
					$conditions[0] = "`trashed_by_id` = 0 AND (".$conditions[0].")";
				} else if ($conditions != '') {
					$conditions = "`trashed_by_id` = 0 AND ($conditions)";
				} else {
					$conditions = "`trashed_by_id` = 0";
				}
				$arguments['conditions'] = $conditions;
			}
		}
	}
	
	function find($arguments = null) {
		$this->check_include_trashed($arguments);
		return parent::find($arguments);
	}
	
	function paginate($arguments = null, $items_per_page = 10, $current_page = 1, $count = null) {
		$this->check_include_trashed($arguments);
		return parent::paginate($arguments, $items_per_page, $current_page, $count);
	}
	
	function getUserTags() {
		$oc = new ObjectController();
		$queries = $oc->getDashboardObjectQueries();
		$objects = "";
		foreach ($queries as $type => $query) {
			if (!str_ends_with($type, "Comments")) {
				if ($objects != "") $objects .= " \n UNION \n ";
				$objects .= $query;
			}
		}
		$sql = "SELECT DISTINCT `t`.`tag` AS `name`, count(`t`.`tag`) AS `count` FROM `" . TABLE_PREFIX . "tags` `t`, ($objects) `o` WHERE `t`.`rel_object_manager` = `o`.`object_manager_value` AND `t`.`rel_object_id` = `o`.`oid` GROUP BY `t`.`tag` ORDER BY `count` DESC, `t`.`tag`";
	}
	

	/**
	 * Populates common data for a set of objects such as tags, timeslots, etc.
	 * 
	 * @param $objects_list
	 * @return unknown_type
	 */
	function populateData($objects_list){
		if (is_array($objects_list) && count($objects_list) > 0){
			$manager_objects = array();
			foreach ($objects_list as $object){
				if ($object instanceof ProjectDataObject) {
					$manager = $object->getObjectManagerName();
					if (!array_key_exists($manager, $manager_objects))
						$manager_objects[$manager] = array();
					
					$manager_objects[$manager][] = $object;
				}
			}
			
			foreach ($manager_objects as $manager => $objects){
				self::populateTags($objects);
				self::populateIsRead($objects);
				self::populateTimeslots($objects);
			}
		}
	}

	private function populateTimeslots($objects_list){
		if (is_array($objects_list) && count($objects_list) > 0 && $objects_list[0]->allowsTimeslots() && $objects_list[0] instanceof ProjectDataObject){
			$ids = array();
			$objects = array();
			$manager_name = $objects_list[0]->getObjectManagerName();
			for ($i = 0; $i < count($objects_list); $i++){
				$ids[] = $objects_list[$i]->getId();
				$objects[$objects_list[$i]->getId()] = $objects_list[$i];
				$objects_list[$i]->timeslots = array();
				$objects_list[$i]->timeslots_count = 0;
			}
			if (count($ids > 0)){
				$timeslots = Timeslots::findAll(array('conditions' => 'object_manager = \'' . $manager_name . '\' AND object_id in (' . implode(',', $ids) . ')'));
				for ($i = 0; $i < count($timeslots); $i++){
					$object = $objects[$timeslots[$i]->getObjectId()];
					$object->timeslots[] = $timeslots[$i];
					$object->timeslots_count = count($object->timeslots);
				}
			}
		}
	}


	/**
	 * Populates the tags for a list of objects.
	 * 
	 * @param $objects_list
	 * @return unknown_type
	 */
	private function populateTags($objects_list){
		if (is_array($objects_list) && count($objects_list) > 0 && $objects_list[0]->isTaggable() && $objects_list[0] instanceof ProjectDataObject){
			$ids = array();
			$objects = array();
			$manager_name = $objects_list[0]->getObjectManagerName();
			if ($manager_name == 'MailContents'){
				return;//TODO optimize mail tags loading
			}
			for ($i = 0; $i < count($objects_list); $i++){
				$ids[] = $objects_list[$i]->getId();
				$objects[$objects_list[$i]->getId()] = $objects_list[$i];
				$objects_list[$i]->tags = array();
			}
			if (count($ids > 0)){
				$tags = Tags::getTagsByObjectIds(implode(',', $ids), $manager_name);
				for ($i = 0; $i < count($tags); $i++){
					$object = $objects[$tags[$i]->getRelObjectId()];
					if ($object)
					$object->tags[] = $tags[$i];
				}
			}
		}
	}


	/**
	 * Populates information about read status for the 
	 * 
	 * @param $objects_list
	 * @return unknown_type
	 */
	private function populateIsRead($objects_list){
		if (is_array($objects_list) && count($objects_list) > 0 && $objects_list[0]->isReadMarkable()){
			$ids = array();
			$objects = array();
			$manager_name = $objects_list[0]->getObjectManagerName();
			for ($i = 0; $i < count($objects_list); $i++){
				$ids[] = $objects_list[$i]->getId();
				$objects[$objects_list[$i]->getId()] = $objects_list[$i];
				$objects_list[$i]->is_read[logged_user()->getId()] = false;
			}
			if (count($ids > 0)){
				$readObjects = ReadObjects::findAll(array('conditions' => 'user_id = \'' . logged_user()->getId() . '\' AND rel_object_manager = \'' . $manager_name . '\' AND rel_object_id in (' . implode(',', $ids) . ')'));
				for ($i = 0; $i < count($readObjects); $i++){
					$object = $objects[$readObjects[$i]->getRelObjectId()];
					$object->is_read[logged_user()->getId()] = $readObjects[$i]->getIsRead();
				}
			}
		}
	}
}

?>