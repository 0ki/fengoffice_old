<?php

  /**
  * ContactMemberPermissions
  *
  * @author Diego Castiglioni <diego20@gmail.com>
  */
  class ContactMemberPermissions extends BaseContactMemberPermissions {
    
	  function contactCanReadMember($permission_group_ids, $member_id, $user){
	  		if($user instanceof Contact && $user->isAdministrator()) {
	  			return true;
	  		}  		
	  		$member_permissions = ContactMemberPermissions::findOne(array('conditions' => 
	  							'`member_id` = ' . $member_id. ' AND `permission_group_id` IN ('.$permission_group_ids.')'));
	  	
	  		if ($member_permissions != null)
	  			return true;
	  		else return false;
	  }  
	  
	  
	  function contactCanReadObjectTypeinMember($permission_group_ids, $member_id, $object_type_id, $can_write=false, $can_delete=false, $user=null){
	  		if($user instanceof Contact && $user->isAdministrator()) {
	  			return true;
	  		}
			$can_write_cond = false;
			if ($can_write)$can_write_cond = " AND `can_write` = 1";
			$can_delete_cond = false;
			if ($can_delete)$can_delete_cond = " AND `can_delete` = 1";
//			if ($permission_group_ids = "") $permission_group_ids = 0;
	  	
	  		$member_permissions = ContactMemberPermissions::findOne(array('conditions' => 
	  							'`member_id` = ' .$member_id. ' AND `object_type_id` = '.$object_type_id.' AND 
	  							`permission_group_id` IN ('.$permission_group_ids.')'.$can_write_cond.$can_delete_cond));
	  	
	  		return !is_null($member_permissions);
	  }
	  
	  
	  function getActiveContextPermissions(Contact $contact, $object_type_id, $context, $dimension_members, $can_write=false, $can_delete=false){
    		if($contact instanceof Contact && $contact->isAdministrator()) {
    			return $dimension_members;
    		}
	  		$allowed_members = array();
	  			  	
	  		$permission_group_ids = ContactPermissionGroups::getContextPermissionGroupIdsByContactCSV($contact->getId());
	  		$perm_ids_array = explode(",", $permission_group_ids);
  			
  			foreach ($perm_ids_array as $pid) {
  				foreach ($dimension_members as $member_id) {
  					//check if exists a context permission group for this object type id in this member
  					$contact_member_permission = self::findById(array('permission_group_id' => $pid, 'member_id' => $member_id, 'object_type_id' => $object_type_id));
  					if ($contact_member_permission instanceof ContactMemberPermission && (!$can_write || $contact_member_permission->getCanWrite() && !$can_delete || $contact_member_permission->getCanDelete())) {
  						$permission_contexts = PermissionContexts::findAll(array('`contact_id` = '.$contact->getId(), 'permission_group_id' => $pid, 'member_id' => $member_id));
	  					//check if the actual context applies to this permission group
  						if (!is_null($permission_contexts)) {
  							$dimensions = array();
  							$context_members = array();
	  						foreach ($permission_contexts as $pc){
	  							$member = $pc->getMember();
	  							$dimension_id = $member->getDimensionId();
	  							if (!in_array($dimension_id, $dimensions)){
	  								$dimensions[] = $dimension_id;
	  								$context_members[$dimension_id] = array();
	  							}
	  							$context_members[$dimension_id][] = $member;
	  						}
	  						$include = true;
		  					foreach($dimensions as $dim_id){
		  						$members_in_context = array();
		  						foreach ($context_members[$dim_id] as $value){
		  							if (in_array($value, $context))
		  								$members_in_context[] = $value;
		  						}
		  						if (count($members_in_context)==0){
		  							$include = $include && false;
		  						}
		  					}	
		  					if ($include && count($dimensions)!=0) $allowed_members[] = $member_id;
			  			}
		  			}
  				}
  			}
  			return $allowed_members;
 	  }
    
  } // ContactMemberPermissions 

?>