<?php

  /**
  *  GroupUsers class
  *
  * @author Marcos Saiz <marcos.saiz@gmail.com>
  */
  class  GroupUsers extends BaseGroupUsers {
  	/**
  	 * Returns all User objects that belong to a group
  	 *
  	 * @param integer $group_id
  	 * @return User list
  	 */
  	static function getUsersByGroup($group_id){
  		 $all = self::findAll(array('conditions' => array('`group_id` = ?', $group_id) ));
  		 $cond= '0';  		 
  		 if(!$all)
  		 	return array(); //empty result, avoid query
  		 foreach ($all as $usr)  		 	
  		 	$cond .= ',' . $usr->getUserId(); 
  		 $cond = '(' . $cond . ') ';
  		 return  Users::findAll(array('conditions' => array('`id` in ' . $cond) ));
  	}
  	/**
	 * Returns all groups a user belongs to
  	 *
  	 * @param $user_id
  	 * @return unknown
  	 */
  	static function getGroupsByUser($user_id){
  		 $cond = self::getGroupsCSVsByUser($user_id);
  		 if($cond=='')  		 
  			 return array();
  		 else
  			 return Groups::findAll(array('conditions' => array('`id` in ' . $cond) ));
  	}
  	/**
	 * Returns true is a user belongs to a group
  	 *
  	 * @param $user_id
  	 * @return unknown
  	 */
  	static function isUserInGroup($user_id, $group_id){
		try{
 			return (count(self::find(array('conditions' => array("`user_id`  =  $user_id  AND `group_id` =  $group_id") ))) > 0);
		}
		catch (Exception $e){
			return false;
		}
  	}// isUserInGroup
  	
  	/**
  	 * Returns all group ids (separated by commas) which a user belongs to
  	 *
  	 * @param $user_id
  	 * @return unknown
  	 */
  	static function getGroupsCSVsByUser($user_id){
  		 $all = self::findAll(array('conditions' => array('`user_id` = ?', $user_id) ));
  		 $res= '';
  		 if(!$all)
  		 	return ''; //empty result, avoid query
  		 foreach ($all as $gr)  		 	
  		 	$res .= ($res=='')? $gr->getGroupId() : ',' . $gr->getGroupId(); 
		return $res;
  	}
  	
  	/**
  	 * Removes all users of a given grouop
  	 *
  	 * @param unknown_type $group_id
  	 */
  	static function removeUsersByGroup($group_id){
  		self::delete(array('`group_id` = ?', $group_id));
  	}
//    /**
//    * Return all relation objects ( GroupUsers) for specific object
//    *
//    * @param ProjectDataObject $object
//    * @return array
//    */
//    static function getRelationsByObject(ProjectDataObject $object) {
//      return self::findAll(array(
//        'conditions' => array('(`rel_object_manager` = ? and `rel_object_id` = ?) or (`object_manager` = ? and `object_id` = ?)', 
//        		get_class($object->manager()), $object->getObjectId(), get_class($object->manager()), $object->getObjectId()),
//        'order' => '`created_on`'
//      )); // findAll
//    } // getRelationsByObject
//    
//    
//    /**
//    * Return linked objects by object
//    *
//    * @param ProjectDataObject $object
//    * @param boolean $exclude_private Exclude private objects
//    * @return array
//    */
//    static function getGroupUsersByObject(ProjectDataObject $object, $exclude_private = false) {
//      return self::getObjectsByRelations(self::getRelationsByObject($object), $object, $exclude_private);
//    } // getGroupUsersByObject
//    
//    /**
//    * Return objects by array of object - object relations
//    *
//    * @param array $relations
//    * @param boolean $exclude_private Exclude private objects
//    * @return array
//    */
//    static function getObjectsByRelations($relations, $originalObject, $exclude_private = false) {
//      if(!is_array($relations)) return null;
//      
//      $objects = array();
//      foreach($relations as $relation) {
//        $object = $relation->getOtherObject($originalObject);
//        if($object instanceof ProjectDataObject) {
//          if(!($exclude_private && $object->isPrivate())) $objects[] = $object;
//        } // if
//      } // if
//      return count($objects) ? $objects : null;
//    } //getObjectsByRelations
//    
//    /**
//    * Remove all relations by object
//    *
//    * @param ProjectDataObject $object
//    * @return boolean
//    */
//    static function clearRelationsByObject(ProjectDataObject $object) {
//      return self::delete(array('(`object_id` = ? and `object_manager` = ?) or (`object_id` = ? and `object_manager` = ?)', 
//      $object->getId(), get_class($object->manager()), $object->getId(),  get_class($object->manager())));
//    } // clearRelationsByObject
    
  } // clearRelationsByObject

?>