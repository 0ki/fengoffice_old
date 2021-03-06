<?php
/*
	
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

//echo cal_calendar(,$_SESSION['cal_month'],$_SESSION['cal_day']);
$year=$_SESSION['cal_year'];
$month=$_SESSION['cal_month'];
$day=$_SESSION['cal_day'];




/* ##################################################################
  navbar()
   This function writes the navigator bar for the calendar
   this navbar is used only for the calendar page, so we keep in in this file.
###################################################################*/
function cal_navbar($year, $month, $day, $tags){
  $today = "year=".date("Y")."&month=".date("m")."&day=".date('d');
  $output = "";
  $output .= "<table cellpadding='4' cellspacing='0' width='90%' align='center' style='margin-top:5px; margin-bottom:5px'>
  				<tr><td alight='left' style='padding-left: 10px;'>";
  $output .= "<span class='month_title'>".cal_month_name($month)." $year</span>";
  $output .= "</td><td align='right' style='padding-right: 15px;'>";
//  $output .= '<input type="button" value="'.CAL_MENU_TODAY.'" class="formButtons" onClick="og.openLink(\'' . cal_getlink('index.php?'.$today) . '\')"> ';
  $output .= '<select name="calendar_month" class="formElements" id="calendar_month"> ';
  for($mm = 1; $mm<=12; $mm++){
  	if($mm==$month) $output .= "<option value='$mm' selected>".cal_month_name($mm)."</option>";
	else $output .= "<option value='$mm'>".cal_month_name($mm)."</option>";
  }
  $output .= '</select>';
  $output .= '<select name="calendar_year" class="formElements" id="calendar_year">';
  for($yy = $year-10; $yy<$year+10; $yy++){
  	if($yy==$year) $output .= "<option selected>$yy</option>";
	else $output .= "<option value='$yy'>$yy</option>";
  }
  // calculate next month/year and previous month/year.
  $output .= '</select> ';
  $output .= '<input type="button" class="formButtons" style="width: 60px" value="'.CAL_MENU_GO.'" onClick="disable_overlib();var mo = document.getElementById(\'calendar_month\'); var m = mo.options[mo.selectedIndex].value; var yo = document.getElementById(\'calendar_year\'); var y = yo.options[yo.selectedIndex].value; og.openLink( \'index.php?a=index&c=event&month=\'+m+\'&year=\'+y);"> ';
  $pm = $month - 1;
  $py = $year;
  if($pm==0){
  	$pm = 12;
	$py--;
  }
  $nm = $month + 1;
  $ny = $year;
  if($nm==13){
  	$nm = 1;
	$ny++;
  }
 if(!active_project() || ProjectEvent::canAdd(logged_user(),active_project())) {
	 add_page_action(lang('add event'), get_url('event','add',
	 		array("year"=> date("Y"),
	 			 "month" => date("m"),
	 			 "day" => date('d')
	 			 )
	 		), 'ico-event'
	 );// cal_getlink('index.php?'.$today) );
 }
 add_page_action(lang('today'), get_url('event','index',
 		array("year"=> date("Y"),
 			 "month" => date("m"),
 			 "day" => date('d')
 			 )
 		), 'ico-today'
 );// cal_getlink('index.php?'.$today) );
 add_page_action(lang('previous month'), get_url('event','index',
 		array("year"=> $py,
 			 "month" => $pm
 			 )
 		), 'ico-prevmonth'
 );// add_page_action(lang('previous month'), cal_getlink("index.php?year=$py&month=$pm"));
 add_page_action(lang('next month'), get_url('event','index',
 		array("year"=> $ny,
 			 "month" => $nm
 			 )
 		), 'ico-nextmonth'
 );// add_page_action(lang('next month'), cal_getlink("index.php?year=$ny&month=$nm"));
//  $output .= "<input type=\"button\" value=\"<<\" class=\"formButtons\" onClick=\"og.openLink('" . cal_getlink("index.php?year=$py&month=$pm") . "');\">";
//  $output .= "<input type=\"button\" value=\">>\" class=\"formButtons\" onClick=\"og.openLink('" . cal_getlink("index.php?year=$ny&month=$nm") . "');\">";
  $output .= "</td></tr></table>";
  return $output;
} // end function navbar()




/* ##################################################################
  calendar()
   This function writes the calendar according to the date specified
   by the day, month, and year in the url.
###################################################################*/
//function cal_calendar($year, $month, $day){
	global $cal_db;
	// get actual current day info
	$currentday = date("j");
	$currentmonth = date("n");
	$currentyear = date("Y");
	// load the day we are currently viewing in the calendar
	$cday = $_SESSION['cal_day'];
	$cmonth = $_SESSION['cal_month'];
	$cyear = $_SESSION['cal_year'];
	
	if(cal_option("start_monday")) $firstday = (date("w", mktime(0,0,0,$month,1,$year))-1) % 7;
	else $firstday = (date("w", mktime(0,0,0,$month,1,$year))) % 7;
	$lastday = date("t", mktime(0,0,0,$month,1,$year));
	
	echo cal_navbar($year,$month,$day,$tags);
?>

<script language="javascript">

function cancel (evt) {//cancel clic event bubbling. used to cancel opening a New Event window when clicking an object
    var e=(evt)?evt:window.event;
    if (window.event) {
        e.cancelBubble=true;
    } else {
        e.stopPropagation();
    }
}

var ob=true;
function show_overlib(overlib_desc,fg_color,bg_color,txt_color,cap_text,cap_color){	
	if (ob){
		return overlib(overlib_desc,FGCOLOR,fg_color,BGCOLOR,bg_color,TEXTCOLOR,txt_color,CAPTION,cap_text,CAPCOLOR,cap_color);
	}
	return false;
}
//disable showing the overlib. 
function disable_overlib(){
	ob = false;
}
</script>

<table id="calendar" border='0' cellspacing='1' cellpadding='0' style="margin-left:15px">
	<colgroup span="7" width="1*">
	<tr>
	<?php 
	if(!cal_option("start_monday")) {
		echo "    <th width='15%' align='center'>" .  CAL_SUNDAY . '</th>' . "\n";
	}
	?>
	<th width="14%"><?php echo  CAL_MONDAY ?></th>
	<th width="14%"><?php echo  CAL_TUESDAY ?></th>
	<th width="14%"><?php echo  CAL_WEDNESDAY ?></th>
	<th width="14%"><?php echo  CAL_THURSDAY ?></th>
	<th width="14%"><?php echo  CAL_FRIDAY ?></th>
	<th width="15%"><?php echo  CAL_SATURDAY ?></th>
	
	<?php 
	$output = '';
	if(cal_option("start_monday")) {
		$output .= '    <th width="15%">' .  CAL_SUNDAY . '</th>' . "\n";
	}
	$output .= '  </tr>';
	
	
	
	
	$date_start = new DateTimeValue(mktime(0,0,0,$month,1,$year)); 
	$date_end = new DateTimeValue(mktime(0,0,0,$month,31,$year)); 
	$milestones = ProjectMilestones::getRangeMilestonesByUser($date_start,$date_end,logged_user(), $tags, active_project());
	$tasks = ProjectTasks::getRangeTasksByUser($date_start,$date_end,logged_user(), $tags, active_project());
				
	// Loop to render the calendar
	for ($week_index = 0;; $week_index++) {
		$output .= '  <tr>' . "\n";
		for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {
			$i = $week_index * 7 + $day_of_week;
			$day_of_month = $i - $firstday + 1;
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
			}elseif($day_of_month < 1){
				$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month&year=$year");
				$ld = date("t", strtotime("last month"));
				$w = $ld + $day_of_month;
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
			}
			$output .= "><div style='z-index:0; height:100%;' onclick=\"og.openLink('". $t."');disable_overlib();\") >
			<div class='$daytitle' style='text-align:right'>";
			
			$output .= "<a class='internalLink' href=\"$p\" onclick=\"cancel(event);\"  style='color:#5B5B5B' >$w</a>";				
			// only display this link if the user has permission to add an event
			if(!active_project() || ProjectEvent::canAdd(logged_user(),active_project())){
				// if single digit, add a zero
				$dom = $day_of_month;
				if($dom < 10) $dom = "0".$dom;
				// make sure user is allowed to edit the past
					
			}
				
			
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
						if($event instanceof ProjectEvent ){
							$count++;
							$subject =  truncate($event->getSubject(),25,'','UTF-8',true,true);
							$typeofevent = $event->getTypeId(); 
							$private = $event->getIsPrivate(); 
							$eventid = $event->getId(); 
						
							$color = $event->getEventTypeObject()?$event->getEventTypeObject()->getTypeColor():''; 
							if($color=="") $color = "C2FFBF";
							// organize the time and duraton data
							$overlib_time = CAL_UNKNOWN_TIME;
							switch($typeofevent) {
								case 1:
									if(!cal_option("hours_24")) $timeformat = 'g:i A';
									else $timeformat = 'G:i';
									$event_time = date($timeformat, $event->getStart()->getTimestamp()); 
									$overlib_time = "@ $event_time";
									break;
								case 2:
									$event_time = CAL_FULL_DAY;
									$overlib_time = CAL_FULL_DAY;
									break;
								case 3:
									$event_time = '??:??';
									$overlib_time = CAL_UNKNOWN_TIME;
									break;
								default: ;
							} 
							
							// build overlib text
							$overlib_text = "<strong>$overlib_time</strong><br>" . truncate($event->getDescription(),195,'...','UTF-8');
							$overlibtext_color = "#000000";
							// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
							if(!$private && $count <= 3){
								if($event->getEventTypeObject() && $event->getEventTypeObject()->getTypeColor()=="") $output .= '<div class="event_block">';
								else $output .= "<div class='event_block'   style='z-index:1000;border-left-color: #$color;'>";
								if($subject=="") $subject = "[".CAL_NO_SUBJECT."]";
								$output .= '<span onmouseover="return show_overlib(\''.str_replace("'","\\'",$overlib_text).'\',\'#'.$color.'\',\'#75BF60\',\''.$overlibtext_color.'\',\''.$subject.'\',\'#000\');" onmouseout="return nd();">';			
								$output .="<a href='".cal_getlink("index.php?action=viewevent&amp;id=".$event->getId())."' class='internalLink' onclick=\"cancel(event); nd();disable_overlib();\" >
											<img src=" . image_url('/16x16/calendar.png') . " align='absmiddle' border='0'>";
								$output .= $subject."</a>";
								$output .= '</span>';
								$output .= "</div>";
							}
						} elseif($event instanceof ProjectMilestone ){
							$milestone=$event;
							$due_date=$milestone->getDueDate();
							if (mktime(0,0,0,$month,$day_tmp,$year) == mktime(0,0,0,$due_date->getMonth(),$due_date->getDay(),$due_date->getYear())) {	
								$count++;
								if ($count<=3){
									$overlib_text = truncate($milestone->getDescription(),195,'...')."<br>";
									
									if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { 
										$overlib_text .= 'Assigned to:'. clean($milestone->getAssignedTo()->getObjectName());
									} else $overlib_text .= 'Assigned to: None';
									$color = 'FFC0B3'; 
									
									$subject = "&nbsp;".truncate($milestone->getName(),25,'','UTF-8',true,true)." - <i>Milestone</i>";
									$cal_text = substr( $milestone->getName(),0,25);
									$overlibtext_color = "#000000";
									$output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
									$output .= '<span onmouseover="return show_overlib(\''.str_replace("'","\\'",$overlib_text).'\',\'#'.$color.'\',\'#FF9680\',\''.$overlibtext_color.'\',\''.$subject.'\',\'#000\');" onmouseout="return nd();">';
									$output .= "<a href='".$milestone->getViewUrl()."' class='internalLink' onclick=\"cancel(event);nd();disable_overlib();\" >
												<img src=" . image_url('/16x16/milestone.png') . " align='absmiddle' border='0'>";
									$output .= $cal_text."</a>";
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
									$overlib_text = "&nbsp;".truncate($task->getText(),25,'','UTF-8',true,true)."<br>";
									if ($task->getAssignedTo() instanceof ApplicationDataObject) { 
										$overlib_text .= 'Assigned to:'. clean($task->getAssignedTo()->getObjectName());
									} else $overlib_text .= 'Assigned to: None';
									
									$color = 'B1BFAC'; 
									$subject = truncate($task->getTitle(),25,'','UTF-8',true,true).'- <i>Task</i>';
									$cal_text = truncate($task->getTitle(),15,'','UTF-8',true,true);
									
								    $overlibtext_color = "#000000";
									$output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
									$output .= '<span onmouseover="return show_overlib(\''.str_replace("'","\\'",$overlib_text).'\',\'#'.$color.'\',\'#92A96E\',\''.$overlibtext_color.'\',\''.$subject.'\',\'#000\');" onmouseout="return nd();">';
									$output .= "<a href='".$task->getViewUrl()."' class='internalLink' onclick=\"cancel(event);nd();disable_overlib();\"  border='0'>
												<img src=" . image_url('/16x16/tasks.png') . " align='absmiddle'>";
									$output .= $cal_text."</a>";
									$output .= '</span>';
									$output .= "";
								}//if count
							}
						}//endif task
					} // end foreach event writing loop
					if ($count > 3) {
						$output .= '<div style="witdh:100%;text-align:center;font-size:9px" ><a href="'.$p.'" class="internalLink"  onclick="cancel(event);nd();disable_overlib();">+'.($count-3).' more</a></div>';
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
echo  cal_bottom(); //}
?>
