<?php

// Functions that check permissions
// Recomendation: Before changing this, talk with marcos.saiz@fengoffice.com

  	define('ACCESS_LEVEL_READ', 1);
  	define('ACCESS_LEVEL_WRITE', 2);
  	define('ACCESS_LEVEL_DELETE', 3);
  	  	
  	/**
  	 * Returns whether a user can manage security.
  	 *
  	 * @param Contact $user
  	 * @return boolean
  	 */
  	function can_manage_security(Contact $user){
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_security');	
  	}
  	
	/**
  	 * Returns whether a user can manage contacts.
  	 *
  	 * @param Contact $user
  	 * @return boolean
  	 */
  	function can_manage_contacts(Contact $user, $include_groups = true){
  		return true; //FIXME remove this function
  	}
  	
  	
	/**
  	 * Returns whether a user can manage time.
  	 *
  	 * @param Contact $user
  	 * @return boolean
  	 */
  	function can_manage_time(Contact $user){
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_time');
  	}
  	
  	/**
  	 * Returns whether a user can add mail accounts.
  	 *
  	 * @param Contact $user
  	 * @return boolean
  	 */
  	function can_add_mail_accounts(Contact $user){
		return SystemPermissions::userHasSystemPermission($user, 'can_add_mail_accounts');
  	}
  	
  	function can_manage_templates(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_templates');
  	}
  	
  	function can_manage_reports(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_reports');
  	}
  	
  	function can_manage_workspaces(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_workspaces');
  	}
  	
  	function can_manage_dimensions(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_dimensions');
  	}
  	function can_manage_dimension_members(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_dimension_members');
  	}
  	function can_manage_tasks(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_tasks');
  	}
  	function can_task_assignee(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_task_assignee');
  	}
  	function can_manage_billing(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_billing');
  	}
  	function can_view_billing(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_view_billing');
  	}
  	function can_view_time(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_view_time');
  	}
  	function can_record_time(Contact $user) {
		return SystemPermissions::userHasSystemPermission($user, 'can_record_time');
  	}
  	
  	
  	
  	/**
  	 * Returns whether a user can manage configuration.
  	 *
  	 * @param Contact $user
  	 * @return boolean
  	 */
  	function can_manage_configuration(Contact $user){
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_configuration');
  	}
  	

  	function can_manage_members(Contact $user){
		return SystemPermissions::userHasSystemPermission($user, 'can_manage_members');
  	}
  	
  	function can_manage_tabs(Contact $user){
		return $user->isAdministrator();
  	}
  	
  	
  	/**
  	 * Returns whether a user can edit company data.
  	 *
  	 * @param Contact $user
  	 * @return boolean
  	 */
  	function can_edit_company_data(Contact $user){
		return SystemPermissions::userHasSystemPermission($user, 'can_edit_company_data');
  	}
  	
	
	/**
	 * Return true if $user can add an object of type $object_type_id in $member. False otherwise.
	 *
	 * @param Contact $user
	 * @param Member $member
	 * @param array $context_members
	 * @param $object_type_id
	 * @return boolean
	 */
	function can_add_to_member(Contact $user, Member $member, $context_members, $object_type_id, $check_dimension = true){
			
		if ($user->isGuest()) return false;
		if (!$member->canContainObject($object_type_id)) return false;
		try {
			
			$contact_pg_ids = ContactPermissionGroups::getPermissionGroupIdsByContactCSV($user->getId(),false);
			
			// if object_type is associated to a panel, check if the panel is enabled in the system and for the user
			$tab_panel = TabPanels::findOne(array("conditions" => "`object_type_id` = $object_type_id"));
			if ($tab_panel instanceof TabPanel) {
				if (!$tab_panel->getEnabled()) 
					return false;
				if ($tab_panel->getObjectTypeId() > 0) {
					if ($contact_pg_ids == '')
						return false;
					$tab_panel_permissions = TabPanelPermissions::findAll(array("conditions" => "`tab_panel_id` = '".$tab_panel->getId()."' AND `permission_group_id` IN ($contact_pg_ids)"));
					if (is_null($tab_panel_permissions) || !is_array($tab_panel_permissions) || count($tab_panel_permissions) == 0)
						return false;
				}
			}
			
			if ($check_dimension) $dimension = $member->getDimension();
			
			//dimension does not define permissions - user can freely add in all members
			if ($check_dimension && !$dimension->getDefinesPermissions()) return true;
			
			$contact_pg_ids = ContactPermissionGroups::getPermissionGroupIdsByContactCSV($user->getId(),false);
			
			//dimension defines permissions and user has maximum level of permissions so can freely in all members
			if ($check_dimension && $dimension->hasAllowAllForContact($contact_pg_ids)) return true;
			
			//check
			if (ContactMemberPermissions::contactCanReadObjectTypeinMember($contact_pg_ids, $member->getId(), $object_type_id, true))
					return true;
						
			//check for context permissions that allow user to add in this member
			if ($context_members){
				$allowed_members = ContactMemberPermissions::getActiveContextPermissions($user,$object_type_id, $context_members, $context_members, true);
				if (in_array($member, $allowed_members)) return true;
			}	
				
		}
		catch(Exception $e) {
				tpl_assign('error', $e);
				return false;
		}
		return false;
	}
	
	
	/**
	 * Return true if $user can add an object of type $object_type_id in $member. False otherwise.
	 *
	 * @param Contact $user
	 * @param array $context
	 * @param $object_type_id
	 * @return boolean
	 */
	function can_add(Contact $user, $context, $object_type_id){
		if ($user->isAdministrator()) return true;
		if ($user->isGuest()) return false;
		$can_add = false;
				
		$required_dimensions_ids = DimensionObjectTypeContents::getRequiredDimensions($object_type_id);
		$dimensions_in_context = array();
		
		if (!count($required_dimensions_ids)>0) $no_required_dimensions = true;
		else $no_required_dimensions = false;
		foreach ($required_dimensions_ids as $id){
			$dimensions_in_context[$id]= false;
		}
		
		$contact_pg_ids = ContactPermissionGroups::getPermissionGroupIdsByContactCSV($user->getId(),false);
						
		foreach($context as $selection){
			$can_add = false;
			if ($selection instanceof Dimension){
				$dimension_id = $selection->getId();
				
				$allowed = $no_required_dimensions ? $selection->canContainObject($object_type_id) : $selection->isRequired($object_type_id);
				if ($allowed){
					if (!$selection->getDefinesPermissions()){
						if ($no_required_dimensions) return true;
						$can_add = true;
						$dimensions_in_context[$dimension_id]=true;
					}
					else {
						if ($selection->hasAllowAllForContact($contact_pg_ids)){
							if ($no_required_dimensions) return true;
							$can_add = true;
							$dimensions_in_context[$dimension_id]=true;
						}
						else if ($selection->hasCheckForContact($contact_pg_ids)){
							$all_members = $selection->getAllMembers();
							foreach($all_members as $m){
								if (can_add_to_member($user, $m, $context, $object_type_id, false)){
									if ($no_required_dimensions) return true;
									$can_add = true;
									$dimensions_in_context[$dimension_id]=true;
									break;
								}
							}
						}
					}
				}
			}
			else if ($selection instanceof Member){
				if (can_add_to_member($user, $selection, $context, $object_type_id)){
					if ($no_required_dimensions) return true;
					$dimension_id = $selection->getDimensionId();
					$can_add = true;
					$dimensions_in_context[$dimension_id]=true;
				}
			}
			if ($can_add && !$no_required_dimensions){
				foreach ($dimensions_in_context as $key=>$value){
					$dim = Dimensions::findById($key);
					if(!$value && $dim->getDefinesPermissions() && $dim->deniesAllForContact($contact_pg_ids)){
						$can_add = false;
					}
				}
			}
			if ($can_add) return true;
		}
		return $can_add;
	}
	
	
	/**
	 * Return true is $user can read the $object. False otherwise.
	 *
	 * @param Contact $user
	 * @param Member $member
	 * @param array $context_members
	 * @param $object_type_id
	 * @return boolean
	 */
	function can_read(Contact $user, $members, $object_type_id){
		return can_access($user, $members, $object_type_id, ACCESS_LEVEL_READ);
	}
	
	
	/**
	 * Return true if $user can write the object of $object_type_id. False otherwise.
	 *
	 * @param Contact $user
	 * @param Member $member
	 * @param array $context_members
	 * @param $object_type_id
	 * @return boolean
	 */
	function can_write(Contact $user, $members, $object_type_id){
		if ($user->isGuest()) return false;
		return can_access($user, $members, $object_type_id, ACCESS_LEVEL_WRITE);
	}
	
	
		
	/**
	 * Return true is $user can delete an $object. False otherwise.
	 *
	 * @param Contact $user
	 * @param array $members
	 * @param $object_type_id
	 * @return boolean
	 */
	function can_delete(Contact $user, $members, $object_type_id){
		if ($user->isGuest()) return false;
		return can_access($user, $members, $object_type_id, ACCESS_LEVEL_DELETE);
	}
	
	
	/**
	 * Return true is $user can access an $object. False otherwise.
	 *
	 * @param Contact $user
	 * @param array $members
	 * @param $object_type_id
	 * @return boolean
	 */
	function can_access(Contact $user, $members, $object_type_id, $access_level){
		if(logged_user()->isAdministrator())return true;
		$write = false;
		if ($access_level == ACCESS_LEVEL_WRITE) $write = true;
		$delete = false;
		if ($access_level == ACCESS_LEVEL_DELETE) $delete = true;
		
		
		if (($user->isGuest() && $access_level!= ACCESS_LEVEL_READ) || !count($members)>0) return false;
		
		try {
			$contact_pg_ids = ContactPermissionGroups::getPermissionGroupIdsByContactCSV($user->getId(),false);
				
			// if object_type is associated to a panel, check if the panel is enabled in the system and for the user
			/* //TODO VEr que no joda
			$tab_panel = TabPanels::findOne(array("conditions" => "`object_type_id` = $object_type_id"));
			if ($tab_panel instanceof TabPanel) {
				if (!$tab_panel->getEnabled()) 
					return false;
				if ($tab_panel->getObjectTypeId() > 0) {
					if ($contact_pg_ids == '')
						return false;
					$tab_panel_permissions = TabPanelPermissions::findAll(array("conditions" => "`tab_panel_id` = '".$tab_panel->getId()."' AND `permission_group_id` IN ($contact_pg_ids)"));
					if (is_null($tab_panel_permissions) || !is_array($tab_panel_permissions) || count($tab_panel_permissions) == 0)
						return false;
				}
			}
			*/
			
			
			$dimension_permissions = array();
			foreach($members as $m){
				$dimension = $m->getDimension();
				$dimension_id = $dimension->getId();
				if (!isset($dimension_permissions[$dimension_id]))
					$dimension_permissions[$dimension_id]=false;
										
				if (!$dimension_permissions[$dimension_id]){
					if ($m->canContainObject($object_type_id)){
						
						//dimension does not define permissions
						if (!$dimension->getDefinesPermissions()) $dimension_permissions[$dimension_id]=true;
						
						//dimension defines permissions and user has maximum level of permissions
						if ($dimension->hasAllowAllForContact($contact_pg_ids)) $dimension_permissions[$dimension_id]=true;
						
						//check
						if (ContactMemberPermissions::contactCanReadObjectTypeinMember($contact_pg_ids, $m->getId(), $object_type_id, $write, $delete))
								$dimension_permissions[$dimension_id]=true;
					}
				}
			}
			$allowed = true;
			foreach($dimension_permissions as $perm){
				if (!$perm) $allowed = false;
			}			
			if ($allowed) return true;
			//Check Context Permissions
			$allowed_members = ContactMemberPermissions::getActiveContextPermissions($user,$object_type_id, $members, $members, $write, $delete);
			
			$count=0;
			foreach($members as $m){
				$count++;				
				if (!in_array($m, $allowed_members)) return false;
				else if ($count==count($members)) return true;
			}
		}
		catch(Exception $e) {
				tpl_assign('error', $e);
				return false;
		}
		return false;
	}


	function permission_form_parameters($pg_id) {
		$member_permissions = array();		
		$dimensions = array();
		$dims = Dimensions::findAll();
		$members = array();
		$member_types = array();
		$allowed_object_types = array();
		$allowed_object_types_by_member_type[] = array();
		
		foreach($dims as $dim) {
			if ($dim->getDefinesPermissions()) {
				$dimensions[] = $dim;
				$root_members = Members::findAll(array('conditions' => array('`dimension_id`=? AND `parent_member_id`=0', $dim->getId()), 'order' => '`name` ASC'));
				foreach ($root_members as $mem) {
					$members[$dim->getId()][] = $mem;
					$members[$dim->getId()] = array_merge($members[$dim->getId()], $mem->getAllChildrenSorted());
				}
				
				$allowed_object_types[$dim->getId()] = array();
				
				$dim_obj_types = $dim->getAllowedObjectTypeContents();
				foreach ($dim_obj_types as $dim_obj_type) {
					
					// To draw a row for each object type of the dimension
					if (!in_array($dim_obj_type->getContentObjectTypeId(), $allowed_object_types[$dim->getId()])) {
						$allowed_object_types[$dim->getId()][] = $dim_obj_type->getContentObjectTypeId();
					}
					
					// To enable or disable object types depending on the selected member
					if (!is_array(array_var($allowed_object_types_by_member_type, $dim_obj_type->getDimensionObjectTypeId()))) {
						$allowed_object_types_by_member_type[$dim_obj_type->getDimensionObjectTypeId()] = array();
					}
					$allowed_object_types_by_member_type[$dim_obj_type->getDimensionObjectTypeId()][] = $dim_obj_type->getContentObjectTypeId();
					
				}
				
				if ($dim->hasAllowAllForContact($pg_id)) {
					foreach ($members[$dim->getId()] as $mem) {
						$member_permissions[$mem->getId()] = array();
						foreach ($dim_obj_types as $dim_obj_type) {
							if ($dim_obj_type->getDimensionObjectTypeId() == $mem->getObjectTypeId()) {
								$member_permissions[$mem->getId()][] = array(
									'o' => $dim_obj_type->getContentObjectTypeId(),
									'w' => 1,
									'd' => 1,
									'r' => 1
								);
							}
						}
					}
				} else if (!$dim->deniesAllForContact($pg_id)) {
					foreach ($members[$dim->getId()] as $mem) {
						$member_permissions[$mem->getId()] = array();
						$pgs = ContactMemberPermissions::findAll(array("conditions" => array("`permission_group_id` = ? AND `member_id` = ?", $pg_id, $mem->getId())));
						if (is_array($pgs)) {
							foreach ($pgs as $pg) {
								$member_permissions[$mem->getId()][] = array(
									'o' => $pg->getObjectTypeId(),
									'w' => $pg->getCanWrite(),
									'd' => $pg->getCanDelete(),
									'r' => 1
								);
							}
						}
					}
				}
				
				foreach($members[$dim->getId()] as $member) {
					$member_types[$member->getId()] = $member->getObjectTypeId();
				}
			}
		}
		
		$all_object_types = ObjectTypes::findAll(array("conditions" => "`type` IN ('content_object', 'located') AND `name` <> 'file revision'"));
		
		return array(
			'member_types' => $member_types,
			'allowed_object_types_by_member_type' => $allowed_object_types_by_member_type,
			'allowed_object_types' => $allowed_object_types,
			'all_object_types' => $all_object_types,
			'member_permissions' => $member_permissions,
			'dimensions' => $dimensions,
		);
	}
	
	
	function save_permissions($pg_id) {
		
		$sys_permissions_data = array_var($_POST, 'sys_perm');
		
		$changed_members = array();
				
		//module permissions
		$mod_permissions_data = array_var($_POST, 'mod_perm');
		TabPanelPermissions::clearByPermissionGroup($pg_id);
		if (!is_null($mod_permissions_data) && is_array($mod_permissions_data)) {
			foreach($mod_permissions_data as $tab_id => $val) {
				$tpp = new TabPanelPermission();
				$tpp->setPermissionGroupId($pg_id);
				$tpp->setTabPanelId($tab_id);
				$tpp->save();
			}
		}
		
		//system permissions
		$system_permissions = SystemPermissions::findById($pg_id);
		if (!$system_permissions instanceof SystemPermission) {
			$system_permissions = new SystemPermission();
			$system_permissions->setPermissionGroupId($pg_id);
		}
		$system_permissions->setAllPermissions(false);
		$other_permissions = array();
		Hook::fire('add_user_permissions', $pg_id, $other_permissions);
		foreach ($other_permissions as $k => $v) {
			$system_permissions->setColumnValue($k, false);
		}
		$system_permissions->setFromAttributes($sys_permissions_data);
		$system_permissions->save();
		
		//member permissions
		$permissionsString = array_var($_POST, 'permissions');
		if ($permissionsString && $permissionsString != ''){
			$permissions = json_decode($permissionsString);
		}
		
		if (!is_null($permissions) && is_array($permissions)) {
			$allowed_members_ids= array();
			foreach ($permissions as $perm) {
				$allowed_members_ids[$perm->m]=array();
				$allowed_members_ids[$perm->m]['pg']=$pg_id;
				$cmp = ContactMemberPermissions::findById(array('permission_group_id' => $pg_id, 'member_id' => $perm->m, 'object_type_id' => $perm->o));
				if (!$cmp instanceof ContactMemberPermission) {
					$cmp = new ContactMemberPermission();
					$cmp->setPermissionGroupId($pg_id);
					$cmp->setMemberId($perm->m);
					$cmp->setObjectTypeId($perm->o);
				}
				$cmp->setCanWrite($perm->w);
				$cmp->setCanDelete($perm->d);
				if ($perm->r) {
					if(isset($allowed_members_ids[$perm->m]['w'])){
						if($allowed_members_ids[$perm->m]['w']!=1){
							$allowed_members_ids[$perm->m]['w']=$perm->w;
						}
					}else{
						$allowed_members_ids[$perm->m]['w']=$perm->w;
					}
					if(isset($allowed_members_ids[$perm->m]['d'])){
						if($allowed_members_ids[$perm->m]['d']!=1){
							$allowed_members_ids[$perm->m]['d']=$perm->d;
						}
					}else{
						$allowed_members_ids[$perm->m]['d']=$perm->d;
					}
					$cmp->save();
				} else {
					$cmp->delete();
				}
				
				$changed_members[] = $perm->m;
			}
			$sharingTablecontroller = new SharingTableController() ;
			$sharingTablecontroller->afterPermissionChanged($pg_id, $permissions);
			foreach ($allowed_members_ids as $key=>$mids){
				$mbm=Members::findById($key);
				$root_cmp = ContactMemberPermissions::findById(array('permission_group_id' => $mids['pg'], 'member_id' => $key, 'object_type_id' => $mbm->getObjectTypeId()));
				if (!$root_cmp instanceof ContactMemberPermission) {
					$root_cmp = new ContactMemberPermission();
					$root_cmp->setPermissionGroupId($mids['pg']);
					$root_cmp->setMemberId($key);
					$root_cmp->setObjectTypeId($mbm->getObjectTypeId());
				}
				$root_cmp->setCanWrite($mids['w']);
				$root_cmp->setCanDelete($mids['d']);
				$root_cmp->save();
				
			}
		}
		
		// check the status of the changed dimensions to set 'allow_all', 'deny_all' or 'check'
		$dimensions = Dimensions::findAll(array("conditions" => array("`id` IN (SELECT DISTINCT `dimension_id` FROM ".Members::instance()->getTableName(true)." WHERE `id` IN (?))", $changed_members)));
		foreach ($dimensions as $dimension) {
			$mem_ids = $dimension->getAllMembers(true);
			if (count($mem_ids) == 0) $mem_ids[] = 0;
			
			$count = ContactMemberPermissions::count(array('conditions' => "`permission_group_id`=$pg_id AND `member_id` IN (".implode(",",$mem_ids).") AND `can_delete` = 0" ));
			if ($count > 0) {
				$dimension->setContactDimensionPermission($pg_id, 'check');
			} else {
				$count = ContactMemberPermissions::count(array('conditions' => "`permission_group_id`=$pg_id AND `member_id` IN (".implode(",",$mem_ids).")"));
				if ($count == 0) {
					$dimension->setContactDimensionPermission($pg_id, 'deny all');
				} else {
					$allow_all = true;
					$dim_obj_types = $dimension->getAllowedObjectTypeContents();
					$members = Members::findAll("`id` IN (".implode(",",$mem_ids).")");
					foreach ($dim_obj_types as $dim_obj_type) {
						
						$mem_ids_for_ot = array();
						foreach($members as $member) {
							if ($dim_obj_type->getDimensionObjectTypeId() == $member->getObjectTypeId()) $mem_ids_for_ot[] = $member->getId();
						}
						if (count($mem_ids_for_ot) == 0) $mem_ids_for_ot[] = 0;
						
						$count = ContactMemberPermissions::count(array('conditions' => "`permission_group_id`=$pg_id AND 
						`object_type_id` = ".$dim_obj_type->getContentObjectTypeId()." AND `can_delete` = 1 AND `member_id` IN (".implode(",",$mem_ids_for_ot).")"));
						
						if ($count != count($mem_ids_for_ot)) {
							$allow_all = false;
							break;
						}
					}
					if ($allow_all) {
						$dimension->setContactDimensionPermission($pg_id, 'allow all');
					} else {
						$dimension->setContactDimensionPermission($pg_id, 'check');
					}
				}
			}
		}
	}
	
	
	
	function permission_member_form_parameters($member) {
		$dim = $member->getDimension();
		if (logged_user()->isMemberOfOwnerCompany()) {
			$companies = Contacts::findAll(array("conditions" => "is_company = 1", 'order' => 'name'));
		} else {
			$companies = array(owner_company(), logged_user()->getCompany());
		}
		
		$allowed_object_types = array();
		$dim_obj_types = $dim->getAllowedObjectTypeContents();
		foreach ($dim_obj_types as $dim_obj_type) {
			// To draw a row for each object type of the dimension
			if (!array_key_exists($dim_obj_type->getContentObjectTypeId(), $allowed_object_types) && $dim_obj_type->getDimensionObjectTypeId() == $member->getObjectTypeId()) {
				$allowed_object_types[$dim_obj_type->getContentObjectTypeId()] = ObjectTypes::findById($dim_obj_type->getContentObjectTypeId());
				$allowed_object_types_json[] = $dim_obj_type->getContentObjectTypeId();
			}
		}
		
		$permission_groups = array();
		foreach ($companies as $company) {
			$users = $company->getUsersByCompany();
			foreach ($users as $u) $permission_groups[] = $u->getPermissionGroupId();
		}
		$non_personal_groups = PermissionGroups::getNonPersonalPermissionGroups();
		foreach ($non_personal_groups as $group) {
			$permission_groups[] = $group->getId();
		}
		
		foreach ($permission_groups as $pg_id) {
			if ($dim->hasAllowAllForContact($pg_id)) {
				$member_permissions[$pg_id] = array();
				foreach ($dim_obj_types as $dim_obj_type) {
					if ($dim_obj_type->getDimensionObjectTypeId() == $member->getObjectTypeId()) {
						$member_permissions[$pg_id][] = array(
							'o' => $dim_obj_type->getContentObjectTypeId(),
							'w' => 1,
							'd' => 1,
							'r' => 1
						);
					}
				}
			} else if (!$dim->deniesAllForContact($pg_id)) {
				$member_permissions[$pg_id] = array();
				$mpgs = ContactMemberPermissions::findAll(array("conditions" => array("`permission_group_id` = ? AND `member_id` = ?", $pg_id, $member->getId())));
				if (is_array($mpgs)) {
					foreach ($mpgs as $mpg) {
						$member_permissions[$mpg->getPermissionGroupId()][] = array(
							'o' => $mpg->getObjectTypeId(),
							'w' => $mpg->getCanWrite() ? 1 : 0,
							'd' => $mpg->getCanDelete() ? 1 : 0,
							'r' => 1
						);
					}
				}
			}
		}
		
		return array(
			'member' => $member,
			'allowed_object_types' => $allowed_object_types,
			'allowed_object_types_json' => $allowed_object_types_json,
			'permission_groups' => $permission_groups,
			'member_permissions' => $member_permissions,
		);
	}
	
	function save_member_permissions($member) {
		$permissionsString = array_var($_POST, 'permissions');
		if ($permissionsString && $permissionsString != ''){
			$permissions = json_decode($permissionsString);
		}
		
		$changed_pgs = array();
		
		if (!is_null($permissions) && is_array($permissions)) {
			$allowed_pg_ids= array();
			foreach ($permissions as $perm) {
				$cmp = ContactMemberPermissions::findById(array('permission_group_id' => $perm->pg, 'member_id' => $member->getId(), 'object_type_id' => $perm->o));
				if (!$cmp instanceof ContactMemberPermission) {
					$cmp = new ContactMemberPermission();
					$cmp->setPermissionGroupId($perm->pg);
					$cmp->setMemberId($member->getId());
					$cmp->setObjectTypeId($perm->o);
				}
				$cmp->setCanWrite($perm->w);
				$cmp->setCanDelete($perm->d);
				if ($perm->r) {
					$allowed_pg_ids[$perm->pg]=array();
					if(isset($allowed_pg_ids[$perm->pg]['w'])){
						if(!$allowed_pg_ids[$perm->pg]['w']){
							$allowed_pg_ids[$perm->pg]['w']=$perm->w;
						}
					}else{
						$allowed_pg_ids[$perm->pg]['w']=$perm->w;
					}
					if(isset($allowed_pg_ids[$perm->pg]['d'])){
						if(!$allowed_pg_ids[$perm->pg]['d']){
							$allowed_pg_ids[$perm->pg]['d']=$perm->d;
						}
					}else{
						$allowed_pg_ids[$perm->pg]['d']=$perm->d;
					}
					$cmp->save();
				} else {
					$cmp->delete();
				}
				
				$changed_pgs[] = $perm->pg;
			}
			
			foreach ($allowed_pg_ids as $key=>$mids){
				$root_cmp = ContactMemberPermissions::findById(array('permission_group_id' => $key, 'member_id' => $member->getId(), 'object_type_id' => $member->getObjectTypeId()));
				if (!$root_cmp instanceof ContactMemberPermission) {
					$root_cmp = new ContactMemberPermission();
					$root_cmp->setPermissionGroupId($key);
					$root_cmp->setMemberId($member->getId());
					$root_cmp->setObjectTypeId($member->getObjectTypeId());
				}
				$root_cmp->setCanWrite($mids['w']==true ? 1 : 0);
				$root_cmp->setCanDelete($mids['d']==true ? 1 : 0);
				$root_cmp->save();
				
			}
			
		
		}
		
		// check the status of the dimension to set 'allow_all', 'deny_all' or 'check'
		$dimension = $member->getDimension();
		$mem_ids = $dimension->getAllMembers(true);
		if (count($mem_ids) == 0) $mem_ids[] = 0;
		
		foreach ($changed_pgs as $pg_id) {
			$count = ContactMemberPermissions::count(array('conditions' => "`permission_group_id`=$pg_id AND `member_id` IN (".implode(",",$mem_ids).") AND `can_delete` = 0" ));
			if ($count > 0) {
				$dimension->setContactDimensionPermission($pg_id, 'check');
			} else {
				$count = ContactMemberPermissions::count(array('conditions' => "`permission_group_id`=$pg_id AND `member_id` IN (".implode(",",$mem_ids).")"));
				if ($count == 0) {
					$dimension->setContactDimensionPermission($pg_id, 'deny all');
				} else {
					$allow_all = true;
					$dim_obj_types = $dimension->getAllowedObjectTypeContents();
					$members = Members::findAll("`id` IN (".implode(",",$mem_ids).")");
					foreach ($dim_obj_types as $dim_obj_type) {
						
						$mem_ids_for_ot = array();
						foreach($members as $member) {
							if ($dim_obj_type->getDimensionObjectTypeId() == $member->getObjectTypeId()) $mem_ids_for_ot[] = $member->getId();
						}
						if (count($mem_ids_for_ot) == 0) $mem_ids_for_ot[] = 0;
						
						$count = ContactMemberPermissions::count(array('conditions' => "`permission_group_id`=$pg_id AND 
						`object_type_id` = ".$dim_obj_type->getContentObjectTypeId()." AND `can_delete` = 1 AND `member_id` IN (".implode(",",$mem_ids_for_ot).")"));
						
						if ($count != count($mem_ids_for_ot)) {
							$allow_all = false;
							break;
						}
					}
					if ($allow_all) {
						$dimension->setContactDimensionPermission($pg_id, 'allow all');
					} else {
						$dimension->setContactDimensionPermission($pg_id, 'check');
					}
				}
			}
		}
	}

	function allowed_users_in_context($object_type_id, $context = null, $access_level = ACCESS_LEVEL_READ, $extra_conditions = "") {
		$result = array();
		if(!can_manage_tasks(logged_user())&&can_task_assignee(logged_user())&&ProjectTasks::instance()->getObjectTypeId()==$object_type_id) {
			return array(logged_user());
		}
		$users = Contacts::getAllUsers($extra_conditions);
		$members = array();
		foreach ($context as $selection) {
			if ($selection instanceof Member) $members[] = $selection;
		}
		
		if (count($members) == 0) return $users;
		
		foreach ($users as $user) {
			if (can_access($user, $members, $object_type_id, $access_level)) {
				$result[] = $user;
			}
		}
		
		return $result;
	}
	
