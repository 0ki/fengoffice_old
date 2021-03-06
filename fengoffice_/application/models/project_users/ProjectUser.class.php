<?php

/**
 * ProjectUser class
 * Generated on Wed, 15 Mar 2006 22:57:46 +0100 by DataObject generation tool
 *
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class ProjectUser extends BaseProjectUser {

	/**
	 * Sets all permissions to a value.
	 *
	 * @param boolean $value
	 */
	function setAllPermissions($value) {
		$this->setCanReadMessages($value);
		$this->setCanReadTasks($value);
		$this->setCanReadWeblinks($value);
		$this->setCanReadMilestones($value);
		$this->setCanReadMails($value);
		$this->setCanReadContacts($value);
		$this->setCanReadComments($value);
		$this->setCanReadFiles($value);
		$this->setCanReadEvents($value);
		$this->setCanWriteMessages($value);
		$this->setCanWriteTasks($value);
		$this->setCanWriteWeblinks($value);
		$this->setCanWriteMilestones($value);
		$this->setCanWriteMails($value);
		$this->setCanWriteContacts($value);
		$this->setCanWriteComments($value);
		$this->setCanWriteFiles($value);
		$this->setCanWriteEvents($value);
		$this->setCanAssignToOwners($value);
		$this->setCanAssignToOther($value);
	 } // setAllPermissions
} // ProjectUser

?>