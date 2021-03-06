<?php

  /**
  * Report class
  *
  * @author Pablo Kamil <pablokam@gmail.com>
  */
  class Report extends BaseReport {
      
    /**
    * Construct the object
    *
    * @param void
    * @return null
    */
    function __construct() {
      parent::__construct();
    } // __construct
    
    /**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return null
	 */
	function validate(&$errors) {
		if(trim($this->getObjectName()) == ''){
			$errors[] = lang('report name required');
		}
		if(trim($this->getReportObjectTypeId()) == ''){
			$errors[] = lang('report object type required');
		}
	} // validate
	
	/**
	 * Check CAN_MANAGE_REPORTS permission
	 *
	 * @access public
	 * @param Contact $user
	 * @return boolean
	 */
	function canManage(Contact $user) {
		return can_manage_reports($user);
	} // canManage

	/**
	 * Returns true if $user can access this report
	 *
	 * @param Contact $user
	 * @return boolean
	 */
	function canView(Contact $user) {
		return can_read($user, $this->getMembers(), $this->manager()->getObjectTypeId());
	} // canView

	/**
	 * Check if specific user can add reports
	 *
	 * @access public
	 * @param Contact $user
	 * @param Project $project
	 * @return booelean
	 */
	function canAdd(Contact $user, $context) {
		return can_add($user, $context, $this->manager()->getObjectTypeId());
	} // canAdd

	/**
	 * Check if specific user can edit this report
	 *
	 * @access public
	 * @param Contact $user
	 * @return boolean
	 */
	function canEdit(Contact $user) {
		return can_add($user, $this->getMembers(), $this->manager()->getObjectTypeId());
	} // canEdit

	/**
	 * Check if specific user can delete this report
	 *
	 * @access public
	 * @param Contact $user
	 * @return boolean
	 */
	function canDelete(Contact $user) {
		return can_delete($user, $this->getMembers(), $this->manager()->getObjectTypeId());
	} // canDelete
    
   
  } // Report

?>