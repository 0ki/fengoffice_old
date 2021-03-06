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
    	$isProjectView = (active_project() instanceof Project);
    	
    	$this->setTemplate('../json');
    	$this->setLayout('json');
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
		$tag = array_var($_GET,'tag');
		$page = (integer) ($start / $limit) + 1;
		$hide_private = !logged_user()->isMemberOfOwnerCompany();

		if (array_var($_GET,'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'contacts'));
			$err = $this->do_delete_contacts($ids);
			if ($err > 0) {
				tpl_assign('errCode', -1);
				tpl_assign('errMsg', lang('error delete contacts'));
			} else {
				tpl_assign('errCode', 0);
				tpl_assign('errMsg', lang('success delete contacts'));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'contacts'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = Contacts::tagRolesByProject($tagTag, $ids, active_project());
			if ($err > 0) {
				tpl_assign('errCode', -1);
				tpl_assign('errMsg', lang('error tag contacts', $err));
			} else {
				evt_add("tag added", array("name" => $tagTag));
				tpl_assign('errCode', 0);
				tpl_assign('errMsg', lang('success tag contacts', $succ));
			}
		}
		
      if($page < 0) $page = 1;
      
      $conditions = logged_user()->isMemberOfOwnerCompany() ? '' : ' `is_private` = 0';
      
      if ($isProjectView)
      {
      	if ($tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags, " . TABLE_PREFIX . "project_contacts where " .
				TABLE_PREFIX . "project_contacts.project_id = " . active_project()->getId() . " and " .
				TABLE_PREFIX . "project_contacts.contact_id = " . TABLE_PREFIX . "contacts.id and " .
				TABLE_PREFIX . "project_contacts.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectContacts' ) > 0 ";
		}
      	list($contacts, $pagination) = Contacts::instance()->getByProject(active_project(),
      	array("conditions" => $tagstr),
      	config_option('files_per_page', 10),
      	$page
      	); // paginate
      }
      else
      {
      	list($contacts, $pagination) = Contacts::paginate(
      	array(
          'conditions' => $conditions,
          'order' => '`lastname` ASC, `firstname` ASC'
          ),
          config_option('files_per_page', 10),
          $page
          ); // paginate
      }
      
		tpl_assign('totalCount', $pagination->getTotalItems());
      	tpl_assign('contacts', $contacts);
		tpl_assign('pagination', $pagination);
		tpl_assign('tags', Tags::getTagNames());
		
		$object = array(
			"totalCount" => $pagination->getTotalItems(),
			"events" => evt_list(),
			"errorCode" => isset($errCode)?$errCode:0,
			"errorMessage" => isset($errMsg)?$errMsg:"",
			"contacts" => array()
		);
		if (isset($contacts))
		{
			foreach ($contacts as $c) {
				$roleName = "";
				$roleTags = "";
				if ($isProjectView)
				{
					$role = $c->getRole(active_project());
					$roleName = $role->getRole();
					$roleTags = project_object_tags($role, active_project(), true);
				}
				$company = $c->getCompany();
				$companyName = '';
				if (!is_null($company))
				$companyName= $company->getName();
				$object["contacts"][] = array(
				"id" => $c->getId(),
				"name" => $c->getDisplayName(),
				"email" => $c->getEmail(),
				"companyId" => $c->getCompanyId(),
				"companyName" => $companyName,
				"website" => $c->getHWebPage(),
				"jobTitle" => $c->getJobTitle(),
				"createdBy" => Users::findById($c->getCreatedById())->getUsername(),
				"createdById" => $c->getCreatedById(),
			    "role" => $roleName,
				"tags" => $roleTags,
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
    	tpl_assign("object", $object);
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
    			if ($contact instanceof Contact){
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
        $this->redirectToReferer(get_url('contact'));
      } // if
      
      $contact = new Contact();
      $im_types = ImTypes::findAll(array('order' => '`id`'));
      $contact_data = array_var($_POST, 'contact');
      $redirect_to = get_url('contact');
      
      tpl_assign('contact', $contact);
      tpl_assign('contact_data', $contact_data);
      tpl_assign('im_types', $im_types);
      
      if(is_array(array_var($_POST, 'contact'))) {
        
        try {
          $contact->setFromAttributes($contact_data);
          
          DB::beginWork();
          $contact->save();

          if(array_var($contact_data,'role') != '')
          {
          	$pc = new ProjectContact();
          	$pc->setContactId($contact->getId());
          	$pc->setProjectId(active_project()->getId());
          	$pc->setRole(array_var($contact_data,'role'));
          	$pc->save();
          	ApplicationLogs::createLog($contact, active_project(), ApplicationLogs::ACTION_ADD);
          }
          
          DB::commit();
          
          flash_success(lang('success add contact', $contact->getDisplayName()));
          $this->redirectToUrl($contact->getCardUrl());
          
        // Error...
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
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
        $this->redirectTo('contact');
      } // if
      
      if(!$contact->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('contact');
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
          
          $contact->setFromAttributes($contact_data);
          if ($contact->getOBirthday()->getYear() == 0)
          	$contact->setOBirthday(null);
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
          $this->redirectToUrl($contact->getCardUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
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
        $this->redirectTo('dashboard');
      } // if
      
      if(!$contact->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $redirect_to = array_var($_GET, 'redirect_to');
      if((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
        $redirect_to = $contact->getUpdatePictureUrl();
      } // if
      tpl_assign('redirect_to', $redirect_to);
      
      $picture = array_var($_FILES, 'new_picture');
      tpl_assign('contact', $contact);
      
      if(is_array($picture)) {
      	$this->setLayout("html");
		$this->setTemplate(get_template_path("json"));
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
            
          $object = array(
				"errorCode" => 0,
				"errorMessage" => lang('success edit picture'),
				"current" => array(
					"type" => "url",
					"data" => $redirect_to
				)
			);
			tpl_assign("object", $object);
        } catch(Exception $e) {
          DB::rollback();
          $object = array(
			"errorCode" => $e->getCode() || 1,
			"errorMessage" => $e->getMessage()
		);
		tpl_assign("object", $object);
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
        $this->redirectTo('dashboard');
      } // if
      
      if(!$contact->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $redirect_to = array_var($_GET, 'redirect_to');
      if((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
        $redirect_to = $contact->getUpdatePictureUrl();
      } // if
      tpl_assign('redirect_to', $redirect_to);
      
      if(!$contact->hasPicture()) {
        flash_error(lang('picture dnx'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      try {
        DB::beginWork();
        $contact->deletePicture();
        $contact->save();
        ApplicationLogs::createLog($contact, null, ApplicationLogs::ACTION_EDIT);
        
        DB::commit();
        
        flash_success(lang('success delete picture'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete picture'));
      } // try
      
      $this->redirectToUrl($redirect_to);
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
        $this->redirectTo('contact');
      } // if
      
      if(!$contact->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('contact');
      } // if
      
      try {
        
        DB::beginWork();
        $contact->delete();
        DB::commit();
        
        flash_success(lang('success delete contact', $contact->getDisplayName()));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete contact'));
      } // try
      
      $this->redirectTo('contact', 'list_all');
    } // delete
 
    function assign_to_project()
    {
    	$contact = Contacts::findById(get_id());
    	$projects = Projects::getActiveProjects();
    	$contactRoles = ProjectContacts::getRolesByContact($contact);
    	 
    	$contact_data = array_var($_POST, 'contact');
    	$wasntarray = false;
    	if(!is_array($contact_data)) {
    		$wasntarray = true;
    		foreach($projects as $project)
    		{
    			$contact_data['pid_'.$project->getId()] = false;
    			$contact_data['role_pid_'.$project->getId()] = '';
    			
    			if($contactRoles)
    			{
    				foreach($contactRoles as $cr)
    				{
    					if ($project->getId() == $cr->getProjectId())
    					{
    						$tagNames = $cr->getTagNames();
        					$contact_data['tag_'.$project->getId()] = is_array($tagNames) ? implode(', ', $tagNames) : '';
    						$contact_data['pid_'.$project->getId()] = true;
    						$contact_data['role_pid_'.$project->getId()] = $cr->getRole();
    					}
    				}
    			}
    		}
    	} // if

    	tpl_assign('contact', $contact);
    	tpl_assign('contact_data', $contact_data);
    	tpl_assign('projects', $projects);

    	if(!$wasntarray)
    	{
    		try
    		{
    			DB::beginWork();
    			foreach($projects as $project)
    			{
    				if(!isset($contact_data['pid_'.$project->getId()]))
    				{
    					ProjectContacts::deleteRole($contact,$project);
    				}
    				else
    				{
    					$role = $contact_data['role_pid_'.$project->getId()];
    					$pc = ProjectContacts::getRole($contact,$project);
    					if ($pc)
    					{
    						if ($pc->getRole() != $role)
    						{
    							$pc->setRole($role);
    							$pc->save();
          
          						ApplicationLogs::createLog($contact, $project, ApplicationLogs::ACTION_EDIT);
    						}
    					} 
    					else
    					{
    						$pc = new ProjectContact();
    						$pc->setProjectId($project->getId());
    						$pc->setContactId($contact->getId());
    						$pc->setRole($role);
    						$pc->save();
          					ApplicationLogs::createLog($contact, $project, ApplicationLogs::ACTION_ADD);
    					}
    					if (isset($contact_data['tag_'.$project->getId()]) && array_var($contact_data, 'tag_'.$project->getId()) != "")
    						$pc->setTagsFromCSV(array_var($contact_data, 'tag_'.$project->getId()));
    					else
    						$pc->clearTags();
    				}//if else
    			}//foreach
    			DB::commit();
    			 
    			flash_success(lang('success edit contact', $contact->getDisplayName()));
    			$this->redirectToUrl($contact->getCardUrl());
    		} catch(Exception $e) {
    			DB::rollback();
    			tpl_assign('error', $e->getMessage());
    		} // try
    	} // if
    }
    
  } // ContactController

?>