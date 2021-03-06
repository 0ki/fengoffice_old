<?php
return array(
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
	'backup config warning' => 'Vorsicht: die Ordner config und tmp werden nicht gesichert.', 
	'cron event name cron_backup' => 'OpenGoo sichern', 
	'cron event desc cron_backup' => 'Diese Zeitsteuerung sichert OpenGoo regelmäßig. Der Administrator wird Sicherungen über den Administrations-Bereich herunterladen können. Die Sicherungen werden als zip-Datei im Verzeichnis tmp/backup gespeichert',

	'error db backup' => 'Fehler bei der Erstellung des Datenbank-Backups. Überprüfen Sie die Variable MYSQLDUMP_COMMAND.', 
	'error create backup folder' => 'Fehler bei der Erstellung des Backup-Ordners. Das Backup kann nicht fertiggestellt werden.', 
	'error delete backup' => 'Fehler beim Löschen des Datenbank-Backups.', 
	'success delete backup' => 'Das Backup wurde gelöscht.', 
	'success db backup' => 'Backup wurde erfolgreich erstellt.', 
	'backup command failed' => 'Backup-Befehl fehlgeschlagen. Überprüfe MYSQLDUMP_COMMAND Variable.',
	'return code' => 'Return-Code: {0}', 
);
?>