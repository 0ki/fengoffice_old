<?php

	/*
	* Első magyar fordítás 1.3 verzióig: Váczy Attila <vaczy.a.m@gmail.com>
	* Magyar fordítás 1.4.2 verzióig (az 1.3 bázis részbeni újrafordításával, módosításával): Lukács Péter <programozo@lukacspeter.hu>
	*/

  return array(
	// ########## QUERY ERRORS ###########
	"CAL_QUERY_GETEVENT_ERROR" => "Adatbázis Hiba: Nem tudta ID szerint megtalálni az esemény",
	"CAL_QUERY_SETEVENT_ERROR" => "Adatbázis Hiba: Nem tudta beállítani az esemény adatot",
	// ########## SUBMENU ITEMS ###########
	"CAL_SUBM_LOGOUT" => "Kilépés",
	"CAL_SUBM_LOGIN" => "Belépés",
	"CAL_SUBM_ADMINPAGE" => "Admin Lap",
	"CAL_SUBM_SEARCH" => "Keresés",
	"CAL_SUBM_BACK_CALENDAR" => "Vissza a Naptárhoz",
	"CAL_SUBM_VIEW_TODAY" => "Mai események",
	"CAL_SUBM_ADD" => "Esemény a mai napra",
	// ########## NAVIGATION MENU ITEMS ##########
	"CAL_MENU_BACK_CALENDAR" => "Vissza a Naptárhoz",
	"CAL_MENU_NEWEVENT" => "Új esemény",
	"CAL_MENU_BACK_EVENTS" => "Vissza az eseményekehez",
	"CAL_MENU_GO" => "Ugrás",
	"CAL_MENU_TODAY" => "Ma",
	// ########## USER PERMISSION ERRORS ##########
	"CAL_NO_READ_PERMISSION" => "Nincs jogosultsága az esemény megtekintéséhez.",
	"CAL_NO_WRITE_PERMISSION" => " Nincs jogosultsága esemény hozzáadására ill. szerkesztésére.",
	"CAL_NO_EDITOTHERS_PERMISSION" => " Nincs jogosultsága mások eseményeinek szerkesztésére.",
	"CAL_NO_EDITPAST_PERMISSION" => " Nincs jogosultsága múltbeli esemény hozzáadására.",
	"CAL_NO_ACCOUNTS" => "Ez a naptár nem engedi a belépést; csak az adminisztrátor léphet be.",
	"CAL_NO_MODIFY" => "Nem változtatható",
	"CAL_NO_ANYTHING" => " Nincs jogosultsága változtatni ezen a lapon",
	"CAL_NO_WRITE", " Nincs jogosultsága új esemény létrehozására",
	// ############ DAYS ############
	"CAL_MONDAY" => "Hétfõ",
	"CAL_TUESDAY" => "Kedd",
	"CAL_WEDNESDAY" => "Szerda",
	"CAL_THURSDAY" => "Csütörtök",
	"CAL_FRIDAY" => "Péntek",
	"CAL_SATURDAY" => "Szombat",
	"CAL_SUNDAY" => "Vasárnap",
	"CAL_SHORT_MONDAY" => "H",
	"CAL_SHORT_TUESDAY" => "K",
	"CAL_SHORT_WEDNESDAY" => "Sze",
	"CAL_SHORT_THURSDAY" => "Cs",
	"CAL_SHORT_FRIDAY" => "P",
	"CAL_SHORT_SATURDAY" => "Szo",
	"CAL_SHORT_SUNDAY" => "V",
	// ############ MONTHS ############
	"CAL_JANUARY" => "Január",
	"CAL_FEBRUARY" => "Február",
	"CAL_MARCH" => "Március",
	"CAL_APRIL" => "Április",
	"CAL_MAY" => "Május",
	"CAL_JUNE" => "Június",
	"CAL_JULY" => "Július",
	"CAL_AUGUST" => "Augusztus",
	"CAL_SEPTEMBER" => "Szeptember",
	"CAL_OCTOBER" => "Október",
	"CAL_NOVEMBER" => "November",
	"CAL_DECEMBER" => "December",
	
	
	
	
	
	
	// SUBMITTING/EDITING EVENT SECTION TEXT (event.php)
	"CAL_MORE_TIME_OPTIONS" => "Az idõ további beállítása",
	"CAL_REPEAT" => "Ismétlõdõ",
	"CAL_EVERY" => "Minden",
	"CAL_REPEAT_FOREVER" => "Folyamatosan ismétlõdik",
	"CAL_REPEAT_UNTIL" => "-ig ismétlõdik",
	"CAL_TIMES" => "Idõ",
	"CAL_HOLIDAY_EXPLAIN" => "Ezzel megismétlődjön az eseményt minden",
	"CAL_DURING" => "Idõtartam",
	"CAL_EVERY_YEAR" => "Minden évben",
	"CAL_HOLIDAY_EXTRAOPTION" => "Vagy, mivel a hónap utolsó hetére esik, kattintson ide, hogy a végére kerüljön",
	"CAL_IN" => "ban/ben",
	"CAL_PRIVATE_EVENT_EXPLAIN" => "Ez magánesemény",
	"CAL_SUBMIT_ITEM" => "Elem bevitele",
	"CAL_MINUTES" => "Perc", 
	"CAL_MINUTES_SHORT" => "p",
	"CAL_TIME_AND_DURATION" => "Dátum, idõpont and idõtartam",
	"CAL_REPEATING_EVENT" => "Ismétlõdõ esemény",
	"CAL_EXTRA_OPTIONS" => "Extra opciók",
	"CAL_ONLY_TODAY" => "Csak ma",
	"CAL_DAILY_EVENT" => "Naponta ismétlõdõ",
	"CAL_WEEKLY_EVENT" => "Hetente ismétlõdõ",
	"CAL_MONTHLY_EVENT" => "Havonta ismétlõdõ",
	"CAL_YEARLY_EVENT" => "Évente ismétlõdõ",
	"CAL_HOLIDAY_EVENT" => "Ismétlõdõ ünnep",
	"CAL_UNKNOWN_TIME" => "Ismeretlen kezdõ idõpont",
	"CAL_ADDING_TO" => "Hozzáadás",
	"CAL_ANON_ALIAS" => "Álnév",
	"CAL_EVENT_TYPE" => "Esemény típusa",
	
	// MULTI-SECTION RELATED TEXT (used by more than one section, but not everwhere)
	"CAL_DESCRIPTION" => "Leírás", // (search, view date, view event)
	"CAL_DURATION" => "Idõtartam", // (view event, view date)
	"CAL_DATE" => "Dátum", // (search, view date)
	"CAL_NO_EVENTS_FOUND" => "Nem található esemény", // (search, view date)
	"CAL_NO_SUBJECT" => "Nincs tárgy", // (search, view event, view date, calendar)
	"CAL_PRIVATE_EVENT" => "Magán esemény", // (search, view event)
	"CAL_DELETE" => "Törlés", // (view event, view date, admin)
	"CAL_MODIFY" => "Módosítás", // (view event, view date, admin)
	"CAL_NOT_SPECIFIED" => "Nincs meghatározva", // (view event, view date, calendar)
	"CAL_FULL_DAY" => "Egész nap", // (view event, view date, calendar, submit event)
	"CAL_HACKING_ATTEMPT" => "Betörési Kísérlet - az IP cím naplózva", // (delete)
	"CAL_TIME" => "Idõ", // (view date, submit event)
	"CAL_HOURS" => "Óra", // (view event, submit event)
	"CAL_HOUR" => "Óra", // (view event, submit event)
	"CAL_ANONYMOUS" => "Anonymous", // (view event, view date, submit event),
	
	
	"CAL_SELECT_TIME" => "Válasszon kezdõ idõpontot",
	
	'event invitations' => 'Meghívók az eseményre',
	'event invitations desc' => 'Hívjon meg kiválasztott embereket az eseményre',
	'send new event notification' => 'Küldjön email emlékeztetõt',
	'new event notification' => 'Az új esemény hozzáadva',
    'change event notification' => 'Az esemény megváltoztatva',
	'deleted event notification' => 'Az esemény törölve',
	'attendance' => 'Részt veszel?',
    'confirm attendance' => 'A részvétel megerõsítése',
    'maybe' => 'Talán',
    'decide later' => 'Késõbb döntök',
    'view event' => 'Az esemény megtekintése',
	'new event created' => 'Az új esemény elkészült',
	'event changed' => 'Az esemény megváltozott',
 	'event deleted' => 'Az esemény törölve',
	'calendar of' => 'Naptár {0} részére',
	'all users' => 'Minden felhasználónak',
  	'error delete event' => 'Hiba az esemény törlése során',  
  	'event invitation response' => 'Meghívás eseményre válasz',
  	'user will attend to event' => '{0} részt fog venni az eseményen.',
  	'user will not attend to event' => '{0} nem fog részt venni az eseményen',  
  
	"days" => "nap",
	"weeks" => "het",
	"months" => "hónap",
	"years" => "év",

	'invitations' => 'Meghívók',
	'pending response' => 'Függõ válaszok',
	'participate' => 'Részt fog venni',
 	'no invitations to this event' => 'Nem lett meghívó küldve errõl az eseményrõl',
	'duration must be at least 15 minutes' => 'Az idõtartam minimum 15 perc',
  
	'event dnx' => 'A kért esemény nem létezik',
	'no subject' => 'Nincs tárgy',
	'success import events' => '{0} esemény importálva.',
	'no events to import' => 'Nincs importálandó esemény',
	'import events from file' => 'Esemény importálva a file-ból',
	'file should be in icalendar format' => 'A fájlnak naptár formátumúnak kell lennie',
	'export calendar' => 'Naptár exportálás',
	'range of events' => 'Esemény hatókör',
	'from date' => 'Feladó',
	'to date' => 'Címzett',
	'success export calendar' => '{0} esemény exportálva.',
	'calendar name desc' => 'Az exportálandó naptár neve',
	'calendar will be exported in icalendar format' => 'A naptár iCalendar formátumban lesz exportálva.',
	'view date title' => 'l, Y. m. d.',  
	
		'copy this url in your calendar client software' => 'Ha eseményeket akar átvinni naptárszoftverébe, másolja át kliensébe a következő hivatkozást',
	'import events from third party software' => 'Események importálása külső szoftverből',
	'subws' => 'Alproj.',
	'check to include sub ws' => 'Jelölje be ha azt akarja, hogy az alprojekteket is tartalmazza a hivatkozás',
  	'week short' => 'Hét',
  	'week number x' => '{0}. hét',
  ); // array
?>

