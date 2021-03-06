<?php

  /**
  * ProjectFile class
  * Written on Tue, 27 Oct 2007 16:53:08 -0300
  *
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  class  FilePermissions extends  BaseFilePermissions {

        
    /**
    * Reaturn all permissions that a user has
    *
    * @param File $file
    * @return array
    */
    static function getAllPermissionsByUser(User $user) {
      return self::findAll(array(
        'conditions' => array('`user_id` = ?', $user->getId())
      )); // findAll
    } //  getAllPermissionsByUser
        
    /**
    * Reaturn all permissions of a file
    *
    * @param File $file
    * @return array
    */
    static function getAllPermissionsByFile(File $file) {
      return self::findAll(array(
        'conditions' => array('`file_id` = ?', $file->getId())
      )); // findAll
    } //  getAllPermissionsByFile
        
    /**
    * Reaturn all permissions of a file
    *
    * @param int $file
    * @return array
    */
    static function getAllPermissionsByFileId($file_id) {
      return self::findAll(array(
        'conditions' => array('`file_id` = ? ', $file_id)
      )); // findAll
    } //  getAllPermissionsByFile
    
        
    /**
    * User can read
    *
    * @param int $file_id
    * @param int $user_id
    * @return bool
    */
    static function userCanRead( $user_id, $file_id ) {
	  $perm = self::findOne(array(
        'conditions' => array('`user_id` = ? and `file_id` = ? ', $user_id, $file_id)
      )); // findAll
      return $perm!=null && $perm->readPermission();
    } //  userCanRead    
        
    /**
    * User can write
    *
    * @param int $file_id
    * @param int $user_id
    * @return bool
    */
    static function userCanWrite( $user_id, $file_id ) {
	  $perm = self::findOne(array(
        'conditions' => array('`user_id` = ? and `file_id` = ? ', $user_id, $file_id)
      )); // findAll      
      return $perm!=null && $perm->writePermission();
    } //  userCanWrite
    
  
  } // FilePermissions

?>