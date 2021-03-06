<script type="text/javascript">
	scroll_to = -1;
	showCalendarToolbar();	
</script>

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
$state_filter = isset($_GET['state_filter']) ? $_GET['state_filter'] : ' 0 1 3'; 

$user = Users::findById(array('id' => $user_filter));
/*
 * If user does not exists, assign logged_user() to $user 
 * to prevent null exception when calling getRangeTasksByUser(), because this func. expects an User instance.
 */
if ($user == null) $user = logged_user();

$use_24_hours = config_option('time_format_use_24');

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
<div class="calendar" style="padding:0px;height:100%;overflow:hidden;" id="cal_main_div" onmouseup="clearPaintedCells();">
<table style="width:100%;height:100%;">
<tr>
<td>
	<table style="width:100%;height:100%;">
		<tr>
			<td class="coViewHeader" id='cal_coViewHeader' colspan=2  rowspan=1>
				<div class="coViewTitle">				
					<span id="chead0"><?php $dtime = mktime(0, 0, 0, $month, $day, $year); echo lang(strtolower(date('l', $dtime))) . date(' j, ', $dtime) . lang('month ' . date('n', $dtime)) . date(' Y', $dtime)
					.' - '. ($user_filter == -1 ? lang('all users') : lang('calendar of', clean($user->getDisplayName()))); ?></span>	
				</div>
			</td>
		</tr>
		
		<tr>
			<td class="coViewBody" style="padding:0px;height:100%;" colspan=2>
			<div id="chrome_main2" class="printborder" style="border-color: rgb(195, 217, 255); background: rgb(195, 217, 255) none repeat scroll 0% 50%; width:100%; height:100%;">
					
				<div id="allDayGrid" class="inset grid"  style="height: <?php echo $alldaygridHeight ?>px; margin-bottom: 5px;background:#E8EEF7;margin-right:0px;margin-left:40px;" 
					onclick="showEventPopup(<?php echo $dtv->getDay() ?>, <?php echo $dtv->getMonth()?>, <?php echo $dtv->getYear()?>, -1, -1, <?php echo ($use_24_hours ? 'true' : 'false'); ?>);" >
					
					<div id="allDay0" class="allDayCell" style="left: 0px; height: <?php echo $alldaygridHeight ?>px;border-left:3px double #DDDDDD !important; position:absolute;width:3px;"></div>
					<div id="alldayeventowner" onclick="stopPropagation(event) ">
						<?php	
							$top=0;
							foreach ($alldayevents as $event){	
								$tipBody = '';
								$divtype = '';
								$div_prefix = '';
								if ($event instanceof ProjectMilestone ){
									$div_prefix = 'd_ms_div_';
									$subject = clean($event->getName());
									$img_url = image_url('/16x16/milestone.png');
									$divtype = '<i>' . lang('milestone') . '</i> - ';
									$tipBody = lang('assigned to') .': '. clean($event->getAssignedToName()) . (trim(clean($event->getDescription())) != '' ? '<br><br>' . clean($event->getDescription()) : '');
								}elseif ($event instanceof ProjectTask){
									$div_prefix = 'd_ta_div_';
									$subject =$event->getTitle();
									$img_url = image_url('/16x16/tasks.png');
									$divtype = '<i>' . lang('task') . '</i> - ';
									$tipBody = lang('assigned to') .': '. clean($event->getAssignedToName()) . (trim(clean($event->getText())) != '' ? '<br><br>' . clean($event->getText()) : '');
								}elseif ($event instanceof ProjectEvent){
									$div_prefix = 'd_ev_div_';
									$subject = clean($event->getSubject());
									$img_url = image_url('/16x16/calendar.png');
									$divtype = '<i>' . lang('event') . '</i> - ';
									$tipBody = (trim(clean($event->getDescription())) != '' ? '<br>' . clean($event->getDescription()) : '');									
								}
								$tipBody = str_replace("\r", '', $tipBody);
								$tipBody = str_replace("\n", '<br>', $tipBody);
								if (strlen($tipBody) > 200) $tipBody = substr($tipBody, 0, strpos($tipBody, ' ', 200)) . ' ...';
								
								$dws = $event->getWorkspaces();
								$ws_color = 0;
								if (count($dws) >= 1){
									$ws_color = $dws[0]->getColor();
								}
								cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color, $border_color);	
														
						?>
						<div id="<?php echo $div_prefix . $event->getId() ?>" class="adc" style="left: 3px; top: <?php echo $top ?>px; z-index: 5;width: 99%;margin:1px;">
							<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 1px 0px 1px;height:0px; border-bottom:1px solid; border-color:<?php echo $border_color ?>"></div>
							<div class="noleft <?php echo  $ws_class?>" style="<?php echo  $ws_style?>; border-left:1px solid; border-right:1px solid; border-color:<?php echo $border_color ?>">							
								<div class="" style="overflow: hidden; padding-bottom: 1px;">
								
									<nobr style="display: block; text-decoration: none;"><a href='<?php echo $event->getViewUrl()?>' class='internalLink' onclick="stopPropagation(event);hideCalendarToolbar();"><img src="<?php echo $img_url?>" align='absmiddle' border='0'> <span style="color:<?php echo $txt_color ?>!important"><?php echo $subject ?></span> </a></nobr>
								
								</div>
							</div>
							<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 1px 0px 1px;height:0px; border-top:1px solid; border-color:<?php echo $border_color ?>"></div>
						</div>
						<script type="text/javascript">
							addTip('<?php echo $div_prefix . $event->getId() ?>', <?php echo json_encode($divtype . $subject) ?>, <?php echo json_encode($tipBody) ?>);
						</script>
						<?php
								$top += 20;	
							}
						?>
					</div>
				</div>
				<div id="gridcontainer" style="background-color:#fff; overflow-x:hidden; overflow-y:scroll; height:504px; position:relative;" >	
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
												<div class="rheadtext" style="text-align:right;padding-right:2px;"><?php echo date($use_24_hours ? "G:i" : "g a", mktime($hour, 0)) ?></div>
											</div>												
										<?php
											}
										?>

										</div>
									</td>
									<td id="gridcontainercell" style="width: auto;position:relative;" >	
										<div id="grid" style="height: 100%;background-color:#fff;position:relative;" class="grid">										
											<div id="decowner">
												
											</div>
											
											<?php
												for ($hour=0; $hour<=47; $hour++){	
													if ($hour % 2 == 0){
														$parity = "hruleeven";
														$style="border-top:1px solid #DDDDDD;";
													} else {
														$parity="hruleodd";
														$style="border-top:1px dotted #DDDDDD;";
													}
													$top = (PX_HEIGHT/2) * $hour;
													$div_id = 'h0_'.$hour;
											?>
													<div id="r<?php echo $hour?>"" class="hrule <?php echo $parity?>" style="top: <?php echo $top?>px; height:1px; z-index:101;position:absolute;left:0px;<?php echo $style?>;width:100%"></div>

													<div id="<?php echo $div_id?>" style="<?php echo $style ?>;width:100%;top: <?php echo $top?>px; z-index: 100; height:21px;position:absolute; border-left:3px double #DDDDDD;" 
														onmouseover="if (!selectingCells) overCell('<?php echo $div_id?>'); else paintSelectedCells('<?php echo $div_id?>');"
														onmouseout="if (!selectingCells) resetCell('<?php echo $div_id?>')";
														onmousedown="selectStartDateTime(<?php echo $dtv->getDay() ?>, <?php echo $dtv->getMonth()?>, <?php echo $dtv->getYear()?>, <?php echo date("G",mktime($hour/2))?>, <?php echo ($hour % 2 ==0)?0:30 ?>); resetCell('<?php echo $div_id?>'); paintingDay=0; paintSelectedCells('<?php echo $div_id?>');"
														onmouseup="showEventPopup(<?php echo $dtv->getDay() ?>, <?php echo $dtv->getMonth()?>, <?php echo $dtv->getYear()?>, <?php echo date("G",mktime(($hour+1)/2))?>, <?php echo (($hour+1) % 2 ==0)?0:30 ?>, <?php echo ($use_24_hours ? 'true' : 'false'); ?>);"></div>
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
												$event->getDuration()->add('s', -1);
												if ($event->getStart()->getMinute() < 30) {
													$cells[$event->getStart()->getHour()][0]++;
													$cells[$event->getStart()->getHour()][1]++;
												} else $cells[$event->getStart()->getHour()][1]++;
												for($i = $event->getStart()->getHour()+1; $i < $event->getDuration()->getHour(); $i++){
													$cells[$i][0]++;
													$cells[$i][1]++;
												}
												if ($event->getDuration()->getMinute() > 0) {
													if ($event->getDuration()->getHour() != $event->getStart()->getHour()) {
														$cells[$event->getDuration()->getHour()][0]++;
														if ($event->getDuration()->getMinute() > 30) $cells[$event->getDuration()->getHour()][1]++;
													}
												}
											}
											$occup = array(); //keys: hora - pos
											foreach ($result as $event){
												$event_id = $event->getId();
												$subject = clean($event->getSubject());
												$dws = $event->getWorkspaces();
												$ws_color = 0;
												
												if (count($dws) >= 1){
													$ws_color = $dws[0]->getColor();
												}	
												
												cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color, $border_color);
												
												if($use_24_hours) $timeformat = 'G:i';
												else $timeformat = 'g:i A';
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
												$height = $bottom-$top - 4; //substract 4px for the rounded corners - 1px for separation
												
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
												
												$event->getDuration()->add('s', 1);
												$end_time = date($timeformat, $event->getDuration()->getTimestamp());
												$ev_duration = DateTimeValueLib::get_time_difference($event->getStart()->getTimestamp(), $event->getDuration()->getTimestamp()); 

												$tipBody = $event->getStart()->format($use_24_hours ? 'G:i' : 'g:i A') .' - '. $event->getDuration()->format($use_24_hours ? 'G:i' : 'g:i A') . (trim(clean($event->getDescription())) != '' ? '<br><br>' . clean($event->getDescription()) : '');
												$tipBody = str_replace(array("\r", "\n"), array(' ', '<br>'), $tipBody);
												if (strlen($tipBody) > 200) $tipBody = substr($tipBody, 0, strpos($tipBody, ' ', 200)) . ' ...';
										?>
												<script type="text/javascript">
													if (<?php echo $top; ?> < scroll_to || scroll_to == -1) {
														scroll_to = <?php echo $top;?>;
													}
													addTip('d_ev_div_' + <?php echo $event->getId() ?>, <?php echo json_encode(clean($event->getSubject())) ?>, <?php echo json_encode($tipBody); ?>);
												</script>
												
												<div id="d_ev_div_<?php echo $event->getId()?>" class="chip" style="position: absolute; top: <?php echo $top?>px; left: <?php echo $left?>%; width: <?php echo $width?>%;z-index:120;"  onclick="stopPropagation(event)">
													<div class="t1 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 2px 0px 2px;height:0px; border-bottom:1px solid;border-color:<?php echo $border_color ?>"></div>
													<div class="t2 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 1px 0px 1px;height:1px; border-left:1px solid;border-right:1px solid;border-color:<?php echo $border_color ?>"></div>
													<div class="chipbody edit og-wsname-color-<?php echo  $ws_color?>">
														<dl class="<?php echo  $ws_class?>" style="height: <?php echo $height ?>px;<?php echo  $ws_style?>;border-left:1px solid;border-right:1px solid;border-color:<?php echo $border_color ?>">
															<dt class="<?php echo  $ws_class?>" style="<?php echo  $ws_style?>;">
																<table width="100%"><tr><td>
																	<a href='<?php echo $event->getViewUrl()."&amp;view=day&amp;user_id=".$user_filter ?>' class='internalLink' onclick="hideCalendarToolbar();" >
																	<span class="eventheadlabel" style="color:<?php echo $txt_color?>!important;padding-left:5px;"><?php echo "$start_time - $end_time"; ?></span>
																	</a>
																	<?php
																	if ($ev_duration['hours'] == 0) { ?>
																		-<a href='<?php echo $event->getViewUrl()."&amp;view=day&amp;user_id=".$user_filter ?>' class='internalLink' ><span style="color:<?php echo $txt_color?>!important;padding-left:5px;"><?php echo $subject?></span></a>
																	<?php } //if ?>
																</td><td align="right">
																<dd><div align="right" style="padding-right:4px;<?php echo ($ev_duration['hours'] == 0 ? 'height:'.$height.'px;' : '') ?>">
																<?php $invitations = $event->getInvitations(); 
																if ($invitations != null && is_array($invitations) && $invitations[$user_filter] != null) {
																	$inv = $invitations[$user_filter];
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
															<?php
															if ($ev_duration['hours'] > 0) { ?>
															<dd>
																<div>
																	<a href='<?php echo $event->getViewUrl()."&amp;view=day&amp;user_id=".$user_filter ?>' onclick="hideCalendarToolbar();" class='internalLink' ><span style="color:<?php echo $txt_color?>!important;padding-left:5px;"><?php echo $subject?></span></a>
																</div>
															</dd>
															<?php } //if ?>
														</dl>
													</div>
													<div class="b2 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 1px 0px 1px;height:1px; border-left:1px solid;border-right:1px solid; border-color:<?php echo $border_color ?>"> </div>
													<div class="b1 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>;margin:0px 2px 0px 2px;height:0px; border-top:1px solid; border-color:<?php echo $border_color ?>"> </div>
												</div>
										<?php
											}
										?>
											</div>
										</div>
									</td>
									<td id="ie_scrollbar_adjust" style="width:0px;"></td>
								</tr>
							</table>
						</div><!--calowner -->															 
				</div><!--gridcontainer -->
			</div>		
			
			</td>
			</tr>
		</table>
	</td>
</tr></table>
</div>

<?php
	$wdst = config_option('work_day_start_time', '09:00');
	$h_m = explode(':', $wdst);
	if (str_ends_with($wdst, 'PM')) {
		$h_m[0] = ($h_m[0] + 12) % 24;
		$h_m[1] = substr($h_m[1], 0 , strpos(' ', $h_m[1]));
	}
	$defaultScrollTo = PX_HEIGHT * ($h_m[0] + ($h_m[1] / 60));
	
 ?>
 
<script type="text/javascript">
	
	// scroll to first event
	var scroll_pos = (scroll_to == -1 ? <?php echo $defaultScrollTo ?> : scroll_to);
	Ext.get('gridcontainer').scrollTo('top', scroll_pos, true);
	
	if (Ext.isIE) document.getElementById('ie_scrollbar_adjust').style.width = '15px';
	
	// resize grid
	function resizeGridContainer() {
		maindiv = document.getElementById('cal_main_div');
		if (maindiv != null) {
			var divHeight = maindiv.offsetHeight;
			divHeight = divHeight - <?php echo (PX_HEIGHT + $alldaygridHeight); ?>;
			document.getElementById('gridcontainer').style.height = divHeight + 'px';
		}
	}
	resizeGridContainer();
	window.onresize = resizeGridContainer;
	
	// init tooltips
	Ext.QuickTips.init();
		
</script>