<?php

/**
* ProjectEvents, generated on Tue, 04 Jul 2006 06:46:08 +0200 by 
* DataObject generation tool
*
* @author Marcos Saiz <marcos.saiz@gmail.com>
*/
class ProjectEvents extends BaseProjectEvents {
    
	const ORDER_BY_NAME = 'name';
	const ORDER_BY_POSTTIME = 'dateCreated';
	const ORDER_BY_MODIFYTIME = 'dateUpdated';
	
	/**
	 * Returns all events for the given date, tag and considers the active project
	 *
	 * @param DateTimeValue $date
	 * @param String $tags
	 * @return unknown
	 */
	static function getDayProjectEvents(DateTimeValue $date, $tags = '', $project = null, $user = -1, $inv_state = -1){
		$day = $date->getDay();
		$month = $date->getMonth();
		$year = $date->getYear();
		
		if(!is_numeric($day) OR !is_numeric($month) OR !is_numeric($year)){
			return NULL;
		}
		// fix any date issues
		$year = date("Y",mktime(0,0,1,$month, $day, $year));
		$month = date("m",mktime(0,0,1,$month, $day, $year));
		$day = date("d",mktime(0,0,1,$month, $day, $year));
		//permission check
		$limitation='';

		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectEvents::instance(),ACCESS_LEVEL_READ, logged_user()) .')';

		if ($project instanceof Project ){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$limitation = " AND (`project_id` IN ($pids))";
		if (isset($tags) && $tags && $tags!='') {
	    		$tag_str = " AND exists (SELECT * from " . TABLE_PREFIX . "tags t WHERE tag='".$tags."' AND  ".TABLE_PREFIX."project_events.id=t.rel_object_id AND t.rel_object_manager='ProjectEvents') ";
		} else {
			$tag_str= "";
		}
		// build the query
//		$q = "SELECT UNIX_TIMESTAMP(`start`) as start_since_epoch,
//			UNIX_TIMESTAMP(duration) as end_since_epoch, private, created_by_id, subject,
//			description, eventtype, ".TABLE_PREFIX."project_events.id, 
//			repeat_d, repeat_m, repeat_y, repeat_h, repeat_end, type_id, 
//			typename, typedesc, typecolor, repeat_num, special_id, created_on
//			FROM ".TABLE_PREFIX."project_events left outer join ".TABLE_PREFIX."eventtypes 
//			
//			ON ".TABLE_PREFIX."project_events.type_id=".TABLE_PREFIX."eventtypes.id 
//			WHERE
		$conditions = "	(
				-- 
				-- THIS RETURNS EVENTS ON THE ACTUAL DAY IT'S SET FOR (ONE TIME EVENTS)
				-- 
				(
					duration >= '$year-$month-$day 00:00:00' 
					AND `start` <= '$year-$month-$day 23:59:59' 
				) 
				-- 
				-- THIS RETURNS REGULAR REPEATING EVENTS - DAILY, WEEKLY, MONTHLY, OR YEARLY.
				-- 
				OR 
				(
					DATE(`start`) <= '$year-$month-$day' 
					AND
					(
						(
							MOD( DATEDIFF(DATE(`start`), '$year-$month-$day') ,repeat_d) = 0
							AND
							(
								ADDDATE(DATE(`start`), INTERVAL ((repeat_num-1)*repeat_d) DAY) >= '$year-$month-$day' 
								OR
								repeat_forever = 1
								OR
								repeat_end >= '$year-$month-$day'
							)
						)
						OR
						(
							MOD( PERIOD_DIFF(DATE_FORMAT(`start`,'%Y%m'),DATE_FORMAT('$year-$month-$day','%Y%m')) ,repeat_m) = 0
							AND 
							DAY(`start`)= '$day'
							AND
							(
								ADDDATE(DATE(`start`), INTERVAL ((repeat_num-1)*repeat_m) MONTH) >= '$year-$month-$day' 
								OR
								repeat_forever = 1
								OR
								repeat_end >= '$year-$month-$day'
							)
						)
						OR
						(
							MOD( (YEAR(DATE(`start`))-YEAR('$year-$month-$day')) ,repeat_y) = 0
							AND
							MONTH(`start`)='$month' 
							AND 
							DAY(`start`) = '$day'
							AND
							(
								ADDDATE(DATE(`start`), INTERVAL ((repeat_num-1)*repeat_y) YEAR) >= '$year-$month-$day' 
								OR
								repeat_forever = 1
								OR
								repeat_end >= '$year-$month-$day'
							)
						)
					)		
				)
				-- 
				-- THIS RETURNS EVENTS SET TO BE A CERTAIN DAY OF THE WEEK IN A CERTAIN WEEK OF THE MONTH NUMBERED 1-4
				-- 
				OR
				(
					repeat_h = 1
					AND
					MONTH(`start`) = $month 
					AND 
					(
						(
							DAYOFWEEK('$year-$month-01') <= DAYOFWEEK(`start`)
							AND 
							( DAYOFWEEK(`start`) - (DAYOFWEEK('$year-$month-01') - 1) + ( FLOOR((DAY(`start`)-1)/7) * 7) ) = $day
						)
						OR
						(
							DAYOFWEEK('$year-$month-01') > DAYOFWEEK(`start`)
							AND 
							( ( 7 - ( DAYOFWEEK('$year-$month-01') - 1 ) + DAYOFWEEK(`start`) ) + ( FLOOR((DAY(`start`)-1)/7) * 7 ) ) = $day
						)
					)			
				)
				-- 
				-- THIS RETURNS EVENTS SET TO BE A CERTAIN DAY OF THE WEEK IN THE LAST WEEK OF THE MONTH.
				-- 
				OR
				(
					repeat_h = 2
					AND
					MONTH(`start`) = $month 
					AND 
					DAY('$year-$month-$day') > (DAY(LAST_DAY('$year-$month-$day')) - 7) 
					AND 
					DAYOFWEEK(`start`) = DAYOFWEEK('$year-$month-$day')
				)				
			)
			$limitation  
			$permissions 
			$tag_str ";
		
		
		$result_events = self::findAll(array(
			'conditions' => $conditions,
			'order' => '`start`',
		));
		
		// Find invitations for events and logged user
		if (is_array($result_events) && count($result_events)) {
			ProjectEvents::addInvitations($result_events, $user);
			if (!($user == null && $inv_state == null)) {
				foreach ($result_events as $k => $event) {
					$cond = array('event_id' => $event->getId());
					if ($user != -1) $cond['user_id'] = $user;
	
					$inv = EventInvitations::findById($cond);
					if ($inv == null || ($inv_state != -1 && $inv_state != $inv->getInvitationState())) 
						unset($result_events[$k]);
				}
			}
		}
		
		return $result_events;
//			$result = DB::execute($q); // $cal_db->sql_query($q);
//		if(!$result AND DEBUG){
//			echo "Error executing event-retrieval query.";
//		}		
//    	$rows=$result->fetchAll();
//		return $rows;
	}
	
	
	
	/**
	 * Returns all events for the given range, tag and considers the active project
	 *
	 * @param DateTimeValue $date
	 * @param String $tags
	 * @return unknown
	 */
	static function getRangeProjectEvents(DateTimeValue $start_date, DateTimeValue $end_date,  $tags = '', $project = null){
		$start_day = $start_date->getDay();
		$start_month = $start_date->getMonth();
		$start_year = $start_date->getYear();
		
		$end_day = $end_date->getDay();
		$end_month = $end_date->getMonth();
		$end_year = $end_date->getYear();
		
		if(!is_numeric($start_day) OR !is_numeric($start_month) OR !is_numeric($start_year) OR !is_numeric($end_day) OR !is_numeric($end_month) OR !is_numeric($end_year)){
			return NULL;
		}
		// fix any date issues
		$start_year = date("Y",mktime(0,0,1,$start_month, $start_day, $start_year));
		$start_month = date("m",mktime(0,0,1,$start_month, $start_day, $start_year));
		$start_day = date("d",mktime(0,0,1,$start_month, $start_day, $start_year));
		
		$end_year = date("Y",mktime(0,0,1,$end_month, $end_day, $end_year));
		$end_month = date("m",mktime(0,0,1,$end_month, $end_day, $end_year));
		$end_day = date("d",mktime(0,0,1,$end_month, $end_day, $end_year));
		//permission check
		$limitation='';

		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectEvents::instance(),ACCESS_LEVEL_READ, logged_user()) .')';

		if ($project instanceof Project ){
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$limitation = " AND (`project_id` IN ($pids))";
		if (isset($tags) && $tags && $tags!='') {
	    		$tag_str = " AND exists (SELECT * from " . TABLE_PREFIX . "tags t WHERE tag='".$tags."' AND  ".TABLE_PREFIX."project_events.id=t.rel_object_id AND t.rel_object_manager='ProjectEvents') ";
		} else {
			$tag_str= "";
		}
		
		$conditions = "	(
				-- 
				-- THIS RETURNS EVENTS ON THE ACTUAL DAY IT'S SET FOR (ONE TIME EVENTS)
				-- 
				(
					duration >= '$start_year-$start_month-$start_day 00:00:00' 
					AND `start` <= '$end_year-$end_month-$end_day 23:59:59' 
				) 
				-- 
				-- THIS RETURNS REGULAR REPEATING EVENTS - DAILY, WEEKLY, MONTHLY, OR YEARLY.
				-- 
				OR 
				(
					DATE(`start`) <= '$end_year-$end_month-$end_day' --starts before the end date of the range
					AND
					(							
						(
							ADDDATE(DATE(`start`), INTERVAL ((repeat_num-1)*repeat_d) DAY) >= '$start_year-$start_month-$start_day' 
							OR
							repeat_forever = 1
							OR
							repeat_end >= '$start_year-$start_month-$start_day'
						)
						OR
						(
							ADDDATE(DATE(`start`), INTERVAL ((repeat_num-1)*repeat_m) MONTH) >= '$start_year-$start_month-$start_day' 
							OR
							repeat_forever = 1
							OR
							repeat_end >= '$start_year-$start_month-$start_day'
						)
						OR
						(
							ADDDATE(DATE(`start`), INTERVAL ((repeat_num-1)*repeat_y) YEAR) >= '$start_year-$start_month-$start_day' 
							OR
							repeat_forever = 1
							OR
							repeat_end >= '$start_year-$start_month-$start_day')
						)
					)		
				)
				-- 
				-- THIS RETURNS EVENTS SET TO BE A CERTAIN DAY OF THE WEEK IN A CERTAIN WEEK OF THE MONTH NUMBERED 1-4
				-- 
				OR
				(
					repeat_h = 1
					AND
					MONTH(`start`) = $start_month 
					AND 
					(
						(
							DAYOFWEEK('$start_year-$start_month-01') <= DAYOFWEEK(`start`)
							AND 
							( DAYOFWEEK(`start`) - (DAYOFWEEK('$start_year-$start_month-01') - 1) + ( FLOOR((DAY(`start`)-1)/7) * 7) ) = $start_day
						)
						OR
						(
							DAYOFWEEK('$start_year-$start_month-01') > DAYOFWEEK(`start`)
							AND 
							( ( 7 - ( DAYOFWEEK('$start_year-$start_month-01') - 1 ) + DAYOFWEEK(`start`) ) + ( FLOOR((DAY(`start`)-1)/7) * 7 ) ) = $start_day
						)
					)			
				)
				-- 
				-- THIS RETURNS EVENTS SET TO BE A CERTAIN DAY OF THE WEEK IN THE LAST WEEK OF THE MONTH.
				-- 
				OR
				(
					repeat_h = 2
					AND
					MONTH(`start`) = $start_month 
					AND 
					DAY('$start_year-$start_month-$start_day') > (DAY(LAST_DAY('$start_year-$start_month-$start_day')) - 7) 
					AND 
					DAYOFWEEK(`start`) = DAYOFWEEK('$start_year-$start_month-$start_day')
				)				
			)
			$limitation  
			$permissions 
			$tag_str ";
		
		
		$result_events = self::findAll(array(
			'conditions' => $conditions,
			'order' => '`start`',
		));
		
		// Find invitations for events and logged user
		ProjectEvents::addInvitations($result_events);	
		
		return $result_events;		
	}
	
	static function addInvitations($result_events, $user_id = -1) {
		if ($user_id == -1) $user_id = logged_user();
		if (isset($result_events) && is_array($result_events) && count($result_events)) {
			foreach ($result_events as $event) {
				$inv = EventInvitations::findById(array('event_id' => $event->getId(), 'user_id' => $user_id));
				/*if (is_array($inv)) {
					foreach ($inv as $i) {
						$event->addInvitation($i);
					}
				} else */if ($inv != null) {
					$event->addInvitation($inv);
				}
			}
		}
	}
	
	
	
	/**
	* Return paged project Events
	*
	* @param Project $project
	* @param boolean $hide_private Don't show private Events
	* @param string $order Order Events by name or by posttime (desc)
	* @param integer $page Current page
	* @param integer $Events_per_page Number of Events that will be showed per single page
	* @param boolean $group_by_order Group Events by order field
	* added by msaiz 03/10/07:
	* @param string for tag filter
	* @return array
	* 
	*/
/*	static function getProjectEvents($projectId = null, $folderId = null, $hide_private = false, $order = null, $orderdir = 'ASC', $page = null, $Events_per_page = null, $group_by_order = false, $tag = null, $type_string = null, $userId = null) {
		if ($order == self::ORDER_BY_POSTTIME) {
			$order_by = '`created_on` ' . $orderdir;
		} else if ($order == self::ORDER_BY_MODIFYTIME) {
			$order_by = '`updated_on` ' . $orderdir;
		} else {
			$order_by = '`filename`' . $orderdir;
		} // if
		
		if ((integer) $page < 1) {
			$page = 1;
		} // if
		if ((integer) $Events_per_page < 1) {
			$Events_per_page = 10;
		} // if
		
		
		if ($projectId == null || $projectId == 0) {
			$projectId = '1';
			$projectstr = " AND '1' = ? "; // this would generate a dummy condition
		} else {
			$projectstr = " AND `project_id` = ? ";
		}
		if ($tag == '' || $tag == null) {
			$tag = '1';
			$tagstr = " AND '1' = ? "; // dummy condition
		} else {
			$tagstr = " AND (select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "Project_Events.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = ? and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectEvents' ) > 0 ";
		}
		if ($type_string == '' || $type_string == null) {
			$type_string = '1';
			$typestr = " AND '1' = ? "; // dummy condition
		} else {
			$type_string .= '%';
			$typestr = " AND  (select count(*) from " . TABLE_PREFIX . "project_file_revisions where " .
				TABLE_PREFIX . "project_file_revisions.type_string LIKE ? AND " . TABLE_PREFIX .
				"project_Events.id = " . TABLE_PREFIX . "project_file_revisions.file_id)";
		}
		if ($userId == null || $userId == 0) {
			$userId = '1';
			$userstr = " AND '1' = ?"; // dummy condition
		} else {
			$userstr = " AND `created_by_id` = ? ";
		}
		if ($folderId == null || $folderId == 0) {
			$folderId = '1';
			$folderstr = " AND '1' = ? "; // dummy condition
		} else {
			$folderstr = " AND `folder_id` = ? ";
		}
		if ($hide_private) {
			$permissionstr = " AND NOT `is_private` ";
		} else {
			$permissionstr = "";
		}
		
		$otherConditions = $folderstr . $projectstr . $tagstr . $typestr . $userstr . $permissionstr;
		
		if ($hide_private) {
			$conditions = array('`is_private` = ? AND `is_visible` = ?' . $otherConditions, false, true, $folderId, $projectId, $tag, $type_string, $userId);
		} else {
			$conditions = array('`is_visible` = ?' . $otherConditions, true, $folderId, $projectId, $tag, $type_string, $userId);
		}
		
		list($Events, $pagination) = ProjectEvents::paginate(array(
				'conditions' => $conditions,
				'order' => $order_by
			), $Events_per_page, $page);
		
		if ($group_by_order) {
			$grouped_Events = array();
			if (is_array($Events) && count($Events)) {
				$today = DateTimeValueLib::now();
				foreach ($Events as $file) {
					$group_by_str = '';
					if ($order == self::ORDER_BY_POSTTIME) {
						$created_on = $file->getCreatedOn();
						if($created_on->getYear() == $today->getYear()) {
							$group_by_str = format_descriptive_date($created_on);
						} else {
							$group_by_str = format_date($created_on);
						} // if
					} else {
						$group_by_str = strtoupper(substr_utf($file->getFilename(), 0, 1));
					} // if

					if (!isset($grouped_Events[$group_by_str]) || !is_array($grouped_Events[$group_by_str])) {
						$grouped_Events[$group_by_str] = array();
					}
					$grouped_Events[$group_by_str][] = $file;
				} // foreach
			} // if
			$Events = is_array($grouped_Events) ? $grouped_Events : null;
		} // if
		
		return array($Events, $pagination);
	} // getProjectEvents
*/	

	/**
	* Reaturn all calendar Events
	*
	* @param Project $project
	* @return array
	*/
	static function getAllEventsByProject(Project $project = null) {
		if ($project instanceof Project) {
			$pids = $project->getAllSubWorkspacesCSV(true, logged_user());
		} else {
			$pids = logged_user()->getActiveProjectIdsCSV();
		}
		$cond_str = "`project_id` IN ($pids)";
		$result_events = self::findAll(array(
			'conditions' => array($cond_str)
		)); // findAll
		
		// Find invitations for events and logged user
		ProjectEvents::addInvitations($result_events);
		
		return $result_events;
	} // getAllEventsByProject
	
	  
} // ProjectEvents 

?>