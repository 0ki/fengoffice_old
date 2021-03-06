<?php

/**
 * Message controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class MessageController extends ApplicationController {

	function list_all()
	{
		ajx_current("empty");
		
		// Get all variables from request
		$start = array_var($_GET,'start');
		$limit = config_option('files_per_page');
		if (! $start) {
			$start = 0;
		}
		$tag = array_var($_GET,'tag');
		$action = array_var($_GET,'action');
		$attributes = array(
			"ids" => explode(',', array_var($_GET,'ids')),
			"types" => explode(',', array_var($_GET,'types')),
			"tag" => array_var($_GET,'tagTag'),
			"accountId" => array_var($_GET,'account_id'),
			"viewType" => array_var($_GET,'view_type')
		);
		
		//Resolve actions to perform
		$actionMessage = array();
		if (isset($action)) {
			$actionMessage = $this->resolveAction($action, $attributes);
			if ($actionMessage["errorCode"] == 0) {
				flash_success($actionMessage["errorMessage"]);
			} else {
				flash_error($actionMessage["errorMessage"]);
			}
		} 
		
		// Get all emails and messages to display
		$pid = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($pid);
		$emails = $this->getEmails($action, $tag, $attributes, $project);
		$messages = $this->getMessages($action, $tag, $attributes, $project);
		$totMsg = $this->addMessagesAndEmails($messages, $emails);
		
		// Prepare response object
		$object = $this->prepareObject($totMsg, $start, $limit);
		ajx_extra_data($object);
    	tpl_assign("listing", $object);
	}
	
	/**
	 * Resolve action to perform
	 *
	 * @param string $action
	 * @param array $attributes
	 * @return string $message
	 */
	private function resolveAction($action, $attributes){
		$resultMessage = "";
		$resultCode = 0;
		switch ($action){
			case "delete":
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email) && $email->canDelete(logged_user())){
								try{
									$email->deleteContents();
									DB::beginWork();
									$email->save();
									DB::commit();
									$resultMessage = lang("success delete objects", '');
								} catch(Exception $e){
									DB::rollback();
									$resultMessage .= $e->getMessage();
									$resultCode = $e->getCode();
								}
							};
							break;
							
						case "message":
							$message = ProjectMessages::findById($id);
							if (isset($message) && $message->canDelete(logged_user())){
								try{
									DB::beginWork();
									$message->delete();
									DB::commit();
									$resultMessage = lang("success delete objects", '');
								} catch(Exception $e){
									DB::rollback();
									$resultMessage .= $e->getMessage();
									$resultCode = $e->getCode();
								}
							};
							break;
							
						default:
							$resultMessage = lang("Unimplemented type: '" . $type . "'");// if 
							$resultCode = 2;
							break;
					}; // switch
				}; // for
				break;
						
			case "tag":
				$tag = $attributes["tag"];
				for($i = 0; $i < count($attributes["ids"]); $i++){
					$id = $attributes["ids"][$i];
					$type = $attributes["types"][$i];
					switch ($type){
						case "email":
							$email = MailContents::findById($id);
							if (isset($email) && $email->canEdit(logged_user())){
								Tags::addObjectTag($tag, $email);
								$resultMessage = lang("success tag objects", '');
							};
							break;

						case "message":
							$message = ProjectMessages::findById($id);
							if (isset($message) && $message->canEdit(logged_user())){
								Tags::addObjectTag($tag, $message);
								$resultMessage = lang("success tag objects", '');
							};
							break;

						default:
							$resultMessage = lang("Unimplemented type: '" . $type . "'");// if
							$resultCode = 2;
							break;
					}; // switch
				}; // for
				break;
			case "checkmail":
				$resultCheck = MailController::checkmail();
				$resultMessage = $resultCheck[1];// if 
				$resultCode = $resultCheck[0];
				break;
			
			default:
				$resultMessage = lang("Unimplemented action: '" . $action . "'");// if 
				$resultCode = 2;	
				break;		
		} // switch
		return array("errorMessage" => $resultMessage, "errorCode" => $resultCode);
	}

	
	/**
	 * Adds the messages and emails arrays
	 *
	 * @param array $messages
	 * @param array $emails
	 * @return array
	 */
	private function addMessagesAndEmails($messages, $emails){
		$totCount = 0;
		if (isset($emails)) $totCount = count($emails);
		if (isset($messages)) $totCount += count($messages);
		
		//Order messages and emails by date
		if (!isset($messages))
			$totMsg = $emails;
		else {
			$e = 0;
			$m = 0;
			while (($e + $m) < $totCount){
				if ($e < count($emails))
					if ($m < count($messages))
						if ($emails[$e]->getSentDate() > $messages[$m]->getUpdatedOn()){
							$totMsg[] = $emails[$e];
							$e++;
						} else {
							$totMsg[] = $messages[$m];
							$m++;
						}
					else {
						$totMsg[] = $emails[$e];
						$e++;
					}
				else {
					$totMsg[] = $messages[$m];
					$m++;
				}
			}
		}
		return $totMsg;
	}
	
	/**
	 * Returns a list of emails according to the requested parameters
	 *
	 * @param string $action
	 * @param integer $accountId
	 * @return array
	 */
	private function getEmails($action, $tag, $attributes, $project = null)
	{
		// Return if no emails should be displayed
		if (isset($attributes["viewType"]) && 
			($attributes["viewType"] != "all" && $attributes["viewType"] != "emails" && $attributes["viewType"] != "unclassified"))
			return null;
			
		// Check for accounts
		$accountConditions ="";
		$singleAccount = false;
		if (isset($attributes["accountId"]) && $attributes["accountId"] > 0){ //Single account
			$singleAccount = true;
			$accounts = array();
			$acc = MailAccounts::findById($attributes["accountId"]);
			if ($acc->canView(logged_user()))
				$accounts[] = $acc;
		}
		else																// All user accounts
			$accounts = MailAccounts::findAll(array(
      			'conditions' => '`user_id` = ' . logged_user()->getId()));
		
		if (isset($accounts) && count($accounts) > 0){
			$list = "";
			foreach ($accounts as $acc)
				$list .= "," . $acc->getId();
			$accountConditions = "account_id in (" . substr($list,1) . ")";
		}
		if ($accountConditions == "")
			$accountConditions = "account_id = 0";  //Dummy condition, cannot view any valid accounts but can see project emails
			
			
		// Check for unclassified emails
		if (isset($attributes["viewType"]) && $attributes["viewType"] == "unclassified")
			$classified = "project_id = 0";
		else
			$classified = "'1' = '1'";
			
		
		//Check for tags
		if (!isset($tag) || $tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "mail_contents.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='MailContents' ) > 0 ";
		}
		
		
		//Check for projects (uses accountConditions
		if ($project instanceof Project){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
			
			if ($singleAccount)
				$projectConditions = "($accountConditions AND `project_id` IN ($pids))";
			else
				$projectConditions = logged_user()->isMemberOfOwnerCompany() ?
					"`project_id` IN ($pids)":
					"(($accountConditions AND `project_id` IN ($pids)) OR (`project_id` IN ($pids) AND is_private = 0))";
		} else {
    		$pids = logged_user()->getActiveProjectIdsCSV();
    		
    		if ($singleAccount)
    			$projectConditions = $accountConditions;
    		else
				$projectConditions = logged_user()->isMemberOfOwnerCompany() ?
					"($accountConditions OR `project_id` in ($pids))":
					"($accountConditions OR (`project_id` in ($pids) AND is_private = 0))";
		}
		
		$permissions = ' AND ( ' . permissions_sql_for_listings(MailContents::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id') .')';
	
		return MailContents::findAll(array(
				'conditions' => $projectConditions . " AND " . $tagstr . " AND " . $classified . " AND is_deleted = 0 " . $permissions, 
				'order' => 'sent_date DESC'));
	}
	
	/**
	 * Returns a list of messages according to the requested parameters
	 *
	 * @param string $action
	 * @return array
	 */
	private function getMessages($action, $tag, $attributes, $project = null) {
		if (isset($attributes["viewType"]) && 
			($attributes["viewType"] != "all" && $attributes["viewType"] != "messages"))
			return null;
		
		if ($project instanceof Project){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
			$messageConditions = "`project_id` IN ($pids)";
		} else {
			$proj_ids = logged_user()->getActiveProjectIdsCSV();
			$messageConditions = "`project_id` in ($proj_ids)" ;
		}

		if (!isset($tag) || $tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "project_messages.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectMessages' ) > 0 ";
		}
		
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectMessages::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id') .')';

		return ProjectMessages::findAll(array(
			'conditions' => $messageConditions . " AND " . $tagstr . $permissions,
			'order' => 'updated_on DESC'));
	}
	
	/**
	 * Prepares return object for a list of emails and messages
	 *
	 * @param array $totMsg
	 * @param integer $start
	 * @param integer $limit
	 * @return array
	 */
	private function prepareObject($totMsg, $start, $limit, $attributes = null)
	{
		$object = array(
			"totalCount" => count($totMsg),
			"messages" => array()
		);
		for ($i = $start; $i < $start + $limit; $i++)
		{
			if (isset($totMsg[$i])){
				$msg = $totMsg[$i];
				if ($msg instanceof MailContent){
					$projectName = "";
					if ($msg->getProject() instanceof Project){
						$projectName = $msg->getProject()->getName();
					}
					$text = $msg->getBodyPlain();
					if (strlen($text) > 300)
						$text = substr($text,0,300) . "...";
					$object["messages"][] = array(
					    "id" => $i,
						"object_id" => $msg->getId(),
						"type" => 'email',
						"hasAttachment" => $msg->getHasAttachments(),
						"accountId" => $msg->getAccountId(),
						"accountName" => $msg->getAccount()->getName(),
						"title" => $msg->getSubject(),
						"text" => $text,
						"date" => $msg->getSentDate()->getTimestamp(),
						"projectId" => $msg->getProjectId(),
						"projectName" => $projectName,
						"userId" => $msg->getAccount()->getOwner()->getId(),
						"userName" => $msg->getAccount()->getOwner()->getDisplayName(),
						"tags" => project_object_tags($msg)
					);
				} else if ($msg instanceof ProjectMessage){
					$text = $msg->getText();
					if (strlen($text) > 300)
						$text = substr($text,0,300) . "...";
					$object["messages"][] = array(
					    "id" => $i,
						"object_id" => $msg->getId(),
						"type" => 'message',
						"hasAttachment" => false,
						"accountId" => 0,
						"accountName" => '',
						"title" => $msg->getTitle(),
						"text" => $text,
						"date" => $msg->getUpdatedOn()->getTimestamp(),
						"projectId" => $msg->getProjectId(),
						"projectName" => $msg->getProject()->getName(),
						"userId" => $msg->getCreatedById(),
						"userName" => $msg->getCreatedBy()->getDisplayName(),
						"tags" => project_object_tags($msg)
					);
				}
			}
		}
		return $object;
	}
	
	
	
	/**
	 * Construct the MessageController
	 *
	 * @access public
	 * @param void
	 * @return MessageController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

//	/**
//	 * Return project messages
//	 *
//	 * @access public
//	 * @param void
//	 * @return array
//	 */
//	function index() {
//		$this->addHelper('textile');
//
//		$page = (integer) array_var($_GET, 'page', 1);
//		if($page < 0) $page = 1;
//		if(active_project()){
//			$conditions = logged_user()->isMemberOfOwnerCompany() ?
//			array('`project_id` = ?', active_project()->getId()) :
//			array('`project_id` = ? AND `is_private` = ?', active_project()->getId(), 0);
//		}
//		else{ // all projects selected
//			$ids=logged_user()->getActiveProjectIdsCSV();
//			$ids='('.$ids.')';
//			$conditions = logged_user()->isMemberOfOwnerCompany() ?
//			array('`project_id` in ' . $ids) :
//			array('`project_id` in ' . $ids . ' AND `is_private` = ?', 0);
//		}
//
//		list($messages, $pagination) = ProjectMessages::paginate(
//		array(
//          'conditions' => $conditions,
//          'order' => '`created_on` DESC'
//          ),
//          config_option('messages_per_page', 10),
//          $page
//          ); // paginate
//
//		if(active_project()){
//			$important=active_project()->getImportantMessages();
//		}
//		else{
//			$empty = true;
//			$projs = logged_user()->getActiveProjects();
//			foreach ($projs as $proj){
//				if($empty)				
//					$important = $proj->getImportantMessages();
//				else
//					$important [] = $proj->getImportantMessages();
//			}
//		}
//		tpl_assign('messages', $messages);
//		tpl_assign('messages_pagination', $pagination);
//		tpl_assign('important_messages', $important);
//
//          $this->setSidebar(get_template_path('index_sidebar', 'message'));
//	} // index

	/**
	 * View single message
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function view() {
		$this->addHelper('textile');

		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$message->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('message', $message);
		tpl_assign('subscribers', $message->getSubscribers());

//		$this->setSidebar(get_template_path('view_sidebar', 'message'));
	} // view

	/**
	 * Add message
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add() {
		$this->setTemplate('add_message');
		$message = new ProjectMessage();
		tpl_assign('message', $message);

		if(active_or_personal_project() && !ProjectMessage::canAdd(logged_user(), active_or_personal_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$message_data = array_var($_POST, 'message');
		if(!is_array($message_data)) {
			$message_data = array(); // array
		} // if
		tpl_assign('message_data', $message_data);

		if(is_array(array_var($_POST, 'message'))) {
			$enteredProject = Projects::findById($message_data["project_id"]);
			
			if ($enteredProject instanceof Project)
				if (!ProjectMessage::canAdd(logged_user(), $enteredProject)){
					flash_error(lang('no access permissions'));
					ajx_current("empty");
					return;
				} else {
					$project = $enteredProject;
				}
			else
				$project = active_or_personal_project();
			
			try {
				$uploaded_files = ProjectFiles::handleHelperUploads($project);
			} catch(Exception $e) {
				$uploaded_files = null;
			} // try

			try {
				$message->setFromAttributes($message_data);
				$message->setProjectId($project->getId());

				// Options are reserved only for members of owner company
				if(!logged_user()->isMemberOfOwnerCompany()) {
					$message->setIsPrivate(false);
					$message->setIsImportant(false);
					$message->setCommentsEnabled(true);
					$message->setAnonymousCommentsEnabled(false);
				} // if

				DB::beginWork();
				$message->save();
				$message->subscribeUser(logged_user());
				$message->setTagsFromCSV(array_var($message_data, 'tags'));

				if(is_array($uploaded_files)) {
					foreach($uploaded_files as $uploaded_file) {
						$message->attachFile($uploaded_file);
						$uploaded_file->setIsPrivate($message->isPrivate());
						$uploaded_file->setIsVisible(true);
						$uploaded_file->setExpirationTime(EMPTY_DATETIME);
						$uploaded_file->save();
					} // if
				} // if

				$message->save_properties($message_data);
				ApplicationLogs::createLog($message, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();

				// Try to send notifications but don't break submission in case of an error
				try {
					$notify_people = array();
					$project_companies = $project->getCompanies();
					foreach($project_companies as $project_company) {
						$company_users = $project_company->getUsersOnProject($project);
						if(is_array($company_users)) {
							foreach($company_users as $company_user) {
								if((array_var($message_data, 'notify_company_' . $project_company->getId()) == 'checked') || (array_var($message_data, 'notify_user_' . $company_user->getId()))) {
									$message->subscribeUser($company_user); // subscribe
									$notify_people[] = $company_user;
								} // if
							} // if
						} // if
					} // if

					Notifier::newMessage($message, $notify_people); // send notification email...
				} catch(Exception $e) {

				} // try

				flash_success(lang('success add message', $message->getTitle()));
				ajx_current("start");
				// Error...
			} catch(Exception $e) {
				DB::rollback();

				if(is_array($uploaded_files)) {
					foreach($uploaded_files as $uploaded_file) {
						$uploaded_file->delete();
					} // foreach
				} // if

				$message->setNew(true);
				flash_error($e->getMessage());
				ajx_current("empty");
				
			} // try

		} // if
	} // add

	/**
	 * Edit specific message
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit() {
		$this->setTemplate('add_message');

		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$message->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$message_data = array_var($_POST, 'message');
		if(!is_array($message_data)) {
			$tag_names = $message->getTagNames();
			$message_data = array(
          'milestone_id' => $message->getMilestoneId(),
          'title' => $message->getTitle(),
          'text' => $message->getText(),
          'additional_text' => $message->getAdditionalText(),
          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $message->isPrivate(),
          'is_important' => $message->getIsImportant(),
          'comments_enabled' => $message->getCommentsEnabled(),
          'anonymous_comments_enabled' => $message->getAnonymousCommentsEnabled(),
			); // array
		} // if

		tpl_assign('message', $message);
		tpl_assign('message_data', $message_data);

		if(is_array(array_var($_POST, 'message'))) {
			try {
				$old_is_private = $message->isPrivate();
				$old_is_important = $message->getIsImportant();
				$old_comments_enabled = $message->getCommentsEnabled();
				$old_anonymous_comments_enabled = $message->getAnonymousCommentsEnabled();

				$message->setFromAttributes($message_data);

				// Options are reserved only for members of owner company
				if(!logged_user()->isMemberOfOwnerCompany()) {
					$message->setIsPrivate($old_is_private);
					$message->setIsImportant($old_is_important);
					$message->setCommentsEnabled($old_comments_enabled);
					$message->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
				} // if

				DB::beginWork();
				$message->save();
				$message->setTagsFromCSV(array_var($message_data, 'tags'));

				$message->save_properties($message_data);
				ApplicationLogs::createLog($message, $message->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();

				flash_success(lang('success edit message', $message->getTitle()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // edit

	/**
	 * Update message options. This is execute only function and if we don't have
	 * options in post it will redirect back to the message
	 *
	 * @param void
	 * @return null
	 */
	function update_options() {
		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$message->canUpdateOptions(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$message_data = array_var($_POST, 'message');
		if(is_array(array_var($_POST, 'message'))) {
			try {
				$message->setIsPrivate((boolean) array_var($message_data, 'is_private', $message->isPrivate()));
				$message->setIsImportant((boolean) array_var($message_data, 'is_important', $message->getIsImportant()));
				$message->setCommentsEnabled((boolean) array_var($message_data, 'comments_enabled', $message->getCommentsEnabled()));
				$message->setAnonymousCommentsEnabled((boolean) array_var($message_data, 'anonymous_comments_enabled', $message->getAnonymousCommentsEnabled()));

				DB::beginWork();
				$message->save();				
				$message->save_properties($message_data);
				ApplicationLogs::createLog($message, $message->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();

				flash_success(lang('success edit message', $message->getTitle()));
			} catch(Exception $e) {
				flash_error(lang('error update message options'), $message->getTitle());
			} // try
		} // if
		$this->redirectToUrl($message->getViewUrl());
	} // update_options

	/**
	 * Delete specific message
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete() {
		ajx_current("empty");
		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$message->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$message->delete();
			ApplicationLogs::createLog($message, $message->getProject(), ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success deleted message', $message->getTitle()));
			ajx_current("start");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete message'));
			ajx_current("empty");
		} // try
	} // delete

	// ---------------------------------------------------
	//  Subscriptions
	// ---------------------------------------------------

	/**
	 * Subscribe to message
	 *
	 * @param void
	 * @return null
	 */
	function subscribe() {
		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			$this->redirectTo('message');
		} // if

		if(!$message->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectTo('message');
		} // if

		if($message->subscribeUser(logged_user())) {
			flash_success('success subscribe to message');
		} else {
			flash_error('error subscribe to message');
		} // if
		$this->redirectToUrl($message->getViewUrl());
	} // subscribe

	/**
	 * Unsubscribe from message
	 *
	 * @param void
	 * @return null
	 */
	function unsubscribe() {
		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			$this->redirectTo('message');
		} // if

		if(!$message->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectTo('message');
		} // if

		if($message->unsubscribeUser(logged_user())) {
			flash_success('success unsubscribe to message');
		} else {
			flash_error('error unsubscribe to message');
		} // if
		$this->redirectToUrl($message->getViewUrl());
	} // unsubscribe

	// ---------------------------------------------------
	//  Comments
	// ---------------------------------------------------

	/**
	 * Add comment
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_comment() {
		$message = ProjectMessages::findById(get_id());
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$message->canAddComment(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$comment = new MessageComment();
		$comment_data = array_var($_POST, 'comment');
		tpl_assign('message', $message);
		tpl_assign('comment', $comment);
		tpl_assign('comment_data', $comment_data);

		if(is_array($comment_data)) {
			$comment->setFromAttributes($comment_data);
			$comment->setMessageId($message->getId());
			if(!logged_user()->isMemberOfOwnerCompany()) $comment->setIsPrivate(false);

			try {

				DB::beginWork();
				$comment->save();
				
				$comment->save_properties($comment_data);
				ApplicationLogs::createLog($comment, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();

				// Try to send notification but don't break
				try {
					Notifier::newMessageComment($comment);
				} catch(Exception $e) {

				} // try

				flash_success(lang('success add comment'));
				$this->redirectToUrl($message->getViewUrl());

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try

		} // if

	} // add_comment

	/**
	 * Edit specific comment
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit_comment() {
		$this->setTemplate('add_comment');

		$comment = MessageComments::findById(get_id());
		if(!($comment instanceof MessageComment)) {
			flash_error(lang('comment dnx'));
			ajx_current("empty");
			return;
		} // if

		$message = $comment->getMessage();
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$comment->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$comment_data = array_var($_POST, 'comment');
		if(!is_array($comment_data)) {
			$comment_data = array(
          'text' => $comment->getText(),
          'is_private' => $comment->isPrivate(),
			); // array
		} // if
		tpl_assign('message', $message);
		tpl_assign('comment', $comment);
		tpl_assign('comment_data', $comment_data);

		if(is_array(array_var($_POST, 'comment'))) {
			$old_is_private = $comment->isPrivate();
			$comment->setFromAttributes($comment_data);
			$comment->setMessageId($message->getId());
			if(!logged_user()->isMemberOfOwnerCompany()) $comment->setIsPrivate($old_is_private);

			try {

				DB::beginWork();
				$comment->save();				
				$comment->save_properties($comment_data);
				ApplicationLogs::createLog($comment, $project, ApplicationLogs::ACTION_EDIT);
				DB::commit();

				flash_success(lang('success edit comment'));
				$this->redirectToUrl($message->getViewUrl());

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if

	} // edit_comment

	/**
	 * Delete comment
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_comment() {
		$comment = MessageComments::findById(get_id());
		if(!($comment instanceof MessageComment)) {
			flash_error(lang('comment dnx'));
			ajx_current("empty");
			return;
		} // if

		$message = $comment->getMessage();
		if(!($message instanceof ProjectMessage)) {
			flash_error(lang('message dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$comment->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$comment->delete();
			ApplicationLogs::createLog($comment, $project, ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete comment'));
			$this->redirectToUrl($message->getViewUrl());

		} catch(Exception $e) {
			DB::rollback();
			flash_error($e->getMessage());
			ajx_current("empty");
		} // try

	} // delete_comment

} // MessageController

?>