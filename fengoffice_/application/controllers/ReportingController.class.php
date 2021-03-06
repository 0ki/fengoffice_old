<?php

/**
* Controller that is responsible for handling project events related requests
*
* @version 1.0
* @author Marcos Saiz <marcos.saiz@gmail.com>
* @adapted from Reece calendar <http://reececalendar.sourceforge.net/>.
* Acknowledgements at the bottom.
*/

class ReportingController extends ApplicationController {

	/**
	* Construct the ReportingController
	*
	* @access public
	* @param void
	* @return ReportingController
	*/
	function __construct() 
	{
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct
     	
	function chart_details() 
	{
		$pcf = new ProjectChartFactory();
		$chart = $pcf->loadChart(get_id());
		$chart->ExecuteQuery();
		tpl_assign('chart', $chart);
		ajx_set_no_toolbar(true);
	}
	
	/**
	* Show reporting index page
	*
	* @param void
	* @return null
	*/
	function add_chart() 
	{
		$factory = new ProjectChartFactory();
		$types = $factory->getChartTypes();
		
		$chart_data = array_var($_POST, 'chart');
		if(!is_array($chart_data)) {
			$chart_data = array(
				'type_id' => 1,
				'display_id' => 20,
				'show_in_project' => 1,
				'show_in_parents' => 0
			); // array
		} // if
		tpl_assign('chart_data', $chart_data);
		
		
		if (is_array(array_var($_POST, 'chart'))) {
			$chart = $factory->getChart(array_var($chart_data, 'type_id'));
			$chart->setDisplayId(array_var($chart_data, 'display_id'));
			$chart->setTitle(array_var($chart_data, 'title'));
			
			if (array_var($chart_data, 'save') == 1){
				$chart->setFromAttributes($chart_data);
				
				try {
					DB::beginWork();
					$chart->save();
					DB::commit();
					flash_success(lang('success add chart', $chart->getTitle()));
					ajx_current('back');
				} catch(Exception $e) {
					DB::rollback();
					flash_error($e->getMessage());
					ajx_current("empty");
				}
				return;
			}
			
			$chart->ExecuteQuery();
			tpl_assign('chart', $chart);
			ajx_replace(true);
		}
		tpl_assign('chart_displays', $factory->getChartDisplays());
		tpl_assign('chart_list', $factory->getChartTypes());
	}
	
	function delete_chart(){
		$chart = ProjectCharts::findById(get_id());
		if(!($chart instanceof ProjectChart)) {
			flash_error(lang('chart dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$chart->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$chart->delete();
			ApplicationLogs::createLog($chart, $chart->getProject(), ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success deleted chart', $chart->getTitle()));
			ajx_current("back");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete chart'));
			ajx_current("empty");
		} // try
	}
	
	/**
	* Show reporting add chart page
	*
	* @param void
	* @return null
	*/
	function index() 
	{
		ajx_set_no_toolbar(true);
	}
	
	function list_all() 
	{
		ajx_current("empty");

		$pid = array_var($_GET, 'active_project', 0);
		$project = Projects::findById($pid);
		$isProjectView = ($project instanceof Project);
		 
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
			$ids = explode(',', array_var($_GET, 'charts'));
			list($succ, $err) = ObjectController::do_delete_objects($ids, 'ProjectCharts');
			if ($err > 0) {
				flash_error(lang('error delete objects'), $err);
			} else {
				flash_success(lang('success delete objects'), $succ);
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'charts'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = ObjectController::do_tag_object($tagTag, $ids, 'ProjectCharts');
			if ($err > 0) {
				flash_error(lang('error tag objects', $err));
			} else {
				flash_success(lang('success tag objects', $succ));
			}
		}

		if($page < 0) $page = 1;

		//$conditions = logged_user()->isMemberOfOwnerCompany() ? '' : ' `is_private` = 0';
		if ($tag == '' || $tag == null) {
			$tagstr = " '1' = '1'"; // dummy condition
		} else {
			$tagstr = "(select count(*) from " . TABLE_PREFIX . "tags where " .
			TABLE_PREFIX . "project_charts.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
			TABLE_PREFIX . "tags.tag = '".$tag."' and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectCharts' ) > 0 ";
		}
		$permission_str = ''; /* ' AND (' . permissions_sql_for_listings(ProjectCharts::instance(),
							ACCESS_LEVEL_READ, 
							logged_user()) . ')';*/

		if ($isProjectView) {
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$project_str = " AND `project_id` IN ($pids) ";
		
		list($charts, $pagination) = ProjectCharts::paginate(
			array("conditions" => $tagstr . $permission_str . $project_str ,
	        		'order' => '`title` ASC'),
			config_option('files_per_page', 10),
			$page
		); // paginate

		tpl_assign('totalCount', $pagination->getTotalItems());
		tpl_assign('charts', $charts);
		tpl_assign('pagination', $pagination);
		tpl_assign('tags', Tags::getTagNames());

		$object = array(
			"totalCount" => $pagination->getTotalItems(),
			"charts" => array()
		);
		
		$factory = new ProjectChartFactory();
		$types = $factory->getChartDisplays();
		
		if (isset($charts))
		{
			foreach ($charts as $c) {
				if ($c->getProject() instanceof Project)
				$tags = project_object_tags($c);
				else
				$tags = "";
					
				$object["charts"][] = array(
				"id" => $c->getId(),
				"name" => $c->getTitle(),
				"type" => $types[$c->getDisplayId()],
				"tags" => $tags,
				"project" => $c->getProject()?$c->getProject()->getName():'',
				"projectId" => $c->getProjectId()
				);
			}
		}
		ajx_extra_data($object);
		tpl_assign("listing", $object);
	}
	
	
	
	// ---------------------------------------------------
	//  Tasks Reports
	// ---------------------------------------------------
	
	function total_task_times_p(){
		$users = owner_company()->getUsers();
		$workspaces = logged_user()->getActiveProjects();
		
		tpl_assign('workspaces', $workspaces);
		tpl_assign('users', $users);
	}
	
	function total_task_times($report_data = null, $task = null){
		$this->setTemplate('report_wrapper');
		
		if (!$report_data) {
			$report_data = array_var($_POST, 'report');
			// save selections into session
			$_SESSION['total_task_times_report_data'] = $report_data;
		}
		
		$user = Users::findById(array_var($report_data, 'user'));
		$workspace = Projects::findById(array_var($report_data, 'project_id'));
		if ($workspace instanceof Project){
			if (array_var($report_data, 'include_subworkspaces'))
				$workspacesCSV = $workspace->getAllSubWorkspacesCSV(false,logged_user());
			else
				$workspacesCSV = $workspace->getId();
		} else {
			$workspacesCSV = logged_user()->getActiveProjectIdsCSV();
		}
		
		$st = DateTimeValueLib::now();
		$et = DateTimeValueLib::now();
		switch (array_var($report_data, 'date_type')){
			case 1:
				$now = DateTimeValueLib::now();
				$st = DateTimeValueLib::make(0,0,0,$now->getMonth(),$now->getDay(),$now->getYear());
				$et = DateTimeValueLib::make(23,59,59,$now->getMonth(),$now->getDay(),$now->getYear());break;
			case 2:
				$now = DateTimeValueLib::now();
				$monday = $now->getMondayOfWeek();
				$nextMonday = $now->getMondayOfWeek()->add('w',1)->add('d',-1);
				$st = DateTimeValueLib::make(0,0,0,$monday->getMonth(),$monday->getDay(),$monday->getYear());
				$et = DateTimeValueLib::make(23,59,59,$nextMonday->getMonth(),$nextMonday->getDay(),$nextMonday->getYear());break;
			case 3:
				$now = DateTimeValueLib::now();
				$monday = $now->getMondayOfWeek()->add('w',-1);
				$nextMonday = $now->getMondayOfWeek()->add('d',-1);
				$st = DateTimeValueLib::make(0,0,0,$monday->getMonth(),$monday->getDay(),$monday->getYear());
				$et = DateTimeValueLib::make(23,59,59,$nextMonday->getMonth(),$nextMonday->getDay(),$nextMonday->getYear());break;
			case 4:
				$now = DateTimeValueLib::now();
				$st = DateTimeValueLib::make(0,0,0,$now->getMonth(),1,$now->getYear());
				$et = DateTimeValueLib::make(23,59,59,$now->getMonth(),1,$now->getYear())->add('M',1)->add('d',-1);break;
			case 5:
				$now = DateTimeValueLib::now();
				$now->add('M',-1);
				$st = DateTimeValueLib::make(0,0,0,$now->getMonth(),1,$now->getYear());
				$et = DateTimeValueLib::make(23,59,59,$now->getMonth(),1,$now->getYear())->add('M',1)->add('d',-1);break;
			case 6:
				$sday = array_var($report_data, 'start_day');
				$smonth = array_var($report_data, 'start_month');
				$syear = array_var($report_data, 'start_year');
				$eday = array_var($report_data, 'end_day');
				$emonth = array_var($report_data, 'end_month');
				$eyear = array_var($report_data, 'end_year');
		
				$st = DateTimeValueLib::make(0,0,0,$smonth,$sday,$syear);
				$et = DateTimeValueLib::make(23,59,59,$emonth,$eday,$eyear);
				break;
		}
		
		$st = new DateTimeValue($st->getTimestamp() - logged_user()->getTimezone() * 3600);
		$et = new DateTimeValue($et->getTimestamp() - logged_user()->getTimezone() * 3600);
		
		$group_by = array();
		if (array_var($report_data, 'group_by_1') != '0')
			$group_by[] = array_var($report_data, 'group_by_1');
		if (array_var($report_data, 'group_by_2') != '0')
			$group_by[] = array_var($report_data, 'group_by_2');
		if (array_var($report_data, 'group_by_3') != '0')
			$group_by[] = array_var($report_data, 'group_by_3');
		
		$timeslotsArray = Timeslots::getTaskTimeslots($workspace,$user,$workspacesCSV,$st,$et, array_var($report_data, 'task_id',0),$group_by);
		
		tpl_assign('group_by', $group_by);
		tpl_assign('timeslotsArray', $timeslotsArray);
		tpl_assign('workspace', $workspace);
		tpl_assign('start_time', $st);
		tpl_assign('end_time', $et);
		tpl_assign('user', $user);
		tpl_assign('post', $report_data);
		tpl_assign('template_name', 'total_task_times');
		tpl_assign('title',lang('task time report'));
	}
	
	function total_task_times_by_task_print(){
		$this->setLayout("html");
		
		$task = ProjectTasks::findById(get_id());
		
		$st = DateTimeValueLib::make(0,0,0,1,1,1900);
		$et = DateTimeValueLib::make(23,59,59,12,31,2036);
		
		//$timeslots = Timeslots::getTimeslotsByUserWorkspacesAndDate(null, $task->getProjectId(),$st,$et,'ProjectTasks', get_id());
		$timeslotsArray = Timeslots::getTaskTimeslots(null,null,null,$st,$et, get_id());
		
		tpl_assign('estimate', $task->getTimeEstimate());
		//tpl_assign('timeslots', $timeslots);
		tpl_assign('timeslotsArray', $timeslotsArray);
		tpl_assign('workspace', $task->getProject());
		tpl_assign('template_name', 'total_task_times');
		tpl_assign('title',lang('task time report'));
		tpl_assign('task_title', $task->getTitle());
		$this->setTemplate('report_printer');
	}
	
	function total_task_times_print(){
		$this->setLayout("html");
		
		$report_data = json_decode(str_replace("'",'"', array_var($_POST, 'post')),true);
		
		$this->total_task_times($report_data);
		$this->setTemplate('report_printer');
	}


	
	function total_task_times_vs_estimate_comparison_p(){
		$users = owner_company()->getUsers();
		$workspaces = logged_user()->getActiveProjects();
		
		tpl_assign('workspaces', $workspaces);
		tpl_assign('users', $users);
	}
	
	function total_task_times_vs_estimate_comparison($report_data = null, $task = null){
		$this->setTemplate('report_wrapper');
		
		if (!$report_data)
			$report_data = array_var($_POST, 'report');
		
		$workspace = Projects::findById(array_var($report_data, 'project_id'));
		if ($workspace instanceof Project){
			if (array_var($report_data, 'include_subworkspaces'))
				$workspacesCSV = $workspace->getAllSubWorkspacesCSV(false,logged_user());
			else
				$workspacesCSV = $workspace->getId();
		} 
		else {
			$workspacesCSV = logged_user()->getActiveProjectIdsCSV();
		}
		
		$sday = array_var($report_data, 'start_day');
		$smonth = array_var($report_data, 'start_month');
		$syear = array_var($report_data, 'start_year');
		$eday = array_var($report_data, 'end_day');
		$emonth = array_var($report_data, 'end_month');
		$eyear = array_var($report_data, 'end_year');

		$st = DateTimeValueLib::make(0,0,0,$smonth,$sday,$syear);
		$et = DateTimeValueLib::make(23,59,59,$emonth,$eday,$eyear);
		$st = new DateTimeValue($st->getTimestamp() - logged_user()->getTimezone() * 3600);
		$et = new DateTimeValue($et->getTimestamp() - logged_user()->getTimezone() * 3600);
		
		$timeslots = Timeslots::getTimeslotsByUserWorkspacesAndDate(null,$workspacesCSV,$st,$et,'ProjectTasks', array_var($report_data, 'task_id',0));
		
		tpl_assign('timeslots', $timeslots);
		tpl_assign('workspace', $workspace);
		tpl_assign('start_time', $st);
		tpl_assign('end_time', $et);
		tpl_assign('user', $user);
		tpl_assign('post', $report_data);
		tpl_assign('template_name', 'total_task_times');
		tpl_assign('title',lang('task time report'));
	}

}
?>