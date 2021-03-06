<?php
//
//  /**
//  * ProjectObject class
//  * Written on Tue, 27 Oct 2007 16:53:08 -0300
//  *
//  * @author Marcos Saiz <marcos.saiz@opengoo.org>
//  */
//  class  ObjectPermissions extends  BaseObjectPermissions {
//
//        
//    /**
//    * Reaturn all permissions that a user has
//    *
//    * @param Object $object
//    * @return array
//    */
//    static function getAllPermissionsByUser(User $user) {
//      return self::findAll(array(
//        'conditions' => array('`user_id` = ?', $user->getId())
//      )); // findAll
//    } //  getAllPermissionsByUser
//        
//    /**
//    * Reaturn all permissions of a object
//    *
//    * @param Object $object
//    * @return array
//    */
//    static function getAllPermissionsByObject(Object $object) {
//      return self::findAll(array(
//        'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object->getId(), get_class($object->manager()))
//      )); // findAll
//    } //  getAllPermissionsByObject
//        
//    /**
//    * Reaturn all permissions of a object
//    *
//    * @param int $object
//    * @return array
//    */
//    static function getAllPermissionsByObjectIdAndManager($object_id, $manager) {
//      return self::findAll(array(
//        'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object_id, $manager)
//      )); // findAll
//    } //  getAllPermissionsByObject
//    
//        
//    /**
//    * User can read
//    *
//    * @param int $object_id
//    * @param int $user_id
//    * @return bool
//    */
//    static function userCanRead( $user_id, $object ) {
//	  $perm = self::findOne(array(
//        'conditions' => array('`user_id` = ? and `rel_object_id` = ? AND `rel_object_manager` = ?', $user_id, $object->getId(), get_class($object->manager()))
//      )); // findAll
//      return $perm!=null && $perm->readPermission();
//    } //  userCanRead    
//        
//    /**
//    * User can write
//    *
//    * @param int $object_id
//    * @param int $user_id
//    * @return bool
//    */
//    static function userCanWrite( $user_id, $object ) {
//	  $perm = self::findOne(array(
//        'conditions' => array('`user_id` = ? and `rel_object_id` = ? AND `rel_object_manager` = ?', $user_id, $object->getId(), get_class($object->manager()))
//      )); // findAll      
//      return $perm!=null && $perm->writePermission();
//    } //  userCanWrite   
//        
//    /**
//    * User can write
//    *
//    * @param int $object_id
//    * @param int $user_id
//    * @return bool
//    */
//    static function userCannotAccess( $user_id, $object ) {
//	  $perm = self::findOne(array(
//        'conditions' => array('`user_id` = ? and `rel_object_id` = ? AND `rel_object_manager` = ?', $user_id, $object->getId(), get_class($object->manager()))
//      )); // findAll      
//      return $perm!=null && $perm->cannotAccess();
//    } //  userCanWrite
//    
//  
//  } // ObjectPermissions

?>