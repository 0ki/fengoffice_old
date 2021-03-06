<?php

/**
 * Access login, used for handling login / logout requests
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class AccessController extends ApplicationController {

	/**
	 * Construct controller
	 *
	 * @param void
	 * @return null
	 */
	function __construct() {
		parent::__construct();

		$this->setLayout('dialog');
		$this->addHelper('form', 'breadcrumbs', 'pageactions', 'tabbednavigation', 'company_website', 'project_website');
	} // __construct

	/**
	 * Show and process login form
	 *
	 * @param void
	 * @return null
	 */
	function login() {
		$this->addHelper('form');

		if(function_exists('logged_user') && (logged_user() instanceof User)) {
			$this->redirectTo('dashboard');
		} // if

		$login_data = array_var($_POST, 'login');
		if(!is_array($login_data)) {
			$login_data = array();
			foreach($_GET as $k => $v) {
				if(str_starts_with($k, 'ref_')) $login_data[$k] = $v;
			} // foreach
		} // if

		tpl_assign('login_data', $login_data);

		if(is_array(array_var($_POST, 'login'))) {
			$username = array_var($login_data, 'username');
			$password = array_var($login_data, 'password');
			$remember = array_var($login_data, 'remember') == 'checked';

			if(trim($username == '')) {
				tpl_assign('error', new Error(lang('username value missing')));
				$this->render();
			} // if

			if(trim($password) == '') {
				tpl_assign('error', new Error(lang('password value missing')));
				$this->render();
			} // if

			$user = Users::getByUsername($username, owner_company());
			if(!($user instanceof User)) {
				tpl_assign('error', new Error(lang('invalid login data')));
				$this->render();
			} // if

			if(!$user->isValidPassword($password)) {
				tpl_assign('error', new Error(lang('invalid login data')));
				$this->render();
			} // if

			try {
				CompanyWebsite::instance()->logUserIn($user, $remember);
			} catch(Exception $e) {
				tpl_assign('error', new Error(lang('invalid login data')));
				$this->render();
			} // try

			$ref_controller = null;
			$ref_action = null;
			$ref_params = array();

			foreach($login_data as $k => $v) {
				if(str_starts_with($k, 'ref_')) {
					$ref_var_name = trim(substr($k, 4, strlen($k)));
					switch ($ref_var_name) {
						case 'c':
							$ref_controller = $v;
							break;
						case 'a':
							$ref_action = $v;
							break;
						default:
							$ref_params[$ref_var_name] = $v;
					} // switch
				} // if
			} // if
			if(!count($ref_params)) $ref_params = null;

			if($ref_controller && $ref_action) {
				$this->redirectTo($ref_controller, $ref_action, $ref_params);
			} else {
				$this->redirectTo('dashboard');
			} // if
		} // if
	} // login

	/**
	 * Log user back in
	 *
	 * @access public
	 * @param void
	 * @return null
	*/
	function relogin() {
		ajx_current("empty");
		if (function_exists('logged_user') && (logged_user() instanceof User)) {
			flash_success(lang("already logged in"));
			return;
		} // if

		$login_data = array_var($_POST, 'login');
		if (!is_array($login_data)) {
			$login_data = array();
		} // if
		$username = array_var($login_data, 'username');
		$password = array_var($login_data, 'password');
		$remember = array_var($login_data, 'remember', '') != '';

		if (trim($username == '')) {
			flash_error(lang("username value missing"));
			return;
		} // if

		if (trim($password) == '') {
			flash_error(lang("password value missing"));
			return;
		} // if

		$user = Users::getByUsername($username, owner_company());
		if (!($user instanceof User)) {
			flash_error(lang('invalid login data'));
			return;
		} // if

		if (!$user->isValidPassword($password)) {
			flash_error(lang('invalid login data'));
			return;
		} // if

		try {
			CompanyWebsite::instance()->logUserIn($user, $remember);
		} catch(Exception $e) {
			flash_error(lang('invalid login data'));
			return;
		} // try
		
	} // relogin
	
	/**
	 * Log user out
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function logout() {
		CompanyWebsite::instance()->logUserOut();
		$this->redirectTo('access', 'login');
	} // logout

	/**
	 * Render and process forgot password form
	 *
	 * @param void
	 * @return null
	 */
	function forgot_password() {
		$your_email = trim(array_var($_POST, 'your_email'));
		tpl_assign('your_email', $your_email);

		if(array_var($_POST, 'submited') == 'submited') {
			if(!is_valid_email($your_email)) {
				tpl_assign('error', new InvalidEmailAddressError($your_email, lang('invalid email address')));
				$this->render();
			} // if

			$user = Users::getByEmail($your_email);
			if(!($user instanceof User)) {
				flash_error(lang('email address not in use', $your_email));
				$this->redirectTo('access', 'forgot_password');
			} // if

			try {
				Notifier::forgotPassword($user);
				flash_success(lang('success forgot password'));
			} catch(Exception $e) {
				flash_error(lang('error forgot password'));
			} // try

			$this->redirectTo('access', 'forgot_password');
		} // if
	} // forgot_password

	/**
	 * Finish the installation - create owner company and administrator
	 *
	 * @param void
	 * @return null
	 */
	function complete_installation() {
		if(Companies::getOwnerCompany() instanceof Company) {
			die('Owner company already exists'); // Somebody is trying to access this method even if the user already exists
		} // if

		$form_data = array_var($_POST, 'form');
		tpl_assign('form_data', $form_data);

		if(array_var($form_data, 'submited') == 'submited') {
			try {
				$admin_password = trim(array_var($form_data, 'admin_password'));
				$admin_password_a = trim(array_var($form_data, 'admin_password_a'));

				if(trim($admin_password) == '') {
					throw new Error(lang('password value required'));
				} // if

				if($admin_password <> $admin_password_a) {
					throw new Error(lang('passwords dont match'));
				} // if

				DB::beginWork();

				Users::delete(); // clear users table
				Companies::delete(); // clear companies table

				// Create the administrator user
				$administrator = new User();
				$administrator->setId(1);
				$administrator->setCompanyId(1);
				$administrator->setUsername(array_var($form_data, 'admin_username'));
				$administrator->setEmail(array_var($form_data, 'admin_email'));
				$administrator->setPassword($admin_password);
				$administrator->setCanEditCompanyData(true);
				$administrator->setCanManageConfiguration(true);
				$administrator->setCanManageSecurity(true);
				$administrator->setCanManageWorkspaces(true);
				$administrator->setCanManageContacts(true);
				$administrator->setAutoAssign(false);
				$administrator->setPersonalProjectId(1);

				$administrator->save();

				$group = new Group();
				$group->setName('administrators');
				$group->setAllPermissions(true);
				$group->setId(Group::CONST_ADMIN_GROUP_ID );
				
				$group->save();
				
				$group_user = new GroupUser();
				$group_user->setGroupId(Group::CONST_ADMIN_GROUP_ID);
				$group_user->setUserId($administrator->getId());
				
				$group_user->save();
				
				$project = new Project();
				$project->setId(1);
				$project->setP1(1);
				$project->setName($administrator->getUsername().'_personal');
				$project->setDescription(lang('files'));
				$project->setCreatedById($administrator->getId());
		
				$project->save();
		
				$project_user = new ProjectUser();
				$project_user->setProjectId($project->getId());
				$project_user->setUserId($administrator->getId());
				$project_user->setCreatedById($administrator->getId());
				$project_user->setAllPermissions(true);
		
				$project_user->save();
		
				// Create a company
				$company = new Company();
				$company->setId(1);
				$company->setClientOfId(0);
				$company->setName(array_var($form_data, 'company_name'));
				$company->setCreatedById(1);

				$company->save();

				DB::commit();

				$this->redirectTo('access', 'login');
			} catch(Exception $e) {
				tpl_assign('error', $e);
				DB::rollback();
			} // try
		} // if
	} // complete_installation

	
	function get_javascript_translation() {
		$filenames = get_files("./language/" . Localization::instance()->getLocale(), "js");
		$content = "/* inicio */\n";
		foreach ($filenames as $f) {
			$content .= "\n/* $f */\n";
			$content .= "try {";				
			$content .= file_get_contents($f);
			$content .= "} catch (e) {}";
		}
		$content .= "\n/* fin */\n";
		$this->setLayout("json");
		$this->renderText($content, true);
	}
	
} // AccessController

?>