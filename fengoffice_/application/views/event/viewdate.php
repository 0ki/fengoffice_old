<?php
define('PX_HEIGHT',42);
$year = isset($_GET['year'])?$_GET['year']:$_SESSION['cal_year'];
$month = isset($_GET['month'])?$_GET['month']:$_SESSION['cal_month'];
$day = isset($_GET['day'])?$_GET['day']:$_SESSION['cal_day'];
$tags = active_tag();	
	
?>

<style type="text/css">
.rhead {
	background: #E8EEF7 none repeat scroll 0%;
	border-top:1px solid #DDDDDD;
	left:0pt;
	width: 100%;
}
.rheadtext {
	color:#446688;
	padding-right:4px;
	text-align:right;
}
div.grid {
	background:#FFFFFF none repeat scroll 0%;
	cursor:default;
	position:relative;
}

.grid_bg {
	position:absolute; top:25; left:0; width:100%;border:2px;
	background-image: url(public/assets/themes/default/images/Calendar_BG.gif);	
	background-repeat: repeat;
	background-color:#ffffff;
	height:1024px;
}

.colheadersmiddle {
	margin-left:40px;
	margin-right:16px;
}
.chead {
	text-align:center;
	position:absolute;
}
.cheadToday {
	background:#455678 none repeat scroll 0% 0%;
	border-color:#6786A7 rgb(170, 204, 238) rgb(170, 204, 238) rgb(103, 134, 167);
	border-style:solid;
	border-width:1px;
	font-weight:bold;
	color: #fff;
}
.allDayCell {
	border-left:3px double #DDDDDD !important;
	position:absolute;
	width:3px;
}


div.inset {
	border-color:#A2BBDD rgb(255, 255, 255) rgb(255, 255, 255) rgb(162, 187, 221);
	border-style:solid;
	border-width:1px;
}

.chip {
	cursor:default;
	font-size:85%;
	overflow:hidden;
}
.chip .chipbody {
	color:#FFFFFF;
	overflow:hidden;
	position:relative;
	width:100%;
}
.t1 {
	font-size:1px;
	height:1px;
	line-height:1px;
	margin-top:0pt;
	margin-bottom:0pt;
	margin-left:2px;
	margin-right:2px;
}
.t2 {
	font-size:1px;
	height:1px;
	line-height:1px;
	margin-top:0pt;
	margin-bottom:0pt;
	margin-left:1px;
	margin-right:1px;
}
.t3 {
	border-width:0pt;
	font-size:1px;
	height:1px;
	line-height:1px;
	margin:0pt 1px;
}

.chip .b2 {
	border-style:solid;
	border-width:0pt 1px;
	margin-top:0pt;
	margin-bottom:0pt;
	margin-left:1px;
	margin-right:1px;
}

.chip .b1 {
	margin-top:0pt;
	margin-bottom:0pt;
	margin-left:2px;
	margin-right:2px;
}
.chip .b1, .chip .b2 {
	font-size:1px;
	height:1px;
	line-height:1px;
}

#allDayGrid {	
	background:#E8EEF7 none repeat scroll 0% 0%;
	margin-bottom:5px;
	margin-right:16px;
	margin-left:40px;
}
#eventowner, #decowner {
	height:100%;
	left:0pt;
	position:absolute;
	top:0pt;
	width:100%;
}
#gridcontainercell {
	position:relative !important;
}
#eventowner, #decowner {
	height:100%;
	left:0pt;
	position:absolute;
	top:0pt;
	width:100%;
}
#gridcontainer {
	border-bottom:1px solid #FFFFFF;
	border-left:1px solid #A2BBDD;
	border-top:1px solid #A2BBDD;
	height:100%;
	overflow: hidden;
	position:relative;
	dispaly:block;
}

#colheaders {
	height:2.5ex;
	position:relative;
}
#calowner {
	display:block;
	height:100%;
	width:100%;
}
.chip dl {
	border-style:solid;
	border-width:0pt 1px;
	margin:0pt;
	overflow:hidden;
	position:relative;
	color: #fff !important;
}

.eventheadlabel {
	color: #ffffff !important;
	white-space: nowrap;
	font-weight: 700;
}

.hrule {
	left:0pt;
	position:absolute;
	width:100%;
}

.hruleeven {
	border-top:1px solid #DDDDDD;
}
.hruleodd {
	border-top:1px dotted #DDDDDD;
}

.adc {
	-moz-user-select:none;
	color:#FFFFFF;
	font-family:Verdana,Sans-serif;
	font-size:85%;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:normal;
	font-variant:normal;
	font-weight:normal;
	line-height:1.2em;
	overflow:hidden;
	position:absolute;
	text-align:left;
	width:100%;
}

.noleft {
	padding-left:3px;
}
</style>
<?php
	$date = new DateTimeValue(mktime(0,0,0,$month,$day,$year)); 
	$end_date = new DateTimeValue(mktime(0,0,0,$month,$day+1,$year));
	$result = ProjectEvents::getDayProjectEvents($date, $tags, active_project()); 
	if(!$result) $result = array();	
	
	
	$alldayevents = array();
	$milestones = ProjectMilestones::getRangeMilestonesByUser($date,$end_date,logged_user(), $tags, active_project());	
	$tasks = ProjectTasks::getRangeTasksByUser($date,$end_date,logged_user(), $tags, active_project());
	
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
<div class="calendar" style="padding:7px;height:100%">
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
					<span id="chead0"><?php echo  date('l j, F Y',mktime(0, 0, 0, $month, $day, $year)) ?></span>	
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
					
				<div id="allDayGrid" class="inset grid"  style="height: <?php echo $alldaygridHeight ?>px; margin-bottom: 5px;background:#E8EEF7;margin-right:0px;margin-left:40px;"  onclick="og.EventPopUp.show(null, {day:'<?php echo $dtv->getDay() ?>',	month:'<?php echo $dtv->getMonth()?>',year:'<?php echo $dtv->getYear()?>',view:'day',type_id:1,title:'<?php echo date("l, F j",  mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear()))?>'},'');" >
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
								if ($ws_color>0){
									$ws_style = "";
									$ws_class = "og-wsname-color-$ws_color";
								} else {
									$ws_style = "color: #fff;background-color: #C5C7C1;border-color: #C5C7C1;";
									$ws_class = "";	
								}			
														
						?>
						<div class="adc" style="left: 3px; top: <?php echo $top ?>px; z-index: 5;width: 99%;margin:1px;">
							<div class="t3 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"></div>
							<div class="noleft <?php echo  $ws_class?>" style="<?php echo  $ws_style?>">							
								<div class="" style="overflow: hidden; padding-bottom: 1px;">
								
									<nobr style="display: block; text-decoration: none;"><a href='<?php echo $event->getViewUrl()?>' class='internalLink' "><img src="<?php echo $img_url?>" align='absmiddle' border='0'> <span style="color:#fff!important"><?php echo $subject ?></span> </a></nobr>
								
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
				<div id="gridcontainer" style="background-color:#fff;height: 1024px;overflow:hidden; position:relative;" >	
					<!-- <div class='grid_bg' style="background-image: url(public/assets/themes/default/images/Calendar_BG.gif);background-repeat: repeat;background-color:#ffffff;height:1024px;"> -->
						<div id='calowner' style="display:block; width:100%;">  
							<table cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed; width: 100%;">
								<tr>
									<td id="rowheadcell" style="width: 40px;">
										<div id="rowheaders" style="height: 144ex; top: 0pt; left: 0pt;">										
										<?php
											$horas = array();
											for ($hour=0; $hour<=23; $hour++){	
												$horas[$hour]	= 0;
												$procesados[$hour] = 0;
										?>
											<div style="height: 41px; top: 0ex;border-right:3px double #DDDDDD !important;" id="rhead0" class="rhead">
												<div class="rheadtext"><?php echo date("ga",mktime($hour)) ?></div>
											</div>												
										<?php
											}
										?>

										</div>
									</td>
									<td id="gridcontainercell" style="width: auto;position:relative" >	
										<div id="grid" style="height: 100%;background-color:#fff;" class="grid">										
											<div id="decowner">
												
											</div>
											
											<?php
												for ($hour=0; $hour<=47; $hour++){	
													($hour % 2 ==0)? $parity = "hruleeven": $parity="hruleodd";
													$top = (PX_HEIGHT/2) * $hour;
											?>
													<div id="r<?php echo $hour?>"" class="hrule <?php echo $parity?>" style="top: <?php echo $top?>px; z-index: 1;"></div>
													<div id="h<?php echo $hour?>"" style="width:100%;top: <?php echo $top?>px; z-index: 100; height:20px;position:absolute;" onclick="og.EventPopUp.show(null, {day:'<?php echo $dtv->getDay() ?>',	month:'<?php echo $dtv->getMonth()?>',year:'<?php echo $dtv->getYear()?>',hour:'<?php echo date("G",mktime($hour/2))?>',minute:'<?php echo ($hour % 2 ==0)?0:30?>',type_id:1,view:'day',title:'<?php echo date("l, F j",  mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear())) ?>'},'');"></div>
											<?php
												}
											?>
											
											<div id="eventowner" style="z-index: 102;" onclick="stopPropagation(event) ">
										<?php	
											foreach ($result as $event){
												for($i=$event->getStart()->getHour();$i<= $event->getDuration()->getHour();$i++){
													$horas[$i]++;
												}
											}
											foreach ($result as $event){
												$event_id = $event->getId();
												$subject = $event->getSubject();
												$dws = $event->getWorkspaces();
												$ws_color = 0;
												if (count($dws) >= 1){
													$ws_color = $dws[0]->getColor();
												}	
												
												if ($ws_color>0){
													$ws_style = "";
													$ws_class = "og-wsname-color-$ws_color";
												} else {
													$ws_style = "color: #fff;background-color: #C5C7C1;border-color: #C5C7C1;";
													$ws_class = "";	
												}
												
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
												
												
												$width = 100 / $horas[$hr_start];
												$left =  (100 / $horas[$hr_start])*$procesados[$hr_start] + 0.25;
												$procesados[$hr_start]++;
												if ($procesados[$hr_start] == $horas[$hr_start]) $width = $width- 1.5;
										?>	
												<div class="chip" style="position: absolute; top: <?php echo $top?>px; left: <?php echo $left?>%; width: <?php echo $width?>%;"  onclick="stopPropagation(event)">
													<div class="t1 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>"></div>
													<div class="t2 <?php echo $ws_class ?>" style="<?php echo $ws_style ?>"></div>
													<div class="chipbody edit og-wsname-color-<?php echo  $ws_color?>">
														<dl class="<?php echo  $ws_class?>" style="height: <?php echo $height ?>px;<?php echo  $ws_style?>">
															<dt class="<?php echo  $ws_class?>" style="<?php echo  $ws_style?>">
																<span class="eventheadlabel" style="color:#fff!important;padding-left:5px;"><?php echo "$start_time - $end_time"; ?></span>
															</dt>
															<dd>
																<div>
																	<a href='<?php echo $event->getViewUrl()."&amp;view=day" ?>' class='internalLink' ><span style="color:#fff!important;padding-left:5px;"><?php echo $subject?></span></a>
																</div>
															</dd>
														</dl>
													</div>
													<div class="b2 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"> </div>
													<div class="b1 <?php echo  $ws_class?>" style="<?php echo  $ws_style?>"> </div>
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
	})
	
	//jQuery("#grid").click(function(e){ var x = e.pageX - this.offsetLeft; var y = e.pageY - this.offsetTop; alert(x +', '+ y); }); 

</script>