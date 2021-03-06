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


/* ##################################################################
  cal_error()
   Used to print nice error messages
###################################################################*/
function cal_error($s){
	return "<br><span class='failure'>$s</span><br>";
}


/* ##################################################################
  cal_submenu()
   returns the menu of links to other parts of the calendar
   such as the admin page or search page, as well as login/logout
   (these are the links at the bottom of the page)
###################################################################*/
function cal_submenu($year, $month, $day){
/*	$day = $_SESSION['cal_day'];
	$month = $_SESSION['cal_month'];
	$year = $_SESSION['cal_year'];
	$today = "year=".date('Y')."&month=".date("n")."&day=".date("d");
	// start output
	$output="";
	$output.= "<div id='navbar'>";
	$action = $_SESSION['cal_action'];
	// start the buttons
	if(!cal_anon()) $output .= " <a  class='internalLink' href=\"".cal_getlink("index.php?c=event&action=logout")."\">" . CAL_SUBM_LOGOUT. "</a> | ";
	else $output .= " <a  class='internalLink' href=\"".cal_getlink("index.php?c=event&action=login")."\">" .CAL_SUBM_LOGIN. "</a> | ";
	if(cal_admin()) $output .= " <a class='internalLink'  href=\"".cal_getlink("index.php?c=event&action=admin")."\">" .CAL_SUBM_ADMINPAGE. "</a> | ";
	$output .= " <a  class='internalLink' href=\"".cal_getlink("index.php?c=event&action=search")."\">" .CAL_SUBM_SEARCH. "</a>";
	if($_SESSION['cal_action']!="" AND $_SESSION['cal_action']!="calendar" AND $_SESSION['cal_action']!="logout") $output .= " | <a  class='internalLink' href=\"".cal_getlink("index.php?c=event&action=calendar&month=$month&year=$year")."\">" .  CAL_SUBM_BACK_CALENDAR . '</a>';
	if($action!="viewdate") $output .= " | <a  class='internalLink' href=\"".cal_getlink("index.php?c=event&action=viewdate&".$today)."\">" . CAL_SUBM_VIEW_TODAY. "</a>";
	if($action=="viewdate" AND cal_permission("write")) $output .= " | <a  class='internalLink' href=\"".cal_getlink("index.php?c=event&action=add&day=$day&month=$month&year=$year")."\">" .CAL_SUBM_ADD. "</a></div>";
	return $output;*/
return "";

}



/* ##################################################################
  cal_navmenu()
   returns the navigation buttons for the day/module
###################################################################*/
function cal_navmenu($show_date_title= true,$day,$month,$year){
	
	$a = array_var($_GET,'a');
	// make calculations
	if($a=="calendar" OR $a=="" OR $a=="admin" OR $a=="search"){
		$title = cal_month_name(date("m"))." ".date("Y");
	}else{
		$mtime = mktime(0, 0, 0, $month, $day, $year);
		$title = cal_month_name(date("m",$mtime))." ".date("j, Y", $mtime);
	}
	$tablename = date('Fy', mktime(0, 0, 0, $month, 1, $year));
	$monthname = cal_month_name($month);
	$lasttime = mktime(0, 0, 0, $month, $day - 1, $year);
	$pd = date('j', $lasttime);
	$pm = date('n', $lasttime);
	$py = date('Y', $lasttime);
	$nexttime = mktime(0, 0, 0, $month, $day + 1, $year);
	$nd = date('j', $nexttime);
	$nm = date('n', $nexttime);
	$ny = date('Y', $nexttime);
	if ( !$show_date_title) $title ='';
	// return menu output
	
	/*add_page_action(lang('back to calendar'), 'javascript:(function(){ Ext.getCmp(\'calendar-panel\').reset(); })()');

	$can_add = (!active_project() || ProjectEvent::canAdd(logged_user(),active_project()));
	if( ($a=="viewdate" OR $a=="delete" OR $a=="submitevent") AND  $can_add ) {		
 		add_page_action(lang('add event'), cal_getlink("index.php?action=add&year=$year&month=$month&day=$day") );
		
	}
	if($a=="add" OR $a=="modify" OR $a=="viewevent") {		
 		add_page_action(lang('back to day'), cal_getlink("index.php?c=event&action=viewdate&year=$year&month=$month&day=$day") );
		
	}
	if($a!="viewevent" AND $a!="search" AND $a!="search_results" AND $a!="admin" AND $a!="login"){
		 add_page_action(lang('previous day'), cal_getlink("index.php?c=event&a=viewdate&year=$py&month=$pm&day=$pd"));
		 add_page_action(lang('next day'), cal_getlink("index.php?c=event&a=viewdate&year=$ny&month=$nm&day=$nd"));
	
	}*/
}




/* ##################################################################
  cal_getlangs()
   looks for language files in the "languages" folder and returns a list.
###################################################################*/
function cal_getlangs(){
	$list = array();
	// make sure the languages folders exists
/*	if(!file_exists(CAL_INCLUDE_PATH."languages")) return "";
	// open the folder
	$handle=opendir(CAL_INCLUDE_PATH."languages");
	if(empty($handle)) return "";
	// loop through the files in the folder, create list of languages
	while ($file = readdir($handle)) {
		if ( (eregi("\.php$",$file)) ) {
			// notice skin names are seperated by two colons (::)
			$list[] =  substr($file, 0, strlen($file)-4);
		}
	}
	closedir($handle);*/
	return $list;
}



/* ##################################################################
  cal_getskins()
   looks for skin css files in the "skins" folder and returns a list
###################################################################*/
function cal_getskins(){
	$list = array();
/*	// make sure the skins folders exists
	if(!file_exists(CAL_INCLUDE_PATH."skins")) return "";
	// open the folder
	$handle = opendir(CAL_INCLUDE_PATH."skins");
	if(empty($handle)) return "";
	// loop through the files in the folder, create list of skins
	while ($file = readdir($handle)) {
		if ( (eregi("\.css$",$file)) ) {
			// notice skin names are seperated by two colons (::)
			$list[] =  substr($file, 0, strlen($file)-4);
		}
	}
	closedir($handle);*/
	return $list;
}




/* ##################################################################
  cal_getlink()
   returns the link with added GET querys from $link_tail.
###################################################################*/
function cal_getlink($link){
	global $cal_link_tail;
	// if we use a different filename, replace index.php with the one we use
	/*if(CAL_URL_FILENAME!="index.php"){
		$link = str_replace("index.php",CAL_URL_FILENAME,$link);
	}*/
	$link .= '&c=event';	
	$link = str_replace('?action=','?a=',$link);
	$link = str_replace('&action=','&a=',$link);	
	if($cal_link_tail=="") return $link;
	else if(eregi("\?",$link)) return $link ."&amp;". $cal_link_tail;
	else return $link ."?". $cal_link_tail;	
}


/* ##################################################################
  cal_add_to_links()
   adds GET querys to every link used on the page.
   Made to help simplify adding querys for things like
   skins, usernames, passwords, and of course for modularity.
   useage:  add_to_links("skin=".$skin_name);
   
   Basically, you can use this whole program as a module in something like
   php-nuke or postnuke by adding variables they need to every link's query.
###################################################################*/
function cal_add_to_links($add){
	global $cal_link_tail;
	if((!isset($link_tail )) || $link_tail == "") $link_tail = $add;
	else $link_tail .= "&amp;".$add;
}





/* ##################################################################
  cal_month_name()
   Returns the full month name when given a number.
   (number is modded 12)
###################################################################*/
function cal_month_name($month){
	$month = ($month - 1) % 12 + 1;
	switch($month) {
		case 1:  return CAL_JANUARY;
		case 2:  return CAL_FEBRUARY;
		case 3:  return CAL_MARCH;
		case 4:  return CAL_APRIL;
		case 5:  return CAL_MAY;
		case 6:  return CAL_JUNE;
		case 7:  return CAL_JULY;
		case 8:  return CAL_AUGUST;
		case 9:  return CAL_SEPTEMBER;
		case 10: return CAL_OCTOBER;
		case 11: return CAL_NOVEMBER;
		case 12: return CAL_DECEMBER;
	}
}



/* ##################################################################
  cal_month_short()
   same as month_name() above except it returns an abreviation.
###################################################################*/
function cal_month_short($month){
	$month = ($month - 1) % 12 + 1;
	switch($month) {
		case 1:  return substr(CAL_JANUARY,0,3);
		case 2:  return substr(CAL_FEBRUARY,0,3);
		case 3:  return substr(CAL_MARCH,0,3);
		case 4:  return substr(CAL_APRIL,0,3);
		case 5:  return substr(CAL_MAY,0,3);
		case 6:  return substr(CAL_JUNE,0,3);
		case 7:  return substr(CAL_JULY,0,3);
		case 8:  return substr(CAL_AUGUST,0,3);
		case 9:  return substr(CAL_SEPTEMBER,0,3);
		case 10: return substr(CAL_OCTOBER,0,3);
		case 11: return substr(CAL_NOVEMBER,0,3);
		case 12: return substr(CAL_DECEMBER,0,3);
	}
}



/* ##################################################################
  cal_top()
   returns the header information,
   css stylesheet file links (acording to which skin is loaded) etc
###################################################################*/
function cal_top(){
	
	// print the beginning of the calendar module
	$output = '
		<script type="text/javascript">
		
			function cal_toggle(id){
				obj = document.getElementById(id);
				if(obj.style.display=="none"){
					obj.style.display = "block";
				}else{
					obj.style.display = "none";
				}
			}
			function cal_hide(id){
				document.getElementById(id).style.display = "none";
			}
			function cal_show(id){
				document.getElementById(id).style.display = "block";
			}
		</script>
		<!-- overlib -->
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
		<!-- start main calendar tables -->';
	return $output;	
}




/* ##################################################################
  cal_bottom()
   ends the html file.
###################################################################*/
function cal_bottom(){
	// get date stuff
	$day = $_SESSION['cal_day'];
	$month = $_SESSION['cal_month'];
	$year = $_SESSION['cal_year'];
	// start output
	$output = cal_submenu($year, $month, $day);
	//$output .= '<br></td></tr></table></td></tr></table>';
	return $output;
}


/* ##################################################################
  cal_easter_orthodox()
	Takes any Gregorian date and returns the Gregorian
	date of Orthodox Easter for that year.
###################################################################*/
function cal_easter_orthodox($year){
	$year = date("Y", mktime(0,0,1,1,1,$year));
	$r1 = $year % 19;
	$r2 = $year % 4;
	$r3 = $year % 7;
	$ra = 19 * $r1 + 16;
	$r4 = $ra % 30;
	$rb = 2 * $r2 + 4 * $r3 + 6 * $r4;
	$r5 = $rb % 7;
	$rc = $r4 + $r5;
	//Orthodox Easter for this year will fall $rc days after April 3
	return date("Y-m-d",strtotime("3 April $year + $rc days"));
}



?>