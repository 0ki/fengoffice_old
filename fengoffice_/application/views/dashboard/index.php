<?php 
  set_page_title(lang('dashboard'));
  
  if(Project::canAdd(logged_user())) {
    add_page_action(lang('add project'), get_url('project', 'add'), 'ico-add');
  } // if
  

?>
<?php if(logged_user()->isMemberOfOwnerCompany() && !owner_company()->getHideWelcomeInfo()) { ?>
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

<?php if((isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) || (isset($late_milestones) && is_array($late_milestones) && count($late_milestones))) { ?>
<div id="lateOrTodayMilestones" class="important">
<?php if(isset($late_milestones) && is_array($late_milestones) && count($late_milestones)) { ?>
  <div class="header"><?php echo lang('late milestones') ?></div>
  <ul>
<?php foreach($late_milestones as $milestone) { ?>
<?php if($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>: <a class="internalLink" href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a class="internalLink" href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a> (<?php echo lang('days late', $milestone->getLateInDays()) ?>)</li>
<?php } else { ?>
    <li><a class="internalLink" href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a class="internalLink" href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a> (<?php echo lang('days late', $milestone->getLateInDays()) ?>)</li>
<?php } // if ?>
<?php } // foreach ?>
  </ul>
<?php } // if ?>

<?php if(isset($today_milestones) && is_array($today_milestones) && count($today_milestones)) { ?>
  <div class="header"><?php echo lang('today') ?></div>
  <ul>
<?php foreach($today_milestones as $milestone) { ?>
<?php if($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
    <li><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>: <a class="internalLink" href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a class="internalLink" href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a></li>
<?php } else { ?>
    <li><a class="internalLink" href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a> <?php echo strtolower(lang('in')) ?> <a class="internalLink" href="<?php echo $milestone->getProject()->getOverviewUrl() ?>"><?php echo clean($milestone->getProject()->getName()) ?></a></li>
<?php } // if ?>
<?php } // foreach ?>
  </ul>
<?php } // if ?>
</div>
<?php } // if ?>
<br>

<b>Upcoming events, milestones and tasks</b><br>
<br>

  <?php
  $startday =date("d",mktime());
  $endday =date("d",mktime()) +14;
  $currentday = date("j");
	$currentmonth = date("n");
	$currentyear = date("Y");
	// load the day we are currently viewing in the calendar
	$cday = $_SESSION['cal_day'];
	$cmonth = $_SESSION['cal_month'];
	$cyear = $_SESSION['cal_year'];
	$output ='';
	$tags = active_tag();
	if(cal_option("start_monday")) $firstday = (date("w", mktime(0,0,0,$cmonth,1,$cyear))-1) % 7;
	else $firstday = (date("w", mktime(0,0,0,$cmonth,1,$cyear))) % 7; // Numeric representation of day of week.
	$lastday = date("t", mktime(0,0,0,$cmonth,1,$cyear)); // # of days in the month
	
	
	$output .= "<table id=\"calendar\" border='0' cellspacing='1' cellpadding='0'>
	<colgroup span=\"7\" width=\"1*\">
	<tr>\n";
	$day = date("d");
	$month = date("m");
	$year = date("Y");
	// Loop to render the calendar
	for ($week_index = 0;$week_index < 2; $week_index++) {
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
			if($day_of_month <= $lastday AND $day_of_month >= 1){ 
				$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month&year=$year");
				$w = $today_text . $day_of_month;				
				$current_day = date("w",mktime(0,0,0,$month,$day_of_month,$year));
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
				$w = $day_of_month - $lastday . ' / ' . $month;
				$current_day = date("w",mktime(0,0,0,$month,$day_of_month-$lastday,$year));
			}
			if($current_day ==0 OR $current_day ==6){
				$daytype = "weekend";
			}else{
				$daytype = "weekday";
			}
			// writes the cell info (color changes) and day of the month in the cell.
			$output .= "<td valign=\"top\" class=\"$daytype\"";
			$output .= "><div class='$daytitle'>";
			if($day_of_month >= 1){
				$output .= "<a class='internalLink' href=\"$p\">$w</a>";				
				// only display this link if the user has permission to add an event
				if(!active_project() || ProjectEvent::canAdd(logged_user(),active_project())){
					// if single digit, add a zero
					$dom = $day_of_month;
					if($dom < 10) $dom = "0".$dom;
					// make sure user is allowed to edit the past
						$output .= "<a  class='internalLink' href=\"$t\">+</a>";
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
				$milestones = ProjectMilestones::getDayMilestonesByUser($date,logged_user());
				if($milestones)
					$result = array_merge($result,$milestones );
				$tasks = ProjectTasks::getDayTasksByUser($date,logged_user());
				if($tasks)
					$result = array_merge($result,$tasks );
				if(count($result)<1) $output .= "&nbsp;";
				else
				foreach ($result as $event){ 
					if($event instanceof ProjectEvent ){
						$subject = $event->getSubject();
						$typeofevent = $event->getTypeId(); 
						$private = $event->getIsPrivate(); 
						$eventid = $event->getId(); 
						$desc = $event->getDescription(); 
						$overlib = "<strong>$subject</strong> - <i>Event</i><br>$desc";
						$event_type_obj = $event->getEventTypeObject();
						$color = $event_type_obj?$event_type_obj->getTypeColor():''; 
						$start_stamp =$event->getStart()->getTimestamp();
						if($color=="") $color = "AAEE00";
						// organize the time and duraton data
						$overlib_time = CAL_UNKNOWN_TIME;
						switch($typeofevent) {
							case 1:
								if(!cal_option("hours_24")) $timeformat = 'g:i A';
								else $timeformat = 'G:i';
								$event_time = date($timeformat, $start_stamp); 
								$overlib_time = "<br>@ $event_time";
								break;
							case 2:
								$event_time = CAL_FULL_DAY;
								$overlib_time = "<br>" . CAL_FULL_DAY;
								break;
							case 3:
								$event_time = '??:??';
								$overlib_time = '';
								break;
							default: ;
						} 
						// build overlib text
						$overlib = "<strong>$subject - <i>Event</i>$overlib_time</strong><br>" . $desc;
						// see if event type color is dark.  If it is, make text white in overlib box.
						$c1 = $color[0];
						$c2 = $color[2];
						$c3 = $color[4];
						if(!is_numeric($c1)) $c1 = 10;
						if(!is_numeric($c2)) $c2 = 10;
						if(!is_numeric($c3)) $c3 = 10;
						if($c1<4 AND $c2<9 AND $c3<9) $overlibtext = "#FFFFFF";
						elseif($c2<4 AND $c1<9 AND $c3<9) $overlibtext = "#FFFFFF";
						elseif($c3<4 AND $c1<9 AND $c2<9) $overlibtext = "#FFFFFF";
						else $overlibtext = "#000000";
						// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
						if(!$private || !cal_anon()){
							if($event_type_obj && $color=="") $output .= '<div class="event_block">';
							else $output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
							if($subject=="") $subject = "[".CAL_NO_SUBJECT."]";
							$output .= '<span onmouseover="return overlib(\''.str_replace("'","\\'",$overlib).'\',FGCOLOR,\'#'.$color.'\',BGCOLOR,\'#000000\',TEXTCOLOR,\''.$overlibtext.'\');" onmouseout="return nd();">';
							$output .= "<img src=" . image_url('/16x16/calendar.png') . "> ";
							if(cal_option("show_times")) $output .= "$event_time - $subject";
							else $output .= "$subject";
							$output .= '</span>';
							$output .= "</div>";
						}
					} // end if event
					elseif($event instanceof ProjectMilestone ){
						$milestone=$event;
						$overlib = "<strong>".$milestone->getName()."</strong> - <i>Milestone</i><br>" . $milestone->getDescription();
						$color = 'FF0000'; 
						$subject = $milestone->getName();
						// build overlib text
						// see if event type color is dark.  If it is, make text white in overlib box.
						$c1 = $color[0];
						$c2 = $color[2];
						$c3 = $color[4];
						if(!is_numeric($c1)) $c1 = 10;
						if(!is_numeric($c2)) $c2 = 10;
						if(!is_numeric($c3)) $c3 = 10;
						if($c1<4 AND $c2<9 AND $c3<9) $overlibtext = "#FFFFFF";
						elseif($c2<4 AND $c1<9 AND $c3<9) $overlibtext = "#FFFFFF";
						elseif($c3<4 AND $c1<9 AND $c2<9) $overlibtext = "#FFFFFF";
						else $overlibtext = "#000000";
						// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
						if($color == "") $output .= '<div class="event_block">';
						else $output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
						$output .= '<span onmouseover="return overlib(\''.str_replace("'","\\'",$overlib).'\',FGCOLOR,\'#'.$color.'\',BGCOLOR,\'#000000\',TEXTCOLOR,\''.$overlibtext.'\');" onmouseout="return nd();">';
						$output .= "<img src=" . image_url('/16x16/milestone.png') . ">$subject";
						$output .= '</span>';
						$output .= "</div>";
					}//endif milestone
					elseif($event instanceof ProjectTask){
						$task=$event;
						$overlib = "<strong>".$task->getTitle()."</strong> - <i>Task</i><br>" . $task->getText();
						$color = '0000FF'; 
						$subject = $task->getTitle();
						// build overlib text
						// see if event type color is dark.  If it is, make text white in overlib box.
						$c1 = $color[0];
						$c2 = $color[2];
						$c3 = $color[4];
						if(!is_numeric($c1)) $c1 = 10;
						if(!is_numeric($c2)) $c2 = 10;
						if(!is_numeric($c3)) $c3 = 10;
						if($c1<4 AND $c2<9 AND $c3<9) $overlibtext = "#FFFFFF";
						elseif($c2<4 AND $c1<9 AND $c3<9) $overlibtext = "#FFFFFF";
						elseif($c3<4 AND $c1<9 AND $c2<9) $overlibtext = "#FFFFFF";
						else $overlibtext = "#000000";
						// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
						if($color == "") $output .= '<div class="event_block">';
						else $output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
						$output .= '<span onmouseover="return overlib(\''.str_replace("'","\\'",$overlib).'\',FGCOLOR,\'#'.$color.'\',BGCOLOR,\'#000000\',TEXTCOLOR,\''.$overlibtext.'\');" onmouseout="return nd();">';
						$output .= "<img src=" . image_url('/16x16/tasks.png') . ">$subject";
						$output .= '</span>';
						$output .= "</div>";
					}//endif task
				} // end foreach event writing loop
				$output .= '</td>';
			} //if is_numeric($w) 
		} // end weekly loop
		$output .= "\n  </tr>\n";
		// If it's the last day, we're done
		if($day_of_month >= $endday) {
			break;
		}
	} // end main loop
echo $output;
  ?>
 </table>
 <br>
<b>Pending tasks</b><br>

<br>

<?php
$tasks = ProjectTasks::getUndatedTaskListsForTwoWeeks();
$i=false;
foreach ($tasks as $task){
	$i=!$i;
	if($i)	echo "<div style='background-color:#CCCCFF;'>";
	$text = $task->getText();
	if(strlen($text)>100)
		$text = substr($text,0,100) . " ...";
	echo "<a class='internalLink' href='".$task->getEditUrl()."'><b>".$task->getTitle() . "</b> : " . $text . "</a><br>";
	if($i) echo "</div>";
}

//echo "<img src=" . image_url("/16x16/milestone.png") . ">"
?>