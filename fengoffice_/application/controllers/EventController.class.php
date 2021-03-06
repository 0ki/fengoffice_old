<?php

/**
* Controller that is responsible for handling project events related requests
*
* @version 1.0
* @author Marcos Saiz <marcos.saiz@gmail.com>
* @adaptd from Reece calendar <http://reececalendar.sourceforge.net/>
*/

class EventController extends ApplicationController {

	/**
	* Construct the EventController
	*
	* @access public
	* @param void
	* @return EventController
	*/
	function __construct() {
		parent::__construct();
		if (is_ajax_request()) {
			prepare_company_website_controller($this, 'ajax');
		} else {
			prepare_company_website_controller($this, 'website');
		}	
		// Reece calendar initialization
		//define('CAL_SECURITY_BIT',1);
		$_SESSION['cal_loginfailed'] = 0;
		$_SESSION['cal_user'] = logged_user()->getUsername();
		$_SESSION['cal_userid'] = logged_user()->getId() ;
		cal_add_to_links('c=event');
		cal_load_permissions();
	} // __construct
     	
	/**
	* Show events index page (list recent events)
	*
	* @param void
	* @return null
	*/
	function index() {
		//auth check in cal_query_get_eventlist		
		if(! ( logged_user()->isAdministrator() || (active_project() && logged_user()->isProjectUser(active_project())))){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('dashboard');
	    }		
		//$can_add = ProjectEvent::canAdd(logged_user(), active_project());
		$this->setTemplate('calendar');
	}
	
	function add(){		
		//check auth
	    if(! (ProjectEvent::canAdd(logged_user(), active_project()))){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
	    }
		$this->setTemplate('event');
		tpl_assign('cal_action','add');
	}
	function modify(){	
		//check auth
		$event = ProjectEvents::findById(get_id());
	    if(!$event->canEdit(logged_user())){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
	    }
	          
        $tag_names = $event->getTagNames();
        $event_data = array(
          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
        ); // array
        
		$this->setTemplate('event');
		tpl_assign('event',$event);
		tpl_assign('cal_action','modify');
		tpl_assign('event_data',$event_data);
	}
	

	function delete(){
		//check auth
		$event = ProjectEvents::findById(get_id());
	    if(!$event->canDelete(logged_user())){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
	    }	
		$this->setTemplate('viewdate');
		//tpl_assign('cal_action','calendar');
		//tpl_assign('action','calendar');
   		if(!$event->delete()){
			echo $this->cal_error($del_error);
		}
	}
	function viewdate(){
		tpl_assign('cal_action','viewdate');
		$this->setTemplate('viewdate');		
	}
	function viewevent(){
		//check auth
	    $event = ProjectEvents::findById(get_id());
	    if(!$event->canView(logged_user())){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
	    }
		$this->setTemplate('viewevent');	
		// tpl_assign('evnt',$evnt);
		tpl_assign('cal_action','viewevent');	
	}
	/*function search(){
		$this->setTemplate('search');		
	}*/
	function cal_error($text){
		$output = "<center><span class='failure'>$text</span></center><br>";
		return $output;
	}
	/**
	 * 	  cal_submit_event()
	 * 	   Add's an event to the database if required fields are
	 * 	   all provided, else it produces an error.
	 * */
	function cal_submit_event($day = NULL, $month = NULL, $year = NULL){
		global $cal_db;
		if(array_var($_POST,'modify')){
			if(!is_numeric($_POST['id'])) return CAL_MISSING_INFO;
			$id = $_POST['id'];
			$modify = 1;
		} else $modify = 0;
		// get the day
		if( $day==NULL AND is_numeric($_SESSION['cal_day'])) $day   = $_SESSION['cal_day'];
		elseif(is_numeric($_POST['day'])) $day = $_POST['day'];
		else return "You did not enter the Day: $day";
		// get month
		if($month==NULL AND is_numeric($_SESSION['cal_month'])) $month = $_SESSION['cal_month'];
		elseif($_POST['month']!="" AND is_numeric($_POST['month'])) $month = $_POST['month'];
		else return "You did not enter the month";
		// get year
		if($year==NULL AND is_numeric($_SESSION['cal_year'])) $year  = $_SESSION['cal_year'];
		elseif($_POST['year']!="" AND is_numeric($_POST['year'])) $year = $_POST['year'];
		else return "You did not enter the year";
		// get the posted times
		if(isset($_POST['hour']) AND $_POST['hour']!="" AND is_numeric($_POST['hour'])) $hour = $_POST['hour'];
		//else return "You did not enter the Hour";
		if(isset($_POST['pm']) AND ($_POST['pm']) && $_POST['pm'] == 1) $hour += 12;
		if(isset($_POST['minute']) AND$_POST['minute']!="" AND is_numeric($_POST['minute'])) $minute = $_POST['minute'];
		//else return "Your did not enter the minute";
		// make sure the date is actually valid
		// must do this here or else they could put in something crazy that could somehow bypass the editpast permission
		$redotime = mktime(0,0,1,$month, $day, $year);
		$day = date("d",$redotime);
		$month = date("m",$redotime);
		$year = date("Y",$redotime);
		// if modifying, get the event and check it's data
		if($modify){
			// get event data to do permissions checking.			
			$perm = ProjectEvents::findById($id)->canEdit(logged_user());
			if(!$perm) return CAL_NO_MODIFY;
		}
		// if not modifying, make sure they have permission to write new events
		else{
			if(active_project() && !ProjectEvent::canAdd(logged_user(), active_project())) return CAL_NO_WRITE;
			// note that I dont just compare strings like above, because I don't know if passed in variables have leading zero or not
		}
		// repeat defaults
		$repeat_d = 0;
		$repeat_m = 0;
		$repeat_y = 0;
		$repeat_h = 0;
		$oend = "0000-00-00";
		// get the options
		$jump = array_var($_POST,'occurance_jump');
		if(array_var($_POST,'repeat_option')==1) $forever = 1;
		elseif(array_var($_POST,'repeat_option')==2) $rnum = $_POST['repeat_num'];
		elseif(array_var($_POST,'repeat_option')==3) $rend = $_POST['repeat_end'];
		// verify the options above are valid
		// I made the jump and rnum values max out at 1000 for performance purposes, but you can change that.
		if(isset($rnum) && $rnum !=""){
			if(!is_numeric($rnum)) return CAL_EVENT_COUNT_ERROR;
			if($rnum < 1) return CAL_EVENT_COUNT_ERROR;
			if($rnum > 1000) return CAL_EVENT_COUNT_ERROR;
		}else $rnum = 0;
		if($jump !=""){
			if(!is_numeric($jump)) return CAL_REPEAT_EVERY_ERROR;
			if($jump<1) return CAL_REPEAT_EVERY_ERROR;
			if($jump>1000) return CAL_REPEAT_EVERY_ERROR;
		}else $jump = 1;
		if(isset($rend) && $rend!=""){
			$endarray = explode("-",$rend);
			if(count($endarray)!=3) return CAL_ENDING_DATE_ERROR;
			foreach($endarray as $v){ if(!is_numeric($v)) return CAL_ENDING_DATE_ERROR;}
			$rend = date("Y-m-d",mktime(0,0,1,$endarray[1], $endarray[2], $endarray[0]));
		}
		// check for repeating options
		// 1=repeat once, 2=repeat daily, 3=weekly, 4=monthy, 5=yearly, 6=holiday repeating
		switch(array_var($_POST,'occurance')){
		case "2":
			$repeat_d = $jump;
			if($forever==1) $oend = "9999-00-00";
			else $oend = $rend;
			break;
		case "3":
			$repeat_d = 7*$jump;
			if($forever==1) $oend = "9999-00-00";
			else $oend = $rend;
			break;
		case "4":
			$repeat_m = $jump;
			if($forever==1) $oend = "9999-00-00";
			else $oend = $rend;
			break;
		case "5":
			$repeat_y = $jump;
			if(isset($forever) && $forever==1) $oend = "9999-00-00";
			else $oend = $rend;
			break;
		case "6":
			$repeat_h = 1;
			if($_POST['cal_holiday_lastweek']) $repeat_h = 2;
			break;
		}
		$repeat_number = $rnum;
		// get event type
		$type = array_var($_POST,'eventtype');
		if(!is_numeric($type)) $type = 0;
		// get description
		if(array_var($_POST,'description')) {
			$description = $_POST['description'];
			if(count($description)>3000) return CAL_DESCRIPTION_ERROR;
		} else $description = '';
	 	// get subject
		if(array_var($_POST,'subject')) {
			$subject = $_POST['subject'];
			if($subject=='' || count($subject)>100) return CAL_SUBJECT_ERROR;
		} else return CAL_SUBJECT_ERROR;
		// check if private event or not
		$private = array_var($_POST,'private');
		if($private=="1" AND !cal_anon());
		else $private=="0";
	 	// get duration
		$durationhour = array_var($_POST,'durationhour');
		//else return CAL_DURATION_ERROR;
		$durationmin = array_var($_POST,'durationmin');
		//else return CAL_DURATION_ERROR;
	 	// get anonymous alias
		if(array_var($_POST,'alias')) $alias = $_POST['alias'];
		else $alias = "";
		// get event type:  2=full day, 3=time/duratin not specified, 4=time not specified
		$typeofevent = array_var($_POST,'eventtype');
		if(!is_numeric($typeofevent) OR $typeofevent!=2 OR $typeofevent!=4) $typeofevent = 0;
		if(!array_var($_POST,'usetimeandduration')){
			$typeofevent = 3; 
			$hour = 0;
			$minute = 0;
		}		
		// calculate timestamp and durationstamp
		// By putting through mktime(), we don't have to check for sql injection here and ensure the date is valid at the same time.
		$timestamp = date('Y-m-d H:i:s', mktime($hour,$minute,0,$month,$day,$year));
		$durationstamp = date('Y-m-d H:i:s', mktime($hour + $durationhour,$minute + $durationmin, 0, array_var($_POST,'cal_origmonth'), array_var($_POST,'cal_origday'), array_var($_POST,'cal_origyear')));
		// organize the data expected by the query function
		$data = array();
		$data['repeat_num'] = $rnum;
		$data['type_id'] = $type;
		$data['repeat_h'] = $repeat_h;
		$data['repeat_d'] = $repeat_d;
		$data['repeat_m'] = $repeat_m;
		$data['repeat_y'] = $repeat_y;
		if(isset($oend) && $oend!="") {
			$data['repeat_end'] =  $oend;
		}
		$data['start'] = $timestamp;
		$data['subject'] = $subject;
		$data['private'] = $private;
		$data['description'] = $description;
		$data['eventtype'] = $typeofevent;
		$data['duration'] = $durationstamp;
		// run the query to set the event data                     
		if($modify) {
			$event = ProjectEvents::findById($id);
			$project = $event->getProject(); 
		}
		else {
			$event=new ProjectEvent();
			$project = active_or_personal_project();
        	$event->setProjectId($project->getId());
		}
        $event->setFromAttributes($data); 
        if(!logged_user()->isMemberOfOwnerCompany()) $event->setIsPrivate(false);  
		try {
          
          DB::beginWork();
          $event->save();
          $event->setTagsFromCSV(array_var(array_var($_POST,'event'), 'tags'));          
		  $event->save_properties(array_var($_POST,'event'));
          ApplicationLogs::createLog($event, $project, ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add event', $event->getObjectName()));
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        /*
		if($modify) 
		$result = cal_query_setevent($data, $id); // if we specify the ID, it updates that ID using $data
		else 
		$result = cal_query_setevent($data); // if we don't specify ID, it create a new event using $data
		// return an error if the SQL query failed
		if(!$result) return CAL_EVENT_UPDATE_FAILED;*/
		// returning NULL means it was a success (no error message)
		return NULL;
	}

	function submitevent(){
		//check auth
	    if(active_project() && !ProjectEvent::canAdd(logged_user(),active_project())){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
	    }
		$sub_error = $this->cal_submit_event();
		if(isset($sub_error) && $sub_error!=null && $sub_error!="") 
		{
			echo $this->cal_error($sub_error) ;			
		}
		$this->viewdate();
		/*$_SESSION['cal_action'] = "viewdate";
		$this->setTemplate('viewdate');*/
	}
	function admin(){
		//check auth
	    if(!logged_user()->isAdministrator()){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
	    }
		$this->setTemplate('admin');		
	}
	
	
	/**
	 * add event type
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_type(){		 
		$type = new EventType();
		$type_data = array_var($_POST, 'eventtype');
		 
		tpl_assign('eventtype', $type);
		tpl_assign('eventtype_data', $type_data);
		 
		if(is_array($type_data)) {
			$type->setFromAttributes($type_data);
			$type->setProjectId(active_project()->getId());

			try {
				DB::beginWork();
				$type->save();
				
				DB::commit();

				flash_success(lang('success add event type', $type->getName()));
				$this->redirectTo('event');
			} catch(Exception $e) {
				DB::rollback();
				tpl_assign('error', $e);
			} // try
		} // if
	}
	
	
	
	/**
	 * edit event type
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit_type(){
		$type = EventTypes::findById(get_id());
		if(!($type instanceof EventType )) {
			flash_error(lang('event type dnx'));
			$this->redirectTo('event');
		} // if
		$type_data = array_var($_POST, 'eventtype');
		 
		tpl_assign('eventtype', $type);
		tpl_assign('eventtype_data', $type_data);
		 
		if(is_array($type_data)) {
			$type->setFromAttributes($type_data);
			$type->setProjectId(active_project()->getId());

			try {
				DB::beginWork();
				$type->save();
				
				DB::commit();

				flash_success(lang('success add event type', $type->getName()));
				$this->redirectTo('event');
			} catch(Exception $e) {
				DB::rollback();
				tpl_assign('error', $e);
			} // try
		} // if
	}
	
	
	/**
	 * Delete event type
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_type() {
		$type = EventTypes::findById(get_id());
		if(!($type instanceof EventType )) {
			flash_error(lang('event type dnx'));
			$this->redirectTo('event');
		} // if
		 
		try {
			DB::beginWork();
			$type->delete();
			DB::commit();

			flash_success(lang('success delete event type', $type->getName()));
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete event type'));
		} // try
		 
		$this->redirectTo('files');
	} // delete_eventtype
} // EventController

/***************************************************************************
 *           Parts of the code for this class were extracted from
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: EventController.class.php,v 1.8 2008/05/02 20:38:15 msaiz Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
/*
	Code is from:
	Copyright (c) Reece Pegues
	sitetheory.com

    Reece PHP Calendar is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or 
	any later version if you wish.

    You should have received a copy of the GNU General Public License
    along with this file; if not, write to the Free Software
    Foundation Inc, 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
*/
?>