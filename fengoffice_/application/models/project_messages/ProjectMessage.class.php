<?php

/**
 * ProjectMessage class
 * Generated on Sat, 04 Mar 2006 12:21:44 +0100 by DataObject generation tool
 *
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class ProjectMessage extends BaseProjectMessage {

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
	protected $searchable_columns = array('title', 'text', 'additional_text');

	/**
	 * Messages are commentable
	 *
	 * @var boolean
	 */
	protected $is_commentable = true;

	/**
	 * Message is file container
	 *
	 * @var boolean
	 */
	protected $is_file_container = true;

	/**
	 * Cached array of subscribers
	 *
	 * @var array
	 */
	private $subscribers;

	/**
	 * Cached array of related forms
	 *
	 * @var array
	 */
	private $related_forms;

	// ---------------------------------------------------
	//  Comments
	// ---------------------------------------------------

	/**
	 * Create new comment. This function is used by ProjectForms to post comments
	 * to the messages
	 *
	 * @param string $content
	 * @param boolean $is_private
	 * @return Comment or NULL if we fail to save comment
	 * @throws DAOValidationError
	 */
	function addComment($content, $is_private = false) {
		$comment = new Comment();
		$comment->setText($content);
		$comment->setIsPrivate($is_private);
		return $this->attachComment($comment);
	} // addComment

	/**
	 * Handle on add comment event
	 *
	 * @param Comment $comment
	 * @return null
	 */
	function onAddComment(Comment $comment) {
		try {
			Notifier::newMessageComment($comment);
		} catch(Exception $e) {
			// nothing here, just suppress error...
		} // try
	} // onAddComment

	// ---------------------------------------------------
	//  Subscriptions
	// ---------------------------------------------------

	/**
	 * Return array of subscribers
	 *
	 * @param void
	 * @return array
	 */
	function getSubscribers() {
		if(is_null($this->subscribers)) $this->subscribers = MessageSubscriptions::getUsersByMessage($this);
		return $this->subscribers;
	} // getSubscribers

	/**
	 * Check if specific user is subscriber
	 *
	 * @param User $user
	 * @return boolean
	 */
	function isSubscriber(User $user) {
		$subscription = MessageSubscriptions::findById(array(
        'message_id' => $this->getId(),
        'user_id' => $user->getId()
		)); // findById
		return $subscription instanceof MessageSubscription;
	} // isSubscriber

	/**
	 * Subscribe specific user to this message
	 *
	 * @param User $user
	 * @return boolean
	 */
	function subscribeUser(User $user) {
		if($this->isNew()) {
			throw new Error('Can\'t subscribe user to message that is not saved');
		} // if
		if($this->isSubscriber($user)) {
			return true;
		} // if

		// New subscription
		$subscription = new MessageSubscription();
		$subscription->setMessageId($this->getId());
		$subscription->setUserId($user->getId());
		return $subscription->save();
	} // subscribeUser

	/**
	 * Unsubscribe user
	 *
	 * @param User $user
	 * @return boolean
	 */
	function unsubscribeUser(User $user) {
		$subscription = MessageSubscriptions::findById(array(
        'message_id' => $this->getId(),
        'user_id' => $user->getId()
		)); // findById
		if($subscription instanceof MessageSubscription) {
			return $subscription->delete();
		} else {
			return true;
		} // if
	} // unsubscribeUser

	/**
	 * Clear all message subscriptions
	 *
	 * @param void
	 * @return boolean
	 */
	function clearSubscriptions() {
		return MessageSubscriptions::clearByMessage($this);
	} // clearSubscriptions

	// ---------------------------------------------------
	//  Related forms
	// ---------------------------------------------------

	/**
	 * Get project forms that are in relation with this message
	 *
	 * @param void
	 * @return array
	 */
	function getRelatedForms() {
		if(is_null($this->related_forms)) {
			$this->related_forms = ProjectForms::findAll(array(
          'conditions' => '`action` = ' . DB::escape(ProjectForm::ADD_COMMENT_ACTION) . ' AND `in_object_id` = ' . DB::escape($this->getId()),
          'order' => '`order`'
          )); // findAll
		} // if
		return $this->related_forms;
	} // getRelatedForms

	// ---------------------------------------------------
	//  Permissions
	// ---------------------------------------------------

	/**
	 * Check CAN_MANAGE_MESSAGES permission
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canManage(User $user) {
		can_write($user,$this);
	} // canManage

	/**
	 * Returns true if $user can access this message
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canView(User $user) {
		return can_read($user,$this);
	} // canView

	/**
	 * Check if specific user can add messages to specific project
	 *
	 * @access public
	 * @param User $user
	 * @param Project $project
	 * @return booelean
	 */
	function canAdd(User $user, Project $project) {
		return can_add($user,$project,get_class(ProjectMessages::instance()));
	} // canAdd

	/**
	 * Check if specific user can edit this messages
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canEdit(User $user) {		
		return can_write($user,$this);
	} // canEdit

	/**
	 * Check if $user can update message options
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canUpdateOptions(User $user) {
		return can_write($user,$this);
	} // canUpdateOptions

	/**
	 * Check if specific user can delete this messages
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canDelete(User $user) {
		return can_delete($user,$this);
	} // canDelete

	/**
	 * Check if specific user can comment this message
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function canAddComment(User $user) {
		return can_write($user,$this);
	} // canAddComment

	// ---------------------------------------------------
	//  URLS
	// ---------------------------------------------------

	/**
	 * Return view message URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getViewUrl() {
		return get_url('message', 'view', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getViewUrl

	/**
	 * Return edit message URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getEditUrl() {
		return get_url('message', 'edit', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getEditUrl

	/**
	 * Return update options URL
	 *
	 * @param void
	 * @return string
	 */
	function getUpdateOptionsUrl() {
		return get_url('message', 'update_options', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getUpdateOptionsUrl

	/**
	 * Return delete message URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getDeleteUrl() {
		return get_url('message', 'delete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getDeleteUrl

	/**
	 * Return add comment URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getAddCommentUrl() {
		return get_url('message', 'add_comment', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getAddCommentUrl

	/**
	 * Return subscribe URL
	 *
	 * @param void
	 * @return boolean
	 */
	function getSubscribeUrl() {
		return get_url('message', 'subscribe', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getSubscribeUrl

	/**
	 * Return unsubscribe URL
	 *
	 * @param void
	 * @return boolean
	 */
	function getUnsubscribeUrl() {
		return get_url('message', 'unsubscribe', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getUnsubscribeUrl

	// ---------------------------------------------------
	//  System
	// ---------------------------------------------------

	/**
	 * Delete this object
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function delete() {
		$comments = $this->getComments();
		if(is_array($comments)) foreach($comments as $comment) $comment->delete();

		$related_forms = $this->getRelatedForms();
		if(is_array($related_forms)) {
			foreach($related_forms as $related_form) {
				$related_form->setInObjectId(0);
				$related_form->save();
			} // foreach
		} // if
		$this->clearSubscriptions();
		return parent::delete();
	} // delete

	/**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return null
	 */
	function validate(&$errors) {
		if($this->validatePresenceOf('title')) {
			if(!$this->validateUniquenessOf('title', 'project_id')) $errors[] = lang('message title unique');
		} else {
			$errors[] = lang('message title required');
		} // if
		if(!$this->validatePresenceOf('text')) $errors[] = lang('message text required');
	} // validate

	// ---------------------------------------------------
	//  Override ApplicationDataObject methods
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
		return 'message';
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

} // ProjectMessage

?>