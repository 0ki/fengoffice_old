<?php

  /**
  * DimensionMemberAssociations
  *
  * @author Diego Castiglioni <diego.castiglioni@fengoffice.com>
  */
  class DimensionMemberAssociations extends BaseDimensionMemberAssociations {
    
    function getAssociatedDimensions($associated_dimension_id) {

  		$sql = "SELECT DISTINCT (`dimension_id`) FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `associated_dimension_id` = $associated_dimension_id";
  		
  		$result = DB::execute($sql);
    	$rows = $result->fetchAll();
    	$dimension_ids = array();
    	if ($rows){
	    	foreach ($rows as $row){
	    		$dimension_ids[] = (int)$row['dimension_id'];
	    	}
    	}

    	return $dimension_ids ;	
  	}
  	
  	
    function getDimensionsToReload($dimension_id) {

  		$sql = "SELECT DISTINCT(`associated_dimension_id`) FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `dimension_id` = $dimension_id
				UNION SELECT DISTINCT(`dimension_id`) FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `associated_dimension_id` = $dimension_id";
  		
  		$result = DB::execute($sql);
    	$rows = $result->fetchAll();
    	$dIds = array();
    	if ($rows){
	    	foreach ($rows as $row){
	    		$dIds[] = (int)$row['associated_dimension_id'];
	    	}
    	}

    	return $dIds;
  	}
  	
  	
  	/** 
  	 * Returns an array with the dimensions to reload foreach member type that belongs to this dimension
  	 */
	function getDimensionsToReloadByObjectType($dimension_id) {
		
		$sql = "SELECT `associated_dimension_id` as dim_id, `object_type_id` as ot_id FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `dimension_id` = $dimension_id
				UNION SELECT `dimension_id` as dim_id, `associated_object_type_id` as ot_id  FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `associated_dimension_id` = $dimension_id";
		
		$rows = DB::executeAll($sql);
		
		$result = array();
		if (is_array($rows)) {
			foreach ($rows as $row) {
				if (!isset($result[$row['ot_id']])) $result[$row['ot_id']] = array();
				$result[$row['ot_id']][] = $row['dim_id'];
			}
		}
		
		return $result;
	}
  	
  	
    function getAllAssociationIds($dimension_id, $associated_dimension_id, $obj_type_id=null) {
    	
    	$ot_cond = "";
    	$associated_ot_cond = "";
    	if (is_numeric($obj_type_id)) {
    		$ot_cond = " AND object_type_id=$obj_type_id";
    		$associated_ot_cond = " AND associated_object_type_id=$obj_type_id";
    	}
		
    	$sql = "SELECT `id` FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `dimension_id` = $dimension_id $ot_cond AND `associated_dimension_id` = $associated_dimension_id
		  UNION SELECT `id` FROM `".TABLE_PREFIX."dimension_member_associations` WHERE `dimension_id` = $associated_dimension_id $associated_ot_cond AND `associated_dimension_id` = $dimension_id";
  		
    	$result = DB::execute($sql);
    	$rows = $result->fetchAll();
    	$association_ids = array();
    	if ($rows){
	    	foreach ($rows as $row){
	    		$association_ids[] = (int)$row['id'];
	    	}
    	}

    	return $association_ids;	
  	}
  	
  	
    function getAllAssociations($dimension_id, $associated_dimension_id) {

  		$associations =  self::findAll(array('conditions' => '`dimension_id` = ' . 
								$dimension_id.' AND `associated_dimension_id` = ' . $associated_dimension_id));
		return $associations;
  	}
  	
  	static function getAssociatations($dimension_id, $object_type_id) {
  		return self::findAll(array("conditions" => array("`dimension_id` = ? AND `object_type_id` = ?", $dimension_id, $object_type_id)));
  	}
  	
  	static function getAllAssociatationsForObjectType($dimension_id, $object_type_id) {
  		return self::findAll(array("conditions" => array("`dimension_id` = ? AND `object_type_id` = ? OR `associated_dimension_id` = ? AND `associated_object_type_id` = ?",
  				$dimension_id, $object_type_id, $dimension_id, $object_type_id)));
  	}
  	
	static function getRequiredAssociatations($dimension_id, $object_type_id, $only_ids = false) {
  		return self::findAll(array(
  			"conditions" => array("`dimension_id` = ? AND `object_type_id` = ? AND is_required = 1", $dimension_id, $object_type_id),
  			"id" => $only_ids,
  		));
  	}
  
  	
    function existsAssociationBetweenDimensions($dimension_id, $associated_dimension_id){
  		$associations =  self::findOne(array('conditions' => '`dimension_id` = ' . 
								$dimension_id.' AND `associated_dimension_id` = ' . $associated_dimension_id));
			
		if (is_null($associations)) return false;
		else return true;						
  	}
  	
  	
  	
  	function getAllAssociationsInfo() {
  		$enabled_dimensions = config_option('enabled_dimensions');
		$dimensions = Dimensions::findAll(array('conditions' => 'id IN ('.implode(',', $enabled_dimensions).')'));
		
		$dims_info = array();
		
		foreach ($dimensions as $dim) {
			$associations = self::findAll(array('conditions' => '`dimension_id` = ' .$dim->getId().' OR `associated_dimension_id` = ' . $dim->getId()));
			
			if (is_array($associations) && count($associations)) {
				$this_dim_info = array();
				foreach ($associations as $assoc) {
					/* @var $assoc DimensionMemberAssociation */
					
					if ($assoc->getDimensionId() == $dim->getId()) {
						if (!in_array($assoc->getAssociatedDimensionMemberAssociationId(), $enabled_dimensions)) continue;
						
						$object_type_id = $assoc->getObjectTypeId();
						$assoc_dimension_id = $assoc->getAssociatedDimensionMemberAssociationId();
						$assoc_dim = Dimensions::getDimensionById($assoc->getAssociatedDimensionMemberAssociationId());
						$assoc_dimension_name = $assoc_dim->getName();
						$assoc_dimension_code = $assoc_dim->getCode();
						$assoc_object_type_id = $assoc->getAssociatedObjectType();
					} else {
						if (!in_array($assoc->getDimensionId(), $enabled_dimensions)) continue;
						
						$object_type_id = $assoc->getAssociatedObjectType();
						$assoc_dimension_id = $assoc->getDimensionId();
						$assoc_dim = Dimensions::getDimensionById($assoc->getDimensionId());
						$assoc_dimension_name = $assoc_dim->getName();
						$assoc_dimension_code = $assoc_dim->getCode();
						$assoc_object_type_id = $assoc->getObjectTypeId();
					}
					
					$info = array(
						'id' => $assoc->getId(),
						'name' => $assoc_dimension_name,
						'code' => $assoc_dimension_code,
						'assoc_dimension_id' => $assoc_dimension_id,
						'assoc_object_type_id' => $assoc_object_type_id,
						'is_required' => $assoc->getIsRequired(),
						'is_multiple' => $assoc->getIsMultiple(),
						'keeps_record' => $assoc->getKeepsRecord(),
						'allows_default_selection' => $assoc->getAllowsDefaultSelection(),
						'is_reverse' => $dim->getId() != $assoc->getDimensionId(),
						// load the configs only in one direction
						'config' => $dim->getId() == $assoc->getDimensionId() ? $assoc->getConfig() : array(),
					);
					
					if (!isset($this_dim_info[$object_type_id])) {
						$this_dim_info[$object_type_id] = array();
					}
					$this_dim_info[$object_type_id][] = $info;
				}
				
				$dims_info[$dim->getId()] = $this_dim_info;
			}
		}
		
		return $dims_info;
  	}
  	
  	
  	function getAssociationObject($dimension_id, $object_type_id, $assoc_dimension_id, $assoc_object_type_id) {
  		return self::findOne(array('conditions' => "dimension_id=$dimension_id AND object_type_id=$object_type_id
  				AND associated_dimension_id=$assoc_dimension_id AND associated_object_type_id=$assoc_object_type_id"));
  	}
  	
  	
  }

?>