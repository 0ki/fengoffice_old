<?php

  /**
  * ProjectEvent class
  * Generated on Tue, 04 Jul 2006 06:46:08 +0200 by DataObject generation tool
  *
  * @author Marcos Saiz <marcos.saiz@gmail.com>
  */
  class ProjectEvent extends BaseProjectEvent {
    
    /**
    * This project object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    /**
    * Message comments are searchable
    *
    * @var boolean
    */
    protected $is_searchable = true;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('subject', 'description');
    
    /**
    * Project Event is commentable object
    *
    * @var boolean
    */
    protected $is_commentable = true;
  
    /**
    * Cached Event type object
    *
    * @var EventType
    */
    private $event_type;
    
    
    /**
    * Contruct the object
    *
    * @param void
    * @return null
    */
    function __construct() {
//      $this->addProtectedAttribute('system_Eventname', 'Eventname', 'type_string', 'Eventsize');
      parent::__construct();
    } // __construct
 
    function getUserName(){
    	$user = Users::findById($this->getCreatedById());
    	if ($user instanceof User ) return $user->getUsername();
    	else return null;
    }
  
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return Event modification URL
    *
    * @param void
    * @return string
    */
    function getModifyUrl() {
    	return get_url('event','modify',array('id'=> $this->getId() ));
		//ejemplo:http://localhost/opengoo/index.php?ajax=true&a=modify&id=8&day=02&month=4&year=2008&c=event&_dc=1208295398801
    } // getModifyUrl
	
	/**
    * Return Event viewing URL
    *
    * @param void
    * @return string
    */
    function getOpenUrl() {
    	return $this->getModifyUrl();
    } // getOpenUrl 
       
   
    /**
    * Return Event details URL
    *
    * @param void
    * @return string
    */
    function getDetailsUrl() {
		return $this->getModifyUrl();
    } // getDetailsUrl
    
    /**
    * Return comments URL
    *
    * @param void
    * @return string
    */
    function getCommentsUrl() {
      return $this->getDetailsUrl() . '#objectComments';
    } // getCommentsUrl
    
    /**
    * Return Event download URL
    *
    * @param void
    * @return string
    */
    function getDownloadUrl() {
		return $this->getModifyUrl();
    } // getDownloadUrl
    
    /**
    * Return edit Event URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
		return $this->getModifyUrl();
    } // getEditUrl
    
    /**
    * Return delete Event URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {    	
    	get_url('event','delete',array('id'=> $this->getId() ));

    } // getDeleteUrl
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Check CAN_MANAGE_EventS permission
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canManage(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      return $user->isAdministrator() ||  $user->getProjectPermission($this->getProject(), ProjectUsers::CAN_MANAGE_EVENTS );
    } // canManage
    
    
    /**
    * Empty implementation of abstract method. Message determins if user have view access
    *
    * @param void
    * @return boolean
    */
    function canView(User $user) {
      if($this->getIsPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false;
      } // if
      if( ObjectUserPermissions::userCannotAccess( logged_user()->getId() ,$this))
      	return false;      
	  return $user->isAdministrator() ||  
	  		$user->getProjectPermission($this->getProject(), ProjectUsers::CAN_MANAGE_EVENTS ) ||
	  		$user->isProjectUser($this->getProject());
    } // canView
    
    /**
    * Returns true if user can download this Event
    *
    * @param User $user
    * @return boolean
    */
    function canDownload(User $user) {
      return $this->canView($user);
    } // canDownload
    
    /**
    * Empty implementation of abstract methods. Messages determine does user have
    * permissions to add comment
    *
    * @param void
    * @return null
    */
    function canAdd(User $user, Project $project) {
		if($user->isAdministrator())
			return true;
		if($user->getProjectPermission($project, ProjectUsers::CAN_MANAGE_EVENTS ))
  			return true;
  		return false;
    } // canAdd
    
    /**
    * Check if specific user can edit this Event
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      
      if(!$this->canManage(logged_user())) {
        return false; // user don't have access to this project or can't manage Events
      } // if
      if($user->isAdministrator()) {
        return true; // give access to admin
      } // if
      if($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // reserved only for members of owner company
      } // if
      return true;
    } // canEdit
    
    /**
    * Returns true if $user can update Event options
    *
    * @param User $user
    * @return boolean
    */
    function canUpdateOptions(User $user) {
      return $this->canEdit($user) && $user->isMemberOfOwnerCompany();
    } // canUpdateOptions
    
    /**
    * Check if specific user can delete this comment
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if($user->isAdministrator()) {
        return true;
      } // if
      if( $user->getProjectPermission($this->getProject(), ProjectUsers::CAN_MANAGE_EVENTS ))
      	return true;

      return ObjectUserPermissions::userCanWrite($user->getId(),$this);
    } // canDelete
    
    // ---------------------------------------------------
    //  System
    // ---------------------------------------------------

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
      return $this->getSubject();
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('Event');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getDetailsurl();
    } // getObjectUrl
        
    /**
    * Return parent project
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if(is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    
    /**
    * Return Event type object
    *
    * @param void
    * @return EventType
    */
/*    function getEventType() {
    	//$this->getEventType();
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectEventRevision ? $revision->getEventType() : null;
    } // getEventType
*/
    
    // ---------------------------------------------------
    //  Revision interface
    // ---------------------------------------------------
    
    /**
    * Return Event type ID
    *
    * @param void
    * @return integer
    */
  /*  function getEventTypeId() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectEventRevision ? $revision->getEventTypeId() : null;
    } // getEventTypeId
 */   
    /**
    * Return type string. We need to know mime type when forwarding Event 
    * to the client
    *
    * @param void
    * @return string
    */
 /*/   function getTypeString() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectEventRevision ? $revision->getTypeString() : null;
    } // getTypeString
 */   
    /**
    * Return Event size in bytes
    *
    * @param void
    * @return integer
    */
  } // projectEvent 

?>