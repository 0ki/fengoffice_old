<?php

	
//	Copyright (c) Reece Pegues
//	sitetheory.com
//
//    Reece PHP Calendar is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or 
//	any later version if you wish.
//
//    You should have received a copy of the GNU General Public License
//    along with this file; if not, write to the Free Software
//    Foundation Inc, 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	

// @var $event ProjectEvent

if (isset($event) && $event instanceof ProjectEvent) {
	$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : logged_user()->getId();
	
	if (!$event->isTrashed()){
		if($event->canEdit(logged_user())) {
			add_page_action(lang('edit'), $event->getEditUrl()."&view=$view&user_id=$user_id", 'ico-edit');
		}
	}
		
	if($event->canDelete(logged_user())) {
		if ($event->isTrashed()) {
	    	add_page_action(lang('restore from trash'), "javascript:if(confirm(lang('confirm restore objects'))) og.openLink('" . $event->getUntrashUrl() ."');", 'ico-restore');
	    	add_page_action(lang('delete permanently'), "javascript:if(confirm(lang('confirm delete permanently'))) og.openLink('" . $event->getDeletePermanentlyUrl() ."');", 'ico-delete');
	    } else {
	    	add_page_action(lang('move to trash'), "javascript:if(confirm(lang('confirm move to trash'))) og.openLink('" . $event->getTrashUrl() ."');", 'ico-trash');
	    }
	} // if

	$modified="";
	$error = "";
	// Do this if we are MODIFYING a form.
	$id = $_GET['id'];
	
    if(!is_numeric($id)) $error = lang('CAL_NO_EVENT_SELECTED');
	// get user who submitted the event, subject, event description, etc.
    $username = clean($event->getCreatedBy()->getUsername());
    $subject = clean($event->getSubject());
	$private = $event->getIsPrivate();
	$alias = clean($event->getCreatedBy()->getUsername());
    $desc = clean($event->getDescription());
    $start_time = $event->getStart();
	$mod_username = clean($event->getUpdatedBy()->getUsername());
	$mod_stamp = $event->getUpdatedOn();
	
	// check username to see if it's anonymous or not
	if($username=="") $username = lang('CAL_ANONYMOUS');
	
	if($mod_username=="") $mod_username = lang('CAL_ANONYMOUS');
	
	// if the event is private and the user is anonymous, return that the event does not exist.
	if($private AND cal_anon() AND $error=="") $error = lang('CAL_DOESNT_EXIST');
	
    $durtime = $event->getDuration()->getTimestamp() - $start_time->getTimestamp();
    $durmin = ($durtime / 60) % 60;     //seconds per minute
    $durhr  = ($durtime / 3600) % 24;   //seconds per hour
    $durday = floor($durtime / 86400);  //seconds per day

	if(config_option('time_format_use_24')) $timeformat = 'G:i';
	else $timeformat = 'g:i A';
	$time = date($timeformat, $start_time->getTimestamp());
	
	// organize duration of event
	$duration = '';
	if ($durday > 0) $duration .= $durday . ' '.lang('days').($durhr!="1" ? ', ' : ' ');
	$duration .= $durhr . ' ';
	if($durhr!="1") $duration .= lang('CAL_HOURS');
	else $duration .= lang('CAL_HOUR');
	if($durmin!="0") $duration .= ", ". $durmin. " ". lang('CAL_MINUTES_SHORT');
	
	// organize other time options for the event
    $typeofevent = $event->getTypeId();
	if($typeofevent=="2") $duration = lang('CAL_FULL_DAY');
	elseif($typeofevent=="3"){
		$time = lang('CAL_NOT_SPECIFIED');
		$duration = lang('CAL_NOT_SPECIFIED');
	}
	elseif($typeofevent=="4") $duration = lang('CAL_NOT_SPECIFIED');
	
	$permission = ProjectEvents::findById($id)->canEdit(logged_user());
	
?>
<div style="padding:7px;">
<div class="event" style="height:100%;">

<?php
	
	$title = Localization::instance()->formatDescriptiveDate($event->getStart()) . ' - ' . clean($event->getSubject());
	$description = $event->getTypeId() == 2 ? lang('CAL_FULL_DAY') : lang('CAL_TIME').": $time" ;
  	tpl_assign('description', $description);

	$att_form = '';
  	if (!$event->isNew() && !$event->isTrashed()) {
		$event_inv = EventInvitations::findById(array('event_id' => $event->getId(), 'user_id' => $user_id));
		if ($event_inv != null) {
			$event->addInvitation($event_inv);
			$event_inv_state = $event_inv->getInvitationState();
			$options = array(
				option_tag(lang('yes'), 1, ($event_inv_state == 1)?array('selected' => 'selected'):null),
				option_tag(lang('no'), 2, ($event_inv_state == 2)?array('selected' => 'selected'):null),
				option_tag(lang('maybe'), 3, ($event_inv_state == 3)?array('selected' => 'selected'):null)
			);
			if ($event_inv_state == 0) {
				$options[] = option_tag(lang('decide later'), 0, ($event_inv_state == 0) ? array('selected' => 'selected'):null);
			}
			
			$att_form = '<form style="height:100%;background-color:white" class="internalForm" action="' . get_url('event', 'change_invitation_state') . '" method="post">';
			$att_form .= '<table><tr><td style="padding-right:6px;"><b>' . lang('attendance') . '<b></td><td>';
			$att_form .= select_box('event_attendance', $options, array('id' => 'viewEventFormComboAttendance')) . '</td><td>';
			$att_form .= input_field('event_id', $event->getId(), array('type' => 'hidden'));
			$att_form .= input_field('user_id', $user_id, array('type' => 'hidden'));
			$att_form .= submit_button(lang('Save'), null, array('style'=>'margin-top:0px;margin-left:10px')) . '</td></tr></table></form>';
		} //if
	} // if

	$otherInvitationsTable = '';
	if (!$event->isNew()) {
		$otherInvitations = EventInvitations::findAll(array ('conditions' => 'event_id = ' . $event->getId() . ' AND user_id <> ' . $user_id));
		if (isset($otherInvitations) && is_array($otherInvitations)) {
			$otherInvitationsTable .= '<div class="coInputMainBlock adminMainBlock" style="width:70%;">';
			$otherInvitationsTable .= '<table style="width:100%;"><col width="50%" /><col width="50%" />';
			$otherInvitationsTable .= '<tr><th><b>' . lang('name') . '</b></th><th><b>' . lang('participate') . '</b></th></tr>';
			$isAlt = false;
			$cant = 0;
			foreach ($otherInvitations as $inv) {
				$inv_user = Users::findById($inv->getUserId());
				if ($inv_user->hasProjectPermission($event->getProject(), ProjectUsers::CAN_READ_EVENTS)) {
					$state_desc = lang('pending response');
					if ($inv->getInvitationState() == 1) $state_desc = lang('yes');
					else if ($inv->getInvitationState() == 2) $state_desc = lang('no');
					else if ($inv->getInvitationState() == 3) $state_desc = lang('maybe');
					$otherInvitationsTable .= '<tr'.($isAlt ? ' class="altRow"' : '').'><td>' . $inv_user->getDisplayName() . '</td><td>' . $state_desc . '</td></tr>';
					$isAlt = !$isAlt;
					$cant++;
				}
			}
			if ($cant > 0) $otherInvitationsTable .= '</table></div>';
			else $otherInvitationsTable = lang('no invitations to this event');
		} else {
			$otherInvitationsTable = lang('no invitations to this event');
		}
	}
	
	$variables = array();
	$variables['username'] = $username;
	if (isset($modtimeformat))
		$variables['modtimeformat'] = $modtimeformat;
	$variables['mod_username'] = $mod_username;
	$variables['time'] = $time;
	if (!$event->isNew()) {
		$variables['attendance'] = $att_form;
		$variables['other_invitations'] = $otherInvitationsTable;
	}
	$variables['duration'] = $duration;
	$variables['desc'] = $desc;
	
	
	
	tpl_assign("variables", $variables);
	tpl_assign("content_template", array('view_event', 'event'));
	tpl_assign('object', $event);
	tpl_assign('title', $title);
	tpl_assign('iconclass', $event->isTrashed()? 'ico-large-event-trashed' :  'ico-large-event');

	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>
<?php }//if isset ?>
