<?php
define('PX_HEIGHT',42);
$year = isset($_GET['year']) ? $_GET['year'] : (isset($_SESSION['year']) ? $_SESSION['year'] : date('Y'));
$month = isset($_GET['month']) ? $_GET['month'] : (isset($_SESSION['month']) ? $_SESSION['month'] : date('n'));
$day = isset($_GET['day']) ? $_GET['day'] : (isset($_SESSION['day']) ? $_SESSION['day'] : date('j'));

$_SESSION['year'] = $year;
$_SESSION['month'] = $month;
$_SESSION['day'] = $day;

$user_filter = !isset($_GET['user_filter']) || $_GET['user_filter'] == 0 ? logged_user()->getId() : $_GET['user_filter'];
$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : -1; 

$user = Users::findById(array('id' => $user_filter));

$tags = active_tag();	
?>
<?php echo stylesheet_tag('event/week.css') ?>
<?php
	$startday = date("d", mktime(0, 0, 0, $month, $day, $year)) - (date("N", mktime(0, 0, 0, $month, $day, $year)) % 7);//inicio de la semana
	$endday = $startday + 7;//fin de la semana
	$currentday = date("j");
	$currentmonth = date("n");
	$currentyear = date("Y");
	$lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); // # of days in the month
	//DateTimeValue
	
	$date_start = new DateTimeValue(mktime(0, 0, 0, $month, $startday, $year)); 
	$date_end = new DateTimeValue(mktime(0, 0, 0, $month, $endday, $year)); 
	
	$milestones = ProjectMilestones::getRangeMilestonesByUser($date_start, $date_end, logged_user(), $tags, active_project());
	$tasks = ProjectTasks::getRangeTasksByUser($date_start, $date_end, $user, $tags, active_project());
	
	//$day_events = array();
	$dates = array();//datetimevalye for each day of week
	$results = array();
	$allday_events_count = array();
	$alldayevents = array();
	$today_style = array();
	
	$month_aux = $month;
	$year_aux = $year;
	
	for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {	
		
		$day_of_month = $day_of_week + $startday;
		if($day_of_month <= $lastday AND $day_of_month >= 1){ 								
			$w = $day_of_month;
		} elseif($day_of_month < 1) {								
			$w = $day_of_month;
		} else {
			if($day_of_month == $lastday+1) {
				$month_aux++;
				if($month_aux == 13){
					$month_aux = 1;
					$year_aux++;
				}
			}
			$w = $day_of_month - $lastday;
		}	
		
		$day_tmp = (isset($w) && is_numeric($w)) ? $w : 0;
	
		$dates[$day_of_week] = new DateTimeValue(mktime(0, 0, 0, $month_aux, $day_tmp, $year_aux)); 
		
		$today_style[$day_of_week] = '';
		if($currentyear == $year_aux && $currentmonth == $month_aux && $currentday == $day_of_month) { // Today
			$today_style[$day_of_week] = 'background-color:#FFFFCC;';
		} else if($year == $year_aux && $month == $month_aux && $day == $day_of_month) { // Selected day
			$today_style[$day_of_week] = 'background-color:#F5FFFF;';
		}

		
		$results[$day_of_week] = ProjectEvents::getDayProjectEvents($dates[$day_of_week], $tags, active_project(), $user_filter, $state_filter); 
		if(!$results[$day_of_week]) $results[$day_of_week]=array();
		foreach ($results[$day_of_week] as $key => $event){
			if ($event->getTypeId()> 1){
				$alldayevents[$day_of_week][] = $event;
				unset($results[$day_of_week][$key]);
			}
		}
		if(is_array($milestones)){
			foreach ($milestones as $milestone){
				if ($dates[$day_of_week]->getTimestamp() == mktime(0,0,0,$milestone->getDueDate()->getMonth(),$milestone->getDueDate()->getDay(),$milestone->getDueDate()->getYear())) {	
					$alldayevents[$day_of_week][] = $milestone;
				}			
			}
		}
		if(is_array($tasks)){
			foreach ($tasks as $task){
				if ($dates[$day_of_week]->getTimestamp() == mktime(0,0,0,$task->getDueDate()->getMonth(),$task->getDueDate()->getDay(),$task->getDueDate()->getYear())) {	
					$alldayevents[$day_of_week][] = $task;
				}			
			}
		}
		$allday_events_count[$day_of_week]=  count(array_var($alldayevents, $day_of_week, array()));
	}
	
	$max_events = max($allday_events_count) == 0 ? 1 : max($allday_events_count);
	$alldaygridHeight = $max_events * PX_HEIGHT / 2 + PX_HEIGHT / 2;//Day events container height= all the events plus an extra free space
	
?>
<div class="calendar" style="padding:7px;height:100%" id="cal_main_div">
<table style="width:100%;height:95%">
<tr>
<td>
	<table style="width:100%">
	<col width=1%/>
	<col/>
	<col width=1%/>
	<tr>
	<td class="coViewHeader" colspan=2  rowspan=2>
	<div class="coViewTitle">				
		<span id="chead0"><?php echo  date('d/m/y'/*Localization::instance()->getDateFormat()*/, mktime(0, 0, 0, $month, $startday, $year)) ." - ". date('d/m/y'/*Localization::instance()->getDateFormat()*/, mktime(0, 0, 0, $month, $endday-1, $year))
		 .' - '. ($user_filter == -1 ? lang('all users') : lang('calendar of', $user->getDisplayName()));?></span>	
	</div>		
	</td>
			
	<td class="coViewTopRight"></td>
	</tr>
	<tr>
		<td class="coViewRight" rowspan=2></td>
	</tr>
		
	<tr>
		<td class="coViewBody" style="padding:0px" colspan=2>					
		<div id="chrome_main2" class="printborder" style="border-color: rgb(195, 217, 255); background: rgb(195, 217, 255) none repeat scroll 0% 50%; width:100%; height:95%">
		<div id="allDayGrid" class="inset grid"  style="height: <?php echo $alldaygridHeight ?>px; margin-bottom: 5px;background:#E8EEF7;margin-right:0px;margin-left:40px;position:relative;"   >
		<?php					
									
						$width_percent = 100/7;
						$width = 0;
						for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {	
							
							$day_of_month = $day_of_week + $startday;
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
							
													
							$dtv_temp = $dates[$day_of_week];
							$p = cal_getlink("index.php?action=viewdate&day=".$dtv_temp->getDay()."&month={$dtv_temp->getMonth()}&year={$dtv_temp->getYear()}");
							$t = cal_getlink("index.php?action=add&day=".$dtv_temp->getDay()."&month={$dtv_temp->getMonth()}&year={$dtv_temp->getYear()}");							
											
					?>
							<div class="chead cheadNotToday" style="width: <?php echo $width_percent ?>%; left: <?php echo $width ?>%;text-align:center;position:absolute;top:0%;">
								<span id="chead<?php echo $day_of_week ?>">
									<a class="internalLink" href="<?php echo $p; ?>"  onclick="stopPropagation(event) "><?php $dtime = mktime(0, 0, 0, $dtv_temp->getMonth(), $dtv_temp->getDay(), $dtv_temp->getYear()); echo lang(strtolower(date("l", $dtime)) . ' short') . date(" j/n", $dtime); ?></a>
								</span>
							</div>
							<div id="allDay<?php echo $day_of_week ?>" class="allDayCell" style="left: <?php echo $width ?>%; height: <?php echo $alldaygridHeight ?>px;border-left:3px double #DDDDDD !important; position:absolute;width:3px;z-index:110;background:#E8EEF7;top:0%;"></div>
					
							<div id="alldayeventowner" style="width: <?php echo $width_percent ?>%;position:absolute;left: <?php echo $width ?>%; top: 12px;height: <?php echo $alldaygridHeight ?>px;" onclick="og.EventPopUp.show(null, {day:'<?php echo $dates[$day_of_week]->getDay() ?>',	month:'<?php echo $dates[$day_of_week]->getMonth()?>',year:'<?php echo $dates[$day_of_week]->getYear()?>',view:'week',type_id:2,title:'<?php echo date("l, F j",  mktime(0, 0, 0, $dates[$day_of_week]->getMonth(), $dates[$day_of_week]->getDay(), $dates[$day_of_week]->getYear()))?>'},'');">
								<?php	
									$top=5;
									if(is_array(array_var($alldayevents,$day_of_week))){
										foreach ($alldayevents[$day_of_week] as $event){	
										
											if ($event instanceof ProjectMilestone ){									
												$subject =$event->getName();
												$img_url = image_url('/16x16/milestone.png');
												$due_date=$event->getDueDate();
											}elseif ($event instanceof ProjectTask){
												$subject =$event->getTitle();
												$img_url = image_url('/16x16/tasks.png');
												$due_date=$event->getDueDate();
											}elseif ($event instanceof ProjectEvent){
												$subject =$event->getSubject();
												$img_url = image_url('/16x16/calendar.png'); /* @var $event ProjectEvent */											
											}
											
											if ($event instanceof ProjectEvent || ($dates[$day_of_week]->getTimestamp() == mktime(0,0,0,$due_date->getMonth(),$due_date->getDay(),$due_date->getYear()))) {	
												$dws = $event->getWorkspaces();
												$ws_color = 0;
												if (count($dws) >= 1){
													$ws_color = $dws[0]->getColor();
												}
												cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color);
								?>
								<div class="adc" style="left: 6%; top: <?php echo $top ?>px; z-index: 5;width: 90%;margin:1px;position:absolute;">
									<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"></div>
									<div class="noleft <?php echo  $ws_class?>" style="<?php echo  $ws_style?>">							
										<div class="" style="overflow: hidden; padding-bottom: 1px;">										
											<nobr style="display: block; text-decoration: none;"><a href='<?php echo $event->getViewUrl()."&amp;view=week"?>' class='internalLink'" onclick="stopPropagation(event)"><img src="<?php echo $img_url?>" align='absmiddle' border='0'> <span style="color:<?php echo $txt_color ?>!important"><?php echo $subject ?></span> </a></nobr>										
										</div>
									</div>
									<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"></div>
								</div>
								<?php
												$top += 20;	
											}
										}
									}
								?>
							</div>		
					<?php
							$width += $width_percent;
						}
					?>
				</div>					
				<div id="gridcontainer" style="background-color:#fff;overflow: hidden;height: 1008px; 	position:relative;" >	
					<!-- <div class='grid_bg' style="background-image: url(public/assets/themes/default/images/Calendar_BG.gif);background-repeat: repeat;background-color:#ffffff;height:1024px;"> -->
						<div id='calowner' style="display:block; width:100%;">  
							<table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed; width: 100%;height: 1008px;">
								<tr>
									<td id="rowheadcell" style="width: 40px;">
										<div id="rowheaders" style="top: 0pt; left: 0pt;">										
										<?php
											for ($hour=0; $hour<=23; $hour++){	
										?>
<div style="height: <?php echo PX_HEIGHT-1?>px; top: 0ex;background: #E8EEF7 none repeat scroll 0%;border-top:1px solid #DDDDDD;left:0pt;width: 100%;" id="rhead<?php echo $hour?>" class="rhead">
	<div class="rheadtext"><?php echo date("ga",mktime($hour)) ?></div>
</div>												
										<?php
											}
										?>

										</div>
									</td>
									<td id="gridcontainercell" style="width: auto;position:relative" >	
										<div id="grid" style="height: 100%;background-color:#fff;position:relative;" class="grid">										
											<div id="decowner">
												
											</div>
											
										<?php
											for ($hour=0; $hour<=47; $hour++){	
												$curr_hour = date("g");
												if ($hour % 2 == 0){
													$parity = "hruleeven";
													$style="border-top:1px solid #DDDDDD;";
												} else {
													$parity="hruleodd";
													$style="border-top:1px dotted #DDDDDD;";
												}
												$top = (PX_HEIGHT/2) * $hour;
										?>
<div id="r<?php echo $hour?>"" class="hrule <?php echo $parity?>" style="top: <?php echo $top?>px; z-index: 101;position:absolute;left:0px;<?php echo $style?>;width:100%">
<?php $hour == $curr_hour? print("<span id='curr_hour' style='visibility:hidden;height:0px;width:0px'></span>"):print('');?>
</div>
<?php
											}
											
											
											
											for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {										
												$procesados = array();
												$horas = array();
												$date = $dates[$day_of_week];
												$left = (100/7)*$day_of_week;
												for ($hour=0; $hour<=23; $hour++){	
													$horas[$hour]	= 0;
													$procesados[$hour]	= 0;
												}			
												for ($hour=0; $hour<=47; $hour++){
													$top = (PX_HEIGHT/2) * $hour;
										?>
<div id="h<?php echo $day_of_week."_".$hour?>" style="left:<?php echo $left ?>%;width:<?php echo $width_percent ?>%;top:<?php echo $top?>px;z-index:100;height:20px;position:absolute;<?php echo $today_style[$day_of_week] ?>"
onmousedown="selectStartDateTime(<?php echo $date->getDay() ?>, <?php echo $date->getMonth()?>, <?php echo $date->getYear()?>, <?php echo date("G",mktime($hour/2))?>, <?php echo ($hour % 2 ==0)?0:30 ?>);"
onmouseup="showEventPopup(<?php echo $date->getDay() ?>, <?php echo $date->getMonth()?>, <?php echo $date->getYear()?>, <?php echo date("G",mktime($hour/2))?>, <?php echo ($hour % 2 ==0)?0:30 ?>);"
></div>
										<?php
												}
																					
										?>		
												<div id="vd<?php echo $day_of_week ?>" style="left: <?php echo $left ?>%; height: <?php echo (PX_HEIGHT)*24 ?>px;border-left:3px double #DDDDDD !important; position:absolute;width:3px;z-index:110;"></div>
												<div id="eventowner" style="z-index: 102;" onclick="stopPropagation(event) ">
												<?php
													$cells = array();
													for ($i = 0; $i < 24; $i++) {
														$cells[$i][0] = 0;
														$cells[$i][1] = 0;
													}
													foreach ($results[$day_of_week] as $event){
														if ($event->getStart()->getMinute() < 30) {
															$cells[$event->getStart()->getHour()][0]++;
															$cells[$event->getStart()->getHour()][1]++;
														} else $cells[$event->getStart()->getHour()][1]++;
														for($i = $event->getStart()->getHour()+1; $i < $event->getDuration()->getHour(); $i++){
															$cells[$i][0]++;
															$cells[$i][1]++;
														}
														if ($event->getDuration()->getMinute() > 0) {
															$cells[$i][0]++;
															if ($event->getDuration()->getMinute() > 30) $cells[$i][1]++;
														}															
													}
													$occup = array(); //keys: hora - pos
													foreach ($results[$day_of_week] as $event){
														$event_id = $event->getId();
														$subject = $event->getSubject();
														$dws = $event->getWorkspaces();
														$ws_color = 0;
														if (count($dws) >= 1){
															$ws_color = $dws[0]->getColor();
														}	
														
														cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color);	
														
														if(!cal_option("hours_24")) $timeformat = 'g:i A';
														else $timeformat = 'G:i';
														$start_time = date($timeformat, $event->getStart()->getTimestamp());
														$end_time = date($timeformat, $event->getDuration()->getTimestamp());
														
														$hr_start = $event->getStart()->getHour();
														$min_start = $event->getStart()->getMinute();
														$hr_end = $event->getDuration()->getHour();
														$min_end = $event->getDuration()->getMinute();
														
														if ($event->getStart() == $event->getDuration()){
															$hr_end++;
														}
														$top = PX_HEIGHT * $hr_start + (PX_HEIGHT*(($min_start*100)/(60*100)));
														$bottom = PX_HEIGHT * $hr_end + (PX_HEIGHT*(($min_end*100)/(60*100)));
														$height = $bottom - $top - 5; //substract 4px for the rounded corners, 1px for separation
														
														$evs_same_time = 0;
														$i = $event->getStart()->getHour();
														if ($event->getStart()->getMinute() < 30) {
															if ($cells[$i][0] > $evs_same_time) $evs_same_time = $cells[$i][0];
															if ($cells[$i][1] > $evs_same_time) $evs_same_time = $cells[$i][1];
														} else if ($cells[$i][1] > $evs_same_time) $evs_same_time = $cells[$i][1];
														
														for($i = $event->getStart()->getHour()+1; $i < $event->getDuration()->getHour(); $i++){
															if ($cells[$i][0] > $evs_same_time) $evs_same_time = $cells[$i][0];
															if ($cells[$i][1] > $evs_same_time) $evs_same_time = $cells[$i][1];
														}
														$i = $event->getDuration()->getHour();
														if ($event->getDuration()->getMinute() > 0) {
															if ($cells[$i][0] > $evs_same_time) $evs_same_time = $cells[$i][0];
															if ($event->getDuration()->getMinute() > 30) {
																if ($cells[$i][1] > $evs_same_time) $evs_same_time = $cells[$i][1];
															}
														}
														
														$posHoriz = 0;
														$canPaint = false;
														while (!$canPaint) {
															$canPaint = true;
															if ($event->getStart()->getMinute() < 30) {
																$canPaint = !(isset($occup[$event->getStart()->getHour()][0][$posHoriz]) && $occup[$event->getStart()->getHour()][0][$posHoriz]
																		 || isset($occup[$event->getStart()->getHour()][1][$posHoriz]) && $occup[$event->getStart()->getHour()][1][$posHoriz]);
															} else {
																$canPaint = !(isset($occup[$event->getStart()->getHour()][1][$posHoriz]) && $occup[$event->getStart()->getHour()][1][$posHoriz]);
															}
															for($i = $event->getStart()->getHour()+1; $canPaint && $i < $event->getDuration()->getHour(); $i++) {
																if (isset($occup[$i][0][$posHoriz]) && $occup[$i][0][$posHoriz] || isset($occup[$i][1][$posHoriz]) && $occup[$i][1][$posHoriz]) {
																	$canPaint = false;
																}																
															}
															if ($canPaint) {
																if ($event->getDuration()->getMinute() > 30) {
																	$canPaint = !(isset($occup[$event->getDuration()->getHour()][0][$posHoriz]) && $occup[$event->getDuration()->getHour()][0][$posHoriz]
																	|| isset($occup[$event->getDuration()->getHour()][1][$posHoriz]) && $occup[$event->getDuration()->getHour()][1][$posHoriz]);
																} else {
																	$canPaint = !(isset($occup[$event->getDuration()->getHour()][1][$posHoriz]) && $occup[$event->getDuration()->getHour()][1][$posHoriz]);
																}
															}
															
															if (!$canPaint) $posHoriz++;
														}
														
														$width = (100/7) / $evs_same_time;
														$left = $width * $posHoriz + ((100/7) * $day_of_week) + 0.25;
														$width -= 0.2;
														
														if ($event->getStart()->getMinute() < 30) {
															$occup[$event->getStart()->getHour()][0][$posHoriz] = true;
															$occup[$event->getStart()->getHour()][1][$posHoriz] = true;
														} else {
															$occup[$event->getStart()->getHour()][1][$posHoriz] = true;
														}
														for($i = $event->getStart()->getHour()+1; $i < $event->getDuration()->getHour(); $i++) {
															$occup[$i][0][$posHoriz] = true;
															$occup[$i][1][$posHoriz] = true;
														}
														if ($event->getDuration()->getMinute() > 0) {
															$occup[$event->getDuration()->getHour()][0][$posHoriz] = true;
															if ($event->getDuration()->getMinute() > 30) {
																$occup[$event->getDuration()->getHour()][1][$posHoriz] = true;
															}
														}
														
														if ($posHoriz + 1 == $evs_same_time) $width = $width - 0.5;
														$procesados[$hr_start]++;
														//if ($procesados[$hr_start] == $horas[$hr_start]) $width = $width - 1.5;
												?>
						<div id="ev_div_<?php echo $event->getId()?>" class="chip" style="position: absolute; top: <?php echo $top?>px; left: <?php echo $left?>%; width: <?php echo $width?>%;z-index:120;"  onclick="stopPropagation(event)"
						onmouseover="quickTip('ev_div_<?php echo $event->getId()?>', '<?php echo $event->getSubject()?>', '<?php echo $event->getStart()->format('h:i') .'-'. $event->getDuration()->format('h:i') . '<br><br>' . $event->getDescription();?>','<?php echo cal_getlink("index.php?action=viewevent&amp;view=week&amp;id=".$event->getId())."&amp;user_id=".$user_filter;?>');stopPropagation(event);"
						><!-- title="<?php echo "$start_time - $end_time : " . $event->getSubject() . (trim($event->getDescription() != '' ? ' - ' . $event->getDescription() : ''))?>"-->
						
						<div class="t1 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 2px 0px 2px;height:1px;"></div>
						<div class="t2 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 1px 0px 1px;height:1px;"></div>
						<div class="chipbody edit og-wsname-color-<?php echo $ws_color?>">
						<dl class="<?php echo  $ws_class?>" style="height: <?php echo $height ?>px;<?php echo $ws_style?>">
							<dt class="<?php echo  $ws_class?>" style="<?php echo $ws_style?>">
							<table width="100%"><tr><td>
								<a
								href='<?php echo cal_getlink("index.php?action=viewevent&amp;view=week&amp;id=".$event->getId())."&amp;user_id=".$user_filter;?>'
								class='internalLink'><!-- nobr --><span style="color:<?php echo $txt_color?>!important;padding-left:5px;;font-size:93%"><?php echo "$start_time"?></span></a>
		<!-- nobr				<span class="eventheadlabel" style="color:<?php echo $txt_color?>!important;padding-left:5px;font-size:94%"><?php echo "$start_time"/*" - $end_time"*/; ?></span>-->
							</td><td align="right">
								<dd><div align="right" style="padding-right:4px;">
								<?php $invitations = $event->getInvitations(); 
								if ($invitations != null && is_array($invitations) && $invitations[$user_filter] != null) {
									$inv = $invitations[$user_filter];
									//echo "userfilter=".$user_filter."<br>val=".$invitations[$user_filter]->getInvitationState();
									if ($inv->getInvitationState() == 0) { // Not answered
										echo '<img src="' . image_url('/16x16/mail_mark_unread.png') . '"/>';
									} else if ($inv->getInvitationState() == 1) { // Assist = Yes
										echo '<img src="' . image_url('/16x16/complete.png') . '"/>';
									} else if ($inv->getInvitationState() == 2) { // Assist = No
										echo '<img src="' . image_url('/16x16/del.png') . '"/>';
									} else if ($inv->getInvitationState() == 3) { // Assist = Maybe
										echo '<img src="' . image_url('/16x16/help.png') . '"/>';
									} else {
										//echo "Not Invited";
									}
								} // if ?>
								</div></dd>
							</td></tr></table>
							</dt>
							<dd>
							<div><a
								href='<?php echo cal_getlink("index.php?action=viewevent&amp;view=week&amp;id=".$event->getId())."&amp;user_id=".$user_filter;?>'
								class='internalLink'><!-- nobr --><span style="color:<?php echo $txt_color?>!important;padding-left:5px;;font-size:93%"><?php echo $subject?></span></a>
							</div>
							</dd>
						</dl>
						</div>
						<div class="b2 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 1px 0px 1px;height:1px;">
						</div>
						<div class="b1 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 2px 0px 2px;height:1px;">
						</div>
						</div>
						<?php
													}//foreach
												?>
											</div>
										<?php
											}//day of week
										?>
										</div>
									</td>
								</tr>
							</table>
						</div><!--calowner -->															 
					<!--  </div>		 -->				
				</div><!--gridcontainer -->
				
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

<script type="text/javascript">

	function quickTip(id, title, bdy, link) {
		tt = new Ext.ToolTip({
			target: id,
	        html: bdy,
	        title: '<a href="'+link+'">'+title+'</a>',
	        showDelay: 200,
	        hideDelay: 1200,
	        minWidth: 250,
	        buttons: [{
				text: lang('view event'),
				handler: this.gotoevent,
				scope: this
			}]
	    });
	}	
  
	var ev_start_day, ev_start_month, ev_start_year, ev_start_hour, ev_start_minute;
	var ev_end_day, ev_end_month, ev_end_year, ev_end_hour, ev_end_minute;
	
	function selectStartDateTime(day, month, year, hour, minute) {
		selectDateTime(true, day, month, year, hour, minute);
	}
	
	function selectEndDateTime(day, month, year, hour, minute) {
		selectDateTime(false, day, month, year, hour, minute);
	}
	
	function selectDateTime(start, day, month, year, hour, minute) {
		if (start == true) {
			ev_start_day = day;
			ev_start_month = month; 
			ev_start_year = year; 
			ev_start_hour= hour; 
			ev_start_minute = minute; 
		} else {
			ev_end_day = day; 
			ev_end_month = month; 
			ev_end_year = year; 
			ev_end_hour = hour; 
			ev_end_minute = minute; 
		}
		
	}
	
	function getDurationMinutes() {
		var s_val = new Date();
		s_val.setFullYear(ev_start_year);
		s_val.setMonth(ev_start_month);
		s_val.setDate(ev_start_day);
		s_val.setHours(ev_start_hour);
		s_val.setMinutes(ev_start_minute);
		s_val.setSeconds(0);
		s_val.setMilliseconds(0);
		
		var e_val = new Date();
		e_val.setFullYear(ev_end_year);
		e_val.setMonth(ev_end_month);
		e_val.setDate(ev_end_day);
		e_val.setHours(ev_end_hour);
		e_val.setMinutes(ev_end_minute);
		e_val.setSeconds(0);
		e_val.setMilliseconds(0);
		
		var millis = e_val.getTime() - s_val.getTime();
		
		return ((millis / 1000) / 60); 		
	}
	
	function showEventPopup(day, month, year, hour, minute) {
		selectEndDateTime(day, month, year, hour, minute);
		var hrs = 0;
		var mins = getDurationMinutes();
		while (mins >= 60) {
			mins -= 60;
			hrs +=1;
		}
		if (hrs == 0) {
			hrs = 1;
			mins = 0;
		}

		og.EventPopUp.show(null, {day: ev_start_day,
								month: ev_start_month,
								year: ev_start_year,
								hour: ev_start_hour,
								minute: ev_start_minute,
								durationhour: hrs,
								durationmin: mins,
								start_value: ev_start_month + '/' + ev_start_day + '/' + ev_start_year,
								type_id:1, view:'week', title: lang('add event')
								}, '');
	}
</script>

