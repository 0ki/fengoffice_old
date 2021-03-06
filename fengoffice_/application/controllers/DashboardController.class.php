<?php

/**
 * Dashboard controller
 *
 * @author Ilija Studen <ilija.studen@gmail.com>, Marcos Saiz <marcos.saiz@opengoo.org>
 */
class DashboardController extends ApplicationController {

	/**
	 * Construct controller and check if we have logged in user
	 *
	 * @param void
	 * @return null
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * Show dashboard index page
	 *
	 * @param void
	 * @return null
	 */
	function index() {
		$tag = array_var($_GET,'active_tag');
		
		$logged_user = logged_user();
		if (active_project() instanceof Project){
			$active_projects = active_project()->getSubWorkspaces();
			$subws = active_project()->getAllSubWorkspacesCSV();
			$wscsv = $subws != '' ? active_project()->getId() . ', ' . $subws : active_project()->getId();
		} else {
			$wscsv = $logged_user->getActiveProjectIdsCSV();
			$active_projects = $logged_user->getActiveProjects();
		}
		if(!$wscsv){
			$wscsv = "-1";
		}
		$activity_log = null;
		if(is_array($active_projects) && count($active_projects)) {
			$include_private = $logged_user->isMemberOfOwnerCompany();
			$include_silent = $logged_user->isAdministrator();

			$project_ids = array();
			foreach($active_projects as $active_project) {
				$project_ids[] = $active_project->getId();
			} // if

			$activity_log = ApplicationLogs::getOverallLogs($include_private, $include_silent, $project_ids, config_option('dashboard_logs_count', 15));
		} // if
		if(user_config_option('show charts widget')){
			$charts = ProjectCharts::findAll(array(
				'conditions' => '(project_id in ('. $wscsv . ') AND show_in_parents = 1)' 
					. (active_project() instanceof Project? ' OR (project_id = '. active_project()->getId() . ' AND show_in_project = 1)' : '')
					. ($tag? (" AND id in (SELECT rel_object_id from " . TABLE_PREFIX . "tags t WHERE tag='".$tag."' AND t.rel_object_manager='ProjectCharts')"):'')
					, 'order' => 'updated_on DESC', 'limit' => 5));
			tpl_assign('charts', $charts);
		}
		if(user_config_option('show messages widget')){
			$messages = ProjectMessages::findAll(array(
				'conditions' => 'id IN (SELECT `object_id` FROM `' .TABLE_PREFIX. "workspace_objects` WHERE `object_manager` = 'ProjectMessages' && `workspace_id` IN ($wscsv))"
					. ($tag? (" AND id in (SELECT rel_object_id from " . TABLE_PREFIX . "tags t WHERE tag='".$tag."' AND t.rel_object_manager='ProjectMessages')"):'')
					 . ' AND ' .permissions_sql_for_listings(ProjectMessages::instance(),ACCESS_LEVEL_READ,logged_user())
					, 'order' => 'updated_on DESC', 'limit' => 10));
			tpl_assign('messages', $messages);
		}
		if(user_config_option('show documents widget')){
			$documents = ProjectFiles::findAll(array(
				'conditions' => "id IN (SELECT `object_id` FROM `" .TABLE_PREFIX. "workspace_objects` WHERE `object_manager` = 'ProjectFiles' && `workspace_id` IN ($wscsv))"
					. ($tag? (" AND id in (SELECT rel_object_id from " . TABLE_PREFIX . "tags t WHERE tag='".$tag."' AND t.rel_object_manager='ProjectFiles')"):'')
					. ' AND ' .permissions_sql_for_listings(ProjectFiles::instance(),ACCESS_LEVEL_READ,logged_user())
					, 'order' => 'updated_on DESC', 'limit' => 10));
					
			tpl_assign('documents', $documents);
		}
		
		if(user_config_option('show emails widget')){
			$mail_accounts = logged_user()->getMailAccountIdsCSV();
			if ($mail_accounts != ''){
				$unread_emails = MailContents::findAllUnread(array('conditions' => 'account_id in (' . $mail_accounts . ')', 'order' => 'sent_date DESC', 'limit' => 10));
				tpl_assign('unread_emails', $unread_emails);
			}
		}
		
		if(user_config_option('show pending tasks widget')){
			$assigned_to = explode(':', user_config_option('pending tasks widget assigned to filter'));
			$to_company = array_var($assigned_to, 0,0);
			$to_user = array_var($assigned_to, 1, 0);
			
			$tasks = ProjectTasks::getProjectTasks(active_project(),null,'ASC',null,null,$tag,$to_company,$to_user,null,true);
			tpl_assign('dashtasks', $tasks);
		}
		if(user_config_option('show tasks in progress widget')){
			$tasks_in_progress = ProjectTasks::getOpenTimeslotTasks(logged_user(), active_project(), $tag);
			tpl_assign('tasks_in_progress', $tasks_in_progress);
		}
		
		if(user_config_option('show late tasks and milestones widget')){
			tpl_assign('today_milestones', $logged_user->getTodayMilestones(active_project(), $tag));
			tpl_assign('late_milestones', $logged_user->getLateMilestones(active_project(), $tag));
			tpl_assign('today_tasks', $logged_user->getTodayTasks(active_project(), $tag));
			tpl_assign('late_tasks', $logged_user->getLateTasks(active_project(), $tag));
		}
		tpl_assign('active_projects', $active_projects);
		tpl_assign('activity_log', $activity_log);

		ajx_set_no_toolbar(true);
	} // index

	/**
	 * Show my projects page
	 *
	 * @param void
	 * @return null
	 */
	function my_projects() {
		$this->addHelper('textile');
		tpl_assign('active_projects', logged_user()->getActiveProjects());
		tpl_assign('finished_projects', logged_user()->getFinishedProjects());
	} // my_projects

	/**
	 * Show milestones and tasks assigned to specific user
	 *
	 * @param void
	 * @return null
	 */
	function my_tasks() {
		tpl_assign('active_projects', logged_user()->getActiveProjects());
	} // my_tasks
} // DashboardController

?>