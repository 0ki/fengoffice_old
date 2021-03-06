<?php

/**
 * Controller for handling task list and task related requests
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class TaskController extends ApplicationController {

	/**
	 * Construct the MilestoneController
	 *
	 * @access public
	 * @param void
	 * @return MilestoneController
	 */
	function __construct() {
		parent::__construct();
		if (is_ajax_request()) {
			prepare_company_website_controller($this, 'ajax');
		} else {
			prepare_company_website_controller($this, 'website');
		}
	} // __construct

	/**
	 * Show index page
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function index() {
		$this->view_tasks();
		$mc = new MilestoneController();
		$mc->view_milestones();
		ajx_content_property("current");
		ajx_unset_current();
		tpl_assign('assignedTo', array_var($_GET, "assigned_to", null));
		tpl_assign('status', array_var($_GET, "status", null));
	} // index
	
	function view_tasks() {
		ajx_current("empty");
		
		$project_id = array_var($_GET, 'active_project');
		$project = Projects::findById($project_id);
		$tag = active_tag();
		$parent_id = array_var($_GET, 'parent_id');
		$milestone_id = array_var($_GET, 'milestone_id');
		$assigned_by = array_var($_GET, 'assigned_by', '');
		$assigned_to = array_var($_GET, 'assigned_to', '');
		$status = array_var($_GET, 'status', null);
		
		$assigned_to = explode(':', $assigned_to);
		$to_company = array_var($assigned_to, 0, null);
		$to_user = array_var($assigned_to, 1, null);
		$assigned_by = explode(':', $assigned_by);
		$by_company = array_var($assigned_by, 0, null);
		$by_user = array_var($assigned_by, 1, null);
		
		if ($parent_id == null) {
			// if no parent task is sent, we get all tasks that satisfy the conditions,
			// and show as root tasks those tasks whose parents don't satisfy the conditions 
			$tasks = ProjectTasks::getProjectTasks($project, null, 'ASC', null, $milestone_id, $tag, $to_company, $to_user, $by_user, $status == 'pending');
			$taskset = array();
			foreach ($tasks as $t) {
				$taskset[$t->getId()] = true;
			}
			$rootTasks = array();
			foreach ($tasks as $t) {
				if ($t->getParentId() == 0) {
					$rootTasks[] = $t;
				} else if ($taskset[$t->getParentId()] !== true) {
					$rootTasks[] = $t;
				}
			}
			$tasks = $rootTasks;
		} else {
			// if a parent task is sent, we get all child tasks, filetring only by status
			$tasks = ProjectTasks::getProjectTasks($project, null, 'ASC', $parent_id, $milestone_id, $tag, null, null, $by_user, $status == 'pending');
		}
		
		// sort by status (completed tasks on the bottom)
		$tasks_bottom_complete = array();
		foreach ($tasks as $t) {
			if (!$t->isCompleted()) {
				$tasks_bottom_complete[] = $t;
			}
		}
		foreach ($tasks as $t) {
			if ($t->isCompleted()) {
				$tasks_bottom_complete[] = $t;
			}
		}
		if (!$milestone_id) $milestone_id = 0;

		$ts = array();
		foreach ($tasks_bottom_complete as $task) {
			$ts[] = $this->task_item($task);
		}
		ajx_extra_data(array("tasks" => $ts));
		
		tpl_assign('tasks', $tasks_bottom_complete);
		tpl_assign('project', $project);
		tpl_assign('parentId', $parent_id);
		tpl_assign('milestoneId', $milestone_id);
	}
	
	private function task_item($task) {
		return array(
			"id" => $task->getId(),
			"title" => $task->getObjectName(),
			"parent" => $task->getParentId(),
			"milestone" => $task->getMilestoneId(),
			"assignedTo" => $task->getAssignedToName(),
			"workspaces" => $task->getProject()->getName(),
			"completed" => $task->isCompleted(),
			"completedBy" => $task->getCompletedByName(),
			"isLate" => $task->isLate(),
			"daysLate" => $task->getLateInDays(),
			"order" => $task->getOrder()
		);
	}
	
	private function max_order($parentId = null, $milestoneId = null) {
		$condition = "";
		if (is_numeric($parentId)) {
			if ($condition != "") $condition .= " AND ";
			$condition .= " `parent_id` = " . DB::escape($parentId);
		}
		if (is_numeric($milestoneId)) {
			if ($condition != "") $condition .= " AND ";
			$condition .= " `milestone_id` = " . DB::escape($milestoneId);
		}
		$res = DB::execute("SELECT max(`order`) as `max` FROM `" . TABLE_PREFIX . "project_tasks` " .
				($condition == "" ? "" : " WHERE " . $condition));
		if ($res->numRows() < 1) {
			return 0;
		} else {
			$row = $res->fetchRow();
			return $row["max"] + 1;
		}
	}
	
	function quick_add_task() {
		ajx_current("empty");
		$task = new ProjectTask();
		$task_data = array_var($_POST, 'task');
		$parent_id = array_var($task_data, 'parent_id', 0);
		$parent = ProjectTasks::findById($parent_id);
		if ($parent instanceof ProjectTask) {
			$project = $parent->getProject();
		} else {
			$project = active_or_personal_project();
		}
		if(!ProjectTask::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			return;
		} // if
		
		if (is_array($task_data)) {
			$task->setFromAttributes($task_data);
			$task->setProjectId($project->getId());
			$task->setOrder($this->max_order(array_var($task_data, "parent_id", 0), array_var($task_data, "milestone_id", 0)));
			// Set assigned to
			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));			
			$task->setIsPrivate(false); // Not used, but defined as not null.
			try {
				DB::beginWork();
				$task->save();

				ApplicationLogs::createLog($task, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();

				ajx_extra_data(array("task" => $this->task_item($task)));
				flash_success(lang('success add task list', $task->getTitle()));
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
			} // try
		} // if
	}


	function list_tasks() {
		ajx_current("empty");
			
		/* get query parameters */
		$start = array_var($_GET,'start');
		$limit = array_var($_GET,'limit');
		if (! $start) {
			$start = 0;
		}
		if (! $limit) {
			$limit = config_option('files_per_page');
		}
		$order = array_var($_GET,'sort');
		$orderdir = array_var($_GET,'dir');
		$page = (integer) ($start / $limit) + 1;
		$hide_private = !logged_user()->isMemberOfOwnerCompany();
		$project = array_var($_GET,'active_project');
		$tag = array_var($_GET,'tag');
		$user = array_var($_GET,'user');
		$parent_id = array_var($_GET, 'parent_id', 0);

		/* if there's an action to execute, do so */
		if (array_var($_GET, 'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'objects'));
			list($succ, $err) = ObjectController::do_delete_objects($ids);
			if ($err > 0) {
				flash_error(lang('error delete objects', $err));
			} else {
				flash_success(lang('success delete objects', $succ));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'objects'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = ObjectController::do_tag_object($tagTag, $ids);
			if ($err > 0) {
				flash_error(lang('error tag objects', $err));
			} else {
				flash_success(lang('success tag objects', $succ));
			}
		}
		$result = null;

		/* perform queries according to type*/
		$project_id = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($project_id);
		$result = $this->getTasksAndMilestones($page, config_option('files_per_page'), $tag, null, null, $parent_id, $project);
		if (!$result) $result = array();
		$total_items = $this->countTasksAndMilestones($tag, $type, $project);
	
		/* prepare response object */
		$object = array(
 			"totalCount" => $total_items,
 			"objects" => $result
 		);
		ajx_extra_data($object);
		$this->setTemplate(get_template_path("json"));
		$this->setLayout("json");
		tpl_assign("object", $object);
	}

	/**
	 * View task page
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function view_task() {
		$task_list = ProjectTasks::findById(get_id());
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task_list->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('task_list', $task_list);

		/*if(active_project()){
			$open=active_project()->getOpenTasks();
			$comp=active_project()->getCompletedTasks();
		}
		else{
			$projects=active_projects();
			foreach ($projects as $p){
				$open[] = $p->getOpenTasks();
				$comp[] = $p->getCompletedTasks();
			}
		}*/
		$this->addHelper('textile');
		// Sidebar
		/*tpl_assign('open_task_lists', $open);
		tpl_assign('completed_task_lists', $comp);*/
		ajx_extra_data(array("title" => $task_list->getTitle(), 'icon'=>'ico-task'));
		$this->setSidebar(get_template_path('index_sidebar', 'task'));
		ajx_set_no_toolbar(true);
		$this->setTemplate('view_list');
	} // view_task

	/**
	 * Add new task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_task() {
		$project = active_or_personal_project();
		if(!ProjectTask::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$task = new ProjectTask();
		$task_data = array_var($_POST, 'task');
		if(!is_array($task_data)) {
			$task_data = array(
				'milestone_id' => array_var($_GET, 'milestone_id'),
				'title' => array_var($_GET, 'title', ''),
				'assigned_to' => array_var($_GET, 'assigned_to', '0:0'),
				'parent_id' => array_var($_GET, 'parent_id', 0)
			); // array
		} // if

		tpl_assign('task_data', $task_data);
		tpl_assign('task', $task);

		if (is_array(array_var($_POST, 'task'))) {
			// order
			$task_data["order"] = $this->max_order(array_var($_GET, 'id', 0), 0);
			
			if (array_var($_POST, 'use_due_date')) {
				$task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));
			}
			if (array_var($_POST, 'use_start_date')) {
				$task_data['start_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_start_date_month', 1), array_var($_POST, 'task_start_date_day', 1), array_var($_POST, 'task_start_date_year', 1970));
			}
			$task->setFromAttributes($task_data);
			$task->setIsPrivate(true); // Not used, but defined as not null.
			$task->setProjectId(array_var($task_data, 'project_id'));
			// Set assigned to
			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));
			// project id and is private
			$task->setProjectId($project->getId());
			
			if (array_var($_GET, 'id'))
				$task->setParentId(array_var($_GET, 'id'));
			
			// Add tasks
			$subtasks = array();
			for ($i = 0; $i < 6; $i++) {
				if(isset($task_data["task$i"]) && is_array($task_data["task$i"]) && (trim(array_var($task_data["task$i"], 'title')) <> '')) {
					$assigned_to = explode(':', array_var($task_data["task$i"], 'assigned_to', ''));
					$subtasks[] = array(
						'title' => array_var($task_data["task$i"], 'title'),
						'assigned_to_company_id' => array_var($assigned_to, 0, 0),
						'assigned_to_user_id' => array_var($assigned_to, 1, 0)
					); // array
				} // if
			} // for

			//Add handins
			$handins = array();
			for($i = 0; $i < 4; $i++) {
				if(isset($task_data["handin$i"]) && is_array($task_data["handin$i"]) && (trim(array_var($task_data["handin$i"], 'title')) <> '')) {
					$assigned_to = explode(':', array_var($task_data["handin$i"], 'assigned_to', ''));
					$handins[] = array(
						'title' => array_var($task_data["handin$i"], 'title'),
						'responsible_company_id' => array_var($assigned_to, 0, 0),
						'responsible_user_id' => array_var($assigned_to, 1, 0)
					); // array
				} // if
			} // for

			try {
				DB::beginWork();
				$task->save();
				//echo 'pepe'; DB::rollback(); die();
				$task->setTagsFromCSV(array_var($task_data, 'tags'));

				foreach($subtasks as $subtask_data) {
					$subtask = new ProjectTask();
					$subtask->setFromAttributes($subtask_data);
					$subtask->setProjectId(array_var($subtask_data, 'project_id'));
					$task->attachTask($subtask);
					$subtask->save();
				} // foreach
					
				foreach($handins as $handin_data) {
					$handin = new ObjectHandin();
					$handin->setFromAttributes($handin_data);
					$handin->setObjectId($task->getId());
					$handin->setObjectManager(get_class($task->manager()));
					$handin->save();
				} // foreach*/

				$task->save_properties($task_data);
				ApplicationLogs::createLog($task, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();

				flash_success(lang('success add task list', $task->getTitle()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add_task
	
	function move_down() {
		ajx_current("empty");
		$task_id = get_id();
		$task = ProjectTasks::findById($task_id);
		if (!$task instanceof ProjectTask) {
			flash_error(lang('task dnx'));
			return;
		}
		// get the next sibling task
		$next = ProjectTasks::findOne(array(
			'conditions' => array('`order` >= ? AND `id` <> ? AND `parent_id` = ? AND `milestone_id` = ?', $task->getOrder(), $task->getId(), $task->getParentId(), $task->getMilestoneId()),
			'order' => '`order` ASC'
		));
		if (!$next instanceof ProjectTask) {
			return;
		}
		DB::beginWork();
		try {
			$o = $task->getOrder();
			$new = ($next->getOrder() == $task->getOrder()? $next->getOrder() + 1 : $next->getOrder());
			$task->setOrder($new);
			$next->setOrder($o);
			$task->save();
			$next->save();
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
		}
	}

	/**
	 * Edit task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit_task() {
		$this->setTemplate('add_task');

		$task = ProjectTasks::findById(get_id());
		if(!($task instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$task_data = array_var($_POST, 'task');
		if(!is_array($task_data)) {
			$tag_names = $task->getTagNames();
			$task_data = array(
				'title' => $task->getTitle(),
				'text' => $task->getText(),
				'milestone_id' => $task->getMilestoneId(),
				'use_due_date' => ($task->getDueDate()==EMPTY_DATETIME)?1:false,
				'due_date' => $task->getDueDate(),
				'use_start_date' => ($task->getStartDate()==EMPTY_DATETIME)?1:false,
				'start_date' => $task->getStartDate(),
				'parent_id' => $task->getParentId(),
				'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				'is_private' => $task->isPrivate(),
				'assigned_to' => $task->getAssignedToCompanyId() . ':' . $task->getAssignedToUserId()
			); // array
			$handins = ObjectHandins::getAllHandinsByObject($task);
			$id = 0;
			if($handins){
				foreach($handins as $handin){
					$task_data['handin'.$id] =array(
		              'title' => $handin->getTitle(),
		              'assigned_to' => $handin->getResponsibleCompanyId() . ':' . $handin->getResponsibleUserId()
					); // array
					$id=$id +1;
					if($id>3) break;
				} // foreach
			} // if
		} // if

		tpl_assign('task', $task);
		tpl_assign('task_data', $task_data);

		if(is_array(array_var($_POST, 'task'))) {
			$old_is_private = $task->isPrivate();
			$old_project_id = $task->getProjectId();
			if(array_var($_POST, 'use_start_date'))
				$task_data['start_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_start_date_month', 1), array_var($_POST, 'task_start_date_day', 1), array_var($_POST, 'task_start_date_year', 1970));			
			elseif ($task->getStartDate() != EMPTY_DATETIME)
				$task_data['start_date'] = EMPTY_DATETIME;
			if(array_var($_POST, 'use_due_date'))
				$task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));			
			elseif ($task->getDueDate() != EMPTY_DATETIME)
				$task_data['due_date'] = EMPTY_DATETIME;
			$task->setFromAttributes($task_data);
			// Set assigned to
			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));
			if(!logged_user()->isMemberOfOwnerCompany()) $task->setIsPrivate($old_is_private);
			//Add handins
			$handins = array();
			for($i = 0; $i < 4; $i++) {
				if(isset($task_data["handin$i"]) && is_array($task_data["handin$i"]) && (trim(array_var($task_data["handin$i"], 'title')) <> '')) {
					$assigned_to = explode(':', array_var($task_data["handin$i"], 'assigned_to', ''));
					$handins[] = array(
              'title' => array_var($task_data["handin$i"], 'title'),
              'responsible_company_id' => array_var($assigned_to, 0, 0),
              'responsible_user_id' => array_var($assigned_to, 1, 0)
					); // array
				} // if
			} // for
			try {
				DB::beginWork();
				if($task_data['project_id'] && $task_data['project_id'] != $old_project_id){
					//update projectid for child tasks
					foreach ($task->getSubTasks() as $subtask){
						$subtask->setProjectId(array_var($task_data, 'project_id'));
						$subtask->save();
					}
				}
				$task->save();
				$task->setTagsFromCSV(array_var($task_data, 'tags'));
		  		$task->save_properties($task_data);
				ApplicationLogs::createLog($task, $task->getProject(), ApplicationLogs::ACTION_EDIT);
   
				DB::commit();

				flash_success(lang('success edit task list', $task->getTitle()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // edit_task

	/**
	 * Delete task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_task() {
		ajx_current("empty");
		$project = active_or_personal_project();
		$task = ProjectTasks::findById(get_id());
		if (!($task instanceof ProjectTask)) {
			flash_error(lang('task dnx'));
			return;
		} // if

		if (!$task->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			return;
		} // if

		try {
			DB::beginWork();
			$task->delete();
			ApplicationLogs::createLog($task, $project, ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete task list', $task->getTitle()));
			ajx_current('start');
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete task list'));
		} // try
	} // delete_task

	/**
	 * Show and process reorder tasks form
	 *
	 * @param void
	 * @return null
	 */
	function reorder_tasks() {
		$task_list = ProjectTasks::findById(get_id('task_list_id'));
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		$back_to_list = (boolean) array_var($_GET, 'back_to_list');
		$redirect_to = $back_to_list ? $task_list->getViewUrl() : get_url('task');

		if(!$task_list->canReorderTasks(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$tasks = $task_list->getOpenSubTasks();
		if(!is_array($tasks) || (count($tasks) < 1)) {
			flash_error(lang('no open task in task list'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('task_list', $task_list);
		tpl_assign('tasks', $tasks);
		tpl_assign('back_to_list', $back_to_list);

		if(array_var($_POST, 'submitted') == 'submitted') {
			$updated = 0;
			foreach($tasks as $task) {
				$new_value = (integer) array_var($_POST, 'task_' . $task->getId());
				if($new_value <> $task->getOrder()) {
					$task->setOrder($new_value);
					if($task->save()) {
						$updated++;
					} // if
				} // if
			} // foreach

			flash_success(lang('success n tasks updated', $updated));
			$this->redirectToUrl($redirect_to);
		} // if
	} // reorder_tasks

	// ---------------------------------------------------
	//  Tasks
	// ---------------------------------------------------


	/**
	 * Complete task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function complete_task() {
		ajx_current("empty");
		$task = ProjectTasks::findById(get_id());
		if(!($task instanceof ProjectTask)) {
			flash_error(lang('task dnx'));
			return;
		} // if

		if(!$task->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			return;
		} // if

		try {
			DB::beginWork();
			$task->completeTask();
			ApplicationLogs::createLog($task, $task->getProject(), ApplicationLogs::ACTION_CLOSE);
			
			$completed_tasks = array();
			$parent = $task->getParent();
			while ($parent instanceof ProjectTask && $parent->countOpenSubTasks() <= 0) {
				$parent->completeTask();
				$completed_tasks[] = $parent->getId();
				$milestone = ProjectMilestones::findById($parent->getMilestoneId());
				if ($milestone instanceof ProjectMilestones && $milestone->countOpenTasks() <= 0) {
					$milestone->setCompletedOn(DateTimeValueLib::now());
					ajx_extra_data(array("completedMilestone" => $milestone->getId())); 
				}
				$parent = $parent->getParent();
			}
			ajx_extra_data(array("completedTasks" => $completed_tasks));
			
			DB::commit();

			flash_success(lang('success complete task'));
			
			$redirect_to = array_var($_GET, 'redirect_to', false);
			if ($redirect_to) {
				ajx_current("url", $redirect_to);
			}
			
		} catch(Exception $e) {
			DB::rollback();
			flash_error($e->getMessage());
		} // try
	} // complete_task

	/**
	 * Reopen completed task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function open_task() {
		ajx_current("empty");
		$task = ProjectTasks::findById(get_id());
		if(!($task instanceof ProjectTask)) {
			flash_error(lang('task dnx'));
			return;
		} // if

		if(!$task->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {
			DB::beginWork();
			$task->openTask();
			ApplicationLogs::createLog($task, $task->getProject(), ApplicationLogs::ACTION_OPEN);
			
			$opened_tasks = array();
			$parent = $task->getParent();
			while ($parent instanceof ProjectTask && $parent->isCompleted()) {
				$parent->openTask();
				$opened_tasks[] = $parent->getId();
				$milestone = ProjectMilestones::findById($parent->getMilestoneId());
				if ($milestone instanceof ProjectMilestones && $milestone->isCompleted()) {
					$milestone->setCompletedOn(EMPTY_DATETIME);
					ajx_extra_data(array("openedMilestone" => $milestone->getId())); 
				}
				$parent = $parent->getParent();
			}
			ajx_extra_data(array("openedTasks" => $opened_tasks));
			
			DB::commit();

			flash_success(lang('success open task'));
			
			$redirect_to = array_var($_GET, 'redirect_to', false);
			if ($redirect_to) {
				ajx_current("url", $redirect_to);
			}
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error open task'));
		} // try
	} // open_task

	private function getTasksAndMilestones($page, $objects_per_page, $tag=null, $order=null, $order_dir=null, $parent_task_id = null, $project = null, $tasksAndOrMilestones = 'both'){
		if(!$parent_task_id || !is_numeric($parent_task_id))
			$parent_task_id = 0;
		$parent_string = " AND parent_id = $parent_task_id ";
		$queries = ObjectController::getDashboardObjectQueries($project, $tag);
		if ($tasksAndOrMilestones == 'both') {
			$query = $queries['Tasks'] . $parent_string . " UNION " . $queries['Milestones'];
		} else if ($tasksAndOrMilestones == 'tasks') {
			$query = $queries['Tasks'] . $parent_string;
		} else {
			$query = $queries['Milestones'];
		}
		if ($order) {
			$query .= " order by " . $order . " ";
			if ($order_dir) {
				$query .= " " . $order_dir . " ";
			}
		} else {
			$query .= " order by last_update desc ";
		}
		if ($page && $objects_per_page) {
			$start = ($page-1) * $objects_per_page;
			$query .=  " limit " . $start . "," . $objects_per_page. " ";
		} else if ($objects_per_page) {
			$query .= " limit " . $objects_per_page;
		}

		$res = DB::execute($query);
		$objects = array();
		if (!$res) return $objects;
		$rows = $res->fetchAll();
		if (!$rows) return $objects;
		$i=1;
		foreach ($rows as $row) {
			$manager= $row['object_manager_value'];
			$id = $row['oid'];
			if ($id && $manager) {
				$obj = get_object_by_manager_and_id($id, $manager);
				if ($obj->canView(logged_user())) {
					$dash_object = $obj->getDashboardObject();
					//	$dash_object['id'] = $i++;
					$objects[] = $dash_object;
				}
			} //if($id && $manager)
		}//foreach
		return $objects;
	} //getDashboardobjects

	/**
	 * Counts dashboard objects
	 *
	 * @return unknown
	 */
	private function countTasksAndMilestones($tag=null, $project=null) {
		$queries = ObjectController::getDashboardObjectQueries($project,$tag,true);
		$query = $queries['Tasks'] . " UNION " . $queries['Milestones'];
		$ret = 0;
		$res1 = DB::execute($query);
		if ($res1) {
			$rows = $res1->fetchAll();
			if ($rows) {
				foreach ($rows as $row) {
					if (isset($row['quantity'])) {
						$ret += $row['quantity'];
					}
				}//foreach
			}
		}
		return $ret;
	}

} // TaskController

?>