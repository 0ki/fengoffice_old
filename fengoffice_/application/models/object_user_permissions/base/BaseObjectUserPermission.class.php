<?php

  /**
  * BaseObjectUserPermission class
  * Written on Tue, 27 Oct 2007 16:53:08 -0300
  *
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  abstract class BaseObjectUserPermission extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'object_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getObjectId() {
      return $this->getColumnValue('rel_object_id');
    } // getId()
    
    /**
    * Set value of 'object_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setObjectId($value) {
      return $this->setColumnValue('rel_object_id', $value);
    } // setId() 
    /**
    * Return value of 'object_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    
    function getObjectManager() {
      return $this->getColumnValue('rel_object_manager');
    } // getManager()
    
    /**
    * Set value of 'object_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setObjectManager($value) {
      return $this->setColumnValue('rel_object_manager', $value);
    } // setManager() 
    
    /**
    * Return value of 'user_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUserId() {
      return $this->getColumnValue('user_id');
    } // getProjectId()
    
    /**
    * Set value of 'user_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUserId($value) {
      return $this->setColumnValue('user_id', $value);
    } // setProjectId() 
    
    /**
    * Return value of 'permission' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getPermission() {
      return $this->getColumnValue('permission');
    } // getFolderId()
    
    /**
    * Set value of 'permission' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setPermission($value) {
      return $this->setColumnValue('permission', $value);
    } // setFolderId() 
    
    /**
    * Set value of 'permission' field to read and write
    *
    * @access public   
    * @return boolean
    */
    function setWritePermission() {
      return $this->setColumnValue('permission', 2);
    } // setFolderId() 
    
    /**
    * Set value of 'permission' field to reads
    *
    * @access public   
    * @return boolean
    */
    function setReadPermission() {
      return $this->setColumnValue('permission', 1);
    } // setFolderId() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ObjectUserPermission 
    */
    function manager() {
      if(!($this->manager instanceof ObjectUserPermissions )) $this->manager =  ObjectUserPermissions::instance();
      return $this->manager;
    } // manager
  
  } // BaseObjectUserPermission

?>