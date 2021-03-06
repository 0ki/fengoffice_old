<?php

  /**
  * BaseEventType class
  *
  * @author Marcos Saiz <marcos.saiz@gmail.com>
  */
  abstract class BaseEventType extends DataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
    /**
    * Return value of 'id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getId() {
      return $this->getColumnValue('id');
    } // getId()
    
    /**
    * Set value of 'id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setId($value) {
      return $this->setColumnValue('id', $value);
    } // setId() 
    
    /**
    * Return value of 'typename' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTypename() {
      return $this->getColumnValue('typename');
    } //  getTypename()
    
    /**
    * Set value of 'typename' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function  setTypename($value) {
      return $this->setColumnValue('typename', $value);
    } //  setTypename() 
    
    /**
    * Return value of 'typedesc' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTypeDesc() {
      return $this->getColumnValue('typedesc');
    } //  getTypeDesc()
    
    /**
    * Set value of 'typedesc' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function  setTypeDesc($value) {
      return $this->setColumnValue('typedesc', $value);
    } //  setTypeDesc() 
    
    
    /**
    * Return value of 'typecolor' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTypeColor() {
      return $this->getColumnValue('typecolor');
    } //   getTypeColor()
    
    /**
    * Set value of 'typecolor' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setTypeColor($value) {
      return $this->setColumnValue('typecolor', $value);
    } //   setTypeColor() 
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return EventTypes 
    */
    function manager() {
      if(!($this->manager instanceof EventTypes)) $this->manager = EventTypes::instance();
      return $this->manager;
    } // manager
  
  } // BaseEventType 

?>