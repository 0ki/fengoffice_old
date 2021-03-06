<?php

  /**
  * ProjectFile class
  * Written on Tue, 27 Oct 2007 16:53:08 -0300
  *
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  abstract class BaseFilePermission extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'file_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getFileId() {
      return $this->getColumnValue('file_id');
    } // getId()
    
    /**
    * Set value of 'file_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setFileId($value) {
      return $this->setColumnValue('file_id', $value);
    } // setId() 
    
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
    * @return FilePermission 
    */
    function manager() {
      if(!($this->manager instanceof FilePermissions )) $this->manager =  FilePermissions::instance();
      return $this->manager;
    } // manager
  
  } // BaseFilePermission

?>