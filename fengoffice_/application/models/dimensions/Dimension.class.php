<?php

/**
 * Dimension class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class Dimension extends BaseDimension {
	
	
	function getAllMembers($only_ids = false, $order = null) {
		$parameters = array('conditions' => '`dimension_id` = ' . $this->getId(), 'id' => $only_ids);
		if (!is_null($order)) {
			if (in_array($order, array('name', 'dimension_id'))) $parameters['order'] = $order;
		}
		$members = Members::findAll($parameters);
  		return $members;
  	}
  	
  	
	function getRootMembers() {
		$members = Members::findAll(array('conditions' => '`parent_member_id`=0 AND `dimension_id` = ' . $this->getId()));
  		return $members;
  	}
  	
  	function isDefault() {
  		return (bool) parent::getIsDefault();
  	}
  	
  	function deniesAllForContact($permission_group_ids){
  		 		
  		$dim_permissions = ContactDimensionPermissions::findOne(array('conditions' => 
  		'`dimension_id` = ' . $this->getId(). ' AND `permission_type` <> '. DB::escape('deny all') .' 
  		AND `permission_group_id` in ('.$permission_group_ids.')'));
  	
  		if ($dim_permissions != null)
  			return false;
  		else return true;
  	}
  	
  	
	function hasAllowAllForContact($permission_group_ids){
  		  		
  		$dim_permissions = ContactDimensionPermissions::findOne(array('conditions' => 
  		'`dimension_id` = ' . $this->getId(). ' AND `permission_type` = '. DB::escape('allow all') .' 
  		AND `permission_group_id` in ('.$permission_group_ids.')'));
  	
  		if ($dim_permissions != null)
  			return true;
  		else return false;
  	}
  	
  	
	function hasCheckForContact($permission_group_ids){
  		  		
  		$dim_permissions = ContactDimensionPermissions::findOne(array('conditions' => 
  		'`dimension_id` = ' . $this->getId(). ' AND `permission_type` = '. DB::escape('check') .' 
  		AND `permission_group_id` in ('.$permission_group_ids.')'));
  	
  		if ($dim_permissions != null)
  			return true;
  		else return false;
  	}
  	
  	
  	function setContactDimensionPermission($permission_group_id, $value) {
  		if (!in_array($value, array('allow all','deny all','check'))) return;
  		
  		$dim_permission = ContactDimensionPermissions::findById(array('dimension_id' => $this->getId(), 'permission_group_id' => $permission_group_id));
  		if (!$dim_permission instanceof ContactDimensionPermission) {
  			$dim_permission = new ContactDimensionPermission();
  			$dim_permission->setPermissionGroupId($permission_group_id);
  			$dim_permission->setContactDimensionId($this->getId());
  		}
  		$dim_permission->setPermissionType($value);
  		$dim_permission->save();
  	}
  	

  	function getObjectTypeContent($object_type_id){
  		return DimensionObjectTypeContents::findAll(array('conditions' => array("`dimension_id` = ? AND `content_object_type_id` = ?", $this->getId(), $object_type_id)));
  	}
  	
  	
	function getAllowedObjectTypeContents(){
		return DimensionObjectTypeContents::findAll(array(
		'conditions' => array("`dimension_id` = ?
			AND (`content_object_type_id` IN (SELECT `id` FROM ".ObjectTypes::instance()->getTableName(true)." WHERE `type` = 'located')
			OR ( 
				`content_object_type_id` NOT IN (SELECT `object_type_id` FROM ".TabPanels::instance()->getTableName(true)." WHERE `enabled` = 0) 
	  			AND `content_object_type_id` IN (SELECT `id` FROM ".ObjectTypes::instance()->getTableName(true)." WHERE `type` = 'content_object' AND `name` <> 'file revision') 
  			))", $this->getId()), 
  		'distinct' => true));
  	}
  	
  	
  	//returns the ids of the dimensions from which $this is property
  	function getAssociatedDimensions(){
  		return DimensionMemberAssociations::getAssociatedDimensions($this->getId());
  	}
  	
  	
  	function canContainObjects(){
  		$result = DimensionObjectTypeContents::findOne(array('conditions' => '`dimension_id` = ' . $this->getId()));
  		if (!is_null($result)) return true;
  		return false;
  	}
  	
  	
	function canContainObject($object_type_id){
		$result = DimensionObjectTypeContents::findOne(array('conditions' => '`dimension_id` = '.$this->getId().' 
					AND `content_object_type_id` = '.$object_type_id));
		if (!is_null($result)) return true;
		return false;
	}
	
	
	function isRequired($object_type_id){
		$result = DimensionObjectTypeContents::findOne(array('conditions' => '`dimension_id` = '.$this->getId().' 
					AND `content_object_type_id` = '.$object_type_id.' AND `is_required` = 1'));
		if (!is_null($result)) return true;
		return false;
	}
	
	function getRequiredObjectTypes() {
		$result = DimensionObjectTypeContents::findAll(array('conditions' => '`dimension_id` = '.$this->getId().' AND `is_required` = 1'));
		
		$types = array();
		if ($result && is_array($result)) {
			foreach ($result as $res) {
				$types[] = $res->getContentObjectTypeId();
			}
		}
		return $types;
	}
	
	function getOptions($decoded = false ) {
		$js = $this->getColumnValue("options") ;
		if ( $decoded ) { 
			return json_decode ( $js );
		}else{
			return $js ;
		}
	}

}
