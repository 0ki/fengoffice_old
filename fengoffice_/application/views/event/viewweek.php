<?php
define('PX_HEIGHT',42);
$year = isset($_GET['year'])?$_GET['year']:$_SESSION['cal_year'];
$month = isset($_GET['month'])?$_GET['month']:$_SESSION['cal_month'];
$day = isset($_GET['day'])?$_GET['day']:$_SESSION['cal_day'];
$tags = active_tag();	
?>
<?php echo stylesheet_tag('event/week.css') ?>
<?php
	$startday = date("d",mktime(0,0,0,$month,$day,$year)) - (date("N", mktime(0,0,0,$month,$day,$year)) %7);//inicio de la semana
	$endday = $startday +7;//fin de la semana
	$currentday = date("j");
	$currentmonth = date("n");
	$currentyear = date("Y");
	$lastday = date("t", mktime(0,0,0,$month,1,$year)); // # of days in the month
	
	
	$date_start = new DateTimeValue(mktime(0,0,0,$month,$startday,$year)); 
	$date_end = new DateTimeValue(mktime(0,0,0,$month,$endday,$year)); 
	
	
	
	$milestones = ProjectMilestones::getRangeMilestonesByUser($date_start,$date_end,logged_user(), $tags, active_project());
	$tasks = ProjectTasks::getRangeTasksByUser($date_start,$date_end,logged_user(), $tags, active_project());
	
	//$day_events = array();
	$dates = array();//datetimevalye for each day of week
	$results = array();
	$allday_events_count=array();
	$alldayevents = array();
	$today_style = array();
	
	for ($day_of_week = 0; $day_of_week < 7; $day_of_week++) {	
		
		$day_of_month = $day_of_week + $startday;
		if($day_of_month <= $lastday AND $day_of_month >= 1){ 								
			$w = $day_of_month;
		}elseif($day_of_month < 1){								
			$w = $day_of_month;
		}else{
			if($day_of_month==$lastday+1){
				$month++;
				if($month==13){
					$month = 1;
					$year++;
				}
			}
			$w = $day_of_month - $lastday;
		}	
		
		$day_tmp = (isset($w) && is_numeric($w)) ? $w : 0;
	
		$dates[$day_of_week] = new DateTimeValue(mktime(0,0,0,$month,$day_tmp,$year)); 
		
		$today_style[$day_of_week] = '';
		if($currentyear == $year && $currentmonth == $month && $currentday == $day_of_month){
		  $today_style[$day_of_week] = 'background-color:#FFFFCC;';
		}
		
		
		$results[$day_of_week] = ProjectEvents::getDayProjectEvents($dates[$day_of_week], $tags, active_project()); 
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
		$allday_events_count[$day_of_week]=  count(array_var($alldayevents,$day_of_week,array()));
	}
	
	$max_events = max($allday_events_count)==0?1:max($allday_events_count);
	$alldaygridHeight = $max_events*PX_HEIGHT/2 + PX_HEIGHT/2;//Day events container height= all the events plus an extra free space
	
	
?>
<div class="calendar" style="padding:7px;height:100%" id="cal_main_div">
<table style="width:100%;height:95%">
<tr>
<td>
	<table style="width:100%">
	<col width=12/>
	<col/>
	<col width=12/>
	<tr>
	<td class="coViewHeader" colspan=2  rowspan=2>
	<div class="coViewTitle">				
		<span id="chead0"><?php echo  date('j/n',mktime(0, 0, 0, $month, $startday, $year)) ." - ".date('j/n',mktime(0, 0, 0, $month, $endday, $year)) ?></span>	
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
									<a class="internalLink" href="<?php echo $p; ?>"  onclick="stopPropagation(event) "><?php echo date("D j/n", mktime(0, 0, 0, $dtv_temp->getMonth(), $dtv_temp->getDay(), $dtv_temp->getYear())); //date("D j/n", mktime(0, 0, 0, $month, $w, $year)); ?></a>
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
												cal_get_ws_color($ws_color, $ws_style, $ws_class, $txt_color);
								?>
								<div class="adc" style="left:  6%; top: <?php echo $top ?>px; z-index: 5;width: 90%;margin:1px;position:absolute;">
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
												if ($hour % 2 ==0){
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
<div id="h<?php echo $day_of_week."_".$hour?>" style="left:<?php echo $left ?>%;width:<?php echo $width_percent ?>%;top: <?php echo $top?>px; z-index: 100; height:20px;position:absolute;<?php echo $today_style[$day_of_week] ?>" 
onclick="og.EventPopUp.show(null, {day:'<?php echo $date->getDay() ?>',	month:'<?php echo $date->getMonth()?>',year:'<?php echo $date->getYear()?>',hour:'<?php echo date("G",mktime($hour/2))?>',minute:'<?php echo ($hour % 2 ==0)?0:30?>',type_id:1,view:'week',title:'<?php echo date("l, F j",  mktime(0, 0, 0, $date->getMonth(), $date->getDay(), $date->getYear()))?>'},'');"></div>
<?php
												}
																					
										?>		
												<div id="vd<?php echo $day_of_week ?>" style="left: <?php echo $left ?>%; height: <?php echo (PX_HEIGHT)*24 ?>px;border-left:3px double #DDDDDD !important; position:absolute;width:3px;z-index:110;"></div>
												<div id="eventowner" style="z-index: 102;" onclick="stopPropagation(event) ">
												<?php	
													foreach ($results[$day_of_week] as $event){
														for($i=$event->getStart()->getHour();$i<= $event->getDuration()->getHour();$i++){
															$horas[$i]++;
														}
													}
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
														$height = $bottom-$top - 4; //substract 4px for the rounded corners
														
														
														$width = (100/7) / $horas[$hr_start];
														$left =  ((100/7) / $horas[$hr_start])*$procesados[$hr_start] + ((100/7)*$day_of_week) + 0.25;
														$procesados[$hr_start]++;
														if ($procesados[$hr_start] == $horas[$hr_start]) $width = $width- 1.5;
												?>
						<div class="chip" style="position: absolute; top: <?php echo $top?>px; left: <?php echo $left?>%; width: <?php echo $width?>%;z-index:120;"  onclick="stopPropagation(event)">
						<div class="t1 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 2px 0px 2px"></div>
						<div class="t2 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>;margin:0px 1px 0px 1px"></div>
						<div class="chipbody edit og-wsname-color-<?php echo  $ws_color?>">
						<dl class="<?php echo  $ws_class?>" style="height: <?php echo $height ?>px;<?php echo  $ws_style?>">
							<dt class="<?php echo  $ws_class?>" style="<?php echo  $ws_style?>">
							<nobr class="eventheadlabel" style="color:<?php echo  $txt_color?>!important;padding-left:5px;font-size:94%"><?php echo "$start_time - $end_time"; ?></nobr>
							</dt>
							<dd>
							<div><a
								href='<?php echo cal_getlink("index.php?action=viewevent&amp;view=week&amp;id=".$event->getId())?>'
								class='internalLink'><nobr style="color:<?php echo  $txt_color?>!important;padding-left:5px;;font-size:93%"><?php echo $subject?></nobr></a>
							</div>
							</dd>
						</dl>
						</div>
						<div class="b2 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>">
						</div>
						<div class="b1 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>">
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
			<tr><td class="coViewBottomLeft"></td>
			<td class="coViewBottom"></td>
			<td class="coViewBottomRight"></td></tr>
		</table>
	</td>
	<!-- Actions Panel -->
	<td style="width:200px; padding-left:10px">
		<table>
			<colgroup><col width=12/><col width=176/><col width=12/></colgroup>
			<tr><td class="coViewHeader" colspan=2 rowspan=2><div class="coViewPropertiesHeader"><?php echo lang("actions") ?></div></td>
			<td class="coViewTopRight" ></td></tr>
				
			<tr><td class="coViewRight" rowspan=2></td></tr>
			<tr><td class="coViewBody"  colspan=2>
				<?php if(count(PageActions::instance()->getActions()) > 0 ) {?>
					<div>
					<?php
						$pactions = PageActions::instance()->getActions();
						foreach ($pactions as $action) { 
							if ($action->getTarget() != '') {
							?>
							<a style="display:block" class="coViewAction <?php echo $action->getName()?>" href="<?php echo $action->getURL()?>" target="<?php echo $action->getTarget()?>">
							<?php } else { ?>
							<a style="display:block" class="internalLink coViewAction <?php echo $action->getName()?>" href="<?php echo $action->getURL()?>">
						<?php } echo $action->getTitle() ?></a>
					<?php } ?>
					</div>
				<?php } ?>
			
			</td></tr>
			
			<tr><td class="coViewBottomLeft"></td>
			<td class="coViewBottom"></td>
			<td class="coViewBottomRight"></td></tr>
		</table>
	
	
		<table>
			<col width=12/><col width=176/><col width=12/>
			<tr><td class="coViewHeader" colspan=2 rowspan=2><div class="coViewPropertiesHeader"><?php echo lang("pick a date") ?></div></td>
			<td class="coViewTopRight"></td></tr>
				
			<tr><td class="coViewRight" rowspan=2></td></tr>
			<tr><td class="coViewBody" colspan=2>
				<div align="center" id="datepicker">
				
				</div><p style="clear: both;"><!-- See day-by-day example for highlighting days code --></p>
			</td></tr>
			
			<tr><td class="coViewBottomLeft"></td>
			<td class="coViewBottom"></td>
			<td class="coViewBottomRight"></td></tr>
		</table>

	</td>
</tr></table>
</div>
<script type="text/javascript">
	jQuery.noConflict();//YUI redefines $, so we need to set jQuery to non-conflict mode	
	
	jQuery(document).ready(function() {
		jQuery("#datepicker").datepicker({ 
			defaultDate: new Date(<?php echo $year?>, <?php echo $month - 1?>, <?php echo $day?>),
		    onSelect: function(date) { 
		    	var s = date.split("/");
		    	og.openLink(og.getUrl('event', 'viewdate', {day:s[1] , month:s[0], year: s[2]}), null);
		    } 
		});		
		document.getElementById('curr_hour').scrollIntoView(true);
		//Ext.getCmp('calendar-tb').setActiveDate({day:'<?php echo $day ?>',	month:'<?php echo $month?>',year:'<?php echo $year ?>'});	
	})
	
	//jQuery("#grid").click(function(e){ var x = e.pageX - this.offsetLeft; var y = e.pageY - this.offsetTop; alert(x +', '+ y); }); 

</script>