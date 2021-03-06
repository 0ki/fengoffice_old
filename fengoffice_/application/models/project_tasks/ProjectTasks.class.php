<?php
 
  /**
  * ProjectTasks, generated on Sat, 04 Mar 2006 12:50:11 +0100 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class ProjectTasks extends BaseProjectTasks {
  	
  	const ORDER_BY_ORDER = 'order';
	const ORDER_BY_STARTDATE = 'startDate';
	const ORDER_BY_DUEDATE = 'dueDate';
  	
  	/*
	* Return tasks lists for the next two weeks which don't have due date and have not been completed.
	*
	* @param Project $project
	* @return array
	*/
	static function getPendingTasks(User $user, $project) {
		if ($project instanceof Project)
      		$project_ids = $project->getAllSubWorkspacesCSV();
      	else
      		$project_ids = $user->getActiveProjectIdsCSV();
		
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
		$objects = self::findAll(array(
  				'conditions' => array('((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ? ) ' .
			  		 ' OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) '.
			  		 ' OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) '.
			  		 ' AND `completed_on` = ? AND parent_id = ? AND (due_date > DATE(CURRENT_TIMESTAMP) OR due_date = \'00:00:00 00-00-0000\')'.
			  		 ' AND project_id in (' . $project_ids . ')' . $permissions, $user->getId(), $user->getCompanyId(),
  					 0, $user->getCompanyId(), 0, 0, EMPTY_DATETIME,0, EMPTY_DATETIME),
        			'order' => 'due_date ASC, `created_on` DESC'
        		));
		return $objects;
	} // getAllFilesByProject
  	/*
	* Return tasks for the next two weeks
	*
	* @param Project $project
	* @return array
	*/
	static function getTasksForTwoWeeks() {
		$user =  logged_user();
		
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
		$objects = self::findAll(array(
  				'conditions' => array('((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ? ) ' .
			  		 ' OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) '.
			  		 ' OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) '.
			  		 ' AND `completed_on` = ? AND parent_id = ? ' . $permissions, $user->getId(), $user->getCompanyId(),
  					 0, $user->getCompanyId(), 0, 0, EMPTY_DATETIME,0),
        		'order' => '`created_on`'
        		));
		return $objects;
	} // getAllFilesByProject
    
    /**
    * Return day tasks this user has access to
    *
    * @access public
    * @param void
    * @return array
    */
    function getDayTasksByUser(DateTimeValue $date, User $user, $project = null) {
	  if ($project instanceof Project)
      	$project_ids = $project->getAllSubWorkspacesCSV();
      else
      	$project_ids = $user->getActiveProjectIdsCSV();
      	
      $from_date =   (new DateTimeValue($date->getTimestamp()));
      $from_date = $from_date->beginningOfDay();
      $to_date =  (new DateTimeValue($date->getTimestamp()));
      $to_date = $to_date->endOfDay();
     
      $permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
		
       $result = self::findAll(array(
        'conditions' => array('`completed_on` = ? AND (`due_date` >= ? AND `due_date` < ?) AND `project_id` in (' .$project_ids . ')' . $permissions, EMPTY_DATETIME, $from_date, $to_date)
      )); // findAll
      return $result;
    } // getDayTasksByUser
    
    /**
    * Return late tasks this user has access to
    *
    * @access public
    * @param void
    * @return array
    */
    function getLateTasksByUser(User $user, $project = null) {
	  if ($project instanceof Project)
      	$project_ids = $project->getAllSubWorkspacesCSV();
      else
      	$project_ids = $user->getActiveProjectIdsCSV();
      	
      $time = strtotime("-1 day", time());
      $to_date =  (new DateTimeValue($time));
      $to_date = $to_date->endOfDay();
     
      $permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
		
       $result = self::findAll(array(
        'conditions' => array('`completed_on` = ? AND `due_date` > \'00:00:00 00-00-0000\' AND `due_date` < ? AND `project_id` in (' .$project_ids . ')' . $permissions, EMPTY_DATETIME, $to_date),
      	'order' => '`due_date` ASC'
       )); // findAll
      return $result;
    } // getDayTasksByUser
  
	static function getProjectTasks($project = null, $order = null, $orderdir = 'ASC', $parent_id = null, $milestone_id = null, $tag = null, $assigned_to_company = null, $assigned_to_user = null, $assigned_by_user = null, $pending = false) {
		if ($order == self::ORDER_BY_STARTDATE) {
			$order_by = '`start_date` ' . $orderdir;
		} else if ($order == self::ORDER_BY_DUEDATE) {
			$order_by = '`due_date` ' . $orderdir;
		} else {
			// default
			$order_by = '`order` ' . $orderdir;
		} // if
				
		if ($project instanceof Project) {
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$projectstr = " AND `project_id` IN ($pids) ";
		
		if ($parent_id === null) {
			$parentstr = "";
		} else {
			$parentstr = " AND `parent_id` = " . DB::escape($parent_id) . " ";
		}
		
		if ($milestone_id === null) {
			$milestonestr = "";
		} else {
			$milestonestr = " AND `milestone_id` = " . DB::escape($milestone_id) . " ";
		}

		if ($tag == '' || $tag == null) {
			$tagstr = "";
		} else {
			$tagstr = " AND (select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "project_tasks.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = ".DB::escape($tag)." and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectTasks' ) > 0 ";
		}
		
		$assignedToStr = "";
		if ($assigned_to_company) {
			$assignedToStr .= " AND `assigned_to_company_id` = " . DB::escape($assigned_to_company) . " ";
		}
		if ($assigned_to_user) {
			$assignedToStr .= " AND `assigned_to_user_id` = " . DB::escape($assigned_to_user) . " ";
		}
		
		$assignedByStr = "";
		if ($assigned_by_user) {
			$assignedByStr .= " AND (`created_by_id` = " . DB::escape($assigned_by_user) . " OR `updated_by_id` = " . DB::escape($assigned_by_user) . ") ";
		}
		
		if ($pending) {
			$pendingstr = " AND `completed_on` = " . DB::escape(EMPTY_DATETIME) . " ";
		} else {
			 $pendingstr = "";
		}
		
		$permissionstr = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(), ACCESS_LEVEL_READ, logged_user()) . ') ';
		
		$otherConditions = $milestonestr . $parentstr . $projectstr . $tagstr . $assignedToStr . $assignedByStr . $pendingstr . $permissionstr;
		
		$conditions = array(' true ' . $otherConditions);
		
		$tasks = ProjectTasks::find(array(
				'conditions' => $conditions,
				'order' => $order_by
			));
		if (!is_array($tasks)) $tasks = array();
		return $tasks;
	} // getProjectTasks
	
	static function paginateProjectTasks($project = null, $order = null, $orderdir = 'ASC', $page = null, $tasks_per_page = null, $group_by_order = false, $parent_id = 0, $milestone_id = null, $tag = null, $assigned_to_company = null, $assigned_to_user = null, $assigned_by_user = null, $pending = false) {
		if ($order == self::ORDER_BY_STARTDATE) {
			$order_by = '`start_date` ' . $orderdir;
		} else if ($order == self::ORDER_BY_DUEDATE) {
			$order_by = '`due_date` ' . $orderdir;
		} else {
			// default
			$order_by = '`order` ' . $orderdir;
		} // if
		
		if ((integer) $page < 1) {
			$page = 1;
		} // if
		if ((integer) $tasks_per_page < 1) {
			$tasks_per_page = 10;
		} // if		
		
		if ($project instanceof Project) {
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$projectstr = " AND `project_id` IN ($pids) ";
		
		$parentstr = " AND `parent_id` = " . DB::escape($parent_id) . " ";
		
		if ($milestone_id) {
			$milestonestr = " AND `milestone_id` = " . DB::escape($milestone_id) . " ";
		} else {
			$milestonestr = "";
		}

		if ($tag == '' || $tag == null) {
			$tagstr = "";
		} else {
			$tagstr = " AND (select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "project_tasks.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = ".DB::escape($tag)." and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectTasks' ) > 0 ";
		}
		
		$assignedToStr = "";
		if ($assigned_to_company) {
			$assignedToStr .= " AND `assigned_to_company_id` = " . DB::escape($assigned_to_company) . " ";
		}
		if ($assigned_to_user) {
			$assignedToStr .= " AND `assigned_to_user_id` = " . DB::escape($assigned_to_user) . " ";
		}
		
		$assignedByStr = "";
		if ($assigned_by_user) {
			$assignedByStr .= " AND (`created_by_id` = " . DB::escape($assigned_by_user) . " OR `updated_by_id` = " . DB::escape($assigned_by_user) . ") ";
		}
		
		if ($pending) {
			$pendingstr = " AND `completed_on` = " . DB::escape(EMPTY_DATETIME) . " ";
		} else {
			 $pendingstr = "";
		}
		
		$permissionstr = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(), ACCESS_LEVEL_READ, logged_user()) . ') ';
		
		$otherConditions = $milestonestr . $parentstr . $projectstr . $tagstr . $assignedToStr . $assignedByStr . $pendingstr . $permissionstr;
		
		$conditions = array(' true ' . $otherConditions);
		
		list($tasks, $pagination) = ProjectTasks::paginate(array(
				'conditions' => $conditions,
				'order' => $order_by
			), $tasks_per_page, $page);
		if (!is_array($tasks)) $tasks = array();
		return array($tasks, $pagination);
	} // paginateProjectTasks
    
	function maxOrder($parentId) {
		$sql = "SELECT max(`order`) as `max` FROM `" . TABLE_PREFIX . "project_tasks` WHERE `parent_id` = " . DB::escape($parentId);
		$res = DB::execute($sql);
		$row = $res->fetchRow();
		$max = $row['max'];
		if (!$max) $max = 0;
		return $max; 
	}
	
	/**
    * Return Day tasks this user have access on
    *
    * @access public
    * @param void
    * @return array
    */
    function getRangeTasksByUser(DateTimeValue $date_start, DateTimeValue $date_end, User $user, $tags = '', $project = null){
		
      $from_date =   (new DateTimeValue($date_start->getTimestamp()));
      $from_date = $date_start->beginningOfDay();
      $to_date =  (new DateTimeValue($date_end->getTimestamp()));
      $to_date = $date_end->endOfDay();
     
      $permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user(), 'project_id') .')';
	
      if ($project instanceof Project ){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
	  } else {
		$pids = logged_user()->getActiveProjectIdsCSV();
	  }
	  $limitation = " AND (`project_id` IN ($pids))";
	  if (isset($tags) && $tags && $tags!='') {
  		$tag_str = " AND exists (SELECT * from " . TABLE_PREFIX . "tags t WHERE tag='".$tags."' AND  ".TABLE_PREFIX."project_tasks.id=t.rel_object_id AND t.rel_object_manager='ProjectTasks') ";
	  } else {
		$tag_str= "";
	  }
	  
      $result = self::findAll(array(
        'conditions' => array('`completed_on` = ? AND (`due_date` >= ? AND `due_date` < ?) ' . $permissions.$limitation.$tag_str, EMPTY_DATETIME, $from_date, $to_date)
      )); // findAll
      return $result;
    } // getDayTasksByUser
  } // ProjectTasks
?>