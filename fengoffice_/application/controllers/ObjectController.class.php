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
      if (array_var($_GET,'ajax')) {
			prepare_company_website_controller($this, 'ajax');
		} else {
			prepare_company_website_controller($this, 'website');
		}
	} // __construct
	
	// ---------------------------------------------------
	//  Link / Unlink
	// ---------------------------------------------------
	
	function link_object(){		
		$manager_class = array_var($_GET, 'manager');
		$object_id = get_id('object_id');
	  
		$object = get_object_by_manager_and_id($object_id, $manager_class);
		if(!($object instanceof ApplicationDataObject)) {
			flash_error(lang('no access permissions'));
			//$this->redirectToReferer(get_url('dashboard'));
			ajx_current("empty");
			return;
		} // if
		if(!($object->canEdit(logged_user()))){
			flash_error(lang('no access permissions'));
			//$this->redirectToReferer(get_url('dashboard'));
			ajx_current("empty");
			return;
		} // if
		$rel_manager_class = array_var($_GET, 'rel_manager');
		$rel_object_id = get_id('rel_object_id');
	  
		$rel_object = get_object_by_manager_and_id($rel_object_id, $rel_manager_class);
		if(!($rel_object instanceof ApplicationDataObject)) {
			flash_error(lang('no access permissions'));
			//$this->redirectToReferer(get_url('dashboard'));
			ajx_current("empty");
			return;
		} // if
		if(!($rel_object->canEdit(logged_user()))){
			flash_error(lang('no access permissions'));
			//$this->redirectToReferer(get_url('dashboard'));
			ajx_current("empty");
			return;
		} // if
		
		try{
			DB::beginWork();
			$object->linkObject($rel_object);
			DB::commit();
			flash_success(lang('success link object'));
			$this->redirectToUrl($object->getObjectUrl());		
		} catch(Exception $e){
			flash_error($e->getMessage());
			ajx_current("empty");
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
		if(!($object1 instanceof ProjectDataObject)|| !($object2 instanceof ProjectDataObject)) {
			flash_error(lang('no access permissions'));
			//$this->redirectToReferer(get_url('dashboard'));
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
			//$this->redirectToReferer(get_url('dashboard'));
			ajx_current("empty");
			return;
		} // if
	  
		try {
			DB::beginWork();
			$linked_object->delete();
			DB::commit();
			
			flash_success(lang('success unlink object'));
			$this->redirectToReferer($object1->getObjectUrl());
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
          	ApplicationLogs::createLog($obj, active_project(), ApplicationLogs::ACTION_EDIT);  
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
          	ApplicationLogs::createLog($obj, active_project(), ApplicationLogs::ACTION_EDIT);  
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
	static function getDashboardObjectQueries($project = null, $tag = null, $count = false){
		if (isset($project)) {
    		$proj_ids = $project->getAllSubWorkspacesCSV(true, logged_user());
    	} else {
    		$proj_ids = logged_user()->getActiveProjectIdsCSV();
    	}
    	$proj_cond = ' project_id in (' . $proj_ids . ')';
    	if(isset($tag) && $tag && $tag!='')
    		$tag_str = " AND exists (SELECT * from " . TABLE_PREFIX . "tags t WHERE tag='".$tag."' AND oid=t.rel_object_id AND t.rel_object_manager=object_manager) ";
    	else
    		$tag_str= ' ';
    	$unclassifiedMails = "";
    	if (!isset($project)){
    		$accountIds = logged_user()->getMailAccountIdsCSV();
    		if ($accountIds != "")
    			$unclassifiedMails = " union SELECT 'MailContents' as object_manager, id as oid, sent_date as last_update FROM " . TABLE_PREFIX . "mail_contents co WHERE account_id in (" . $accountIds . ") " . $tag_str;
    	}
    	$res = array();
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectMessages::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Messages']  = "SELECT  'ProjectMessages' as object_manager, id as oid, updated_on as last_update FROM " . 
					TABLE_PREFIX . "project_messages co WHERE " . $proj_cond . $tag_str . $permissions;
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectEvents::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Calendar'] = "SELECT  'ProjectEvents' as object_manager, id as oid, updated_on as last_update FROM " . 
					TABLE_PREFIX . "project_events co WHERE  " . $proj_cond . $tag_str . $permissions;
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectFiles::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Documents'] = "SELECT  'ProjectFiles' as object_manager, id as oid, updated_on as last_update FROM " . 
					TABLE_PREFIX . "project_files co WHERE " . $proj_cond . $tag_str . $permissions;
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Tasks'] = "SELECT  'ProjectTasks' as object_manager, id as oid, updated_on as last_update FROM " . 
					TABLE_PREFIX . "project_tasks co WHERE parent_id=0 AND " . $proj_cond . $tag_str . $permissions;
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectMilestones::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Milestones'] = "SELECT  'ProjectMilestones' as object_manager, id as oid, updated_on as last_update FROM " . 
					TABLE_PREFIX . "project_milestones co WHERE " . $proj_cond . $tag_str . $permissions;
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectWebpages::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Web Pages'] = "SELECT  'ProjectWebPages' as object_manager, id as oid, created_on as last_update FROM " . 
					TABLE_PREFIX . "project_webpages co WHERE " . $proj_cond . $tag_str . $permissions;
		$permissions = ' AND ( ' . permissions_sql_for_listings(MailContents::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		$res['Emails'] = "SELECT  'MailContents' as object_manager, id as oid, sent_date as last_update FROM " . 
					TABLE_PREFIX . "mail_contents co WHERE " . $proj_cond . $tag_str . $permissions . $unclassifiedMails;
		$permissions = ' AND ( ' . permissions_sql_for_listings(Contacts::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id','co') .')';
		if (isset($project)) {
			$res['Contacts'] = "SELECT 'Contacts' as object_manager, id as oid, created_on as last_update FROM " . 
					TABLE_PREFIX . "contacts co WHERE exists (SELECT * FROM " . 
					TABLE_PREFIX . "project_contacts pc WHERE pc.contact_id = co.id and ". $proj_cond.	")" .
					str_replace('=object_manager',"='ProjectContacts'",$tag_str) . $permissions;
		} else{
			$res['Contacts'] = "SELECT 'Contacts' as object_manager, id as oid, created_on as last_update FROM " . 
						TABLE_PREFIX . "contacts co WHERE '1' = '1' " . str_replace('=object_manager',"='Contacts'",$tag_str) . $permissions;
		}
		if($count){
			foreach ($res as $p => $q){
				$res[$p] ="SELECT count(*) as quantity, '$p' as objectName FROM ( $q ) table_alias";
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
    function getDashboardObjects($page, $objects_per_page, $tag=null, $order=null, $order_dir=null, $type = null, $project = null){
    	///TODO: this method is horrible on performance and should not be here!!!!
    	$queries = $this->getDashboardObjectQueries($project, $tag, false);
		if(isset($type) && $type){
			$query = $queries[$type];
		} //if $type
		else {
			$query = '';
			foreach ($queries as $q){
				if($query == '')
					$query = $q;
				else 
					$query .= " \n union \n" . $q;
			}

		}
		if($order){
			$query .= " order by " . mysql_real_escape_string($order) ." ";
			if($order_dir)
				$query .= " " . mysql_real_escape_string($order_dir) . " ";
		}
		else 
			$query .= " order by last_update desc ";
		if($page && $objects_per_page){
			$start=($page-1) * $objects_per_page ;
			$query .=  " limit " . $start . "," . $objects_per_page. " ";
		}		
		elseif($objects_per_page)
			$query .= " limit " . $objects_per_page;
		
    	$res = DB::execute($query);
    	$objects = array();
    	if(!$res)  return $objects;
    	$rows=$res->fetchAll();
    	if(!$rows)  return $objects;
    	$i=1;
    	foreach ($rows as $row){
    		$manager= $row['object_manager'];
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
	function countDashboardObjects($tag = null, $type = null, $project = null){
		  ///TODO: this method is also horrible in performance and should not be here!!!!
    	$queries = $this->getDashboardObjectQueries($project, $tag, true);
		if(isset($type) && $type){
			$query = $queries[$type];
		} //if $type
		else {
			$query = '';
			foreach ($queries as $q){
				if($query == '')
					$query = $q;
				else 
					$query .= " \n union \n" . $q;
			}
		}
		$ret = 0;
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
		$page = (integer) ($start / $limit) + 1;
		$hide_private = !logged_user()->isMemberOfOwnerCompany();
		$project = array_var($_GET,'active_project');
		$tag = array_var($_GET,'tag');
		$type = array_var($_GET,'type');
		$user = array_var($_GET,'user');

		/* if there's an action to execute, do so */
		if (array_var($_GET, 'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'objects'));
			list($succ, $err) = $this->do_delete_objects($ids);
			if ($err > 0) {
				flash_error(lang('error delete objects', $err));
			} else {
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
		}
		$result = null;
		
		/* perform queries according to type*/
		//$result = $this->getDashboardObjects($page, config_option('files_per_page'), $tag, $order, $orderdir, $type);
		$project_id = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($project_id);
		$result = $this->getDashboardObjects($page, config_option('files_per_page'), $tag, null, null, $type, $project);
		if(!$result)
			$result = array();
		$total_items=$this->countDashboardObjects($tag, $type, $project);
				
		/* prepare response object */
		$listing = array(
			"totalCount" => $total_items,
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
					if ($obj instanceof ProjectDataObject && $obj->isSearchable()){
						$obj->addTagsToSearchableObject();
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
	
	function do_delete_objects($ids,$manager=null) {
		$err = 0; // count errors
		$succ = 0; // count files deleted
		foreach ($ids as $id) {
			try {
				if(trim($id)!=''){					
					if($manager){
						$obj=get_object_by_manager_and_id($id,$manager);
						$obj->delete();
						ApplicationLogs::createLog($obj, $obj->getProject(), ApplicationLogs::ACTION_DELETE);
					}
					else{ //call from dashboard, format is manager:id
						$split=explode(":",$id);
						$obj = get_object_by_manager_and_id($split[1],$split[0]);
						$obj->delete();
						ApplicationLogs::createLog($obj, $obj->getProject(), ApplicationLogs::ACTION_DELETE);
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
}
?>