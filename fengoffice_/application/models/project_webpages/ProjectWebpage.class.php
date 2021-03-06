<?php

  /**
  * ProjectWebpage class
  * Generated on Wed, 15 Mar 2006 22:57:46 +0100 by DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class ProjectWebpage extends BaseProjectWebpage {
  
    /**
    * This project object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    /**
    * Project messages are searchable
    *
    * @var boolean
    */
    protected $is_searchable = true;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('title', 'description');

    
    /**
    * Validate before save
    *
    * @access public
    * @param array $errors
    * @return null
    */
    function validate(&$errors) {
      if(!$this->validatePresenceOf('title')) {
        $errors[] = lang('webpage title required');
      } // if
      if(!$this->validatePresenceOf('url') || $this->getUrl() == 'http://') {
        $errors[] = lang('webpage url required');
      } // if
    } // validate
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return view webpage URL of this webpage
    *
    * @access public
    * @param void
    * @return string
    */
    function getViewUrl() {
      return get_url('webpage', 'view', $this->getId());
    } // getAccountUrl
    
    /**
    * Return edit webpage URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('webpage', 'edit', $this->getId());
    } // getEditUrl
    
    /**
    * Return add webpage URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getAddUrl() {
      return get_url('webpage', 'add');
    } // getEditUrl
    
    /**
    * Return delete webpage URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('webpage', 'delete', $this->getId());
    } // getDeleteUrl
    
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Returns true if $user can access this webpage
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false; // user have access to project
      } // if
      if($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't access private objects
      } // if
      return true;
    } // canView
    
    /**
    * Check if specific user can add webpages to specific project
    *
    * @access public
    * @param User $user
    * @param Project $project
    * @return booelean
    */
    function canAdd(User $user, Project $project) {
      if($user->isAdministrator()) {
        return true; // administrator
      } // if
      if(!$user->isProjectUser($project)) {
        return false; // user is on project
      } // if
      return $user->getProjectPermission($project, ProjectUsers::CAN_MANAGE_MESSAGES);
    } // canAdd
    
    /**
    * Check if specific user can edit this webpages
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      if($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't edit private webpage
      } // if
      if($user->getId() == $this->getCreatedById()) {
        return true; // user is webpage author
      } // if
      return false; // no no
    } // canEdit
    
    /**
    * Check if $user can update webpage options
    *
    * @param User $user
    * @return boolean
    */
    function canUpdateOptions(User $user) {
      return $user->isMemberOfOwnerCompany() && $this->canEdit($user);
    } // canUpdateOptions
    
    /**
    * Check if specific user can delete this webpages
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      return false; // no no
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
      return $this->getTitle();
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('webpage');
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
	
  function getDashboardObject(){
    	$result = parent::getDashboardObject();
    	$result["url"] = $this->getUrl();
    	return $result;
    }
  }
?>