<?php 


class  SharingTableController extends ApplicationController {
	
	/**
	 * When updating perrmissions, sharing table should be updated
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param stdClass $permission:  
	 * 			[m] => 36
	 * 			[o] => 3
	 * 			[d] => 0 //delete
	 * 			[w] => 1 //write
	 * 			[r] => 1 //read 
	 * @throws Exception
	 */
	function afterPermissionChanged($group , $permissions) {
		$stManager = SharingTables::instance();
		if (!count($permissions)) {
			// No modifications
			
			return ;
		}
		
		// DELETE THE AFFECTED OBJECTS FROM SHARING TABLE
		$sql = "
			SELECT DISTINCT (object_id) AS oid 
			FROM ".TABLE_PREFIX."object_members om INNER JOIN ".TABLE_PREFIX."objects o ON o.id = om.object_id
			WHERE ";	
		
		$affectedObjects = array() ;
		$count = count($permissions);
		$members = array();
		foreach ($permissions as $permission) {
			$count--;
			$memberId = $permission->m;
			
			if ( $permission->r ) {
				$members[$memberId] = $memberId ;
			}
			
			$objectTypeId = $permission->o;
			$sql .= " (  object_type_id = $objectTypeId AND om.member_id =  $memberId )" ;
			if ($count > 0) $sql .= " OR ";
		}

		$res = DB::execute($sql);
		$oids = array();
		while ($row  = $res->fetchRow()) {
			$oids[] = $row['oid'] ;
		}
		
		if (!count($oids)) {
			return;	
		}
		
		$oids = implode(",", $oids);
		
		// Delete them from sharing table
		$stManager->delete("object_id IN ($sql) AND group_id = $group ");
		
		
		//if (!count($members)) {
			// No hay ningun miembro con permisos para este grupo. No hago mas nada
			//return ;
		//}
		
		// busco los objects is a los cuales el group tiene permisos y estan en los miembros leibles cambiados  
		//$mids = implode(",", $members ) ;
		
		
		// Dimensions en las cuales entan colgados los objectos afectados:
		$sql = "
			SELECT DISTINCT(dimension_id) AS did
	   		FROM
				".TABLE_PREFIX."object_members om  INNER JOIN
				".TABLE_PREFIX."members m ON m.id = om.member_id INNER JOIN
				".TABLE_PREFIX."dimensions d ON d.id = m.dimension_id
			WHERE om.object_id IN ($oids)
		
		";
		
		
		$res = DB::execute($sql);
		$dids = array();
		while ($row = $res->fetchRow()) {
			$dids[] = $row['did']; 
		}
		$sql = "" ;
		$first = true ; 
		foreach ($dids as $did) {
			if (!$first) {
				$sql .= "AND om.object_id IN ( ";	
			}

			$sql.= "
				SELECT DISTINCT (om.object_id) AS  object_id
				FROM ".TABLE_PREFIX."contact_member_permissions cmp
				INNER JOIN
				  ".TABLE_PREFIX."object_members om ON om.member_id = cmp.member_id
				INNER JOIN
				  ".TABLE_PREFIX."members m ON  m.id = om.member_id
				INNER JOIN
				  ".TABLE_PREFIX."dimensions d ON  d.id = m.dimension_id
				WHERE
				  cmp.permission_group_id = $group
		        AND om.is_optimization = 0
		        AND d.id = $did	  
			 ";
			if (!$first) {
				$sql .= " )";  
			}
			$first = false ;
		}
		

		
		$res = DB::execute($sql);
		$oids = array();
		while ($row  = $res->fetchRow() ) {
			$oids[] = $row['object_id'] ;
		}
		// Inserto en la sharing table
		$stManager->populateObjects($oids, $group);

	}
	
	
	
	
}