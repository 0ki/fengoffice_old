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
  $output .= "<table cellpadding='4' cellspacing='0' width='90%' align='center'><tr><td alight='left' style='padding-left: 10px;'>";
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
  $output .= '<input type="button" class="formButtons" value="'.CAL_MENU_GO.'" onClick="var mo = document.getElementById(\'calendar_month\'); var m = mo.options[mo.selectedIndex].value; var yo = document.getElementById(\'calendar_year\'); var y = yo.options[yo.selectedIndex].value; og.openLink( \'index.php?a=index&c=event&month=\'+m+\'&year=\'+y);"> ';
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
	
	$output = cal_navbar($year,$month,$day,$tags);
	
	$output .= "<table id=\"calendar\" border='0' cellspacing='1' cellpadding='0'>
	<colgroup span=\"7\" width=\"1*\">
	<tr>\n";
	
	// Set header cells: notice the widths are defined so it will resize.
	if(!cal_option("start_monday")) {
		$output .= "    <th width='15%' align='center'>" .  CAL_SUNDAY . '</th>' . "\n";
	}
	$output .= '    <th width="14%">' .  CAL_MONDAY . '</th>
	<th width="14%">' .  CAL_TUESDAY . '</th>
	<th width="14%">' .  CAL_WEDNESDAY . '</th>
	<th width="14%">' .  CAL_THURSDAY . '</th>
	<th width="14%">' .  CAL_FRIDAY . '</th>
	<th width="15%">' .  CAL_SATURDAY . '</th>';
	if(cal_option("start_monday")) {
		$output .= '    <th width="15%">' .  CAL_SUNDAY . '</th>' . "\n";
	}
	$output .= '  </tr>';
	
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
			}elseif($day_of_month > $lastday OR $day_of_month < 1){
				$daytitle = 'extralink';
			}else $daytitle = 'daylink';
			// writes the cell info (color changes) and day of the month in the cell.
			$output .= "<td valign=\"top\" class=\"$daytype\"";
			if($day_of_month <= $lastday AND $day_of_month >= 1){ 
				$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month&year=$year");
				$w = $day_of_month;
			}elseif($day_of_month < 1){
				$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month&year=$year");
				$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month&year=$year");
				$w = "&nbsp;";
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
				if(count($result)<1) $output .= "&nbsp;";
				else
				foreach ($result as $event){ 
					$subject = $event->getSubject();
					$typeofevent = $event->getTypeId(); 
					$private = $event->getIsPrivate(); 
					$eventid = $event->getId(); 
					$desc = $event->getDescription(); 
					$overlib = "<strong>$subject</strong><br>$desc";
					$color = $event->getEventTypeObject()?$event->getEventTypeObject()->getTypeColor():''; 
					if($color=="") $color = "AAEE00";
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
					$overlib = "<strong>$subject<br>$overlib_time</strong><br>" . $desc;
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
						if($event->getEventTypeObject() && $event->getEventTypeObject()->getTypeColor()=="") $output .= '<div class="event_block">';
						else $output .= '<div class="event_block" style="border-left-color: #'.$color.';">';
						if($subject=="") $subject = "[".CAL_NO_SUBJECT."]";
						$output .= '<span onmouseover="return overlib(\''.str_replace("'","\\'",$overlib).'\',FGCOLOR,\'#'.$color.'\',BGCOLOR,\'#000000\',TEXTCOLOR,\''.$overlibtext.'\');" onmouseout="return nd();">';
						if(cal_option("show_times")) $output .= "$event_time - $subject";
						else $output .= "$subject";
						$output .= '</span>';
						$output .= "</div>";
					}
				} // end foreach event writing loop
				$output .= '</td>';
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
