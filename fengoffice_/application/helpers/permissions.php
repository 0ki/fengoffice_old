<?php

// Functions that check permissions
// Recomendation: Before changing this, talk with marcos.saiz@opengoo.org

  	define('ACCESS_LEVEL_READ', 1);
  	define('ACCESS_LEVEL_WRITE', 2);
  	
  	
  	/**
  	 * Returns whether a user can manage security.
  	 * If groups are checked, one true permission makes the function return true.
  	 *
  	 * @param User $user
  	 * @param boolean $include_groups states whether groups should be checked for permissions
  	 * @return boolean
  	 */
  	function can_manage_security(User $user, $include_groups = true){
  		if ($user->getCanManageSecurity()){
  			return true;
  		}
  		if ($include_groups){
  			$user_ids = $user->getId();  			
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_ids);
			if($group_ids!=''){
	  			$gr = Groups::findOne(array('conditions' => array('id in ('.$group_ids.') AND can_manage_security = true ')));
	  			return $gr instanceof Group ;
			}
  		}
  		return false;
  	}
  	
	/**
  	 * Returns whether a user can manage contacts.
  	 * If groups are checked, one true permission makes the function return true.
  	 *
  	 * @param User $user
  	 * @param boolean $include_groups states whether groups should be checked for permissions
  	 * @return boolean
  	 */
  	function can_manage_contacts(User $user, $include_groups = true){
  		if ($user->getCanManageContacts()){
  			return true;
  		}
  		if ($include_groups){
  			$user_ids = $user->getId();  			
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_ids);
			if($group_ids!=''){
	  			$gr = Groups::findOne(array('conditions' => array('id in ('.$group_ids.') AND can_manage_contacts = true ')));
	  			return $gr instanceof Group ;
			}
  		}
  		return false;
  	}
  	
  	/**
  	 * Returns whether a user can manage configuration.
  	 * If groups are checked, one true permission makes the function return true.
  	 *
  	 * @param User $user
  	 * @param boolean $include_groups states whether groups should be checked for permissions
  	 * @return boolean
  	 */
  	function can_manage_configuration(User $user, $include_groups = true){
  		if ($user->getCanManageConfiguration()){
  			return true;
  		}
  		if ($include_groups){
  			$user_ids = $user->getId();  			
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_ids);
			if($group_ids!=''){
	  			$gr = Groups::findOne(array('conditions' => array('id in ('.$group_ids.') AND can_manage_configuration = true ')));
	  			return $gr instanceof Group ;
			}
  		}
  		return false;
  	}
  	
  	/**
  	 * Returns whether a user can manage workspaces.
  	 * If groups are checked, one true permission makes the function return true.
  	 *
  	 * @param User $user
  	 * @param boolean $include_groups states whether groups should be checked for permissions
  	 * @return boolean
  	 */
  	function can_manage_workspaces(User $user, $include_groups = true){
  		if ($user->getCanManageWorkspaces()){
  			return true;
  		}
  		if ($include_groups){
  			$user_ids = $user->getId();  			
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_ids);
			if($group_ids!=''){
	  			$gr = Groups::findOne(array('conditions' => array('id in ('.$group_ids.') AND can_manage_workspaces = true ')));
	  			return $gr instanceof Group ;
			}
  		}
  		return false;
  	}
  	
  	/**
  	 * Returns whether a user can edit company data.
  	 * If groups are checked, one true permission makes the function return true.
  	 *
  	 * @param User $user
  	 * @param boolean $include_groups states whether groups should be checked for permissions
  	 * @return boolean
  	 */
  	function can_edit_company_data(User $user, $include_groups = true){
  		if ($user->getCanEditCompanyData()){
  			return true;
  		}
  		if ($include_groups){
  			$user_ids = $user->getId();  			
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_ids);
			if($group_ids!=''){
	  			$gr = Groups::findOne(array('conditions' => array('id in ('.$group_ids.') AND can_edit_company_data = true ')));
	  			return $gr instanceof Group ;
			}
  		}
  		return false;
  	}
  	
	/**
	 * Returns the field name that has to be checked for the given access level
	 *
	 * @param ObjectUserPermission $perm
	 * @param unknown_type $access_level
	 */
	function access_level_field_name($access_level){
		switch ($access_level){
			case ACCESS_LEVEL_READ: return "can_read"; break;
			case ACCESS_LEVEL_WRITE: return "can_write"; break;			
		}
		throw new Exception('Invalid ACCESS LEVEL in permission helper',-1);
	}  	
	
	/**
	 * Returns the field name that has to be checked for the given object type
	 *
	 * @param ApplicationDataObject $object
	 * @param ProjectPermission $proj_perm
	 * @return unknown
	 */
	function manager_class_field_name($manager_class,$access_level){
		if ($manager_class != ''){
			switch ($manager_class){
				case 'ProjectEvents' : 
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_events';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_events';
					else return false;
					break;
				case 'ProjectFiles' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_files';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_files';
					else return false;
					break;
				case 'ProjectMessages' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_messages';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_messages';
					else return false;
					break;
				case 'ProjectMilestones' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_milestones';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_milestones';
					else return false;
					break;
				case 'ProjectTasks' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_tasks';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_tasks';
					else return false;
					break;
				case 'ProjectWebpages' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_weblinks';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_weblinks';
					else return false;
					break;
				case 'MailContents' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_mails';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_mails';
					else return false;
					break;
				case 'Contacts' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return 'can_write_contacts';
					else if ($access_level == ACCESS_LEVEL_READ)
						return 'can_read_contacts';
					else return false;
					break;
			}
		}
		throw new Exception('Invalid MANAGER in permission helper',-1);
	}
  	/**
  	 * Enter description here...
  	 * assumes manager has one field as PK
  	 *
  	 * @param DataManager $manager
  	 * @param $access_level ACCESS_LEVEL_XX objects that defines which permission is being checked
  	 * @param string $project_id string that will be compared to the project id while searching project_user table
  	 * @param int $user_id user whose permissions are being checked
  	 * @return unknown
  	 */
	function permissions_sql_for_listings (DataManager $manager, $access_level, $user_id, $project_id='project_id', $table_alias = null){
		if(! ($manager instanceof DataManager )){
			throw new Exception("Invalid manager '$manager' in permissions helper",-1);
			return '';
		}
		$oup_tablename = ObjectUserPermissions::instance()->getTableName(true);
		$users_table_name =  Users::instance()->getTableName(true);
		$pu_table_name = ProjectUsers::instance()->getTableName(true);
		if ( isset($table_alias) && $table_alias && $table_alias!='')
			$object_table_name = $table_alias;
		else
			$object_table_name = $manager->getTableName();
		if(!is_numeric($project_id))
			$project_id = "$object_table_name.$project_id";
		$object_id_field = $manager->getPkColumns();
		$object_id = $object_table_name . '.' . $object_id_field;
		$object_manager = get_class($manager);
		$access_level_text = access_level_field_name($access_level);
		$can_manage_object = manager_class_field_name($object_manager, $access_level);
		$item_class = $manager->getItemClass();
		$is_project_data_object = (new $item_class) instanceof ProjectDataObject  ;
		// user is creator
		$str = " ( created_by_id = $user_id) ";
		// element belongs to personal project
		if($is_project_data_object) // TODO: type of element belongs to a project
			$str .= "\n OR ( $project_id = (SELECT personal_project_id FROM $users_table_name xx_u WHERE xx_u.id = $user_id)) ";
		// user or group has specific permissions over object
		$group_ids = GroupUsers::getGroupsCSVsByUser($user_id);
		$all_ids = '(' . $user_id . (($group_ids!='')?','.$group_ids:'' ) . ')';
		$str .= "\n OR ( exists ( SELECT * FROM $oup_tablename xx_oup 
				WHERE xx_oup.rel_object_id = $object_id 
					and xx_oup.rel_object_manager = '$object_manager' 
					and xx_oup.user_id in $all_ids 
					and xx_oup.$access_level_text = true) )" ; 
		if($is_project_data_object){ // TODO: type of element belongs to a project
			$str .= "\n OR ( exists ( SELECT * FROM $pu_table_name xx_pu 
				WHERE xx_pu.user_id in $all_ids 
					AND xx_pu.project_id = $project_id 
					AND xx_pu.$can_manage_object = true ) ) ";
		}
		return ' (' . $str . ') ';
	}	
	
	
	/**
	 * Return true is $user can add an $object. False otherwise.
	 *
	 * @param User $user
	 * @param Project $project
	 * @param string $object_type
	 * @return boolean
	 */
	function can_add(User $user, Project $project, $object_manager){
		try{
			$user_id = $user->getId();
			$proj_perm = ProjectUsers::findOne(array('conditions' => array('user_id = ? AND project_id = ? ',  $user_id , $project->getId())));
			if ($proj_perm && can_manage_type($object_manager,$proj_perm, ACCESS_LEVEL_WRITE)){
				return true; // if user has permissions over type of object in the project
			}
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_id);
			if($group_ids && $group_ids!= ''){ //user belongs to at least one group
				$proj_perms = ProjectUsers::findAll(array('conditions' => array('project_id = '.$project->getId().' AND user_id in ('. $group_ids .')')));
				if($proj_perms){
					foreach ($proj_perms as $perm){
						if( can_manage_type($object_manager,$perm, ACCESS_LEVEL_WRITE)) return true; // if any group has permissions over type of object in the project
					}	
				}
			}
		}
		catch(Exception $e) {
				tpl_assign('error', $e);
				return false;
		}
		return false;
	}
	/**
	 * Return true is $user can read an $object. False otherwise.
	 *
	 * @param User $user
	 * @param ApplicationDataObject $object
	 * @return unknown
	 */
	function can_read(User $user, ApplicationDataObject $object){
		return can_access($user, $object, ACCESS_LEVEL_READ);
	}
	
	/**
	 * Return true is $user can write an $object. False otherwise.
	 *
	 * @param User $user
	 * @param ApplicationDataObject $object
	 * @return unknown
	 */
	function can_write(User $user, ApplicationDataObject $object){
		return can_access($user, $object, ACCESS_LEVEL_WRITE);
	}
	
	/**
	 * Return true is $user can delete an $object. False otherwise.
	 *
	 * @param User $user
	 * @param ApplicationDataObject $object
	 * @return unknown
	 */
	function can_delete(User $user, ApplicationDataObject $object){
		return can_access($user, $object, ACCESS_LEVEL_WRITE);
	}
	
	/**
	 * Return true is $user has $access_level (R/W) over $object
	 *
	 * @param User $user
	 * @param ApplicationDataObject $object
	 * @param int $access_level // 1 = read ; 2 = write
	 * @return unknown
	 */
	function can_access(User $user, ApplicationDataObject $object, $access_level){
		try{
			$user_id = $user->getId();
			if($object->getCreatedById() == $user_id)
				return true; // the user is the creator of the object
			if($object instanceof ProjectDataObject && $object->getProject() instanceof Project && $object->getProject()->getId() == $user->getPersonalProjectId() )
				return true; // The object belongs to the user's personal project
			$perms = ObjectUserPermissions::getAllPermissionsByObject($object, $user->getId());		
			if ($perms && is_array($perms)) //if the permissions for the user in the object are specially set
				return has_access_level($perms[0],$access_level); 
			$group_ids = GroupUsers::getGroupsCSVsByUser($user_id);
			if($group_ids && $group_ids!= ''){ //user belongs to at least one group
				$perms = ObjectUserPermissions::getAllPermissionsByObject($object, $group_ids);			
				if($perms){
					foreach ($perms as $perm){
						if ( has_access_level($perm,$access_level))
							return true; //there is one group permission that allows the user to access
					}				
				}
			}
			if($object instanceof ProjectDataObject && $object->getProject()){
				//if the object has a project assigned to it
				$proj_perm = ProjectUsers::findOne(array('conditions' => array('user_id = ? AND project_id = ? ',  $user_id , $object->getProject()->getId())));
				if ($proj_perm && can_manage_type(get_class($object->manager()),$proj_perm,$access_level)){
					return true; // if user has permissions over type of object in the project
				}
				if($group_ids && $group_ids!= ''){ //user belongs to at least one group
					$proj_perms = ProjectUsers::findAll(array('conditions' => array('project_id = '.$object->getProject()->getId().' AND user_id in ('. $group_ids .')')));
					if($proj_perms){
						foreach ($proj_perms as $perm){
							if( can_manage_type(get_class($object->manager()),$perm,$access_level)) return true; // if any group has permissions over type of object in the project
						}	
					}
				}
			}
		}
		catch(Exception $e) {
				tpl_assign('error', $e);
				return false;
		}
		return false;
	}
	/**
	 * Check whether an ObjectUserPermission
	 *
	 * @param ObjectUserPermission $perm
	 * @param unknown_type $access_level
	 */
	function has_access_level(ObjectUserPermission $perm, $access_level){
		switch ($access_level){
			case ACCESS_LEVEL_READ: return $perm->hasReadPermission(); break;
			case ACCESS_LEVEL_WRITE: return $perm->hasWritePermission(); break;			
		}
		return false;
	}
	
	
	/**
	 * Determines whether a ProjectUser object allows access to an object
	 *
	 * @param ApplicationDataObject $object
	 * @param ProjectPermission $proj_perm
	 * @return unknown
	 */
	function can_manage_type($object_type, $proj_perm, $access_level){
		if ($proj_perm){
			switch ($object_type){
				case 'ProjectEvents' : 
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteEvents();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadEvents();
					else return false;
					break;
				case 'ProjectFiles' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteFiles();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadFiles();
					else return false;
					break;
				case 'ProjectMessages' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteMessages();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadMessages();
					else return false;
					break;
				case 'ProjectMilestones' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteMilestones();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadMilestones();
					else return false;
					break;
				case 'ProjectTasks' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteTasks();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadTasks();
					else return false;
					break;
				case 'ProjectWebpages' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteWeblinks();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadWeblinks();
					else return false;
					break;
				case 'MailContents' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteMails();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadMails();
					else return false;
					break;
				case 'ProjectContacts' :  
					if ($access_level == ACCESS_LEVEL_WRITE)
						return $proj_perm->getCanWriteContacts();
					else if ($access_level == ACCESS_LEVEL_READ)
						return $proj_perm->getCanReadContacts();
					else return false;
					break;
			}
		}
		return false;
	}
	
?>