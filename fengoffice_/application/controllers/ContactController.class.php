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
		
		// Get all emails and messages to display
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
						$contact_name = trim( ((array_var($contacts[$e],'lastname','') != '') ?  
												array_var($contacts[$e],'lastname') .', ' : ''
											  ) .
											  array_var($contacts[$e],'firstname','') .' ' .
											  array_var($contacts[$e],'middlename','')
											);
						if (strcmp($contact_name ,$companies[$m]['name'])  < 0 ){
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
									$contact->deletePicture();
									$contact->delete();
									DB::commit();
									$resultMessage = lang("success delete objects", '');
								} catch(Exception $e){
									DB::rollback();
									$resultMessage .= $e->getMessage();
									$resultCode = $e->getCode();
								}
							};
							break;
							
						case "company":
							$company = Companies::findById($id);
							if (isset($company) && $company->canDelete(logged_user())){
								try{
									DB::beginWork();
									$company->deleteLogo();
									$company->delete();									
									DB::commit();
									$resultMessage = lang("success delete objects", '');
								} catch(Exception $e){
									DB::rollback();
									$resultMessage .= $e->getMessage();
									$resultCode = $e->getCode();
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
		
//		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectContacts::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
/*		if($page && $objects_per_page){
			$start=($page-1) * $objects_per_page ;
			$query .=  " limit " . $start . "," . $objects_per_page. " ";
		}		
		elseif($objects_per_page)
			$query .= " limit " . $objects_per_page;*/
		
		$res = DB::execute("SELECT id, `lastname`,`firstname`,`middlename`, 'Contacts' as manager from " . TABLE_PREFIX. "contacts where " . 
			$tagstr . $permission_str . " ORDER BY lastname, firstname ");
			
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
			$contactConditions . $tagstr . $permissions . " ORDER BY name");
			
		if(!$res) return null;
		return $res->fetchAll();
	}

	private function do_delete_contacts($ids)
	{
		$err = 0;
		try
		{
			DB::beginWork();
			foreach ($ids as $id)
			{
				$contact = Contacts::findById($id);
				if ($contact instanceof Contact && $contact->canDelete(logged_user())){
					$roles = $contact->getRoles();
					if (isset($roles))
					foreach ($roles as $role){
						$role->delete();
					}
					$contact->delete();
				}
			}
			DB::commit();
		}
		catch (Exception $e)
		{
			DB::rollback();
			$err = $e->getCode();
		}
		return $err;
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
		if (active_project() instanceof Project)
		tpl_assign('isAddProject',true);
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
					$newCompany = true;
				}
				
				$contact->setFromAttributes($contact_data);

				if($newCompany)
					$contact->setCompanyId($company->getId());
				
				if ($contact_data["o_birthday_year"] != 0) {
					$bday = new DateTimeValue(0);
					$bday->setYear($contact_data["o_birthday_year"]);
					$bday->setMonth($contact_data["o_birthday_month"]);
					$bday->setDay($contact_data["o_birthday_day"]);
					$contact->setOBirthday($bday);
				}
				
				$contact->save();
				
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
					ApplicationLogs::createLog($contact, active_project(), ApplicationLogs::ACTION_ADD);
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

		$contact_data = array_var($_POST, 'contact');
		if(!is_array($contact_data)) {
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
      	    'role' => ''
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
				if (array_var($contact_data, 'isNewCompany') == 'true' && trim(array_var($contact_data, 'new_company_name')) != ''){
					$company = new Company();
					$company->setAddress(array_var($contact_data, 'w_address'));
					$company->setCity(array_var($contact_data, 'w_city'));
					$company->setState(array_var($contact_data, 'w_state'));
					$company->setPhoneNumber(array_var($contact_data, 'w_phone_number'));
					$company->setZipcode(array_var($contact_data, 'w_zipcode'));
					$company->setCountry(array_var($contact_data, 'w_country'));
					$company->setHomepage(array_var($contact_data, 'w_webpage'));
					$company->setFaxNumber(array_var($contact_data, 'w_fax_number'));
					$company->setName(array_var($contact_data, 'new_company_name'));
					$company->setClientOfId(1);
					
					$company->save();
					$newCompany = true;
				}
				
				$contact->setFromAttributes($contact_data);
				
				if (!is_null($contact->getOBirthday()) && $contact_data["o_birthday_year"] == 0){
					$contact->setOBirthday(null);
				} else if ($contact_data["o_birthday_year"] != 0) {
					$bday = new DateTimeValue(0);
					$bday->setYear($contact_data["o_birthday_year"]);
					$bday->setMonth($contact_data["o_birthday_month"]);
					$bday->setDay($contact_data["o_birthday_day"]);
					$contact->setOBirthday($bday);
				}

				if($newCompany)
					$contact->setCompanyId($company->getId());

				$contact->save();
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

				//ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_EDIT);
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
			ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_EDIT);

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
			$contact->delete();
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

								ApplicationLogs::createLog($contact, $project, ApplicationLogs::ACTION_EDIT);
							} //if
						} else {
							$pc = new ProjectContact();
							$pc->setProjectId($project->getId());
							$pc->setContactId($contact->getId());
							$pc->setRole($role);
							$pc->save();
							ApplicationLogs::createLog($contact, $project, ApplicationLogs::ACTION_ADD);
						}//if else
					}//if else
				}//foreach
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

} // ContactController

?>