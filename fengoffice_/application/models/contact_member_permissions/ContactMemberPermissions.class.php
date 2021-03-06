<?php

/**
 * ContactMemberPermissions
 *
 * @author Diego Castiglioni <diego.castiglioni@fengoffice.com>
 */
class ContactMemberPermissions extends BaseContactMemberPermissions {
	
	function contactCanReadMember($permission_group_ids, $member_id, $user) {
		if ($user instanceof Contact && $user->isAdministrator ()) {
			return true;
		}
		$member_permissions = ContactMemberPermissions::findOne ( array ('conditions' => '`member_id` = ' . $member_id . ' AND `permission_group_id` IN (' . $permission_group_ids . ')' ) );
		
		if ($member_permissions != null)
			return true;
		else
			return false;
	}
	
	function contactCanReadObjectTypeinMember($permission_group_ids, $member_id, $object_type_id, $can_write = false, $can_delete = false, $user = null) {
		if ($user instanceof Contact && $user->isAdministrator ()) {
			return true;
		}
		$can_write_cond = false;
		if ($can_write)
			$can_write_cond = " AND `can_write` = 1";
		$can_delete_cond = false;
		if ($can_delete)
			$can_delete_cond = " AND `can_delete` = 1";
		
		//			if ($permission_group_ids = "") $permission_group_ids = 0;
		

		$member_permissions = ContactMemberPermissions::findOne ( array ('conditions' => '`member_id` = ' . $member_id . ' AND `object_type_id` = ' . $object_type_id . ' AND 
	  							`permission_group_id` IN (' . $permission_group_ids . ')' . $can_write_cond . $can_delete_cond ) );
		
		return ! is_null ( $member_permissions );
	}
	
	function getActiveContextPermissions(Contact $contact, $object_type_id, $context, $dimension_members, $can_write = false, $can_delete = false) {
		if ($contact instanceof Contact && $contact->isAdministrator ()) {
			return $dimension_members;
		}
		$allowed_members = array ();
		
		$permission_group_ids = ContactPermissionGroups::getContextPermissionGroupIdsByContactCSV ( $contact->getId () );
		$perm_ids_array = explode ( ",", $permission_group_ids );
		
		foreach ( $perm_ids_array as $pid ) {
			foreach ( $dimension_members as $member_id ) {
				//check if exists a context permission group for this object type id in this member
				$contact_member_permission = self::findById ( array ('permission_group_id' => $pid, 'member_id' => $member_id, 'object_type_id' => $object_type_id ) );
				if ($contact_member_permission instanceof ContactMemberPermission && (! $can_write || $contact_member_permission->getCanWrite () && ! $can_delete || $contact_member_permission->getCanDelete ())) {
					$permission_contexts = PermissionContexts::findAll ( array ('`contact_id` = ' . $contact->getId (), 'permission_group_id' => $pid, 'member_id' => $member_id ) );
					//check if the actual context applies to this permission group
					if (! is_null ( $permission_contexts )) {
						$dimensions = array ();
						$context_members = array ();
						foreach ( $permission_contexts as $pc ) {
							$member = $pc->getMember ();
							$dimension_id = $member->getDimensionId ();
							if (! in_array ( $dimension_id, $dimensions )) {
								$dimensions [] = $dimension_id;
								$context_members [$dimension_id] = array ();
							}
							$context_members [$dimension_id] [] = $member;
						}
						$include = true;
						foreach ( $dimensions as $dim_id ) {
							$members_in_context = array ();
							foreach ( $context_members [$dim_id] as $value ) {
								if (in_array ( $value, $context ))
									$members_in_context [] = $value;
							}
							if (count ( $members_in_context ) == 0) {
								$include = $include && false;
							}
						}
						if ($include && count ( $dimensions ) != 0)
							$allowed_members [] = $member_id;
					}
				}
			}
		}
		return $allowed_members;
	}
	
	/**
	 * Enter description here ...
	 * @param Contact $contact
	 * @param array of ObjectType $types
	 * @param array of int  $members
	 */
	function grantAllPermissions(Contact $contact, $members) {
		if ($contact->getUserType() > 0  && count($members)) {
			$userType = $contact->getUserTypeName() ;
			$permissions = array(); // TO fill sharing table
			$gid = $contact->getPermissionGroupId ();
			foreach ( $members as $member_id ) {
				//new 
				$member = Members::findById($member_id);
				$dimension = $member->getDimension();
				
				$types = array();
				$member_types = DimensionObjectTypeContents::getContentObjectTypeIds($dimension->getId(), $member->getObjectTypeId());
				if (count($member_types)) {
					switch ( $userType ) {
						case 'Super Administrator':  case 'Administrator': case 'Manager': case 'Executive' :
							$types = $member_types;
							break;
						case 'Collaborator Customer': case 'Non-Exec Director':
							foreach (ObjectTypes::findAll(array("conditions"=>" name NOT IN ('mail') ")) as $type) {//TODO This sucks 
								$types[]=$type->getId();
							}
							break;
						case 'Internal Collaborator':  case 'External Collaborator': 
							foreach (ObjectTypes::findAll(array("conditions"=>" name NOT IN ('mail','contact', 'report') ")) as $type) {//TODO This sucks 
								$types[]=$type->getId();
							}
							break;
						case 'Guest Customer':
							foreach (ObjectTypes::findAll(array("conditions"=>" name IN ('message', 'weblink', 'event', 'file') ")) as $type) {//TODO This sucks 
								$types[]=$type->getId();
							}
							break;
						case 'Guest':
							foreach (ObjectTypes::findAll(array("conditions"=>" name IN ('message', 'weblink', 'event') ")) as $type) {//TODO This sucks 
								$types[]=$type->getId();
							}
							break;
					}
				}
				foreach ( $types as $type_id ) {
					if (! ContactMemberPermissions::instance ()->findOne ( array ("conditions" => 
							"permission_group_id = $gid	AND 
							member_id = $member_id AND 
							object_type_id = $type_id" ) )) {
						$cmp = new ContactMemberPermission ();
						$cmp->setPermissionGroupId ( $gid );
						$cmp->setMemberId ( $member_id );
						$cmp->setObjectTypeId ( $type_id );
						if ($userType != "Guest" && $userType != "Guest Customer" ){
							$cmp->setCanWrite ( 1 );
							$cmp->setCanDelete ( 1 );
						}else{
							$cmp->setCanWrite ( 0 );
							$cmp->setCanDelete ( 0 );
						}
						$cmp->save ();
						
						
						$perm = new stdClass();
						$perm->m = $member_id;
						$perm->r = 1;
						$perm->w = 1;
						$perm->d = 1;
						$perm->o = $type_id;
						$permissions[] = $perm;
						
					}
				}
			}
			if (count($permissions)) {
				$stCtrl = new SharingTableController();
				$stCtrl->afterPermissionChanged($contact->getPermissionGroupId(), $permissions);
			}
			
			
		}
	}

} 
