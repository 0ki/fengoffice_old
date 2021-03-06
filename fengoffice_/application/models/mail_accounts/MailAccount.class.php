<?php

/**
 * MailAccount class
 * Generated on Wed, 15 Mar 2006 22:57:46 +0100 by DataObject generation tool
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class MailAccount extends BaseMailAccount {

	private $owner;
	 
	/**
	 * Gets the account owner
	 *
	 * @return User
	 */
	function getOwner()
	{
		if (is_null($this->owner)){
			$this->owner = Users::findById($this->getUserId());
		}
		return $this->owner;
	}
	 
	/**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return null
	 */
	function validate(&$errors) {
		if(!$this->validatePresenceOf('name')) {
			$errors[] = lang('mail account name required');
		} // if
		if(!$this->validatePresenceOf('server')) {
			$errors[] = lang('mail account server required');
		} // if
		if(!$this->validatePresenceOf('password')) {
			$errors[] = lang('mail account password required');
		} // if
		if(!$this->validatePresenceOf('email')) {
			$errors[] = lang('mail account id required');
		} // if
	} // validate

	/* Return array of all emails
	 *
	 * @access public
	 * @param void
	 * @return one or MailContents objects
	 */
	function getMailContents() {
		return MailContents::findAll(array(
        'conditions' => '`account_id` = ' . DB::escape($this->getId()),
      'order' => '`date` DESC'
      )); // findAll
	} // getMailContents

	function getUidls()
	{
		try
		{
			$sql = "SELECT uid from " . MailContents::instance()->getTableName()." WHERE account_id = ". $this->getId();
			$rows = DB::executeAll($sql);
			return $rows;
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}


	// ---------------------------------------------------
	//  URLs
	// ---------------------------------------------------

	/**
	 * Return view mail URL of this mail
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getViewUrl() {
		return get_url('mail', 'view_account', $this->getId());
	} // getAccountUrl

	/**
	 * Return edit mail URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getEditUrl() {
		return get_url('mail', 'edit_account', $this->getId());
	} // getEditUrl

	/**
	 * Return add mail URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getAddUrl() {
		return get_url('mail', 'add_account');
	} // getEditUrl

	/**
	 * Return delete mail URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getDeleteUrl() {
		return get_url('mail', 'delete_account', $this->getId());
	} // getDeleteUrl


	// ---------------------------------------------------
	//  Permissions
	// ---------------------------------------------------

	/**
	 * Returns true if $user can access this account
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canView(User $user) {
		return true;
	} // canView

	/**
	 * Check if specific user can add accounts
	 *
	 * @access public
	 * @param User $user
	 * @param Project $project
	 * @return booelean
	 */
	function canAdd(User $user) {
		return true;
	} // canAdd

	/**
	 * Check if specific user can edit this account
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canEdit(User $user) {
		return true;
	} // canEdit

	/**
	 * Check if specific user can delete this account
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canDelete(User $user) {
		return true;
	} // canDelete

	// ---------------------------------------------------
	//  ApplicationDataObject implementation
	// ---------------------------------------------------

	/**
	 * Return object name
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getObjectName() {
		return $this->getName();
	} // getObjectName

	/**
	 * Return object type name
	 *
	 * @param void
	 * @return string
	 */
	function getObjectTypeName() {
		return 'mail account';
	} // getObjectTypeName

	/**
	 * Return object URl
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getObjectUrl() {
		return $this->getEditUrl();
	} // getObjectUrl

}
?>