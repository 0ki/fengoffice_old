<?php

  /**
  * Webpage controller
  *
  * @version 1.0
  * @author Carlos Palma <chonwil@gmail.com>
  */
  class WebpageController extends ApplicationController {
  
    /**
    * Construct the WebpageController
    *
    * @access public
    * @param void
    * @return WebpageController
    */
    function __construct() {
      parent::__construct();
      if (is_ajax_request()) {
		prepare_company_website_controller($this, 'ajax');
	  } else {
		prepare_company_website_controller($this, 'website');
	  }
    } // __construct
    
    /**
    * Return project webpages
    *
    * @access public
    * @param void
    * @return array
    */
    function index() {
      $this->addHelper('textile');
      if(active_project()){
	      $conditions = logged_user()->isMemberOfOwnerCompany() ? 
	        array('`project_id` = ?', active_project()->getId()) :
	        array('`project_id` = ? AND `is_private` = ?', active_project()->getId(), 0);
      }
      else {
      	$conditions = logged_user()->isMemberOfOwnerCompany() ? 
	        array('`project_id` in (' . logged_user()->getActiveProjectIdsCSV() . ')' ) :
	        array('`project_id` = ('.logged_user()->getActiveProjectIdsCSV().') AND `is_private` = ?', 0);
      }
      
      $webpages = ProjectWebpages::findAll(array(
          'conditions' => $conditions,
          'order' => '`title` ASC'
        )
      );
      
      tpl_assign('webpages', $webpages);
      
      $this->setSidebar(get_template_path('index_sidebar', 'webpage'));
    } // index
    
    /**
    * Add webpage
    *
    * @access public
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add');
      
      if(!ProjectWebpage::canAdd(logged_user(), active_or_personal_project())) {
        	flash_error(lang('no access permissions'));
			ajx_current("empty");
      } // if
      
      $webpage = new ProjectWebpage();
      tpl_assign('webpage', $webpage);
      
      $webpage_data = array_var($_POST, 'webpage');
      if(!is_array($webpage_data)) {
        $webpage_data = array(
          'milestone_id' => array_var($_GET, 'milestone_id')
        ); // array
      } // if
      tpl_assign('webpage_data', $webpage_data);
      
      if(is_array(array_var($_POST, 'webpage'))) {
        
        try {
             if(substr($webpage_data['url'],0,7) != 'http://')
             	$webpage_data['url'] = 'http://' . $webpage_data['url'];
          $webpage->setFromAttributes($webpage_data);
          $webpage->setProjectId(active_or_personal_project()->getId());
          
          // Options are reserved only for members of owner company
          if(!logged_user()->isMemberOfOwnerCompany()) {
            $webpage->setIsPrivate(false); 
          } // if
          
          DB::beginWork();
          $webpage->save();
          $webpage->setTagsFromCSV(array_var($webpage_data, 'tags'));
		  $webpage->save_properties($webpage_data);
          ApplicationLogs::createLog($webpage, active_or_personal_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add webpage', $webpage->getTitle()));
		  ajx_current("start");
        // Error...
        } catch(Exception $e) {
            DB::rollback();
            flash_error($e);
			ajx_current("empty");
        } // try
        
      } // if
    } // add
    
    /**
    * Edit specific webpage
    *
    * @access public
    * @param void
    * @return null
    */
    function edit() {
      $this->setTemplate('add');
      
      $webpage = ProjectWebpages::findById(get_id());
      if(!($webpage instanceof ProjectWebpage)) {
        flash_error(lang('webpage dnx'));
        ajx_current("empty");
      } // if
      
      if(!$webpage->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        ajx_current("empty");
      } // if
      
      $webpage_data = array_var($_POST, 'webpage');
      if(!is_array($webpage_data)) {
        $tag_names = $webpage->getTagNames();
        $webpage_data = array(
          'url' => $webpage->getUrl(),
          'title' => $webpage->getTitle(),
          'description' => $webpage->getDescription(),
          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $webpage->isPrivate()
        ); // array
      } // if
      
      tpl_assign('webpage', $webpage);
      tpl_assign('webpage_data', $webpage_data);
      
      if(is_array(array_var($_POST, 'webpage'))) {
        try {
             if(substr($webpage_data['url'],0,7) != 'http://')
             	$webpage_data['url'] = 'http://' . $webpage_data['url'];
          $old_is_private = $webpage->isPrivate();
          $webpage->setFromAttributes($webpage_data);
          
          // Options are reserved only for members of owner company
          if(!logged_user()->isMemberOfOwnerCompany()) {
            $webpage->setIsPrivate($old_is_private);
          } // if
          
          DB::beginWork();
          $webpage->save();
          $webpage->setTagsFromCSV(array_var($webpage_data, 'tags'));
          
		  $webpage->save_properties($webpage_data);
          ApplicationLogs::createLog($webpage, $webpage->getProject(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit webpage', $webpage->getTitle()));
          ajx_current("start");
          
        } catch(Exception $e) {
          DB::rollback();
          flash_error($e);
          ajx_current("empty");
        } // try
      } // if
    } // edit
    
    /**
    * Delete specific webpage
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
      $webpage = ProjectWebpages::findById(get_id());
      if(!($webpage instanceof ProjectWebpage)) {
        flash_error(lang('webpage dnx'));
        ajx_current("empty");
      } // if
      
      if(!$webpage->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        ajx_current("empty");
      } // if
      
      try {
        
        DB::beginWork();
        $webpage->delete();
        ApplicationLogs::createLog($webpage, $webpage->getProject(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success deleted webpage', $webpage->getTitle()));
        ajx_current("start");
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete webpage'));
        ajx_current("empty");
      } // try
    } // delete
    
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
			$ids = explode(',', array_var($_GET, 'webpages'));
			list($succ, $err) = ObjectController::do_delete_objects($ids, 'ProjectWebpages');
			if ($err > 0) {
				tpl_assign('errCode', -1);
				tpl_assign('errMsg', lang('error delete webpages'));
			} else {
				tpl_assign('errCode', 0);
				tpl_assign('errMsg', lang('success delete webpages'));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'webpages'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = ObjectController::do_tag_object($tagTag, $ids, 'ProjectWebpages');
			if ($err > 0) {
				tpl_assign('errCode', -1);
				tpl_assign('errMsg', lang('error tag webpages', $err));
			} else {
				tpl_assign('errCode', 0);
				tpl_assign('errMsg', lang('success tag webpages', $succ));
			}
		}
		
      if($page < 0) $page = 1;
      
      //$conditions = logged_user()->isMemberOfOwnerCompany() ? '' : ' `is_private` = 0';
    if ($tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "project_webpages.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectWebpages' ) > 0 ";
		}
		
      if ($isProjectView)
      {
      	
      	list($webpages, $pagination) = ProjectWebpages::paginate(
      	array("conditions" => "project_id = " . active_project()->getId() ." AND " . $tagstr,
          'order' => '`title` ASC'),
      	config_option('files_per_page', 10),
      	$page
      	); // paginate
      }
      else
      {
      	list($webpages, $pagination) = ProjectWebpages::paginate(
      	array(
      	  "conditions" => $tagstr,
          'order' => '`title` ASC'
          ),
          config_option('files_per_page', 10),
          $page
          ); // paginate
      }
      
		tpl_assign('totalCount', $pagination->getTotalItems());
      	tpl_assign('webpages', $webpages);
		tpl_assign('pagination', $pagination);
		tpl_assign('tags', Tags::getTagNames());
		
		$object = array(
			"totalCount" => $pagination->getTotalItems(),
			"events" => evt_list(),
			"errorCode" => isset($errCode)?$errCode:0,
			"errorMessage" => isset($errMsg)?$errMsg:"",
			"webpages" => array()
		);
		if (isset($webpages))
		{
			foreach ($webpages as $w) {
				if ($w->getProject() instanceof Project)
					$tags = project_object_tags($w, $w->getProject(), true);
				else
					$tags = "";
					
				$object["webpages"][] = array(
				"id" => $w->getId(),
				"name" => $w->getTitle(),
				"description" => $w->getDescription(),
				"url" => $w->getUrl(),
				"tags" => $tags,
				"project" => $w->getProject()?$w->getProject()->getName():'',
				"projectId" => $w->getProjectId()
				);
			}
		}
    	tpl_assign("object", $object);
    }
  } // WebpageController

?>