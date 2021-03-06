<script type="text/javascript">

	
function changeRepeat() {
	cal_hide("cal_extra1");
	cal_hide("cal_extra2");
	cal_hide("cal_extra3");
	if(document.getElementById("daily").selected){
		document.getElementById("word").innerHTML = '<?php echo lang("days")?>';
		cal_show("cal_extra1");
		cal_show("cal_extra2");
	} else if(document.getElementById("weekly").selected){
		document.getElementById("word").innerHTML =  '<?php echo lang("weeks")?>';
		cal_show("cal_extra1");
		cal_show("cal_extra2");
	} else if(document.getElementById("monthly").selected){
		document.getElementById("word").innerHTML =  '<?php echo lang("months")?>';
		cal_show("cal_extra1");
		cal_show("cal_extra2");
	} else if(document.getElementById("yearly").selected){
		document.getElementById("word").innerHTML =  '<?php echo lang("years")?>';
		cal_show("cal_extra1");
		cal_show("cal_extra2");
	} else if(document.getElementById("holiday").selected){
		cal_show("cal_extra3");
	}
}
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
$genid = gen_id();

$active_projects = logged_user()->getActiveProjects();

$day =  array_var($event_data, 'day');
$month =  array_var($event_data, 'month');
$year =  array_var($event_data, 'year');

$filter_user = isset($_GET['user_id']) ? $_GET['user_id'] : logged_user()->getId();

	// get dates
	$setlastweek='';
	$pm = 0;
	if($event->isNew()) { 
			
		
		$username = '';
		$desc = '';
		
		// if adding event to today, make the time current time.  Else just make it 6PM (you can change that)
		if( "$year-$month-$day" == date("Y-m-d") ) $hour = date('G') + 1;
		else $hour = 18;
		// organize time by 24-hour or 12-hour clock.
		$pm = 0;
		if(!cal_option("hours_24")) {
			if($hour >= 12) {
				$hour = $hour - 12;
				$pm = 1;
			}
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
	<form style="height:100%;background-color:white" class="internalForm" action="<?php echo get_url('event', 'add')."&view=". array_var($_GET, 'view','month'); ?>" method="post">
	<?php } else { ?>
	<form style="height:100%;background-color:white" class="internalForm" action="<?php echo $event->getEditUrl()."&view=". array_var($_GET, 'view','month'); ?>" method="post">
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
		<a href='#' class='option' onclick="og.toggleAndBolden('<?php echo $genid ?>add_event_select_workspace_div', this)"><?php echo lang('workspace')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('<?php echo $genid ?>add_event_tags_div', this)"><?php echo lang('tags')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('<?php echo $genid ?>add_event_description_div', this)"><?php echo lang('description')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('<?php echo $genid ?>event_repeat_options_div', this)"><?php echo lang('CAL_REPEATING_EVENT')?></a> -
		<a href='#' class='option' onclick="og.toggleAndBolden('<?php echo $genid ?>add_event_properties_div', this)"><?php echo lang('properties')?></a> - 
		<a href='#' class='option' onclick="og.toggleAndBolden('<?php echo $genid ?>add_event_linked_objects_div', this)"><?php echo lang('linked objects')?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_event_invitation_div', this)"><?php echo lang('event invitations') ?></a>
		</div></div>
	
		<div class="coInputSeparator"></div>
		<div class="coInputMainBlock">	
			
		<div id="<?php echo $genid ?>add_event_select_workspace_div" style="display:none">
		<fieldset>
		<legend><?php echo lang('workspace') ?></legend>
			<?php echo select_project2('event[project_id]', ($event->getProject() instanceof Project)? $event->getProject()->getId():active_or_personal_project()->getId(), $genid) ?>
		</fieldset>
		</div>
		
		<div id="<?php echo $genid ?>add_event_tags_div" style="display:none">
		<fieldset>
			<legend><?php echo lang('tags')?></legend>
			<?php echo autocomplete_textfield("event[tags]", array_var($event_data, 'tags'), Tags::getTagNames(), lang("enter tags desc"), array("class" => "long")); ?>
		</fieldset>
		</div>
		
		<div id="<?php echo $genid ?>add_event_description_div" style="display:none">
			<fieldset>
			<legend><?php echo lang('description')?></legend>
				<?php echo textarea_field('event[description]',array_var($event_data, 'description'), array('id' => 'descriptionFormText', 'tabindex' => '2'));?>
			</fieldset>
		</div>

<?php $occ = array_var($event_data, 'occ'); 
	$rsel1 = array_var($event_data, 'rsel1'); 
	$rsel2 = array_var($event_data, 'rsel2'); 
	$rsel3 = array_var($event_data, 'rsel3'); 
	$rnum = array_var($event_data, 'rnum'); 
	$rend = array_var($event_data, 'rend');?>
		
		<div id="<?php echo $genid ?>event_repeat_options_div" style="display:none">
		<fieldset>
			<legend><?php echo lang('CAL_REPEATING_EVENT')?></legend>
		<?php
		// calculate what is visible given the repeating options
		$hide = '';
		$hide2 = (isset($occ) && $occ == 6)? '' : "display: none;";
		if((!isset($occ)) OR $occ == 1 OR $occ=="6" OR $occ=="") $hide = "display: none;";
		// print out repeating options for daily/weekly/monthly/yearly repeating.
		if(!isset($rsel1)) $rsel1=true;
		if(!isset($rsel2)) $rsel2="";
		if(!isset($rsel3)) $rsel3="";
		if(!isset($rnum) || $rsel2=='') $rnum="";
		if(!isset($rend) || $rsel3=='') $rend="";
		if(!isset($hide2) ) $hide2="";?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" valign="top" style="padding-bottom:6px">
		
			<table><tr><td><?php echo lang('CAL_REPEAT')?> 
			<select name="event[occurance]" onChange="changeRepeat()">
				<option value="1" id="today"<?php if(isset($occ) && $occ == 1) echo ' selected="selected"'?>><?php echo lang('CAL_ONLY_TODAY')?></option>
				<option value="2" id="daily"<?php if(isset($occ) && $occ == 2) echo ' selected="selected"'?>><?php echo lang('CAL_DAILY_EVENT')?></option>
				<option value="3" id="weekly"<?php if(isset($occ) && $occ == 3) echo ' selected="selected"'?>><?php echo lang('CAL_WEEKLY_EVENT')?></option>
				<option value="4" id="monthly"<?php if(isset($occ) && $occ == 4) echo ' selected="selected"'?>><?php echo lang('CAL_MONTHLY_EVENT') ?></option>
				<option value="5" id="yearly"<?php if(isset($occ) && $occ == 5) echo  ' selected="selected"'?>><?php echo lang('CAL_YEARLY_EVENT') ?></option>
				<option value="6" id="holiday"<?php if(isset($occ) && $occ == 6)  echo ' selected="selected"'?>><?php echo lang('CAL_HOLIDAY_EVENT') ?></option>
			</select>
			<?php if (isset($occ) && $occ > 1 && $occ < 6){ ?>
			<script type="text/javascript">
				changeRepeat();
			</script>
			<?php } ?>
			</td><td>
			<div id="cal_extra1" style="<?php echo $hide ?>">
				&nbsp;<?php echo lang('CAL_EVERY') . text_field('event[occurance_jump]',array_var($event_data, 'rjump'), array('class' => 'title','size' => '2', 'id' => 'eventSubject', 'tabindex' => '1', 'maxlength' => '100', 'style'=>'width:25px')) ?>
				<span id="word"></span>
			</div>
			</td></tr></table>
		</td>
		</tr><tr>
		<td>
			<div id="cal_extra2" style="width: 400px; align: center; text-align: left; <?php echo $hide ?>">
				<?php echo radio_field('event[repeat_option]',$rsel1,array('id' => 'cal_repeat_option','value' => '1')) . lang('CAL_REPEAT_FOREVER')?>
				<br/>
				<?php echo radio_field('event[repeat_option]',$rsel2,array('id' => 'cal_repeat','value' => '2')) .lang('CAL_REPEAT');
				echo "&nbsp;" . text_field('event[repeat_num]', $rnum, array('size' => '3', 'id' => 'repeat_num', 'maxlength' => '3', 'style'=>'width:25px')) ."&nbsp;" . lang('CAL_TIMES') ?>
				<br/>
				<table><tr><td><?php echo radio_field('event[repeat_option]',$rsel3,array('id' => 'cal_repeat_until','value' => '3')) .lang('CAL_REPEAT_UNTIL');?></td>
				<td><?php echo pick_date_widget2('event[repeat_end]', $rend, $genid);?></td></tr></table>
				<br>
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
				$dayname = "CAL_" .strtoupper  ($dayname);
				// use week number, and days in month to calculate if it's on the last week.
				if($day > $daysinmonth - 7) $lastweek = true;
				else $lastweek = false;
				// calculate the correct number endings
				if($week==1) $weekname = "1st";
				elseif($week==2) $weekname = "2nd";
				elseif($week==3) $weekname = "3rd";
				else $weekname = $week."th";
				// print out the data for holiday repeating
		
				echo lang('CAL_HOLIDAY_EXPLAIN'). $weekname." ". lang($dayname) ." ".lang('CAL_DURING')." ".cal_month_name($month)." ".lang('CAL_EVERY_YEAR');
		
				if($lastweek){// if it's the last week, add option to have event repeat on LAST week every month (holiday repeating only)
					echo "<br/><br/>". checkbox_field('event[cal_holiday_lastweek]',$setlastweek, array('value' => '1', 'id' => 'cal_holiday_lastweek', 'maxlength' => '10')) .lang('CAL_HOLIDAY_EXTRAOPTION') ." " . lang($dayname)." ".lang('CAL_IN')." ".cal_month_name($month)." ".lang('CAL_EVERY_YEAR');
				}
				?>
			</div>
		</td>
	</tr>
</table>
		</fieldset>
		</div>
		
		
			
	<div id="<?php echo $genid ?>add_event_properties_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('properties')?></legend>
		<?php echo render_object_properties('event',isset($event)?$event:null);?>
	</fieldset>
	</div>
		
	<div style="display:none" id="<?php echo $genid ?>add_event_linked_objects_div">
	<fieldset>
    	<legend><?php echo lang('linked objects') ?></legend>
    	<div class="objectFiles">
		<table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
	   	<tbody></tbody>
		</table>
    	<?php echo render_object_links($event); ?>
		</div>
	</fieldset>
	</div>
	
	<div id="<?php echo $genid ?>add_event_invitation_div" style="display:none">
	<fieldset id="emailNotification">
		<legend><?php echo lang('event invitations') ?></legend>
		<p><?php echo lang('event invitations desc') ?></p>

		<?php echo checkbox_field('event[send_notification]', array_var($event_data, 'send_notification', $event->isNew()), array('id' => 'eventFormSendNotification')) ?> 
		<label for="eventFormSendNotification" class="checkbox"><?php echo lang('send new event notification') ?></label>

		<?php
		$project = active_or_personal_project(); 
		if ($project instanceof Project) {
			$companies = $project->getCompanies();
		} else {
			$companies = Companies::findAll();
		}?>
		<?php foreach($companies as $company) { ?>
			<script type="text/javascript">
				App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?> = {
					id          : <?php echo $company->getId() ?>,
					checkbox_id : 'notifyCompany<?php echo $company->getId() ?>',
					users       : []
				};
			</script>
			<?php if ($project instanceof Project) {
				$users = $company->getUsersOnProject($project);
			} else {
				$users = $company->getUsers();
			}?>
			<?php if(is_array($users) && count($users)) { ?>
			<div class="companyDetails">
				<div class="companyName">
					<?php echo checkbox_field('event[invite_company_' . $company->getId() . ']', 
						array_var($event_data, 'invite_company_' . $company->getId()), 
						array('id' => $genid.'notifyCompany' . $company->getId(), 
							'onclick' => 'App.modules.addMessageForm.emailNotifyClickCompany(' . $company->getId() . ',"' . $genid. '")')) ?> 
					<label for="<?php echo $genid ?>notifyCompany<?php echo $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
				</div>
				
				<div class="companyMembers">
				<ul>
				<?php foreach($users as $user) { 
					if ($user->getId() != $filter_user) { ?>
						<li><?php echo checkbox_field('event[invite_user_' . $user->getId() . ']',
							array_var($event_data, 'invite_user_' . $user->getId()), 
							array('id' => $genid.'notifyUser' . $user->getId(),
								'onclick' => 'App.modules.addMessageForm.emailNotifyClickUser(' . $company->getId() . ', ' . $user->getId() . ',"' . $genid. '")')) ?> 
							<label for="<?php echo $genid ?>notifyUser<?php echo $user->getId() ?>" class="checkbox"><?php echo clean($user->getDisplayName()) ?></label></li>
						<script type="text/javascript">
							App.modules.addMessageForm.notify_companies.company_<?php echo $company->getId() ?>.users.push({
								id          : <?php echo $user->getId() ?>,
								checkbox_id : 'notifyUser<?php echo $user->getId() ?>'
							});
						</script>
					<?php } // if ?>
				<?php } // foreach ?>
				</ul>
				</div>
				</div>
			<?php } // if ?>
		<?php } // foreach ?>
		<?php // ComboBox for Assistance confirmation 
			if (!$event->isNew()) {
				$event_invs = $event->getInvitations();
				if (isset($event_invs[$filter_user])) {
					$event_inv_state = $event_invs[$filter_user]->getInvitationState();
				} else {
					$event_inv_state = -1;
				}
				
				if ($event_inv_state != -1) {
					$options = array(
						option_tag(lang('yes'), 1, ($event_inv_state == 1)?array('selected' => 'selected'):null),
						option_tag(lang('no'), 2, ($event_inv_state == 2)?array('selected' => 'selected'):null),
						option_tag(lang('maybe'), 3, ($event_inv_state == 3)?array('selected' => 'selected'):null)
					);
					if ($event_inv_state == 0) {
						$options[] = option_tag(lang('decide later'), 0, ($event_inv_state == 0) ? array('selected' => 'selected'):null);
					}
					?>
					<table><tr><td style="padding-right: 6px;"><label for="eventFormComboAttendance" class="combobox"><?php echo lang('confirm attendance') ?></label></td><td>
					<?php echo select_box('event[confirmAttendance]', $options, array('id' => 'eventFormComboAttendance'));?>
					</td></tr></table>	
			<?php	} //if			
			} // if ?>
	</fieldset>
	</div>	
	
<div>
<fieldset><legend><?php echo lang('CAL_TIME_AND_DURATION') ?></legend>
<table>
	<tr style="padding-bottom:4px">
		<td align="right" style="padding-right:6px;padding-bottom:4px;padding-top:2px"><?php echo lang('CAL_DATE') ?></td>
		<td align='left'><?php
				$dv_start = new DateTimeValue(time());
				$dv_start->setDay($day);
				$dv_start->setMonth($month);
				$dv_start->setYear($year);
				$event->setStart($dv_start);
				echo pick_date_widget2('event[start_value]', $event->getStart(), $genid); ?>
		</td>
	</tr>
	<tr style="padding-bottom:4px">
		<td align="right" style="padding-right:6px;padding-bottom:4px;padding-top:2px">
			<?php echo lang('CAL_TIME') ?>
		</td>
		<td align='left'>
			<span id='row_time'>			
			<select name="event[hour]" size="1">
				<?php
				if(!cal_option("hours_24")) {
					$hr = array_var($event_data, 'hour');
					for($i = 1; $i <= 12; $i++) {
						echo '<option value="' . $i % 12 . '"';
						if($hr == $i || ($hr == 0 && $i == 12)) {
							echo ' selected="selected"';
						}
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
					</select> <b>:</b> <select name="event[minute]" size="1">
				<?php
				$minute = array_var($event_data, 'minute');
				for($i = 0; $i < 60; $i = $i + 15) {
					echo "<option value='$i'";
					if($minute >= $i && $i > $minute - 15) echo ' selected="selected"';
					echo sprintf(">%02d</option>\n", $i);
				}
				?>
			</select> <?php
				// print out the PM/AM option (only if using 12-hour clock)
				if(!cal_option("hours_24")) {
					echo '<select name="event[pm]" size="1"><option value="0"';
					if(array_var($event_data, 'pm'))echo ' selected="selected"';
					echo '>AM</option><option value="1"';
					if(array_var($event_data, 'pm')) echo ' selected="selected"';
					echo ">PM</option></select>\n";
				}
				?>
			</span>
		</td>
	</tr>
	<tr style="padding-bottom:4px">
		<td align="right" style="padding-right:6px;padding-bottom:4px;padding-top:2px">&nbsp;</td>
		<td align='left'>
			<?php
			echo checkbox_field('event[type_id]',array_var($event_data, 'typeofevent') == 2, array('id' => 'format_html','value' => '2', 'onchange'=>"toggleDiv('row_time')"));
			echo lang('CAL_FULL_DAY');
			?>
		</td>
	</tr>
	
	<!--   begin printing the duration options-->
	<tr>
		<td align="right" style="padding-right:6px;padding-bottom:4px;padding-top:2px"><?php echo lang('CAL_DURATION') ?></td>
		<td align="left"><select name="event[durationhour]" size="1">
		<?php
		for($i = 0; $i < 15; $i++) {
			echo "<option value='$i'";
			if(array_var($event_data, 'durationhour')== $i) echo ' selected="selected"';
			echo ">$i</option>\n";
		}
		?>
		</select> <?php echo lang('CAL_HOURS') ?> <select
			name="event[durationmin]" size="1">
			<?php
			// print out the duration minutes drop down
			$durmin = array_var($event_data, 'durationmin');
			for($i = 0; $i <= 59; $i = $i + 15) {
				echo "<option value='$i'";
				if($durmin >= $i && $i > $durmin - 15) echo ' selected="selected"';
				echo sprintf(">%02d</option>\n", $i);
			}
			?>
		</select> 
		
		</td>
	</tr>

	<!--   print extra time options-->
	
</table>
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
function cal_toggle(id) {
	obj = document.getElementById(id);
	if(obj.style.display=="none"){
		obj.style.display = "block";
	}else{
		obj.style.display = "none";
	}
}

function cal_hide(id) {
	document.getElementById(id).style.display = "none";
}

function cal_show(id) {
	document.getElementById(id).style.display = "block";
}

function toggleDiv(div_id){
	var theDiv = document.getElementById(div_id);
	dis = !theDiv.disabled;
    var theFields = theDiv.getElementsByTagName('select');
    for (var i=0; i < theFields.length;i++) theFields[i].disabled=dis;
    theDiv.disabled=dis;
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

Ext.get('eventSubject').focus();
<?php if (array_var($event_data, 'typeofevent') == 2) echo "toggleDiv('row_time')";?>
	
</script>