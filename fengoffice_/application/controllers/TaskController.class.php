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
	// function index() {
	//   } // index


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
		$type = array_var($_GET,'type');
		$user = array_var($_GET,'user');

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
		$result = $this->getTasksAndMilestones($page, config_option('files_per_page'), $tag, null, null, $type);
		if (!$result) $result = array();
		$total_items = $this->countTasksAndMilestones($tag, $type);

		/* prepare response object */
		$object = array(
			"totalCount" => $total_items,
			"objects" => $result
		);
		ajx_extra_data($object);
		tpl_assign("listing", $object);
	}

	/**
	 * View task lists page
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function view_list() {
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

		if(active_project()){
			$open=active_project()->getOpenTasks();
			$comp=active_project()->getCompletedTasks();
		}
		else{
			$projects=active_projects();
			foreach ($projects as $p){
				$open[] = $p->getOpenTasks();
				$comp[] = $p->getCompletedTasks();
			}
		}
		// Sidebar
		tpl_assign('open_task_lists', $open);
		tpl_assign('completed_task_lists', $comp);
		$this->setSidebar(get_template_path('index_sidebar', 'task'));
	} // view_list

	/**
	 * Add new task list
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_list() {
		$project = active_or_personal_project();
		if(!ProjectTask::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$task_list = new ProjectTask();
		$task_list_data = array_var($_POST, 'task_list');
		if(!is_array($task_list_data)) {
			$task_list_data = array(
          'milestone_id' => array_var($_GET, 'milestone_id')
			); // array
		} // if

		tpl_assign('task_list_data', $task_list_data);
		tpl_assign('task_list', $task_list);

		if(is_array(array_var($_POST, 'task_list'))) {

			$task_list->setFromAttributes($task_list_data);
			$task_list->setProjectId($project->getId());
			if(!logged_user()->isMemberOfOwnerCompany()) $task_list->setIsPrivate(false);
			//Add tasks
			$tasks = array();
			for($i = 0; $i < 6; $i++) {
				if(isset($task_list_data["task$i"]) && is_array($task_list_data["task$i"]) && (trim(array_var($task_list_data["task$i"], 'text')) <> '')) {
					$assigned_to = explode(':', array_var($task_list_data["task$i"], 'assigned_to', ''));
					$tasks[] = array(
              'text' => array_var($task_list_data["task$i"], 'text'),
              'assigned_to_company_id' => array_var($assigned_to, 0, 0),
              'assigned_to_user_id' => array_var($assigned_to, 1, 0)
					); // array
				} // if
			} // for
			//Add handins
			$handins = array();
			for($i = 0; $i < 4; $i++) {
				if(isset($task_list_data["handin$i"]) && is_array($task_list_data["handin$i"]) && (trim(array_var($task_list_data["handin$i"], 'title')) <> '')) {
					$assigned_to = explode(':', array_var($task_list_data["handin$i"], 'assigned_to', ''));
					$handins[] = array(
              'title' => array_var($task_list_data["handin$i"], 'title'),
              'responsible_company_id' => array_var($assigned_to, 0, 0),
              'responsible_user_id' => array_var($assigned_to, 1, 0)
					); // array
				} // if
			} // for

			try {

				DB::beginWork();
				$task_list->save();
				$task_list->setTagsFromCSV(array_var($task_list_data, 'tags'));

				foreach($tasks as $task_data) {
					$task = new ProjectTask();
					$task->setFromAttributes($task_data);
					$task->setProjectId($project->getId());
					$task_list->attachTask($task);
					$task->save();
				} // foreach
					
				foreach($handins as $handin_data) {
					$handin = new ObjectHandin();
					$handin->setFromAttributes($handin_data);
					$handin->setObjectId($task_list->getId());
					$handin->setObjectManager(get_class($task_list->manager()));
					$handin->save();
				} // foreach

				$task_list->save_properties($task_list_data);
				ApplicationLogs::createLog($task_list, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();

				flash_success(lang('success add task list', $task_list->getTitle()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add_list

	/**
	 * Edit task list
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit_list() {
		$this->setTemplate('add_list');

		$task_list = ProjectTasks::findById(get_id());
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task_list->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$task_list_data = array_var($_POST, 'task_list');
		if(!is_array($task_list_data)) {
			$tag_names = $task_list->getTagNames();
			$task_list_data = array(
          'title' => $task_list->getTitle(),
          'text' => $task_list->getText(),
          'milestone_id' => $task_list->getMilestoneId(),
          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $task_list->isPrivate(),
			); // array
			$handins = ObjectHandins::getAllHandinsByObject($task_list);
			$id = 0;
			if($handins){
				foreach($handins as $handin){
					$task_list_data['handin'.$id] =array(
		              'title' => $handin->getTitle(),
		              'assigned_to' => $handin->getResponsibleCompanyId() . ':' . $handin->getResponsibleUserId()
					); // array
					$id=$id +1;
					if($id>3) break;
				} // foreach
			} // if
		} // if

		tpl_assign('task_list', $task_list);
		tpl_assign('task_list_data', $task_list_data);

		if(is_array(array_var($_POST, 'task_list'))) {
			$old_is_private = $task_list->isPrivate();
			$old_project_id = $task_list->getProjectId();
			$task_list->setFromAttributes($task_list_data);
			if(!logged_user()->isMemberOfOwnerCompany()) $task_list->setIsPrivate($old_is_private);
			//Add handins
			$handins = array();
			for($i = 0; $i < 4; $i++) {
				if(isset($task_list_data["handin$i"]) && is_array($task_list_data["handin$i"]) && (trim(array_var($task_list_data["handin$i"], 'title')) <> '')) {
					$assigned_to = explode(':', array_var($task_list_data["handin$i"], 'assigned_to', ''));
					$handins[] = array(
              'title' => array_var($task_list_data["handin$i"], 'title'),
              'responsible_company_id' => array_var($assigned_to, 0, 0),
              'responsible_user_id' => array_var($assigned_to, 1, 0)
					); // array
				} // if
			} // for
			try {
				DB::beginWork();
				if($task_list_data['project_id'] && $task_list_data['project_id'] != $old_project_id){
					//update projectid for child tasks
					foreach ($task_list->getSubTasks() as $subtask){
						$subtask->setProjectId($task_list_data['project_id']);
						$subtask->save();
					}
				}
				$task_list->save();
				$task_list->setTagsFromCSV(array_var($task_list_data, 'tags'));
		  		$task_list->save_properties($task_list_data);
				ApplicationLogs::createLog($task_list, $task_list->getProject(), ApplicationLogs::ACTION_EDIT);
   
				DB::commit();

				flash_success(lang('success edit task list', $task_list->getTitle()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // edit_list

	/**
	 * Delete task list
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_list() {
		$project=active_or_personal_project();
		$task_list = ProjectTasks::findById(get_id());
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task_list->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {
			DB::beginWork();
			$task_list->delete();
			ApplicationLogs::createLog($task_list, $project, ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete task list', $task_list->getTitle()));
			ajx_current("start");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete task list'));
			ajx_current("empty");
		} // try
	} // delete_list

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
	 * Add single task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_task() {
		$task_list = ProjectTasks::findById(get_id());
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task_list->canAddSubTask(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$back_to_list = array_var($_GET, 'back_to_list');

		$task = new ProjectTask();
		$task_data = array_var($_POST, 'task');

		tpl_assign('task', $task);
		tpl_assign('task_list', $task_list);
		tpl_assign('back_to_list', $back_to_list);
		tpl_assign('task_data', $task_data);

		// Form is submited
		if(is_array($task_data)) {
			$task->setFromAttributes($task_data);

			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));
			$task->setProjectId(active_or_personal_project()->getId());
			$task->setIsPrivate($task_list->getIsPrivate());
			try {

				DB::beginWork();
				$task->save();

				$task->setTagsFromCSV(array_var($task_data, 'tags'));
				$task_list->attachTask($task);
		  $task->save_properties($task_data);
		  ApplicationLogs::createLog($task, active_or_personal_project(), ApplicationLogs::ACTION_ADD);
		  DB::commit();

		  flash_success(lang('success add task'));
		  if($back_to_list) {
		  	$this->redirectToUrl($task_list->getViewUrl());
		  } else {
		  	ajx_current("start");
		  } // if

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try

		} // if
	} // add_task

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
			flash_error(lang('task dnx'));
			ajx_current("empty");
			return;
		} // if

		$task_list = $task->getParent();
		if(!($task_list instanceof ProjectTask)) {
			$task_list = $task;
			ajx_current("empty");
			return ;
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
          'task_list_id' => $task->getParentId(),          
		  'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
          'assigned_to' => $task->getAssignedToCompanyId() . ':' . $task->getAssignedToUserId()
			); // array
		} // if

		tpl_assign('task', $task);
		tpl_assign('task_list', $task_list);
		tpl_assign('task_data', $task_data);

		if(is_array(array_var($_POST, 'task'))) {
			$task->setFromAttributes($task_data);
			$task->setParentId($task_list->getId()); // keep old task list id

			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));

			try {
				DB::beginWork();
				$task->save();

				$task->setTagsFromCSV(array_var($task_data, 'tags'));
				// Move?
				$new_task_list_id = (integer) array_var($task_data, 'task_list_id');
				if($new_task_list_id && ($task->getParentId() <> $new_task_list_id)) {

					// Move!
					$new_task_list = ProjectTasks::findById($new_task_list_id);
					if($new_task_list instanceof ProjectTask) {
						$task_list->detachTask($task, $new_task_list); // detach from old and attach to new list
					} // if

				} // if

		  $task->save_properties($task_data);
		  ApplicationLogs::createLog($task, $task->getProject(), ApplicationLogs::ACTION_EDIT);
		  DB::commit();

		  flash_success(lang('success edit task'));

		  // Redirect to task list. Check if we have updated task list ID first
		  if(isset($new_task_list) && ($new_task_list instanceof ProjectTask)) {
		  	$this->redirectToUrl($new_task_list->getViewUrl());
		  } else {
		  	$this->redirectToUrl($task_list->getViewUrl());
		  } // if

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try

		} // if

	} // edit_task

	/**
	 * Delete specific task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_task() {
		$task = ProjectTasks::findById(get_id());
		if(!($task instanceof ProjectTask)) {
			flash_error(lang('task dnx'));
			ajx_current("empty");
			return;
		} // if

		$task_list = $task->getParent();
		if(!($task_list instanceof ProjectTask)) {
			flash_error('task list dnx');
			ajx_current("empty");
			return;
		} // if

		if(!$task->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {
			DB::beginWork();
			$task->delete();
			ApplicationLogs::createLog($task, $task->getProject() , ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete task'));
			ajx_current("start");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete task'));
			ajx_current("empty");
		} // try
	} // delete_task

	/**
	 * Complete single project task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function complete_task() {
		$task = ProjectTasks::findById(get_id());
		if(!($task instanceof ProjectTask)) {
			flash_error(lang('task dnx'));
			ajx_current("empty");
			return;
		} // if

		$task_list = $task->getParent();
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {
			DB::beginWork();
			$task->completeTask();
			ApplicationLogs::createLog($task, $task->getProject(), ApplicationLogs::ACTION_CLOSE);
			DB::commit();

			flash_success(lang('success complete task'));
			$this->redirectTo('task','view_list',array("id" => $task_list->getId()));
		} catch(Exception $e) {
			flash_error(lang('error complete task'));
			DB::rollback();
			ajx_current("empty");
		} // try
	} // complete_task

	/**
	 * Reopen completed project task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function open_task() {
		$task = ProjectTasks::findById(get_id());
		if(!($task instanceof ProjectTask)) {
			flash_error(lang('task dnx'));
			ajx_current("empty");
			return;
		} // if

		$task_list = $task->getParent();
		if(!($task_list instanceof ProjectTask)) {
			flash_error(lang('task list dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$task->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$redirect_to = array_var($_GET, 'redirect_to');
		if((trim($redirect_to) == '') || !is_valid_url($redirect_to)) {
			$redirect_to = get_referer($task_list->getViewUrl());
		} // if

		try {
			DB::beginWork();
			$task->openTask();
			ApplicationLogs::createLog($task, $task->getProject(), ApplicationLogs::ACTION_OPEN);
			DB::commit();

			flash_success(lang('success open task'));
			$this->redirectTo('task','view_list',array("id" => $task_list->getId()));
		} catch(Exception $e) {
			flash_error(lang('error open task'));
			DB::rollback();
			ajx_current("empty");
		} // try
	} // open_task

	private function getTasksAndMilestones($page, $objects_per_page, $tag=null, $order=null, $order_dir=null){
		///TODO: this method is horrible on performance and should not be here!!!!
		if (active_project()) {
			$proj_ids = active_project()->getId();
		} else {
			$proj_ids = logged_user()->getActiveProjectIdsCSV();
		}
		$proj_ids = ' (' . $proj_ids . ') ';
		$queries = ObjectController::getDashboardObjectQueries($proj_ids,$tag);
		$query = $queries['Tasks'] . " UNION " . $queries['Milestones'];
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
			$manager= $row['object_manager'];
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
	private function countTasksAndMilestones($tag=null, $type) {
		if (active_project()) {
			$proj_ids = active_project()->getId();
		} else {
			$proj_ids = logged_user()->getActiveProjectIdsCSV();
		}
		$proj_ids = ' (' . $proj_ids . ') ';
		$queries = ObjectController::getDashboardObjectQueries($proj_ids,$tag,true);
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