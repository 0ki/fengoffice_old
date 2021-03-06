<?php

/**
 * SystemPermission class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class SystemPermission extends BaseSystemPermission {
		
	function setAllPermissions($value){
		$columns = $this->manager()->getColumns();
		foreach ($columns as $col) {
			if (in_array($col, array('permission_group_id'))) continue;
			$this->setColumnValue($col, $value);
		}
	}
	
	function setPermission($value){
		$this->setColumnValue($value, 1);
	}
	
}