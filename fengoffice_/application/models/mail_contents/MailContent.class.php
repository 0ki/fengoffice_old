<?php

/**
 * MailContent class
 * Generated on Wed, 15 Mar 2006 22:57:46 +0100 by DataObject generation tool
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class MailContent extends BaseMailContent {

	/**
	 * Cache of account
	 *
	 * @var MailAccount
	 */
	private $account;

	protected $project;

	/**
	 * This project object is taggable
	 *
	 * @var boolean
	 */
	protected $is_taggable = true;
	
	/**
	 * Mail contents are searchable
	 *
	 * @var boolean
	 */
	protected $is_searchable = true;

	/**
	 * Array of searchable columns
	 *
	 * @var array
	 */
	protected $searchable_columns = array('from', 'to', 'subject', 'body_plain', );
	 
	/**
	 * Return Project
	 *
	 * @access public
	 * @param void
	 * @return Project
	 */
	function getProject()
	{
		if(!isset($this->project)) {
			$this->project = Projects::findById($this->getProjectId());
		} // if
		return $this->project;
	}
	 
	/**
	 * Gets the owner mail account
	 *
	 * @return MailAccount
	 */
	function getAccount()
	{
		if (is_null($this->account)){
			$this->account = MailAccounts::findById($this->getAccountId());
		} //if
		return $this->account;
	}
	 
	/**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return null
	 */
	function validate(&$errors) {
		if(!$this->validatePresenceOf('uid')) {
			$errors[] = lang('uid required');
		} // if
		if(!$this->validatePresenceOf('account_id')) {
			$errors[] = lang('account id required');
		} // if
	} // validate


	function deleteContents()
	{
		$this->setContent("");
		$this->setBodyHtml("");
		$this->setBodyPlain("");
		$this->setProjectId(0);
		$this->setFrom("");
		$this->setTo("");
		$this->setIsDeleted(true);
		$this->clearTags();
		$this->clearSearchIndex();
		$this->clearLinkedObjects();
		return true;
	}



	/**
	 * Returns if the field is classified
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function getIsClassified() {
		return ($this->getColumnValue('project_id') != 0);
	} // getIsClassified()

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
		return get_url('mail', 'view', $this->getId());
	} // getAccountUrl

	/**
	 * Return delete mail URL of this mail
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getDeleteUrl() {
		return get_url('mail', 'delete', $this->getId());
	} // getDeleteUrl

	/**
	 * Return classify mail URL of this mail
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getClassifyUrl() {
		return get_url('mail', 'classify', array( 'id' => $this->getId(), 'type' => 'email'));
	} // getClassifyUrl

	/**
	 * Return send mail URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getSendMailUrl() {
		return get_url('mail', 'add_mail');
	} // getClassifyUrl

	/**
	 * Return reply mail URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getReplyMailUrl() {
		return get_url('mail', 'reply_mail', array( 'id' => $this->getId(), 'type' => 'email'));
	} // getReplyMailUrl
	
	// ---------------------------------------------------
	//  Permissions
	// ---------------------------------------------------

	/**
	 * Returns true if $user can view this email
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canView(User $user) {	
		return can_read($user,$this);
		//return $this->getAccount()->getUserId() == $user->getId() || $user->isAdministrator();
	} // canView


	/**
	 * Returns true if $user can edit this email
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canEdit(User $user) {	
		return can_write($user,$this);
//		return $this->getAccount()->getUserId() == $user->getId() || $user->isAdministrator();
	} // canEdit

	/**
	 * Check if specific user can add contacts to specific project
	 *
	 * @access public
	 * @param User $user
	 * @param Project $project
	 * @return booelean
	 */
	function canAdd(User $user, Project $project) {
		return can_add($user,$project,get_class(MailContents::instance()));
	} // canAdd

	/**
	 * Returns true if $user can delete this email
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canDelete(User $user) {
		return can_delete($user,$this);
//		return $this->getAccount()->getUserId() == $user->getId() || $user->isAdministrator();
	} // canView

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
		if ($this->getProjectId() > 0)
			return 'email';
		else
			return 'emailunclassified';
	} // getObjectTypeName

	/**
	 * Return object URl
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getObjectUrl() {
		return $this->getViewUrl();
	} // getObjectUrl



	/**
	 * Return value of 'subject' field
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getName() {
		return $this->getColumnValue('subject');
	} // getSubject()


  function getDashboardObject(){
    	$projectId = "0";
    	$project = "";
    	$type = "emailunclassified";
    	$tags = project_object_tags($this);
    	if ($this->getProjectId() > 0){
    		$projectId = $this->getProjectId();
    		$project = $this->getProject()->getName();
    		$type = "email";
    	}
    	
    	return array(
				"id" => $this->getObjectTypeName() . $this->getId(),
				"object_id" => $this->getId(),
				"name" => $this->getObjectName(),
				"type" => $type,
				"tags" => $tags,
				"createdBy" => $this->getAccount()->getOwner()->getDisplayName(),
				"createdById" => $this->getAccount()->getOwner()->getId(),
				"dateCreated" => $this->getSentDate()->getTimestamp(),
				"updatedBy" => $this->getAccount()->getOwner()->getDisplayName(),
				"updatedById" => $this->getAccount()->getOwner()->getId(),
				"dateUpdated" => $this->getSentDate()->getTimestamp(),
				"project" => $project,
				"projectId" => $projectId,
				"url" => $this->getObjectUrl(),
				"manager" => get_class($this->manager())
		);
	}
}
?>