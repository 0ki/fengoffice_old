<?php

  return array(
	// ########## QUERY ERRORS ###########
	"CAL_QUERY_GETEVENT_ERROR" => "Database Error: Failed fetching event by ID",
	"CAL_QUERY_SETEVENT_ERROR" => "Database Error: Failed to Set Event Data",
	// ########## SUBMENU ITEMS ###########
	"CAL_SUBM_LOGOUT" => "Log Out",
	"CAL_SUBM_LOGIN" => "Log In",
	"CAL_SUBM_ADMINPAGE" => "Admin Page",
	"CAL_SUBM_SEARCH" => "Search",
	"CAL_SUBM_BACK_CALENDAR" => "Back to Calendar",
	"CAL_SUBM_VIEW_TODAY" => "View Today's Events",
	"CAL_SUBM_ADD" => "Add Event Today",
	// ########## NAVIGATION MENU ITEMS ##########
	"CAL_MENU_BACK_CALENDAR" => "Back to Calendar",
	"CAL_MENU_NEWEVENT" => "New Event",
	"CAL_MENU_BACK_EVENTS" => "Back To Events",
	"CAL_MENU_GO" => "Go",
	"CAL_MENU_TODAY" => "Today",
	// ########## USER PERMISSION ERRORS ##########
	"CAL_NO_READ_PERMISSION" => "You do not have permission to view the event.",
	"CAL_NO_WRITE_PERMISSION" => "You do not have permission to add or edit events.",
	"CAL_NO_EDITOTHERS_PERMISSION" => "You do not have permission to edit other user's events.",
	"CAL_NO_EDITPAST_PERMISSION" => "You do not have permission to add or edit events in the past.",
	"CAL_NO_ACCOUNTS" => "This calendar does not allow accounts; only root can log on.",
	"CAL_NO_MODIFY" => "can't modify",
	"CAL_NO_ANYTHING" => "You don't have permission to do anything on this page",
	"CAL_NO_WRITE", "You do not have permission to create new events",
	// ############ DAYS ############
	"CAL_MONDAY" => "Poniedziałek",
	"CAL_TUESDAY" => "Wtorek",
	"CAL_WEDNESDAY" => "Środa",
	"CAL_THURSDAY" => "Czwartek",
	"CAL_FRIDAY" => "Piątek",
	"CAL_SATURDAY" => "Sobota",
	"CAL_SUNDAY" => "Niedziela",
	"CAL_SHORT_MONDAY" => "P",
	"CAL_SHORT_TUESDAY" => "W",
	"CAL_SHORT_WEDNESDAY" => "Ś",
	"CAL_SHORT_THURSDAY" => "C",
	"CAL_SHORT_FRIDAY" => "P",
	"CAL_SHORT_SATURDAY" => "S",
	"CAL_SHORT_SUNDAY" => "N",
	// ############ MONTHS ############
	"CAL_JANUARY" => "Styczeń",
	"CAL_FEBRUARY" => "Luty",
	"CAL_MARCH" => "Marzec",
	"CAL_APRIL" => "Kwiecień",
	"CAL_MAY" => "Maj",
	"CAL_JUNE" => "Czerwiec",
	"CAL_JULY" => "Lipiec",
	"CAL_AUGUST" => "SIerpień",
	"CAL_SEPTEMBER" => "Wrzesień",
	"CAL_OCTOBER" => "Październik",
	"CAL_NOVEMBER" => "Listopad",
	"CAL_DECEMBER" => "Grudzień",
	
	
	
	
	
	
	// SUBMITTING/EDITING EVENT SECTION TEXT (event.php)
	"CAL_MORE_TIME_OPTIONS" => "More Time Options",
	"CAL_REPEAT" => "Repeat",
	"CAL_EVERY" => "Every",
	"CAL_REPEAT_FOREVER" => "Repeat Forever",
	"CAL_REPEAT_UNTIL" => "Repeat Until",
	"CAL_TIMES" => "Times",
	"CAL_HOLIDAY_EXPLAIN" => "This will make the Event Repeat on the",
	"CAL_DURING" => "During",
	"CAL_EVERY_YEAR" => "Every Year",
	"CAL_HOLIDAY_EXTRAOPTION" => "Or, since this falls on the last week of the month, Check here to make the event fall on the LAST",
	"CAL_IN" => "in",
	"CAL_PRIVATE_EVENT_EXPLAIN" => "This is a private event",
	"CAL_SUBMIT_ITEM" => "Submit Item",
	"CAL_MINUTES" => "Minutes", 
	"CAL_MINUTES_SHORT" => "min",
	"CAL_TIME_AND_DURATION" => "Date, Time and Duration",
	"CAL_REPEATING_EVENT" => "Repeating Event",
	"CAL_EXTRA_OPTIONS" => "Extra Options",
	"CAL_ONLY_TODAY" => "This Day Only",
	"CAL_DAILY_EVENT" => "Repeating Daily",
	"CAL_WEEKLY_EVENT" => "Repeating Weekly",
	"CAL_MONTHLY_EVENT" => "Repeating Monthly",
	"CAL_YEARLY_EVENT" => "Repeating Yearly",
	"CAL_HOLIDAY_EVENT" => "Holiday Repeating",
	"CAL_UNKNOWN_TIME" => "Unknown Starting Time",
	"CAL_ADDING_TO" => "Adding To",
	"CAL_ANON_ALIAS" => "Alias Name",
	"CAL_EVENT_TYPE" => "Event Type",
	
	// MULTI-SECTION RELATED TEXT (used by more than one section, but not everwhere)
	"CAL_DESCRIPTION" => "Description", // (search, view date, view event)
	"CAL_DURATION" => "Duration", // (view event, view date)
	"CAL_DATE" => "Date", // (search, view date)
	"CAL_NO_EVENTS_FOUND" => "No events found", // (search, view date)
	"CAL_NO_SUBJECT" => "No Subject", // (search, view event, view date, calendar)
	"CAL_PRIVATE_EVENT" => "Private Event", // (search, view event)
	"CAL_DELETE" => "Delete", // (view event, view date, admin)
	"CAL_MODIFY" => "Modify", // (view event, view date, admin)
	"CAL_NOT_SPECIFIED" => "Not Specified", // (view event, view date, calendar)
	"CAL_FULL_DAY" => "All Day", // (view event, view date, calendar, submit event)
	"CAL_HACKING_ATTEMPT" => "Hacking Attempt - IP address logged", // (delete)
	"CAL_TIME" => "Time", // (view date, submit event)
	"CAL_HOURS" => "Hours", // (view event, submit event)
	"CAL_HOUR" => "Hour", // (view event, submit event)
	"CAL_ANONYMOUS" => "Anonymous", // (view event, view date, submit event),
	
	
	"CAL_SELECT_TIME" => "Select Starting Time",
	
	'event invitations' => 'Event Invitations',
	'event invitations desc' => 'Invite selected people to this event',
	'send new event notification' => 'Send email notifications',
	'new event notification' => 'New event has been added',
    'change event notification' => 'Event has changed',
	'deleted event notification' => 'Event has been deleted',
	'attendance' => 'Will you participate?',
    'confirm attendance' => 'Confirm Attendance',
    'maybe' => 'Maybe',
    'decide later' => 'Decide later',
    'view event' => 'View event',
	'new event created' => 'New Event created',
	'event changed' => 'Event changed',
 	'event deleted' => 'Event deleted',
	'calendar of' => '{0}\'s Calendar',
	'all users' => 'All Users',
  	'error delete event' => 'Error deleting event',  
  
	"days" => "days",
	"weeks" => "weeks",
	"months" => "months",
	"years" => "years",

	'invitations' => 'Invitations',
	'pending response' => 'Pending response',
	'participate' => 'Will attend',
 	'no invitations to this event' => 'No invitations were sent to this event',
	'duration must be at least 15 minutes' => 'Duration must be at least 15 minutes',
  
	'event dnx' => 'Requested event does not exists',
	'no subject' => 'No Subject',
	'success import events' => '{0} events were imported.',
	'no events to import' => 'There are no events for import',
	'import events from file' => 'Event import from file',
	'file should be in icalendar format' => 'File should be in iCalendar format',
	'export calendar' => 'Calendar export',
	'range of events' => 'Event range',
	'from date' => 'From',
	'to date' => 'To',
	'success export calendar' => '{0} Events were exported.',
	'calendar name desc' => 'Name for the calendar to export',
	'calendar will be exported in icalendar format' => 'Calendar will be exported in iCalendar format.',
  
  ); // array
?>