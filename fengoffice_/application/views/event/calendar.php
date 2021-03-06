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

$year = isset($_GET['year']) ? $_GET['year'] : (isset($_SESSION['year']) ? $_SESSION['year'] : date('Y'));
$month = isset($_GET['month']) ? $_GET['month'] : (isset($_SESSION['month']) ? $_SESSION['month'] : date('n'));
$day = isset($_GET['day']) ? $_GET['day'] : (isset($_SESSION['day']) ? $_SESSION['day'] : date('j'));

$_SESSION['year'] = $year;
$_SESSION['month'] = $month;
$_SESSION['day'] = $day;

$user_filter = !isset($_GET['user_filter']) || $_GET['user_filter'] == 0 ? logged_user()->getId() : $_GET['user_filter'];
$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : -1; 

$user = Users::findById(array('id' => $user_filter));

global $cal_db;
// get actual current day info
$currentday = date("j");
$currentmonth = date("n");
$currentyear = date("Y");

if(cal_option("start_monday")) $firstday = (date("w", mktime(0, 0, 0, $month, 1, $year)) - 1) % 7;
else $firstday = (date("w", mktime(0, 0, 0, $month, 1, $year))) % 7;
$lastday = date("t", mktime(0, 0, 0, $month, 1, $year));

?>


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



</script>
<div style="padding:7px">
<div class="calendar" align="center">
<table style="width:95%">
<tr>
<td>
	<table style="width:100%">
			<col width=1%/>
			<col/>
			<col width=1%/>
		<tr>
			<td class="coViewHeader" colspan=2  rowspan=2>
				<div class="coViewTitle">				
					<?php echo cal_month_name($month)." ". $year .' - '. ($user_filter == -1 ? lang('all users') : lang('calendar of', $user->getDisplayName()));?>				
				</div>		
			</td>
			
			<td class="coViewTopRight"></td>
		</tr>
		<tr>
			<td class="coViewRight" rowspan=2></td>
		</tr>
		
		<tr>
			<td class="coViewBody" style="padding:0px" colspan=2>
				<div style="padding-bottom:0px">
				<table id="calendar" border='0' cellspacing='0' cellpadding='0' width="100%">
					<colgroup span="7" width="1*">
					<tr>
					<?php 
					if(!cal_option("start_monday")) {
						echo "    <th width='15%' align='center'>" .  lang('sunday short') . '</th>' . "\n";
					}
					?>
					<th width="14%"><?php echo  lang('monday short') ?></th>
					<th width="14%"><?php echo  lang('tuesday short') ?></th>
					<th width="14%"><?php echo  lang('wednesday short') ?></th>
					<th width="14%"><?php echo  lang('thursday short') ?></th>
					<th width="14%"><?php echo  lang('friday short') ?></th>
					<th width="15%"><?php echo  lang('saturday short') ?></th>
					
					<?php 
					$output = '';
					if(cal_option("start_monday")) {
					?>
						<th width="15%"> <?php echo lang('sunday short') ?> </th>
					<?php } ?>
					</tr>
					
					
					
					<?php
					$date_start = new DateTimeValue(mktime(0,0,0,$month-1,$firstday,$year)); 
					$date_end = new DateTimeValue(mktime(0,0,0,$month+1,$lastday,$year)); 
					$milestones = ProjectMilestones::getRangeMilestonesByUser($date_start,$date_end,logged_user(), $tags, active_project());
					$tasks = ProjectTasks::getRangeTasksByUser($date_start,$date_end, $user, $tags, active_project());
								
					// Loop to render the calendar
					for ($week_index = 0;; $week_index++) {
					?>
						<tr>
					<?php
						$month_aux = $month;
						$year_aux = $year;
						
						for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {
							$i = $week_index * 7 + $day_of_week;
							$day_of_month = $i - $firstday + 1;
							// if weekends override do this
							if(cal_option("weekendoverride")){
								// set whether the date is in the past or future/present
								if($day_of_week == 0 OR $day_of_week == 6){
									$daytype = "weekend";
								}elseif($day_of_month <= $lastday AND $day_of_month >= 1){
									$daytype = "weekday";
								}else{
									$daytype = "weekday_future";
								}
							}else{
								if( !cal_option("start_monday") AND ($day_of_week == 0 OR $day_of_week == 6) ){
									$daytype = "weekend";
								}elseif( cal_option("start_monday") AND ($day_of_week == 5 OR $day_of_week == 6) AND $day_of_month <= $lastday AND $day_of_month >= 1){
									$daytype = "weekend";
								}elseif($day_of_month <= $lastday AND $day_of_month >= 1){
									$daytype = "weekday";
								}else{
									$daytype = "weekday_future";
								}
							}
							$date_tmp = DateTimeValueLib::make(0, 0, 0, $month_aux, $day_of_month, $year_aux);
							// see what type of day it is
							if($currentyear == $date_tmp->getYear() && $currentmonth == $date_tmp->getMonth() && $currentday == $date_tmp->getDay()){
								$daytitle = 'todaylink';
								$daytype = "today";
							} else if($year == $year_aux && $month == $month_aux && $day == $day_of_month){
								$daytitle = 'selecteddaylink';
								$daytype = "selectedday";
							} else if($day_of_month > $lastday OR $day_of_month < 1){
								if ($daytype == "weekend")
								$daytitle = 'extraweekendlink';
								else
								$daytitle = 'extralink';
							} else
								$daytitle = 'daylink';
							// writes the cell info (color changes) and day of the month in the cell.
							
					?>
							<td valign="top" class="<?php echo $daytype?>">
					<?php
						
							if($day_of_month <= $lastday AND $day_of_month >= 1){ 
								$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month_aux&year=$year_aux");
								$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month_aux&year=$year_aux");
								$w = $day_of_month;
								$dtv = DateTimeValueLib::make(0, 0, 0, $month_aux, $day_of_month, $year_aux);
							}elseif($day_of_month < 1){
								$p = cal_getlink("index.php?action=viewdate&day=$day_of_month&month=$month_aux&year=$year_aux");
								$t = cal_getlink("index.php?action=add&day=$day_of_month&month=$month_aux&year=$year_aux");
								$ld = idate('d', mktime(0, 0, 0, $month_aux, 0, $year_aux));//date("t", strtotime("last month",mktime(0,0,0,$month-1,1,$year)));
								$w = $ld + $day_of_month ;
								$dtv = DateTimeValueLib::make(0, 0, 0, $month_aux, $day_of_month, $year_aux);  
								
							}else{
								if($day_of_month == $lastday + 1){
									$month_aux++;
									if($month_aux == 13){
										$month_aux = 1;
										$year_aux++;
									}
								}
								$p = cal_getlink("index.php?action=viewdate&day=".($day_of_month-$lastday)."&month=$month_aux&year=$year_aux");
								$t = cal_getlink("index.php?action=add&day=".($day_of_month-$lastday)."&month=$month_aux&year=$year_aux");
								$w = $day_of_month - $lastday;
								$dtv = DateTimeValueLib::make(0, 0, 0, $month_aux, $w, $year_aux);
							}
														
					?>	
							
							
								<div style='z-index:0; height:100%;cursor:pointer' onclick="showEventPopup('<?php echo $dtv->getDay() ?>','<?php echo $dtv->getMonth()?>','<?php echo $dtv->getYear()?>');" >
									<div class='<?php echo $daytitle?>' style='text-align:right'>
							
							 		<a class='internalLink' href="<?php echo $p ?>" onclick="cancel(event);return true;"  style='color:#5B5B5B' ><?php echo $w?></a>				
					<?php
							// only display this link if the user has permission to add an event
							if(!active_project() || ProjectEvent::canAdd(logged_user(), active_project())){
								// if single digit, add a zero
								$dom = $day_of_month;
								if($dom < 10) $dom = "0" . $dom;
								// make sure user is allowed to edit the past
									
							}
					?>			
							
								</div>
					<?php
							
							// This loop writes the events for the day in the cell
							if (is_numeric($w)){ //if it is a day after the first of the month
								$result = ProjectEvents::getDayProjectEvents($dtv, $tags, active_project(), $user_filter, $state_filter); 
								if(!$result)
									$result = array();
								if($milestones)
									$result = array_merge($result, $milestones );
									
								if($tasks)
									$result = array_merge($result, $tasks );
								
								if(count($result) < 1) { ?> 
									&nbsp; 				
								<?php
								} else {
									$count = 0;
									foreach($result as $event){
										if($event instanceof ProjectEvent ){
											$count++;
											$subject =  $event->getSubject();//truncate($event->getSubject(),30,'','UTF-8',true,true);
											$typeofevent = $event->getTypeId(); 
											$private = $event->getIsPrivate(); 
											$eventid = $event->getId(); 
										
											$color = $event->getEventTypeObject() ? $event->getEventTypeObject()->getTypeColor() : ''; 
											if($color == "") $color = "C2FFBF";
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
													$event_time = lang('CAL_FULL_DAY');
													$overlib_time = lang('CAL_FULL_DAY');
													break;
												case 3:
													$event_time = '??:??';
													$overlib_time = lang('CAL_UNKNOWN_TIME');
													break;
												default: ;
											} 
											
											// build overlib text
											$overlib_text = "$overlib_time<br>" . truncate($event->getDescription(), 195, '...', 'UTF-8');
											$overlibtext_color = "#000000";
											// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
											if(!$private && $count <= 3){
												if($subject == "") $subject = "[".lang('CAL_NO_SUBJECT')."]";
												$strStyle = '';
												if($event->getEventTypeObject() && $event->getEventTypeObject()->getTypeColor() == "") { 
													$strStyle= "style='z-index:1000;border-left-color: #$color;'";
												}		
								?>
												<div class="event_block" <?php echo $strStyle  ?> > 
													<span class='event_hover_details' title="<?php echo $subject." - <i>Event</i>"?>|<?php echo $overlib_text?>" >													 	
														<a href='<?php echo cal_getlink("index.php?action=viewevent&amp;id=".$event->getId()."&amp;user_id=".$user_filter)?>' class='internalLink' onclick="hide_tooltip(this); cancel(event); disable_overlib();return true;" >
															<img src="<?php echo image_url('/16x16/calendar.png')?>" align='absmiddle' border='0'>
														<?php echo $subject ?>
														</a>
													</span>
											 	</div>
								<?php
											}
										} elseif($event instanceof ProjectMilestone ){
											$milestone=$event;
											$due_date=$milestone->getDueDate();
											$now = mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear());
											if ($now == mktime(0, 0, 0, $due_date->getMonth(), $due_date->getDay(), $due_date->getYear())) {	
												$count++;
												if ($count <= 3){
													$overlib_text = truncate($milestone->getDescription(), 195, '...') . "<br>";
													
													if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { 
														$overlib_text .= 'Assigned to:'. clean($milestone->getAssignedTo()->getObjectName());
													} else $overlib_text .= 'Assigned to: None';
													$color = 'FFC0B3'; 
													
													$subject = "&nbsp;" . $milestone->getName()." - <i>Milestone</i>";//"&nbsp;".truncate($milestone->getName(),30,'','UTF-8',true,true)." - <i>Milestone</i>";
													$cal_text = $milestone->getName();
													$overlibtext_color = "#000000";
								?>
													<div class="event_block" style="border-left-color: #<?php echo $color?>;">
														<span class='milestone_hover_details' title="<?php echo $subject?>|<?php echo $overlib_text?>" >
															<a href='<?php echo $milestone->getViewUrl()?>' class='internalLink' onclick="hide_tooltip(this);cancel(event);disable_overlib();return true;" >
																<img src="<?php echo image_url('/16x16/milestone.png')?>" align='absmiddle' border='0'>
															<?php echo $cal_text ?>
															</a>
														</span>
													</div>
								<?php
												}//if count
											}
											
										}//endif milestone
										elseif($event instanceof ProjectTask){
											$task = $event;
											$start_date = $task->getStartDate();
											$due_date = $task->getDueDate();
											$now = mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear());
											if ($now == mktime(0, 0, 0, $due_date->getMonth(), $due_date->getDay(), $due_date->getYear())) {	
												$count++;
												if ($count <= 3){
													$overlib_text = "&nbsp;" . $task->getText() . "<br>";
													if ($task->getAssignedTo() instanceof ApplicationDataObject) { 
														$overlib_text .= 'Assigned to:' . clean($task->getAssignedTo()->getObjectName());
													} else $overlib_text .= 'Assigned to: None';
													
													$color = 'B1BFAC'; 
													$subject = $task->getTitle().'- <i>Task</i>';//truncate($task->getTitle(),25,'','UTF-8',true,true).'- <i>Task</i>';
													$cal_text = $task->getTitle();
													
												    $overlibtext_color = "#000000";
								?>
								
													<div class="event_block" style="border-left-color: #<?php echo $color?>;">
														<span class='task_hover_details' title="<?php echo $subject?>|<?php echo $overlib_text?>" >
															<a href='<?php echo $task->getViewUrl()?>' class='internalLink' onclick="hide_tooltip(this);cancel(event);disable_overlib();return true;"  border='0'>
																	<img src="<?php echo image_url('/16x16/tasks.png')?>" align='absmiddle'>
														 		<?php echo $cal_text ?>
														 	</a>
														</span>
													</div>
								<?php
												}//if count
											}
										}//endif task
									} // end foreach event writing loop
									if ($count > 3) {
								?>
									
										<div style="witdh:100%;text-align:center;font-size:9px" ><a href="<?php echo $p?>" class="internalLink"  onclick="cancel(event);disable_overlib();return true;">+<?php echo ($count-3) ?> more</a></div>
								<?php
									}
								}
								?>									
								</td>
								<?php
							} //if is_numeric($w) 
						} // end weekly loop
						?>
						</tr>
						<?php
						// If it's the last day, we're done
						if($day_of_month >= $lastday) {
							break;
						}
					} // end main loop
					
				?>
				</table>
				</div>
			</td>
			</tr>
			<tr><td class="coViewBottomLeft" style="width:12"></td>
			<td class="coViewBottom" style="width:85%"></td>
			<td class="coViewBottomRight" style="width:12"></td></tr>
		</table>
	</td>
</tr></table>
</div>
</div>
<script type="text/javascript">
	jQuery.noConflict();//YUI redefines $, so we need to set jQuery to non-conflict mode	

	jQuery('span.task_hover_details').cluetip({		
	    splitTitle: '|', // use the invoking element's title attribute to populate the clueTip...
	                     // ...and split the contents into separate divs where there is a "|"
	    cluetipClass: 'task',
	    width: 'auto',
	    // effect and speed for opening clueTips
	    fx: {             
              open:       'fadeIn', // can be 'show' or 'slideDown' or 'fadeIn'
              openSpeed:  ''
	    },
	                  
	    // settings for when hoverIntent plugin is used
	    hoverIntent: {    
              sensitivity:  3,
              interval:     50,
              timeout:      0
	    }, 
	    topOffset:        8,       // Number of px to offset clueTip from top of invoking element. more info below [3]
    	leftOffset:       8,
    	onActivate: function(e) {//to prevent keeping the tooltip after moving away from the page
		    return ob;
		  },
	    showTitle: false // hide the clueTip's heading
  	});
  	
  	jQuery('span.milestone_hover_details').cluetip({		
	    splitTitle: '|', 
	    cluetipClass: 'milestone',
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
  	
  	jQuery('span.event_hover_details').cluetip({		
	    splitTitle: '|', 
	    cluetipClass: 'event',
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
  	
  	function quickTip(id, title, bdy, link) {
		tt = new Ext.ToolTip({
			target: id,
	        html: bdy,
	        title: '<a href="' + link + '">'+title+'</a>',
	        showDelay: 800,
	        hideDelay: 1200,
	        minWidth: 250
	    });
	}
	
	function showEventPopup(day, month, year) {
		if (lang('date format') == 'm/d/Y') 
			st_val = month + '/' + day + '/' + year;
		else
			st_val = day + '/' + month + '/' + year;

		og.EventPopUp.show(null, {day: day,
								month: month,
								year: year,
								hour: 9,
								minute: 0,
								durationhour: 1,
								durationmin: 0,
								start_value: st_val,
								type_id:2, view:'month', title: lang('add event')
								}, '');
	}
</script>