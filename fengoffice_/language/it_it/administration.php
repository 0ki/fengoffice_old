<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Test configurazione mail',
    'administration tool desc test_mail_settings' => 'Usa questo semplice strumento per inviare  emails di test e controllare se il mailer di OpenGoo è ben configurato',
    'administration tool name mass_mailer' => 'Spedizione massiva',
    'administration tool desc mass_mailer' => 'Semplice strumento per inviare messaggi di testo a ogni gruppo di utenti registrato nel sistema',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configurazione',
    
    'mail transport mail()' => 'Configurazione di default di PHP',
    'mail transport smtp' => 'Server SMTP',
    
    'secure smtp connection no'  => 'No',
    'secure smtp connection ssl' => 'Si, usa SSL',
    'secure smtp connection tls' => 'si, usa TLS',
    
    'file storage file system' => 'File system',
    'file storage mysql' => 'Database (MySQL)',
    
    // Categories
    'config category name general' => 'Generale',
    'config category desc general' => 'Configurazione generale di OpenGoo',
    'config category name mailing' => 'Sistema di posta elettronica',
    'config category desc mailing' => 'Usa questo insieme di preferenze per configurare come OpenGoo gestisce l\'invio di  email. Puoi usare le opzioni configurazione fornite in php.ini o configurarlo affinché usi un\' altro server SMTP',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nome del sito',
    'config option desc site_name' => 'Valore visualizzato come nome del sito nella pagina del Sommario',
    'config option name file_storage_adapter' => 'Deposito File',
    'config option desc file_storage_adapter' => 'Seleziona dove vuoi memorizzare i documenti caricati. <strong>Cambiando deposito i file precedentemente caricati diventeranno indisponibili</strong>.',
    'config option name default_project_folders' => 'Cartelle di default',
    'config option desc default_project_folders' => 'Cartelle che saranno create alla creazione del Progetto. Un nome per riga. Linee duplicate o vuote saranno ignorate',
    'config option name theme' => 'Tema',
    'config option desc theme' => 'L\'uso dei temi consente di personalizzare l\'aspetto di OpenGoo',
  	'config option name days_on_trash' => 'Giorni nel cestino',
    'config option desc days_on_trash' => 'Numero dei giorni per cui un oggetto resta cestinato prima di essere automaticamente cancellato. Indica 0 per impedire lo svuotamento del cestino.',
	'config option name time_format_use_24' => 'Usa il formato orario a 24 ore',
  	'config option desc time_format_use_24' => 'Se abilitato il tempo sarà visualizzato come \'hh:mm\' da 00:00 to 23:59, se disabilitato le ore andranno da 1 a 12 AM o PM.',
  
    'config option name upgrade_check_enabled' => 'Abilita controllo aggiornamenti',
    'config option desc upgrade_check_enabled' => 'Se abilitato il sistema controllerà una volta algiorno la disponibilità di una versione aggiornata di OpenGoo disponibile per il download',
	'config option name work_day_start_time' => 'Ora inizio giornata di lavoro',
  	'config option desc work_day_start_time' => 'Specifica a che ora inizia una giornata lavorativa',
    
    // Mailing
    'config option name exchange_compatible' => 'Modalità compatibile con Microsoft Exchange',
    'config option desc exchange_compatible' => 'Se usi Microsoft Exchange Server scegli Si per evitare problemi di spedizione posta.',
    'config option name mail_transport' => 'Trasporto Mail',
    'config option desc mail_transport' => 'Puoi usare la configurazione di default di PHP per la spedizione di email o specificare un server SMTP',
    'config option name smtp_server' => 'Server SMTP',
    'config option name smtp_port' => 'Porta SMTP',
    'config option name smtp_authenticate' => 'Usa autenticazione SMTP',
    'config option name smtp_username' => 'nome utente SMTP',
    'config option name smtp_password' => 'password SMTP',
    'config option name smtp_secure_connection' => 'Usa una connessione SMTP sicura',
  
 	'can edit company data' => 'Puoi modificare i dati della Società',
  	'can manage security' => 'Puoi amministrare la sicurezza',
  	'can manage workspaces' => 'Puoi amministrare i Progetti',
  	'can manage configuration' => 'Puoi amministrare la configurazione',
  	'can manage contacts' => 'Puoi amministrare i contatti',
  	'group users' => 'Gruppo utenti',
    
  	
  	'user ws config category name dashboard' => 'Opzioni Sommario',
  	'user ws config category name task panel' => 'Opzioni Attività',
  	'user ws config option name show pending tasks widget' => 'Mostra lo strumento attività pendenti',
  	'user ws config option name pending tasks widget assigned to filter' => 'Mostra le attività assegnate a',
  	'user ws config option name show late tasks and milestones widget' => 'Mostra le attività in ritardo e lo strumento traguardo',
  	'user ws config option name show messages widget' => 'Mostra lo strumento Note',
  	'user ws config option name show comments widget' => 'Mostra lo strumento Commenti',
  	'user ws config option name show documents widget' => 'Mostra lo strumento Documenti',
  	'user ws config option name show calendar widget' => 'Mostra lo strumento Mini Calendario',
  	'user ws config option name show charts widget' => 'Mostra lo strumento Grafici',
  	'user ws config option name show emails widget' => 'Mostra lo strumento Email',
  	
  	'user ws config option name my tasks is default view' => 'La vista di default è quella delle attività assegnate a me',
  	'user ws config option desc my tasks is default view' => 'Se disabilitata, la vista di default del pannello attività mostrerà tutte le attività',
  	'user ws config option name show tasks in progress widget' => 'Mostra lo strumento \'Attività in corso\'',
  	'user ws config option name can notify from quick add' => 'Casella di notifica in \'Aggiunta veloce\'',
  	'user ws config option desc can notify from quick add' => 'Una casella è abilitata così gli utenti assegnati possono essere notificati dopo l\'aggiunta veloce a una attività',
 	
  	'backup process desc' => 'Un backup salva lo stato corrente dell\'intera applicazione in una cartella compressa. Può essere usato per salvare una installazione di OpenGoo. <br> Generare il backup di database e filesystem può durare un pò, ed è un processo  in tre passi: <br>1.- Lanciare la procedura di backup, <br>2.- Scaricare il backup. <br> 3.- Opzionalmente, il backup può essere cancellato manualmente, in questo caso non sarà più disponibile. <br> ',
  	'start backup' => 'Lancia il backup',
    'start backup desc' => 'Il lancio del processo di backup implica la cancellazione dei backups precedenti, e la generazione di un backup nuovo.',
  	'download backup' => 'Scarica il backup',
    'download backup desc' => 'Per poter scaricare il backup, prima devi generarlo.',
  	'delete backup' => 'Cancella il backup',
    'delete backup desc' => 'Cancella l\'ultimo backup im modo che non possa essere scaricato. La cancellazione del backup dopo averlo scaricato è fortemente consigliata.',
    'backup' => 'Backup',
    'backup menu' => 'Menù Backup',
   	'last backup' => 'L\'ultimo backup è stato creato in',
   	'no backups' => 'Backup scaricabile inesistente',
   	
   	'user ws config option name always show unread mail in dashboard' => 'Mostra sempre le mail non lette nel Sommario',
   	'user ws config option desc always show unread mail in dashboard' => 'Se è stato scelto NO le mail non lette saranno mostrate nel Sommario del Progetto',
   	'workspace emails' => 'Mail Progetto',
  	'user ws config option name tasksShowWorkspaces' => 'Mostra Progetti',
  	'user ws config option name tasksShowTime' => 'Mostra ora',
  	'user ws config option name tasksShowDates' => 'Mostra date',
  	'user ws config option name tasksShowTags' => 'Mostra tags',
  	'user ws config option name tasksGroupBy' => 'Raggruppa per',
  	'user ws config option name tasksOrderBy' => 'Ordina per',
  	'user ws config option name task panel status' => 'Stato',
  	'user ws config option name task panel filter' => 'Filtra per',
  	'user ws config option name task panel filter value' => 'Valore filtro',
  
  	'templates' => 'Modelli',
	'add template' => 'Aggiungi modello',
	'confirm delete template' => 'Confermi la cancellazione del modello?',
	'no templates' => 'Non ci sono modelli',
	'template name required' => 'Il nome del modello è richiesto',
	'can manage templates' => 'Puoi amministrare modelli',
	'new template' => 'Nuovo modello',
	'edit template' => 'Modifica modello',
	'template dnx' => 'Modello inesistente',
	'success edit template' => 'Modello modificato con successo',
	'log add cotemplates' => '{0} aggiunto',
	'log edit cotemplates' => '{0} modificato',
	'success delete template' => 'Il modello è stato cancellato',
	'error delete template' => 'Errore durante la cancellazione del modello',
	'objects' => 'Oggetti',
	'objects in template' => 'Oggetti nel modello',
	'no objects in template' => 'Non ci sono oggetti in questo modello',
	'add to a template' => 'Aggiungi a un modello',
  	'add an object to template' => 'Aggiungi un oggetto a questo modello',
	'you are adding object to template' => 'Stai aggiungendo {0} \'{1}\' a un modello. Scegli uno dei modelli seguenti o creane uno nuovo per {0}.',
	'success add object to template' => 'L\'oggetto è stato aggiunto al modello',
	'object type not supported' => 'Questo tipo di oggetto non è supportato dai modelli',
  	'assign template to workspace' => 'Assegna modello a Progetto',
  ); // array

?>