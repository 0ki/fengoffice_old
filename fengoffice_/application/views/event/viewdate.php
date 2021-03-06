<?php
define('PX_HEIGHT',42);
$year = isset($_GET['year']) ? $_GET['year'] : (isset($_SESSION['year']) ? $_SESSION['year'] : date('Y'));
$month = isset($_GET['month']) ? $_GET['month'] : (isset($_SESSION['month']) ? $_SESSION['month'] : date('n'));
$day = isset($_GET['day']) ? $_GET['day'] : (isset($_SESSION['day']) ? $_SESSION['day'] : date('j'));

$_SESSION['year'] = $year;
$_SESSION['month'] = $month;
$_SESSION['day'] = $day;

$tags = active_tag();	

$user_filter = !isset($_GET['user_filter']) || $_GET['user_filter'] == 0 ? logged_user()->getId() : $_GET['user_filter'];
$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : -1; 

$user = Users::findById(array('id' => $user_filter));

?>
<?php echo stylesheet_tag('event/day.css') ?>

<?php
	$currentday = date("j");
	$currentmonth = date("n");
	$currentyear = date("Y");
	
	$today_style = '';
	if($currentyear == $year && $currentmonth == $month && $currentday == $day){
	  $today_style = 'background-color:#FFFFCC;';
	}
	
	$date = new DateTimeValue(mktime(0,0,0,$month,$day,$year)); 
	$end_date = new DateTimeValue(mktime(0,0,0,$month,$day,$year));
	$result = ProjectEvents::getDayProjectEvents($date, $tags, active_project(), $user_filter, $state_filter); 
	if(!$result) $result = array();	
	
	
	$alldayevents = array();
	$milestones = ProjectMilestones::getRangeMilestonesByUser($date,$end_date,logged_user(), $tags, active_project());	
	$tasks = ProjectTasks::getRangeTasksByUser($date, $end_date, $user, $tags, active_project());
	
	foreach ($result as $key => $event){
		if ($event->getTypeId()> 1){
			$alldayevents[] = $event;
			unset($result[$key]);
		}
	}
	
	if($milestones)
		$alldayevents = array_merge($alldayevents,$milestones);
	if($tasks)
		$alldayevents = array_merge($alldayevents,$tasks);	
	
	$alldaygridHeight = count($alldayevents)*PX_HEIGHT/2 + PX_HEIGHT/3;
	$dtv = DateTimeValueLib::make(0,0,0,$month,$day,$year);
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
			<td class="coViewHeader" id='cal_coViewHeader' colspan=2  rowspan=2>
				<div class="coViewTitle">				
					<span id="chead0"><?php $dtime = mktime(0, 0, 0, $month, $day, $year); echo lang(strtolower(date('l', $dtime))) . date(' j, ', $dtime) . lang('month ' . date('n', $dtime)) . date(' Y', $dtime)
					.' - '. ($user_filter == -1 ? lang('all users') : lang('calendar of', $user->getDisplayName())); ?></span>	
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
					
				<div id="allDayGrid" class="inset grid"  style="height: <?php echo $alldaygridHeight ?>px; margin-bottom: 5px;background:#E8EEF7;margin-right:0px;margin-left:40px;" 
					onclick="og.EventPopUp.show(null, {day:'<?php echo $dtv->getDay() ?>',	month:'<?php echo $dtv->getMonth()?>',year:'<?php echo $dtv->getYear()?>',view:'day',type_id:2,title:'<?php echo date("l, F j",  mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear()))?>'},'');" >
					
					<div id="allDay0" class="allDayCell" style="left: 0px; height: <?php echo $alldaygridHeight ?>px;border-left:3px double #DDDDDD !important; position:absolute;width:3px;"></div>
					<div id="alldayeventowner" onclick="stopPropagation(event) ">
						<?php	
							$top=0;
							foreach ($alldayevents as $event){	
								
							
								if ($event instanceof ProjectMilestone ){									
									$subject =$event->getName();
									$img_url = image_url('/16x16/milestone.png');
								}elseif ($event instanceof ProjectTask){
									$subject =$event->getTitle();
									$img_url = image_url('/16x16/tasks.png');
								}elseif ($event instanceof ProjectEvent){
									$subject =$event->getSubject();
									$img_url = image_url('/16x16/calendar.png');
								}
								$dws = $event->getWorkspaces();
								$ws_color = 0;
								if (count($dws) >= 1){
									$ws_color = $dws[0]->getColor();
								}
								cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color);	
														
						?>
						<div class="adc" style="left: 3px; top: <?php echo $top ?>px; z-index: 5;width: 99%;margin:1px;">
							<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"></div>
							<div class="noleft <?php echo  $ws_class?>" style="<?php echo  $ws_style?>">							
								<div class="" style="overflow: hidden; padding-bottom: 1px;">
								
									<nobr style="display: block; text-decoration: none;"><a href='<?php echo $event->getViewUrl()?>' class='internalLink' "><img src="<?php echo $img_url?>" align='absmiddle' border='0'> <span style="color:<?php echo $txt_color ?>!important"><?php echo $subject ?></span> </a></nobr>
								
								</div>
							</div>
							<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"></div>
						</div>
						<?php
								$top += 20;	
							}
						?>
					</div>
				</div>					
				<div id="gridcontainer" style="background-color:#fff;height: 1008px;overflow:hidden; position:relative;" >	
					<!-- <div class='grid_bg' style="background-image: url(public/assets/themes/default/images/Calendar_BG.gif);background-repeat: repeat;background-color:#ffffff;height:1024px;"> -->
						<div id='calowner' style="display:block; width:100%;">  
							<table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed; width: 100%;height: 1008px;">
								<tr>
									<td id="rowheadcell" style="width: 40px;">
										<div id="rowheaders" style="height: 1008px; top: 0pt; left: 0pt;">										
										<?php
											$horas = array();
											$curr_hour = date("H");
											for ($hour=0; $hour<=23; $hour++){	
												$horas[$hour]	= 0;
												$procesados[$hour] = 0;
										?>
											<div style="height: 41px; top: 0ex;border-right:3px double #DDDDDD !important;background: #E8EEF7 none repeat scroll 0%;border-top:1px solid #DDDDDD;left:0pt;width: 100%;" id="rhead<?php echo $hour?>" class="rhead">
												<?php
													$hour == $curr_hour? print("<span id='curr_hour' style='visibility:hidden;height:0px;width:0px'></span>"):print('');
												?>
												<div class="rheadtext"><?php echo date("ga",mktime($hour)) ?></div>
											</div>												
										<?php
											}
										?>

										</div>
									</td>
									<td id="gridcontainercell" style="width: auto;position:relative;<?php echo $today_style ?>" >	
										<div id="grid" style="height: 100%;background-color:#fff;position:relative;" class="grid">										
											<div id="decowner">
												
											</div>
											
											<?php
												for ($hour=0; $hour<=47; $hour++){	
													if ($hour % 2 ==0){
														$parity = "hruleeven";
														$style="border-top:1px solid #DDDDDD;";
													} else {
														$parity="hruleodd";
														$style="border-top:1px dotted #DDDDDD;";
													}
													$top = (PX_HEIGHT/2) * $hour;
											?>
													<div id="r<?php echo $hour?>"" class="hrule <?php echo $parity?>" style="top: <?php echo $top?>px; z-index: 0;position:absolute;left:0px;<?php echo $style?>;width:100%"></div>
													<div id="h<?php echo $hour?>"" style="width:100%;top: <?php echo $top?>px; z-index: 100; height:20px;position:absolute;" 
														onmousedown="selectStartDateTime(<?php echo $dtv->getDay() ?>, <?php echo $dtv->getMonth()?>, <?php echo $dtv->getYear()?>, <?php echo date("G",mktime($hour/2))?>, <?php echo ($hour % 2 ==0)?0:30 ?>);"
														onmouseup="showEventPopup(<?php echo $dtv->getDay() ?>, <?php echo $dtv->getMonth()?>, <?php echo $dtv->getYear()?>, <?php echo date("G",mktime($hour/2))?>, <?php echo ($hour % 2 ==0)?0:30 ?>);"></div>
													<!--
													onclick="og.EventPopUp.show(null, {day:'<?php echo $dtv->getDay() ?>',	month:'<?php echo $dtv->getMonth()?>',year:'<?php echo $dtv->getYear()?>',hour:'<?php echo date("G",mktime($hour/2))?>',minute:'<?php echo ($hour % 2 ==0)?0:30?>',type_id:1,view:'day',title:'<?php echo date("l, F j",  mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear())) ?>'},'');"></div>-->
													
											<?php
												}
											?>
											
											<div id="eventowner" style="z-index: 102;" onclick="stopPropagation(event) ">
										<?php	
											$cells = array();
											for ($i = 0; $i < 24; $i++) {
												$cells[$i][0] = 0;
												$cells[$i][1] = 0;
											}
											foreach ($result as $event){
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
											foreach ($result as $event){
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
												$height = $bottom-$top - 5; //substract 4px for the rounded corners - 1px for separation
												
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
												
												$width = 100 / $evs_same_time;
												$left = $width * $posHoriz + 0.25;
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
												
												if ($posHoriz+1 == $evs_same_time) $width = $width - 0.75;
												$procesados[$hr_start]++;
												//if ($procesados[$hr_start] == $horas[$hr_start]) $width = $width- 1.5;
										?>	
												<div id="ev_div_<?php echo $event->getId()?>" class="chip" style="position: absolute; top: <?php echo $top?>px; left: <?php echo $left?>%; width: <?php echo $width?>%;z-index:120;"  onclick="stopPropagation(event)" 
												onmouseover="quickTip('ev_div_<?php echo $event->getId()?>', '<?php echo $event->getSubject()?>', '<?php echo $event->getStart()->format('h:i') .'-'. $event->getDuration()->format('h:i') . '<br><br>' . $event->getDescription();?>');stopPropagation(event);">
												<!-- title="<?php echo "$start_time - $end_time : " . $event->getSubject()?>"> -->
													<div class="t1 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 2px 0px 2px;height:1px;"></div>
													<div class="t2 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 1px 0px 1px;height:1px;"></div>
													<div class="chipbody edit og-wsname-color-<?php echo  $ws_color?>">
														<dl class="<?php echo  $ws_class?>" style="height: <?php echo $height ?>px;<?php echo  $ws_style?>;">
															<dt class="<?php echo  $ws_class?>" style="<?php echo  $ws_style?>">
																<table width="100%"><tr><td>
																	<a href='<?php echo $event->getViewUrl()."&amp;view=day&amp;user_id=".$user_filter ?>' class='internalLink' >
																	<span class="eventheadlabel" style="color:<?php echo $txt_color?>!important;padding-left:5px;"><?php echo "$start_time - $end_time"; ?></span>
																	</a>
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
																<div>
																	<a href='<?php echo $event->getViewUrl()."&amp;view=day&amp;user_id=".$user_filter ?>' class='internalLink' ><span style="color:<?php echo $txt_color?>!important;padding-left:5px;"><?php echo $subject?></span></a>
																</div>
															</dd>
														</dl>
													</div>
													<div class="b2 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 1px 0px 1px;height:1px;"> </div>
													<div class="b1 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 2px 0px 2px;height:1px;"> </div>
												</div>
										<?php
											}
										?>
											</div>
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

	function quickTip(id, title, body) {
		var tt = new Ext.ToolTip({
			target: id,
	        html: body,
	        title: title,
	        showDelay: 200,
	        hideDelay: 1200,
	        minWidth: 250
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