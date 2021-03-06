<?php

  /**
  * Members
  *
  * @author Diego Castiglioni <diego20@gmail.com>
  */
  class Members extends BaseMembers {
    
	static function getSubmembers(Member $member, $recursive = true) {
		$members = Members::findAll(array('conditions' => '`parent_member_id` = ' . $member->getId()));
		if ($recursive) {
	  		foreach ($members as $m) {
	  			$members = array_merge($members, self::getSubmembers($m, $recursive));
	  		}
		}
		return $members;
	}
	
	static function getByDimensionObjType($dimension_id, $object_type_id) {
		return Members::findAll(array("conditions" => array("`dimension_id` = ? AND `object_type_id` = ?", $dimension_id, $object_type_id)));
	}
	
	/**
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * Find all members that have $id at 'object_id_column'
	 */
	static function findByObjectId($id) {
		return self::findAll(array("conditions" => array(
			"`object_id` = ? ", $id 
		)));
		
	}	
	
  } 
