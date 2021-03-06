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