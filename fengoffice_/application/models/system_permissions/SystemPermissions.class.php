<?php


  /**
  * SystemPermissions
  *
  * @author Diego Castiglioni <diego20@gmail.com>
  */
  class SystemPermissions extends BaseSystemPermissions {
    
  		function userHasSystemPermission(Contact $user, $system_permission){
  			if($user->isAdministrator())return true;
			$contact_pg_ids = ContactPermissionGroups::getPermissionGroupIdsByContactCSV($user->getId(),false);
			$permission = self::findOne(array('conditions' => "`$system_permission` = 1 
										AND `permission_group_id` IN ($contact_pg_ids)"));
			
			if (!is_null($permission)) return true;
			return false;
  			
  		}
  		
  		function roleHasSystemPermission($role_id,$system_permission){
  			$permission=self::findOne(array('conditions' => "`$system_permission` = 1
  										AND `permission_group_id` = $role_id"));
  			if (!is_null($permission)) return true;
			return false;
  		}
  	
  		function getRolePermissions($role_id){
  			$permission=self::findOne(array('conditions'=>"`permission_group_id` = $role_id"));
  			return $permission->getSettedPermissions();
  		}
  		function getNotRolePermissions($role_id){
  			$permission=self::findOne(array('conditions'=>"`permission_group_id` = $role_id"));
  			return $permission->getNotSettedPermissions();
  		}
  		function getAllRolesPermissions(){
  			$groups=PermissionGroups::getNonPersonalPermissionGroups('`parent_id`,`id` ASC');
  			$roles_permissions=array();
  			foreach($groups as $group){
  				$roles_permissions[$group->getId()]=array();
  				$roles_permissions[$group->getId()]=self::getRolePermissions($group->getId());
  			}
  			return $roles_permissions;
  		}
  } // SystemPermissions 
