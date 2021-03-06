<?php

  /**
  * DimensionObjectTypeHierarchies
  *
  * @author Diego Castiglioni <diego20@gmail.com>
  */
  class DimensionObjectTypeHierarchies extends BaseDimensionObjectTypeHierarchies {
    
  	static function getAllChildrenObjectTypeIds($dimension_id, $parent_object_type_id, $recursive = true){
  		
  		$dimension_obj_type_hierarchy = DimensionObjectTypeHierarchies::findAll(array('conditions' => 
  		'`dimension_id` = ' . $dimension_id. ' AND `parent_object_type_id` = ' . $parent_object_type_id));
		
  		$children = array();
  		if ($recursive) {
	  		foreach ($dimension_obj_type_hierarchy as $obj_type_hierarchy) {
	  			$child = $obj_type_hierarchy->getChildObjectTypeId();
	  			$children [] = $child;
	  			$children = array_unique(array_merge($children, self::getAllChildrenObjectTypeIds($dimension_id, $child, $recursive)));
	  		}
		}
		
		return $children;
	}//getAllChildrenObjectTypeIds
	
	
	static function getAllParentObjectTypeIds($dimension_id, $child_object_type_id, $recursive = true){
  		
  		$dimension_obj_type_hierarchy = DimensionObjectTypeHierarchies::findAll(array('conditions' => 
  		'`dimension_id` = ' . $dimension_id. ' AND `child_object_type_id` = ' . $child_object_type_id));
		
  		$parents = array();
  		if ($recursive) {
	  		foreach ($dimension_obj_type_hierarchy as $obj_type_hierarchy) {
	  			$parent = $obj_type_hierarchy->getParentObjectTypeId();
	  			$parents [] = $parent;
	  			$parents = array_unique(array_merge($parents, self::getAllParentObjectTypeIds($dimension_id, $parent, $recursive)));
	  		}
		}
		
		return $parents;
	}//getAllParentObjectTypeIds
  		
  } // DimensionObjectTypeHierarchies 

?>