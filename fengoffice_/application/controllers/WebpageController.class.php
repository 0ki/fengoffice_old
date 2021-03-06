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
		prepare_company_website_controller($this, 'website');
	} // __construct

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
			return;
		} // if

		$webpage = new ProjectWebpage();

		$webpage_data = array_var($_POST, 'webpage');
		if(!is_array($webpage_data)) {
			$webpage_data = array(
          'milestone_id' => array_var($_GET, 'milestone_id')
			); // array
		} // if

		if(is_array(array_var($_POST, 'webpage'))) {

			try {
				if(substr($webpage_data['url'],0,7) != 'http://' && substr($webpage_data['url'],0,7) != 'file://' && substr($webpage_data['url'],0,8) != 'https://' && substr($webpage_data['url'],0,6) != 'about:' && substr($webpage_data['url'],0,6) != 'ftp://')
					$webpage_data['url'] = 'http://' . $webpage_data['url'];
				$webpage->setFromAttributes($webpage_data);
	
				$project_id = $webpage_data["project_id"];
				$webpage->setProjectId($project_id);
				$webpage->setIsPrivate(false);
				// Options are reserved only for members of owner company
				if(!logged_user()->isMemberOfOwnerCompany()) {
					$webpage->setIsPrivate(false);
				} // if
	
				DB::beginWork();
				$webpage->save();
				$webpage->setTagsFromCSV(array_var($webpage_data, 'tags'));
			  $webpage->save_properties($webpage_data);
  			    $object_controller = new ObjectController();
			    $object_controller->link_to_new_object($webpage);
			  DB::commit();
	
			  ApplicationLogs::createLog($webpage, $webpage->getProject(), ApplicationLogs::ACTION_ADD);
	
			  flash_success(lang('success add webpage', $webpage->getTitle()));
			  ajx_current("back");
			  // Error...
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try

		} // if

		$webpage_data["project_id"] = active_or_personal_project()->getId();
		tpl_assign('webpage', $webpage);
		tpl_assign('webpage_data', $webpage_data);
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
			return;
		} // if

		if(!$webpage->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$webpage_data = array_var($_POST, 'webpage');
		if(!is_array($webpage_data)) {
			$tag_names = $webpage->getTagNames();
			$webpage_data = array(
          'url' => $webpage->getUrl(),
          'title' => $webpage->getTitle(),
          'project_id' => $webpage->getProjectId(),
          'description' => $webpage->getDescription(),
          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $webpage->isPrivate()
			); // array
		} // if

		if(is_array(array_var($_POST, 'webpage'))) {
			try {
//				if(substr($webpage_data['url'],0,7) != 'http://')
//				$webpage_data['url'] = 'http://' . $webpage_data['url'];
				$old_is_private = $webpage->isPrivate();
				$webpage->setFromAttributes($webpage_data);

				$project_id = $webpage_data["project_id"];
				$webpage->setProjectId($project_id);

				// Options are reserved only for members of owner company
				if(!logged_user()->isMemberOfOwnerCompany()) {
					$webpage->setIsPrivate($old_is_private);
				} // if

				DB::beginWork();
				$webpage->save();
				$webpage->setTagsFromCSV(array_var($webpage_data, 'tags'));
		  $webpage->save_properties($webpage_data);
		  DB::commit();

		  ApplicationLogs::createLog($webpage, $webpage->getProject(), ApplicationLogs::ACTION_EDIT);

		  flash_success(lang('success edit webpage', $webpage->getTitle()));
		  ajx_current("back");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if

		tpl_assign('webpage', $webpage);
		tpl_assign('webpage_data', $webpage_data);
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
			return;
		} // if

		if(!$webpage->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$webpage->delete();
			ApplicationLogs::createLog($webpage, $webpage->getProject(), ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success deleted webpage', $webpage->getTitle()));
			ajx_current("back");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete webpage'));
			ajx_current("empty");
		} // try
	} // delete

	function list_all()
	{
		ajx_current("empty");

		$pid = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($pid);
		$isProjectView = ($project instanceof Project);
		 
		$start = (integer)array_var($_GET,'start');
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
				flash_error(lang('error delete objects'), $err);
			} else {
				flash_success(lang('success delete objects'), $succ);
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'webpages'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = ObjectController::do_tag_object($tagTag, $ids, 'ProjectWebpages');
			if ($err > 0) {
				flash_error(lang('error tag objects', $err));
			} else {
				flash_success(lang('success tag objects', $succ));
			}
		}
		
		if ($isProjectView) {
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}

		$result = ProjectWebpages::getWebpages($pids,$tag,$page,$limit);
		if (is_array($result)) {
			list($webpages, $pagination) = $result;
			if ($pagination->getTotalItems() < (($page - 1) * $limit)){
				$start = 0;
				$page = 1;
				$result = ProjectWebpages::getWebpages($pids,$tag,$page,$limit);
				if (is_array($result)) {
					list($webpages, $pagination) = $result;
				}else {
					$webpages = null;
					$pagination = 0 ;
				} // if
			}
		} else {
			$webpages = null;
			$pagination = 0 ;
		} // if
		/*tpl_assign('totalCount', $pagination->getTotalItems());
		tpl_assign('webpages', $webpages);
		tpl_assign('pagination', $pagination);
		tpl_assign('tags', Tags::getTagNames());*/

		$object = array(
			"totalCount" => $pagination->getTotalItems(),
			"start" => $start,
			"webpages" => array()
		);
		if (isset($webpages))
		{
			foreach ($webpages as $w) {
				if ($w->getProject() instanceof Project)
				$tags = project_object_tags($w);
				else
				$tags = "";
					
				$object["webpages"][] = array(
				"id" => $w->getId(),
				"name" => $w->getTitle(),
				"description" => $w->getDescription(),
				"url" => $w->getUrl(),
				"tags" => $tags,
				"wsIds" => $w->getProjectId(),
				);
			}
		}
		ajx_extra_data($object);
		/*tpl_assign("listing", $object);*/
	}
} // WebpageController

?>