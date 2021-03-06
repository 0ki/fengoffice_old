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
		$this->setTemplate('add_chart');
		$this->add_chart();
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
	
}
?>