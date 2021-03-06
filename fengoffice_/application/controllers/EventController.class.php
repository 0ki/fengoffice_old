<?php

/**
* Controller that is responsible for handling project events related requests
*
* @version 1.0
* @author Marcos Saiz <marcos.saiz@gmail.com>
* @adapted from Reece calendar <http://reececalendar.sourceforge.net/>.
* Acknowledgements at the bottom.
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
		prepare_company_website_controller($this, 'website');	
		// Reece calendar initialization
		//define('CAL_SECURITY_BIT',1);
		$_SESSION['cal_loginfailed'] = 0;
		$_SESSION['cal_user'] = logged_user()->getUsername();
		$_SESSION['cal_userid'] = logged_user()->getId();
		cal_add_to_links('c=event');
		cal_load_permissions();
		
		$_SESSION['active_calendar_view'] = 'viewweek';
	} // __construct
     	
	/**
	* Show events index page (list recent events)
	*
	* @param void
	* @return null
	*/
	function index() {
		//auth check in cal_query_get_eventlist		
		if( (!(logged_user()->isAdministrator())) && ((active_project() && !(logged_user()->isProjectUser(active_project()))))){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('dashboard');
			return ;
	    }		
		ajx_set_no_toolbar(true);
		ajx_replace(true);
		
		$_SESSION['active_calendar_view'] = 'index';
				 
		$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
		$month = isset($_GET['month']) ? $_GET['month'] : date('n');
		$day = isset($_GET['day']) ? $_GET['day'] : date('j');
		
		$user_filter = !isset($_GET['user_filter']) || $_GET['user_filter'] == 0 ? logged_user()->getId() : $_GET['user_filter']; 
	    $state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3';
	    $state_filter = explode(' ', $state_filter); // make an array of filters
				  
		$pm = $month - 1;
		$py = $year;
		if($pm == 0){
			$pm = 12;
			$py--;
		}
		$nm = $month + 1;
		$ny = $year;
		if($nm == 13){
			$nm = 1;
			$ny++;
		}
		ajx_replace(true);
		 
	    $tag = active_tag();
		tpl_assign('tags',$tag);
		$this->setTemplate('calendar');
	}
	
	function registerInvitations($data, $event) {
		// Invitations
		foreach ($data['users_to_invite'] as $id => $assist) {
			$conditions = array('event_id' => $event->getId(), 'user_id' => $id);
			//insert only if not exists 
			if (EventInvitations::findById($conditions) == null) { 
	            $invitation = new EventInvitation();
	            $invitation->setEventId($event->getId());
	            $invitation->setUserId($id);
	            $invitation->setInvitationState($assist);
	            $invitation->save();
            }
		}
	}
	
	function change_invitation_state($attendance = null, $event_id = null, $user_id = null) {
		$from_post = $attendance == null || $event_id == null; 
		if ($attendance == null) $attendance = array_var($_POST, 'event_attendance');
		if ($event_id == null) $event_id = array_var($_POST, 'event_id');
		if ($user_id == null) $user_id = array_var($_POST, 'user_id');
		
		if ($attendance == null || $event_id == null) {
			flash_error('Missing parameters');
			ajx_current("back");
		} else {
			$conditions = array('event_id' => $event_id, 'user_id' => $user_id);
			$inv = EventInvitations::findById($conditions);
			if ($inv != null) {
				$inv->setInvitationState($attendance);
				$inv->save();
			}
			if ($from_post) {
				flash_success(lang('success edit event', ''));
				ajx_current("back");
			}
		}
	}
	
	function getData($event_data){
		// get the day
			if (array_var($event_data, 'start_value') != '') {
				$startDate = explode('/', array_var($event_data, 'start_value'));
				$posD = 0;
				$posM = 1;
				$posY = 2;
				if (lang('date format') == 'm/d/Y') {
					$posD = 1;
					$posM = 0;
				}
				$day = $startDate[$posD];
	       		$month = $startDate[$posM];
	       		$year = $startDate[$posY];
			} else {
				$month = isset($_GET['month'])?$_GET['month']:date('n');
				$day = isset($_GET['day'])?$_GET['day']:date('j');
				$year = isset($_GET['year'])?$_GET['year']:date('Y');
			}
       		
			if (array_var($event_data, 'start_time') != '') {
				$this->parseTime(array_var($event_data, 'start_time'), $hour, $minute);
			} else {
				$hour = array_var($event_data, 'hour');
	       		$minute = array_var($event_data, 'minute');
				if(array_var($event_data, 'pm') == 1) $hour += 12;
			}
			if (array_var($event_data, 'type_id') == 2 && $hour == 24) $hour = 23;
			// make sure the date is actually valid
			$redotime = mktime(0, 0, 1, $month, $day, $year);
			$day = date("d", $redotime);
			$month = date("m", $redotime);
			$year = date("Y", $redotime);
			
			
			// repeat defaults
			$repeat_d = 0;
			$repeat_m = 0;
			$repeat_y = 0;
			$repeat_h = 0;
			$rend = '';		
			// get the options
			$forever = 0;
			$jump = array_var($event_data,'occurance_jump');
			
			if(array_var($event_data,'repeat_option') == 1) $forever = 1;
			elseif(array_var($event_data,'repeat_option') == 2) $rnum = array_var($event_data,'repeat_num');
			elseif(array_var($event_data,'repeat_option') == 3) $rend = getDateValue(array_var($event_data,'repeat_end'));
			// verify the options above are valid
			if(isset($rnum) && $rnum !="") {
				if(!is_numeric($rnum) || $rnum < 1 || $rnum > 1000) {
					throw new Exception(CAL_EVENT_COUNT_ERROR);
				}
			} else $rnum = 0;
			if($jump != ""){
				if(!is_numeric($jump) || $jump < 1 || $jump > 1000) {
					throw new Exception(CAL_REPEAT_EVERY_ERROR);
				}
			} else $jump = 1;
			
		
		    // check for repeating options
			// 1=repeat once, 2=repeat daily, 3=weekly, 4=monthy, 5=yearly, 6=holiday repeating
			$oend = null;
			switch(array_var($event_data,'occurance')){
				case "2":
					$repeat_d = $jump;
					if(isset($forever) && $forever == 1) $oend = null;
					else $oend = $rend;
					break;
				case "3":
					$repeat_d = 7 * $jump;
					if(isset($forever) && $forever == 1) $oend = null;
					else $oend = $rend;
					break;
				case "4":
					$repeat_m = $jump;
					if(isset($forever) && $forever == 1) $oend = null;
					else $oend = $rend;
					break;
				case "5":
					$repeat_y = $jump;
					if(isset($forever) && $forever == 1) $oend = null;
					else $oend = $rend;
					break;
				case "6":
					$repeat_h = 1;
					if(array_var($event_data, 'cal_holiday_lastweek')) $repeat_h = 2;
					break;
			}
			$repeat_number = $rnum;
			
			
		 	// get duration
			$durationhour = array_var($event_data,'durationhour');
			$durationmin = array_var($event_data,'durationmin');
			
			// get event type:  2=full day, 3=time/duratin not specified, 4=time not specified
			$typeofevent = array_var($event_data,'type_id');
			if(!is_numeric($typeofevent) OR ($typeofevent!=1 AND $typeofevent!=2 AND $typeofevent!=3)) $typeofevent = 1;

			if ($durationhour == 0 && $durationmin < 15 && $typeofevent != 2) {
				throw new Exception(lang('duration must be at least 15 minutes'));
			}
									
			// calculate timestamp and durationstamp
			// By putting through mktime(), we don't have to check for sql injection here and ensure the date is valid at the same time.
			$timestamp = date('Y-m-d H:i:s', mktime($hour+null, $minute+null, 0, $month,$day,$year));
			if ($hour + $durationhour > 24)
				$durationstamp = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, $day+1, $year));
			else
				$durationstamp = date('Y-m-d H:i:s', mktime($hour + $durationhour, $minute + $durationmin, 0, $month, $day, $year)); 

			// organize the data expected by the query function
			$data = array();
			$data['repeat_num'] = $rnum;
			$data['repeat_h'] = $repeat_h;
			$data['repeat_d'] = $repeat_d;
			$data['repeat_m'] = $repeat_m;
			$data['repeat_y'] = $repeat_y;
			$data['repeat_forever'] = $forever;
			$data['repeat_end'] =  $oend;
			$data['start'] = $timestamp;
			$data['subject'] =  array_var($event_data,'subject');
			$data['description'] =  array_var($event_data,'description');
			$data['type_id'] = $typeofevent;
			$data['duration'] = $durationstamp;
			
			$data['users_to_invite'] = array();
			// owner user always is invited and confirms assistance
			$data['users_to_invite'][logged_user()->getId()] = 1; 

			$compstr = 'invite_user_';
			foreach ($event_data as $k => $v) {
				if (str_starts_with($k, $compstr) && $v == 'checked') {
					$data['users_to_invite'][substr($k, strlen($compstr))] = 0; // Pending Answer
				}
			}
			
			if (isset($event_data['confirmAttendance'])) {
				$data['confirmAttendance'] = array_var($event_data, 'confirmAttendance');
			}			
			
			if (isset($event_data['send_notification'])) {
				$data['send_notification'] = array_var($event_data,'send_notification') == 'checked';
			}
			return $data;
	}
	
	function add(){		
		if(! (ProjectEvent::canAdd(logged_user(), active_or_personal_project()))){	    	
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
	    }
	    $this->setTemplate('event');
		$event = new ProjectEvent();		
		$event_data = array_var($_POST, 'event');
		$event_subject = array_var($_GET, 'subject'); //if sent from pupup
		
		$month = isset($_GET['month'])?$_GET['month']:date('n');
		$day = isset($_GET['day'])?$_GET['day']:date('j');
		$year = isset($_GET['year'])?$_GET['year']:date('Y');
		
		$user_filter = isset($_GET['user_filter']) ? $_GET['user_filter'] : logged_user()->getId();
		$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3';
	    $state_filter = explode(' ', $state_filter); // make an array of filters 
		
		if(!is_array($event_data)) {
			// if data sent from quickadd popup (via get) we se it, else default
			if (isset($_GET['start_time'])) $this->parseTime($_GET['start_time'], $hour, $minute);
			else {
				$hour = isset($_GET['hour']) ? $_GET['hour'] : date('G', DateTimeValueLib::now()->getTimestamp() + logged_user()->getTimezone() * 3600);
				$minute = isset($_GET['minute']) ? $_GET['minute'] : round((date('i') / 15), 0) * 15; //0,15,30 and 45 min
			}
			if(!config_option('time_format_use_24')) {
				if($hour >= 12){
					$pm = 1;
					$hour = $hour - 12;
				} else $pm = 0;
			}
			$event_data = array(
				'month' => isset($_GET['month']) ? $_GET['month'] : date('n'),
				'year' => isset($_GET['year']) ? $_GET['year'] : date('Y'),
				'day' => isset($_GET['day']) ? $_GET['day'] : date('n'),
				'hour' => $hour,
				'minute' => $minute,
				'pm' => (isset($pm) ? $pm : 0),
				'typeofevent' => isset($_GET['type_id']) ? $_GET['type_id'] : 1,
				'subject' => $event_subject,
				'durationhour' => isset($_GET['durationhour']) ? $_GET['durationhour'] : 1,
				'durationmin' => isset($_GET['durationmin']) ? $_GET['durationmin'] : 0,
			); // array
		} // if
		
		tpl_assign('event', $event);
		tpl_assign('event_data', $event_data);
		tpl_assign('active_projects', logged_user()->getActiveProjects());

		if (is_array(array_var($_POST, 'event'))) {
			try {
				$data = $this->getData($event_data);
				
				// run the query to set the event data 
				$projId = array_var($event_data, 'project_id');      
				if($projId != '') {
					$project = Projects::findById($projId );
				}
				else {
			 		$project = active_or_personal_project();
				}

	        	$event->setProjectId($project->getId());
			    $event->setFromAttributes($data);
			    

			    if(!logged_user()->isMemberOfOwnerCompany()) $event->setIsPrivate(false);  
		
			    DB::beginWork();
	          	$event->save();
	          	$event->setTagsFromCSV(array_var($event_data, 'tags'));   
	            $event->save_properties(array_var($event_data, 'event'));
	            
	            $this->registerInvitations($data, $event);
	            if (isset($data['confirmAttendance'])) {
	            	$this->change_invitation_state($data['confirmAttendance'], $event->getId(), $user_filter);
	            }
	            
				if (isset($data['send_notification']) && $data['send_notification']) {
					$users_to_inv = array();
            		foreach ($data['users_to_invite'] as $us => $v) {
            			if ($us != logged_user()->getId()) {
            				$users_to_inv[] = Users::findById(array('id' => $us));
            			}
            		}
            		Notifier::notifEvent($event, $users_to_inv, true);
		        }
		        
			    $object_controller = new ObjectController();
			    $object_controller->link_to_new_object($event);
	         	DB::commit();
	          	ApplicationLogs::createLog($event, $event->getWorkspaces(), ApplicationLogs::ACTION_ADD);
	          	
	          	flash_success(lang('success add event', $event->getObjectName()));

	          	if (array_var($_POST, 'popup', false)) {
					ajx_current("reload");
	          	} else {
	          		ajx_current("back");
	          	}
	          	ajx_add("overview-panel", "reload");
	        } catch(Exception $e) {
	          	DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
	        } // try
		    
		}
	}
	
	function delete(){
		//check auth
		$event = ProjectEvents::findById(get_id());
	    if(!$event->canDelete(logged_user())){	    	
			flash_error(lang('no access permissions'));
			$this->redirectTo('event');
			return ;
	    }
		$this->setTemplate('viewdate');
		$tag = active_tag();
		tpl_assign('tags',$tag);
		try {
			
			$notifications = array();
			$invs = EventInvitations::findAll(array ('conditions' => 'event_id = ' . $event->getId()));
			if (is_array($invs)) {
				foreach ($invs as $inv) {
					if ($inv->getUserId() != logged_user()->getId()) 
						$notifications[] = Users::findById(array('id' => $inv->getUserId()));
				}
			} else {
				if ($invs->getUserId() != logged_user()->getId()) 
					$notifications[] = Users::findById(array('id' => $invs->getUserId()));
			}
			Notifier::notifEventDeletion($event->getSubject(), $event->getProject()->getName(), $event->getStart(), $notifications);
			
			DB::beginWork();
			// delete event
			$event->trash();
			ApplicationLogs::createLog($event, $event->getWorkspaces(), ApplicationLogs::ACTION_TRASH);
			DB::commit();

			flash_success(lang('success delete event', $event->getSubject()));
			
			if (array_var($_POST, 'popup', false)) {
				ajx_current("reload");
          	} else {
          		ajx_current("back");
          	}
          	ajx_add("overview-panel", "reload");          	
		} catch(Exception $e) {
			DB::rollback();
			Logger::log($e->getTraceAsString());
			flash_error(lang('error delete event'));
			ajx_current("empty");
		} // try
	}
	
	function viewdate(){
		$tag = active_tag();
		tpl_assign('tags',$tag);	
		tpl_assign('cal_action','viewdate');
		ajx_set_no_toolbar(true);
		
		$_SESSION['active_calendar_view'] = 'viewdate';
		
		$day = isset($_GET['day'])?$_GET['day']:date('j');
		$month = isset($_GET['month'])?$_GET['month']:date('n');
	    $year = isset($_GET['year'])?$_GET['year']:date('Y');

		$user_filter = !isset($_GET['user_filter']) || $_GET['user_filter'] == 0 ? logged_user()->getId() : $_GET['user_filter']; 
	    $state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3';
	    $state_filter = explode(' ', $state_filter); // make an array of filters
	    	    
	    $this->setTemplate('viewdate');		
	}
	
	function viewweek(){
		$tag = active_tag();
		tpl_assign('tags',$tag);	
		tpl_assign('cal_action','viewdate');
		ajx_set_no_toolbar(true);
		
		$_SESSION['active_calendar_view'] = 'viewweek';
				
		$day = isset($_GET['day']) ? $_GET['day'] : date('j');
		$month = isset($_GET['month']) ? $_GET['month'] : date('n');
	    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
	    
		$user_filter = !isset($_GET['user_filter']) || $_GET['user_filter'] == 0 ? logged_user()->getId() : $_GET['user_filter']; 
	    $state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3';
	    $state_filter = explode(' ', $state_filter); // make an array of filters

		$this->setTemplate('viewweek');		
	}
	
	
	function viewevent(){
		//check auth
		$this->addHelper('textile');
		ajx_set_no_toolbar(true);
	    $event = ProjectEvents::findById(get_id());
	    if (isset($event) && $event != null) {
		    if(!$event->canView(logged_user())){
				flash_error(lang('no access permissions'));
				$this->redirectTo('event');
				return ;
		    }
			$this->setTemplate('viewevent');
			$tag = active_tag();
			tpl_assign('tags',$tag);	
			tpl_assign('event',$event);
			tpl_assign('cal_action','viewevent');	
			tpl_assign('view', array_var($_GET, 'view','month'));	
			tpl_assign('active_projects',logged_user()->getActiveProjects());
			ajx_extra_data(array("title" => $event->getSubject(), 'icon'=>'ico-calendar'));
	    } else {
	    	flash_error(lang('event dnx'));
			ajx_current("empty");
			return ;
	    }
	}

	function cal_error($text){
		$output = "<center><span class='failure'>$text</span></center><br>";
		return $output;
	}
	
		
	function edit() {
		$this->setTemplate('event');
		$event = ProjectEvents::findById(get_id());
		
		$user_filter = isset($_GET['user_id']) ? $_GET['user_id'] : logged_user()->getId();
		$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3';
	    $state_filter = explode(' ', $state_filter); // make an array of filters
		
		$inv = EventInvitations::findById(array('event_id' => $event->getId(), 'user_id' => $user_filter));
		if ($inv != null) {
			$event->addInvitation($inv);
		}
		$event->addInvitation($inv);
		
		if(!$event->canEdit(logged_user())){	    	
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return ;
	    }
	    
		tpl_assign('active_projects',logged_user()->getActiveProjects());
	    
		$event_data = array_var($_POST, 'event');
		if(!is_array($event_data)) {
				
			$tag_names = $event->getTagNames();
			$setlastweek = false;
			$rsel1=false;$rsel2=false; $rsel3=false;
			$forever= $event->getRepeatForever();
			$occ = 1;
			if($event->getRepeatD()  > 0){ $occ = 2; $rjump = $event->getRepeatD();}
			if($event->getRepeatD() > 0 AND $event->getRepeatD()%7==0){ $occ = 3; $rjump = $event->getRepeatD()/7;}
			if($event->getRepeatM() > 0){ $occ = 4; $rjump = $event->getRepeatM();}
			if($event->getRepeatY() > 0){ $occ = 5; $rjump = $event->getRepeatY();}
			if($event->getRepeatH() > 0){ $occ = 6;}
			if($event->getRepeatH()==2){ $setlastweek = true;}
			if($event->getRepeatEnd()) { $rend = $event->getRepeatEnd();	}
			if($event->getRepeatNum() > 0) $rnum = $event->getRepeatNum();
			if(!isset($rjump) || !is_numeric($rjump)) $rjump = 1;
			// decide which repeat type it is
			if($forever) $rsel1 = true; //forever
			else if(isset($rnum) AND $rnum>0) $rsel2 = true; //repeat n-times
			else if(isset($rend) AND $rend instanceof DateTimeValue) $rsel3 = true; //repeat until
			
			//if(isset($rend) AND $rend=="9999-00-00") $rend = "";
			// organize the time and date data for the html select drop downs.
			$thetime = $event->getStart()->getTimestamp();
			$durtime = $event->getDuration()->getTimestamp() - $thetime;
			$hour = date('G', $thetime);
			// format time to 24-hour or 12-hour clock.
			if(!config_option('time_format_use_24')){
				if($hour >= 12){
					$pm = 1;
					$hour = $hour - 12;
				}else $pm = 0;
			}
				
			$event_data = array(
	          'subject'        => $event->getSubject(),
	          'description'        => $event->getDescription(),
	          'name'    => $event->getCreatedById(),
	          'username' => $event->getCreatedById(),
	          'typeofevent'  => $event->getTypeId(),
	          'forever'  => $event->getRepeatForever(),
	          'usetimeandduration'  => ($event->getTypeId())==3?0:1,
	          'occ' => $occ,
	          'rjump' => $rjump,
	          'setlastweek' => $setlastweek,
	          'rend' => isset($rend)?$rend:NULL,
	          'rnum' => isset($rnum)?$rnum:NULL,
	          'rsel1' => $rsel1,
	          'rsel2' => $rsel2,
	          'rsel3' => $rsel3,
	          'thetime' => $event->getStart()->getTimestamp(),
			  'hour' => $hour,
			  'minute' => date('i', $thetime),
			  'month' => date('n', $thetime),
			  'year' => date('Y', $thetime),
			  'day' => date('j', $thetime),
			  'durtime' => ($event->getDuration()->getTimestamp() - $thetime),
			  'durationmin' => ($durtime / 60) % 60,
			  'durationhour'  => ($durtime / 3600) % 24,
			  'durday' => floor($durtime / 86400),
			  'pm' => isset($pm) ? $pm : 0,
	          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : ''
				); // array
		} // if
	
		tpl_assign('event_data', $event_data);
		tpl_assign('event', $event);

		if(is_array(array_var($_POST, 'event'))) {
			try {
				$data = $this->getData($event_data);
				// run the query to set the event data 
				$projId = array_var($event_data,'project_id');                    
			
				$old_project_id = $event->getProjectId();
				if($projId != '' && $projId != $old_project_id) {
					$project = Projects::findById($projId);
					if(!$event->canAdd(logged_user(),$project)) {
						flash_error(lang('no access permissions'));
						ajx_current("empty");
						return;
					} // if
	        		$event->setProjectId($project->getId());
				}
			    $event->setFromAttributes($data); 
			    
			    $this->registerInvitations($data, $event);
				if (isset($data['confirmAttendance'])) {
	            	$this->change_invitation_state($data['confirmAttendance'], $event->getId(), $user_filter);
	            }
			    
	            if (isset($data['send_notification']) && $data['send_notification']) {
					$users_to_inv = array();
            		foreach ($data['users_to_invite'] as $us => $v) {
            			if ($us != logged_user()->getId()) {
            				$users_to_inv[] = Users::findById(array('id' => $us));
            			}
            		}
            		Notifier::notifEvent($event, $users_to_inv, false);
	            }
				    
			    if(!logged_user()->isMemberOfOwnerCompany()) $event->setIsPrivate(false);  				
	          
	          	DB::beginWork();
	         	$event->save();
	         	$event->setTagsFromCSV(array_var($event_data, 'tags')); 
			 	$event->save_properties(array_var($event_data,'event'));
	          	ApplicationLogs::createLog($event, $event->getWorkspaces(), ApplicationLogs::ACTION_EDIT);
	          	DB::commit();
	          	
	          	flash_success(lang('success edit event', $event->getObjectName()));

	          	if (array_var($_POST, 'popup', false)) {
					ajx_current("reload");
	          	} else {
	          		ajx_current("back");
	          	}
	          	ajx_add("overview-panel", "reload");          	
	        } catch(Exception $e) {
	        	DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");		          
	          //tpl_assign('error', $e);
	        } // try
		} // if
	} // edit
	
	
	/**
	 * Returns hour and minute in 24 hour format
	 *
	 * @param string $time_str
	 * @param int $hour
	 * @param int $minute
	 */
	function parseTime($time_str, &$hour, &$minute) {
		$exp = explode(':', $time_str);
		$hour = $exp[0];
		$minute = $exp[1];
		if (str_ends_with($time_str, 'M')) {
			$exp = explode(' ', $minute);
			$minute = $exp[0];
			if ($exp[1] == 'PM' && $hour < 12) {
				$hour = ($hour + 12) % 24;
			}
			if ($exp[1] == 'AM' && $hour == 12) {
				$hour = 0;
			}
		}
	}

} // EventController

/***************************************************************************
 *           Parts of the code for this class were extracted from
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: EventController.class.php,v 1.65 2008/12/05 20:35:05 alvarotm01 Exp $
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