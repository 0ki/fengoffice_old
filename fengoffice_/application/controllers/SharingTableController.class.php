<?php 


class  SharingTableController extends ApplicationController {
	
	/**
	 * When updating perrmissions, sharing table should be updated
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param stdClass $permission:  
	 * 			[m] => 36 : Member Id 
	 * 			[o] => 3 : Object Type Id 
	 * 			[d] => 0 //delete
	 * 			[w] => 1 //write
	 * 			[r] => 1 //read 
	 * @throws Exception
	 */
	function afterPermissionChanged($group , $permissions) {
		// CHECK PARAMETERS
		if(!count($permissions)){
			return false;
		}
		if (!is_numeric($group) || !$group) {
			throw new Error("Error filling sharing table. Invalid Paramenters for afterPermissionChanged method");
		}

		// INIT LOCAL VARS
		$stManager = SharingTables::instance();
		$affectedObjects = array() ;
		$members = array();
		$general_condition = '' ;
		$read_condition = '' ;
		$delete_condition = '' ;

		// BUILD OBJECT_IDs SUB-QUERIES
		$from = "FROM ".TABLE_PREFIX."object_members om INNER JOIN ".TABLE_PREFIX."objects o ON o.id = om.object_id";
		foreach ($permissions as $permission) {
			$memberId = $permission->m;
			$objectTypeId = $permission->o;
			$delete_condition = " (  object_type_id = $objectTypeId AND om.member_id =  $memberId ) AND om.object_id NOT IN (
				SELECT distinct(object_id) FROM ".TABLE_PREFIX."object_members om
				INNER JOIN ".TABLE_PREFIX."contact_member_permissions cmp on om.member_id = cmp.member_id
				WHERE permission_group_id = $group  AND  om.member_id <> $memberId AND is_optimization = 0 
			)" ;
			$read_condition = " (  object_type_id = $objectTypeId AND om.member_id =  $memberId ) ";
			// Falta chequear las dimensiones allowAll 
			$delete_conditions[] = $delete_condition ;
			if ($permission->r) {
				$read_conditions[] = $read_condition ; 
			}
		}
		
		// DELETE THE AFFECTED OBJECTS FROM SHARING TABLE
		$stManager->delete("object_id IN (SELECT object_id $from WHERE  ".implode(' OR ' , $delete_conditions ).") AND group_id = $group ");
		
		// 2. POPULATE THE SHARING TABLE AGAIN WITH THE READ-PERMISSIONS (If there are)
		if (count($read_conditions)) {
			$st_new_rows = "
				SELECT $group AS group_id, object_id $from
				WHERE ". implode(' OR ', $read_conditions);

			$st_insert_sql =  "INSERT INTO ".TABLE_PREFIX."sharing_table(group_id, object_id) $st_new_rows ";
			DB::execute($st_insert_sql);
		}
	}
	
	
	
	
}