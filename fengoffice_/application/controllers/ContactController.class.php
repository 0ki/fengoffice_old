<?php

/**
 * Contact controller
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
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
		if (is_ajax_request()) {
			prepare_company_website_controller($this, 'ajax');
		} else {
			prepare_company_website_controller($this, 'website');
		}
	} // __construct


	function list_all()
	{
		ajx_current("empty");
		
		$project = active_project();
		$isProjectView = ($project instanceof Project);
		$filesPerPage = config_option('files_per_page');
		$start = array_var($_GET,'start') ? array_var($_GET,'start') : 0;
		$limit = array_var($_GET,'limit') ? array_var($_GET,'limit') : $filesPerPage;
		//$order = array_var($_GET,'sort');
		//$orderdir = array_var($_GET,'dir');
		$tag = array_var($_GET,'tag');
		$page = (integer) ($start / $limit) + 1;
		if ($page < 0) $page = 1;
		$hide_private = !logged_user()->isMemberOfOwnerCompany();

		/**
		 * Resolve actions if any
		 */
		if (array_var($_GET,'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'contacts'));
			$err = $this->do_delete_contacts($ids);
			if ($err > 0) {
				flash_error(lang('error delete contacts'));
			} else {
				flash_success(lang('success delete contacts'));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'contacts'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = Contacts::tagContacts($tagTag, $ids);
			if ($err > 0) {
				flash_error(lang('error tag contacts', $err));
			} else {
				flash_success(lang('success tag contacts', $succ));
			}
		}
		
		/**
		 * Search by tags
		 */ 
		if ($tag == '' || $tag == null) {
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
		
		list($contacts, $pagination) = Contacts::paginate(
			array(
				'conditions' => $tagstr . $permission_str,
				'order' => 'UPPER(`lastname`) ASC, UPPER(`firstname`) ASC'
			),
			$filesPerPage,
			$page
		); // paginate

		tpl_assign('totalCount', $pagination->getTotalItems());
		tpl_assign('contacts', $contacts);
		tpl_assign('pagination', $pagination);
		tpl_assign('tags', Tags::getTagNames());

		$object = array(
			"totalCount" => $pagination->getTotalItems(),
			"contacts" => array()
		);
		if (isset($contacts)) {
			foreach ($contacts as $c) {
				$roleName = "";
				$roleTags = "";
				if ($isProjectView) {
					$role = $c->getRole($project);
					if ($role instanceof ProjectContact) {
						$roleName = $role->getRole();
					}
				}
				$company = $c->getCompany();
				$companyName = '';
				if (!is_null($company))
				$companyName= $company->getName();
				$object["contacts"][] = array(
					"id" => $c->getId(),
					"name" => $c->getReverseDisplayName(),
					"email" => $c->getEmail(),
					"companyId" => $c->getCompanyId(),
					"companyName" => $companyName,
					"website" => $c->getHWebPage(),
					"jobTitle" => $c->getJobTitle(),
					"createdBy" => Users::findById($c->getCreatedById())->getUsername(),
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
			}
		}
		ajx_extra_data($object);
		tpl_assign("listing", $object);
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
		if(!Contact::canView(logged_user())) {
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

		if(!Contact::canAdd(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$contact = new Contact();
		$im_types = ImTypes::findAll(array('order' => '`id`'));
		$contact_data = array_var($_POST, 'contact');
		$redirect_to = get_url('contact');

		tpl_assign('contact', $contact);
		tpl_assign('contact_data', $contact_data);
		tpl_assign('im_types', $im_types);

		if(is_array(array_var($_POST, 'contact'))) {
			ajx_current("empty");
			try {
				$contact->setFromAttributes($contact_data);

				DB::beginWork();
				$contact->save();
				//link it!
			    $object_controller = new ObjectController();
			    $object_controller->link_to_new_object($contact);

				DB::commit();

				flash_success(lang('success add contact', $contact->getDisplayName()));
				ajx_current("start");

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
				 
				DB::beginWork();

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
				ajx_current("start");

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
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
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
			$this->redirectToUrl($redirect_to);
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
			ajx_current("start");
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
					if(!$contact->canAdd(logged_user(),$project)) {
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
				ajx_current("start");
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