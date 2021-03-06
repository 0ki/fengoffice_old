<?php

  /**
  * BaseMailAccount class
  *
  * @author Carlos Palma <chonwil@gmail.com>
  */
  abstract class BaseMailAccount extends DataObject {
  
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
    * Return value of 'user_id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getUserId() {
      return $this->getColumnValue('user_id');
    } // getUserId()
    
    /**
    * Set value of 'user_id' field
    *
    * @access public   
    * @param integer $value
    * @return boolean
    */
    function setUserId($value) {
      return $this->setColumnValue('user_id', $value);
    } // setUserId() 
    
    /**
     * Return value of 'name' field
     *
     * @access public
     * @param void
     * @return string
     */
    function getName() {
    	return $this->getColumnValue('name');
    } // getName()

    /**
     * Set value of 'name' field
     *
     * @access public
     * @param string $value
     * @return boolean
     */
    function setName($value) {
    	return $this->setColumnValue('name', $value);
    } // setName()

    /**
     * Return value of 'email' field
     *
     * @access public
     * @param void
     * @return string
     */
    function getEmail() {
    	return $this->getColumnValue('email');
    } // getEmail()

    /**
     * Set value of 'email' field
     *
     * @access public
     * @param string $value
     * @return boolean
     */
    function setEmail($value) {
    	return $this->setColumnValue('email', $value);
    } // setEmail()

    /**
     * Return value of 'password' field
     *
     * @access public
     * @param void
     * @return string
     */
    function getPassword() {
    	return $this->getColumnValue('password');
    } // getPassword()

    /**
     * Set value of 'password' field
     *
     * @access public
     * @param string $value
     * @return boolean
     */
    function setPassword($value) {
    	return $this->setColumnValue('password', $value);
    } // setPassword()

    /**
     * Return value of 'server' field
     *
     * @access public
     * @param void
     * @return string
     */
    function getServer() {
    	return $this->getColumnValue('server');
    } // getServer()

    /**
     * Set value of 'server' field
     *
     * @access public
     * @param string $value
     * @return boolean
     */
    function setServer($value) {
    	return $this->setColumnValue('server', $value);
    } // setServer()

    /**
     * Return value of 'is_imap' field
     *
     * @access public
     * @param void
     * @return boolean
     */
    function getIsImap() {
    	return $this->getColumnValue('is_imap');
    } // getIsImap()

    /**
     * Set value of 'is_imap' field
     *
     * @access public
     * @param boolean $value
     * @return boolean
     */
    function setIsImap($value) {
    	return $this->setColumnValue('is_imap', $value);
    } // setIsImap()

    /**
     * Return value of 'incoming_ssl' field
     *
     * @access public
     * @param void
     * @return boolean
     */
    function getIncomingSsl() {
    	return $this->getColumnValue('incoming_ssl');
    } // getIncomingSsl()

    /**
     * Set value of 'incoming_ssl' field
     *
     * @access public
     * @param boolean $value
     * @return boolean
     */
    function setIncomingSsl($value) {
    	return $this->setColumnValue('incoming_ssl', $value);
    } // setIncomingSsl()

    /**
     * Return value of 'incoming_ssl_port' field
     *
     * @access public
     * @param void
     * @return integer
     */
    function getIncomingSslPort() {
    	return $this->getColumnValue('incoming_ssl_port');
    } // getIncomingSslPort()

    /**
     * Set value of 'incoming_ssl_port' field
     *
     * @access public
     * @param integer $value
     * @return boolean
     */
    function setIncomingSslPort($value) {
    	return $this->setColumnValue('incoming_ssl_port', $value);
    } // setIncomingSslPort()


    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return MailAccounts
    */
    function manager() {
      if(!($this->manager instanceof MailAccounts)) $this->manager = MailAccounts::instance();
      return $this->manager;
    } // manager
  
  } // BaseMailAccount 

?>