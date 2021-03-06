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


/*

	This file defines the phrases and words used throughout the program.
	It is seperated into 2 main sections:
		1) general words and errors used throughout the program
		2) words/phrases/errors/confirmations used by specifiec sections
	
	To add new languages, simply translate this file and place it into the "languages" folder.
	Once there, it will be an option in the admin menu for you to choose.
	Please note though that the file extension *must* be "php"
	
	If you do translate this file, please email it to me at:  reece.pegues@gmail.com
	Also, please post a link to it on the project forum at sourceforge so others can use it!
	
*/








/*  
	THIS STARTS THE SECTION THAT LISTS THE COMMON WORDS AND ERRORS
	USED BY THE ENTIRE PROGRAM
*/

########## QUERY ERRORS ###########
define("CAL_QUERY_GETEVENT_ERROR","Database Error: Failed fetching event by ID");
define("CAL_QUERY_SETEVENT_ERROR","Database Error: Failed to Set Event Data");
########## SUBMENU ITEMS ###########
define("CAL_SUBM_LOGOUT","Log Out");
define("CAL_SUBM_LOGIN","Log In");
define("CAL_SUBM_ADMINPAGE","Admin Page");
define("CAL_SUBM_SEARCH","Search");
define("CAL_SUBM_BACK_CALENDAR","Back to Calendar");
define("CAL_SUBM_VIEW_TODAY","View Today's Events");
define("CAL_SUBM_ADD","Add Event Today");
########## NAVIGATION MENU ITEMS ##########
define("CAL_MENU_BACK_CALENDAR","Back to Calendar");
define("CAL_MENU_NEWEVENT","New Event");
define("CAL_MENU_BACK_EVENTS","Back To Events");
define("CAL_MENU_GO","Go");
define("CAL_MENU_TODAY","Today");
########## USER PERMISSION ERRORS ##########
define("CAL_NO_READ_PERMISSION","You do not have permission to view the event.");
define("CAL_NO_WRITE_PERMISSION","You do not have permission to add or edit events.");
define("CAL_NO_EDITOTHERS_PERMISSION","You do not have permission to edit other user's events.");
define("CAL_NO_EDITPAST_PERMISSION","You do not have permission to add or edit events in the past.");
define("CAL_NO_ACCOUNTS","This calendar does not allow accounts; only root can log on.");
define("CAL_NO_MODIFY","can't modify");
define("CAL_NO_ANYTHING","You don't have permission to do anything on this page");
define("CAL_NO_WRITE", "You do not have permission to create new events");
############ DAYS ############
define("CAL_MONDAY","Monday");
define("CAL_TUESDAY","Tuesday");
define("CAL_WEDNESDAY","Wednesday");
define("CAL_THURSDAY","Thursday");
define("CAL_FRIDAY","Friday");
define("CAL_SATURDAY","Saturday");
define("CAL_SUNDAY","Sunday");
define("CAL_SHORT_MONDAY","M");
define("CAL_SHORT_TUESDAY","T");
define("CAL_SHORT_WEDNESDAY","W");
define("CAL_SHORT_THURSDAY","T");
define("CAL_SHORT_FRIDAY","F");
define("CAL_SHORT_SATURDAY","S");
define("CAL_SHORT_SUNDAY","S");
############ MONTHS ############
define("CAL_JANUARY","January");
define("CAL_FEBRUARY","February");
define("CAL_MARCH","March");
define("CAL_APRIL","April");
define("CAL_MAY","May");
define("CAL_JUNE","June");
define("CAL_JULY","July");
define("CAL_AUGUST","August");
define("CAL_SEPTEMBER","September");
define("CAL_OCTOBER","October");
define("CAL_NOVEMBER","November");
define("CAL_DECEMBER","December");






// SUBMITTING/EDITING EVENT SECTION TEXT (event.php)
define("CAL_MORE_TIME_OPTIONS","More Time Options");
define("CAL_REPEAT","Repeat");
define("CAL_EVERY","Every");
define("CAL_REPEAT_FOREVER","Repeat Forever");
define("CAL_REPEAT_UNTIL","Repeat Until");
define("CAL_TIMES","Times");
define("CAL_HOLIDAY_EXPLAIN","This will make the Event Repeat on the");
define("CAL_DURING","During");
define("CAL_EVERY_YEAR","Every Year");
define("CAL_HOLIDAY_EXTRAOPTION","Or, since this falls on the last week of the month, Check here to make the event fall on the LAST");
define("CAL_IN","in");
define("CAL_PRIVATE_EVENT_EXPLAIN","This is a private event");
define("CAL_SUBMIT_ITEM","Submit Item");
define("CAL_MINUTES","Minutes"); 
define("CAL_TIME_AND_DURATION","Date, Time and Duration");
define("CAL_REPEATING_EVENT","Repeating Event");
define("CAL_EXTRA_OPTIONS","Extra Options");
define("CAL_ONLY_TODAY","This Day Only");
define("CAL_DAILY_EVENT","Repeating Daily");
define("CAL_WEEKLY_EVENT","Repeating Weekly");
define("CAL_MONTHLY_EVENT","Repeating Monthly");
define("CAL_YEARLY_EVENT","Repeating Yearly");
define("CAL_HOLIDAY_EVENT","Holiday Repeating");
define("CAL_UNKNOWN_TIME","Unknown Starting Time");
define("CAL_ADDING_TO","Adding To");
define("CAL_ANON_ALIAS","Alias Name");
define("CAL_EVENT_TYPE","Event Type");
define("CAL_STARTING_TIME","Time");

// MULTI-SECTION RELATED TEXT (used by more than one section, but not everwhere)
define("CAL_DESCRIPTION","Description"); // (search, view date, view event)
define("CAL_DURATION","Duration"); // (view event, view date)
define("CAL_DATE","Date"); // (search, view date)
define("CAL_NO_EVENTS_FOUND","No events found"); // (search, view date)
define("CAL_NO_SUBJECT","No Subject"); // (search, view event, view date, calendar)
define("CAL_PRIVATE_EVENT","Private Event"); // (search, view event)
define("CAL_DELETE","Delete"); // (view event, view date, admin)
define("CAL_MODIFY","Modify"); // (view event, view date, admin)
define("CAL_NOT_SPECIFIED","Not Specified"); // (view event, view date, calendar)
define("CAL_FULL_DAY","All Day"); // (view event, view date, calendar, submit event)
define("CAL_HACKING_ATTEMPT","Hacking Attempt - IP address logged"); // (delete)
define("CAL_TIME","Time"); // (view date, submit event)
define("CAL_HOURS","Hours"); // (view event, submit event)
define("CAL_HOUR","Hour"); // (view event, submit event)
define("CAL_ANONYMOUS","Anonymous"); // (view event, view date, submit event)





?>
