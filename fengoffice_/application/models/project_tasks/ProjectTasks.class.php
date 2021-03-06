<?php

  /**
  * ProjectTasks, generated on Sat, 04 Mar 2006 12:50:11 +0100 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class ProjectTasks extends BaseProjectTasks {
  	
  	/*
	* Return tasks lists for the next two weeks which don't have due date and have not been completed.
	*
	* @param Project $project
	* @return array
	*/
	static function getUndatedTaskListsForTwoWeeks() {
		$user =  logged_user();
		
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id') .')';
		$objects = self::findAll(array(
  				'conditions' => array('((`assigned_to_user_id` = ? AND `assigned_to_company_id` = ? ) ' .
			  		 ' OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?) '.
			  		 ' OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) '.
			  		 ' AND `completed_on` = ? AND parent_id = ? AND due_date = ? ' . $permissions, $user->getId(), $user->getCompanyId(),
  					 0, $user->getCompanyId(), 0, 0, EMPTY_DATETIME,0, EMPTY_DATETIME),
        			'order' => '`created_on`'
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
		
		$permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id') .')';
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
    * Return Day tasks this user have access on
    *
    * @access public
    * @param void
    * @return array
    */
    function getDayTasksByUser(DateTimeValue $date,User $user) {
		
      $from_date =   (new DateTimeValue($date->getTimestamp()));
      $from_date = $from_date->beginningOfDay();
      $to_date =  (new DateTimeValue($date->getTimestamp()));
      $to_date = $to_date->endOfDay();
     
      $permissions = ' AND ( ' . permissions_sql_for_listings(ProjectTasks::instance(),ACCESS_LEVEL_READ, logged_user()->getId(), 'project_id') .')';
		
       $result = self::findAll(array(
        'conditions' => array('`completed_on` = ? AND (`due_date` >= ? AND `due_date` < ?) ' . $permissions, EMPTY_DATETIME, $from_date, $to_date)
      )); // findAll
      return $result;
    } // getDayTasksByUser
  
  } // ProjectTasks 

?>