<?php

  /**
  * Array of messages file (error, success message, status...)
  * @author Ilija Studen <ilija.studen@gmail.com>
  * UTF-8
  * @version 1.2 RC1, Keine Unterscheidung Du- oder Sie-Version
  * @translation 02/04/2009 by Karl, bitte Fehler und Korrekturen per Email an <karl@mountainbird.net> senden
  */

  return array(
  
    // Empty, dnx et
    'no mail accounts set' => 	'Es existiert noch kein E-Mail-Konto. Bitte zuerst ein E-Mail-Konto erstellen.',
    'no mail accounts set for check' => 	'Es ist noch kein E-Mail-Konto angelegt. Bitte zuerst ein E-Mail-Konto erstellen.',
    'email dnx' => 	'Die angeforderte E-Mail existiert nicht.',
    'email dnx deleted' => 	'Die angeforderte E-Mail wurde aus der Datenbank gelöscht.',
    'project dnx' => 	'Der angeforderte Arbeitsbereich existiert nicht in der Datenbank.',
    'contact dnx' => 	'Der angeforderte Kontakt existiert nicht in der Datenbank.',
    'company dnx' => 	'Die angeforderte Firma existiert nicht in der Datenbank.',
    'message dnx' => 	'Die angeforderte Notiz existiert nicht.',
    'no comments in message' => 	'Es gibt keine Kommentare zu dieser Notiz.',
    'no comments associated with object' => 	'Es gibt keine Kommentare zu diesem Objekt.',
    'no messages in project' => 	'Es gibt keine Kommentare in diesem Arbeitsbereich.',
    'no subscribers' => 	'Zu diesem Objekt sind keine Benutzer abonniert.',
    'no activities in project' => 	'Zu diesem Arbeitsbereich sind keine Aktivitäten gespeichert.',
    'comment dnx' => 	'Angeforderter Kommentar existiert nicht',
    'milestone dnx' => 	'Angeforderter Meilenstein existiert nicht',
    'task list dnx' => 	'Angeforderte Aufgabe existiert nicht',
    'task dnx' => 	'Angeforderte Aufgabe existiert nicht',
    'event type dnx' => 	'Angeforderter Ereignistyp existiert nicht',
    'no milestones in project' => 	'Es gibt keine Meilensteine in diesem Arbeitsbereich',
    'no active milestones in project' => 	'Es gibt keine aktiven Meilensteine in diesem Arbeitsbereich',
    'empty milestone' => 	'Dieser Meilenstein ist leer. Es kann jederzeit ein <a class="internalLink" href="{1}">task</a> hinzugefügt werden',
    'no logs for project' => 	'Es gibt keine Log-Einträge zu diesem Arbeitsbereich',
    'no recent activities' => 	'Es gibt keine Aufzeichnungen über letzte Aktivitäten in der Datenbank',
    'no open task lists in project' => 	'Es gibt keine offenen Aufgaben in diesem Arbeitsbereich',
    'no completed task lists in project' => 	'Es gibt keine erledigte Aufgaben in diesem Arbeitsbereich',
    'no open task in task list' => 	'Es gibt keine offenen Aufgaben in dieser Liste',
    'no closed task in task list' => 	'Es gibt keine geschlossenen Aufgaben in dieser Liste',
    'no open task in milestone' => 	'Es gibt keine offenen Aufgaben in diesem Meilenstein',
    'no closed task in milestone' => 	'Es gibt keine geschlossenen Aufgaben in diesem Meilenstein',
    'no projects in db' => 	'Es gibt keine Arbeitsbereiche in der Datenbank',
    'no projects owned by company' => 	'Es gibt keine Arbeitsbereiche in dieser Firma',
    'no projects started' => 	'Es gibt keine gestarteten Arbeitsbereiche',
    'no active projects in db' => 	'Es gibt keine aktiven Arbeitsbereiche',
    'no new objects in project since last visit' => 	'Es gibt keine neuen Objekte in diesem Arbeitsbereich seit dem letzten Aufruf',
    'no clients in company' => 	'Diese Firma hat keine registrierten Kunden',
    'no users in company' => 	'Es gibt keine Benutzer in dieser Firma',
    'client dnx' => 	'Gewählte Kunden-Firma existiert nicht',
    'company dnx' => 	'Gewählte Firma existiert nicht',
    'user dnx' => 	'Gewählter Benutzer existiert nicht in der Datenbank',
    'avatar dnx' => 	'Avatar existiert nicht',
    'no current avatar' => 	'Es ist kein Avatar hochgeladen',
    'picture dnx' => 	'Bild existiert nicht',
    'no current picture' => 	'Es ist kein Bild hochgeladen',
    'no current logo' => 	'Es ist kein Logo hochgeladen',
    'user not on project' => 	'Gewählter Benutzer ist dem gewählten Arbeitsbereich nicht zugeordnet',
    'company not on project' => 	'Gewählte Firma ist dem gewählten Arbeitsbereich nicht zugeordnet',
    'user cant be removed from project' => 	'Gewählter Benutzer kann nicht von diesem Arbeitsbereich entfernt werden',
    'tag dnx' => 	'Gewähltes Schlagwort existiert nicht',
    'no tags used on projects' => 	'Es gibt keine Schlagworte in diesem Arbeitsbereich',
    'no forms in project' => 	'Es gibt keine Formulare in diesem Arbeitsbereich',
    'project form dnx' => 	'Gewähltes Arbeitsbereichs-Formular existiert nicht in der Datenbank',
    'related project form object dnx' => 	'Zugehöriges Formular-Objekt existiert nicht in der Datenbank',
    'no my tasks' => 	'Es gibt keine zugeordneten Aufgaben',
    'no search result for' => 	'Es gibt keine passenden Ergebnisse zu "<strong>{0}</strong>"',
    'no files on the page' => 	'Es gibt keine Dateien auf dieser Seite',
    'folder dnx' => 	'Ordner existiert nicht in der Datenbank',
    'define project folders' => 	'Es gibt keine Ordner in diesem Arbeitsbereich. Bitte zum Fortfahren Ordner anlegen',
    'file dnx' => 	'Gewählte Datei existiert nicht in der Datenbank',
    'not s5 presentation' => 	'Kann die Diashow nicht starten weil die Datei keine gültige S5-Präsentation ist',
    'file not selected' => 	'Es ist keine Datei ausgewählt',
    'file revision dnx' => 	'Gewählte Revision existiert nicht in der Datenbank',
    'no file revisions in file' => 	'Ungültige Datei - mit dieser Datei sind keine Revisionen verbunden',
    'cant delete only revision' => 	'Diese Revision kann nicht gelöscht. Jede Datei benötigt zumindest eine Revision',
    'config category dnx' => 	'Gewählte Konfigurations-Kategorie existiert nicht',
    'config category is empty' => 	'Gewählte Konfigurations-Kategorie ist leer',
    'email address not in use' => 	'{0} ist nicht in Benutzung',
    'no linked objects' => 	'Zu diesem Objekt sind keine Objekte verbunden',
    'object not linked to object' => 	'Zwischen den gewählten Objekten besteht keine Verbindung',
    'no objects to link' => 	'Bitte Objekte wählen, die verbunden werden sollen',
    'no administration tools' => 	'Es gibt keine aktivierten Administrations-Tools in der Datenbank',
    'administration tool dnx' => 	'Administrations-Tool "{0}" existiert nicht',
    
    // Success
    'success add contact' => 	'Kontakt \'{0}\' erzeugt',
    'success edit contact' => 	'Kontakt \'{0}\' wurde erfolgreich aktualisiert',
    'success delete contact' => 	'Kontakt \'{0}\' wurde erfolgreich gelöscht',
    'success edit picture' => 	'Das Bild wurde erfolgreich hochgeladen',
    'success delete picture' => 	'Das Bild wurde erfolgreich gelöscht',
    
    'success add project' => 	'Arbeitsbereich {0} wurde erfolgreich hinzugefügt',
    'success edit project' => 	'Arbeitsbereich {0} wurde aktualisiert',
    'success delete project' => 	'Arbeitsbereich {0} wurde gelöscht',
    'success complete project' => 	'Arbeitsbereich {0} wurde erledigt',
    'success open project' => 	'Arbeitsbereich {0} wurde wiedereröffnet',
    
    'success add milestone' => 	'Meilenstein \'{0}\' wurde erfolgreich angelegt',
    'success edit milestone' => 	'Meilenstein \'{0}\' wurde erfolgreich aktualisiert',
    'success deleted milestone' => 	'Meilenstein \'{0}\' wurde erfolgreich gelöscht',
    
    'success add message' => 	'Notiz {0} wurde erfolgreich hinzugefügt',
    'success edit message' => 	'Notiz {0} wurde erfolgreich aktualisiert',
    'success deleted message' => 	'Notiz \'{0}\' and all of its comments wurde erfolgreich gelöscht',
    
    'success add comment' => 	'Kommentar wurde erfolgreich hinzugefügt',
    'success edit comment' => 	'Kommentar wurde erfolgreich aktualisiert',
    'success delete comment' => 	'Kommentar wurde erfolgreich gelöscht',
    
    'success add task list' => 	'Aufgabe \'{0}\' wurde hinzugefügt',
    'success edit task list' => 	'Aufgabe \'{0}\' wurde aktualisiert',
    'success delete task list' => 	'Aufgabe \'{0}\' wurde gelöscht',
    
    'success add task' => 	'Gewählte Aufgabe wurde hinzugefügt',
    'success edit task' => 	'Gewählte Aufgabe wurde aktualisiert',
    'success delete task' => 	'Gewählte Aufgabe wurde gelöscht',
    'success complete task' => 	'Gewählte Aufgabe wurde erledigt',
    'success open task' => 	'Gewählte Aufgabe wurde wiedereröffnet',
    'success n tasks updated' => 	'{0} Aufgaben aktualisiert',
    'success add mail' => 	'E-Mail erfolgreich gesendet',
    
    'success add client' => 	'Firma {0} wurde hinzugefügt',
    'success edit client' => 	'Firma {0} wurde aktualisiert',
    'success delete client' => 	'Firma {0} wurde gelöscht',
    
    'success add group' => 	'Gruppe {0} wurde hinzugefügt',
    'success edit group' => 	'Gruppe {0} wurde aktualisiert',
    'success delete group' => 	'Gruppe {0} wurde gelöscht',
    
    'success edit company' => 	'Firmendaten wurde aktualisiert',
    'success edit company logo' => 	'Firmenlogo wurde aktualisiert',
    'success delete company logo' => 	'Firmenlogo wurde gelöscht',
    
    'success add user' => 	'Benutzer {0} wurde erfolgreich hinzugefügt',
    'success edit user' => 	'Benutzer {0} wurde erfolgreich aktualisiert',
    'success delete user' => 	'Benutzer {0} wurde erfolgreich gelöscht',
    
    'success update project permissions' => 	'Arbeitsbereichs-Rechte wurde erfolgreich aktualisiert',
    'success remove user from project' => 	'Benutzer wurde erfolgreich vom Arbeitsbereich entfernt',
    'success remove company from project' => 	'Firma wurde erfolgreich vom Arbeitsbereich entfernt',
    
    'success update profile' => 	'Das Profil wurde aktualisiert',
    'success edit avatar' => 	'Das Profilbild wurde erfolgreich aktualisiert',
    'success delete avatar' => 	'Das Profilbild wurde erfolgreich gelöscht',
    
    'success hide welcome info' => 	'Die Willkommens-Infobox wurde erfolgreich auf unsichtbar gesetzt',
    
    'success complete milestone' => 	'Meilenstein \'{0}\' erreicht',
    'success open milestone' => 	'Meilenstein \'{0}\' wurde neu geöffnet',
    
    'success subscribe to object' => 	'Benachrichtigungs-Abo wurde hinzugefügt',
    'success unsubscribe to object' => 	'Benachrichtigungs-Abo wurde gelöscht',
    
    'success add project form' => 	'Formular \'{0}\' wurde hinzugefügt',
    'success edit project form' => 	'Formular \'{0}\' wurde aktualisiert',
    'success delete project form' => 	'Formular \'{0}\' wurde gelöscht',
    
    'success add folder' => 	'Ordner \'{0}\' wurde hinzugefügt',
    'success edit folder' => 	'Ordner \'{0}\' wurde aktualisiert',
    'success delete folder' => 	'Ordner \'{0}\' wurde gelöscht',
    
    'success add file' => 	'Datei \'{0}\' wurde hinzugefügt',
    'success save file' => 	'Datei \'{0}\' wurde gespeichert',
    'success edit file' => 	'Datei \'{0}\' wurde aktualisiert',
    'success delete file' => 	'Datei \'{0}\' wurde gelöscht',
    'success delete files' => 	'{0} Datei(en) wurden gelöscht',
    'success tag files' => 	'{0} Datei(en) wurden verschlagwortet',
    'success tag contacts' => 	'{0} Kontakt(e) wurden verschlagwortet',
    
    'success add handis' => 	'"Handins" wurden aktualisiert',
    
    'success add properties' => 	'Die Eigenschaften wurden aktualisiert',
    
    'success edit file revision' => 	'Die Revision wurde aktualisiert',
    'success delete file revision' => 	'Die Dateirevision wurde gelöscht',
    
    'success link objects' => 	'{0} Objekt(e) wurde(n) erfolgreich verknüpft',
    'success unlink object' => 	'Objekt wurde erfolgreich entknüpft',
    
    'success update config category' => 	'{0} Konfigurationseinstellung(en) wurden aktualisiert',
    'success forgot password' => 	'Das Passwort wurde per Email zugesandt',
    
    'success test mail settings' => 	'Testmail wurde erfolgreich versandt',
    'success massmail' => 	'Email wurde versandt',
    
    'success update company permissions' => 	'Firmen-Rechte erfolgreich aktualisiert. {0} Einstellung(en) aktualisiert',
    'success user permissions updated' => 	'Benutzer-Rechte wurden erfolgreich aktualisiert',
  
    'success add event' => 	'Ereignis wurde hinzugefügt',
    'success edit event' => 	'Ereignis wurde aktualisiert',
    'success delete event' => 	'Ereignis wurde gelöscht',
    
    'success add event type' => 	'Ereignistyp wurde hinzugefügt',
    'success delete event type' => 	'Ereignistyp wurde gelöscht',
    
    'success add webpage' => 	'Weblink wurde hinzugefügt',
    'success edit webpage' => 	'Weblink wurde aktualisiert',
    'success deleted webpage' => 	'Weblink wurde gelöscht',
    
    'success add chart' => 	'Diagramm wurde hinzugefügt',
    'success edit chart' => 	'Diagramm wurde aktualisiert',
    'success delete chart' => 	'Diagramm wurde gelöscht',
    'success delete charts' => 	'Die gewählten Diagramme wurden erfolgreich gelöscht',
  
    'success delete contacts' => 	'Die gewählten Kontakte wurden erfolgreich gelöscht',
  
    'success classify email' => 	'Email erfolgreich klassifiziert',
    'success delete email' => 	'Email wurde gelöscht',
  
    'success delete mail account' => 	'Das E-Mail-Konto wurde erfolgreich gelöscht',
    'success add mail account' => 	'Das E-Mail-Konto wurde erfolgreich angelegt',
    'success edit mail account' => 	'Das E-Mail-Konto wurde erfolgreich aktualisiert',
  
    'success link object' => 	'Objekt wurde erfolgreich verknüpft',
  
    'success check mail' => 	'E-Mail-Abruf beendet: {0} E-Mails empfangen.',
  
    'success delete objects' => 	'{0} Objekt(e) erfolgreich gelöscht',
    'success tag objects' => 	'{0} Objekt(e) erfolgreich verschlagwortet',
    'error delete objects' => 	'Fehler beim Löschen von {0} Objekt(e)',
    'error tag objects' => 	'Fehler beim verschlagworten von {0} Objekt(e)',
    'success move objects' => 	'{0} Objekt(e) erfolgreich verschoben',
    'error move objects' => 	'Fehler beim Verschieben von {0} Objekt(en)',
  
    'success checkout file' => 	'Datei erfolgreich ausgecheckt',
    'success checkin file' => 	'Datei erfolgreich eingecheckt',
    'success undo checkout file' => 	'Datei-Checkout erfolgreich abgebrochen',
    'success extracting files' => 	'{0} Dateien entpackt',
    'success compressing files' => 	'Dateien erfolgreich komprimiert',
    
    // Failures
    'error edit timeslot' => 	'Fehler beim Speichern des Arbeitszeitspeichers',
    'error delete timeslot' => 	'Fehler beim Löschen des Arbeitszeitspeichers',
    'error add timeslot' => 	'Fehler beim Hinzufügen des Arbeitszeitspeichers',
    'error open timeslot' => 	'Fehler beim Öffnen des Arbeitszeitspeichers',
    'error close timeslot' => 	'Fehler beim Schließen des Arbeitszeitspeichers',
    'error start time after end time' => 	'Fehler beim Speichern des Arbeitszeitspeicher: Die Startzeit muss VOR der Endzeit liegen',
    'error form validation' => 	'Fehler beim Speichern des Objekts wegen der Ungültigkeit von Eigenschaften',
    'error delete owner company' => 	'Die Firma des Inhabers/Erstellers kann nicht gelöscht werden',
    'error delete message' => 	'Fehler beim Löschen der Notiz',
    'error update message options' => 	'Fehler beim Aktualisieren der Notiz-Optionen',
    'error delete comment' => 	'Fehler beim Löschen des Kommentars',
    'error delete milestone' => 	'Fehler beim Löschen des Meilensteins',
    'error complete task' => 	'Fehler beim Abschließen der Aufgabe',
    'error open task' => 	'Fehler beim Wiedereröffnen der Aufgabe',
    'error upload file' => 	'Fehler beim Hochladen der Datei',
    'error delete project' => 	'Fehler beim Löschen des Arbeitsbereiches',
    'error complete project' => 	'Fehler beim Abschließen des Arbeitsbereiches',
    'error open project' => 	'Fehler beim Wiedereröffnen des Arbeitsbereiches',
    'error delete client' => 	'Fehler beim Löschen der Kundenfirma',
    'error delete group' => 	'Fehler beim Löschen der Gruppe',
    'error delete user' => 	'Fehler beim Löschen des Benutzers',
    'error update project permissions' => 	'Fehler beim Aktualisieren der Arbeitsbereichs-Rechte',
    'error remove user from project' => 	'Fehler beim Entfernen des Benutzer vom Arbeitsbereich',
    'error remove company from project' => 	'Fehler beim Entfernen der Firma vom Arbeitsbereich',
    'error edit avatar' => 	'Fehler beim Bearbeiten des Avatars',
    'error delete avatar' => 	'Fehler beim Löschen des Avatars',
    'error edit picture' => 	'Fehler beim Bearbeiten des Bildes',
    'error delete picture' => 	'Fehler beim Löschen des Bildes',
    'error edit contact' => 	'Fehler beim Bearbeiten des Kontaktes',
    'error delete contact' => 	'Fehler beim Löschen des Kontaktes',
    'error hide welcome info' => 	'Fehler beim Verstecken der Willkommens-Info',
    'error complete milestone' => 	'Fehler beim Abschließen des Meilensteins',
    'error open milestone' => 	'Fehler beim Wiedereröffnen des Meilensteins',
    'error file download' => 	'Fehler beim Herunterladen der Datei',
    'error link object' => 	'Fehler beim Verlinken des Objektes',
    'error edit company logo' => 	'Fehler beim Aktualisieren des Firmenlogos',
    'error delete company logo' => 	'Fehler beim Löschen des Firmenlogos',
    'error subscribe to object' => 	'Fehler beim Abbonieren des Objektes',
    'error unsubscribe to object' => 	'Fehler beim Löschen des Mitteilungs-Abos des Objektes',
    'error add project form' => 	'Fehler beim Hinzufügen des Arbeitsbereichs-Formulars',
    'error submit project form' => 	'Fehler beim Abschließen des Arbeitsbereichs-Formulars',
    'error delete folder' => 	'Fehler beim Löschen des Ordners',
    'error delete file' => 	'Fehler beim Löschen der Datei',
    'error delete files' => 	'Fehler beim Löschen von {0} Datei(en)',
    'error tag files' => 	'Fehler beim Verschlagworten von {0} Datei(en)',
    'error tag contacts' => 	'Fehler beim Verschlagworten von {0} Kontakt(e)',
    'error delete file revision' => 	'Fehler beim Löschen der Datei-Revision',
    'error delete task list' => 	'Fehler beim Löschen der Aufgabenliste',
    'error delete task' => 	'Fehler beim Löschen der Aufgabe',
    'error check for upgrade' => 	'Fehler beim Prüfen auf neue Version',
    'error link object' => 	'Fehler beim Verlinken der Objekt(e)',
    'error unlink object' => 	'Fehler beim Entlinken von {0} Objekt(e)',
    'error link objects max controls' => 	'Es können keine weiteren Objekt-Links hinzugefügt werden. Das Limit ist {0}',
    'error test mail settings' => 	'Fehler beim Senden der Testmail',
    'error massmail' => 	'Fehler beim Senden der Email(s)',
    'error owner company has all permissions' => 	'Die Firma des Inhabers/Erstellers hat alle Rechte',
    'error while saving' => 	'Fehler beim Abspeichern des Dokumentes',
    'error delete event type' => 	'Fehler beim Löschen des Ereignistyps',
    'error delete mail' => 	'Fehler beim Löschen der Email',
    'error delete mail account' => 	'Fehler beim Löschen des Email-Kontos',
    'error delete contacts' => 	'Fehler beim Löschen der Kontakte',
    'error check mail' => 	'Fehler beim Prüfen des Email-Kontos \'{0}\': {1}',
    'error check out file' => 	'Fehler beim Auschecken der Datei zur exklusiven Benutzung',
    'error checkin file' => 	'Fehler beim Einchecken der Datei',
    'error classifying attachment cant open file' => 	'Fehler beim Klassifizieren des Anhanges: Kann die Datei nicht öffnen',
    'error contact added but not assigned' => 	'Der Kontakt \'{0}\' wurde zwar hinzugefügt, konnte aber dem Arbeitsbereich \'{1}\' wegen fehlender Zugriffs-Rechte nicht zugeordnet werden',
    'error cannot set workspace as parent' => 	'Kann den Arbeitsbereich \'{0}\' nicht als übergeordneten Bereich setzen: Es gibt zu viele Arbeitsbereichs-Ebenen oder eine Endlos-Verknüpfung',
  
    
    // Access or data errors
    'no access permissions' => 	'Sie haben keine Berechtigung, die angeforderte Seite aufzurufen', 
    'invalid request' => 	'Ungültige Anfrage!',
    
    // Confirmation
    'confirm cancel work timeslot' => 	"Wirklich sicher, den laufenden Arbeitszeitspeicher abzubrechen?",
    'confirm delete mail account' => 	'Achtung: Alle zu diesem Konto gehörigen Emails werden gelöscht. Wirklich sicher, dieses Email-Konto zu löschen?',
    'confirm delete message' => 	'Wirklich sicher, diese Notiz zu löschen?',
    'confirm delete milestone' => 	'Wirklich sicher, diesen Meilenstein zu löschen?',
    'confirm delete task list' => 	'Wirklich sicher, diese Aufgabe und alle Unter-Aufgaben zu löschen?',
    'confirm delete task' => 	'Wirklich sicher, diese Aufgabe zu löschen?',
    'confirm delete comment' => 	'Wirklich sicher, diesen Kommentar zu löschen?',
    'confirm delete project' => 	'Wirklich sicher, diesen Arbeitsbereich und alle zugehörigen Daten (Notizen, Aufgaben, Meilensteine, Dateien usw.) zu löschen?',
    'confirm complete project' => 	'Wirklich sicher, diesen Arbeitsbereich zu schließen?\nAlle Arbeitsbereichs-Aktionen werden dadurch gesperrt.',
    'confirm open project' => 	'Wirklich sicher, diesen Arbeitsbereich wiederzueröffnen?\nAlle Arbeitsbereichs-Aktionen werden dadurch entsperrt.',
    'confirm delete client' => 	'Wirklich sicher, diese Kunden-Firma und alle enthaltenen Benutzer zu löschen?\nDie persönlichen Arbeitsbereiche der Benutzer werden dadurch ebenfalls gelöscht.',
    'confirm delete contact' => 	'Wirklich sicher, diesen Kontakt zu löschen?',
    'confirm delete user' => 	'Wirklich sicher, dieses Benutzerkonto zu löschen?\nDer persönliche Arbeitsbereich des Benutzers wird dadurch ebenfalls gelöscht.',
    'confirm reset people form' => 	'Wirklich sicher, dieses Formular zurückzusetzen?\nAlle Veränderungen gehen verloren!',
    'confirm remove user from project' => 	'Wirklich sicher, diesen Benutzer vom Arbeitsbereich zu entfernen?',
    'confirm remove company from project' => 	'Wirklich sicher, diese Firma vom Arbeitsbereich zu entfernen?',
    'confirm logout' => 	'Wirklich sicher, auszuloggen?',
    'confirm delete current avatar' => 	'Wirklich sicher, diesen Avatar zu löschen?',
    'confirm unlink object' => 	'Wirklich sicher, dieses Objekt zu entlinken?',
    'confirm delete company logo' => 	'Wirklich sicher, dieses Logo zu löschen?',
    'confirm subscribe' => 	'Wirklich sicher, zu diesem Objekt zu abonnieren? Zu jedem Kommentar zu diesem Objekt erhalten Sie eine Email.',
    'confirm unsubscribe' => 	'Wirklich sicher, das Benachrichtigungs-Abo zu diesem Objekt zu entfernen?',
    'confirm delete project form' => 	'Wirklich sicher, dieses Formular zu löschen?',
    'confirm delete folder' => 	'Wirklich sicher, diesen Ordner zu löschen?',
    'confirm delete file' => 	'Wirklich sicher, diese Datei zu löschen?',
    'confirm delete revision' => 	'Wirklich sicher, diese Revision zu löschen?',
    'confirm reset form' => 	'Wirklich sicher, dieses Formular zurückzusetzen?',
    'confirm delete contacts' => 	'Wirklich sicher, diese Kontakte zu löschen?',
    'confirm delete group' => 	'Wirklich sicher, diese Gruppe zu löschen?',
    
    // Errors...
    'system error message' => 	'Entschuldigung, ein schwerer Programmfehler trat bei dieser Anweisung auf. Ein Fehlerbericht wurde an den Administrator versandt.',
    'execute action error message' => 	'Entschuldigung, diese Anweisung kann derzeit nicht ausgeführt werden. Ein Fehlerbericht wurde an den Administrator versandt.',
    
    // Log
    'log add projectmessages' => 	'\'{0}\' hinzugefügt',
    'log edit projectmessages' => 	'\'{0}\' aktualisiert',
    'log delete projectmessages' => 	'\'{0}\' gelöscht',
    'log trash projectmessages' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectmessages' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectmessages' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectmessages' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectmessages' => 	'Abo entfernt von \'{0}\'',
    'log tag projectmessages' => 	'\'{0}\' verschlagwortet',
    'log link projectmessages' => 	'\'{0}\' verknüpft',
    'log unlink projectmessages' => 	'\'{0}\' entknüpft',
    'log tag projectmessages data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectmessages data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectmessages data' => 	'\'{0}\' entknüpft von {1}',
  
  
    'log add projectevents' => 	'\'{0}\' hinzugefügt',
    'log edit projectevents' => 	'\'{0}\' aktualisiert',
    'log delete projectevents' => 	'\'{0}\' gelöscht',
    'log trash projectevents' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectevents' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectevents' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectevents' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectevents' => 	'Abo entfernt von \'{0}\'',
    'log tag projectevents' => 	'\'{0}\' verschlagwortet',
    'log link projectevents' => 	'\'{0}\' verknüpft',
    'log unlink projectevents' => 	'\'{0}\' entknüpft',
    'log tag projectevents data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectevents data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectevents data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add comments' => 	'{0} hinzugefügt',
    'log edit comments' => 	'{0} aktualisiert',
    'log delete comments' => 	'{0} gelöscht',
    'log trash comments' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash comments' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment comments' => 	'Kommentiert zu \'{0}\'',
    'log subscribe comments' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe comments' => 	'Abo entfernt von \'{0}\'',
    'log tag comments' => 	'\'{0}\' verschlagwortet',
    'log link comments' => 	'\'{0}\' verknüpft',
    'log unlink comments' => 	'\'{0}\' entknüpft',
    'log tag comments data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link comments data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink comments data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projectmilestones' => 	'\'{0}\' hinzugefügt',
    'log edit projectmilestones' => 	'\'{0}\' aktualisiert',
    'log delete projectmilestones' => 	'\'{0}\' gelöscht',
    'log close projectmilestones' => 	'\'{0}\' abgeschlossen',
    'log open projectmilestones' => 	'\'{0}\' wiedereröffnet',
    'log trash projectmilestones' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectmilestones' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectmilestones' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectmilestones' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectmilestones' => 	'Abo entfernt von \'{0}\'',
    'log tag projectmilestones' => 	'\'{0}\' verschlagwortet',
    'log link projectmilestones' => 	'\'{0}\' verknüpft',
    'log unlink projectmilestones' => 	'\'{0}\' entknüpft',
    'log tag projectmilestones data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectmilestones data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectmilestones data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projecttasklists' => 	'\'{0}\' hinzugefügt',
    'log edit projecttasklists' => 	'\'{0}\' aktualisiert',
    'log delete projecttasklists' => 	'\'{0}\' gelöscht',
    'log close projecttasklists' => 	'\'{0}\' abgeschlossen',
    'log open projecttasklists' => 	'\'{0}\' geöffnet',
    'log trash projecttasklists' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projecttasklists' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projecttasklists' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projecttasklists' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projecttasklists' => 	'Abo entfernt von \'{0}\'',
    'log tag projecttasklists' => 	'\'{0}\' verschlagwortet',
    'log link projecttasklists' => 	'\'{0}\' verknüpft',
    'log unlink projecttasklists' => 	'\'{0}\' entknüpft',
    'log tag projecttasklists data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projecttasklists data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projecttasklists data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projecttasks' => 	'\'{0}\' hinzugefügt',
    'log edit projecttasks' => 	'\'{0}\' aktualisiert',
    'log delete projecttasks' => 	'\'{0}\' gelöscht',
    'log close projecttasks' => 	'\'{0}\' abgeschlossen',
    'log open projecttasks' => 	'\'{0}\' geöffnet',
    'log trash projecttasks' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projecttasks' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projecttasks' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projecttasks' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projecttasks' => 	'Abo entfernt von \'{0}\'',
    'log tag projecttasks' => 	'\'{0}\' verschlagwortet',
    'log link projecttasks' => 	'\'{0}\' verknüpft',
    'log unlink projecttasks' => 	'\'{0}\' entknüpft',
    'log tag projecttasks data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projecttasks data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projecttasks data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projectforms' => 	'\'{0}\' hinzugefügt',
    'log edit projectforms' => 	'\'{0}\' aktualisiert',
    'log delete projectforms' => 	'\'{0}\' gelöscht',
    'log trash projectforms' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectforms' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectforms' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectforms' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectforms' => 	'Abo entfernt von \'{0}\'',
    'log tag projectforms' => 	'\'{0}\' verschlagwortet',
    'log link projectforms' => 	'\'{0}\' verknüpft',
    'log unlink projectforms' => 	'\'{0}\' entknüpft',
    'log tag projectforms data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectforms data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectforms data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projectfolders' => 	'\'{0}\' hinzugefügt',
    'log edit projectfolders' => 	'\'{0}\' aktualisiert',
    'log delete projectfolders' => 	'\'{0}\' gelöscht',
    'log comment projectfolders' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectfolders' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectfolders' => 	'Abo entfernt von \'{0}\'',
    'log tag projectfolders' => 	'\'{0}\' verschlagwortet',
    'log link projectfolders' => 	'\'{0}\' verknüpft',
    'log unlink projectfolders' => 	'\'{0}\' entknüpft',
    'log tag projectfolders data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectfolders data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectfolders data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projectfiles' => 	'\'{0}\' hochgeladen',
    'log edit projectfiles' => 	'\'{0}\' aktualisiert',
    'log delete projectfiles' => 	'\'{0}\' gelöscht',
    'log trash projectfiles' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectfiles' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectfiles' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectfiles' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectfiles' => 	'Abo entfernt von \'{0}\'',
    'log tag projectfiles' => 	'\'{0}\' verschlagwortet',
    'log link projectfiles' => 	'\'{0}\' verknüpft',
    'log unlink projectfiles' => 	'\'{0}\' entknüpft',
    'log tag projectfiles data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectfiles data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectfiles data' => 	'\'{0}\' entknüpft von {1}',
    
    'log edit projectfilerevisions' => 	'{0} aktualisiert',
    'log delete projectfilerevisions' => 	'{0} gelöscht',
    'log trash projectfilerevisions' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectfilerevisions' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectfilerevisions' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectfilerevisions' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectfilerevisions' => 	'Abo entfernt von \'{0}\'',
    'log tag projectfilerevisions' => 	'\'{0}\' verschlagwortet',
    'log link projectfilerevisions' => 	'\'{0}\' verknüpft',
    'log unlink projectfilerevisions' => 	'\'{0}\' entknüpft',
    'log tag projectfilerevisions data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectfilerevisions data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectfilerevisions data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add projectwebpages' => 	'\'{0}\' hinzugefügt',
    'log edit projectwebpages' => 	'\'{0}\' aktualisiert',
    'log delete projectwebpages' => 	'\'{0}\' gelöscht',
    'log trash projectwebpages' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash projectwebpages' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment projectwebpages' => 	'Kommentiert zu \'{0}\'',
    'log subscribe projectwebpages' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe projectwebpages' => 	'Abo entfernt von \'{0}\'',
    'log tag projectwebpages' => 	'\'{0}\' verschlagwortet',
    'log link projectwebpages' => 	'\'{0}\' verknüpft',
    'log unlink projectwebpages' => 	'\'{0}\' entknüpft',
    'log tag projectwebpages data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link projectwebpages data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink projectwebpages data' => 	'\'{0}\' entknüpft von {1}',
    
    'log add contacts' => 	'\'{0}\' hinzugefügt',
    'log edit contacts' => 	'\'{0}\' aktualisiert',
    'log delete contacts' => 	'\'{0}\' gelöscht',
    'log trash contacts' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash contacts' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment contacts' => 	'Kommentiert zu \'{0}\'',
    'log subscribe contacts' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe contacts' => 	'Abo entfernt von \'{0}\'',
    'log tag contacts' => 	'\'{0}\' verschlagwortet',
    'log link contacts' => 	'\'{0}\' verknüpft',
    'log unlink contacts' => 	'\'{0}\' entknüpft',
    'log tag contacts data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link contacts data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink contacts data' => 	'\'{0}\' entknüpft von {1}',
  
    'no contacts in company' => 	'Diese Firma hat keine Kontakte.',
  
    'session expired error' => 	'Die Sitzung ist abgelaufen. Bitte die Seite aktualisieren und erneut anmelden.',
    'admin cannot be removed from admin group' => 	'Der erste Nutzer kann nicht aus der Gruppe der Administratoren gelöscht werden',
    'open this link in a new window' => 	'Link in neuem Fenster öffnen',
  
    'confirm delete template' => 	'Vorlage wirklich löschen?',
    'success delete template' => 	'Die Vorlage \'{0}\' wurde gelöscht',
    'success add template' => 	'Die Vorlage wurde hinzugefügt',
  
    'log add companies' => 	'\'{0}\' hinzugefügt',
    'log edit companies' => 	'\'{0}\' aktualisiert',
    'log delete companies' => 	'\'{0}\' gelöscht',
    'log trash companies' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash companies' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment companies' => 	'Kommentiert zu \'{0}\'',
    'log subscribe companies' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe companies' => 	'Abo entfernt von \'{0}\'',
    'log tag companies' => 	'\'{0}\' verschlagwortet',
    'log link companies' => 	'\'{0}\' verknüpft',
    'log unlink companies' => 	'\'{0}\' entknüpft',
    'log tag companies data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link companies data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink companies data' => 	'\'{0}\' entknüpft von {1}',
  
    'log add mailcontents' => 	'\'{0}\' hinzugefügt',
    'log edit mailcontents' => 	'\'{0}\' aktualisiert',
    'log delete mailcontents' => 	'\'{0}\' gelöscht',
    'log trash mailcontents' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash mailcontents' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'log comment mailcontents' => 	'Kommentiert zu \'{0}\'',
    'log subscribe mailcontents' => 	'Abonniert zu \'{0}\'',
    'log unsubscribe mailcontents' => 	'Abo entfernt von \'{0}\'',
    'log tag mailcontents' => 	'\'{0}\' verschlagwortet',
    'log link mailcontents' => 	'\'{0}\' verknüpft',
    'log unlink mailcontents' => 	'\'{0}\' entknüpft',
    'log tag mailcontents data' => 	'\'{0}\' verschlagwortet als \'{1}\'',
    'log link mailcontents data' => 	'\'{0}\' verknüpft zu {1}',
    'log unlink companies data' => 	'\'{0}\' entknüpft von {1}',
  
    'log open timeslots' => 	'\'{0}\' geöffnet',
    'log close timeslots' => 	'\'{0}\' abgeschlossen',
    'log delete timeslots' => 	'\'{0}\' gelöscht',
    'log trash timeslots' => 	'\'{0}\' in den Papierkorb verschoben',
    'log untrash timeslots' => 	'\'{0}\' aus dem Papierkorb wiederhergestellt',
    'error assign workspace' => 	'Fehler beim Zuordnen der Vorlage zum Arbeitsbereich',
    'success assign workspaces' => 	'Erfolgreich Vorlage zum Arbeitsbereich zugeordnet',
    'success update config value' => 	'Konfigurations-Einstellungen aktualisiert',
    'view open tasks' => 	'Offene Aufgaben',
    'already logged in' => 	'Bereits eingeloggt',
  
    'some tasks could not be updated due to permission restrictions' => 	'Einige Aufgaben konnten wegen fehlender Zugriffsrechte nicht aktualisiert werden',
  
    'success trash object' => 	'Objekt erfolgreich in den Papierkorb verschoben',
    'error trash object' => 	'Fehler beim Verschieben des Objektes in den Papierkorb',
    'success untrash object' => 	'Objekt erfolgreich aus dem Papierkorb wiederhergestellt',
    'error untrash object' => 	'Fehler beim Wiederherstellen des Objektes aus dem Papierkorb',
    'success trash objects' => 	'{0} Objekte erfolgreich in den Papierkorb verschoben',
    'error trash objects' => 	'Fehler beim Verschieben von {0} Objekt(en) in den Papierkorb',
    'success untrash objects' => 	'{0} Objekte erfolgreich aus dem Papierkorb wiederhergestellt',
    'error untrash objects' => 	'Fehler beim Wiederherstellen von {0} Objekt(en) aus dem Papierkorb',
    'success delete object' => 	'Objekt erfolgreich gelöscht',
    'error delete object' => 	'Fehler beim Löschen des Objektes',
    

    'copied from file' => 	'Kopiert von der Datei {0} ({1})',

    'check file name advice' => 	'Nach der Umbenennung der Datei die TAB-Taste drücken, um eine Namensüberprüfung zu starten. Der Speichern-Button wird dadurch aktiviert.',
    'filename already exists' => 	'Der Dateiname wird bereits durch eine Datei benutzt.',

    'success purging trash' => 	'{0} Objekt(e) gelöscht.',
    'success sending reminders' => 	'{0} Erinnerun(en) versandt.',
    'failed to assign contact due to permissions' => 	'Keine Rechte vorhanden, um Kontakte zu diesen Arbeitsbereichen zuzuordnen: {0}',
  ); // array

?>