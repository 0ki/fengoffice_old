<?php

  return array(
	// ########## QUERY ERRORS ###########
	"CAL_QUERY_GETEVENT_ERROR" => "Erreur Base de données : Failed fetching event by ID",
	"CAL_QUERY_SETEVENT_ERROR" => "Erreur Base de données : Failed to Set Event Data",
	// ########## SUBMENU ITEMS ###########
	"CAL_SUBM_LOGOUT" => "Déconnecté",
	"CAL_SUBM_LOGIN" => "Connecté",
	"CAL_SUBM_ADMINPAGE" => "Page Admin",
	"CAL_SUBM_SEARCH" => "Recherche",
	"CAL_SUBM_BACK_CALENDAR" => "Retour au Calendrier",
	"CAL_SUBM_VIEW_TODAY" => "Voir les évènements du jour",
	"CAL_SUBM_ADD" => "Ajouter un évènement ce jour",
	// ########## NAVIGATION MENU ITEMS ##########
	"CAL_MENU_BACK_CALENDAR" => "Retour au Calendrier",
	"CAL_MENU_NEWEVENT" => "Nouvel évènement",
	"CAL_MENU_BACK_EVENTS" => "Retour aux évènements",
	"CAL_MENU_GO" => "Go",
	"CAL_MENU_TODAY" => "Aujourd\'hui",
	// ########## USER PERMISSION ERRORS ##########
	"CAL_NO_READ_PERMISSION" => "Vous n\'avez pas les droits pour voir cet évènement.",
	"CAL_NO_WRITE_PERMISSION" => "Vous n\'avez pas les droits pour ajouter ou modifier des &vènements.",
	"CAL_NO_EDITOTHERS_PERMISSION" => "Vous n\'avez pas les droits pour éditer les évènements d\'autres utilisateurs.",
	"CAL_NO_EDITPAST_PERMISSION" => "Vous n\'avez pas les droits to pour ajouter ou modifier des évènements passés.",
	"CAL_NO_ACCOUNTS" => "Ce calendrier n\'autorise aucun compte ; seul un administrateur a accès.",
	"CAL_NO_MODIFY" => "Ne peut modifier",
	"CAL_NO_ANYTHING" => "Vous n\'avez aucun droit sur cette page",
	"CAL_NO_WRITE", "Vous n\'avez pas les droits pour créer de nouveaux évènements",
	// ############ DAYS ############
	"CAL_MONDAY" => "Lundi",
	"CAL_TUESDAY" => "Mardi",
	"CAL_WEDNESDAY" => "Mercredi",
	"CAL_THURSDAY" => "Jeudi",
	"CAL_FRIDAY" => "Vendredi",
	"CAL_SATURDAY" => "Samedi",
	"CAL_SUNDAY" => "Dimanche",
	"CAL_SHORT_MONDAY" => "L",
	"CAL_SHORT_TUESDAY" => "M",
	"CAL_SHORT_WEDNESDAY" => "M",
	"CAL_SHORT_THURSDAY" => "J",
	"CAL_SHORT_FRIDAY" => "V",
	"CAL_SHORT_SATURDAY" => "S",
	"CAL_SHORT_SUNDAY" => "D",
	// ############ MONTHS ############
	"CAL_JANUARY" => "Janvier",
	"CAL_FEBRUARY" => "Février",
	"CAL_MARCH" => "Mars",
	"CAL_APRIL" => "Avril",
	"CAL_MAY" => "Mai",
	"CAL_JUNE" => "Juin",
	"CAL_JULY" => "Juillet",
	"CAL_AUGUST" => "Août",
	"CAL_SEPTEMBER" => "Septembre",
	"CAL_OCTOBER" => "Octobre",
	"CAL_NOVEMBER" => "Novembre",
	"CAL_DECEMBER" => "Décembre",
	
	
	
	
	
	
	// SUBMITTING/EDITING EVENT SECTION TEXT (event.php)
	"CAL_MORE_TIME_OPTIONS" => "Plus d\'options de temps",
	"CAL_REPEAT" => "Répété",
	"CAL_EVERY" => "Chaque",
	"CAL_REPEAT_FOREVER" => "Répété Toujours",
	"CAL_REPEAT_UNTIL" => "Répété Jusqu\'à",
	"CAL_TIMES" => "Fois",
	"CAL_HOLIDAY_EXPLAIN" => "Cela rendra l\'évènement répété plusieurs fois",
	"CAL_DURING" => "During",
	"CAL_EVERY_YEAR" => "Chaque année",
	"CAL_HOLIDAY_EXTRAOPTION" => "Or, since this falls on the last week of the month, Check here to make the event fall on the LAST",
	"CAL_IN" => "dans",
	"CAL_PRIVATE_EVENT_EXPLAIN" => "C\'est un évènement privé",
	"CAL_SUBMIT_ITEM" => "2lément soumis",
	"CAL_MINUTES" => "Minutes", 
	"CAL_MINUTES_SHORT" => "min",
	"CAL_TIME_AND_DURATION" => "Date, Heure & Durée",
	"CAL_REPEATING_EVENT" => "Évènement répété",
	"CAL_EXTRA_OPTIONS" => "Extra Options",
	"CAL_ONLY_TODAY" => "Ce jour seulement",
	"CAL_DAILY_EVENT" => "Répété chaque jour",
	"CAL_WEEKLY_EVENT" => "Répété chaque semaine",
	"CAL_MONTHLY_EVENT" => "Répété chaque mois",
	"CAL_YEARLY_EVENT" => "Répété chaque année",
	"CAL_HOLIDAY_EVENT" => "Répété chaque jour de congé",
	"CAL_UNKNOWN_TIME" => "Heure de début inconnue",
	"CAL_ADDING_TO" => "Ajouté à",
	"CAL_ANON_ALIAS" => "Alias",
	"CAL_EVENT_TYPE" => "Type d\'évènement",
	
	// MULTI-SECTION RELATED TEXT (used by more than one section, but not everwhere)
	"CAL_DESCRIPTION" => "Description", // (search, view date, view event)
	"CAL_DURATION" => "Durée", // (view event, view date)
	"CAL_DATE" => "Date", // (search, view date)
	"CAL_NO_EVENTS_FOUND" => "Aucun évènement trouvé", // (search, view date)
	"CAL_NO_SUBJECT" => "Aucun Sujet", // (search, view event, view date, calendar)
	"CAL_PRIVATE_EVENT" => "Évènement privé", // (search, view event)
	"CAL_DELETE" => "Supprimer", // (view event, view date, admin)
	"CAL_MODIFY" => "Modifier", // (view event, view date, admin)
	"CAL_NOT_SPECIFIED" => "Non spécifié", // (view event, view date, calendar)
	"CAL_FULL_DAY" => " Tous les jours", // (view event, view date, calendar, submit event)
	"CAL_HACKING_ATTEMPT" => "Tentative d\'intrusion - Adresse IP enregistrée", // (delete)
	"CAL_TIME" => "Heure", // (view date, submit event)
	"CAL_HOURS" => "Heures", // (view event, submit event)
	"CAL_HOUR" => "Heure", // (view event, submit event)
	"CAL_ANONYMOUS" => "Anonyme", // (view event, view date, submit event),
	
	
	"CAL_SELECT_TIME" => "Selectionner l\'heure de début",
	
	'event invitations' => 'Invitations',
	'event invitations desc' => 'Inviter les personnes sélectionnées à cet évènement',
	'send new event notification' => 'Envoyer une notification par courriel',
	'new event notification' => 'Un nouvel évènement a été ajouté',
    'change event notification' => 'L\'évènement a changé',
	'deleted event notification' => 'L\'évènement a été supprimé',
	'attendance' => 'Souhaitez-vous participer ?',
    'confirm attendance' => 'Confirmer',
    'maybe' => 'Peut-être',
    'decide later' => 'Décider plus tard',
    'view event' => 'Voir l\'évènement',
	'new event created' => 'Nouvel évènement créé',
	'event changed' => 'L\'évènement a changé',
 	'event deleted' => 'Évènement supprimé',
	'calendar of' => 'Calendrier de {0}',
	'all users' => 'Tous les Utilisateurs',
  	'error delete event' => 'Erreur de suppression d\'évènement',  
  
	"days" => "jours",
	"weeks" => "semaines",
	"months" => "mois",
	"years" => "années",

  ); // array
?>