<?php

  /**
  * PermissionGroups
  *
  * @author Diego Castiglioni <diego20@gmail.com>
  */
  class PermissionGroups extends BasePermissionGroups {
    
    function getNonPersonalPermissionGroups($order = '`name` ASC') {
    	return self::findAll(array("conditions" => "`contact_id` = 0 AND `parent_id` != 0", "order" => $order));
    }
    function getNonPersonalSameLevelPermissionsGroups($order = '`name` ASC') {
    	return self::findAll(array("conditions" => "`contact_id` = 0 AND `parent_id` != 0 AND `id` >= ".logged_user()->getUserType(), "order" => $order));
    }
    function getParentId($group_id){
    	return self::findById($group_id)->getParentId();
    }
    
  } // PermissionGroups 

?>