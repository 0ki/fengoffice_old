<?php
class SearchController extends ApplicationController {
	
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct
	
	
	/**
	 * Execute search
	 *
	 * @param void
	 * @return null
	 */
	function search() {
		if(active_project() && !logged_user()->isProjectUser(active_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$pageType = array_var($_GET, 'page_type');
		$search_for = array_var($_GET, 'search_for');
		
		$objectManagers = array("ProjectWebpages", "ProjectMessages", "MailContents", 
			"ProjectFileRevisions", "ProjectMilestones", "ProjectTasks");
		$objectTypes = array(lang('webpages'), lang('messages'), lang('emails'), 
			lang('files'), lang('milestones'), lang('tasks'));
		$iconTypes = array('webpage', 'message', 'email', 
			'file', 'milestone', 'task');
		
		$search_results = array();
		
		$timeBegin = microtime(true);
		if(trim($search_for) == '') {
			$search_results = null;
			$pagination = null;
		} else {
			if(active_project())
				$projects = active_project()->getId();
			else 
				$projects = logged_user()->getActiveProjectIdsCSV();
			
				$c = 0;
			foreach ($objectManagers as $om){
				$results = SearchableObjects::searchByType($search_for, $projects, $om, true, 5);
				if (count($results[0]) > 0){
					$sr = array();
					$sr['result'] = $results[0];
					$sr['pagination'] = $results[1];
					$sr['type'] = $objectTypes[$c];
					$sr['icontype'] = $iconTypes[$c];
					$sr['manager'] = $om;
					$search_results[] = $sr;
				}
				$c++;
			}
			if ( (logged_user()))
				$search_results = $this->searchContacts($search_for,$search_results,5);
		} // if
		$timeEnd = microtime(true);
		
		tpl_assign('search_string', $search_for);
		tpl_assign('search_results', $search_results);
		tpl_assign('time', $timeEnd - $timeBegin);
		ajx_set_no_toolbar(true);
	} // search
	
	function searchContacts($search_term, $search_results = null, $row_count = 5){
		if (!is_array($search_results))
			$search_results = array();
			
		$results = SearchableObjects::searchByType($search_term, '0', 'Contacts', true, $row_count);
		if (count($results[0]) > 0){
			$sr = array();
			$sr['result'] = $results[0];
			$sr['pagination'] = $results[1];
			$sr['type'] = lang('contacts');
			$sr['icontype'] = 'contact';
			$sr['manager'] = 'Contacts';
			$search_results[] = $sr;
		}
		
		return $search_results;
	}
	
	/**
	 * Execute search
	 *
	 * @param void
	 * @return null
	 */
	function searchbytype() {
		$this->setTemplate('search');
		
		if(active_project() && !logged_user()->isProjectUser(active_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$page = array_var($_GET, 'page');
		$pageType = array_var($_GET, 'page_type');
		$search_for = array_var($_GET, 'search_for');
		$manager = array_var($_GET, 'manager');
		
		$objectManagers = array("ProjectWebpages", "ProjectMessages", "MailContents",
			 "ProjectFileRevisions", "ProjectMilestones", "ProjectTasks");
		$objectTypes = array(lang('webpages'), lang('messages'), lang('emails'), 
			lang('files'), lang('milestones'), lang('tasks'));
		$iconTypes = array('webpage', 'message', 'email', 
			'file', 'milestone', 'task');
		
		$search_results = array();
		
		$timeBegin = microtime(true);
		if(trim($search_for) == '') {
			$search_results = null;
			$pagination = null;
		} else {
			if(active_project())
				$projects = active_project()->getId();
			else 
				$projects = logged_user()->getActiveProjectIdsCSV();
			
			$results = SearchableObjects::searchByType($search_for, $projects, $manager, true, 30,$page);
			if (count($results[0]) > 0){
				$c = array_search($manager, $objectManagers);
				$sr = array();
				$pagination = $results[1];
				$sr['result'] = $results[0];
				$sr['pagination'] = $pagination;
				$sr['type'] =  $objectTypes[$c];
				$sr['icontype'] = $iconTypes[$c];
				$sr['manager'] = $manager;
				$search_results[] = $sr;
			}
		} // if
		$timeEnd = microtime(true);
		
		tpl_assign('search_string', $search_for);
		tpl_assign('search_results', $search_results);
		tpl_assign('time', $timeEnd - $timeBegin);
		tpl_assign('enable_pagination', true);
	} // search
}
?>