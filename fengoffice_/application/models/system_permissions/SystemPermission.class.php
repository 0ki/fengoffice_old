<?php

/**
 * SystemPermission class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class SystemPermission extends BaseSystemPermission {
		
	function setAllPermissions($value){
		$this->setCanEditCompanyData($value);
		$this->setCanManageConfiguration($value);
		$this->setCanManageSecurity($value);
		$this->setCanManageMembers($value);
		$this->setCanManageTemplates($value);
		$this->setCanManageTime($value);
		$this->setCanManageReports($value);
		$this->setCanAddMailAccounts($value);
	}
	
	function setPermission($value){
		$this->setColumnValue($value, 1);
	}
	
}