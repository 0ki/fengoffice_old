<script type="text/javascript">
	showCalendarToolbar();
</script>
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
$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3';

$user = Users::findById(array('id' => $user_filter));
/*
 * If user does not exists, assign logged_user() to $user 
 * to prevent null exception when calling getRangeTasksByUser(), because this func. expects an User instance.
 */
if ($user == null) $user = logged_user(); 

$use_24_hours = user_config_option('time_format_use_24');

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
</script>
<div style="padding-right:1px">
<div class="calendar" align="center" style="width:100%;height:100%;">
<table style="width:100%;height:100%;">
<tr>
<td>
	<table style="width:100%;height:100%;">
		<tr>
			<td class="coViewHeader" colspan=1 rowspan=1>
				<div class="coViewTitle" style="width:100%;">				
					<?php echo cal_month_name($month)." ". $year .' - '. ($user_filter == -1 ? lang('all users') : lang('calendar of', clean($user->getDisplayName())));?>
				</div>		
			</td>
		</tr>
		<tr>
			<td class="coViewBody" style="padding:0px;width:100%;height:100%;" colspan=1>
				<div style="padding-bottom:0px;width:100%;height:100%;">
				<table id="calendar" border='0' cellspacing='0' cellpadding='0' width="100%" height="100%">
					<colgroup span="7" width="1*">
					<tr>
					<?php 
					if(!cal_option("start_monday")) {
						echo "    <th width='15%'>" .  lang('sunday short') . '</th>' . "\n";
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
								<div style='z-index:0; min-height:90px; height:100%; cursor:pointer;' onclick="showMonthEventPopup('<?php echo $dtv->getDay() ?>','<?php echo $dtv->getMonth()?>','<?php echo $dtv->getYear()?>');" >
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
											$subject =  clean($event->getSubject());
											$typeofevent = $event->getTypeId(); 
											$private = $event->getIsPrivate(); 
											$eventid = $event->getId();
											
											$dws = $event->getWorkspaces();
											$ws_color = 0;											
											if (count($dws) >= 1) $ws_color = $dws[0]->getColor();											
											cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color, $border_color);											
										
											// make the event subjects links or not according to the variable $whole_day in gatekeeper.php
											if(!$private && $count <= 3){
												$tip_text = str_replace("\r", '', clean($event->getDescription()));
												$tip_text = str_replace("\n", '<br>', $tip_text);													
												if (strlen_utf($tip_text) > 200) $tip_text = substr_utf($tip_text, 0, strpos($tip_text, ' ', 200)) . ' ...';
								?>
												<div id="m_ev_div_<?php echo $event->getId()?>" class="<?php echo ($typeofevent == 2 ? "og-wsname-color-$ws_color ": 'event_block') ?>" style="margin: 1px;padding-left:1px;padding-bottom:2px;"> 
													<nobr><a href='<?php echo cal_getlink("index.php?action=viewevent&amp;id=".$event->getId()."&amp;user_id=".$user_filter)?>' class='internalLink' onclick="cancel(event); hideCalendarToolbar(); return true;" <?php echo ($typeofevent == 2 ? "style='color:$txt_color;'" : '') ?>>
															<img src="<?php echo image_url('/16x16/calendar.png')?>" align='absmiddle' border='0'>
														<?php echo $subject ?>
													</a></nobr>
											 	</div>
										 		<script type="text/javascript">
													addTip('m_ev_div_<?php echo $event->getId() ?>', '<i>' + lang('event') + '</i> - ' + <?php echo json_encode(clean($event->getSubject())) ?>, <?php echo json_encode($event->getTypeId() == 2 ? lang('CAL_FULL_DAY') : $event->getStart()->format($use_24_hours ? 'G:i' : 'g:i A') .' - '. $event->getDuration()->format($use_24_hours ? 'G:i' : 'g:i A') . ($tip_text != '' ? '<br><br>' . $tip_text : ''));?>);
												</script>
											 	
								<?php
											}
								?>
												
								<?php
										} elseif($event instanceof ProjectMilestone ){
											$milestone=$event;
											$due_date=$milestone->getDueDate();
											$now = mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear());
											if ($now == mktime(0, 0, 0, $due_date->getMonth(), $due_date->getDay(), $due_date->getYear())) {	
												$count++;
												if ($count <= 3){
													$color = 'FFC0B3'; 
													$subject = "&nbsp;" . clean($milestone->getName())." - <i>Milestone</i>";
													$cal_text = clean($milestone->getName());
													
													$tip_text = str_replace("\r", '', lang('assigned to') .': '. clean($milestone->getAssignedToName()) . (trim(clean($milestone->getDescription())) == '' ? '' : '<br><br>'. clean($milestone->getDescription())));
													$tip_text = str_replace("\n", '<br>', $tip_text);													
													if (strlen_utf($tip_text) > 200) $tip_text = substr_utf($tip_text, 0, strpos($tip_text, ' ', 200)) . ' ...';
													
								?>
													<div id="m_ms_div_<?php echo $milestone->getId()?>" class="event_block" style="border-left-color: #<?php echo $color?>;">
														<nobr><a href='<?php echo $milestone->getViewUrl()?>' class="internalLink" onclick="cancel(event);return true;" >
																<img src="<?php echo image_url('/16x16/milestone.png')?>" align="absmiddle" border="0">
															<?php echo $cal_text ?>
														</a></nobr>
													</div>
													<script type="text/javascript">
														addTip('m_ms_div_<?php echo $milestone->getId() ?>', '<i>' + lang('milestone') + '</i> - ' + <?php echo json_encode(clean($milestone->getTitle())) ?>, <?php echo json_encode($tip_text != '' ? $tip_text : '');?>);
													</script>
								<?php
												}//if count
								?>
												
								<?php
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
													$color = 'B1BFAC'; 
													$subject = clean($task->getTitle()).'- <i>Task</i>';
													$cal_text = clean($task->getTitle());
													
													$tip_text = str_replace("\r", '', lang('assigned to') .': '. clean($task->getAssignedToName()) . (trim(clean($task->getText())) == '' ? '' : '<br><br>'. clean($task->getText())));
													$tip_text = str_replace("\n", '<br>', $tip_text);													
													if (strlen_utf($tip_text) > 200) $tip_text = substr_utf($tip_text, 0, strpos($tip_text, ' ', 200)) . ' ...';
								?>
								
													<div id="m_ta_div_<?php echo $task->getId()?>" class="event_block" style="border-left-color: #<?php echo $color?>;">
														<nobr><a href='<?php echo $task->getViewUrl()?>' class='internalLink' onclick="cancel(event);return true;"  border='0'>
																	<img src="<?php echo image_url('/16x16/tasks.png')?>" align='absmiddle'>
														 		<?php echo $cal_text ?>
														</a></nobr>
													</div>
													<script type="text/javascript">
														addTip('m_ta_div_<?php echo $task->getId() ?>', '<i>' + lang('task') + '</i> - ' + <?php echo json_encode(clean($task->getTitle()))?>, <?php echo json_encode(trim($tip_text) != '' ? trim($tip_text) : '');?>);
													</script>
								<?php
												}//if count
								?>
													
								<?php
											}
										}//endif task
									} // end foreach event writing loop
									if ($count > 3) {
								?>
									
										<div style="witdh:100%;text-align:center;font-size:9px" ><a href="<?php echo $p?>" class="internalLink"  onclick="cancel(event);return true;"><?php echo ($count-3) . ' ' . lang('more');?> </a></div>
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
		</table>
	</td>
</tr></table>
</div>
</div>
<script type="text/javascript">
	Ext.QuickTips.init();

	function showMonthEventPopup(day, month, year) {
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
								start_time: '9:00',
								type_id:2, 
								view:'month', 
								title: lang('add event'),
								time_format: '<?php echo ($use_24_hours ? 'G:i' : 'g:i A') ?>',
								hide_calendar_toolbar: 1
								}, '');
	}
</script>