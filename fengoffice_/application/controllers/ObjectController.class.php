<?php

/**
* Controller that is responsible for handling objects linking related requests
*
* @version 1.0
* @author Ilija Studen <ilija.studen@gmail.com>
*/
class ObjectController extends ApplicationController {

	function index(){
		$this->setLayout('html');
		
	}
	/**
	* Construct the ObjectController
	*
	* @access public
	* @param void
	* @return ObjectController
	*/
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct
	
	function add_subscribers(ProjectDataObject $object) {
		$subscribers = array_var($_POST, 'subscribers');
		$object->clearSubscriptions();
		if (is_array($subscribers)) {
			foreach ($subscribers as $key => $checked) {
				$user_id = substr($key, 5);
				if ($checked == "checked") {
					$user = Users::findById($user_id);
					if ($user instanceof User) {
						$object->subscribeUser($user);
					}
				}
			}
		}
	}
	
	function render_add_subscribers() {
		$ws_ids = array_var($_GET, 'workspaces', '');
		$uids = array_var($_GET, 'users', '');
		$genid = array_var($_GET, 'genid', '');
		$type = array_var($_GET, 'object_type', '');
		$workspaces = Projects::findByCSVIds($ws_ids);
		$subscriberIds = split(",", $uids);
		
		tpl_assign('type', $type);
		tpl_assign('workspaces', $workspaces);
		tpl_assign('subscriberIds', $subscriberIds);
		tpl_assign('genid', $genid);
		$this->setLayout("html");
		$this->setTemplate("add_subscribers");
	}
	
	function add_custom_properties($object) {
		$object->clearObjectProperties();
		$names = array_var($_POST, 'custom_prop_names');
		$values = array_var($_POST, 'custom_prop_values');
		if (!is_array($names)) return;
		for ($i=0; $i < count($names); $i++) {
			$name = trim($names[$i]);
			$value = trim($values[$i]);
			if ($name != '' && $value != '') {
				$property = new ObjectProperty();
				$property->setObject($object);
				$property->setPropertyName($name);
				$property->setPropertyValue($value);
				$property->save();
				if ($object->isSearchable()) {
					$object->addPropertyToSearchableObject($property);
				}
			}
		}
	}
	
	// ---------------------------------------------------
	//  Link / Unlink
	// ---------------------------------------------------
	
	function link_object() {
		ajx_current("empty");
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
	  
		$object = get_object_by_manager_and_id($object_id, $manager_class);
		if(!($object instanceof ApplicationDataObject)) {
			flash_error(lang('no access permissions'));
			return;
		} // if
		if(!($object->canLinkObject(logged_user()))){
			flash_error(lang('no access permissions'));
			return;
		} // if
		$str_obj = array_var($_GET, 'objects');
		if ($str_obj == null) return;
		try {
			$split = split(",", $str_obj);
			$succ = 0; $err = 0;
			foreach ($split as $objid) {
				$parts = split(":", $objid);	  
				$rel_object = get_object_by_manager_and_id($parts[1], $parts[0]);
				if (!($rel_object instanceof ApplicationDataObject)) {
					$err++;
					continue;
				} // if
				if (!($rel_object->canLinkObject(logged_user()))) {
					$err++;
					continue;
				} // if
				try {
					$object->linkObject($rel_object);
					if ($object instanceof ProjectDataObject) {
						ApplicationLogs::createLog($object, $object->getWorkspaces(), ApplicationLogs::ACTION_LINK, false, null, true, $objid);
					}
					if ($rel_object instanceof ProjectDataObject) {
						ApplicationLogs::createLog($rel_object, $rel_object->getWorkspaces(), ApplicationLogs::ACTION_LINK, false, null, true, get_class($object->manager()) . ':' . $object->getId());
					}
					$succ++;
				} catch(Exception $e){
					$err++;
				}
			}
			$message = "";
			if ($err > 0) {
				$message .= lang("error link object", $err) . "\n";
			}
			if ($succ > 0) {
				$message .= lang("success link objects", $succ) . "\n";
			}
			if ($succ == 0 && $err > 0) {
				flash_error($message);
			} else if ($succ > 0) {
				flash_success($message);
			}
			ajx_current("reload");
		} catch (Exception $e) {
			flash_error($e->getMessage());
			ajx_current("empty");
		}
	}
	
	/**
	* Function called from other controllers when creating a new object an linking objects to it
	*
	* @param void
	* @return null
	*/
	function link_to_new_object($the_object){
		if (!$the_object->isNew() && !$the_object->canLinkObject(logged_user())) {
			flash_error(lang("user cannot link objects"));
			return;
		}
		$objects = array_var($_POST, 'linked_objects');
		$the_object->clearLinkedObjects();
		if (is_array($objects)) {
			$err = 0;
			foreach ($objects as $objid) {
				$split = split(":", $objid);
				$object = get_object_by_manager_and_id($split[1], $split[0]);
				if ($object->canLinkObject(logged_user())) {
					$the_object->linkObject($object);
					if ($the_object instanceof ProjectDataObject)
						ApplicationLogs::createLog($the_object, $the_object->getWorkspaces(), ApplicationLogs::ACTION_LINK,false,null,true,get_class($object->manager()).':'.$object->getId());
					if ($object instanceof ProjectDataObject)
						ApplicationLogs::createLog($object, $object->getWorkspaces(), ApplicationLogs::ACTION_LINK,false,null,true,get_class($the_object->manager()).':'.$the_object->getId());
				} else {
					$err++;
				}
			}
			if ($err > 0) {
				flash_error(lang('some objects could not be linked'));
			}
		}
	}
	
	/**
	* Link object to the object
	*
	* @param void
	* @return null
	*/
	function link_to_object() {
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
	  
		$object = get_object_by_manager_and_id($object_id, $manager_class);
		if(!($object instanceof ProjectDataObject)) {
			flash_error(lang('no access permissions'));
			//$this->redirectToReferer(get_url('dashboard'));
			ajx_current("empty");
			return;
		} // if
	  
		$already_linked_objects = $object->getLinkedObjects();
		$already_linked_objects_ids = null;
		if(is_array($already_linked_objects)) {
			$already_linked_objects_ids = array();
			foreach($already_linked_objects as $already_linked_object) {
				$already_linked_objects_ids[] = $already_linked_object->getId();
			} // foreach
		} // if
	  
		$link_data = array_var($_POST, 'link');
		if(!is_array($link_data)) {
			$link_data = array('what' => 'existing_object');
		} // if
	  
		tpl_assign('link_to_object', $object);
		tpl_assign('link_data', $link_data);
		tpl_assign('already_linked_objects_ids', $already_linked_objects_ids);
	  
		if(is_array(array_var($_POST, 'link'))) {
		  
			if(array_var($link_data, 'what') == 'existing_object') {
				$link_data_info  = explode('::',array_var($link_data, 'object_id'));
				echo $link_data_info [0] . '-' . $link_data_info [1]; 
				$object2 = get_object_by_manager_and_id($link_data_info[0],$link_data_info[1]);
				if(!($object2 instanceof ProjectDataObject )) {
					flash_error(lang('no object to link'));
					$this->redirectToUrl($object->getLinkedObjectsUrl());
				} // if
				$linked_objects[] = $object2;
			} elseif(array_var($link_data, 'what') == 'new_object') {
				try {
					$linked_objects = ProjectFiles::handleHelperUploads(active_project());
				} catch(Exception $e) {
					flash_error(lang('error upload file'));
					$this->redirectToUrl($object->getLinkedObjectsUrl());
				} // try
			} // if
		
			if(!is_array($linked_objects) || !count($linked_objects)) {
				flash_error(lang('no objects to link'));
				$this->redirectToUrl($object->getLinkedObjectsUrl());
			} // if
			
			try {
				DB::beginWork();
			  
				$counter = 0;
				foreach($linked_objects as $linked_object) {
					$object->linkObject($linked_object);
					if ($object instanceof ProjectDataObject)
						ApplicationLogs::createLog($object, $object->getWorkspaces(), ApplicationLogs::ACTION_LINK,false,null,true,get_class($linked_object->manager()).':'.$linked_object->getId());
					if ($linked_object instanceof ProjectDataObject)
						ApplicationLogs::createLog($linked_object, $linked_object->getWorkspaces(), ApplicationLogs::ACTION_LINK,false,null,true,get_class($object->manager()).':'.$object->getId());
					$counter++;
				} // foreach
			  
				DB::commit();
				flash_success(lang('success link objects', $counter));
				$this->redirectToUrl($object->getObjectUrl());
			} catch(Exception $e) {
				DB::rollback();
			  
				if(array_var($link_data, 'what') == 'new_object' && count($linked_objects)) {
					foreach($linked_objects as $linked_object) {
					$linked_object->delete();
					} // foreach
				} // if
			    flash_error($e->getMessage());
			    ajx_current("empty");
			} // try
		} // if
	} // link_to_object
    
	/**
	* Unlink object from related object
	*
	* @param void
	* @return null
	*/
	function unlink_from_object() { // ex detach_from_object() {
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$rel_object_id = get_id('rel_object_id');
		$rel_object_manager = array_var($_GET, 'rel_object_manager');
	  
		$object1 = get_object_by_manager_and_id($object_id, $manager_class);
		$object2 = get_object_by_manager_and_id($rel_object_id, $rel_object_manager);
		if(!($object1 instanceof ApplicationDataObject)|| !($object2 instanceof ApplicationDataObject)) {
			flash_error(lang('object not found'));
			ajx_current("empty");
			return;
		} // if
	  
		$linked_object = LinkedObjects::findById(array(
			'rel_object_manager' => $manager_class,
			'rel_object_id' => $object_id,
			'object_id' => $rel_object_id,
			'object_manager' => $rel_object_manager,
		)); // findById
	  	if(!($linked_object instanceof LinkedObject ))
	  	{ //search for reverse link
			$linked_object = LinkedObjects::findById(array(
				'rel_object_manager' => $rel_object_manager,
				'rel_object_id' => $rel_object_id,
				'object_id' => $object_id,
				'object_manager' => $manager_class,
			)); // findById
		}
		
		if(!($linked_object instanceof LinkedObject )) {
			flash_error(lang('object not linked to object'));
			ajx_current("empty");
			return;
		} // if
	  
		try {
			DB::beginWork();
			$linked_object->delete();
			
			if ($object1 instanceof ProjectDataObject)
				ApplicationLogs::createLog($object1, $object1->getWorkspaces(), ApplicationLogs::ACTION_UNLINK,false,null,true,get_class($object2->manager()).':'.$object2->getId());
			if ($object2 instanceof ProjectDataObject)
				ApplicationLogs::createLog($object2, $object2->getWorkspaces(), ApplicationLogs::ACTION_UNLINK,false,null,true,get_class($object1->manager()).':'.$object1->getId());
			DB::commit();
			
			flash_success(lang('success unlink object'));
			ajx_current("reload");
		} catch(Exception $e) {
			flash_error(lang('error unlink object'));
			DB::rollback();
			ajx_current("empty");
		} // try
	  
	} // unlink_from_object
	
	
	/**
	 * Show property list
	 * 
	 * @param 
	 * @return ObjectProperties
	 */
	function view_properties()
	{
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$obj = get_object_by_manager_and_id ($object_id, $manager_class);
		
		if (!($obj instanceof ProjectDataObject ))
		{
	        flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
		}
		$properties = ObjectProperties::getAllPropertiesByObject($obj);
		if(!($properties instanceof ObjectProperties ))
		{
	        flash_error(lang('properties dnx'));
			ajx_current("empty");
			return;    			
		}
		tpl_assign('properties', $properties);
	} // view_properties
	
	/**
    * Update, delete and add new properties
    *
    * @access public
    * @param void
    * @return null
    */
    function update_properties() {
      	$this->setTemplate('add_properties');
      
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$obj = get_object_by_manager_and_id ($object_id, $manager_class);
	    if(!($obj instanceof ProjectDataObject )) {
	        flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
	    } // if
      
	    if(! logged_user()->getCanManageProperties()) {
	        flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
	    } // if
      
      $new_properties = array_var($_POST, 'new_properties');
      $update_properties = array_var($_POST, 'update_properties');
      $delete_properties = array_var($_POST, 'delete_properties');
      if(is_array(array_var($_POST, 'new_properties')) || is_array(array_var($_POST, 'update_properties')) || is_array(array_var($_POST, 'delete_handins'))) {
        
        try {
		    DB::beginWork();
		    //add new properties
            foreach ($new_properties as $prop) {
            	$property = new ObjectProperty();
	        	$property->setFromAttributes($prop);
	        	$property->setRelObjectId($object_id);
	        	$property->setRelObjectManager($manager_class);
	        	$property->save();        		
	        }	        
	        foreach ($update_properties as $prop) {	        	
            	$property = ObjectProperties::getProperty(array_var($prop,'id')); //ObjectProperties::getPropertyByName($obj, array_var($prop,'name'));
	        	$property->setPropertyValue(array_var($prop,'value'));
	        	$property->save();        		
	        }	        
	        foreach ($delete_properties as $prop)
	        {
	        	$property = ObjectProperties::getProperty(array_var($prop,'id')); //ObjectProperties::getPropertyByName($obj, array_var($prop,'name'));
	        	$prop->delete();
	        }
			tpl_assign('properties',ObjectProperties::getAllPropertiesByObject($obj));
          	ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_EDIT);  
          	DB::commit();
          	
        	flash_success(lang('success add properties'));
			$this->redirectToReferer($obj->getObjectUrl());
        } catch(Exception $e) {
          DB::rollback();
          flash_error($e->getMessage());
			ajx_current("empty");
        } // 
      } // if
    } // update_properties	
    
	/**
	 * Show handins list
	 * 
	 * @param 
	 * @return ObjectHandins
	 */
	function view_handins()
	{
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$obj = get_object_by_manager_and_id ($object_id, $manager_class);
		
		if (!($obj instanceof ProjectDataObject ))
		{
	        flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
		}
		$handins = ObjectHandins::getAllHandinsByObject($obj);
		if(!($handins instanceof ObjectHandins))
		{
	        flash_error(lang('handins dnx'));
			ajx_current("empty");
			return;       			
		}
		tpl_assign('handins', $handins);
	} // view_handins
	
	/**
    * Update, delete and add new handins
    *
    * @access public
    * @param void
    * @return null
    */
    function update_handins() {
      	$this->setTemplate('add_handins');
      
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$obj = get_object_by_manager_and_id ($object_id, $manager_class);
	    if(!($obj instanceof ProjectDataObject )) {
	        flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
	    } // if
      
	    if($obj->canEdit()) {
	        flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
	    } // if
      
      $new_handins = array_var($_POST, 'new_handins');
      $update_handins = array_var($_POST, 'update_handins');
      $delete_handins = array_var($_POST, 'delete_handins');
      if(is_array(array_var($_POST, 'new_handins')) || is_array(array_var($_POST, 'update_handins')) || is_array(array_var($_POST, 'delete_handins'))) {
        
        try {
		    DB::beginWork();
		    //add new handins
            foreach ($new_handins as $handin) {
            	$handin = new ObjectHandin();
	        	$handin->setFromAttributes($handin);
	        	$handin->setRelObjectId($object_id);
	        	$handin->setRelObjectManager($manager_class);
	        	$handin->save();        		
	        }	        
	        foreach ($update_handins as $handin) {	        	
            	$handin = ObjectHandins::getHandin(array_var($handin,'id')); 
	        	$handin->setFromAttributes($handin);
	        	$handin->save();        		
	        }	        
	        foreach ($delete_handins as $handin)
	        {
	        	$handin = ObjectHandins::getHandin(array_var($handin,'id')); 
	        	$handin->delete();
	        }
			tpl_assign('handins',ObjectHandins::getAllHandinsByObject($obj));
          	ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_EDIT);  
          	DB::commit();
          	
        	flash_success(lang('success add handins'));
			$this->redirectToReferer($obj->getObjectUrl());
        } catch(Exception $e) {
          DB::rollback();
          flash_error($e->getMessage());
          ajx_current("empty");
        } // 
      } // if
    } // update_handins
    
    /**
     * Returns array of queries that will return Dashboard Objects
     *
     * @param string $proj_ids
     * @param string $tag
     * @param boolean $count if false the query will return objects, if true it will return object count
     */
	static function getDashboardObjectQueries($project = null, $tag = null, $count = false, $trashed = false, $order = 'updatedOn'){
		if ($trashed) $order = 'trashedOn';
		switch ($order){
			case 'createdOn':
				$order_crit_companies = '`created_on`';
				$order_crit_contacts = '`created_on`';
				$order_crit_file_revisions = '`created_on`';
				$order_crit_calendar = '`created_on`';
				$order_crit_tasks = '`created_on`';
				$order_crit_milestones = '`created_on`';
				$order_crit_webpages = '`created_on`';
				$order_crit_files = '`created_on`';
				$order_crit_emails = '`created_on`';
				$order_crit_comments = '`created_on`';
				$order_crit_messages = '`created_on`';
				break;
			case 'trashedOn':
				$order_crit_companies = '`trashed_on`';
				$order_crit_contacts = '`trashed_on`';
				$order_crit_file_revisions = '`trashed_on`';
				$order_crit_calendar = '`trashed_on`';
				$order_crit_tasks = '`trashed_on`';
				$order_crit_milestones = '`trashed_on`';
				$order_crit_webpages = '`trashed_on`';
				$order_crit_files = '`trashed_on`';
				$order_crit_emails = '`trashed_on`';
				$order_crit_comments = '`trashed_on`';
				$order_crit_messages = '`trashed_on`';
				break;
			case 'name':
				$order_crit_companies = '`name`';
				$order_crit_contacts = "TRIM(CONCAT(' ', `lastname`, `firstname`, `middlename`))";
				$order_crit_file_revisions = "'zzzzzzzzzzzzzz'"; //Revisar
				$order_crit_calendar = '`subject`';
				$order_crit_tasks = '`title`';
				$order_crit_milestones = '`name`';
				$order_crit_webpages = '`title`';
				$order_crit_files = '`filename`';
				$order_crit_emails = '`subject`';
				$order_crit_comments = '`text`';
				$order_crit_messages = '`title`';
				break;
			default:
				$order_crit_companies = '`updated_on`';
				$order_crit_contacts = '`updated_on`';
				$order_crit_file_revisions = '`updated_on`';
				$order_crit_calendar = '`updated_on`';
				$order_crit_tasks = '`updated_on`';
				$order_crit_milestones = '`updated_on`';
				$order_crit_webpages = '`updated_on`';
				$order_crit_files = '`updated_on`';
				$order_crit_emails = '`sent_date`';
				$order_crit_comments = '`updated_on`';
				$order_crit_messages = '`updated_on`';
				break;
		}
		if (isset($project)) {
    		$proj_ids = $project->getAllSubWorkspacesCSV(true, logged_user());
    	} else {
    		$proj_ids = logged_user()->getActiveProjectIdsCSV();
    	}
    	$proj_cond = ' `project_id` IN (' . $proj_ids . ')';
    	
    	if ($trashed) {
    		$trashed_cond = '`trashed_by_id` <> 0';
    	} else {
    		$trashed_cond = '`trashed_by_id` = 0';
    	}
    	/**
    	 * In queries for companies, messages, documents and emails '$proj_cond' was replaced by '$proj_cond_comp', '$proj_cond_msgs' and '$proj_cond_docs'
    	 * because those can be in multiple workspaces
    	 */
    	$proj_cond_companies = ' `id` IN (SELECT `object_id` FROM `'.TABLE_PREFIX.'workspace_objects` WHERE `object_manager` = \'Companies\' AND `workspace_id` IN ('.$proj_ids.'))';
    	$proj_cond_messages = ' `id` IN (SELECT `object_id` FROM `'.TABLE_PREFIX.'workspace_objects` WHERE `object_manager` = \'ProjectMessages\' AND `workspace_id` IN ('.$proj_ids.'))';
    	$proj_cond_documents = ' `id` IN (SELECT `object_id` FROM `'.TABLE_PREFIX.'workspace_objects` WHERE `object_manager` = \'ProjectFiles\' AND `workspace_id` IN ('.$proj_ids.'))';
    	$proj_cond_emails = ' `id` IN (SELECT `object_id` FROM `'.TABLE_PREFIX.'workspace_objects` WHERE `object_manager` = \'MailContents\' AND `workspace_id` IN ('.$proj_ids.'))';
    	$proj_cond_events = $proj_cond;
    	$proj_cond_tasks = $proj_cond;
    	$proj_cond_charts = $proj_cond;
    	$proj_cond_milestones = $proj_cond;
    	$proj_cond_weblinks = $proj_cond;
    	$proj_cond_contacts = $proj_cond;
    	
    	if(isset($tag) && $tag && $tag!='')
    		$tag_str = " AND EXISTS (SELECT * FROM `" . TABLE_PREFIX . "tags` `t` WHERE `tag`=".DB::escape($tag)." AND `co`.`id` = `t`.`rel_object_id` AND `t`.`rel_object_manager` = `object_manager_value`) ";
    	else
    		$tag_str= ' ';
    	$unclassifiedMails = "";
    	if (!isset($project)){
    		$accountIds = logged_user()->getMailAccountIdsCSV();
    		if ($accountIds != "")
    			$unclassifiedMails = " UNION SELECT 'MailContents' AS `object_manager_value`, `id` AS `oid`, $order_crit_emails AS `order_value` FROM `" . TABLE_PREFIX . "mail_contents` `co` WHERE $trashed_cond AND `account_id` IN (" . $accountIds . ") " . str_replace('= `object_manager_value`', "= 'MailContents'", $tag_str);
    	}
    	$res = array();
    	
    	/** If the name of the query ends with Comments it is assumed to be a list of Comments **/
    	
    	// Notes
    	if (config_option("enable_notes_module")) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectMessages::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$res['Messages']  = "SELECT  'ProjectMessages' AS `object_manager_value`, `id` AS `oid`, $order_crit_messages AS `order_value` FROM `" . 
						TABLE_PREFIX . "project_messages` `co` WHERE " . $trashed_cond ." AND ".$proj_cond_messages . str_replace('= `object_manager_value`', "= 'ProjectMessages'", $tag_str) . $permissions;
			$res['MessagesComments'] = "SELECT  'Comments' AS `object_manager_value`, `id` AS `oid`, $order_crit_comments AS `order_value` FROM `" . 
						TABLE_PREFIX . "comments` WHERE $trashed_cond AND `rel_object_manager` = 'ProjectMessages' AND `rel_object_id` IN (SELECT `co`.`id` FROM `" . 
						TABLE_PREFIX . "project_messages` `co`, `" . TABLE_PREFIX . "object_subscriptions` `os` WHERE `trashed_by_id` = 0 AND " . $proj_cond_messages . str_replace('= `object_manager_value`', "= 'ProjectMessages'", $tag_str) . $permissions . " AND `co`.`id` = `os`.`object_id` AND `os`.`object_manager` = 'ProjectMessages' AND `os`.`user_id` = " . logged_user()->getId() . ")";
    	}

    	// Events
    	if (config_option("enable_calendar_module")) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectEvents::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$res['Calendar'] = "SELECT  'ProjectEvents' AS `object_manager_value`, `id` AS `oid`, $order_crit_calendar AS `order_value` FROM `" . 
						TABLE_PREFIX . "project_events` `co` WHERE  " . $trashed_cond ." AND ".$proj_cond_events . str_replace('= `object_manager_value`', "= 'ProjectEvents'", $tag_str) . $permissions;
			$res['CalendarComments'] = "SELECT  'Comments' AS `object_manager_value`, `id` AS `oid`, $order_crit_comments AS `order_value` FROM `" . 
						TABLE_PREFIX . "comments` WHERE $trashed_cond AND `rel_object_manager` = 'ProjectEvents' AND `rel_object_id` IN (SELECT `co`.`id` FROM `" . 
						TABLE_PREFIX . "project_events` `co`, `" . TABLE_PREFIX . "object_subscriptions` `os` WHERE `trashed_by_id` = 0 AND " . $proj_cond_events . str_replace('= `object_manager_value`', "= 'ProjectEvents'", $tag_str) . $permissions . " AND `co`.`id` = `os`.`object_id` AND `os`.`object_manager` = 'ProjectEvents' AND `os`.`user_id` = " . logged_user()->getId() . ")";
    	}

    	// Documents
    	if (config_option("enable_documents_module")) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectFiles::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$typestring = array_var($_GET, "typestring");
			if ($typestring) {
				$typecond = " AND  ((SELECT count(*) FROM `" . TABLE_PREFIX . "project_file_revisions` `pfr` WHERE `" .
					"pfr`.`type_string` LIKE ".DB::escape($typestring)." AND `".
					"co`.`id` = `pfr`.`file_id`) > 0)";
			} else {
				$typecond = "";
			}
			$res['Documents'] = "SELECT  'ProjectFiles' AS `object_manager_value`, `id` as `oid`, $order_crit_files AS `order_value` FROM `" . 
						TABLE_PREFIX . "project_files` `co` WHERE " . $trashed_cond ." AND ".$proj_cond_documents . str_replace('= `object_manager_value`', "= 'ProjectFiles'", $tag_str) . $permissions . $typecond;
			$res['DocumentsComments'] = "SELECT  'Comments' AS `object_manager_value`, `id` AS `oid`, $order_crit_comments AS `order_value` FROM `" . 
						TABLE_PREFIX . "comments` WHERE $trashed_cond AND `rel_object_manager` = 'ProjectFiles' AND `rel_object_id` IN (SELECT `co`.`id` FROM `" . 
						TABLE_PREFIX . "project_files` `co`, `" . TABLE_PREFIX . "object_subscriptions` `os` WHERE `trashed_by_id` = 0 AND " . $proj_cond_documents . str_replace('= `object_manager_value`', "= 'ProjectFiles'", $tag_str) . $permissions . " AND `co`.`id` = `os`.`object_id` AND `os`.`object_manager` = 'ProjectFiles' AND `os`.`user_id` = " . logged_user()->getId() . ")";
    	
	    	if ($trashed) {
				$file_rev_docs = "SELECT `id` FROM `" . TABLE_PREFIX . "project_files` `co` WHERE `trashed_by_id` = 0 AND " . $proj_cond_documents . str_replace('= `object_manager_value`', "= 'ProjectFileRevisions'", $tag_str) . $permissions . $typecond;
				$res['FileRevisions'] = "SELECT 'ProjectFileRevisions' AS `object_manager_value`, `id` AS `oid`, $order_crit_file_revisions AS `order_value` FROM `" .
						TABLE_PREFIX . "project_file_revisions` `co` WHERE $trashed_cond AND `file_id` IN (" . $file_rev_docs . ")";
			}    	
    	}

		// Tasks and Milestones
    	if (config_option("enable_tasks_module")) {
			$completed = $trashed? '': 'AND `completed_by_id` = 0';
			$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$res['Tasks'] = "SELECT  'ProjectTasks' AS `object_manager_value`, `id` AS `oid`, $order_crit_tasks AS `order_value` FROM `" . 
						TABLE_PREFIX . "project_tasks` `co` WHERE `is_template` = false $completed AND " . $trashed_cond ." AND `is_template` = false AND ".$proj_cond_tasks . str_replace('= `object_manager_value`', "= 'ProjectTasks'", $tag_str) . $permissions;
			$res['TasksComments'] = "SELECT  'Comments' AS `object_manager_value`, `id` AS `oid`, $order_crit_comments AS `order_value` FROM `" . 
						TABLE_PREFIX . "comments` WHERE $trashed_cond AND `rel_object_manager` = 'ProjectTasks' AND `rel_object_id` IN (SELECT `co`.`id` FROM `" . 
						TABLE_PREFIX . "project_tasks` `co`, `" . TABLE_PREFIX . "object_subscriptions` `os` WHERE `trashed_by_id` = 0 AND `is_template` = false AND " . $proj_cond_tasks . str_replace('= `object_manager_value`', "= 'ProjectTasks'", $tag_str) . $permissions . " AND `co`.`id` = `os`.`object_id` AND `os`.`object_manager` = 'ProjectTasks' AND `os`.`user_id` = " . logged_user()->getId() . ")";
	
			$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectMilestones::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$res['Milestones'] = "SELECT  'ProjectMilestones' AS `object_manager_value`, `id` AS `oid`, $order_crit_milestones AS `order_value` FROM `" . 
						TABLE_PREFIX . "project_milestones` `co` WHERE " . $trashed_cond ." AND `is_template` = false AND ".$proj_cond_milestones . str_replace('= `object_manager_value`', "= 'ProjectMilestones'", $tag_str) . $permissions;
			$res['MilestonesComments'] = "SELECT  'Comments' AS `object_manager_value`, `id` AS `oid`, $order_crit_comments AS `order_value` FROM `" . 
						TABLE_PREFIX . "comments` WHERE $trashed_cond AND `rel_object_manager` = 'ProjectMilestones' AND `rel_object_id` IN (SELECT `co`.`id` FROM `" . 
						TABLE_PREFIX . "project_milestones` `co`, `" . TABLE_PREFIX . "object_subscriptions` `os` WHERE `trashed_by_id` = 0 AND `is_template` = false AND " . $proj_cond_milestones . str_replace('= `object_manager_value`', "= 'ProjectMilestones'", $tag_str) . $permissions . " AND `co`.`id` = `os`.`object_id` AND `os`.`object_manager` = 'ProjectMilestones' AND `os`.`user_id` = " . logged_user()->getId() . ")";
    	}

    	// Weblinks
    	if (config_option("enable_weblinks_module")) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectWebpages::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$res['Web Pages'] = "SELECT  'ProjectWebPages' AS `object_manager_value`, `id` AS `oid`, $order_crit_webpages AS `order_value` FROM `" . 
						TABLE_PREFIX . "project_webpages` `co` WHERE " . $trashed_cond ." AND ".$proj_cond_weblinks . str_replace('= `object_manager_value`', "= 'ProjectWebpages'", $tag_str) . $permissions;
    	}

		// Email
    	if (config_option("enable_email_module")) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(MailContents::instance(), ACCESS_LEVEL_READ, logged_user(), isset($project)?$project->getId():0, '`co`') .')';
			$res['Emails'] = "SELECT  'MailContents' AS `object_manager_value`, `id` AS `oid`, $order_crit_emails AS `order_value` FROM `" . 
						TABLE_PREFIX . "mail_contents` `co` WHERE " . $trashed_cond ." AND ".$proj_cond_emails . str_replace('= `object_manager_value`', "= 'MailContents'", $tag_str) . $permissions . $unclassifiedMails;
    	}
		
    	// Conacts and Companies
    	if (config_option("enable_contacts_module")) {
			$permissions = ' AND ( ' . permissions_sql_for_listings(Companies::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`co`') .')';
			$res['Companies'] = "SELECT  'Companies' AS `object_manager_value`, `id` as `oid`, $order_crit_companies AS `order_value` FROM `" . 
						TABLE_PREFIX . "companies` `co` WHERE " . $trashed_cond ." AND ".$proj_cond_companies . str_replace('= `object_manager_value`', "= 'Companies'", $tag_str) . $permissions;
						
			if (!can_manage_contacts(logged_user())){
				$pcTableName = "`" . TABLE_PREFIX . 'project_contacts`';
				$permissions = " AND `co`.`id` IN ( SELECT `contact_id` FROM $pcTableName `pc` WHERE `pc`.`contact_id` = `co`.`id` AND (" . permissions_sql_for_listings(ProjectContacts::instance(), ACCESS_LEVEL_READ, logged_user(), '`project_id`', '`pc`') .'))';
			} else $permissions = '';
			
			if (isset($project)) {
				$res['Contacts'] = "SELECT 'Contacts' AS `object_manager_value`, `id` AS `oid`, $order_crit_contacts AS `order_value` FROM `" . 
						TABLE_PREFIX . "contacts` `co` WHERE $trashed_cond AND EXISTS (SELECT * FROM `" . 
						TABLE_PREFIX . "project_contacts` `pc` WHERE `pc`.`contact_id` = `co`.`id` AND ".$proj_cond_contacts. ")" .
						str_replace('= `object_manager_value`', "= 'Contacts'", $tag_str) . $permissions;
			} else{
				$res['Contacts'] = "SELECT 'Contacts' AS `object_manager_value`, `id` AS `oid`, $order_crit_contacts AS `order_value` FROM `" . 
						TABLE_PREFIX . "contacts` `co` WHERE $trashed_cond " . str_replace('= `object_manager_value`', "= 'Contacts'", $tag_str) . $permissions;
			}
    	}
		
		if($count){
			foreach ($res as $p => $q){
				$res[$p] ="SELECT count(*) AS `quantity`, '$p' AS `objectName` FROM ( $q ) `table_alias`";
			}
		}
		return $res;
	}
    
    /**
     *  Returns al objects that will be found on the dashboard. 
     * 	Functions used only in ObjectController
     *
     * @param int $page
     * @param int $objects_per_page
     * @param string $order 
     * @param string $order_dir can be asc or desc
     */
    function getDashboardObjects($page, $objects_per_page, $tag=null, $order=null, $order_dir=null, $type = null, $project = null, $trashed = false){
    	///TODO: this method is horrible on performance and should not be here!!!!
    	$queries = $this->getDashboardObjectQueries($project, $tag, false, $trashed, $order);
    	if (!$order_dir){
			switch ($order){
				case 'name': $order_dir = 'ASC'; break;
				default: $order_dir = 'DESC';
			}
		}
		if(isset($type) && $type){
			$query = $queries[$type];
		} //if $type
		else {
			$query = '';
			foreach ($queries as $q){
				if($query == '')
					$query = $q;
				else 
					$query .= " \n UNION \n" . $q;
			}

		}
		if($order){
			$query .= " ORDER BY `order_value` ";
			if($order_dir)
				$query .= " " . mysql_real_escape_string($order_dir) . " ";
		}
		else 
			$query .= " ORDER BY `order_value` DESC ";
		if($page && $objects_per_page){
			$start=($page-1) * $objects_per_page ;
			$query .=  " LIMIT " . $start . "," . $objects_per_page. " ";
		}		
		elseif($objects_per_page)
			$query .= " LIMIT " . $objects_per_page;
		
    	$res = DB::execute($query);
    	$objects = array();
    	if(!$res)  return $objects;
    	$rows=$res->fetchAll();
    	if(!$rows)  return $objects;
    	$i=1;
    	foreach ($rows as $row){
    		$manager= $row['object_manager_value'];
    		$id = $row['oid'];
    		if($id && $manager){
    			$obj=get_object_by_manager_and_id($id,$manager);    			
    			if($obj->canView(logged_user())){
    				$dash_object=$obj->getDashboardObject();
    			//	$dash_object['id'] = $i++;
    				$objects[]=$dash_object;
    			}
    			//if($manager=='ProjectWebPages')
    				//$objects[count($objects[])-1]=null;
    				
    		} //if($id && $manager)
    	}//foreach
    	return $objects;
    } //getDashboardobjects
    
    /**
     * Counts dashboard objects
     *
     * @return unknown
     */
	function countDashboardObjects($tag = null, $type = null, $project = null, $trashed = false, $order = null){
		  ///TODO: this method is also horrible in performance and should not be here!!!!
    	$queries = $this->getDashboardObjectQueries($project, $tag, true, $trashed,$order);
		if(isset($type) && $type){
			$query = $queries[$type];
		} //if $type
		else {
			$query = '';
			foreach ($queries as $q){
				if($query == '')
					$query = $q;
				else 
					$query .= " \n UNION \n" . $q;
			}
		}
		$ret = 0;
    	//echo $query;die();
		$res = DB::execute($query);	
    	if(!$res)  return $ret;
    	$rows=$res->fetchAll();
		if(!$rows) return  $ret;	
    	foreach ($rows as $row){
    		if(isset($row['quantity']))
    			$ret += $row['quantity'];
    	}//foreach
    	return $ret;
	}
	
    function list_objects() {
		ajx_current("empty");
    	
    	/* get query parameters */
		$filesPerPage = config_option('files_per_page');
		$start = array_var($_GET,'start') ? (integer)array_var($_GET,'start') : 0;
		$limit = array_var($_GET,'limit') ? array_var($_GET,'limit') : $filesPerPage;
		
		$order = array_var($_GET,'sort');
		$orderdir = array_var($_GET,'dir');
		$page = (integer) ($start / $limit) + 1;
		$hide_private = !logged_user()->isMemberOfOwnerCompany();
		$tag = array_var($_GET,'tag');
		$type = array_var($_GET,'type');
		$user = array_var($_GET,'user');
		$trashed = array_var($_GET, 'trashed', false);

		/* if there's an action to execute, do so */
		if (array_var($_GET, 'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'objects'));
			list($succ, $err) = $this->do_delete_objects($ids);
			if ($err > 0) {
				flash_error(lang('error delete objects', $err));
			} else {
				flash_success(lang('success delete objects', $succ));
			}
		} else if (array_var($_GET, 'action') == 'delete_permanently') {
			$ids = explode(',', array_var($_GET, 'objects'));
			list($succ, $err) = $this->do_delete_objects($ids, null, true);
			if ($err > 0) {
				flash_error(lang('error delete objects', $err));
			}
			if ($succ > 0) {
				flash_success(lang('success delete objects', $succ));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'objects'));
			$tagTag = array_var($_GET, 'tagTag');			
			list($succ, $err) = $this->do_tag_object($tagTag, $ids);
			if ($err > 0) {
				flash_error(lang('error tag objects', $err));
			} else {
				flash_success(lang('success tag objects', $succ));
			}
		} else if (array_var($_GET, 'action') == 'restore') {
			$ids = explode(',', array_var($_GET, 'objects'));
			$success = 0; $error = 0;
			foreach ($ids as $id) {
				$split = explode(":", $id);
				$obj = get_object_by_manager_and_id($split[1], $split[0]);
				if ($obj->canDelete(logged_user())) {
					try {
						$obj->untrash();
						ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_UNTRASH);
						$success++;
					} catch (Exception $e) {
						$error++;
					}
				} else {
					$error++;
				}
			}
			if ($success > 0) {
				flash_success(lang("success untrash objects", $success));
			}
			if ($error > 0) {
				flash_error(lang("error untrash objects", $error));
			}
		}
		$result = null;
		
		/* perform queries according to type*/
		//$result = $this->getDashboardObjects($page, config_option('files_per_page'), $tag, $order, $orderdir, $type);
		$project_id = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($project_id);
		$total_items=$this->countDashboardObjects($tag, $type, $project, $trashed);
		if ($total_items < ($page - 1) * $limit){
			$page = 1;
			$start = 0;
		}
		$result = $this->getDashboardObjects($page, $filesPerPage, $tag, $order, $orderdir, $type, $project, $trashed);
		if(!$result)
			$result = array();
				
		/* prepare response object */
		$listing = array(
			"totalCount" => $total_items,
			"start" => $start,
			"objects" => $result
		);
		ajx_extra_data($listing);
    	tpl_assign("listing", $listing);
    }
    
    function do_tag_object($tag, $ids, $manager=null) {
		$err = $succ = 0;
		foreach ($ids as $id) {
			if (trim($id) != '') {
				try {
					if($manager){
						$obj = get_object_by_manager_and_id($id,$manager);
						Tags::addObjectTag($tag, $obj, $obj->getProject());
					}
					else{ //call from dashboard, format is manager:id
						$split=explode(":",$id);
						$obj = get_object_by_manager_and_id($split[1],$split[0]);
						Tags::addObjectTag($tag, $obj, $obj->getProject());
					}
					if ($obj instanceof ProjectDataObject){
						if ($obj->isSearchable())
							$obj->addTagsToSearchableObject();
						ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_TAG,false,null,true,$tag);
					}
					$succ++;
				} catch (Exception $e) {
					$err ++;
				}
			}
		}
		return array($succ, $err);
	}
	function view(){
		$id = array_var($_GET,'id');
		$manager = array_var($_GET,'manager');
		$obj = get_object_by_manager_and_id($id,$manager);
	    if(!($obj instanceof DataObject )) {
	        flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
	    } // if
      
	    if(! $obj->canView( logged_user())) {
	        flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
	    } // if
	    
	    redirect_to($obj->getObjectUrl(),true);
	}
	
	function do_delete_objects($ids, $manager=null, $permanent = false) {
		$err = 0; // count errors
		$succ = 0; // count files deleted
		foreach ($ids as $id) {
			try {
				if (trim($id)!=''){					
					if ($manager){
						$obj = get_object_by_manager_and_id($id, $manager);
						if ($obj->canDelete(logged_user())) {
							if ($permanent || !$obj->isTrashable()) {
								$obj->delete();
							} else {
								$obj->trash();						
							}
							if (!$permanent) {
								ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
							} else {
								ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_DELETE);
							}
						}
					} else { //call from dashboard, format is manager:id
						$split = explode(":", $id);
						$obj = get_object_by_manager_and_id($split[1], $split[0]);
						if (!$obj instanceof ApplicationDataObject) {
							break;
						}
						if ($obj->canDelete(logged_user())) {
							if ($permanent || !$obj->isTrashable()) {
								$obj->delete();						
							} else {
								$obj->trash();
							}
							if (!$permanent) {
								ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
							} else {
								ApplicationLogs::createLog($obj, $obj->getWorkspaces(), ApplicationLogs::ACTION_DELETE);
							}
						}
					}
					$succ++;
				}
			} catch(Exception $e) {
				$err ++;
			} // try
		}
		return array($succ, $err);
	}

	function move() {
		ajx_current("empty");
		
		$ids = array_var($_GET, 'ids');
		if (!$ids) {
			return;
		}
		$workspace = array_var($_GET, 'workspace');
		$p = Projects::findById($workspace);
		if (!$p instanceof Project) {
			flash_error(lang("project dnx"));
			return;
		}
		$id_list = split(";", $ids);
		$err = 0;
		$succ = 0;
		foreach ($id_list as $cid) {
			list($manager, $id) = split(":", $cid);
			try {
				DB::beginWork();
				$obj = get_object_by_manager_and_id($id, $manager);
				if (!$obj) {
					$err++;
				} else {
					$obj->setColumnValue('project_id', $workspace);
					$obj->save();
					DB::commit();
					$succ++;
				}
			} catch (Exception $e) {
				$err++;
				DB::rollback();
			}
		}
		if ($err > 0) {
			flash_error(lang("error move objects", $err));
		} else {
			flash_success(lang("success move objects", $succ));
		}
	}
	
	function view_history(){
		$id = array_var($_GET,'id');
		$manager = array_var($_GET,'manager');
		$obj = get_object_by_manager_and_id($id,$manager);		
	    if(!($obj instanceof ApplicationDataObject )) {
	        flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
	    } // if      	
	    if(! $obj->canView( logged_user())) {
	        flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
	    } // if
		$logs = ApplicationLogs::getObjectLogs($obj);
		tpl_assign('object',$obj);
		tpl_assign('logs',$logs);
	}
	
	// ---------------------------------------------------
	//  Subscriptions
	// ---------------------------------------------------

	/**
	 * Subscribe to object
	 *
	 * @param void
	 * @return null
	 */
	function subscribe() {
		ajx_current("reload");
		
		$id = array_var($_GET,'id');
		$manager = array_var($_GET,'manager');
		$object = get_object_by_manager_and_id($id, $manager);
		if(!($object instanceof ApplicationDataObject)) {
			flash_error(lang('message dnx'));
			return;
		} // if

		if(!$object->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			return ;
		} // if

		try {
			$object->subscribeUser(logged_user());
			ApplicationLogs::createLog($object, $object->getWorkspaces(), ApplicationLogs::ACTION_SUBSCRIBE);
			flash_success(lang('success subscribe to object'));
		} catch (Exception $e) {
			flash_error(lang('error subscribe to object'));
		}
	} // subscribe

	/**
	 * Unsubscribe from object
	 *
	 * @param void
	 * @return null
	 */
	function unsubscribe() {
		ajx_current("reload");
		
		$id = array_var($_GET,'id');
		$manager = array_var($_GET,'manager');
		$object = get_object_by_manager_and_id($id, $manager);
		if(!($object instanceof ApplicationDataObject)) {
			flash_error(lang('message dnx'));
			return;
		} // if

		if(!$object->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			return;
		} // if

		try {
			$object->unsubscribeUser(logged_user());
			ApplicationLogs::createLog($object, $object->getWorkspaces(), ApplicationLogs::ACTION_UNSUBSCRIBE);
			flash_success(lang('success unsubscribe to object'));
		} catch (Exception $e) {
			flash_error(lang('error unsubscribe to object'));
		}
	} // unsubscribe
	
	function send_reminders() {
		ajx_current("empty");
		try {
			$sent = Notifier::sendReminders();
			flash_success("success sending reminders", $sent);
		} catch (Exception $e) {
			flash_error($e->getMessage());
		}
	}
	
	/**
	 * Properties are sent as POST name:values
	 *
	 */
	function save_properties() {
		ajx_current("empty");
		$id = array_var($_GET,'id');
		$manager = array_var($_GET,'manager');
		$object = get_object_by_manager_and_id($id, $manager);
		if (!$object->canEdit(logged_user())) {
			//flash_error(lang('no access permissions'));
			return ;
		}
		try {
			$count = 0;
			foreach ($_POST as $n => $v) {
				$object->setProperty($n, $v);
				$count++;
			}
		} catch (Exception $e) {
			
		}
	}
	
	function untrash() {
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$object = get_object_by_manager_and_id($object_id, $manager_class);
		if ($object instanceof ApplicationDataObject && $object->canDelete(logged_user())) {
			try {
				DB::beginWork();
				$object->untrash();
				$ws = $object->getWorkspaces();
				ApplicationLogs::createLog($object, $ws, ApplicationLogs::ACTION_UNTRASH);
				DB::commit();
				flash_success(lang("success untrash object"));
			} catch (Exception $e) {
				flash_error(lang("error untrash object"));
			}
		} else {
			flash_error(lang("no access permissions"));
		}
		ajx_current("back");
	}
	
	function delete_permanently() {
    	$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$object = get_object_by_manager_and_id($object_id, $manager_class);
		if ($object instanceof ProjectDataObject && $object->canDelete(logged_user())) {
			try {
				DB::beginWork();
				$ws = $object->getWorkspaces();
				$object->delete();
				ApplicationLogs::createLog($object, $ws, ApplicationLogs::ACTION_DELETE);
				flash_success(lang("success delete object"));
				DB::commit();
			} catch (Exception $e) {
				DB::rollback();
				flash_error(lang("error delete object"));
			}
		} else {
			flash_error(lang("no access permissions"));
		}
		ajx_current("back");
    }
	
	function trash() {
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
		$object = get_object_by_manager_and_id($object_id, $manager_class);
		if ($object instanceof ProjectDataObject && $object->canDelete(logged_user())) {
			try {
				DB::beginWork();
				$object->trash();
				$ws = $object->getWorkspaces();
				ApplicationLogs::createLog($object, $ws, ApplicationLogs::ACTION_TRASH);
				flash_success(lang("success trash object"));
				DB::commit();
			} catch (Exception $e) {
				DB::rollback();
				flash_error(lang("error trash object"));
			}
		} else {
			flash_error(lang("no access permissions"));
		}
		ajx_current("back");
	}
	
	/**
	 * Clears old objects in trash according to config option days_on_trash
	 *
	 */
	function purge_trash() {
		ajx_current("empty");
		try {
			$deleted = Trash::purge_trash();
			flash_success("success purging trash", $deleted);
		} catch (Exception $e) {
			flash_error($e->getMessage());
		}
	}
}
?>