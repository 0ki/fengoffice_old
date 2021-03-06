<?php

/**
 * Contact controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>,  Marcos Saiz <marcos.saiz@opengoo.org>
 */
class ContactController extends ApplicationController {

	/**
	 * Construct the ContactController
	 *
	 * @access public
	 * @param void
	 * @return ContactController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * Creates a system user, receiving a Contact id
	 *
	 */
	function create_user(){
		$contact = Contacts::findById(get_id());
		if(!($contact instanceof Contact)) {
			flash_error(lang('contact dnx'));
			ajx_current("empty");
			return;
		} // if
		
		if(!can_manage_security(logged_user())){
			flash_error(lang('no permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$company = Companies::findById($contact->getCompanyId());
		if(!($company instanceof Company)) {
			flash_error(lang('company dnx') .'. ' . lang('users must belong to a company'));
			ajx_current("empty");
			return;
		} // if
		$this->redirectTo('user','add',array('company_id' => $company->getId(), 'contact_id' => $contact->getId()));
		
	}
	
	/**
	 * Lists all contacts and clients
	 *
	 */
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
		
		// Get all emails and companies to contacts
		$pid = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($pid);
		$contacts = $this->getContacts($tag, $attributes, $project);
		$companies = array();
		$companies = $this->getCompanies($tag, $attributes, $project);
		$union = $this->addContactsAndCompanies($contacts, $companies);
		
		// Prepare response object
		$object = $this->prepareObject($union, $start, $limit);
		ajx_extra_data($object);
    	tpl_assign("listing", $object);
	}
	
	/**
	 * Adds the contacts and companies arrays
	 *
	 * @param array $messages
	 * @param array $emails
	 * @return array
	 */
	private function addContactsAndCompanies($contacts, $companies){
		$totCount = 0;
		if (isset($contacts)) $totCount = count($contacts);
		if (isset($companies)) $totCount += count($companies);
		$totContacts = array();
		//Order messages and emails by name
		if (!isset($contacts)){
			$totContacts = $companies ;
		}
		else if (!isset($companies))
			$totContacts  = $contacts;
		else {
			$e = 0;
			$m = 0;
			while (($e + $m) < $totCount){
				if ($e < count($contacts))
					if ($m < count($companies)){						
						$contact_name = trim( array_var($contacts[$e],'lastname','') . ' ' .
											  array_var($contacts[$e],'firstname','') . ' ' .
											  array_var($contacts[$e],'middlename','')
											);
						$company_name = array_var($companies[$m], 'name', '');
						if (strcasecmp($contact_name ,$company_name)  < 0 ){
							$totContacts [] = $contacts[$e];
							$e++;
						} else {
							$totContacts [] = $companies[$m];
							$m++;
						}
					}
					else {
						$totContacts [] = $contacts[$e];
						$e++;
					}
				else {
					$totContacts [] = $companies[$m];
					$m++;
				}
			}
		}
		
		return $totContacts ;
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
						case "contact":
							$contact = Contacts::findById($id);
							if (isset($contact) && $contact->canDelete(logged_user())){
								try{
									DB::beginWork();
									$contact->trash();
									DB::commit();
									$resultMessage = lang("success delete objects", '');
									ApplicationLogs::createLog($contact, $contact->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
								} catch(Exception $e){
									DB::rollback();
									$resultMessage .= $e->getMessage();
									$resultCode = $e->getCode();
								}
							}
							else {
								throw new Exception(lang('error delete contact'));
								return ;
							}
							break;
							
						case "company":
							$company = Companies::findById($id);
							if (isset($company)) {
								if ($company->canDelete(logged_user())) {
									try{
										DB::beginWork();
										$company->trash();									
										DB::commit();
										$resultMessage = lang("success delete objects", '');
										ApplicationLogs::createLog($company, $company->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
									} catch(Exception $e){
										DB::rollback();
										$resultMessage .= $e->getMessage();
										$resultCode = $e->getCode();
									}
								} else {
									$resultMessage .= lang('no access permissions');
									$resultCode = 2;
								}
							};
							break;
							
						default:
							$resultMessage = lang("unimplemented type" . ": '" . $type . "'");// if 
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
						case "contact":
							$contact = Contacts::findById($id);
							if (isset($contact) && $contact->canEdit(logged_user())){
								Tags::addObjectTag($tag, $contact);
								$resultMessage = lang("success tag objects", '');
							};
							break;

						case "company":
							$company = Companies::findById($id);
							if (isset($company) && $company->canEdit(logged_user())){
								Tags::addObjectTag($tag, $company);
								$resultMessage = lang("success tag objects", '');
							};
							break;

						default:
							$resultMessage = lang("unimplemented type" .": '" . $type . "'");// if
							$resultCode = 2;
							break;
					}; // switch
				}; // for
				break;
							
			default:
				$resultMessage = lang("unimplemented action" . ": '" . $action . "'");// if 
				$resultCode = 2;	
				break;		
		} // switch
		return array("errorMessage" => $resultMessage, "errorCode" => $resultCode);
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
			"start" => (integer)min(array(count($totMsg) - (count($totMsg) % $limit),$start)),
			"contacts" => array()
		);
		for ($i = $start; $i < $start + $limit; $i++){
			if (isset($totMsg[$i])){
				$manager= $totMsg[$i]['manager'];
    			$id = $totMsg[$i]['id'];
    			if($id && $manager){
    				$c=get_object_by_manager_and_id($id,$manager);  
					
					if ($c instanceof Contact){						
						$roleName = "";
						$roleTags = "";
						$project = active_project();
						if ($project ) {
							$role = $c->getRole($project);
							if ($role instanceof ProjectContact) {
								$roleName = $role->getRole();
							}
						}
						$company = $c->getCompany();
						$companyName = '';
						if (!is_null($company))
						$companyName= $company->getName();
						$usr_created_by = Users::findById($c->getCreatedById());
						$object["contacts"][] = array(
							"id" => $i,
							"object_id" => $c->getId(),
							"type" => 'contact',
							"wsIds" => $c->getProjectIdsCSV(),
    						"workspaceColors" => $c->getWorkspaceColorsCSV(logged_user()->getActiveProjectIdsCSV()),
							"name" => $c->getReverseDisplayName(),
							"email" => $c->getEmail(),
							"companyId" => $c->getCompanyId(),
							"companyName" => $companyName,
							"website" => $c->getHWebPage(),
							"jobTitle" => $c->getJobTitle(),
							"createdBy" => $usr_created_by?$usr_created_by->getUsername():'',
							"createdById" => $c->getCreatedById(),
					    	"role" => $roleName,
							"tags" => project_object_tags($c),
							"department" => $c->getDepartment(),
							"email2" => $c->getEmail2(),
							"email3" => $c->getEmail3(),
							"workWebsite" => $c->getWWebPage(),
							"workAddress" => $c->getFullWorkAddress(),
							"workPhone1" => $c->getWPhoneNumber(),
							"workPhone2" => $c->getWPhoneNumber2(),
							"homeWebsite" => $c->getHWebPage(),
							"homeAddress" => $c->getFullHomeAddress(),
							"homePhone1" => $c->getWPhoneNumber(),
							"homePhone2" => $c->getWPhoneNumber2(),
							"mobilePhone" =>$c->getHMobileNumber()
						);
					} else if ($c instanceof Company ){					
						$roleName = "";
						$roleTags = "";
//						$project = active_project();
//						if ($project ) {
//							$role = $c->getRole($project);
//							if ($role instanceof ProjectContact) {
//								$roleName = $role->getRole();
//							}
//						}
//						$company = $c->getCompany();
//						$companyName = '';
						if (!is_null($c))
						$companyName= $c->getName();
						$object["contacts"][] = array(
							"id" => $i,
							"object_id" => $c->getId(),
							"type" => 'company',
							"wsIds" => $c->getWorkspacesIdsCSV(logged_user()->getActiveProjectIdsCSV()),
    						"workspaceColors" => $c->getWorkspaceColorsCSV(logged_user()->getActiveProjectIdsCSV()),
							'name' => $c->getName(),
							'email' => $c->getEmail(),
							'website' => $c->getHomepage(),
							'workPhone1' => $c->getPhoneNumber(),
          					'workPhone2' => $c->getFaxNumber(),
          					'workAddress' => $c->getAddress() . ' - ' . $c->getAddress2(),
							"companyId" => $c->getId(),
							"companyName" => $c->getName(),
							"jobTitle" => '',
							"createdBy" => Users::findById($c->getCreatedById())->getUsername(),
							"createdById" => $c->getCreatedById(),
					    	"role" => lang('company'),
							"tags" => project_object_tags($c),
							"department" => lang('company'),
							"email2" => '',
							"email3" => '',
							"workWebsite" => $c->getHomepage(),
							"homeWebsite" => '',
							"homeAddress" => '',
							"homePhone1" => '',
							"homePhone2" => '',
							"mobilePhone" =>''
						);
					}
    			}
			}
		}
		return $object;
	}
	
	/**
	 * Get all contacts for list_all
	 *
	 */
	function getContacts( $tag, $attributes, $project)
	{
		$isProjectView = ($project instanceof Project);
		if (isset($attributes["viewType"]) && 
			($attributes["viewType"] != "all" && $attributes["viewType"] != "contacts"))
			return null;

		if ($project instanceof Project){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
//		$contactConditions = "`id` IN (SELECT `contact_id` FROM `".TABLE_PREFIX."project_contacts` WHERE `project_id` IN ($pids))";

		if (!isset($tag) || $tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "contacts.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='Contacts' ) > 0 ";
		}
		
		/**
		 * If logged user cannot manage contacts, only contacts which belong to a project where the user can manage contacts are displayed.
		 */
		$pc_tbl = ProjectContacts::instance()->getTableName(true);
		if (!can_manage_contacts(logged_user())) {
			$pids = $isProjectView ? $project->getAllSubWorkspacesCSV(true, logged_user()): logged_user()->getActiveProjectIdsCSV();
			$permission_str = " AND `id` IN (SELECT `contact_id` FROM $pc_tbl WHERE $pc_tbl.`project_id` IN ($pids) AND (" . permissions_sql_for_listings(ProjectContacts::instance(),ACCESS_LEVEL_READ, logged_user(),'project_id') . '))';
		} else {
			if ($isProjectView) {
				$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
				$permission_str = " AND `id` IN (SELECT `contact_id` FROM $pc_tbl pc WHERE pc.`project_id` IN ($pids))";
			} else $permission_str = "";
		}
		
		$res = DB::execute("SELECT `id`, TRIM(CONCAT(' ', `lastname`, `firstname`, `middlename`)) AS `display_name`,`lastname`, `firstname`, `middlename`, 'Contacts' AS manager FROM " . TABLE_PREFIX. "contacts WHERE " . 
			"`trashed_by_id` = 0 AND " . $tagstr . $permission_str . " ORDER BY `display_name` ");
			
		if(!$res) return null;
		return $res->fetchAll();
	}
		
	/**
	 * Get all companies for list_all
	 *
	 */
	function getCompanies($tag, $attributes, $project)
	{
		$isProjectView = ($project instanceof Project);
		if (isset($attributes["viewType"]) && 
			($attributes["viewType"] != "all" && $attributes["viewType"] != "companies"))
			return null;

		if ($project instanceof Project){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$contactConditions = "";
		/**
		 * If logged user cannot manage contacts, only contacts which belong to a project where the user can manage contacts are displayed.
		 */
		if($isProjectView){
			$contactConditions = " `id` IN (SELECT `object_id` FROM `".TABLE_PREFIX."workspace_objects` WHERE `object_manager` = 'Companies' AND `workspace_id` IN ($pids)) AND ";
		}
		
					
		if (!isset($tag) || $tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "companies.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='Companies' ) > 0 ";
		}
		if (!can_manage_contacts(logged_user())) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(Companies::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
		}
		else {
			$permissions =' ';
		}
		$res = DB::execute("SELECT id, name, 'Companies' as manager, `updated_on` as comp_date FROM " . TABLE_PREFIX. "companies WHERE " . 
			"`trashed_by_id` = 0 AND " . $contactConditions . $tagstr . $permissions . " ORDER BY name");
			
		if(!$res) return null;
		return $res->fetchAll();
	}


	/**
	 * View single contact
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function view() {
		$this->card();
	} // view

	/**
	 * View single contact
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function card() {
		$contact = Contacts::findById(get_id());
		if(!$contact || !$contact->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		$roles = ProjectContacts::getRolesByContact($contact);
		if (isset($roles))
		{
			foreach ($roles as $role)
			{
				$tags[$role->getProjectId()] = $role->getTagNames();
			}
		}

		tpl_assign('contact', $contact);
		if(($uid = $contact->getUserId()) && ($usr = Users::findById($uid)))
			tpl_assign('user', $usr);
		if (isset($roles))
		tpl_assign('roles',$roles);
		if (isset($tags))
		tpl_assign('tags',$tags);
		ajx_extra_data(array("title" => $contact->getDisplayName(), 'icon'=>'ico-contact'));
		ajx_set_no_toolbar(true);
	} // view

	/**
	 * Add contact
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add() {
		if (active_project() instanceof Project) {
			tpl_assign('isAddProject',true);
		}
		$this->setTemplate('edit_contact');

		if(!Contact::canAdd(logged_user(),active_or_personal_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$contact = new Contact();		
		$im_types = ImTypes::findAll(array('order' => '`id`'));
		$contact_data = array_var($_POST, 'contact');
		if(!array_var($contact_data,'company_id')){
//			$company_id = get_id('company_id');
//			if($company_id && ( Companies::findById($company_id) instanceof Company) ) {
				$contact_data['company_id'] = get_id('company_id');
				$contact_data['timezone'] = logged_user()->getTimezone();
//			}	
		}
		$redirect_to = get_url('contact');

		tpl_assign('contact', $contact);
		tpl_assign('contact_data', $contact_data);
		tpl_assign('im_types', $im_types);

		if(is_array(array_var($_POST, 'contact'))) {
			ajx_current("empty");
			try {
				DB::beginWork();
				
				$newCompany = false;
				if (array_var($contact_data, 'isNewCompany') == 'true' && is_array(array_var($_POST, 'company'))){
					$company_data = array_var($_POST, 'company');
					$company = new Company();
					$company->setFromAttributes($company_data);
					$company->setClientOfId(1);
					
					$company->save();
					ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_ADD);
					$newCompany = true;
				}
				
				$contact_data['o_birthday'] = getDateValue($contact_data["o_birthday_value"]);
				
				$contact->setFromAttributes($contact_data);

				if($newCompany)
					$contact->setCompanyId($company->getId());
				$contact->setIsPrivate(false);
				$contact->save();
				ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_ADD);
				$contact->setTagsFromCSV(array_var($contact_data, 'tags'));
				
				foreach($im_types as $im_type) {
					$value = trim(array_var($contact_data, 'im_' . $im_type->getId()));
					if($value <> '') {

						$contact_im_value = new ContactImValue();

						$contact_im_value->setContactId($contact->getId());
						$contact_im_value->setImTypeId($im_type->getId());
						$contact_im_value->setValue($value);
						$contact_im_value->setIsDefault(array_var($contact_data, 'default_im') == $im_type->getId());

						$contact_im_value->save();
					} // if
				} // foreach
				
				//link it!
			    $object_controller = new ObjectController();
			    $object_controller->link_to_new_object($contact);

				DB::commit();

				flash_success(lang('success add contact', $contact->getDisplayName()));
				ajx_current("back");

				if(active_project() instanceof Project)
				{
					if(!ProjectContact::canAdd(logged_user(), active_project())) {
						flash_error(lang('error contact added but not assigned', $contact->getDisplayName(), active_project()->getName()));
						ajx_current("start");
						return;
					} // if
					
					$pc = new ProjectContact();
					$pc->setContactId($contact->getId());
					$pc->setProjectId(active_project()->getId());
					$pc->setRole(array_var($contact_data,'role'));
					
					DB::beginWork();
					$pc->save();
					DB::commit();
//					ApplicationLogs::createLog($contact, $contact->getWorkspaces(), ApplicationLogs::ACTION_ADD);

				}

				// Error...
			} catch(Exception $e) {
				DB::rollback();
				//tpl_assign('error', $e);
				flash_error($e->getMessage());
			} // try

		} // if
	} // add

	/**
	 * Edit specific contact
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit() {
		$this->setTemplate('edit_contact');
		
		if (active_project() instanceof Project) {
			tpl_assign('isAddProject',true);
		}

		$contact = Contacts::findById(get_id());
		if(!($contact instanceof Contact)) {
			flash_error(lang('contact dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$contact->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$im_types = ImTypes::findAll(array('order' => '`id`'));
		$active_project = active_project();
		$role = "" ;
		if($active_project){
			$pc = $contact->getRole(active_project());
			if ($pc instanceof ProjectContact) {
				$role = $pc->getRole();
			}
		}
		
		$contact_data = array_var($_POST, 'contact');
		if(!is_array($contact_data)) {
			$tag_names = $contact->getTagNames();
			$contact_data = array(
          	'firstname' => $contact->getFirstName(),
          	'lastname' => $contact->getLastName(),
			'middlename'=> $contact->getMiddleName(), 
          	'department' => $contact->getDepartment(),
          	'job_title' => $contact->getJobTitle(),
            'email' => $contact->getEmail(),
            'email2' => $contact->getEmail2(),
            'email3' => $contact->getEmail3(),
			'w_web_page'=> $contact->getWWebPage(), 
			'w_address'=> $contact->getWAddress(), 
			'w_city'=> $contact->getWCity(), 
			'w_state'=> $contact->getWState(), 
			'w_zipcode'=> $contact->getWZipcode(), 
			'w_country'=> $contact->getWCountry(), 
			'w_phone_number'=> $contact->getWPhoneNumber(), 
			'w_phone_number2'=> $contact->getWPhoneNumber2(), 
			'w_fax_number'=> $contact->getWFaxNumber(), 
			'w_assistant_number'=> $contact->getWAssistantNumber(), 
			'w_callback_number'=> $contact->getWCallbackNumber(), 

			'h_web_page'=> $contact->getHWebPage(), 
			'h_address'=> $contact->getHAddress(), 
			'h_city'=> $contact->getHCity(), 
			'h_state'=> $contact->getHState(), 
			'h_zipcode'=> $contact->getHZipcode(), 
			'h_country'=> $contact->getHCountry(), 
			'h_phone_number'=> $contact->getHPhoneNumber(), 
			'h_phone_number2'=> $contact->getHPhoneNumber2(), 
			'h_fax_number'=> $contact->getHFaxNumber(), 
			'h_mobile_number'=> $contact->getHMobileNumber(), 
			'h_pager_number'=> $contact->getHPagerNumber(), 

			'o_web_page'=> $contact->getOWebPage(), 
			'o_address'=> $contact->getOAddress(), 
			'o_city'=> $contact->getOCity(), 
			'o_state'=> $contact->getOState(), 
			'o_zipcode'=> $contact->getOZipcode(), 
			'o_country'=> $contact->getOCountry(), 
			'o_phone_number'=> $contact->getOPhoneNumber(), 
			'o_phone_number2'=> $contact->getOPhoneNumber2(), 
			'o_fax_number'=> $contact->getOFaxNumber(), 
			'o_birthday'=> $contact->getOBirthday(), 
          	'picture_file' => $contact->getPictureFile(),
          	'timezone' => $contact->getTimezone(),
          	'notes' => $contact->getNotes(),
          	'is_private' => $contact->getIsPrivate(),
          	'company_id' => $contact->getCompanyId(),
      	    'role' => $role,
      	    'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
      	    
      	    ); // array

      	    if(is_array($im_types)) {
      	    	foreach($im_types as $im_type) {
      	    		$contact_data['im_' . $im_type->getId()] = $contact->getImValue($im_type);
      	    	} // forech
      	    } // if

      	    $default_im = $contact->getDefaultImType();
      	    $contact_data['default_im'] = $default_im instanceof ImType ? $default_im->getId() : '';
		} // if

		tpl_assign('contact', $contact);
		tpl_assign('contact_data', $contact_data);
		tpl_assign('im_types', $im_types);

		if(is_array(array_var($_POST, 'contact'))) {
			try {
				DB::beginWork();
				
				$newCompany = false;
				if (array_var($contact_data, 'isNewCompany') == 'true' && is_array(array_var($_POST, 'company'))){
					$company_data = array_var($_POST, 'company');
					$company = new Company();
					$company->setFromAttributes($company_data);
					$company->setClientOfId(1);
					
					$company->save();
					ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_ADD );
					$newCompany = true;
				}
				
				$contact_data['o_birthday'] = getDateValue($contact_data["o_birthday_value"]);
				
				$contact->setFromAttributes($contact_data);
				
				/*if (!is_null($contact->getOBirthday()) && $contact_data["o_birthday_year"] == 0){
					$contact->setOBirthday(null);
				} else if ($contact_data["o_birthday_year"] != 0) {
					$bday = new DateTimeValue(0);
					$bday->setYear($contact_data["o_birthday_year"]);
					$bday->setMonth($contact_data["o_birthday_month"]);
					$bday->setDay($contact_data["o_birthday_day"]);
					$contact->setOBirthday($bday);
				}*/

				if($newCompany)
					$contact->setCompanyId($company->getId());

				$contact->save();
				ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_EDIT );
				$contact->setTagsFromCSV(array_var($contact_data, 'tags'));
				$contact->clearImValues();

				foreach($im_types as $im_type) {
					$value = trim(array_var($contact_data, 'im_' . $im_type->getId()));
					if($value <> '') {

						$contact_im_value = new ContactImValue();

						$contact_im_value->setContactId($contact->getId());
						$contact_im_value->setImTypeId($im_type->getId());
						$contact_im_value->setValue($value);
						$contact_im_value->setIsDefault(array_var($contact_data, 'default_im') == $im_type->getId());

						$contact_im_value->save();
					} // if
				} // foreach

				DB::commit();
				
				if (trim(array_var($contact_data, 'role', '')) != '' && active_project() instanceof Project) {
					if(!ProjectContact::canAdd(logged_user(), active_project())) {
						flash_error(lang('error contact added but not assigned', $contact->getDisplayName(), active_project()->getName()));
						ajx_current("back");
						return;
					} // if
					
					$pc = new ProjectContact();
					$pc->setContactId($contact->getId());
					$pc->setProjectId(active_project()->getId());
					$pc->setRole(array_var($contact_data,'role'));
					
					DB::beginWork();
					$pc->save();
					DB::commit();
//					ApplicationLogs::createLog($contact, $contact->getWorkspaces(), ApplicationLogs::ACTION_ADD);

				}

				flash_success(lang('success edit contact', $contact->getDisplayName()));
				ajx_current("back");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
		  		ajx_current("empty");
			} // try
		} // if
	} // edit

	/**
	 * Edit contact picture
	 *
	 * @param void
	 * @return null
	 */
	function edit_picture() {
		$contact = Contacts::findById(get_id());
		if(!($contact instanceof Contact)) {
			flash_error(lang('contact dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$contact->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$redirect_to = array_var($_GET, 'redirect_to');
		if((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
			$redirect_to = $contact->getUpdatePictureUrl();
		} // if
		tpl_assign('redirect_to', $redirect_to);

		$picture = array_var($_FILES, 'new_picture');
		tpl_assign('contact', $contact);

		if(is_array($picture)) {
			try {
				if(!isset($picture['name']) || !isset($picture['type']) || !isset($picture['size']) || !isset($picture['tmp_name']) || !is_readable($picture['tmp_name'])) {
					throw new InvalidUploadError($picture, lang('error upload file'));
				} // if

				$valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
				$max_width   = config_option('max_avatar_width', 50);
				$max_height  = config_option('max_avatar_height', 50);

				if(!in_array($picture['type'], $valid_types) || !($image = getimagesize($picture['tmp_name']))) {
					throw new InvalidUploadError($picture, lang('invalid upload type', 'JPG, GIF, PNG'));
				} // if

				$old_file = $contact->getPicturePath();
				DB::beginWork();

				if(!$contact->setPicture($picture['tmp_name'], $max_width, $max_height)) {
					throw new InvalidUploadError($avatar, lang('error edit picture'));
				} // if

				ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_EDIT);
				DB::commit();

				if(is_file($old_file)) {
					@unlink($old_file);
				} // if

				flash_success(lang('success edit picture'));
				
				ajx_current("back");
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // edit_picture

	/**
	 * Delete picture
	 *
	 * @param void
	 * @return null
	 */
	function delete_picture() {
		$contact = Contacts::findById(get_id());
		if(!($contact instanceof Contact)) {
			flash_error(lang('contact dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$contact->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$redirect_to = array_var($_GET, 'redirect_to');
		if((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
			$redirect_to = $contact->getUpdatePictureUrl();
		} // if
		tpl_assign('redirect_to', $redirect_to);

		if(!$contact->hasPicture()) {
			flash_error(lang('picture dnx'));
			ajx_current("empty");
			return;
		} // if

		try {
			DB::beginWork();
			$contact->deletePicture();
			$contact->save();
			ApplicationLogs::createLog($contact, $contact->getWorkspaces(), ApplicationLogs::ACTION_EDIT);

			DB::commit();

			flash_success(lang('success delete picture'));
			ajx_current("back");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete picture'));
			ajx_current("empty");
		} // try

	} // delete_picture

	/**
	 * Delete specific contact
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete() {
		$contact = Contacts::findById(get_id());
		if(!($contact instanceof Contact)) {
			flash_error(lang('contact dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$contact->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$contact->trash();
			ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_TRASH );

			DB::commit();

			flash_success(lang('success delete contact', $contact->getDisplayName()));
			ajx_current("back");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete contact'));
			ajx_current("empty");
		} // try
	} // delete

	function assign_to_project()
	{
		$contact = Contacts::findById(get_id());
		if(!($contact instanceof Contact)) {
			flash_error(lang('contact dnx'));
			ajx_current("empty");
			return;
		} // if
		
		$projects = active_projects();
		$contactRoles = ProjectContacts::getRolesByContact($contact);

		if(!$contact->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$contact_data = array_var($_POST, 'contact');
		$enterData = true;
		if(!is_array($contact_data)) {
			$enterData = false;
			foreach($projects as $project){
				$contact_data['pid_'.$project->getId()] = false;
				$contact_data['role_pid_'.$project->getId()] = '';
				 
				if($contactRoles){
					foreach($contactRoles as $cr){
						if ($project->getId() == $cr->getProjectId()){
							$contact_data['pid_'.$project->getId()] = true;
							$contact_data['role_pid_'.$project->getId()] = $cr->getRole();
						} // if
					} // foreach
				} // if
			} // foreach
		} // if

		if($enterData){
			try {
				DB::beginWork();
				foreach($projects as $project){	
					if(!ProjectContact::canAdd(logged_user(),$project)) {
						DB::rollback();
						flash_error(lang('no access permissions'));
						ajx_current("empty");
						return;
					} // if
					if(!isset($contact_data['pid_'.$project->getId()])){
						ProjectContacts::deleteRole($contact,$project);
					} else {
						$role = $contact_data['role_pid_'.$project->getId()];
						$pc = ProjectContacts::getRole($contact,$project);
						if ($pc){
							if ($pc->getRole() != $role){
								$pc->setRole($role);
								$pc->save();

//								ApplicationLogs::createLog($contact, $project, ApplicationLogs::ACTION_EDIT);
							} //if
						} else {
							$pc = new ProjectContact();
							$pc->setProjectId($project->getId());
							$pc->setContactId($contact->getId());
							$pc->setRole($role);
							$pc->save();
//							ApplicationLogs::createLog($contact, $project, ApplicationLogs::ACTION_EDIT);
						}//if else
					}//if else
				}//foreach
				ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_EDIT );
				DB::commit();

				flash_success(lang('success edit contact', $contact->getDisplayName()));
				ajx_current("back");
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if

		tpl_assign('contact', $contact);
		tpl_assign('contact_data', $contact_data);
		tpl_assign('projects', $projects);
	} // assign_to_project
	
	
	function import_from_csv_file() {
		if (isset($_SESSION['history_back'])) {
			if ($_SESSION['history_back'] > 0) $_SESSION['history_back'] = $_SESSION['history_back'] - 1;
			if ($_SESSION['history_back'] == 0) unset($_SESSION['history_back']);
			ajx_current("back");
		} else {
			
			if(!Contact::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if
	
			$this->setTemplate('csv_import');
			
			$filedata = array_var($_FILES, 'csv_file');
			if (is_array($filedata) && !is_array(array_var($_POST, 'select_contact'))) {
				
				$filename = $filedata['tmp_name'].'.csv';
				copy($filedata['tmp_name'], $filename);
				
				$first_record_has_names = array_var($_POST, 'first_record_has_names', false);
				$delimiter = array_var($_POST, 'delimiter', ',');
				
				$titles = $this->read_csv_file($filename, $delimiter, true);
				
				tpl_assign('titles', $titles);
				$_SESSION['delimiter'] = $delimiter;
				$_SESSION['csv_import_filename'] = $filename;
				$_SESSION['first_record_has_names'] = $first_record_has_names;
			}
			
			if (array_var($_GET, 'calling_back', false)) {
				$filename = $_SESSION['csv_import_filename'];
				$delimiter = $_SESSION['delimiter'];
				$first_record_has_names = $_SESSION['first_record_has_names'];
				
				$titles = $this->read_csv_file($filename, $delimiter, true);
	
				unset($_GET['calling_back']);
				tpl_assign('titles', $titles);
			}
			
			if (is_array(array_var($_POST, 'select_contact'))) {
				
				$filename = $_SESSION['csv_import_filename'];
				$delimiter = $_SESSION['delimiter'];
				$first_record_has_names = $_SESSION['first_record_has_names'];
				
				$registers = $this->read_csv_file($filename, $delimiter);
				
				$import_result = array('import_ok' => array(), 'import_fail' => array());
				
				$i = $first_record_has_names ? 1 : 0;
				while ($i < count($registers)) {
					try {
						DB::beginWork();
						$contact_data = $this->buildContactData(array_var($_POST, 'select_contact'), array_var($_POST, 'check_contact'), $registers[$i]);
						$contact = new Contact();
						$contact->setFromAttributes($contact_data);
						$contact->save();
						ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_ADD);
						$contact->setTagsFromCSV(array_var($_POST, 'tags'));
						
						if(active_project() instanceof Project)
						{
							$pc = new ProjectContact();
							$pc->setContactId($contact->getId());
							$pc->setProjectId(active_project()->getId());
							$pc->setRole(array_var($contact_data,'role'));
							$pc->save();
						}
						DB::commit();
						
						$import_result['import_ok'][] = $contact_data;
					} catch (Exception $e) {
						$contact_data['fail_message'] = substr($e->getMessage(), strpos($e->getMessage(), "\r\n"));
						DB::rollback();
						$import_result['import_fail'][] = $contact_data;
					}		
					$i++;
				}
				unlink($_SESSION['csv_import_filename']);
				unset($_SESSION['csv_import_filename']);
				unset($_SESSION['delimiter']);
				unset($_SESSION['first_record_has_names']);
				
				$_SESSION['history_back'] = 2;
				tpl_assign('import_result', $import_result);
			}
		}
	} // import_from_csv_file

		
	function read_csv_file($filename, $delimiter, $only_first_record = false) {
		$handle = fopen($filename, 'rb');
		if (!$handle) {
			flash_error(lang('file not exists'));
			ajx_current("empty");
			return;
		}
		
		if ($only_first_record) {
			$result = fgetcsv($handle, null, $delimiter);
			$aux = array();
			foreach ($result as $title) $aux[] = utf8_encode($title);
			$result = $aux;			
		} else {
			$result = array();
			while ($fields = fgetcsv($handle, null, $delimiter)) {
				$aux = array();
				foreach ($fields as $field) $aux[] = utf8_encode($field);
				$result[] = $aux;
			}
		}
		
		fclose($handle);
		return $result;
	} //read_csv_file
	
	
function buildContactData($position, $checked, $fields) {
		$contact_data = array();
		if (isset($checked['firstname']) && $checked['firstname']) $contact_data['firstname'] = array_var($fields, $position['firstname']);
		if (isset($checked['lastname']) && $checked['lastname']) $contact_data['lastname'] = array_var($fields, $position['lastname']);
		if (isset($checked['middlename']) && $checked['middlename']) $contact_data['middlename'] = array_var($fields, $position['middlename']);
		if (isset($checked['department']) && $checked['department']) $contact_data['department'] = array_var($fields, $position['department']);
		if (isset($checked['job_title']) && $checked['job_title']) $contact_data['job_title'] = array_var($fields, $position['job_title']);
		if (isset($checked['email']) && $checked['email']) $contact_data['email'] = array_var($fields, $position['email']);
		
		if (isset($checked['email2']) && $checked['email2']) $contact_data['email2'] = array_var($fields, $position['email2']);
		if (isset($checked['email3']) && $checked['email3']) $contact_data['email3'] = array_var($fields, $position['email3']);
		if (isset($checked['w_web_page']) && $checked['w_web_page']) $contact_data['w_web_page'] = array_var($fields, $position['w_web_page']);
		if (isset($checked['w_address']) && $checked['w_address']) $contact_data['w_address'] = array_var($fields, $position['w_address']);
		if (isset($checked['w_city']) && $checked['w_city']) $contact_data['w_city'] = array_var($fields, $position['w_city']);
		if (isset($checked['w_state']) && $checked['w_state']) $contact_data['w_state'] = array_var($fields, $position['w_state']);
		if (isset($checked['w_zipcode']) && $checked['w_zipcode']) $contact_data['w_zipcode'] = array_var($fields, $position['w_zipcode']);
		if (isset($checked['w_country']) && $checked['w_country']) $contact_data['w_country'] = array_var($fields, $position['w_country']);
		if (isset($checked['w_phone_number']) && $checked['w_phone_number']) $contact_data['w_phone_number'] = array_var($fields, $position['w_phone_number']);
		if (isset($checked['w_phone_number2']) && $checked['w_phone_number2']) $contact_data['w_phone_number2'] = array_var($fields, $position['w_phone_number2']);
		if (isset($checked['w_fax_number']) && $checked['w_fax_number']) $contact_data['w_fax_number'] = array_var($fields, $position['w_fax_number']);
		if (isset($checked['w_assistant_number']) && $checked['w_assistant_number']) $contact_data['w_assistant_number'] = array_var($fields, $position['w_assistant_number']);
		if (isset($checked['w_callback_number']) && $checked['w_callback_number']) $contact_data['w_callback_number'] = array_var($fields, $position['w_callback_number']);
		
		if (isset($checked['h_web_page']) && $checked['h_web_page']) $contact_data['h_web_page'] = array_var($fields, $position['h_web_page']);
		if (isset($checked['h_address']) && $checked['h_address']) $contact_data['h_address'] = array_var($fields, $position['h_address']);
		if (isset($checked['h_city']) && $checked['h_city']) $contact_data['h_city'] = array_var($fields, $position['h_city']);
		if (isset($checked['h_state']) && $checked['h_state']) $contact_data['h_state'] = array_var($fields, $position['h_state']);
		if (isset($checked['h_zipcode']) && $checked['h_zipcode']) $contact_data['h_zipcode'] = array_var($fields, $position['h_zipcode']);
		if (isset($checked['h_country']) && $checked['h_country']) $contact_data['h_country'] = array_var($fields, $position['h_country']);
		if (isset($checked['h_phone_number']) && $checked['h_phone_number']) $contact_data['h_phone_number'] = array_var($fields, $position['h_phone_number']);
		if (isset($checked['h_phone_number2']) && $checked['h_phone_number2']) $contact_data['h_phone_number2'] = array_var($fields, $position['h_phone_number2']);
		if (isset($checked['h_fax_number']) && $checked['h_fax_number']) $contact_data['h_fax_number'] = array_var($fields, $position['h_fax_number']);
		if (isset($checked['h_mobile_number']) && $checked['h_mobile_number']) $contact_data['h_mobile_number'] = array_var($fields, $position['h_mobile_number']);
		if (isset($checked['h_pager_number']) && $checked['h_pager_number']) $contact_data['h_pager_number'] = array_var($fields, $position['h_pager_number']);
		
		if (isset($checked['o_web_page']) && $checked['o_web_page']) $contact_data['o_web_page'] = array_var($fields, $position['o_web_page']);
		if (isset($checked['o_address']) && $checked['o_address']) $contact_data['o_address'] = array_var($fields, $position['o_address']);
		if (isset($checked['o_city']) && $checked['o_city']) $contact_data['o_city'] = array_var($fields, $position['o_city']);
		if (isset($checked['o_state']) && $checked['o_state']) $contact_data['o_state'] = array_var($fields, $position['o_state']);
		if (isset($checked['o_zipcode']) && $checked['o_zipcode']) $contact_data['o_zipcode'] = array_var($fields, $position['o_zipcode']);
		if (isset($checked['o_country']) && $checked['o_country']) $contact_data['o_country'] = array_var($fields, $position['o_country']);
		if (isset($checked['o_phone_number']) && $checked['o_phone_number']) $contact_data['o_phone_number'] = array_var($fields, $position['o_phone_number']);
		if (isset($checked['o_phone_number2']) && $checked['o_phone_number2']) $contact_data['o_phone_number2'] = array_var($fields, $position['o_phone_number2']);
		if (isset($checked['o_fax_number']) && $checked['o_fax_number']) $contact_data['o_fax_number'] = array_var($fields, $position['o_fax_number']);
		if (isset($checked['o_birthday']) && $checked['o_birthday']) $contact_data['o_birthday'] = array_var($fields, $position['o_birthday']);
		if (isset($checked['notes']) && $checked['notes']) $contact_data['notes'] = array_var($fields, $position['notes']);
		          
		$contact_data['is_private'] = false;
		$contact_data['timezone'] = logged_user()->getTimezone();

		return $contact_data;
	} // buildContactData

} // ContactController

?>