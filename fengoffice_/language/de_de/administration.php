<?php

  /**
  * Administration interface langs
  * UTF-8
  * @version 1.1 RC2
  * @author 
  * @translation by Karl <karl@mountainbird.net>, 12/29/2008
  * Keine Unterscheidung Du- oder Sie-Version
  */

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Testmail-Einstellungen',
    'administration tool desc test_mail_settings' => 'Einfaches Tool zum Senden von Test-Emails um zu prüfen, ob der OpenGoo-Mailer richtig konfiguriert ist',
    'administration tool name mass_mailer' => 'Massen-Mailer',
    'administration tool desc mass_mailer' => 'Einfaches Tool zum Senden von Text-Emails an jede Gruppe registrierter Benutzer im System',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Konfiguration',
    
    'mail transport mail()' => 'Default PHP settings',
    'mail transport smtp' => 'SMTP server',
    
    'secure smtp connection no'  => 'Nein',
    'secure smtp connection ssl' => 'Ja, benutze SSL',
    'secure smtp connection tls' => 'Ja, benutze TLS',
    
    'file storage file system' => 'Dateisystem',
    'file storage mysql' => 'Datenbank (MySQL)',
    
    // Categories
    'config category name general' => 'Allgemein',
    'config category desc general' => 'Allgemeine OpenGoo-Einstellungen',
    'config category name mailing' => 'Mailversand',
    'config category desc mailing' => 'Einstellungen für das Senden der Emails von OpenGoo. Entweder die Einstellungen in der php.ini nutzen oder einen anderen SMTP-Server nutzen',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Name der Website',
    'config option desc site_name' => 'Diese Angabe wird auf der Übersichts-Seite angezeigt',
    'config option name file_storage_adapter' => 'Dateiablage',
    'config option desc file_storage_adapter' => 'Auswahl des Speichersystems für hochgeladene Dokumente. Achtung: Änderungen des Speichersystems machen alle vorher hochgeladenen Dokumente unzugänglich.',
    'config option name default_project_folders' => 'Standard-Ordner',
    'config option desc default_project_folders' => 'Diese Ordner werden automatisch erzeugt, wenn ein neuer Arbeitsbereich (Workspace) erzeugt wird. Ein Ordner-Name pro Zeile; doppelte Einträge oder leere Zeilen werden ignoriert.',
    'config option name theme' => 'Theme (Ansichtsvorlage)',
    'config option desc theme' => 'Mit Themes kann das Erscheinungsbild von OpenGoo verändert werden',
  	'config option name days_on_trash' => 'Tage im Papierkorb',
    'config option desc days_on_trash' => 'Wieviel Tage ein gelöschtes Objekt im Papierkorb verbleibt, bevor es vollständig gelöscht wird. Bei 0 erfolgt keine Löschung.',
  	'config option name enable_email_module' => 'Email-Modul aktivieren',
  	'config option desc enable_email_module' => 'Aktiviert den Email-Tab.  ---  Warnung: Das Email-Modul ist noch im Beta-Status und kann Fehler beinhalten, die es ungeeeignet für produktiven Einsatz machen.',
	'config option name time_format_use_24' => '24-h-Format für Zeitangaben aktivieren',
  	'config option desc time_format_use_24' => 'Wenn aktiviert, werden alle Zeitangaben im Format \'hh:mm\' von 00:00 bis 23:59 angezeigt; ansonsten erfolgt 12-h-Anzeige mit AM bzw. PM.',
  
    'config option name upgrade_check_enabled' => 'Upgrade-Prüfung aktivieren',
    'config option desc upgrade_check_enabled' => 'Wenn aktiviert prüft das System einmal pro Tag, ob eine neuere Version von OpenGoo zum Download bereit ist',
	'config option name work_day_start_time' => 'Startzeit Arbeitstage',
  	'config option desc work_day_start_time' => 'Eingabe der Uhrzeit, wann die Arbeitstage beginnen',
    
    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange Kompatibilitäts-Modus',
    'config option desc exchange_compatible' => 'Bei Nutzung des Microsoft Exchange-Server diese Option aktivieren um bekannte Mail-Probleme zu verhindern.',
    'config option name mail_transport' => 'Mail-Transport',
    'config option desc mail_transport' => 'Entweder die Standard-PHP-Einstellungen verwenden oder einen SMTP-Server angeben',
    'config option name smtp_server' => 'SMTP-Server',
    'config option name smtp_port' => 'SMTP-Port',
    'config option name smtp_authenticate' => 'SMTP-Authentifizierung benutzen',
    'config option name smtp_username' => 'SMTP-Benutzername',
    'config option name smtp_password' => 'SMTP-Passwort',
    'config option name smtp_secure_connection' => 'SMTP-Verbindung benutzen',
  
 	'can edit company data' => 'Darf Firmen-Daten ändern',
  	'can manage security' => 'Darf Sicherheits-Einstellungen ändern',
  	'can manage workspaces' => 'Darf Arbeitsbereiche (Workspaces) ändern',
  	'can manage configuration' => 'Darf Konfiguration ändern',
  	'can manage contacts' => 'Kann Kontakte bearbeiten',
  	'group users' => 'Benutzer gruppieren',
    
  	
  	'user ws config category name dashboard' => 'Dashboard-Optionen',
  	'user ws config category name task panel' => 'Aufgaben-Optionen',
  	'user ws config option name show pending tasks widget' => 'Zeige ausstehende Aufgaben',
  	'user ws config option name pending tasks widget assigned to filter' => 'Zeige zugeteilte Aufgaben',
  	'user ws config option name show late tasks and milestones widget' => 'Zeige verspätete Aufgaben und Meilensteine',
  	'user ws config option name show messages widget' => 'Zeige Notizen',
  	'user ws config option name show comments widget' => 'Zeige Kommentare',
  	'user ws config option name show documents widget' => 'Zeige Dokumente',
  	'user ws config option name show calendar widget' => 'Zeige Mini-Kalender',
  	'user ws config option name show charts widget' => 'Zeige Diagramme',
  	'user ws config option name show emails widget' => 'Zeige Emails',
  	
  	'user ws config option name my tasks is default view' => 'Zeige nur mir zugeteilte Aufgaben in der Standard-Ansicht',
  	'user ws config option desc my tasks is default view' => 'Bei \'Nein\' werden alle Aufgaben in der Standard-Ansicht angezeigt',
  	'user ws config option name show tasks in progress widget' => 'Zeige \'Aufgaben in Bearbeitung\'',
  	'user ws config option name can notify from quick add' => 'Hinweis-Checkbox in \'Schnelleingabe\'',
  	'user ws config option desc can notify from quick add' => 'Bei der Schnelleingabe von Aufgaben wird eine Checkbox zur Benachrichtigung der ausgewählten Benutzer angezeigt',
 	
  	'backup process desc' => 'Ein Backup speichert den momentanen Zustand der gesamten Anwendung in einem komprimierten Ordner. Damit kann man einfach ein Backup der OpenGoo-Installation anfertigen.<br><br>Das Erzeugen eines Backups von Datenbank und Dateisystem kann länger als ein paar Sekunden dauern, weshalb der Backup-Vorgang aus drei Schritten besteht:<br>1. Backup-Prozess starten,<br>2. Backup-Paket herunterladen. <br>3. Optional kann ein bestehendes Backup-Paket manuell gelöscht werden, wodurch es nicht mehr zur Verfügung steht.<br> ',
  	'start backup' => 'Starte Backup-Prozess',
    'start backup desc' => 'Das Starten eines Backup-Prozesses löscht automatisch das vorherige Backup-Paket und erzeugt ein neues.',
  	'download backup' => 'Backup-Paket herunterladen',
    'download backup desc' => 'Vor dem Herunterladen eines neuen Backup-Paketes muss dieses zuerst erzeugt werden.',
  	'delete backup' => 'Lösche Backup-Paket',
    'delete backup desc' => 'Löscht das letzte Backup-Paket, wodurch es nicht mehr zum Herunterladen zur Verfügung steht. Das Löschen nach dem Herunterladen wird empfohlen.',
    'backup' => 'Backup',
    'backup menu' => 'Backup-Menü',
   	'last backup' => 'Das letzte Backup wurde erzeugt am',
   	'no backups' => 'Es stehen keine Backups zum Herunterladen zur Verfügung',
   	
   	'user ws config option name always show unread mail in dashboard' => 'Zeige immer die ungelesenen Emails in der Übersicht (Dashboard)',
   	'user ws config option desc always show unread mail in dashboard' => 'Bei \'Nein\' werden nur die Emails des aktiven Arbeitsbereiches (Workspace) angezeigt',
   	'workspace emails' => 'Arbeitsbereichs(Workspace)-Mails',
  	'user ws config option name tasksShowWorkspaces' => 'Zeige Arbeitsbereiche (Workspaces)',
  	'user ws config option name tasksShowTime' => 'Zeige die Zeit an',
  	'user ws config option name tasksShowDates' => 'Zeige das Datum an',
  	'user ws config option name tasksShowTags' => 'Zeige Tags',
  	'user ws config option name tasksGroupBy' => 'Gruppiere nach',
  	'user ws config option name tasksOrderBy' => 'Sortiere nach',
  	'user ws config option name task panel status' => 'Status',
  	'user ws config option name task panel filter' => 'Filtere nach',
  	'user ws config option name task panel filter value' => 'Filter-Werte',
  
  	'templates' => 'Vorlagen (Templates)',
	'add template' => 'Vorlage hinzufügen',
	'confirm delete template' => 'Sicher, diese Vorlage zu löschen?',
	'no templates' => 'Keine Vorlagen vorhanden',
	'template name required' => 'Der Vorlagen-Name ist erforderlich',
	'can manage templates' => 'Darf Vorlagen verwalten',
	'new template' => 'Neue Vorlage',
	'edit template' => 'Vorlage bearbeiten',
	'template dnx' => 'Die Vorlage existiert nicht',
	'success edit template' => 'Vorlage erfolgreich geändert',
	'log add cotemplates' => '{0} hinzugefügt',
	'log edit cotemplates' => '{0} geändert',
	'success delete template' => 'Vorlage erfolgreich gelöscht',
	'error delete template' => 'Fehler beim Löschen der Vorlage',
	'objects' => 'Objekte',
	'objects in template' => 'Objekte in der Vorlage',
	'no objects in template' => 'Es bestehen keine Objekte in dieser Vorlage',
	'add to a template' => 'hinzufügen zu einer Vorlage',
  	'add an object to template' => 'Ein Objekt zu dieser Vorlage hinzufügen',
	'you are adding object to template' => '{0} \'{1}\' zu einer Vorlage hinzufügen. Eine Vorlage unten auswählen oder eine neue erzeugen für {0}.',
	'success add object to template' => 'Ein Objekt erfolgreich zu einer Vorlage hinzugefügt',
	'object type not supported' => 'Dieser Objekttyp ist nicht für Vorlagen geeeignet',
  	'assign template to workspace' => 'Vorlage zu Arbeitsbereich zuordnen',
  ); // array

?>