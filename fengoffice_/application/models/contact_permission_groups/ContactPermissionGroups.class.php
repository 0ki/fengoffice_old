<?php

  /**
  * ContactPermissionGroups
  *
  * @author Diego Castiglioni <diego.castiglioni@fengoffice.com>
  */
  class ContactPermissionGroups extends BaseContactPermissionGroups {
    
  	
  	static function getPermissionGroupIdsByContactCSV($contact_id, $ignore_context = true) {
 	
 		$pgs = self::findAll(array('conditions' => '`contact_id` = '.$contact_id));
 		$pg_ids = array();
 		
 		foreach ($pgs as $pg){
 			$pg_id = $pg->getPermissionGroupId();
 			if ($ignore_context){
 				$pg_ids [] = $pg_id;
 			}
 			else {
 				if ($pg->getPermissionGroup() instanceof PermissionGroup && !$pg->getPermissionGroup()->getIsContext()) {
 					$pg_ids [] = $pg_id;
 				}
 			}
 		}
 		if ($pg_ids != null){
 			$csv_pg_ids = implode(',',$pg_ids);
 			return $csv_pg_ids;
 		}
 		return '';
 		
  	}
  	
  	
    static function getContextPermissionGroupIdsByContactCSV($contact_id) {
 	
 		$pgs = self::findAll(array('conditions' => '`contact_id` = '.$contact_id));
 		$pg_ids = array();
 		
 		foreach ($pgs as $pg){
 			$pg_id = $pg->getPermissionGroupId();
 			if ($pg->getPermissionGroup() instanceof PermissionGroup && $pg->getPermissionGroup()->getIsContext()){
 				$pg_ids [] = $pg_id;
 			}
 		}
 		$csv_pg_ids = $pg_ids != null ? implode(',',$pg_ids) : 0;
 		
 		return $csv_pg_ids;
  	}
    
  } // ContactPermissionGroups 

?>