<?php

  /**
  *  GroupUsers class
  *
  * @author Marcos Saiz <marcos.saiz@gmail.com>
  */
  class  GroupUsers extends BaseGroupUsers {
  
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