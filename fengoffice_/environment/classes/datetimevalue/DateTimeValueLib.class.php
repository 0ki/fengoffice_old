<?php

  /**
  * This class is used to produce DateTimeValue object based on timestamos, strings etc
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class DateTimeValueLib {
  
    /**
    * Returns current time object
    *
    * @param void
    * @return DateTimeValue
    */
    static function now() {
      return new DateTimeValue(time());
    } // now
    
    /**
    * This function works like mktime, just it always returns GMT
    *
    * @param integer $hour
    * @param integer $minute
    * @param integer $second
    * @param integer $month
    * @param integer $day
    * @param integer $year
    * @return DateTimeValue
    */
    static function make($hour, $minute, $second, $month, $day, $year) {
      return new DateTimeValue(mktime($hour, $minute, $second, $month, $day, $year));
    } // make
    
    /**
    * Make time from string using strtotime() function. This function will return null
    * if it fails to convert string to the time
    *
    * @param string $str
    * @return DateTimeValue
    */
    static function makeFromString($str) {
      $timestamp = strtotime($str);// + date('Z');
      return ($timestamp === false) || ($timestamp === -1) ? null : new DateTimeValue($timestamp);
    } // makeFromString
  
    /**
     * Function to calculate date or time difference.
     *
     * Function to calculate date or time difference. Returns an array or
     * false on error.
     *
     * @author       J de Silva                             <giddomains@gmail.com>
     * @copyright    Copyright &copy; 2005, J de Silva
     * @link         http://www.gidnetwork.com/b-16.html    Get the date / time difference with PHP
     * @param        int                                 $start
     * @param        int                                 $end
     * @return       array
     */
    static function get_time_difference($start, $end, $subtract = 0)
    {
    	$uts['start']      = $start;
    	$uts['end']        = $end;
    	if( $uts['start']!==-1 && $uts['end']!==-1 )
    	{
    		if( $uts['end'] >= $uts['start'] ){
    			$diff    =    $uts['end'] - $uts['start'];
    			$sign = 1;
    		} else {
    			$diff    =    $uts['start'] - $uts['end'];
    			$sign = -1;
    		}
    		
    		$diff -= $subtract;
    		
    		if( $days=intval((floor($diff/86400))) )
    			$diff = $diff % 86400;
    		if( $hours=intval((floor($diff/3600))) )
    			$diff = $diff % 3600;
    		if( $minutes=intval((floor($diff/60))) )
    			$diff = $diff % 60;
    		$diff    =    intval( $diff );
    		
    		return( array('days'=>$days * $sign, 'hours'=>$hours * $sign, 'minutes'=>$minutes * $sign, 'seconds'=>$diff * $sign) );
    	}
    	else
    	{
    		throw new Exception("Invalid date/time data detected");
    	}
    	return false;
    }

    
  } // DateTimeValueLib

?>