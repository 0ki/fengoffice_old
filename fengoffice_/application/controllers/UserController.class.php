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
			//if it is a new contact
			$contact_id = get_id('contact_id');			
			if($contact_id && $contact = Contacts::findById($contact_id)){
				//if it will be created from a contact
				$user_data = array(
					'username' => substr($contact->getFirstname(),0,1) . $contact->getLastname(),
					'display_name' => $contact->getFirstname() . $contact->getLastname(),
					'email' => $contact->getEmail(),
					'contact_id' => $contact->getId(),
					'password_generator' => 'random',
					'company_id' => $company->getId(),
					'timezone' => $contact->getTimezone(),
				); // array
				
			}
			else{
				// if it is new, and created from admin interface
				$user_data = array(
		          'password_generator' => 'random',
		          'company_id' => $company->getId(),
		          'timezone' => $company->getTimezone(),
				); // array
			}
		} // if

		$permissions = ProjectUsers::getNameTextArray();

		tpl_assign('user', $user);
		tpl_assign('company', $company);
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
				
				/* create contact for this user*/
				
				
				if (array_var($user_data, 'create_contact')) {
					$contact = new Contact();
					$contact->setFirstname($user->getDisplayName());
					$contact->setUserId($user->getId());
					$contact->setEmail($user->getEmail());
					$contact->setTimezone($user->getTimezone());
					$contact->setCompanyId($user->getCompanyId());
					$contact->save();
				}
				
				/* create personal project */
				$project = new Project();
				$project->setName($user->getUsername().'_personal');
				$project->setDescription(lang('files'));
				$project->setCreatedById($user->getId());

				$project->save(); //Save to set an ID number
				$project->setP1($project->getId()); //Set ID number to the first project
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

			  	//TODO - Make batch update of these permissions
				$permissionsString = array_var($_POST,'permissions');
				if ($permissionsString && $permissionsString != ''){
					$permissions = json_decode($permissionsString);
				}
			  	if(is_array($permissions)) {
			  		foreach($permissions as $perm){			  			
			  			if(ProjectUser::hasAnyPermissions($perm->pr,$perm->pc)){	
				  			$relation = new ProjectUser();
					  		$relation->setProjectId($perm->wsid);
					  		$relation->setUserId($user->getId());
				  			
					  		$relation->setCheckboxPermissions($perm->pc);
					  		$relation->setRadioPermissions($perm->pr);
					  		$relation->save();
			  			}
			  		}
				  } // if
		
				  // update contact info if user was created from a contact
				  $contact_id = array_var($user_data,'contact_id');
				  if($contact_id && $contact = Contacts::findById($contact_id)){
				  	 if($contact->getUserId()==0){
					  	 $contact->setUserId($user->getId());
					  	 $contact->save();
				  	 }
				  }
				  // End: update contact info if user was created from a contact
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
			  ajx_current("back");

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

			ajx_current("reload");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete user'));
			ajx_current("empty");
		} // try
	} // delete

	/**
	 * Create a contact with the data of a user
	 *
	 */
	function create_contact_from_user(){

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
		
		if($user->getContact()){
			flash_error(lang('user has contact'));
			ajx_current("empty");
			return;			
		}
		
		try{
			DB::beginWork();
			$contact = new Contact();
			$contact->setFirstname($user->getDisplayName());
			$contact->setUserId($user->getId());
			$contact->setEmail($user->getEmail());
			$contact->setTimezone($user->getTimezone());
			$contact->setCompanyId($user->getCompanyId());
			$contact->save();
			DB::commit();
			$this->redirectTo('contact','card',array('id'=>$contact->getId()));
		}
		catch (Exception  $exx){
			flash_error(lang('error add contact from user') . $exx->getMessage());
		}
	}
	
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
		
		$pids = null;
		if (active_project() instanceof Project)
			$pids = active_project()->getAllSubWorkspacesCSV();
		$logs = ApplicationLogs::getOverallLogs(false,false,$pids,15,0,get_id());

		tpl_assign('logs', $logs);
		tpl_assign('user', $user);
		ajx_set_no_toolbar(true);
	} // card

} // UserController

?>