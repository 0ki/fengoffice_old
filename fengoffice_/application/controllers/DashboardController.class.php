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

	function init_overview() {
		require_javascript("og/OverviewManager.js");
		ajx_current("panel", "overview", null, null, true);
		ajx_replace(true);
	}
	
	/**
	 * Show dashboard index page
	 *
	 * @param void
	 * @return null
	 */
	function index() {
		$this->setHelp('dashboard');
		$tag = array_var($_GET,'active_tag');
		
		$logged_user = logged_user();
		if (active_project() instanceof Project){
			$wscsv = active_project()->getAllSubWorkspacesQuery();
		} else {
			$wscsv = $logged_user->getWorkspacesQuery();
		}
		$activity_log = null;
		$include_private = $logged_user->isMemberOfOwnerCompany();
		$include_silent = $logged_user->isAdministrator();

		$activity_log = ApplicationLogs::getOverallLogs($include_private, $include_silent, $wscsv, config_option('dashboard_logs_count', 15));

		if (user_config_option('show charts widget') && config_option('enable_reporting_module')) {
			$charts = ProjectCharts::findAll(array(
				'conditions' => "(" . ProjectCharts::getWorkspaceString($wscsv) . ' AND show_in_parents = 1)' 
					. (active_project() instanceof Project ? ' OR (' . ProjectCharts::getWorkspaceString(active_project()->getId()) . ' AND show_in_project = 1)' : '')
					. ($tag? (" AND id in (SELECT rel_object_id FROM `" . TABLE_PREFIX . "tags` `t` WHERE `tag` = ".DB::escape($tag)." AND `t`.`rel_object_manager`='ProjectCharts')"):'')
					, 'order' => 'updated_on DESC', 'limit' => 5));
			tpl_assign('charts', $charts);
			
			if (BillingCategories::count() > 0 && active_project() instanceof Project){
				tpl_assign('billing_chart_data', active_project()->getBillingTotalByUsers(logged_user()));
			}
		}
		if (user_config_option('show messages widget') && config_option('enable_notes_module')) {
			$messages = ProjectMessages::findAll(array(
				'conditions' => 'id IN (SELECT `object_id` FROM `' .TABLE_PREFIX. "workspace_objects` WHERE `object_manager` = 'ProjectMessages' && `workspace_id` IN ($wscsv))"
					. ($tag? (" AND id in (SELECT rel_object_id from " . TABLE_PREFIX . "tags t WHERE tag=".DB::escape($tag)." AND t.rel_object_manager='ProjectMessages')"):'')
					 . ' AND ' .permissions_sql_for_listings(ProjectMessages::instance(),ACCESS_LEVEL_READ,logged_user())
					, 'order' => 'updated_on DESC', 'limit' => 10));
			tpl_assign('messages', $messages);
		}
		if (user_config_option('show comments widget')) {
			$comments = Comments::getSubscriberComments(active_project(), $tag);
			tpl_assign('comments', $comments);
		}
		if (user_config_option('show documents widget') && config_option('enable_documents_module')) {
			$documents = ProjectFiles::findAll(array(
				'conditions' => "id IN (SELECT `object_id` FROM `" .TABLE_PREFIX. "workspace_objects` WHERE `object_manager` = 'ProjectFiles' && `workspace_id` IN ($wscsv))"
					. ($tag? (" AND id in (SELECT rel_object_id from " . TABLE_PREFIX . "tags t WHERE tag=".DB::escape($tag)." AND t.rel_object_manager='ProjectFiles')"):'')
					. ' AND ' .permissions_sql_for_listings(ProjectFiles::instance(),ACCESS_LEVEL_READ,logged_user())
					, 'order' => 'updated_on DESC', 'limit' => 10));
					
			tpl_assign('documents', $documents);
		}
		
		if (user_config_option('show emails widget') && config_option('enable_email_module')) {
			list($unread_emails, $pagination) = MailContents::getEmails($tag, null, 'received', 'unread', '', null, 0, 10);
			tpl_assign('unread_emails', $unread_emails);
			if (active_project() instanceof Project) {
				$ws_emails = MailContents::getProjectMails(active_project(), 0, 10);
				tpl_assign('ws_emails', $ws_emails);
			}
		}
		
		//Tasks widgets
		$show_pending = user_config_option('show pending tasks widget')  && config_option('enable_tasks_module');
		$show_in_progress = user_config_option('show tasks in progress widget') && config_option('enable_tasks_module');
		$show_late = user_config_option('show late tasks and milestones widget') && config_option('enable_tasks_module');
		if ($show_pending || $show_in_progress || $show_late) {
			$assigned_to = explode(':', user_config_option('pending tasks widget assigned to filter'));
			$to_company = array_var($assigned_to, 0,0);
			$to_user = array_var($assigned_to, 1, 0);
			tpl_assign('assigned_to_user_filter',$to_user);
			tpl_assign('assigned_to_company_filter',$to_company);
		}
		if ($show_pending) {
			 $tasks = ProjectTasks::getProjectTasks(active_project(), ProjectTasks::ORDER_BY_DUEDATE, 'ASC', null, null, $tag, $to_company, $to_user, null, true, 'all', false, false, false, 10);
			tpl_assign('dashtasks', $tasks);
		}
		if ($show_in_progress) {
			$tasks_in_progress = ProjectTasks::getOpenTimeslotTasks(logged_user(),logged_user(), active_project(), $tag,$to_company,$to_user);
			tpl_assign('tasks_in_progress', $tasks_in_progress);
		}
		if ($show_late) {
			tpl_assign('today_milestones', $logged_user->getTodayMilestones(active_project(), $tag, 10));
			tpl_assign('late_milestones', $logged_user->getLateMilestones(active_project(), $tag, 10));
			tpl_assign('today_tasks', ProjectTasks::getDayTasksByUser(DateTimeValueLib::now(), $logged_user, active_project(), $tag, $to_company, $to_user, 10));
			tpl_assign('late_tasks', ProjectTasks::getLateTasksByUser($logged_user, active_project(), $tag, $to_company, $to_user, 10));
		}
		
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