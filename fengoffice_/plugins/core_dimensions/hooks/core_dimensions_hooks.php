<?php
Hook::register('core_dimensions');

function core_dimensions_after_edit_profile($user, &$ignored) {
	$person_member = Members::findOne(array("conditions" => "`object_id` = (".$user->getId().") AND `dimension_id` = (SELECT `id` FROM `".TABLE_PREFIX."dimensions` WHERE `code` = 'feng_persons')"));
	$user_member = Members::findOne(array("conditions" => "`object_id` = (".$user->getId().") AND `dimension_id` = (SELECT `id` FROM `".TABLE_PREFIX."dimensions` WHERE `code` = 'feng_users')"));
	
	$person_member->setName($user->getDisplayName());
	$person_member->save();
	evt_add("reload dimension tree", $person_member->getDimensionId());
	
	$user_member->setName($user->getDisplayName());
	$user_member->save();
	evt_add("reload dimension tree", $user_member->getDimensionId());
}

function core_dimensions_after_add_to_members($object, &$ignored) {
	// Add to persons and users dimensions
	$user_ids = array(logged_user()->getId());
	if ($object instanceof ProjectTask) {
		/* @var $object ProjectTask */
		if ($object->getAssignedById() > 0) $user_ids[] = $object->getAssignedById();
		if ($object->getAssignedToContactId() > 0) $user_ids[] = $object->getAssignedToContactId();
	}
	if ($object instanceof ProjectEvent) {
		/* @var $object ProjectEvent */
		$invitations = EventInvitations::findAll(array("conditions" => "`event_id` = ".$object->getId()));
		foreach ($invitations as $inv) $user_ids[] = $inv->getContactId();
	}
	
	if ($object instanceof Contact && !$object->isUser()) {
		$member = Members::findOne(array("conditions" => "`object_id` = (".$object->getId().") AND `dimension_id` = (SELECT `id` FROM `".TABLE_PREFIX."dimensions` WHERE `code` = 'feng_persons')"));
		if ($member instanceof Member) {
			$object->addToMembers(array($member));
		}
	}
	
	core_dim_add_to_person_user_dimensions ($object, $user_ids);
}


function core_dimensions_after_add_subscribers($params, &$ignored) {
	
	// Add to persons and users dimensions
	core_dim_add_to_person_user_dimensions (array_var($params, 'object'), array_var($params, 'user_ids'));
}


function core_dimensions_after_insert($object, &$ignored) {
	// add member in persons dimension for new contact
	if ($object instanceof Contact && !isset($_POST['user'])) {
		core_dim_add_new_contact_to_person_dimension($object);
	}
}

/**
 * @author Ignacio Vazquez - elpepe.uy at gmail.com
 * @param unknown_type $object
 * @param unknown_type $ignored
 */
function core_dimensions_after_update($object, &$ignored) {
	if ($object instanceof Contact ) {
		$person_dim = Dimensions::findOne(array("conditions" => "`code` = 'feng_persons'"));
		$person_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'person'"));
		$company_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'company'"));
		$members = Members::findByObjectId($object->getId());
		if (count($members) == 1 ){ /* @var $member Member */
			$member = $members[0];
			$member->setName($object->getObjectName());
			
			$parent_member_id = $member->getParentMemberId() ;
			$depth = $member->getDepth();
			if ($object->getCompanyId() > 0) {
				$pmember = Members::findOne(array('conditions' => '`object_id` = '.$object->getCompanyId().' AND `object_type_id` = '.$company_ot->getId(). ' AND `dimension_id` = '.$person_dim->getId()));
				$member->setParentMemberId($pmember->getId());
				$member->setDepth($pmember->getDepth() + 1);
			}else{
				//Is first level 
				$member->setDepth(1);
				$member->setParentMemberId();
			}
			$member->save();
			evt_add("reload dimension tree", $member->getDimensionId());
		}
	}
}

function core_dimensions_after_user_add($object, $ignored) {
	
	// if contact is user then add new member also to users dimension
	if ($object instanceof Contact) {
		/* @var $object Contact */
		
		core_dim_add_new_contact_to_person_dimension($object);
		
		$user_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'user'"));
		$company_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'company'"));
		$user_dim = Dimensions::findOne(array("conditions" => "`code` = 'feng_users'"));

		if ($user_ot instanceof ObjectType && $user_dim instanceof Dimension) {
			$member = new Member();
			$member->setName($object->getObjectName());
			$member->setObjectTypeId($user_ot->getId());
			$member->setDimensionId($user_dim->getId());
			
			$parent_member_id = 0;
			$depth = 1;
			if ($object->getCompanyId() > 0) {
				$pmember = Members::findOne(array('conditions' => '`object_id` = '.$object->getCompanyId().' AND `object_type_id` = '.$company_ot->getId(). ' AND `dimension_id` = '.$user_dim->getId()));
				if (!$pmember instanceof Member) {
					// if company member does not exists in users dimension -> create it
					$company = Contacts::findById($object->getCompanyId());
					$pmember = core_dim_add_company_to_users_dimension($company, $user_dim, $company_ot);
				}
				$parent_member_id = $pmember->getId();
				$depth = $pmember->getDepth() + 1;
			}
			$member->setDepth($depth);
			$member->setParentMemberId($parent_member_id);
			$member->setObjectId($object->getId());
			$member->save();
			
			// permisssions
			$sql = "INSERT INTO `".TABLE_PREFIX."contact_dimension_permissions` (`permission_group_id`, `dimension_id`, `permission_type`)
					 SELECT `c`.`permission_group_id`, ".$user_dim->getId().", 'check'
					 FROM `".TABLE_PREFIX."contacts` `c` 
					 WHERE `c`.`is_company`=0 AND `c`.`user_type`!=0 AND `c`.`disabled`=0
					 ON DUPLICATE KEY UPDATE `dimension_id`=`dimension_id`;";
			DB::execute($sql);
			
			$sql = "INSERT INTO `".TABLE_PREFIX."contact_member_permissions` (`permission_group_id`, `member_id`, `object_type_id`, `can_write`, `can_delete`)
					 SELECT `c`.`permission_group_id`, ".$member->getId().", `ot`.`id`, (`c`.`object_id` = ".$object->getId().") as `can_write`, (`c`.`object_id` = ".$object->getId().") as `can_delete`
					 FROM `".TABLE_PREFIX."contacts` `c` JOIN `".TABLE_PREFIX."object_types` `ot` 
					 WHERE `c`.`is_company`=0 
					 	AND `c`.`user_type`!=0 AND `c`.`disabled`=0
						AND `ot`.`type` IN ('content_object', 'located', 'comment')
					 ON DUPLICATE KEY UPDATE `member_id`=`member_id`;";
			DB::execute($sql);
			
			
			// my stuff
			$ws_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'workspace'"));
			$stuff = new Member();
			$stuff->setName(lang('my stuff'));
			$stuff->setObjectTypeId($ws_ot->getId());
			$stuff->setDimensionId($user_dim->getId());
			$stuff->setDepth($member->getDepth() + 1);
			$stuff->setParentMemberId($member->getId());
			$stuff->save();
			
			$object->setPersonalMemberId($stuff->getId());
			$object->save();
			
			$sql = "INSERT INTO `".TABLE_PREFIX."contact_member_permissions` (`permission_group_id`, `member_id`, `object_type_id`, `can_write`, `can_delete`)
					 SELECT ".$object->getPermissionGroupId().", ".$stuff->getId().", `ot`.`id`, 1, 1
					 FROM `".TABLE_PREFIX."object_types` `ot` 
					 WHERE `ot`.`type` IN ('content_object', 'located', 'comment')
					 ON DUPLICATE KEY UPDATE `member_id`=`member_id`;";
			DB::execute($sql);
			
			evt_add("reload dimension tree", $member->getDimensionId());
		}
	}
}

/**
 * 
 * Fires AFTER User is deleted - Contact.class.php
 * Deletes All members associated with that user  
 * @param Contact $user
 */
function core_dimensions_after_user_deleted(Contact $user, $null) {
	$uid  =  $user->getId() ;
	
	//Delete MyStuff
	if ( $myStuff = Members::findById($user->getPersonalMemberId() ) ) {
		$myStuff->delete();
	}
	
	// Delete All members
	$members =  Members::instance()->findByObjectId($uid) ;
	if ( count($members) ) {
		foreach ($members as $member){
			$member->delete();
			evt_add("reload dimension tree", $member->getDimensionId());
		}
	}
}


function core_dim_add_new_contact_to_person_dimension($object) {
	/* @var $object Contact */
	$person_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'person'"));
	$company_ot = ObjectTypes::findOne(array("conditions" => "`name` = 'company'"));
	$person_dim = Dimensions::findOne(array("conditions" => "`code` = 'feng_persons'"));
	
	if ($person_ot instanceof ObjectType && $person_dim instanceof Dimension) {
		$oid = $object->isCompany() ? $company_ot->getId() : $person_ot->getId();
		$tmp_mem = Members::findOne(array("conditions" => "`dimension_id` = ".$person_dim->getId()." AND `object_type_id` = $oid AND `object_id` = ".$object->getId()));
		if ($tmp_mem instanceof Member) return;
		
		$member = new Member();
		$member->setName($object->getObjectName());
		$member->setDimensionId($person_dim->getId());
		
		$parent_member_id = 0;
		$depth = 1;
		if ($object->isCompany()) {
			$member->setObjectTypeId($company_ot->getId());
		} else {
			$member->setObjectTypeId($person_ot->getId());
			if ($object->getCompanyId() > 0) {
				$pmember = Members::findOne(array('conditions' => '`object_id` = '.$object->getCompanyId().' AND `object_type_id` = '.$company_ot->getId(). ' AND `dimension_id` = '.$person_dim->getId()));
				if ($pmember instanceof Member) {
					$parent_member_id = $pmember->getId();
					$depth = $pmember->getDepth() + 1;
				}
			}
		}
		$member->setParentMemberId($parent_member_id);
		$member->setDepth($depth);
		
		$member->setObjectId($object->getId());
		$member->save();
		
		$sql = "INSERT INTO `".TABLE_PREFIX."contact_dimension_permissions` (`permission_group_id`, `dimension_id`, `permission_type`)
				 SELECT `c`.`permission_group_id`, ".$person_dim->getId().", 'check'
				 FROM `".TABLE_PREFIX."contacts` `c` 
				 WHERE `c`.`is_company`=0 AND `c`.`user_type`!=0 AND `c`.`disabled`=0
				 ON DUPLICATE KEY UPDATE `dimension_id`=`dimension_id`;";
		DB::execute($sql);
		
		$sql = "INSERT INTO `".TABLE_PREFIX."contact_member_permissions` (`permission_group_id`, `member_id`, `object_type_id`, `can_write`, `can_delete`)
				 SELECT `c`.`permission_group_id`, ".$member->getId().", `ot`.`id`, (`c`.`object_id` = ".$object->getId().") as `can_write`, (`c`.`object_id` = ".$object->getId().") as `can_delete`
				 FROM `".TABLE_PREFIX."contacts` `c` JOIN `".TABLE_PREFIX."object_types` `ot` 
				 WHERE `c`.`is_company`=0 
				 	AND `c`.`user_type`!=0 AND `c`.`disabled`=0
					AND `ot`.`type` IN ('content_object', 'located', 'comment')
				 ON DUPLICATE KEY UPDATE `member_id`=`member_id`;";
		DB::execute($sql);
		
		evt_add("reload dimension tree", $member->getDimensionId());
	}
}


function core_dim_add_to_person_user_dimensions ($object, $user_ids) {
	if (logged_user() instanceof Contact) {
		
		$members = Members::findAll(array("conditions" => "`object_id` IN (".implode(",", $user_ids).") AND `dimension_id` IN (SELECT `id` FROM `".TABLE_PREFIX."dimensions` WHERE `code` IN ('feng_persons', 'feng_users'))"));
		if (is_array($members) && count($members) > 0) {
			$object->addToMembers($members);
		}
	}
}

function core_dim_add_company_to_users_dimension($object, $user_dim, $company_ot) {
	
	$member = new Member();
	$member->setName($object->getObjectName());
	$member->setObjectTypeId($company_ot->getId());
	$member->setDimensionId($user_dim->getId());
	$member->setDepth(1);
	$member->setParentMemberId(0);
	$member->setObjectId($object->getId());
	$member->save();
	
	// permisssions
	$sql = "INSERT INTO `".TABLE_PREFIX."contact_dimension_permissions` (`permission_group_id`, `dimension_id`, `permission_type`)
			 SELECT `c`.`permission_group_id`, ".$user_dim->getId().", 'check'
			 FROM `".TABLE_PREFIX."contacts` `c` 
			 WHERE `c`.`is_company`=0 AND `c`.`user_type`!=0 AND `c`.`disabled`=0
			 ON DUPLICATE KEY UPDATE `dimension_id`=`dimension_id`;";
	DB::execute($sql);
	
	$sql = "INSERT INTO `".TABLE_PREFIX."contact_member_permissions` (`permission_group_id`, `member_id`, `object_type_id`, `can_write`, `can_delete`)
			 SELECT `c`.`permission_group_id`, ".$member->getId().", `ot`.`id`, (`c`.`object_id` = ".$object->getId().") as `can_write`, (`c`.`object_id` = ".$object->getId().") as `can_delete`
			 FROM `".TABLE_PREFIX."contacts` `c` JOIN `".TABLE_PREFIX."object_types` `ot` 
			 WHERE `c`.`is_company`=0 
			 	AND `c`.`user_type`!=0 AND `c`.`disabled`=0
				AND `ot`.`type` IN ('content_object', 'located', 'comment')
			 ON DUPLICATE KEY UPDATE `member_id`=`member_id`;";
	DB::execute($sql);
	
	return $member;
}
