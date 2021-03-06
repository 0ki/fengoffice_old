

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
//$active_projects = logged_user()->getActiveProjects();
$project = active_or_personal_project();

$day =  array_var($event_data, 'day');
$month =  array_var($event_data, 'month');
$year =  array_var($event_data, 'year');

	echo  cal_top();
	
?>

<script type="text/javascript">
		function change(){
			cal_hide("cal_extra1");
			cal_hide("cal_extra2");
			cal_hide("cal_extra3");
			if(document.getElementById("daily").selected){
				document.getElementById("word").innerHTML = "Days";
				cal_show("cal_extra1");
				cal_show("cal_extra2");
			} else if(document.getElementById("weekly").selected){
				document.getElementById("word").innerHTML = "Weeks";
				cal_show("cal_extra1");
				cal_show("cal_extra2");
			} else if(document.getElementById("monthly").selected){
				document.getElementById("word").innerHTML = "Months";
				cal_show("cal_extra1");
				cal_show("cal_extra2");
			} else if(document.getElementById("yearly").selected){
				document.getElementById("word").innerHTML = "Years";
				cal_show("cal_extra1");
				cal_show("cal_extra2");
			} else if(document.getElementById("holiday").selected){
				cal_show("cal_extra3");
			}
		}
		
		
		var allTags = [<?php
			$coma = false;
			$tags = Tags::getTagNames();
			if ($tags){
				foreach ($tags as $tag) {
					if ($coma) {
						echo ",";
					} else {
						$coma = true;
					}
					echo "'" . $tag . "'";
				}
			}
		?>];
	</script>
<?php
	// get dates
	cal_navmenu(false,$day,$month,$year);
	$setlastweek='';

	if($event->isNew()) { 
			
		
		$username = '';
		$desc = '';
		
		// if adding event to today, make the time current time.  Else just make it 6PM (you can change that)
		if( "$year-$month-$day" == date("Y-m-d") ) $hour = date('G') + 1;
		else $hour = 18;
		// organize time by 24-hour or 12-hour clock.
		if(!cal_option("hours_24")) {
			if($hour >= 12) {
				$hour = $hour - 12;
				$pm = 1;
			} else $pm = 0;
		}
		// set default minute and duration times.
		$minute = 0;
		$durhr = 1;
		$durday = 0;
		$durmin = 0;
		// set other defaults
		$rjump = 1;
		// set type of event to default of 1 (nothing)
		$typeofevent = 1;
	}
	?>

	<?php if($event->isNew()) { ?>
	<form class="internalForm" action="<?php echo get_url('event', 'add'); //submitevent ?>" method="post">
	<?php } else { ?>
	<form class="internalForm" action="<?php echo $event->getEditUrl() ?>" method="post">
	<?php } // if ?>
	<input type="hidden" id="event[pm]" name="event[pm]" value="<?php echo $pm?>">
	<div class="event">	
	<div class="coInputHeader">
		<div class="coInputHeaderUpperRow">
			<div class="coInputTitle">
				<table style="width:535px">
				<tr>
					<td>
					<?php echo $event->isNew() ? lang('new event') : lang('edit event') ?></td>
					<td style="text-align:right">
						<?php echo submit_button($event->isNew() ? lang('add event') : lang('save changes'),'e',array('style'=>'margin-top:0px;margin-left:10px'))?>
					</td>
				</tr>
				</table>
			</div>		
		</div>
		<div style="text-align:left;"><?php echo label_tag(lang('subject'), 'taskListFormName', true) . text_field('event[subject]', array_var($event_data, 'subject'), 
	    		array('class' => 'title', 'id' => 'eventSubject', 'tabindex' => '1', 'maxlength' => '100')) ?>
	    </div>
	 
	 	<div style="padding-top:5px;text-align:left;">
		<?php if (isset ($active_projects) && count($active_projects) > 0) { ?>
			<a href='#' class='option' onclick="og.toggleAndBolden('add_event_select_workspace_div', this)">
			<?php echo lang('workspace')?></a> - 
		<?php } ?>
		<a href='#' class='option' onclick="og.toggleAndBolden('add_event_tags_div', this)"><?php echo lang('tags')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('add_list_description_div', this)"><?php echo lang('description')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('add_event_properties_div', this)"><?php echo lang('properties')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('event_repeat_options_div', this)"><?php echo CAL_REPEATING_EVENT?></a> -
		<?php //!$event->isNew() && $project instanceof Project &&$event->canLinkObject(logged_user(), $project)
			if( true) {   
		?>
		<a href='#' class='option' onclick="og.toggleAndBolden('add_event_linked_objects_div', this)"><?php echo lang('linked objects')?></a>
		<?php  }?>
	    </div></div>
	
		<div class="coInputSeparator"></div>
		<div class="coInputMainBlock">	
			<div id="add_event_tags_div" style="display:none">
				<fieldset>
				<legend><?php echo lang('tags')?></legend>
					<?php echo autocomplete_textfield('event[tags]', array_var($event_data, 'tags'), 'allTags', array( 'class' => 'long'))	?>
				</fieldset>
			</div>
			
			<div id="add_list_description_div" style="display:none">
				<fieldset>
				<legend><?php echo lang('description')?></legend>
				
					<?php 
					echo editor_widget('event[description]',array_var($event_data, 'description'), array('id' => 'descriptionFormText', 'tabindex' => '2'));
					?>
				</fieldset>
			</div>
			
			<div id="add_event_properties_div" style="display:none">
				<fieldset>
				<legend><?php echo lang('properties')?></legend>
				
					<?php 
					echo render_object_properties('event',isset($event)?$event:null);
					?>
				</fieldset>
			</div>
			
			<div id="add_event_select_workspace_div" style="display:none">
				<fieldset>
				<legend><?php echo lang('workspace')?></legend>
					
				<select id='event[project_id]' name='event[project_id]'>
					<?php 							
						if (isset($event) && $event && !$event->isNew()) {
							$projId = $event->getProjectId();
						} else {
							$projId = active_or_personal_project()->getId();
						}
						if (isset($active_projects) && is_array($active_projects) && count($active_projects)) {
							foreach($active_projects as $project) { //list all projects, marking the active as selected
							echo " <option value= '" . $project->getId() ;
							if ($projId == $project->getId()) { 
								echo "' selected='selected" ;
							 } 
							 echo "'>" . clean($project->getName()) . "</option>";
							}
						}
				  	?> 
				  	</select> 
				</fieldset>
			</div>
					
			<div >
					<fieldset>
					<legend><?php echo CAL_TIME_AND_DURATION ?></legend>
					
						<table>
			<tr>
				<td align="right"><?php echo CAL_DATE ?></td>
				<td align='left'>
				<?php 
				echo pick_date_widget('event[start]',$event->getStart() , date("Y") - 10 , date("Y") + 10);
				?>
				</td>
			</tr>
	 
		
			<tr>
				<td align="right">
					<?php echo CAL_TIME ?>
				</td>
				<td align='left'>
					<select name="event[hour]" size="1">
					<?php	
						if(!cal_option("hours_24")) {
							for($i = 1; $i <= 12; $i++) {
						
								echo '<option value="' . $i % 12 . '"';
								if(array_var($event_data, 'hour') == $i) echo ' selected="selected"';
								echo ">$i</option>\n";
							}
						}else{
							for($i = 0; $i < 24; $i++) {
								echo "<option value=\"$i\"";
								if(array_var($event_data, 'hour') == $i) echo ' selected="selected"';
								echo ">$i</option>\n";
							}
						}
					?>
					</select>
					 <b>:</b> 
					 	<select name="event[minute]" size="1">
					<?php
						$minute = array_var($event_data, 'minute');
						for($i = 0; $i < 60; $i = $i + 15) {
							echo "<option value='$i'";
							if($minute >= $i && $i > $minute - 15) echo ' selected="selected"';
							echo sprintf(">%02d</option>\n", $i);
						}
						?>
						</select>
						<?php
						// print out the PM/AM option (only if using 12-hour clock)
						if(!cal_option("hours_24")) {
							echo '<select name="event[pm]" size="1"><option value="0"';
							if(array_var($event_data, 'pm'))echo ' selected="selected"';
							echo '>AM</option><option value="1"';
							if(array_var($event_data, 'pm')) echo ' selected="selected"';
							echo ">PM</option></select>\n";
						}
					?>
				</td>
			</tr>
					
		<!--   begin printing the duration options-->
			<tr>
				<td align="right"><?php echo CAL_DURATION ?></td>
				<td align="left">
					<select name="event[durationhour]" size="1">
					<?php
					for($i = 0; $i < 15; $i++) {
						echo "<option value='$i'";
						if(array_var($event_data, 'durhr')== $i) echo ' selected="selected"';
						echo ">$i</option>\n";
					}
					?>
					</select> 
					<?php echo CAL_HOURS ?>
					<select name="event[durationmin]" size="1">
					<?php
						// print out the duration minutes drop down
					$durmin = array_var($event_data, 'durmin');
					for($i = 0; $i <= 59; $i = $i + 15) {
						echo "<option value='$i'";
						if($durmin >= $i && $i > $durmin - 15) echo ' selected="selected"';
						echo sprintf(">%02d</option>\n", $i);
					}
					?>
					</select> 
					<?php echo CAL_MINUTES ?>
				</td>
			</tr>
					
						<!--   print extra time options-->
			<tr>
				<td align="right"<?php echo CAL_MORE_TIME_OPTIONS?></td>
				<td align="left">
					<select name="event[type_id]" size="1">
						<option value="1" <?php if(array_var($event_data, 'typeofevent') == 1) echo ' selected="selected"'?>></option>
						<option value="2" <?php if(array_var($event_data, 'typeofevent') == 2) echo ' selected="selected"'?>><?php echo CAL_FULL_DAY?></option>
						<option value="3" <?php if(array_var($event_data, 'typeofevent') == 3) echo ' selected="selected"'?>><?php echo CAL_UNKNOWN_TIME?></option>
					</select>
				</td>
			</tr>
		</table>
			</fieldset>
		</div>
			
		
		<?php
		 $occ = array_var($event_data, 'occ');
		?>
		
		<div id="event_repeat_options_div" style="display:none">
		<fieldset>
			<legend><?php echo CAL_REPEATING_EVENT?></legend>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="left" valign="top">
						<?php echo CAL_REPEAT?>
						<select name="event[occurance]" onChange="change()">
							<option value="1" id="today" <?php if(isset($occ) && $occ == 1) echo ' selected="selected"'?>>
								<?php echo CAL_ONLY_TODAY?>
							</option>
							<option value="2" id="daily" <?php if(isset($occ) && $occ == 2) echo ' selected="selected"'?>>
								<?php echo CAL_DAILY_EVENT?>
							</option>
							<option value="3" id="weekly"<?php if(isset($occ) && $occ == 3) echo ' selected="selected"'?>>
								<?php echo CAL_WEEKLY_EVENT?>
							</option>
							<option value="4" id="monthly"<?php if(isset($occ) && $occ == 4) echo ' selected="selected"'?>>
								<?php echo CAL_MONTHLY_EVENT ?>
							</option>
							<option value="5" id="yearly"<?php if(isset($occ) && $occ == 5) echo  ' selected="selected"'?>>
								<?php echo CAL_YEARLY_EVENT ?>
							</option>
							<option value="6" id="holiday"<?php if(isset($occ) && $occ == 6)  echo ' selected="selected"'?>>
								<?php echo CAL_HOLIDAY_EVENT ?>
							</option>';
						</select>
					</td>
					<?php	
			// calculate what is visible given the repeating options
			$hide = '';
			$hide2 = '';
			if(( !isset($occ)) OR $occ == 1 OR $occ=="6" OR $occ=="") $hide = "display: none;";
			if(isset($occ) && $occ != 6) $hide2 = "display: none;";
			// print out repeating options for daily/weekly/monthly/yearly repeating.
			if(!isset($rsel1)) $rsel1="";
			if(!isset($rsel2)) $rsel2="";
			if(!isset($rsel3)) $rsel3="";
			if(!isset($rnum) || $rsel2=='') $rnum="";
			if(!isset($rend) || $rsel3=='') $rend="";
			if(!isset($hide2) ) $hide2="";
			?>
					<td>
					<div id="cal_extra1" style="<?php echo $hide ?>">
						&nbsp;<?php echo CAL_EVERY . 
						text_field('event[occurance_jump]',array_var($event_data, 'rjump'), array('class' => 'title','size' => '2', 'id' => 'eventSubject', 'tabindex' => '1', 'maxlength' => '100')) ?>
	    				 <span id="word">Days/Weeks/Months/Years</span>
					</div>
					</td>
				</tr>
			</table><br>
			<div id="cal_extra2" style="width: 400px; align: center; text-align: left; <?php echo $hide ?>">
				<?php echo radio_field('event[repeat_option]',$rsel1,array('id' => 'cal_repeat_option','value' => '1')) .CAL_REPEAT_FOREVER?>
				<br><br>
				<?php echo radio_field('event[repeat_option]',$rsel2,array('id' => 'cal_repeat','value' => '2')) .CAL_REPEAT;
				echo text_field('event[repeat_num]', $rnum, array('size' => '3', 'id' => 'repeat_num', 'maxlength' => '3')) .CAL_TIMES ?> 
				
				<?php echo radio_field('event[repeat_option]',$rsel3,array('id' => 'cal_repeat_until','value' => '3')) .CAL_REPEAT_UNTIL;
				echo text_field('event[repeat_end]', $rend, array('size' => '12', 'id' => 'repeat_end', 'maxlength' => '10')) .'(YYYY-MM-DD)' ?> 
				<br><br>
			</div>
			<div id="cal_extra3" style="width: 300px; align: center; text-align: left; <?php echo $hide2 ?>'">
			<?php 
				// get the week number
				$tmp = 1;
				$week = 0;
				while($week < 5 AND $tmp <= $day){
					$week++;
					$tmp += 7;
				}
				// get days in month and day name
				$daysinmonth = date("t",mktime(0,0,1,$month,$day,$year));
				$dayname = date("l",mktime(0,0,1,$month,$day,$year));
				// use week number, and days in month to calculate if it's on the last week.
				if($day > $daysinmonth - 7) $lastweek = true;
				else $lastweek = false;
				// calculate the correct number endings
				if($week==1) $weekname = "1st";
				elseif($week==2) $weekname = "2nd";
				elseif($week==3) $weekname = "3rd";
				else $weekname = $week."th";
				// print out the data for holiday repeating
				
				
				echo CAL_HOLIDAY_EXPLAIN. $weekname." ".$dayname ." ".CAL_DURING." ".cal_month_name($month)." ".CAL_EVERY_YEAR;
				
				if($lastweek){// if it's the last week, add option to have event repeat on LAST week every month (holiday repeating only)
					echo checkbox_field('event[cal_holiday_lastweek]',$setlastweek, array('value' => '1', 'id' => 'cal_holiday_lastweek', 'maxlength' => '10')) .CAL_HOLIDAY_EXTRAOPTION ." $dayname ".CAL_IN." ".cal_month_name($month)." ".CAL_EVERY_YEAR;
				} 
				?>
			</div>
		</fieldset>
		</div>
		
		
		
	<div style="display:none" id="add_event_linked_objects_div">
		<fieldset>
	    <legend><?php echo lang('linked objects') ?></legend>
	    	<div class="objectFiles">
			<table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
		   	<tbody></tbody>
			</table>
	    	<?php
	    		echo render_object_links($event);
	    	?>
			</div>
		</fieldset>
	</div>
		
   	   	
   	
   		
	
	<input type="hidden" name="cal_origday" value="<?php echo $day?>">
	<input type="hidden" name="cal_origmonth" value="<?php echo $month?>">
	<input type="hidden" name="cal_origyear" value="<?php echo $year?>">
	<?php 
	// THIS IS HERE SO THAT THE DURATION CAN BE SET CORRECTLY ACCORDING TO THE EVENT'S ACTUAL START DATE.
	// otherwise, if you modify a repeating event, it can save the duration as a totally different date!
	
	
	echo  submit_button($event->isNew() ? lang('add event') : lang('save changes'),'e',array('style'=>'margin-top:0px;margin-left:10px'));?>
	</div></div>
</form>
<script type="text/javascript">
	Ext.get('eventSubject').focus();
</script>