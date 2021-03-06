<?php

/**
 * Administration controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class AdministrationController extends ApplicationController {

	/**
	 * Construct the AdministrationController
	 *
	 * @access public
	 * @param void
	 * @return AdministrationController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');

		// Access permissios
		if(!logged_user()->isCompanyAdmin(owner_company())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
		} // if
	} // __construct

	/**
	 * Show administration index
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function index() {

	} // index

	/**
	 * Show company page
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function company() {
		tpl_assign('company', owner_company());
		ajx_set_no_toolbar(true);
		$this->setTemplate(get_template_path('view_company', 'company'));
	} // company

	/**
	 * Show owner company members
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function members() {
		tpl_assign('company', owner_company());
		tpl_assign('users', Users::findAll(array('order'=>'display_name')));
	} // members

	/**
	 * List all company projects
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function projects() {
		if(can_manage_workspaces(logged_user()))
			tpl_assign('projects', Projects::getAll());
		else
			tpl_assign('projects', logged_user()->getProjects());
	} // projects

	/**
	 * List clients
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function clients() {
		tpl_assign('clients', owner_company()->getClientCompanies());
	} // clients

	/**
	 * List groups
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function groups() {
		tpl_assign('groups', Groups::getAll());
	} // clients

	/**
	 * Show configuration index page
	 *
	 * @param void
	 * @return null
	 */
	function configuration() {
		$this->addHelper('textile');
		tpl_assign('config_categories', ConfigCategories::getAll());
	} // configuration

	/**
	 * List all available administration tools
	 *
	 * @param void
	 * @return null
	 */
	function tools() {
		tpl_assign('tools', AdministrationTools::getAll());
	} // tools

	/**
	 * List all templates
	 *
	 * @param void
	 * @return null
	 */
	function task_templates() {
		tpl_assign('task_templates', ProjectTasks::getAllTaskTemplates());
	} // tools
	
	/**
	 * Lists all workspaces, so the user can select in which ones to use the task template
	 *
	 */
	function assign_task_template_to_ws(){
		$task_template_id=get_id(); 
		$all = WorkspaceTemplates::getWorkspacesByTemplate('ProjectTasks',$task_template_id);
		$workspace_templates_data = null;
		if($all){
			foreach ($all as $one){
				$workspace_templates_data[$one->getId()] = 'true';
			}
		}
		tpl_assign('workspace_templates_data',$workspace_templates_data );		
		tpl_assign('projectsArray', Projects::getProjectsByParent(logged_user()));			
		tpl_assign('task', ProjectTasks::findById($task_template_id));
		$task_template = array_var($_POST,'task_template');
		if(array_var($_POST,'commit')=='commit'){
			try{
				DB::beginWork();
				WorkspaceTemplates::deleteByTemplate($task_template_id,'ProjectTasks');
				foreach ($task_template as $id => $val){
					if( $val == 'checked'){
						$obj = new WorkspaceTemplate();
						$obj->setWorkspaceId($id);
						$obj->setTemplateId($task_template_id);
						$obj->setObjectManager('ProjectTasks');
						$obj->setInludeSubWs(false);
						$obj->save();
					}
				}
				DB::commit();
				flash_success(lang('success assign workspaces'));
				ajx_current("back");
			}
			catch (Exception $exc){
				flash_error(lang('error assign workspace') . $exc->getMessage());
				ajx_current("empty");									
			}
			tpl_assign('task_templates', ProjectTasks::getAllTaskTemplates());
			$this->setTemplate('task_templates');
		}
	}
	/**
	 * Show upgrade page
	 *
	 * @param void
	 * @return null
	 */
	function upgrade() {
		$this->addHelper('textile');

		$version_feed = VersionChecker::check(true);
		if(!($version_feed instanceof VersionsFeed)) {
			flash_error(lang('error check for upgrade'));
			$this->redirectTo('administration', 'upgrade');
		} // if

		tpl_assign('versions_feed', $version_feed);
	} // upgrade

	// ---------------------------------------------------
	//  Tool implementations
	// ---------------------------------------------------

	/**
	 * Render and execute test mailer form
	 *
	 * @param void
	 * @return null
	 */
	function tool_test_email() {
		$tool = AdministrationTools::getByName('test_mail_settings');
		if(!($tool instanceof AdministrationTool)) {
			flash_error(lang('administration tool dnx', 'test_mail_settings'));
			$this->redirectTo('administration', 'tools');
		} // if

		$test_mail_data = array_var($_POST, 'test_mail');

		tpl_assign('tool', $tool);
		tpl_assign('test_mail_data', $test_mail_data);

		if(is_array($test_mail_data)) {
			try {
				$recepient = trim(array_var($test_mail_data, 'recepient'));
				$message = trim(array_var($test_mail_data, 'message'));

				$errors = array();

				if($recepient == '') {
					$errors[] = lang('test mail recipient required');
				} else {
					if(!is_valid_email($recepient)) {
						$errors[] = lang('test mail recipient invalid format');
					} // if
				} // if

				if($message == '') {
					$errors[] = lang('test mail message required');
				} // if

				if(count($errors)) {
					throw new FormSubmissionErrors($errors);
				} // if

				$success = Notifier::sendEmail($recepient, logged_user()->getEmail(), lang('test mail message subject'), $message);
				if($success) {
					flash_success(lang('success test mail settings'));
				} else {
					flash_error(lang('error test mail settings'));
				} // if
				ajx_current("back");
			} catch(Exception $e) {
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // tool_test_email

	/**
	 * Send multiple emails using this simple tool
	 *
	 * @param void
	 * @return null
	 */
	function tool_mass_mailer() {
		$tool = AdministrationTools::getByName('mass_mailer');
		if(!($tool instanceof AdministrationTool)) {
			flash_error(lang('administration tool dnx', 'test_mail_settings'));
			$this->redirectTo('administration', 'tools');
		} // if

		$massmailer_data = array_var($_POST, 'massmailer');

		tpl_assign('tool', $tool);
		tpl_assign('grouped_users', Users::getGroupedByCompany());
		tpl_assign('massmailer_data', $massmailer_data);

		if(is_array($massmailer_data)) {
			try {
				$subject = trim(array_var($massmailer_data, 'subject'));
				$message = trim(array_var($massmailer_data, 'message'));

				$errors = array();

				if($subject == '') {
					$errors[] = lang('massmailer subject required');
				} // if

				if($message == '') {
					$errors[] = lang('massmailer message required');
				} // if

				$users = Users::getAll();
				$recepients = array();
				if(is_array($users)) {
					foreach($users as $user) {
						if(array_var($massmailer_data, 'user_' . $user->getId()) == 'checked') {
							$recepients[] = Notifier::prepareEmailAddress($user->getEmail(), $user->getDisplayName());
						} // if
					} // foreach
				} // if

				if(!count($recepients)) {
					$errors[] = lang('massmailer select recepients');
				} // if

				if(count($errors)) {
					throw new FormSubmissionErrors($errors);
				} // if

				if(Notifier::sendEmail($recepients, Notifier::prepareEmailAddress(logged_user()->getEmail(), logged_user()->getDisplayName()), $subject, $message)) {
					flash_success(lang('success massmail'));
				} else {
					flash_error(lang('error massmail'));
				} // if
				ajx_current("back");
			} catch(Exception $e) {
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // tool_mass_mailer

} // AdministrationController

?>