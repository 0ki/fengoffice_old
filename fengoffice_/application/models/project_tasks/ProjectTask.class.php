<?php
 
/**
 * ProjectTask class
 * Generated on Sat, 04 Mar 2006 12:50:11 +0100 by DataObject generation tool
 *
 * @author Ilija Studen <ilija.studen@gmail.com>
 * Modif: Marcos Saiz <marcos.saiz@gmail.com> 24/3/08
 */
class ProjectTask extends BaseProjectTask {
	 
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
	protected $searchable_columns = array('text','title');

	/**
	 * Project task is commentable object
	 *
	 * @var boolean
	 */
	protected $is_commentable = true;
	
	protected $allow_timeslots = true;

	/**
	 * Cached task array
	 *
	 * @var array
	 */
	private $all_tasks;

	/**
	 * Cached open task array
	 *
	 * @var array
	 */
	private $open_tasks;

	/**
	 * Cached completed task array
	 *
	 * @var array
	 */
	private $completed_tasks;

	/**
	 * Cached number of open tasks
	 *
	 * @var integer
	 */
	private $count_all_tasks;

	/**
	 * Cached number of open tasks in this list
	 *
	 * @var integer
	 */
	private $count_open_tasks = null;

	/**
	 * Cached number of completed tasks in this list
	 *
	 * @var integer
	 */
	private $count_completed_tasks = null;

	/**
	 * Cached array of related forms
	 *
	 * @var array
	 */
	private $related_forms;

	/**
	 * Cached completed by reference
	 *
	 * @var User
	 */
	private $completed_by;

	private $milestone;
	
	function getMilestone(){
		if ($this->getMilestoneId() > 0 && !$this->milestone){
			$this->milestone = ProjectMilestones::findById($this->getMilestoneId());
		}
		return $this->milestone;
	}
	
	/**
	 * Return parent task that this task belongs to
	 *
	 * @param void
	 * @return ProjectTask
	 */
	function getParent() {
		if ($this->getParentId()==0) return null;
		$parent = ProjectTasks::findById($this->getParentId());
		return $parent instanceof ProjectTask  ? $parent : null;
	} // getProject
	
	/**
	 * Return the user that last assigned the task
	 *
	 * @access public
	 * @param void
	 * @return User
	 */
	function getAssignedBy() {
		return Users::findById($this->getAssignedById());
	} // getAssignedBy()

	/**
	 * Set the user that last assigned the task
	 *
	 * @access public
	 * @param User $value
	 * @return boolean
	 */
	function setAssignedBy($user) {
		$this->setAssignedById($user->getId());
	}

	/**
	 * Return owner user or company
	 *
	 * @access public
	 * @param void
	 * @return ApplicationDataObject
	 */
	function getAssignedTo() {
		if($this->getAssignedToUserId() > 0) {
			return $this->getAssignedToUser();
		} elseif($this->getAssignedToCompanyId() > 0) {
			return $this->getAssignedToCompany();
		} else {
			return null;
		} // if
	} // getAssignedTo
	
	function getAssignedToName() {
		if($this->getAssignedToUserId() > 0) {
			return $this->getAssignedToUser()->getDisplayName();
		} elseif($this->getAssignedToCompanyId() > 0) {
			return $this->getAssignedToCompany()->getName();
		} else {
			return lang("anyone");
		} // if
	} // getAssignedTo

	/**
	 * Return owner comapny
	 *
	 * @access public
	 * @param void
	 * @return Company
	 */
	function getAssignedToCompany() {
		return Companies::findById($this->getAssignedToCompanyId());
	} // getAssignedToCompany

	/**
	 * Return owner user
	 *
	 * @access public
	 * @param void
	 * @return User
	 */
	function getAssignedToUser() {
		return Users::findById($this->getAssignedToUserId());
	} // getAssignedToUser

	/**
	 * Returns true if this task was not completed
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function isOpen() {
		return !$this->isCompleted();
	} // isOpen

	/**
	 * Returns true if this task is completed
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function isCompleted() {
		return $this->getCompletedOn() instanceof DateTimeValue;
	} // isCompleted

	/**
	 * Check if this task is late
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function isLate() {
		if($this->isCompleted()) return false;
		if(!$this->getDueDate() instanceof DateTimeValue) return false;
		return !$this->isToday() && ($this->getDueDate()->getTimestamp() < time());
	} // isLate
	
	/**
	 * Check if this task is today
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function isToday() {
		$now = DateTimeValueLib::now();
		$due = $this->getDueDate();

		// getDueDate and similar functions can return NULL
		if(!($due instanceof DateTimeValue)) return false;

		return $now->getDay() == $due->getDay() &&
		$now->getMonth() == $due->getMonth() &&
		$now->getYear() == $due->getYear();
	} // isToday
	
	/**
	 * Return number of days that this task is late for
	 *
	 * @access public
	 * @param void
	 * @return integer
	 */
	function getLateInDays() {
		if (!$this->getDueDate() instanceof DateTimeValue) return 0;
		$due_date_start = $this->getDueDate()->beginningOfDay();
		return floor(abs($due_date_start->getTimestamp() - DateTimeValueLib::now()->getTimestamp()) / 86400);
	} // getLateInDays
	
	/**
	 * Returns value of is private flag inehrited from parent task list
	 *
	 * @param void
	 * @return boolean
	 */
	function isPrivate() {
		return $this->getIsPrivate();
	} // isPrivate

	// ---------------------------------------------------
	//  Permissions
	// ---------------------------------------------------

	/**
	 * Check if user have task management permissions for project this list belongs to
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canManage(User $user) {
		return can_write($user,$this);
	} // canManage

	/**
	 * Return true if $user can view this task lists
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canView(User $user) {
		return can_read($user,$this);
	} // canView


	/**
	 * Check if user can add task lists in specific project
	 *
	 * @param User $user
	 * @param Project $project
	 * @return boolean
	 */
	function canAdd(User $user, Project $project) {
		return can_add($user,$project,get_class(ProjectTasks::instance()));
	} // canAdd
	
	/**
	 * Private function to check whether a task is asigned to user or company user
	 *
	 * @param User $user
	 * @return unknown
	 */
	private function isAsignedToUserOrCompany(User $user){
				// Additional check - is this task assigned to this user or its company
		if($this->getAssignedTo() instanceof User) {
			if($user->getId() == $this->getAssignedTo()->getObjectId()) return true;
		} elseif($this->getAssignedTo() instanceof Company) {
			if($user->getCompanyId() == $this->getAssignedTo()->getObjectId()) return true;
		} // if
		return false;
	}
	/**
	 * Check if specific user can update this task
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canEdit(User $user) {
		if(can_write($user,$this)) {
			return true;
		} // if
		if($this->isAsignedToUserOrCompany($user)) {
			return true;
		}
		$task_list = $this->getParent();
		return $task_list instanceof ProjectTask ? $task_list->canEdit($user) : false;
	} // canEdit
	
	/**
	 * Check if specific user can change task status
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canChangeStatus(User $user) {
		return ($this->canEdit($user) || $this->isAsignedToUserOrCompany($user));
	} // canChangeStatus

	/**
	 * Check if specific user can delete this task
	 *
	 * @access public
	 * @param User $user
	 * @return boolean
	 */
	function canDelete(User $user) {
		if (can_delete($user,$this))
			return true;
		$task_list = $this->getParent();
		return $task_list instanceof ProjectTask ? $task_list->canDelete($user) : false;
	} // canDelete

	/**
	 * Check if user can reorder tasks in this list
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canReorderTasks(User $user) {
		return can_write($user,$this);
	} // canReorderTasks


	/**
	 * Check if specific user can add task to this list
	 *
	 * @param User $user
	 * @return boolean
	 */
	function canAddSubTask(User $user) {
		return can_write($user,$this);
	} // canAddTask
	// ---------------------------------------------------
	//  Operations
	// ---------------------------------------------------

	/**
	 * Complete this task and subtasks and check if we need to complete the parent
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function completeTask() {
		$this->setCompletedOn(DateTimeValueLib::now());
		$this->setCompletedById(logged_user()->getId());
		$this->save();

		/*
		 * if this is run then when the user wants to reopen a task
		 * he will have to manually reopen the subtasks
		$tasks = $this->getOpenSubTasks();
		foreach ($tasks as $task) {
			$task->completeTask();
		}*/
		
		/*
		 * this is done in the controller
		$task_list = $this->getParent();
		if(($task_list instanceof ProjectTask) && $task_list->isOpen()) {
			$open_tasks = $task_list->getOpenSubTasks();
			if(empty($open_tasks)) $task_list->complete(DateTimeValueLib::now(), logged_user());
		} // if*/
		ApplicationLogs::createLog($this, $this->getProject(), ApplicationLogs::ACTION_CLOSE);
	} // completeTask

	/**
	 * Open this task and check if we need to reopen list again
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function openTask() {
		$this->setCompletedOn(null);
		$this->setCompletedById(0);
		$this->save();

		/*
		 * this is done in the controller
		$task_list = $this->getParent();
		if(($task_list instanceof ProjectTask) && $task_list->isCompleted()) {
			$open_tasks = $task_list->getOpenSubTasks();
			if(!empty($open_tasks)) $task_list->open();
		} // if*/
		ApplicationLogs::createLog($this, $this->getProject(), ApplicationLogs::ACTION_OPEN);
	} // openTask

	function getRemainingDays(){
		if (is_null($this->getDueDate()))
			return null;
		else{
			$due = $this->getDueDate();
			$date = mktime();
			$nowDays = floor($date/(60*60*24));
			$dueDays = floor($due->getTimestamp()/(60*60*24));
			return $dueDays - $nowDays;
		}
	}
	
	// ---------------------------------------------------
	//  TaskList Operations
	// ---------------------------------------------------

	/**
	 * Add subtask to this list
	 *
	 * @param string $text
	 * @param User $assigned_to_user
	 * @param Company $assigned_to_company
	 * @return ProjectTask
	 * @throws DAOValidationError
	 */
	function addSubTask($text, $assigned_to_user = null, $assigned_to_company = null) {
		$task = new ProjectTask();
		$task->setText($text);

		if($assigned_to_user instanceof User) {
			$task->setAssignedToUserId($assigned_to_user->getId());
			$task->setAssignedToCompanyId($assigned_to_user->getCompanyId());
		} elseif($assigned_to_company instanceof Company) {
			$task->setAssignedToCompanyId($assigned_to_company->getId());
		} // if

		$this->attachTask($task); // this one will save task
		return $task;
	} // addTask

	/**
	 * Attach subtask to thistask
	 *
	 * @param ProjectTask $task
	 * @return null
	 */
	function attachTask(ProjectTask $task) {
		if($task->getParentId() == $this->getId()) return;

		$task->setParentId($this->getId());
		$task->save();

		if($this->isCompleted()) $this->open();
	} // attachTask

	/**
	 * Detach subtask from this task
	 *
	 * @param ProjectTask $task
	 * @param ProjectTaskList $attach_to If you wish you can detach and attach task to
	 *   other list with one save query
	 * @return null
	 */
	function detachTask(ProjectTask $task, $attach_to = null) {
		if($task->getParentId() <> $this->getId()) return;

		if($attach_to instanceof ProjectTask) {
			$attach_to->attachTask($task);
		} else {
			$task->setParentId(0);
			$task->save();
		} // if

		$close = true;
		$open_tasks = $this->getOpenSubTasks();
		if(is_array($open_tasks)) {
			foreach($open_tasks as $open_task) {
				if($open_task->getId() <> $task->getId()) $close = false;
			} // if
		} // if

		if($close) $this->complete(DateTimeValueLib::now(), logged_user());
	} // detachTask

	/**
	 * Complete this task lists
	 *
	 * @access public
	 * @param DateTimeValue $on Completed on
	 * @param User $by Completed by
	 * @return null
	 */
	function complete(DateTimeValue $on, User $by) {
		$this->setCompletedOn($on);
		$this->setCompletedById($by->getId());
		$this->save();
		ApplicationLogs::createLog($this, $this->getProject(), ApplicationLogs::ACTION_CLOSE);
	} // complete

	/**
	 * Open this list
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function open() {
		$this->setCompletedOn(NULL);
		$this->setCompletedById(0);
		$this->save();
		ApplicationLogs::createLog($this, $this->getProject(), ApplicationLogs::ACTION_OPEN);
	} // open

	// ---------------------------------------------------
	//  Related object
	// ---------------------------------------------------

	/**
	 * Return all tasks from this list
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getSubTasks() {
		if(is_null($this->all_tasks)) {
			$this->all_tasks = ProjectTasks::findAll(array(
          'conditions' => '`parent_id` = ' . DB::escape($this->getId()),
          'order' => '`order`, `created_on`'
          )); // findAll
		} // if

		return $this->all_tasks;
	} // getTasks

	/**
	 * Return open tasks
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getOpenSubTasks() {
		if(is_null($this->open_tasks)) {
			$this->open_tasks = ProjectTasks::findAll(array(
          'conditions' => '`parent_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` = ' . DB::escape(EMPTY_DATETIME),
          'order' => '`order`, `created_on`'
          )); // findAll
		} // if

		return $this->open_tasks;
	} // getOpenTasks

	/**
	 * Return completed tasks
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getCompletedSubTasks() {
		if(is_null($this->completed_tasks)) {
			$this->completed_tasks = ProjectTasks::findAll(array(
          'conditions' => '`parent_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` > ' . DB::escape(EMPTY_DATETIME),
          'order' => '`completed_on` DESC'
          )); // findAll
		} // if

		return $this->completed_tasks;
	} // getCompletedTasks

	/**
	 * Return number of all tasks in this list
	 *
	 * @access public
	 * @param void
	 * @return integer
	 */
	function countAllSubTasks() {
		if(is_null($this->count_all_tasks)) {
			if(is_array($this->all_tasks)) {
				$this->count_all_tasks = count($this->all_tasks);
			} else {
				$this->count_all_tasks = ProjectTasks::count('`parent_id` = ' . DB::escape($this->getId()));
			} // if
		} // if
		return $this->count_all_tasks;
	} // countAllTasks

	/**
	 * Return number of open tasks
	 *
	 * @access public
	 * @param void
	 * @return integer
	 */
	function countOpenSubTasks() {
		if(is_null($this->count_open_tasks)) {
			if(is_array($this->open_tasks)) {
				$this->count_open_tasks = count($this->open_tasks);
			} else {
				$this->count_open_tasks = ProjectTasks::count('`parent_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` = ' . DB::escape(EMPTY_DATETIME));
			} // if
		} // if
		return $this->count_open_tasks;
	} // countOpenTasks

	/**
	 * Return number of completed tasks
	 *
	 * @access public
	 * @param void
	 * @return integer
	 */
	function countCompletedSubTasks() {
		if(is_null($this->count_completed_tasks)) {
			if(is_array($this->completed_tasks)) {
				$this->count_completed_tasks = count($this->completed_tasks);
			} else {
				$this->count_completed_tasks = ProjectTasks::count('`parent_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` > ' . DB::escape(EMPTY_DATETIME));
			} // if
		} // if
		return $this->count_completed_tasks;
	} // countCompletedTasks

	/**
	 * Get project forms that are in relation with this task list
	 *
	 * @param void
	 * @return array
	 */
	function getRelatedForms() {
		if(is_null($this->related_forms)) {
			$this->related_forms = ProjectForms::findAll(array(
          'conditions' => '`action` = ' . DB::escape(ProjectForm::ADD_TASK_ACTION) . ' AND `in_object_id` = ' . DB::escape($this->getId()),
          'order' => '`order`'
          )); // findAll
		} // if
		return $this->related_forms;
	} // getRelatedForms

	/**
	 * Return user who completed this task
	 *
	 * @access public
	 * @param void
	 * @return User
	 */
	function getCompletedBy() {
		if(!($this->completed_by instanceof User)) {
			$this->completed_by = Users::findById($this->getCompletedById());
		} // if
		return $this->completed_by;
	} // getCompletedBy

	/**
	 * Return the name of who completed this task
	 *
	 * @access public
	 * @param void
	 * @return User
	 */
	function getCompletedByName() {
		if ($this->isCompleted()){
			if(!($this->completed_by instanceof User)) {
				$this->completed_by = Users::findById($this->getCompletedById());
			} // if
			if ($this->completed_by instanceof User) {
				return $this->completed_by->getDisplayName();
			} else {
				return '';
			}
		} else return '';
	} // getCompletedBy
	

	/**
	 * Return all handins for this task, NOT the ones associated with its subtasks
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getAllTaskHandins(){
		return ObjectHandins::getAllHandinsByObject($this);
	} //getAllTaskHandins


	/**
	 * Return all pending handins for this task, NOT the ones associated with its subtasks
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getPendingTaskHandins(){
		return ObjectHandins::getPendingHandinsByObject($this);
	} //getPendingTaskHandins

	// ---------------------------------------------------
	//  URLs
	// ---------------------------------------------------

	/**
	 * Return edit task URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getEditUrl() {
		return get_url('task', 'edit_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getEditUrl

	/**
	 * Return edit list URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getEditListUrl() {
		return get_url('task', 'edit_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getEditUrl

	/**
	 * Return delete task URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getDeleteUrl() {
		return get_url('task', 'delete_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getDeleteUrl

	/**
	 * Return delete task list URL
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getDeleteListUrl() {
		return get_url('task', 'delete_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getDeleteUrl

	/**
	 * Return comete task URL
	 *
	 * @access public
	 * @param string $redirect_to Redirect to this URL (referer will be used if this URL is not provided)
	 * @return string
	 */
	function getCompleteUrl($redirect_to = null) {
		$params = array(
        'id' => $this->getId()
		); // array

		if(trim($redirect_to)) {
			$params['redirect_to'] = $redirect_to;
		} // if

		return get_url('task', 'complete_task', $params);
	} // getCompleteUrl

	/**
	 * Return open task URL
	 *
	 * @access public
	 * @param string $redirect_to Redirect to this URL (referer will be used if this URL is not provided)
	 * @return string
	 */
	function getOpenUrl($redirect_to = null) {
		$params = array(
        'id' => $this->getId()
		); // array

		if(trim($redirect_to)) {
			$params['redirect_to'] = $redirect_to;
		} // if

		return get_url('task', 'open_task', $params);
	} // getOpenUrl


	/**
	 * Return add task url
	 *
	 * @param boolean $redirect_to_list Redirect back to the list when task is added. If false
	 *   after submission user will be redirected to projects tasks page
	 * @return string
	 */
	function getAddTaskUrl($redirect_to_list = true) {
		$attributes = array('id' => $this->getId(), 'active_project' => $this->getProjectId());
		if($redirect_to_list) {
			$attributes['back_to_list'] = true;
		} // if
		return get_url('task', 'add_task', $attributes);
	} // getAddTaskUrl

	/**
	 * Return reorder tasks URL
	 *
	 * @param boolean $redirect_to_list
	 * @return string
	 */
	function getReorderTasksUrl($redirect_to_list = true) {
		$attributes = array('task_list_id' => $this->getId(), 'active_project' => $this->getProjectId());
		if($redirect_to_list) {
			$attributes['back_to_list'] = true;
		} // if
		return get_url('task', 'reorder_tasks', $attributes);
	} // getReorderTasksUrl
	 
	/**
	 * Return view list URL
	 *
	 * @param void
	 * @return string
	 */
	function getViewUrl() {
		return get_url('task', 'view_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
	} // getViewUrl

	/**
	 * This function will return URL of this specific list on project tasks page
	 *
	 * @param void
	 * @return string
	 */
	function getOverviewUrl() {
		$project = $this->getProject();
		if($project instanceof Project) {
			return $project->getTasksUrl() . '#taskList' . $this->getId();
		} // if
		return '';
	} // getOverviewUrl

	// ---------------------------------------------------
	//  System
	// ---------------------------------------------------

	/**
	 * Validate before save
	 *
	 * @access public
	 * @param array $errors
	 * @return null
	 */
	function validate(&$errors) {
		if(!$this->validatePresenceOf('title')) $errors[] = lang('task title required');
	} // validate

	 
	/**
	 * Delete this task lists
	 *
	 * @access public
	 * @param boolean $delete_childs
	 * @return boolean
	 */
	function delete($delete_childs = true) {
		if($delete_childs)  {
			$this->deleteSubTasks();
			$this->deleteHandins();
		}
		$related_forms = $this->getRelatedForms();
		if(is_array($related_forms)) {
			foreach($related_forms as $related_form) {
				$related_form->setInObjectId(0);
				$related_form->save();
			} // foreach
		} // if
		$task_list = $this->getParent();
		if($task_list instanceof ProjectTask) $task_list->detachTask($this);
		return parent::delete();
	} // delete

	/**
	 * Save this list
	 *
	 * @param void
	 * @return boolean
	 */
	function save() {
		if (!$this->isNew()) {
			$old_me = ProjectTasks::findById($this->getId(), true);
		}
		if ($this->isNew() ||
				$this->getAssignedToCompanyId() != $old_me->getAssignedToCompanyId() ||
				$this->getAssignedToUserId() != $old_me->getAssignedToUserId()) {
			$this->setAssignedBy(logged_user());
			$this->setAssignedOn(DateTimeValueLib::now());
		}
		
		parent::save();

		$tasks = $this->getSubTasks();
		if(is_array($tasks)) {
			$task_ids = array();
			foreach($tasks as $task) {
				$task_ids[] = $task->getId();
			} // if

			if(count($task_ids)) {
				ApplicationLogs::setIsPrivateForType($this->isPrivate(), 'ProjectTasks', $task_ids);
			} // if
		} // if

		return true;
	} // save


	/**
	 * Drop all tasks that are in this list
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function deleteSubTasks() {
		return ProjectTasks::delete(DB::escapeField('parent_id') . ' = ' . DB::escape($this->getId()));
	} // deleteTasks

	/**
	 * Drop all tasks that are in this list
	 *
	 * @access public
	 * @param void
	 * @return boolean
	 */
	function deleteHandins() {
		$q=DB::escapeField('rel_object_id') . ' = ' . DB::escape($this->getId()) . ' AND ' .
		DB::escapeField('rel_object_manager') . ' = ' . DB::escape(get_class($this->manager()));
		return ObjectHandins::delete($q);
	} // deleteTasks

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
	function getObjectName($charLimit = 0) {
		$name = $this->getTitle();
		if (!$name) {
			$name = $this->getText();
		}
		if ($charLimit > 0 && strlen_utf($name) > $charLimit)
			return substr_utf($name, 0, $charLimit) . '...';
		else
			return $name;
	} // getObjectName
	

	/**
	 * Return object type name
	 *
	 * @param void
	 * @return string
	 */
	function getObjectTypeName() {
		return 'task';
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
	 * Return object for task listing
	 *
	 * @return unknown
	 */
	function getDashboardObject(){
    	if($this->getUpdatedBy()){
    		$updated_by_id = $this->getUpdatedBy()->getObjectId();
    		$updated_by_name = $this->getUpdatedByDisplayName();
    		$updated_on=($this->getObjectUpdateTime())?$this->getObjectUpdateTime()->getTimestamp(): lang('n/a');
    	}else {
    		if($this->getCreatedBy())
    			$updated_by_id = $this->getCreatedBy()->getId();
    		else
    			$updated_by_id = lang('n/a');
    		$updated_by_name = $this->getCreatedByDisplayName();
    		$updated_on =($this->getObjectCreationTime())? $this->getObjectCreationTime()->getTimestamp(): lang('n/a');
    	}
    	if ($this instanceof ProjectTask)
    		$parent_id = $this->getParentId();
    	else 
    		$parent_id = $this->getId();
   	
    	return array(
				"id" => $this->getObjectTypeName() . $this->getId(),
				"object_id" => $this->getId(),
				"name" => $this->getObjectName(),
				"type" => $this->getObjectTypeName(),
				"tags" => project_object_tags($this),
				"createdBy" => $this->getCreatedByDisplayName(),// Users::findById($this->getCreatedBy())->getUsername(),
				"createdById" => $this->getCreatedBy()->getId(),
				"dateCreated" => ($this->getObjectCreationTime())?$this->getObjectCreationTime()->getTimestamp():lang('n/a'),
				"updatedBy" => $updated_by_name,
				"updatedById" => $updated_by_id,
				"dateUpdated" => $updated_on,
				"project" => $this->getProject()->getName(),
				"projectId" => $this->getProjectId(),
    			"workspaceColors" => $this->getWorkspaceColorsCSV(),
				"url" => $this->getObjectUrl(),
				"parentId" => $parent_id,
				"status" => "Pending",
				"manager" => get_class($this->manager())
			);
    }

    /**
	 * Returns true if the task has a subtask with id $id.
	 * 
	 * @param integer $id id to look for
	 * @return boolean
	 */
	function hasChild($id) {
		foreach ($this->getSubTasks() as $sub) {
			if ($sub->getId() == $id || $sub->hasChild($id)) {
				return true;
			}
		}
		return false;
	}
    
} // ProjectTask

?>