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
		prepare_company_website_controller($this, 'website');
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
		if(active_project() instanceof Project)
			$task_templates = ProjectTasks::getWorkspaceTaskTemplates(active_project()->getId());
		else 
			$task_templates = array();
		$all_task_templates = ProjectTasks::getAllTaskTemplates();
		$milestone_templates = ProjectMilestones::getProjectMilestones(null, null, 'ASC', null, null, null, null, null, true);
		ajx_unset_current();
		if(!array_var($_GET, "assigned_to") && user_config_option('my tasks is default view')) //if default view 
			$assigned_to_default = logged_user()->getCompany()->getId() . ':' . logged_user()->getId();
		else 
			$assigned_to_default = '0:0';
		tpl_assign('assignedTo', array_var($_GET, "assigned_to", $assigned_to_default));
		tpl_assign('status', array_var($_GET, "status", "pending"));
		tpl_assign('priority', array_var($_GET, "priority", "all"));
		tpl_assign('task_templates', $task_templates);
		tpl_assign('all_task_templates', $all_task_templates);
		tpl_assign('milestone_templates', $milestone_templates);
		ajx_extra_data(array("tasks" => null));
		ajx_extra_data(array("milestones" => null));
		ajx_set_no_toolbar(true);
		ajx_replace(true);
	} // index
	
	function view_tasks() {
		ajx_current("empty");
		
		$project_id = array_var($_GET, 'active_project');
		$project = Projects::findById($project_id);
		$tag = active_tag();
		$parent_id = array_var($_GET, 'parent_id');
		$milestone_id = array_var($_GET, 'milestone_id', null);
		$assigned_by = array_var($_GET, 'assigned_by', '');
		$assigned_to = array_var($_GET, 'assigned_to', '');
		$status = array_var($_GET, 'status', "pending");
		$priority = array_var($_GET, 'priority', "all");
		
		$assigned_to = explode(':', $assigned_to);
		$show_assigned_to_me_as_default = user_config_option('my tasks is default view');
		$to_company = array_var($assigned_to, 0, $show_assigned_to_me_as_default?logged_user()->getCompany()->getId():0);
		$to_user = array_var($assigned_to, 1, $show_assigned_to_me_as_default?logged_user()->getId():0);
		$assigned_by = explode(':', $assigned_by);
		$by_company = array_var($assigned_by, 0, null);
		$by_user = array_var($assigned_by, 1, null);
		
		if ($parent_id == null) {
			// if no parent task is sent, we get all tasks that satisfy the conditions,
			// and show as root tasks those tasks whose parents don't satisfy the conditions 
			$tasks = ProjectTasks::getProjectTasks($project, null, 'ASC', null, $milestone_id, $tag, $to_company, $to_user, $by_user, $status == 'pending', $priority);
			$taskset = array();
			foreach ($tasks as $t) {
				$taskset[$t->getId()] = true;
			}
			$rootTasks = array();
			foreach ($tasks as $t) {
				if ($t->getParentId() == 0) {
					$rootTasks[] = $t;
				} else if (array_key_exists($t->getParentId(), $taskset) && $taskset[$t->getParentId()] !== true) {
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
			$taskItem = $this->task_item($task);
			//$taskItem["milestone"] = 0;
			//if ($milestone_id || $taskItem["milestone"] == 0)
				$ts[] = $taskItem;
		}
		ajx_extra_data(array("tasks" => $ts));
		
		tpl_assign('tasks', $tasks_bottom_complete);
		tpl_assign('project', $project);
		tpl_assign('parentId', $parent_id);
		tpl_assign('milestoneId', $milestone_id);
	}
	
	private function task_item(ProjectTask $task) {
		$isCurrentProject = active_project() instanceof Project && $task->getProject()->getId() == active_project()->getId();
		
		return array(
			"id" => $task->getId(),
			"title" => $task->getObjectName(),
			"parent" => $task->getParentId(),
			"milestone" => $task->getMilestoneId(),
			"assignedTo" => $task->getAssignedTo()? $task->getAssignedToName():'',
			"workspaces" => ($isCurrentProject? '' : $task->getWorkspacesNamesCSV(logged_user()->getActiveProjectIdsCSV())),
			"workspaceids" => ($isCurrentProject? '' : $task->getWorkspacesIdsCSV(logged_user()->getActiveProjectIdsCSV())),
			"workspacecolors" => ($isCurrentProject? '' : $task->getWorkspaceColorsCSV(logged_user()->getActiveProjectIdsCSV())),
			"completed" => $task->isCompleted(),
			"completedBy" => $task->getCompletedByName(),
			"isLate" => $task->isLate(),
			"daysLate" => $task->getLateInDays(),
			"priority" => $task->getPriority(),
			"duedate" => ($task->getDueDate() ? $task->getDueDate()->getTimestamp() : '0'),
			"order" => $task->getOrder()
		);
	}
		
	function quick_add_task() {
		ajx_current("empty");
		$task = new ProjectTask();
		$task_data = array_var($_POST, 'task');
		$parent_id = array_var($task_data, 'parent_id', 0);
		$parent = ProjectTasks::findById($parent_id);
		$project = null;
		if ($parent instanceof ProjectTask) {
			$project = $parent->getProject();
		} else {
			$milestone_id = array_var($task_data,'milestone_id',null);
			if($milestone_id){
				$milestone = ProjectMilestones::findById($milestone_id);
				if($milestone)
					$project =$milestone->getProject();
			}
			if(!$project)
				$project = active_or_personal_project();
		}
		if(!ProjectTask::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			return;
		} // if
		
		if (is_array($task_data)) {
			$task->setFromAttributes($task_data);
			$task->setProjectId($project->getId());
			$task->setOrder(ProjectTasks::maxOrder(array_var($task_data, "parent_id", 0), array_var($task_data, "milestone_id", 0)));
			$task->setPriority(ProjectTasks::PRIORITY_NORMAL);
			// Set assigned to
			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));			
			$task->setIsPrivate(false); // Not used, but defined as not null.
			
			if (array_var($task_data,'is_completed',false) == 'true'){
				$task->setCompletedOn(DateTimeValueLib::now());
				$task->setCompletedById(logged_user()->getId());
			}
			
			try {
				DB::beginWork();
				$task->save();
				if (array_var($task_data,'hours') != '' && array_var($task_data,'hours') > 0){
					$hours = array_var($task_data, 'hours');
					$hours = - $hours;
					
					$timeslot = new Timeslot();
					$dt = DateTimeValueLib::now();
					$dt2 = DateTimeValueLib::now();
					$timeslot->setEndTime($dt);
					$dt2 = $dt2->add('h', $hours);
					$timeslot->setStartTime($dt2);
					$timeslot->setUserId(logged_user()->getId());
					$timeslot->setObjectManager("ProjectTasks");
					$timeslot->setObjectId($task->getId());
					$timeslot->save();
				}
				ApplicationLogs::createLog($task, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();
				// notify asignee
				if(array_var($task_data, 'send_notification')) {
					try {
						Notifier::taskAssigned($task);
					} catch(Exception $e) {
						evt_add("debug", $e->getMessage());
					} // try
				}
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
		$this->addHelper('textile');
		
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
		ajx_extra_data(array("title" => $task_list->getTitle(), 'icon'=>'ico-task'));
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
				'parent_id' => array_var($_GET, 'parent_id', 0),
				'priority' => ProjectTasks::PRIORITY_NORMAL,
				'is_template' => array_var($_GET, "is_template", false)
			); // array
		} // if

		tpl_assign('task_data', $task_data);
		tpl_assign('task', $task);

		if (is_array(array_var($_POST, 'task'))) {
			$proj = Projects::findById(array_var($task_data, 'project_id'));
			if ($proj instanceof Project) {
				$project = $proj;
			}
			// order
			$task->setOrder(ProjectTasks::maxOrder(array_var($task_data, "parent_id", 0), array_var($task_data, "milestone_id", 0)));
			
			if (array_var($_POST, 'use_due_date')) {
				$task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));
			}
			if (array_var($_POST, 'use_start_date')) {
				$task_data['start_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_start_date_month', 1), array_var($_POST, 'task_start_date_day', 1), array_var($_POST, 'task_start_date_year', 1970));
			}
			$task->setFromAttributes($task_data);
			
			$totalMinutes = (array_var($task_data, 'time_estimate_hours') * 60) +
				(array_var($task_data, 'time_estimate_minutes'));
			$task->setTimeEstimate($totalMinutes);
			
			$task->setIsPrivate(false); // Not used, but defined as not null.
			$task->setProjectId($project->getId());
			// Set assigned to
			$assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
			$task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$task->setAssignedToUserId(array_var($assigned_to, 1, 0));
			
			if (array_var($_GET, 'id'))
				$task->setParentId(array_var($_GET, 'id'));
			
			if ($task->getParentId() > 0 && $task->hasChild($task->getParentId())) {
				flash_error(lang('task child of child error'));
				ajx_current("empty");
				return;
			}
			
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
					
				foreach($handins as $handin_data) {
					$handin = new ObjectHandin();
					$handin->setFromAttributes($handin_data);
					$handin->setObjectId($task->getId());
					$handin->setObjectManager(get_class($task->manager()));
					$handin->save();
				} // foreach*/

				$task->save_properties($task_data);
				
				if (array_var($_GET, 'copyId', 0) > 0) {
					// copy remaining stuff from the task with id copyId
					$toCopy = ProjectTasks::findById(array_var($_GET, 'copyId'));
					if ($toCopy instanceof ProjectTask) {
						ProjectTasks::copySubTasks($toCopy, $task, array_var($task_data, 'is_template', false));
					}
				}
				
				ApplicationLogs::createLog($task, $project, ApplicationLogs::ACTION_ADD);
				//Link objects
			    $object_controller = new ObjectController();
			    $object_controller->link_to_new_object($task);
				DB::commit();
				
				// notify email recipients
				if (!$task->getIsTemplate()) {
					try {
						$notify_people = array();
						$project_companies = array();
						$processedCompanies = array();
						$processedUsers = array();
						$validWS = array($task->getProject());
						if (is_array($validWS)) {
							foreach ($validWS as $w) {
								$workspace_companies = $w->getCompanies();
								foreach ($workspace_companies as $c) {
									if (!isset($processedCompanies[$c->getId()])) {
										$processedCompanies[$c->getId()] = true;
										$company_users = $c->getUsersOnProject($w);
										if (is_array($company_users)) {
											foreach ($company_users as $company_user) {
												if (!isset($processedUsers[$company_user->getId()])) {
													$processedUsers[$company_user->getId()] = true;
													if ((array_var($task_data, 'notify_company_' . $w->getId()) == 'checked') || (array_var($task_data, 'notify_user_' . $company_user->getId()))) {
														//$task->subscribeUser($company_user); // subscribe
														$notify_people[] = $company_user;
													} // if
												}
											} // if
										}
									}
								}
							}
						}
					Notifier::newTask($task, $notify_people); // send notification email...
					} catch(Exception $e) {
						evt_add("debug", $e->getMessage());
					} // try
				}
				
				// notify asignee
				if(array_var($task_data, 'send_notification') == 'checked') {
					try {
						Notifier::taskAssigned($task);
					} catch(Exception $e) {
						evt_add("debug", $e->getMessage());
					} // try
				}

				if ($task->getIsTemplate()) {
					flash_success(lang('success add template', $task->getTitle()));
				} else {
					flash_success(lang('success add task list', $task->getTitle()));
				}
				ajx_current("back");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add_task
	
	/**
	 * Copy task
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function copy_task() {
		$project = active_or_personal_project();
		if(!ProjectTask::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$id = get_id();
		$task = ProjectTasks::findById($id);
		if (!$task instanceof ProjectTask) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		$task_data = array(
			'milestone_id' => $task->getMilestoneId(),
			'title' => $task->getIsTemplate() ? $task->getTitle() : lang("copy of", $task->getTitle()),
			'assigned_to' => $task->getAssignedToCompanyId() . ":" . $task->getAssignedToUserId(),
			'parent_id' => $task->getParentId(),
			'priority' => $task->getPriority(),
			'tags' => implode(",", $task->getTagNames()),
			'project_id' => $task->getProjectId(),
			'time_estimate' => $task->getTimeEstimate(),
			'text' => $task->getText(),
			'copyId' => $task->getId(),
		); // array
		if ($task->getStartDate() instanceof DateTimeValue) {
			$task_data['start_date'] = $task->getStartDate()->getTimestamp();
		}
		if ($task->getDueDate() instanceof DateTimeValue) {
			$task_data['due_date'] = $task->getDueDate()->getTimestamp();
		}

		$newtask = new ProjectTask();
		tpl_assign('task_data', $task_data);
		tpl_assign('task', $newtask);
		tpl_assign('base_task', $task);
		$this->setTemplate("add_task");
	} // copy_task
	
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
				'assigned_to' => $task->getAssignedToCompanyId() . ':' . $task->getAssignedToUserId(),
				'priority' => $task->getPriority()
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
			$old_owner = $task->getAssignedTo();
			if (array_var($task_data, 'parent_id') == $task->getId()) {
				flash_error(lang("task own parent error"));
				ajx_current("empty");
				return;
			}
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
			
			$totalMinutes = (array_var($task_data, 'time_estimate_hours') * 60) +
				(array_var($task_data, 'time_estimate_minutes'));
			$task->setTimeEstimate($totalMinutes);
			
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
			
			if ($task->getParentId() > 0 && $task->hasChild($task->getParentId())) {
				flash_error(lang('task child of child error'));
				ajx_current("empty");
				return;
			}
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
   
				try {
					$subtasks = $task->getSubTasks();
					foreach ($subtasks as $sub) {
						if (!$task->getAssignedTo() instanceof ApplicationDataObject) {
							$sub->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
							$sub->setAssignedToUserId(array_var($assigned_to, 1, 0));
						}
					}
				} catch (Exception $e) {
				}
				
				DB::commit();
				
				try {
					$new_owner = $task->getAssignedTo();
					if(array_var($task_data, 'send_notification') == 'checked') {
						if($old_owner instanceof User) {
							// We have a new owner and it is different than old owner
							if($new_owner instanceof User && $new_owner->getId() <> $old_owner->getId()) {
								Notifier::taskAssigned($task);
							}
						} else {
							// We have new owner
							if($new_owner instanceof User) {
								Notifier::taskAssigned($task);
							}
						} // if
					} // if
				} catch(Exception $e) {

				} // try

				flash_success(lang('success edit task list', $task->getTitle()));
				ajx_current("back");

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
			$is_template = $task->getIsTemplate();
			$task->delete();
			ApplicationLogs::createLog($task, $project, ApplicationLogs::ACTION_DELETE);
			DB::commit();

			if ($is_template) {
				flash_success(lang('success delete template', $task->getTitle()));
			} else {
				flash_success(lang('success delete task list', $task->getTitle()));
			}
			if (array_var($_GET, 'quick', false)) {
				ajx_current('empty');
			} else {
				ajx_current('back');
			}
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
			if (array_var($_GET, 'quick', false)) {
				ajx_current("empty");
			} else {
				ajx_current("reload");
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
			if (array_var($_GET, 'quick', false)) {
				ajx_current("empty");
			} else {
				ajx_current("reload");
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
	
	
	/**
	 * Create a new template
	 *
	 */
	function new_template() {
		$project = active_or_personal_project();
		if(!ProjectTask::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$id = get_id();
		$task = ProjectTasks::findById($id);
		if (!$task instanceof ProjectTask) {
			$task_data = array('is_template' => true);
		} else {
			$task_data = array(
				'milestone_id' => $task->getMilestoneId(),
				'title' => $task->getTitle(),
				'assigned_to' => $task->getAssignedToCompanyId() . ":" . $task->getAssignedToUserId(),
				'parent_id' => $task->getParentId(),
				'priority' => $task->getPriority(),
				'tags' => implode(",", $task->getTagNames()),
				'project_id' => $task->getProjectId(),
				'time_estimate' => $task->getTimeEstimate(),
				'text' => $task->getText(),
				'is_template' => true,
				'copyId' => $task->getId(),
			); // array
			if ($task->getStartDate() instanceof DateTimeValue) {
				$task_data['start_date'] = $task->getStartDate()->getTimestamp();
			}
			if ($task->getDueDate() instanceof DateTimeValue) {
				$task_data['due_date'] = $task->getDueDate()->getTimestamp();
			}
		}

		$task = new ProjectTask();
		tpl_assign('task_data', $task_data);
		tpl_assign('task', $task);
		$this->setTemplate("add_task");
	} // new_template

	
	/**
	 * View a message in a printer-friendly format.
	 *
	 */
	function print_view_all() {
		$this->setLayout("html");
		$this->view_tasks();
	} // print_view
} // TaskController

?>