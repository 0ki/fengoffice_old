<?php $genid = gen_id() ?>


<div id="<?php echo $genid ?>-db" style="padding:7px">
<div class="dashboard">
<table border=0><tr><td> <!-- submitted by xtender http://forums.opengoo.org/index.php?topic=221.0 -->
<div class="dashWorkspace">
<span class="name">
<?php 
if(active_project() instanceof Project) 
	echo active_project()->getName();
else 
	echo lang('all projects');
	
	$tags = active_tag();
	
	$hasPendingTasks = isset($dashtasks) && is_array($dashtasks) && count($dashtasks) > 0;
	$hasLateMilestones = (isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) || (isset($late_milestones) && is_array($late_milestones) && count($late_milestones));
	$hasMessages = isset($messages) && is_array($messages) && count($messages) > 0;
	$hasDocuments = isset($documents) && is_array($documents) && count($documents) > 0;
	$hasCharts = isset($charts) && is_array($charts) && count($charts) > 0;
	$hasUnreadEmails = isset($unread_emails) && is_array($unread_emails) && count($unread_emails) > 0;
	
	$hasToday = (isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) 
			|| (isset($today_tasks) && is_array($today_tasks) && count($today_tasks));
	$hasLate = (isset($late_tasks) && is_array($late_tasks) && count($late_tasks))
		|| (isset($late_milestones) && is_array($late_milestones) && count($late_milestones));
?>
</span><span class="description">
<?php if (active_project() instanceof Project && active_project()->getShowDescriptionInOverview()) echo '-&nbsp;' . active_project()->getDescription(); ?>
</span>
</div>

</td>
<td width="50%">
<div class="dashActions">
	<a class="internalLink" href="#" onclick="og.switchToOverview(); return false;">
	<div class="viewAsList"><?php echo lang('view as list') ?></div></a>
</div>
</td>
</tr>
</table>



<?php //--------------------------------------------- Remove FALSE
 if(!(active_project() instanceof Project) && false && logged_user()->isMemberOfOwnerCompany() && !owner_company()->getHideWelcomeInfo()) { ?>
<div class="hint">

  <div class="header"><?php echo lang('welcome to new account') ?></div>
  <div class="content"><?php echo lang('welcome to new account info', logged_user()->getDisplayName(), ROOT_URL) ?></div>
  
<?php if(owner_company()->isInfoUpdated()) { ?>
  <div class="header"><del><?php echo lang('new account step1') ?></del></div>
  <div class="content"><del><?php echo lang('new account step1 info', get_url('company', 'edit')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step1') ?></div>
  <div class="content"><?php echo lang('new account step1 info', get_url('company', 'edit')) ?></div>
<?php } // if ?>
  
<?php if(owner_company()->countUsers() > 1) { ?>
  <div class="header"><del><?php echo lang('new account step2') ?></del></div>
  <div class="content"><del><?php echo lang('new account step2 info', owner_company()->getAddUserUrl()) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step2') ?></div>
  <div class="content"><?php echo lang('new account step2 info', owner_company()->getAddUserUrl()) ?></div>
<?php } // if?>
  
<?php if(owner_company()->countClientCompanies() > 0) { ?>
  <div class="header"><del><?php echo lang('new account step3') ?></del></div>
  <div class="content"><del><?php echo lang('new account step3 info', get_url('company', 'add_client')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step3') ?></div>
  <div class="content"><?php echo lang('new account step3 info', get_url('company', 'add_client')) ?></div>
<?php } // if ?>
  
<?php if(owner_company()->countProjects() > 0) { ?>
  <div class="header"><del><?php echo lang('new account step4') ?></del></div>
  <div class="content"><del><?php echo lang('new account step4 info', get_url('project', 'add')) ?></del></div>
<?php } else { ?>
  <div class="header"><?php echo lang('new account step4') ?></div>
  <div class="content"><?php echo lang('new account step4 info', get_url('project', 'add')) ?></div>
<?php } // if?>
  
  <p><a class="internalLink" href="<?php echo get_url('company', 'hide_welcome_info') ?>"><?php echo lang('hide welcome info') ?></a></p>
  
</div>
<?php } // if ?>

<table style="width:100%">
<tr><td colspan=2>
<?php if(user_config_option('show calendar widget')) {?>
<div class="dashCalendar">
<table style="width:100%">
	<col width=12/><col /><col width=12/><tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('upcoming events milestones and tasks')?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2 colspan=2 ></td></tr>
	
		<tr><td colspan=2>
			<script type="text/javascript">

			function cancel (evt) {//cancel clic event bubbling. used to cancel opening a New Event window when clicking an object
			    var e=(evt)?evt:window.event;
			    if (window.event) {
			        e.cancelBubble=true;
			    } else {
			        e.stopPropagation();
			    }
			    return true;
			}
			
			var ob=true;

			function hide_tooltip(elem){
				jQuery(elem).parent().trigger('mouseout');
			}
			
			//disable showing the tooltip. 
			function disable_overlib(){
				ob = false;
			}
			jQuery.noConflict();//YUI redefines $, so we need to set jQuery to non-conflict mode	
			
		  	for (var i = 0; i <= 24; i++){
			  	jQuery('span.cluetip' + i).cluetip({		
				    splitTitle: '|', 
				    cluetipClass: 'color' + i + ' cluetip-event',
				    width: 'auto',
				    fx: {             
			              open:       'fadeIn', 
			              openSpeed:  ''
				    },
				    hoverIntent: {    
			              sensitivity:  3,
			              interval:     50,
			              timeout:      0
				    }, 
				    topOffset:        8,       
			    	leftOffset:       8,
			    	onActivate: function(e) {//to prevent keeping the tooltip after moving away from the page
					    return ob;
					  },
				    showTitle: false 
			  	});
		  	}
		</script>
  <?php
  
  $startday = date("d",mktime()) - (date("N", mktime()) %7);
  $endday = $startday +14;
  $currentday = date("j");
  $currentmonth = date("n");
  $currentyear = date("Y");
  
  $date_start = new DateTimeValue(mktime(0,0,0,$currentmonth,$startday,$currentyear)); 
  $date_end = new DateTimeValue(mktime(0,0,0,$currentmonth,$endday,$currentyear)); 
  $milestones = ProjectMilestones::getRangeMilestonesByUser($date_start,$date_end,logged_user(), $tags, active_project());
  $tasks = ProjectTasks::getRangeTasksByUser($date_start,$date_end,logged_user(), $tags, active_project());
	
 
	// load the day we are currently viewing in the calendar

	$output ='';
	if(cal_option("start_monday")) $firstday = (date("w", mktime(0,0,0,$currentmonth,1,$currentyear))-1) % 7;
	else $firstday = (date("w", mktime(0,0,0,$currentmonth,1,$currentyear))) % 7; // Numeric representation of day of week.
	$lastday = date("t", mktime(0,0,0,$currentmonth,1,$currentyear)); // # of days in the month
	
	$output .= "<table id=\"calendar\" border='0' style='width:100%;border-collapse:collapse' cellspacing='1' cellpadding='0'>\n";
	$day = date("d");
	$month = date("m");
	$year = date("Y");
	// Loop to render the calendar
	
	$can_add_event = !active_project() || ProjectEvent::canAdd(logged_user(),active_project());	
					$output .= "<tr>";
					
					if(!cal_option("start_monday")) {
						$output .= "    <th width='12.5%' align='center'>" .  lang('sunday short') . '</th>' . "\n";
					}
					$output .= '
					<th width="15%">' . lang('monday short') . '</th>
					<th width="15%">' . lang('tuesday short') . '</th>
					<th width="15%">' . lang('wednesday short') . '</th>
					<th width="15%">' . lang('thursday short') . '</th>
					<th width="15%">' . lang('friday short') . '</th>
					<th width="12.5%">' . lang('saturday short') . '</th>';
					
					if(cal_option("start_monday")) {
						$output .= '<th width="12.5%">' . lang('sunday short') . '</th>';
					}
					$output .= '</tr>';
	for ($week_index = 0;$week_index<1; $week_index++) {
		$output .= '  <tr>' . "\n";
		for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {
			$i = $week_index * 7 + $day_of_week;
			$day_of_month = $i + $startday;
			// see what type of day it is
			$today_text = "";	
			if($currentyear == $year && $currentmonth == $month && $currentday == $day_of_month){
				$daytitle = 'todaylink';
				$today_text = "Today ";
			}else $daytitle = 'daylink';
			
			// if weekends override do this
			if(cal_option("weekendoverride")){
				// set whether the date is in the past or future/present
				if($day_of_week==0 OR $day_of_week==6){
					$daytype = "weekend";
				}elseif($day_of_month <= $lastday AND $day_of_month >= 1){
					$daytype = "weekday";
				}else{
					$daytype = "weekday_future";
				}
			}else{
				if( !cal_option("start_monday") AND ($day_of_week==0 OR $day_of_week==6) AND $day_of_month <= $lastday AND $day_of_month >= 1){
					$daytype = "weekend";
				}elseif( cal_option("start_monday") AND ($day_of_week==5 OR $day_of_week==6) AND $day_of_month <= $lastday AND $day_of_month >= 1){
					$daytype = "weekend";
				}elseif($day_of_month <= $lastday AND $day_of_month >= 1){
					$daytype = "weekday";
				}else{
					$daytype = "weekday_future";
				}
			}
			// see what type of day it is
			if($currentyear == $year && $currentmonth == $month && $currentday == $day_of_month){
			  $daytitle = 'todaylink';
			  $daytype = "today";
			}elseif($day_of_month > $lastday OR $day_of_month < 1){
				$daytitle = 'extralink';
			}else $daytitle = 'daylink';
			// writes the cell info (color changes) and day of the month in the cell.
			$output .= "<td valign=\"top\" class=\"$daytype\" ";
			if($day_of_month <= $lastday AND $day_of_month >= 1){ 
				$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month&year=$year");
				$w = $day_of_month;
				$dtv = DateTimeValueLib::make(0,0,0,$month,$day_of_month,$year);
			}elseif($day_of_month < 1){
				$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month&year=$year");
				$w = "&nbsp;";
				$dtv = DateTimeValueLib::make(0,0,0,$month,$day_of_month,$year);  
			}else{
				if($day_of_month==$lastday+1){
					$month++;
					if($month==13){
						$month = 1;
						$year++;
					}
				}
				$p = cal_getlink("index.php?action=viewdate&day=".($day_of_month-$lastday)."&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=".($day_of_month-$lastday)."&month=$month&year=$year");
				$w = $day_of_month - $lastday;
				$dtv = DateTimeValueLib::make(0,0,0,$month,$w,$year);
			}
			$output .= "><div style='z-index:0; height:100%;cursor:pointer' onclick=\"og.EventPopUp.show(null, {day:'{$dtv->getDay()}',	month:'{$dtv->getMonth()}',year:'{$dtv->getYear()}',type_id:1,hour:'0',minute:'0',title:'".date("l, F j",  mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear()))."'},'');\") >
			<div class='$daytitle' style='text-align:right'>";
			if($day_of_month >= 1){
				$output .= "<a class='internalLink' href=\"$p\" onclick=\"cancel(event);return true;\"  style='color:#5B5B5B' >$w</a>";				
				// only display this link if the user has permission to add an event
				if(!active_project() || ProjectEvent::canAdd(logged_user(),active_project())){
					// if single digit, add a zero
					$dom = $day_of_month;
					if($dom < 10) $dom = "0".$dom;
					// make sure user is allowed to edit the past
						
				}
				
			}else $output .= "&nbsp;";
			$output .= "</div>";
			// This loop writes the events for the day in the cell
			if (is_numeric($w)){ //if it is a day after the first of the month
				$day_tmp = is_numeric($w) ? $w : 0;
				$date = new DateTimeValue(mktime(0,0,0,$month,$day_tmp,$year)); 
				$result = ProjectEvents::getDayProjectEvents($date, $tags, active_project()); 
				if(!$result)
					$result = array();
				if($milestones)
					$result = array_merge($result,$milestones );
					
					
				if($tasks)
					$result = array_merge($result,$tasks );
				
				if(count($result)<1) $output .= "&nbsp;";
				else{
					$count=0;
					foreach($result as $event){
						$color = "000000"; // default color
						if($event instanceof ProjectEvent ){
							$count++;
							$subject =   $event->getSubject();
							$typeofevent = $event->getTypeId(); 
							$private = $event->getIsPrivate(); 
							$eventid = $event->getId(); 
						
							$color = $event->getEventTypeObject()?$event->getEventTypeObject()->getTypeColor():''; 
							// organize the time and duraton data
							$overlib_time = lang('CAL_UNKNOWN_TIME');
							switch($typeofevent) {
								case 1:
									if(!cal_option("hours_24")) $timeformat = 'g:i A';
									else $timeformat = 'G:i';
									$event_time = date($timeformat, $event->getStart()->getTimestamp()); 
									$overlib_time = "@ $event_time";
									break;
								case 2:
									$event_time = lang('CAL_FULL_DAY') ;
									$overlib_time = lang('CAL_FULL_DAY');
									break;
								case 3:
									$event_time = '??:??';
									$overlib_time = lang('CAL_UNKNOWN_TIME');
									break;
								default: ;
							} 
							
							// build overlib text
							$overlib_text = "<strong>$overlib_time</strong><br>" . truncate($event->getDescription(),195);
							// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
							if(!$private && $count <= 3){
								if($event->getEventTypeObject() && $event->getEventTypeObject()->getTypeColor()=="") $output .= '<div class="event_block">';
								else $output .= "<div class='event_block'   style='z-index:1000;border-left-color: #$color;'>";
								if($subject=="") $subject = "[".lang('CAL_NO_SUBJECT')."]";
								$output .= "<span class='cluetip" . $event->getProject()->getColor() . "' title='".$subject."- <i>Event</i>|".str_replace("'","\\'",$overlib_text)."' >";			
								$output .="<img src=" . image_url('/16x16/calendar.png') . " align='absmiddle'>";
								$output .= "<a style='vertical-align:bottom;' href='".cal_getlink("index.php?action=viewevent&amp;id=".$event->getId())."' class='internalLink' onclick=\"hide_tooltip(this);cancel(event); disable_overlib();\" >".$subject."</a>";
								$output .= '</span>';
								$output .= "</div>";
							}
						} elseif($event instanceof ProjectMilestone ){
							$milestone=$event;
							$due_date=$milestone->getDueDate();
							if (mktime(0,0,0,$month,$day_tmp,$year) == mktime(0,0,0,$due_date->getMonth(),$due_date->getDay(),$due_date->getYear())) {	
								$count++;
								if ($count<=3){
									$overlib_text = truncate($milestone->getDescription(),195)."<br>";
									
									if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { 
										$overlib_text .= 'Assigned to:'. clean($milestone->getAssignedTo()->getObjectName());
									} else $overlib_text .= 'Assigned to: None';
									
									$subject = "&nbsp;". $milestone->getName()." - <i>Milestone</i>";
									$cal_text = $milestone->getName();
									$output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
									$output .= "<span class='cluetip" . $milestone->getProject()->getColor() . "' title='".$subject."|".str_replace("'","\\'",$overlib_text)."' >";
									$output .= "<img src=" . image_url('/16x16/milestone.png') . " align='absmiddle'>";
									$output .= "<a style='vertical-align:bottom;' href='".$milestone->getViewUrl()."' class='internalLink' onclick=\"hide_tooltip(this);cancel(event);disable_overlib();return true;\" >".$cal_text."</a>";
									$output .= '</span>';
									$output .= "</div>";
								}//if count
							}
							
						}//endif milestone
						elseif($event instanceof ProjectTask){
							$task=$event;
							$start_date=$task->getStartDate();
							$due_date=$task->getDueDate();
							$now = mktime(0,0,0,$month,$day_tmp,$year);
							if ($now == mktime(0,0,0,$due_date->getMonth(),$due_date->getDay(),$due_date->getYear())) {	
								$count++;
								if ($count<=3){
									$overlib_text = "&nbsp;".truncate($task->getText(),195,'','UTF-8',true,true)."<br>";
									if ($task->getAssignedTo() instanceof ApplicationDataObject) { 
										$overlib_text .= 'Assigned to:'. clean($task->getAssignedTo()->getObjectName());
									} else $overlib_text .= 'Assigned to: None';
									
									$subject = $task->getTitle().'- <i>Task</i>';
									$cal_text = $task->getTitle();
									
									$output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
									$output .= "<span class='cluetip" . $task->getProject()->getColor() . "' title='".$subject."|".str_replace("'","\\'",$overlib_text)."' >";
									$output .= "<img src=" . image_url('/16x16/tasks.png') . " align='absmiddle'>";
									$output .= "<a style='vertical-align:bottom;' href='".$task->getViewUrl()."' class='internalLink' onclick=\"hide_tooltip(this);cancel(event);disable_overlib();return true;\" >".$cal_text."</a>";
									$output .= '</span>';
									$output .= "";
								}//if count
							}
						}//endif task
					} // end foreach event writing loop
					if ($count > 3) {
						$output .= '<div style="witdh:100%;text-align:center;font-size:9px" ><a href="'.$p.'" class="internalLink"  onclick="cancel(event);nd();disable_overlib();return true;">+'.($count-3).' more</a></div>';
					}
				}
				
				$output .= '</div></td>';
			} //if is_numeric($w) 
		} // end weekly loop
		$output .= "\n  </tr>\n";
		// If it's the last day, we're done
		if($day_of_month >= $lastday+7) {
			break;
		}
	} // end main loop
echo $output . '</table>';
  ?>
  		</td></tr>
		<tr><td class="coViewBottomLeft" style="width:3%"></td>
		<td class="coViewBottom" style="width:96%"></td>
		<td class="coViewBottomRight" style="width:3%"></td></tr>
	</table>
<?php } //if(user_config_option('show calendar')) ?>
</div>
 
 </td></tr>
<tr><td>



<?php if (isset($tasks_in_progress) && $tasks_in_progress) { ?>
<div class="dashTasksInProgress">
<table style="width:100%"><tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('tasks in progress') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td style="background:white"></td><td class="coViewBody" style="padding-left:0px;">
		<table id="dashTableTIP" style="width:100%">
		<?php
		$c = 0;
		foreach ($tasks_in_progress as $task){
			$stCount = $task->countAllSubTasks();
			$c++;
			$text = $task->getText();
			if ($text != '')
				$text = ": " . $text;
			if(strlen($text)>100)
				$text = substr($text,0,100) . " ...";
			?>
				<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'?>"><td class="db-ico ico-task"></td><td style="padding-left:5px;padding-bottom:2px">
			<?php $dws = $task->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
			$projectLinks = array();
			foreach ($dws as $ws) {
				$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
			}
			echo implode('&nbsp;',$projectLinks);?>
			<a class='internalLink' href='<?php echo $task->getViewUrl() ?>'><?php echo clean($task->getTitle())?><?php echo clean($text) ?></a></td>
			<td align="right"><?php $timeslot = Timeslots::getOpenTimeslotByObjectAndUser($task,logged_user());
				if ($timeslot) { ?>
					<div id="<?php echo $genid . $task->getId() ?>timespan"></div>
					<script language="JavaScript">
					og.startClock('<?php echo $genid . $task->getId() ?>', <?php echo $timeslot->getSeconds() ?>);
					</script>
				<?php } ?>
				</td>
			</tr>
		<?php } // foreach ?>
		</table>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } ?>


<?php 
	if($hasToday || $hasLate) { 
?>
<div class="dashLate">
<table style="width:100%">
	<tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('late milestones and tasks') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td style="background:white"></td><td class="coViewBody" style="padding-left:0px;">
		
<?php if($hasLate) { 
	$c = 0;
	?>
<div>
  <table style="width:100%">
<?php
	if (isset($late_milestones) && is_array($late_milestones) && count($late_milestones))
	foreach($late_milestones as $milestone) { 
	$c++;
	?>
    <tr class="<?php echo $c % 2 == 1? '':'dashAltRow' ?>"><td class="db-ico ico-milestone"></td>
    <td style="padding-left:5px;padding-bottom:2px">
    <?php $dws = $milestone->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
		$projectLinks = array();
		foreach ($dws as $ws) {
			$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
		}
		echo implode('&nbsp;',$projectLinks);?>
    <a class="internalLink" href="<?php echo $milestone->getViewUrl() ?>">
<?php if($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <span style="font-weight:bold"> <?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>: </span><?php echo clean($milestone->getName()) ?>
<?php } else { ?>
    <?php echo clean($milestone->getName()) ?>
<?php } // if ?>
	</a></td>
    <td style="text-align:right"><?php echo lang('days late', $milestone->getLateInDays()) ?></td>
	</tr>
<?php } // foreach ?>
<?php
	if (isset($late_tasks) && is_array($late_tasks) && count($late_tasks))
	foreach($late_tasks as $task) { 
	$c++;
	?>
    <tr class="<?php echo $c % 2 == 1? '':'dashAltRow' ?>"><td class="db-ico ico-task"></td>
    <td style="padding-left:5px;padding-bottom:2px">
    <?php 
		$dws = $task->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
		$projectLinks = array();
		foreach ($dws as $ws) {
			$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
		}
		echo implode('&nbsp;',$projectLinks);?>
	<a class="internalLink" href="<?php echo $task->getViewUrl() ?>">
<?php if($task->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <span style="font-weight:bold"> <?php echo clean($task->getAssignedTo()->getObjectName()) ?>: </span><?php echo clean($task->getTitle()) ?>
<?php } else { ?>
    <?php echo clean($task->getTitle()) ?>
<?php } // if ?>
	</a></td>
    <td style="text-align:right"><?php echo lang('days late', $task->getLateInDays()) ?></td>
	</tr>
<?php } // foreach ?>
  </table></div>
<?php } // if ?>

<?php if($hasToday) { 
	$c = 1; ?>
  <div class="dashSubtitle" style="<?php echo $hasLate ? '': 'padding-top:0px' ?>"><?php echo lang('today') ?></div>
  <div>
  <table style="width:100%">
<?php 
	if (isset($today_milestones) && is_array($today_milestones) && count($today_milestones))
	foreach($today_milestones as $milestone) { 
	$c++;?>
    <tr class="<?php echo $c % 2 == 1? '':'dashAltRow' ?>"><td class="db-ico ico-milestone"></td>
    <td style="padding-left:5px;padding-bottom:2px">
    <?php 
		$dws = $milestone->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
		$projectLinks = array();
		foreach ($dws as $ws) {
			$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
		}
		echo implode(' ',$projectLinks);?>
    <a class="internalLink" href="<?php echo $milestone->getViewUrl() ?>">
<?php if($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <span style="font-weight:bold"> <?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>: </span><?php echo clean($milestone->getName()) ?>
<?php } else { ?>
    <?php echo clean($milestone->getName()) ?>
<?php } // if ?>
	</a></td></tr>
<?php } // foreach ?>
<?php 
	if (isset($today_tasks) && is_array($today_tasks) && count($today_tasks))
	foreach($today_tasks as $task) { 
	$c++;?>
    <tr class="<?php echo $c % 2 == 1? '':'dashAltRow' ?>"><td class="db-ico ico-task"></td>
    <td style="padding-left:5px;padding-bottom:2px">
    <?php 
		$dws = $task->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
		$projectLinks = array();
		foreach ($dws as $ws) {
			$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
		}
		echo implode('&nbsp;',$projectLinks);?>
	<a class="internalLink" href="<?php echo $task->getViewUrl() ?>">
<?php if($task->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <span style="font-weight:bold"> <?php echo clean($task->getAssignedTo()->getObjectName()) ?>: </span><?php echo clean($task->getTitle()) ?>
<?php } else { ?>
    <?php echo clean($task->getTitle()) ?>
<?php } // if ?>
	</a></td></tr>
<?php } // foreach ?>
  </table></div>
<?php } // if ?>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } // if ?>
 
 
<?php if ($hasPendingTasks) { ?>
<div class="dashPendingTasks">
<table style="width:100%"><tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('pending tasks') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td style="background:white"></td><td class="coViewBody" style="padding-left:0px;">
		<table id="dashTablePT" style="width:100%">
		<?php
		$c = 0;
		foreach ($dashtasks as $task){
			$stCount = $task->countAllSubTasks();
			$c++;
			$text = $task->getText();
			if ($text != '')
				$text = ": " . $text;
			if(strlen($text)>100)
				$text = substr($text,0,100) . " ...";
			?>
				<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMTC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
				<td class="db-ico ico-task<?php echo $task->getPriority() == 300? '-high-priority' : ($task->getPriority() == 100? '-low-priority' : '') ?>"></td><td style="padding-left:5px;padding-bottom:2px">
			<?php 
			$dws = $task->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
			$projectLinks = array();
			foreach ($dws as $ws) {
				$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
			}
			echo implode('&nbsp;',$projectLinks);?>
			<a class="internalLink" href="<?php echo $task->getViewUrl() ?>">
			<?php if($task->getAssignedTo() instanceof ApplicationDataObject) { ?>
			    <span style="font-weight:bold"> <?php echo clean($task->getAssignedTo()->getObjectName()) ?>: </span><?php echo clean($task->getTitle()) ?>
			<?php } else { ?>
			    <?php echo clean($task->getTitle()) ?>
			<?php } // if ?>
			</a></td>
			<td><?php if ($stCount > 0) echo "(" . lang('subtask count all open', $stCount, $task->countOpenSubTasks()) . ')'?></td>
			<td><?php if (!is_null($task->getDueDate())){
				if ($task->getRemainingDays() >= 0)
					if ($task->getRemainingDays() == 0)
						echo lang('due today');
					else
						echo lang('due in x days', $task->getRemainingDays());
				else
					echo lang('overdue by x days', -$task->getRemainingDays());
				}?></td>
			<td style="text-align:right"><a class='internalLink' href='<?php echo $task->getCompleteUrl() ?>' title="<?php echo lang('complete task')?>"><?php echo lang('complete task')?></a></td>
			</tr>
		<?php } // foreach ?>
		</table>
		<?php if ($c > 5) { ?>
		<div id="dashSMTT" style="width:100%; text-align:right">
			<a href="#" onclick="og.hideAndShowByClass('dashSMTT', 'dashSMTC', 'dashTablePT'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
		</div>
		<?php } //if ?>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } ?>

</td>
<?php if ($hasMessages || $hasDocuments || $hasCharts || $hasUnreadEmails){ ?>
<td style="width:<?php echo ($hasPendingTasks || $hasLate || $hasToday)? '330px' : '100%' ?>">

<?php if ($hasUnreadEmails) { ?>
<div class="dashUnreadEmails">
<table style="width:100%">
	<col width=12/><col width=85%/><col width=12/><tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('unread emails') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td class="coViewBody" colspan=2>
		<table id="dashTableEmails" style="width:100%">
		<?php $c = 0;
			foreach ($unread_emails as $email){ 
				if (!$email->getIsDeleted()) {
					$c++;?>
					<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMUC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
					<td class="db-ico ico-email"></td>
					<td style="padding-left:5px">
					<?php 
						/*$mws = $email->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
						$projectLinks = array();
						foreach ($mws as $ws) {
							$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
						}
						echo implode('&nbsp;',$projectLinks);  //Commented as unread emails are not yet assignable to workspaces*/?>
					<a class="internalLink" style="font-weight:bold" href="<?php echo get_url('mail','view', array('id' => $email->getId()))?>"
						title="">
					<?php echo clean($email->getSubject()) ?>
					</a><br/><table width="100%" style="color:#888"><tr><td><?php echo clean($email->getFrom())?></td><td align=right><?php echo $email->getSentDate()->isToday() ? format_time($email->getSentDate()) : format_date($email->getSentDate())?></td></tr></table></td></tr>
			<?php } // if?>
		<?php } // foreach?>
			<?php if ($c >= 10) {?>
				<tr class="dashSMUC" style="display:none"><td></td>
				<td style="text-align:right"><a href="#" onclick="Ext.getCmp('tabs-panel').activate('messages-panel');"><?php echo lang('show all') ?>...</a>
				</td></tr>
			<?php } ?>
		</table>
		<?php if ($c > 5) { ?>
		<div id="dashSMUT" style="width:100%;text-align:right">
			<a href="#" onclick="og.hideAndShowByClass('dashSMUT', 'dashSMUC', 'dashTableEmails'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
		</div>
		<?php } // if ?>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom" style="width:90%"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } ?>

<?php if ($hasMessages) { ?>
<div class="dashMessages">
<table style="width:100%">
	<col width=12/><col /><col width=12/><tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('messages') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td class="coViewBody" colspan=2>
		<table id="dashTableMessages" style="width:100%">
		<?php $c = 0;
			foreach ($messages as $message){ $c++;?>
			<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMMC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
			<td class="db-ico ico-message"></td>
			<td style="padding-left:5px">
			<?php 
				$mws = $message->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
				$projectLinks = array();
				foreach ($mws as $ws) {
					$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
				}
				echo implode('&nbsp;',$projectLinks);?>
			<a class="internalLink" href="<?php echo get_url('message','view', array('id' => $message->getId()))?>"
				title="<?php echo lang('message posted on by linktitle', format_datetime($message->getCreatedOn()), $message->getCreatedByDisplayName()) ?>">
			<?php echo clean($message->getTitle()) ?>
			</a></td></tr>
		<?php } // foreach?>
			<?php if ($c >= 10) {?>
				<tr class="dashSMMC" style="display:none"><td></td>
				<td style="text-align:right"><a href="#" onclick="Ext.getCmp('tabs-panel').activate('messages-panel');"><?php echo lang('show all') ?>...</a>
				</td></tr>
			<?php } ?>
		</table>
		<?php if ($c > 5) { ?>
		<div id="dashSMMT" style="width:100%;text-align:right">
			<a href="#" onclick="og.hideAndShowByClass('dashSMMT', 'dashSMMC', 'dashTableMessages'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
		</div>
		<?php } // if ?>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom" style="width:90%"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } ?>


<?php if ($hasCharts) {
	$pcf = new ProjectChartFactory();?>
	
<div class="dashChart">
<table style="width:100%">
	<col width=12/><col/><col width=12/>
	<tr><td style="height:1px;width:12px;"></td><td style="height:1px;width:216px;"></td><td></td></tr>
	<tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('charts') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td class="coViewBody" colspan=2>
<?php
	$c = 1;
	foreach ($charts as $chart) {
?>
		<div style="padding-bottom:10px; margin-bottom:10px;<?php echo $c != count($charts)? 'border-bottom:1px solid #DDDDDD':'' ?>">
		<div style="font-size:120%;font-weight:bold"><?php echo clean($chart->getTitle()) ?></div>
		<?php 
		$chart2 = $pcf->loadChart($chart->getId());
		$chart2->ExecuteQuery();
		echo $chart2->DashboardDraw();
		echo $chart2->PrintInfo();
		$c++;
		 ?>
		 </div>
<?php } // foreach ?>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } // if ?>

<?php if ($hasDocuments) { ?>
<div class="dashDocuments">
<table style="width:100%">
	<col width=12/><col/><col width=12/><tr>
	<td colspan=2 rowspan=2 class="dashHeader"><div class="dashTitle"><?php echo lang('documents') ?></div></td>
	<td class="coViewTopRight"></td></tr>
	<tr><td class="coViewRight" rowspan=2></td></tr>
	
		<tr><td class="coViewBody" colspan=2>
		<table id="dashTableDocuments" style="width:100%">
		<?php $c = 0;
			foreach ($documents as $document){ $c++;?>
			<tr class="<?php echo $c % 2 == 1? '':'dashAltRow'; echo ' ' . ($c > 5? 'dashSMDC':''); ?>" style="<?php echo $c > 5? 'display:none':'' ?>">
			<td class="db-ico ico-unknown ico-<?php echo str_replace("/", "-", $document->getTypeString())?>"></td>
			<td style="padding-left:5px">
			<?php 
				$dws = $document->getWorkspaces(logged_user()->getActiveProjectIdsCSV());
				$projectLinks = array();
				foreach ($dws as $ws) {
					$projectLinks[] = '<span class="project-replace">' . $ws->getId() . '</span>';
				}
				echo '<div style="padding-right:10px;display:inline">' . implode('&nbsp;',$projectLinks) . '</div>';?>
			<a class="internalLink" href="<?php echo get_url('files','file_details', array('id' => $document->getId()))?>"
				title="<?php echo lang('message posted on by linktitle', format_datetime($document->getCreatedOn()), $document->getCreatedByDisplayName()) ?>">
			<?php echo clean($document->getFilename())?>
			</a></td>
			<td style="text-align:right">
			<?php if ($document->isModifiable() && $document->canEdit(logged_user())){ ?>
				<a class="internalLink"  href="<?php echo $document->getModifyUrl()?>"><?php echo lang('edit') ?></a>
			<?php } ?></td></tr>
		<?php } // foreach ?>
			<?php if ($c >= 10) {?>
				<tr class="dashSMDC" style="display:none"><td></td>
				<td style="text-align:right"><a href="#" onclick="Ext.getCmp('tabs-panel').activate('documents-panel');"><?php echo lang('show all') ?>...</a>
				</td></tr>
			<?php } ?>
		</table>
		<?php if ($c > 5) { ?>
		<div id="dashSMDT" style="width:100%; text-align:right">
			<a href="#" onclick="og.hideAndShowByClass('dashSMDT', 'dashSMDC', 'dashTableDocuments'); return false;"><?php echo lang("show more amount", $c -5) ?>...</a>
		</div>
		<?php } // if ?>
		</td></tr>

		<tr><td class="coViewBottomLeft"></td>
		<td class="coViewBottom" style="width:90%"></td>
		<td class="coViewBottomRight"></td></tr>
	</table>
</div>
<?php } ?>


</td>
<?php } ?></tr></table>
</div>
</div>
<script type="text/javascript">
og.showWsPaths('<?php echo $genid ?>-db');
</script>