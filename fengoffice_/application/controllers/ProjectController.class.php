<?php

/**
 * Projec controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class ProjectController extends ApplicationController {

	/**
	 * Prepare this controller
	 *
	 * @param void
	 * @return ProjectController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * Call overview action
	 *
	 * @param void
	 * @return null
	 */
	function index() {
		$this->forward('overview');
	} // index

	/**
	 * Show project overview
	 *
	 * @param void
	 * @return null
	 */
	function overview() {
		if(!logged_user()->isProjectUser(active_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$this->addHelper('textile');

		$project = active_project();

		tpl_assign('project_log_entries', $project->getProjectLog(
		config_option('project_logs_per_page', 20)
		));
		tpl_assign('late_milestones', $project->getLateMilestones());
		tpl_assign('today_milestones', $project->getTodayMilestones());
		tpl_assign('upcoming_milestones', $project->getUpcomingMilestones());

		// Sidebar
		tpl_assign('visible_forms', $project->getVisibleForms(true));
		tpl_assign('project_companies', $project->getCompanies());
		tpl_assign('important_messages', active_project()->getImportantMessages());
		tpl_assign('important_files', active_project()->getImportantFiles());

		$this->setSidebar(get_template_path('overview_sidebar', 'project'));
	} // overview

	/**
	 * Execute search
	 *
	 * @param void
	 * @return null
	 */
	function search() {
		$timeBegin = microtime(true);
		if(active_project() && !logged_user()->isProjectUser(active_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$search_for = array_var($_GET, 'search_for');
		$page = (integer) array_var($_GET, 'page', 1);
		if($page < 1) $page = 1;

		if(trim($search_for) == '') {
			$search_results = null;
			$pagination = null;
		} else {
			if(active_project())
				$projects = active_project()->getId();
			else 
				$projects = logged_user()->getActiveProjectIdsCSV();
			list($search_results, $pagination) = SearchableObjects::searchPaginated($search_for, $projects, logged_user()->isMemberOfOwnerCompany());
		} // if
		$timeEnd = microtime(true);

		tpl_assign('search_string', $search_for);
		tpl_assign('current_page', $page);
		tpl_assign('search_results', $search_results);
		tpl_assign('pagination', $pagination);
		tpl_assign('time', $timeEnd - $timeBegin);

//		tpl_assign('tag_names', active_project()->getTagNames());
//		$this->setSidebar(get_template_path('search_sidebar', 'project'));
	} // search

	/**
	 * Show tags page
	 *
	 * @param void
	 * @return null
	 */
	function tags() {
		if(!logged_user()->isProjectUser(active_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('tag_names', active_project()->getTagNames());
	} // tags

	/**
	 * List all companies and users involved in this project
	 *
	 * @param void
	 * @return null
	 */
	function people() {
		$project=active_or_personal_project();
		if(!logged_user()->isProjectUser($project)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('project_companies', $project->getCompanies());
	} // people

	/**
	 * Show permission update form
	 *
	 * @param void
	 * @return null
	 */
	function permissions() {
		$project = active_or_personal_project();
		if(!$project->canChangePermissions(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('project_users', $project->getUsers(false));
		tpl_assign('project_companies', $project->getCompanies());
		tpl_assign('user_projects', logged_user()->getProjects());

		$permissions = ProjectUsers::getNameTextArray();
		tpl_assign('permissions', $permissions);

		$companies = array(owner_company());
		$clients = owner_company()->getClientCompanies();
		if(is_array($clients)) {
			$companies = array_merge($companies, $clients);
		} // if
		tpl_assign('companies', $companies);

		if(array_var($_POST, 'process') == 'process') {
			try {
				DB::beginWork();

				$project->clearCompanies();
				$project->clearUsers();

				$companies = array(owner_company());
				$client_companies = owner_company()->getClientCompanies();
				if(is_array($client_companies)) {
					$companies = array_merge($companies, $client_companies);
				} // if

				foreach($companies as $company) {

					// Company is selected!
					if(array_var($_POST, 'project_company_' . $company->getId()) == 'checked') {

						// Owner company is automaticly included so it does not need to be in project_companies table
						if(!$company->isOwner()) {
							$project_company = new ProjectCompany();
							$project_company->setProjectId($project->getId());
							$project_company->setCompanyId($company->getId());
							$project_company->save();
						} // if

						$users = $company->getUsers();
						if(is_array($users)) {
							$counter = 0;
							foreach($users as $user) {
								$user_id = $user->getId();
								$counter++;
								if(array_var($_POST, "project_user_$user_id") == 'checked') {

									$project_user = new ProjectUser();
									$project_user->setProjectId($project->getId());
									$project_user->setUserId($user_id);

									foreach($permissions as $permission => $permission_text) {

										// Owner company members have all permissions
										$permission_value = $company->isOwner() ? true : array_var($_POST, 'project_user_' . $user_id . '_' . $permission) == 'checked';

										$setter = 'set' . Inflector::camelize($permission);
										$project_user->$setter($permission_value);

									} // if

									$project_user->save();

								} // if

							} // foreach
						} // if
					} // if
				} // foreach

				DB::commit();

				flash_success(lang('success update project permissions'));
				$this->redirectTo('project', 'people', array('active_project'=>$project->getId()));
			} catch(Exception $e) {
				DB::rollback();
				flash_error(lang('error update project permissions'));
				$this->redirectTo('project', 'permissions');
			} // try
		} // if
	} // permissions

	/**
	 * Add project
	 *
	 * @param void
	 * @return null
	 */
	function add() {
		$this->setTemplate('add_project');

		if(!Project::canAdd(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$project = new Project();
		$project_data = array_var($_POST, 'project');
		$projects = logged_user()->getActiveProjects();
		
		tpl_assign('project', $project);
		tpl_assign('projects', $projects);
		tpl_assign('project_data', $project_data);
		
		/* <permissions> */
		if ($project->canChangePermissions(logged_user())) {
			tpl_assign('project_users', $project->getUsers(false));
			tpl_assign('project_companies', $project->getCompanies());
			tpl_assign('user_projects', logged_user()->getProjects());

			$permissions = ProjectUsers::getNameTextArray();
			tpl_assign('permissions', $permissions);

			$companies = array(owner_company());
			$clients = owner_company()->getClientCompanies();
			if (is_array($clients)) {
				$companies = array_merge($companies, $clients);
			} // if
			tpl_assign('companies', $companies);
		} // if
		/* </permissions> */

		// Submited...
		if(is_array($project_data)) {
			$project->setFromAttributes($project_data);

			try {
				DB::beginWork();
				$project->save();

				$permission_columns = ProjectUsers::getPermissionColumns();
				$auto_assign_users = owner_company()->getAutoAssignUsers();

				// We are getting the list of auto assign users. If current user is not in the list
				// add it. He's creating the project after all...
				if(is_array($auto_assign_users)) {
					$auto_assign_logged_user = false;
					foreach($auto_assign_users as $user) {
						if($user->getId() == logged_user()->getId()) $auto_assign_logged_user = true;
					} // if
					if(!$auto_assign_logged_user) $auto_assign_users[] = logged_user();
				} else {
					$auto_assign_users[] = logged_user();
				} // if

				$project->clearUsers();
				foreach($auto_assign_users as $user) {
					$project_user = new ProjectUser();
					$project_user->setProjectId($project->getId());
					$project_user->setUserId($user->getId());
					if(is_array($permission_columns)) {
						foreach($permission_columns as $permission) $project_user->setColumnValue($permission, true);
					} // if
					$project_user->save();
				} // foreach

				/* <permissions> */
				$project->clearCompanies();

				$companies = array(owner_company());
				$client_companies = owner_company()->getClientCompanies();
				if(is_array($client_companies)) {
					$companies = array_merge($companies, $client_companies);
				} // if

				foreach($companies as $company) {

					// Company is selected!
					if(array_var($_POST, 'project_company_' . $company->getId()) == 'checked') {

						// Owner company is automaticly included so it does not need to be in project_companies table
						if(!$company->isOwner()) {
							$project_company = new ProjectCompany();
							$project_company->setProjectId($project->getId());
							$project_company->setCompanyId($company->getId());
							$project_company->save();
						} // if

						$users = $company->getUsers();
						if(is_array($users)) {
							$counter = 0;
							foreach($users as $user) {
								$continue = true;
								foreach ($auto_assign_users as $already_added_user){
									if($user->getId() == $already_added_user->getId()){
										$continue= false;
									}
								}
								if($continue){
									$user_id = $user->getId();
									$counter++;
									if(array_var($_POST, "project_user_$user_id") == 'checked') {
	
										$project_user = new ProjectUser();
										$project_user->setProjectId($project->getId());
										$project_user->setUserId($user_id);
	
										foreach($permissions as $permission => $permission_text) {
	
											// Owner company members have all permissions
											$permission_value = $company->isOwner() ? true : array_var($_POST, 'project_user_' . $user_id . '_' . $permission) == 'checked';
	
											$setter = 'set' . Inflector::camelize($permission);
											$project_user->$setter($permission_value);
	
										} // if	
										$project_user->save();	
									} // if
								}
							} // foreach
						} // if
					} // if
				} // foreach
				/* </permissions> */
				
				ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_ADD, false, true);
				DB::commit();
				
				evt_add("workspace added", array(
					"id" => $project->getId(),
					"name" => $project->getName(),
					"color" => $project->getColor(),
					"parent" => $project->getParentId()
				));

				flash_success(lang('success add project', $project->getName()));
				ajx_current("start");
				return;

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add

	/**
	 * Edit project
	 *
	 * @param void
	 * @return null
	 */
	function edit() {
		$this->setTemplate('add_project');

		$project = Projects::findById(get_id());
		if(!($project instanceof Project)) {
			flash_error(lang('project dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$project->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$project_data = array_var($_POST, 'project');
		if(!is_array($project_data)) {
			$project_data = array(
				'name' => $project->getName(),
				'description' => $project->getDescription(),
				'show_description_in_overview' => $project->getShowDescriptionInOverview(),
				'color' => 0
			); // array
		} // if
		$projects = logged_user()->getActiveProjects();
		
		tpl_assign('project', $project);
		tpl_assign('projects', $projects);
		tpl_assign('project_data', $project_data);
		
		/* <permissions> */
		if ($project->canChangePermissions(logged_user())) {
			tpl_assign('project_users', $project->getUsers(false));
			tpl_assign('project_companies', $project->getCompanies());
			tpl_assign('user_projects', logged_user()->getProjects());

			$permissions = ProjectUsers::getNameTextArray();
			tpl_assign('permissions', $permissions);

			$companies = array(owner_company());
			$clients = owner_company()->getClientCompanies();
			if (is_array($clients)) {
				$companies = array_merge($companies, $clients);
			} // if
			tpl_assign('companies', $companies);
		} // if
		/* </permissions> */

		if(is_array(array_var($_POST, 'project'))) {
			$project->setFromAttributes($project_data);

			try {
				DB::beginWork();
				$project->save();
				
				/* <permissions> */
				$project->clearCompanies();
				$project->clearUsers();

				$companies = array(owner_company());
				$client_companies = owner_company()->getClientCompanies();
				if(is_array($client_companies)) {
					$companies = array_merge($companies, $client_companies);
				} // if

				foreach($companies as $company) {

					// Company is selected!
					if(array_var($_POST, 'project_company_' . $company->getId()) == 'checked') {

						// Owner company is automaticly included so it does not need to be in project_companies table
						if(!$company->isOwner()) {
							$project_company = new ProjectCompany();
							$project_company->setProjectId($project->getId());
							$project_company->setCompanyId($company->getId());
							$project_company->save();
						} // if

						$users = $company->getUsers();
						if(is_array($users)) {
							$counter = 0;
							foreach($users as $user) {
								$user_id = $user->getId();
								$counter++;
								if(array_var($_POST, "project_user_$user_id") == 'checked') {

									$project_user = new ProjectUser();
									$project_user->setProjectId($project->getId());
									$project_user->setUserId($user_id);

									foreach($permissions as $permission => $permission_text) {

										// Owner company members have all permissions
										$permission_value = $company->isOwner() ? true : array_var($_POST, 'project_user_' . $user_id . '_' . $permission) == 'checked';

										$setter = 'set' . Inflector::camelize($permission);
										$project_user->$setter($permission_value);

									} // if

									$project_user->save();

								} // if

							} // foreach
						} // if
					} // if
				} // foreach
				/* </permissions> */
				
				ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_EDIT, false, true);
				DB::commit();

				evt_add("workspace edited", array(
					"id" => $project->getId(),
					"name" => $project->getName(),
					"color" => $project->getColor(),
					"parent" => $project->getParentId()
				));
				
				flash_success(lang('success edit project', $project->getName()));
				ajx_current("start");
				return;
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // edit

	/**
	 * Delete project
	 *
	 * @param void
	 * @return null
	 */
	function delete() {
		ajx_current("empty");
		$pid = get_id();
		$u = Users::findOne(array("conditions" => "personal_project_id = $pid"));
		if ($u) {
			//flash_error("id: $pid, u: ".$u->getId());
			flash_error(lang('cannot delete personal project'));
			return;
			//$this->redirectTo('administration', 'projects');
		}
		$project = Projects::findById(get_id());
		if(!($project instanceof Project)) {
			flash_error(lang('project dnx'));
				ajx_current("empty");
				return;
			//$this->redirectTo('administration', 'projects');
		} // if

		if(!$project->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			//$this->redirectToReferer(get_url('administration', 'projects'));
		} // if

		try {

			$id = $project->getId();
			$name = $project->getName();
			DB::beginWork();
			$project->delete();
			CompanyWebsite::instance()->setProject(null);
			ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete project', $project->getName()));
			evt_add("workspace deleted", array(
				"id" => $id,
				"name" => $name
			));

		} catch(Exception $e) {
			DB::rollback();
			flash_error($e->getMessage());
		} // try

		//$this->redirectTo('administration', 'projects');
	} // delete

	/**
	 * Complete this project
	 *
	 * @param void
	 * @return null
	 */
	function complete() {

		$project = Projects::findById(get_id());
		if(!($project instanceof Project)) {
			flash_error(lang('project dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$project->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			$project->setCompletedOn(DateTimeValueLib::now());
			$project->setCompletedById(logged_user()->getId());

			DB::beginWork();
			$project->save();
			ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_CLOSE);
			DB::commit();

			flash_success(lang('success complete project', $project->getName()));
			$this->redirectToReferer(get_url('administration', 'projects'));
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error complete project'));
			ajx_current("empty");
		} // try

	} // complete

	/**
	 * Reopen project
	 *
	 * @param void
	 * @return null
	 */
	function open() {
		$project = Projects::findById(get_id());
		if(!($project instanceof Project)) {
			flash_error(lang('project dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$project->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			$project->setCompletedOn(null);
			$project->setCompletedById(0);

			DB::beginWork();
			$project->save();
			ApplicationLogs::createLog($project, null, ApplicationLogs::ACTION_OPEN);
			DB::commit();

			flash_success(lang('success open project', $project->getName()));
			$this->redirectToReferer(get_url('administration', 'projects'));

		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error open project'));
			ajx_current("empty");
		} // try

	} // open

	/**
	 * Remove user from project
	 *
	 * @param void
	 * @return null
	 */
	function remove_user() {
		if(!active_project()->canChangePermissions(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$user = Users::findById(get_id('user_id'));
		if(!($user instanceof User)) {
			flash_error(lang('user dnx'));
			ajx_current("empty");
			return;
		} // if

		if($user->isAccountOwner()) {
			flash_error(lang('user cant be removed from project'));
			ajx_current("empty");
			return;
		} // if

		$project = Projects::findById(get_id('project_id'));
		if(!($project instanceof Project)) {
			flash_error(lang('project dnx'));
			ajx_current("empty");
			return;
		} // if

		$project_user = ProjectUsers::findById(array('project_id' => $project->getId(), 'user_id' => $user->getId()));
		if(!($project_user instanceof ProjectUser)) {
			flash_error(lang('user not on project'));
			ajx_current("empty");
			return;
		} // if

		try {
			$project_user->delete();
			flash_success(lang('success remove user from project'));
			$this->redirectTo('project', 'people');
		} catch(Exception $e) {
			flash_error(lang('error remove user from project'));
			ajx_current("empty");
		} // try

	} // remove_user

	/**
	 * Remove company from project
	 *
	 * @param void
	 * @return null
	 */
	function remove_company() {
		if(!active_project()->canChangePermissions(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$project = Projects::findById(get_id('project_id'));
		if(!($project instanceof Project)) {
			flash_error(lang('project dnx'));
			ajx_current("empty");
			return;
		} // if

		$company = Companies::findById(get_id('company_id'));
		if(!($company instanceof Company)) {
			flash_error(lang('company dnx'));
			ajx_current("empty");
			return;
		} // if

		$project_company = ProjectCompanies::findById(array('project_id' => $project->getId(), 'company_id' => $company->getId()));
		if(!($project_company instanceof ProjectCompany)) {
			flash_error(lang('company not on project'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$project_company->delete();
			$users = ProjectUsers::getCompanyUsersByProject($company, $project);
			if(is_array($users)) {
				foreach($users as $user) {
					$project_user = ProjectUsers::findById(array('project_id' => $project->getId(), 'user_id' => $user->getId()));
					if($project_user instanceof ProjectUser) $project_user->delete();
				} // foreach
			} // if
			DB::commit();

			flash_success(lang('success remove company from project'));
			$this->redirectTo('project', 'people');

		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error remove company from project'));
			ajx_current("empty");
		} // try
	} // remove_company

	/**
	 * Return the list of projects
	 *
	 */
	function list_projects() {
		ajx_current("empty");
		//$this->setLayout("json");
		//$this->setTemplate(get_template_path("json"));
		
		$ps = array();
		$all_projects=array();
		$parent = array_var($_GET, 'parent', 0);
		$all_projects = logged_user()->getWorkspaces(true, $parent);
		if (isset($all_projects)) {
			foreach ($all_projects as $p) {
				$ps[] = array(
					"id" => $p->getId(),
					"name" => $p->getName(),
					"color" => $p->getColor(),
					"parent" => $p->getParentId()
				);
			}
		}
		
		//tpl_assign('object', $ps);
		ajx_extra_data(array('workspaces' => $ps));
	}
	
	function move() {
		ajx_current("empty");
		$id = get_id();
		$to = array_var($_GET, 'to', 0);
		// TODO: check permissions
		$ws = Projects::findById($id);
		$parent = Projects::findById($to);
		if (isset($ws)) {
			if ($to == 0 || isset($parent)) {
				$ws->setParentId($to);
				$ws->save();
				evt_add('workspace_edited', array(
					"is" => $ws->getId(),
					"name" => $ws->getId(),
					"color" => $ws->getId(),
					"parent" => $ws->getParentId()
				));
			}
		}
	}
} // ProjectController

?>