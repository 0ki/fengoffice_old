<?php

  /**
  * ObjectTypes
  *
  * @author Diego Castiglioni <diego.castiglioni@fengoffice.com>
  */
  class ObjectTypes extends BaseObjectTypes {
  	
	static function getAvailableObjectTypes($external_conditions = "") {
		$object_types = self::findAll(array("conditions" => "`type` = 'content_object' AND `name` <> 'file revision'
			AND `id` NOT IN (SELECT `object_type_id` FROM ".TabPanels::instance()->getTableName(true)." WHERE `enabled` = 0) $external_conditions"));
		
		return $object_types;
	}
	
	static function findByName($name) {
		return self::findOne(array('conditions' => array("`name` = ?", $name)));
	}
    
  } // ObjectTypes 

?>