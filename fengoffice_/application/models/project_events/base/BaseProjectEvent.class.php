<?php

  /**
  * BaseProjectEvent class
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  abstract class BaseProjectEvent extends ProjectDataObject {
  
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
    * Return value of 'project_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getProjectId() {
      return $this->getColumnValue('project_id');
    } // getProjectId()
    
    /**
    * Set value of 'project_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setProjectId($value) {
      return $this->setColumnValue('project_id', $value);
    } // setProjectId() 
    
    /**
    * Return value of 'duration' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getDuration() {
      return $this->getColumnValue('duration');
    } // getduration()
    
    /**
    * Set value of 'folder_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setDuration($value) {
      return $this->setColumnValue('duration', $value);
    } // setduration() 
    
    /**
    * Return value of 'forever' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getRepeatForever() {
      return $this->getColumnValue('repeat_forever');
    } //  getForever()
    
    /**
    * Set value of 'forever' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function  setRepeatForever($value) {
      return $this->setColumnValue('repeat_forever', $value);
    } //  setForever() 
    
    /**
    * Return value of 'eventtype' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getEventType() {
      return $this->getColumnValue('eventtype');
    } //  getEventType()
    
    /**
    * Set value of 'eventtype' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function  setEventType($value) {
      return $this->setColumnValue('eventtype', $value);
    } //  setEventType() 
    
    /**
    * Return value of 'description' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getDescription() {
      return $this->getColumnValue('description');
    } // getDescription()
    
    /**
    * Set value of 'description' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setDescription($value) {
      return $this->setColumnValue('description', $value);
    } // setDescription() 
    
    
    /**
    * Return value of 'subject' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getSubject() {
      return $this->getColumnValue('subject');
    } // getSsubject()
    
    /**
    * Set value of 'description' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setSubject($value) {
      return $this->setColumnValue('subject', $value);
    } //setSubject() 
    
    /**
    * Return value of 'private' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsPrivate() {
      return $this->getColumnValue('private');
    } // getIsPrivate()
    
    /**
    * Set value of 'private' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setIsPrivate($value) {
      return $this->setColumnValue('private', $value);
    } // setIsPrivate() 
    
    /**
    * Return value of 'repeat_end' field
    *
    * @access public
    * @param void
    * @return Date 
    */
    function getRepeatEnd() {
      return $this->getColumnValue('repeat_end');
    } //  getRepeatEnd()
    
    /**
    * Set value of 'repeat_end' field
    *
    * @access public   
    * @param Date $value
    * @return boolean
    */
    function  setRepeatEnd($value) {
      return $this->setColumnValue('repeat_end', $value);
    } //  setRepeatEnd() 
    
    /**
    * Set value of 'repeat_end' field
    *
    * @access public   
    * @param Integer $value
    * @return boolean
    */
    function  setRepeatNum($value) {
      return $this->setColumnValue('repeat_num', $value);
    } //  setRepeatNum() 
    
    /**
    * Return value of 'repeat_end' field
    *
    * @access public
    * @param void
    * @return  Integer 
    */
    function getRepeatNum() {
      return $this->getColumnValue('repeat_num');
    } //  getRepeatNum()
    
    /**
    * Set value of 'repeat_end' field
    *
    * @access public   
    * @param Integer $value
    * @return boolean
    */
    function  setRepeatD($value) {
      return $this->setColumnValue('repeat_d', $value);
    } //  setRepeatEnd() 
    
    /**
    * Return value of 'repeat_end' field
    *
    * @access public
    * @param void
    * @return  Integer 
    */
    function getRepeatD() {
      return $this->getColumnValue('repeat_d');
    } //  getRepeatEnd()
    /**
    * Set value of 'repeat_end' field
    *
    * @access public   
    * @param Integer $value
    * @return boolean
    */
    function  setRepeatM($value) {
      return $this->setColumnValue('repeat_m', $value);
    } //  setRepeatEnd() 
    
    /**
    * Return value of 'repeat_end' field
    *
    * @access public
    * @param void
    * @return  Integer 
    */
    function getRepeatM() {
      return $this->getColumnValue('repeat_m');
    } //  getRepeatEnd()
    /**
    * Set value of 'repeat_end' field
    *
    * @access public   
    * @param Integer $value
    * @return boolean
    */
    function  setRepeatY($value) {
      return $this->setColumnValue('repeat_y', $value);
    } //  setRepeatEnd() 
    
    /**
    * Return value of 'repeat_end' field
    *
    * @access public
    * @param void
    * @return  Integer 
    */
    function getRepeatY() {
      return $this->getColumnValue('repeat_y');
    } //  getRepeatEnd()
    /**
    * Set value of 'repeat_end' field
    *
    * @access public   
    * @param Integer $value
    * @return boolean
    */
    function  setRepeatH($value) {
      return $this->setColumnValue('repeat_h', $value);
    } //  setRepeatEnd() 
    
    /**
    * Return value of 'repeat_end' field
    *
    * @access public
    * @param void
    * @return  Integer 
    */
    function getRepeatH() {
      return $this->getColumnValue('repeat_h');
    } //  getRepeatEnd()
    
    /**
    * Return value of 'is_locked' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getIsLocked() {
      return $this->getColumnValue('is_locked');
    } // getIsLocked()
    
    /**
    * Set value of 'type_id' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setTypeId($value) {
      return $this->setColumnValue('type_id', $value);
    } // setIsLocked() 
    
    /**
    * Return value of 'type_id' field
    *
    * @access public
    * @param void
    * @return boolean 
    */
    function getTypeId() {
      return $this->getColumnValue('type_id');
    } // getIsVisible()
    
    /**
    * Set value of 'special_id' field
    *
    * @access public   
    * @param boolean $value
    * @return boolean
    */
    function setSpecialID($value) {
      return $this->setColumnValue('special_id', $value);
    } // setSpecialID() 
    
    /**
    * Return value of 'special_id' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getSpecialID() {
      return $this->getColumnValue('special_id');
    } // setSpecialID()
    
    /**
    * Return value of 'created_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getCreatedOn() {
      return $this->getColumnValue('created_on');
    } // getCreatedOn()
    
    /**
    * Set value of 'created_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setCreatedOn($value) {
      return $this->setColumnValue('created_on', $value);
    } // setCreatedOn() 
    
    /**
    * Return value of 'start' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getStart() {
      return $this->getColumnValue('start');
    } // getStart()
    
    /**
    * Set value of 'start' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setStart($value) {
      return $this->setColumnValue('start', $value);
    } // setStart() 
    
    /**
    * Return value of 'created_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getCreatedById() {
      return $this->getColumnValue('created_by_id');
    } // getCreatedById()
    
    /**
    * Set value of 'created_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setCreatedById($value) {
      return $this->setColumnValue('created_by_id', $value);
    } // setCreatedById() 
    
    /**
    * Return value of 'updated_on' field
    *
    * @access public
    * @param void
    * @return DateTimeValue 
    */
    function getUpdatedOn() {
      return $this->getColumnValue('updated_on');
    } // getUpdatedOn()
    
    /**
    * Set value of 'updated_on' field
    *
    * @access public   
    * @param DateTimeValue $value
    * @return boolean
    */
    function setUpdatedOn($value) {
      return $this->setColumnValue('updated_on', $value);
    } // setUpdatedOn() 
    
    /**
    * Return value of 'updated_by_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUpdatedById() {
      return $this->getColumnValue('updated_by_id');
    } // getUpdatedById()
    
    /**
    * Set value of 'updated_by_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUpdatedById($value) {
      return $this->setColumnValue('updated_by_id', $value);
    } // setUpdatedById() 
    
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectEvents 
    */
    function manager() {
      if(!($this->manager instanceof ProjectEvents)) $this->manager = ProjectEvents::instance();
      return $this->manager;
    } // manager
  
  } // BaseProjectEvent 

?>