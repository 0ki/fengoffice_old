<?
require 'Calendar.php';
class OGCalendar extends Calendar { 
	function getCalendarLink($month, $year) { 
		// Redisplay the current page, but with some parameters 
		// to set the new month and year 
		//$s = getenv('SCRIPT_NAME'); return "$s?month=$month&year=$year"; 
		
		return get_url('event','index',
					 		array("miniyear"=> $year,
					 			 "minimonth" => $month
					 			 )
				 		);
	}
	
	function getDateLink($day, $month, $year) { 
		$link = cal_getlink("index.php?action=viewdate&day=".$day."&month=$month&year=$year");
								
		return $link; 
	}
}
?>