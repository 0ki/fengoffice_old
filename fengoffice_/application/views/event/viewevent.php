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

echo  cal_top();


/* ##################################################################
  cal_display()
   writes the events for a particular day out,
   with the delete/modify/add event options.
###################################################################*/
//function cal_display(){
	global $cal_db;
	$modified="";
	$error = "";
	// get the date requested.
	$day = $_SESSION['cal_day'];
	$month = $_SESSION['cal_month'];
	$year = $_SESSION['cal_year'];
	// Do this if we are MODIFYING a form.
	$id = $_GET['id'];
    if(!is_numeric($id)) $error = CAL_NO_EVENT_SELECTED;
	// get event info from database
    //$result = cal_query_get_event($id);
    //if(($result==NULL OR $cal_db->sql_numrows($result)==0) AND $error=="") $error = CAL_DOESNT_EXIST;
    //$row = $cal_db->sql_fetchrow($result);
	// get user who submitted the event, subject, event description, etc.
    $username = $event->getCreatedById();// $row['created_by_id'];
    $subject = $event->getSubject();// htmlentities($row['subject']);
	$private = $event->getIsPrivate();// $row['private'];
	$alias = $event->getCreatedById();//$row['created_by_id'];
    $desc = $event->getDescription();//htmlentities(nl2br($row['description']));
    $thetime = $event->getStart();//$row['start_since_epoch'];
	$mod_username = $event->getUpdatedById();//$row['updated_by_id'];
	$mod_stamp = $event->getUpdatedOn();//$row['updated_on'];
	// check username to see if it's anonymous or not
	if($username=="") $username = CAL_ANONYMOUS;
	if($mod_username=="") $mod_username = CAL_ANONYMOUS;
	// if the event is private and the user is anonymous, return that the event does not exist.
	if($private AND cal_anon() AND $error=="") $error = CAL_DOESNT_EXIST;
	// begin organizing the event's time and date for display.
    $hour = date('G', $thetime->getTimestamp());
    $minute = date('i', $thetime->getTimestamp());
    $month = date('n', $thetime->getTimestamp());
    $year = date('Y', $thetime->getTimestamp());
    $day = date('j', $thetime->getTimestamp());
    $durtime = $event->getDuration()->getTimestamp() - $thetime->getTimestamp();//$row['end_since_epoch'] - $thetime;
    $durmin = ($durtime / 60) % 60;     //seconds per minute
    $durhr  = ($durtime / 3600) % 24;   //seconds per hour
    $durday = floor($durtime / 86400);  //seconds per day
	// organize time according to either 12 or 24 hour clock
    if(!cal_option("hours_24")) {
      if($hour >= 12) {
        $hour = $hour - 12;
		$extra = " PM";
      } else $extra = " AM";
    }else $extra = "";
	$time = $hour.":".$minute.$extra;
	// organize duration of event
	$duration = $durhr." ";
	if($durhr!="1") $duration .= CAL_HOURS;
	else $duration .= CAL_HOUR;
	if($durmin!="0") $duration .= ", ". $durmin. " ". CAL_MINUTES_SHORT;
	// organize other time options for the event
    $typeofevent = $event->getEventType();// $row['eventtype'];
	if($typeofevent=="2") $duration = CAL_FULL_DAY;
	elseif($typeofevent=="3"){
		$time = CAL_NOT_SPECIFIED;
		$duration = CAL_NOT_SPECIFIED;
	}
	elseif($typeofevent=="4") $duration = CAL_NOT_SPECIFIED;
	// start the output
	$output = "";
	$output .= cal_navmenu();
	$output .= '
		<table align="center" class="box"><tr><td><table border="0" cellpadding="3" width="100%" cellspacing="0">	
		<tr><td colspan="3" height="10"></td></tr>';
	// make sure user is allowed to modify this event.
	//$edit=0;
	$permission = ProjectEvents::findById($id)->canEdit(logged_user());
	/*if(($row['created_by_id'] !=  logged_user()->getId()) AND !cal_permission("editothers"));
	else if(($row['created_by_id'] ==  logged_user()->getUsername()) AND !cal_permission('edit'));
	else if(!cal_permission("editpast") AND date("Y-m-d",$row['start_since_epoch']) < date("Y-m-d"));
	else $edit=1;*/
	// print modify/delete links if allowed to modify the event
	if($permission){
		$modify_link = " - <a  class='internalLink' class='viewdateoption' href=\"".cal_getlink("index.php?action=modify&amp;id=$id&amp;day=$day&amp;month=$month&amp;year=$year")."\">".CAL_MODIFY."</a>";
    	$del_link = "<a  class='internalLink' class='viewdateoption' href='#' onClick=\"if(confirm('".CAL_DELETE_EVENT_CONFIRM."')){ og.openLink( '".cal_getlink("index.php?action=delete&id=$id&month=$month&day=$day&year=$year")."');}\">".CAL_DELETE."</a>";
	}else{
		$modify_link = "";
		$del_link = "";
	}
	// print alias information if the event was submitted by anonymous user and alias is enabled.
	$alias = trim($username);
	if(cal_option("anon_naming") AND $alias!=""){
		$name = "<i>$alias</i> ";
	}else{
		$name = $username;
	}
	// set subject and if event is private or not.
	if($subject=="") $subject = "[".CAL_NO_SUBJECT."]";
	if($private) $private = "(".CAL_PRIVATE_EVENT.")";
	else $private = "";
	// if modified, print modifier username and timestamp
	// must test agains $row variable here, as testing NULL agains $mod_username is always true (fuck you php)
	if($event->getUpdatedById()){//$row['updated_by_id']!==NULL){
		if(!cal_option("hours_24")) $modtimeformat = 'g:i A';
		else $modtimeformat = 'G:i';
		$modified = "<br><strong>".CAL_LAST_MODIFIED_ON." ".date("F j, Y @ $modtimeformat")." ".CAL_BY.":</strong> ".$mod_username;
	}
	// print any error messages that were thrown.
	if($error!="") $output .= "<tr><td><br><br><br><center><span class='failure'>$error</span></center><br><br><br></td></tr>";
	// output all the information organized above.
	else{ $output .= "  <tr align='left' valign='top'>
	   	<td width='80'>&nbsp;</td><td colspan='2'><span class='viewevent_title'>:: $subject $private</span>
		</td></tr><tr align='left' valign='top'><td>&nbsp;</td>
		<td><strong>".CAL_POSTED_BY.":</strong> $name
		$modified
		<br>$del_link $modify_link<br>
    	<br><b>".CAL_STARTING_TIME.":</b> $time
		<br><b>".CAL_DURATION.":</b> $duration<br>
    	<br><b>".CAL_DESCRIPTION.":</b><br>$desc<br>";
    	if($event->canLinkObject(logged_user(), active_or_personal_project())) { 
			 $output .= "<fieldset>
			    <legend class='toggle_collapsed' onclick=\"og.toggle('add_event_linked_objects_div',this)\">" . lang('linked objects') . "</legend>
			    <div style='display:none' id='add_event_linked_objects_div'>" .
			    render_object_links($event, $event->canEdit(logged_user())). 
			"</div>	</fieldset>";
		} // if 
    	 $output .= "</td>
		<td>&nbsp;</td>
  		</tr>\n";
	}
	// return the output to be printed.
  	echo $output . "</table><br><br></td></tr></table>";
//} // end function


echo cal_bottom();
?>
