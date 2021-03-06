<?php

/**
 * User controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class UserController extends ApplicationController {

	/**
	 * Construct the UserController
	 *
	 * @access public
	 * @param void
	 * @return UserController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * User management index
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function index() {

	} // index

	/**
	 * Add user
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add() {
		$this->setTemplate('add_user');

		$company = Companies::findById(get_id('company_id'));
		if(!($company instanceof Company)) {
			flash_error(lang('company dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!User::canAdd(logged_user(), $company)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$user = new User();

		$user_data = array_var($_POST, 'user');
		if(!is_array($user_data)) {
			$user_data = array(
          'password_generator' => 'random',
          'company_id' => $company->getId(),
          'timezone' => $company->getTimezone(),
			); // array
		} // if

		$projects = $company->getProjects();
		$permissions = ProjectUsers::getNameTextArray();

		tpl_assign('user', $user);
		tpl_assign('company', $company);
		tpl_assign('projects', $projects);
		tpl_assign('permissions', $permissions);
		tpl_assign('user_data', $user_data);

		if(is_array(array_var($_POST, 'user'))) {
			$user->setFromAttributes($user_data);
			$user->setCompanyId($company->getId());

			try {
				// Generate random password
				if(array_var($user_data, 'password_generator') == 'random') {
					$password = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);

					// Validate user input
				} else {
					$password = array_var($user_data, 'password');
					if(trim($password) == '') {
						throw new Error(lang('password value required'));
					} // if
					if($password <> array_var($user_data, 'password_a')) {
						throw new Error(lang('passwords dont match'));
					} // if
				} // if
				$user->setPassword($password);

				DB::beginWork();
				$user->save();

				if (array_var($_POST, 'is_admin')) {
					$user->setAsAdministrator();
				}
				
				/* create personal project */
				$project = new Project();
				$project->setName($user->getUsername().'_personal');
				$project->setDescription(lang('files'));
				$project->setCreatedById($user->getId());

				$project->save();
				
				$new_project = $project;


				$user->setPersonalProjectId($project->getId());
				$user->save();

				ApplicationLogs::createLog($user, null, ApplicationLogs::ACTION_ADD);

				$project_user = new ProjectUser();
				$project_user->setProjectId($project->getId());
				$project_user->setUserId($user->getId());
				$project_user->setCreatedById($user->getId());
				$project_user->setAllPermissions(true);

				$project_user->save();
				/* end personal project */

		  if(is_array($projects)) {
		  	foreach($projects as $project) {
		  		if(array_var($user_data, 'project_permissions_' . $project->getId()) == 'checked') {
		  			$relation = new ProjectUser();
		  			$relation->setProjectId($project->getId());
		  			$relation->setUserId($user->getId());

		  			foreach($permissions as $permission => $permission_text) {
		  				$permission_value = array_var($user_data, 'project_permission_' . $project->getId() . '_' . $permission) == 'checked';

		  				$setter = 'set' . Inflector::camelize($permission);
		  				$relation->$setter($permission_value);
		  			} // foreach

		  			$relation->save();
		  		} // if
		  	} // forech
		  } // if

		  DB::commit();
		  if (logged_user()->isProjectUser($new_project)) {
		  	evt_add("workspace added", array(
				"id" => $new_project->getId(),
				"name" => $new_project->getName(),
				"color" => $new_project->getColor()
			));
		  }

		  // Send notification...
		  try {
		  	if(array_var($user_data, 'send_email_notification')) {
		  		Notifier::newUserAccount($user, $password);
		  	} // if
		  } catch(Exception $e) {

		  } // try

		  flash_success(lang('success add user', $user->getDisplayName()));
		  $this->redirectToUrl($company->getViewUrl()); // Translate to profile page

			} catch(Exception $e) {
				DB::rollback();
				ajx_current("empty");
				flash_error($e->getMessage());
			} // try

		} // if

	} // add

	/**
	 * Delete specific user
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete() {
		$user = Users::findById(get_id());
		if(!($user instanceof User)) {
			flash_error(lang('user dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$user->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$project = $user->getPersonalProject();
			$user->delete();
			if ($project instanceof Project) {
				$pid = $project->getId();
				$project->delete();
			}
			ApplicationLogs::createLog($user, null, ApplicationLogs::ACTION_DELETE);
			DB::commit();
			
			evt_add("workspace deleted", array(
				"id" => $pid
		  	));

			flash_success(lang('success delete user', $user->getDisplayName()));

			$this->redirectToUrl($user->getCompany()->getViewUrl());
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete user'));
			ajx_current("empty");
		} // try
	} // delete

	/**
	 * Show user card
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function card() {

		$user = Users::findById(get_id());
		if(!($user instanceof User)) {
			flash_error(lang('user dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!logged_user()->canSeeUser($user)) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('user', $user);
	} // card

} // UserController

?>