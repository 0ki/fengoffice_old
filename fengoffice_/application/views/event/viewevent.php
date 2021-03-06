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
/* @var $event ProjectEvent*/

if($event->canDelete(logged_user())) {
		add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete event'))) og.openLink('" . $event->getDeleteUrl() ."');", 'ico-delete');
} // if

if($event->canEdit(logged_user())) {
		add_page_action(lang('edit'), $event->getEditUrl()."&view=$view", 'ico-edit');
}
	
	
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
	// get user who submitted the event, subject, event description, etc.
    $username = Users::findById($event->getCreatedById())->getUsername();// $row['created_by_id'];
    $subject = $event->getSubject();// htmlentities($row['subject']);
	$private = $event->getIsPrivate();// $row['private'];
	$alias = Users::findById($event->getCreatedById())->getUsername();//$row['created_by_id'];
    $desc = $event->getDescription();//htmlentities(nl2br($row['description']));
    $thetime = $event->getStart();//$row['start_since_epoch'];
	$mod_username = Users::findById($event->getUpdatedById())->getUsername();//$row['updated_by_id'];
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
    $typeofevent = $event->getTypeId();
	if($typeofevent=="2") $duration = CAL_FULL_DAY;
	elseif($typeofevent=="3"){
		$time = CAL_NOT_SPECIFIED;
		$duration = CAL_NOT_SPECIFIED;
	}
	elseif($typeofevent=="4") $duration = CAL_NOT_SPECIFIED;
	
	$permission = ProjectEvents::findById($id)->canEdit(logged_user());
	//echo cal_navmenu(true,$day,$month,$year);
	
?>
<div style="padding:7px">
<div class="event">

<?php
	
	$dtv = $event->getStart();
	$title = date("l, F j",  mktime(0, 0, 0, $dtv->getMonth(), $dtv->getDay(), $dtv->getYear())). " - ".$event->getSubject();
	
	$description = CAL_STARTING_TIME.": $time";
  	tpl_assign('description', $description);
		
	$variables = array();
	$variables['username'] = $username;
	if (isset($modtimeformat))
		$variables['modtimeformat'] = $modtimeformat;
	$variables['mod_username'] = $mod_username;
	$variables['time'] = $time;
	$variables['duration'] = $duration;
	$variables['desc'] = $desc;
	
	
		
	
	tpl_assign("variables", $variables);
	tpl_assign("content_template", array('view_event', 'event'));
	tpl_assign('object', $event);
	tpl_assign('title', $title);
	tpl_assign('iconclass', 'ico-large-event');

	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>