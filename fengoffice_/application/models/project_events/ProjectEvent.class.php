<?php

/**
 * ProjectEvent class
 * Generated on Tue, 04 Jul 2006 06:46:08 +0200 by DataObject generation tool
 *
 * @author Marcos Saiz <marcos.saiz@gmail.com>
 */
class ProjectEvent extends BaseProjectEvent {

	/**
	 * Array of searchable columns
	 *
	 * @var array
	 */
	protected $searchable_columns = array('name', 'description');


	/**
	 * Array of invitated Users
	 *
	 * @var array
	 */
	private $event_invitations;

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
		$user = Contacts::findById($this->getCreatedById());
		if ($user instanceof Contact ) return $user->getUsername();
		else return null;
	}
	
	function getTitle(){
		return $this->getSubject();
	}
	
	function isRepetitive() {
		return $this->getRepeatD() > 0 || $this->getRepeatM() > 0 || $this->getRepeatY() > 0 || $this->getRepeatH() > 0;
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
		return get_url('event','edit',array('id'=> $this->getId() ));
		
		
		//return get_url('event','submitevent',array('id'=> $this->getId() ));
		//antes: return get_url('event','modify',array('id'=> $this->getId() ));
		//ejemplo:http://localhost/fengoffice/index.php?ajax=true&a=modify&id=8&day=02&month=4&year=2008&c=event&_dc=1208295398801
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
		return get_url('event', 'view', array('id' => $this->getId()));
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
		return get_url('event','delete',array('id'=> $this->getId() ));

	} // getDeleteUrl

	
	function getViewUrl() {
		return get_url('event', 'view', array('id' => $this->getId()));
	}
	
	
	// ---------------------------------------------------
	//  Permissions
	// ---------------------------------------------------

	/**
	 * Empty implementation of abstract method. Message determins if user have view access
	 *
	 * @param void
	 * @return boolean
	 */
	function canView(Contact $user) {
		return can_read($user, $this->getMembers(), $this->getObjectTypeId());
	} // canView

	/**
	 * Returns true if user can download this Event
	 *
	 * @param Contact $user
	 * @return boolean
	 */
	function canDownload(Contact $user) {
		return can_read($user, $this->getMembers(), $this->getObjectTypeId());
	} // canDownload
	
	
	function canAdd(Contact $user, $context){
		return can_add($user, $context, ProjectEvents::instance()->getObjectTypeId());
	}


	/**
	 * Check if specific user can edit this Event
	 *
	 * @access public
	 * @param Contact $user
	 * @return boolean
	 */
	function canEdit(Contact $user) {
		return can_write($user, $this->getMembers(), $this->getObjectTypeId());
	} // canEdit


	/**
	 * Check if specific user can delete this comment
	 *
	 * @access public
	 * @param Contact $user
	 * @return boolean
	 */
	function canDelete(Contact $user) {
		return can_delete($user,$this->getMembers(), $this->getObjectTypeId());
	} // canDelete

	// ---------------------------------------------------
	//  System
	// ---------------------------------------------------

	function save() {
		return parent::save();
		
		// update reminders
		$id = $this->getId();
		$sql = "UPDATE `".TABLE_PREFIX."object_reminders` SET
			`date` = date_sub((SELECT `start` FROM `".TABLE_PREFIX."project_events` WHERE `id` = $id), interval `minutes_before` minute) 
			WHERE `object_id` = $id;";
		DB::execute($sql);
	}
	
	function delete() {
		// delete invitations
		$this->clearInvitations();
		parent::delete();
	}
	
	// ---------------------------------------------------
	//  ApplicationDataObject implementation
	// ---------------------------------------------------
	
	function getSubject() {
		return $this->getObjectName();
	}

	/**
	 * Return object URl
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getObjectUrl() {
		return $this->getDetailsUrl();
	} // getObjectUrl
	 
	 /**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return boolean
	 */
	function validate(&$errors) {
		if(!$this->getObject()->validatePresenceOf('name')) $errors[] = lang('event subject required');
		if(!$this->validateMaxValueOf('description',3000)) $errors[] = lang('event description maxlength');
		if(!$this->getObject()->validateMaxValueOf('name', 100)) $errors[] = lang('event subject maxlength');
	} // validate
	
	
	function getInvitations() {
		return $this->event_invitations;
	}
	
	
	function clearInvitations() {
		$this->event_invitations = array();
		EventInvitations::delete(array ('`event_id` = ?', $this->getId()));
	}
	
	
	function addInvitation($inv) {
		if (!is_array($this->event_invitations)) {
			$this->event_invitations = array();
		}
		if (isset($inv)) {
			$this->event_invitations[$inv->getContactId()] = $inv;
		}
	}
	

} // projectEvent

?>