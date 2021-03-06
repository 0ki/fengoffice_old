<?php

  /**
  * BaseProjectWebpage class
  *
  * @author Carlos Palma <chonwil@gmail.com>
  */
  abstract class BaseProjectWebpage extends ProjectDataObject {
  
    // -------------------------------------------------------
    //  Access methods
    // -------------------------------------------------------
  
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
    * Return value of 'id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getId() {
      return $this->getColumnValue('id');
    } // getWebpageId()
    
    /**
    * Set value of 'id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setId($value) {
      return $this->setColumnValue('id', $value);
    } // setWebpageId() 
    
    /**
    * Return value of 'url' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getUrl() {
      return $this->getColumnValue('url');
    } // getUrl()
    
    /**
    * Set value of 'url' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setUrl($value) {
      return $this->setColumnValue('url', $value);
    } // setUrl()
    
    /**
    * Return value of 'title' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getTitle() {
      return $this->getColumnValue('title');
    } // getTitle()
    
    /**
    * Set value of 'title' field
    *
    * @access public   
    * @param string $value
    * @return boolean
    */
    function setTitle($value) {
      return $this->setColumnValue('title', $value);
    } // setTitle()
    
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
	 * Return value of 'created_by_id' field
	 *
	 * @access public
	 * @param void
	 * @return integer
	 */
	function getCreatedById() {
		return $this->getColumnValue('created_by_id');
	} // getCreatedById()
	
	function getUpdatedById() {
		return $this->getColumnValue('created_by_id');
	} // getUpdatedById()

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
	* Return value of 'is_private' field
	*
	* @access public
	* @param void
	* @return boolean 
	*/
	function getIsPrivate() {
	  return $this->getColumnValue('is_private');
	} // getIsPrivate()

	/**
	* Set value of 'is_private' field
	*
	* @access public   
	* @param int $value
	* @return boolean
	*/
	function setIsPrivate($value) {
	  return $this->setColumnValue('is_private', $value);
	} // setIsPrivate()	
	
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectWebpages
    */
    function manager() {
      if(!($this->manager instanceof ProjectWebpages)) $this->manager = ProjectWebpages::instance();
      return $this->manager;
    } // manager
  
  } // BaseProjectWebpage 

?>