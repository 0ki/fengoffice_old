<?php

  /**
  * Error messages
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */

  // Return langs
  return array(
  
    // General
    'invalid email address' => 'Il formato dell\'indirizzo email non è valido',
   
    // Company validation errors
    'company name required' => 'Nome Società richiesto',
    'company homepage invalid' => 'URL Società non valido',
    
    // User validation errors
    'username value required' => 'Nome Utente richiesto',
    'username must be unique' => 'Spiacente, ma il nome utente scelto risulta già assegnato',
    'email value is required' => 'Indirizzo Email richiesto',
    'email address must be unique' => 'Spiacente, ma l\'indirizzo email selezionato risulta già assegnato',
    'company value required' => 'L\'utente deve far parte della Società',
    'password value required' => 'Password richiesta',
    'passwords dont match' => 'Le password non concordano',
    'old password required' => 'Vecchia password richiesta',
    'invalid old password' => 'Vecchia password non valida',
    'users must belong to a company' => 'Un Contatto deve appartenere a una Società  per generare un utente',
    'contact linked to user' => 'Contatto collegato all\'utente {0}',
    
    // Avatar
    'invalid upload type' => 'Tipo file non valido. I tipi consentiti sono {0}',
    'invalid upload dimensions' => 'Dimensioni immagine non valide. La grandezza massima è {0}x{1} pixels',
    'invalid upload size' => 'Dimensione immagine non validq. La grandezza massima è {0}',
    'invalid upload failed to move' => 'Sposatmento del file caricato fallita',
    
    // Registration form
    'terms of services not accepted' => 'Per poter creare un account occorre accettare i termini del servizio',
    
    // Init company website
    'failed to load company website' => 'Caricamento sito web fallito. Amministratore non trovato',
    'failed to load project' => 'Caricamento del Progetto attivo fallito',
    
    // Login form
    'username value missing' => 'Inserisci il nome utente',
    'password value missing' => 'Inserisci la password',
    'invalid login data' => 'Autenticazione fallita. Controlla le credenziali e prova ancora',
    
    // Add project form
    'project name required' => 'Nome Progetto richiesto',
    'project name unique' => 'Il nome del Progetto deve essere unico',
    
    // Add message form
    'message title required' => 'Titolo richiesto',
    'message title unique' => 'In questo Progetto il titolo deve essere unico',
    'message text required' => 'Testo richiesto',
    
    // Add comment form
    'comment text required' => 'Il testo del commento è richiesto',
    
    // Add milestone form
    'milestone name required' => 'Nome traguardo richiesto',
    'milestone due date required' => 'Data scadenza traguardo richiesto',
    
    // Add task list
    'task list name required' => 'Nome attività richiesto',
    'task list name unique' => 'Nel Progetto il nome dell\'Attività deve essere unico',
    'task title required' => 'Titolo attività richiesto',
  
    // Add task
    'task text required' => 'Testo attività richiesto',
    
    // Add event
    'event subject required' => 'Oggetto evento richiesto',
    'event description maxlength' => 'per la Descrizione max 3000 caratteri',
    'event subject maxlength' => 'Per l\' Oggetto max 100 caratteri',
    
    // Add project form
    'form name required' => 'Nome modulo richiesto',
    'form name unique' => 'Il nome modulo deve essere unico',
    'form success message required' => 'Annotazione Buonfine richiesta',
    'form action required' => 'Form action richiesta',
    'project form select message' => 'Seleziona la nota',
    'project form select task lists' => 'Seleziona l\'attività',
    
    // Submit project form
    'form content required' => 'Inserisci il contenuto nella casella di testo',
    
    // Validate project folder
    'folder name required' => 'Nome cartella richiesto',
    'folder name unique' => 'Nel Progetto, il nome della cartella deve essere unico',
    
    // Validate add / edit file form
    'folder id required' => 'Seleziona la cartella',
    'filename required' => 'Nome file richiesto',
    
    // File revisions (internal)
    'file revision file_id required' => 'Devi connettere la revisione a un file',
    'file revision filename required' => 'Nome file richiesto',
    'file revision type_string required' => 'Tipo file sconosciuto',
    
    // Test mail settings
    'test mail recipient required' => 'Indirizzo destinatario richiesto',
    'test mail recipient invalid format' => 'Formato indirizzo destinatario non valido',
    'test mail message required' => 'Messaggio Mail richiesto',
    
    // Mass mailer
    'massmailer subject required' => 'Oggetto del messaggio richiesto',
    'massmailer message required' => 'Corpo del messaggio richiesto',
    'massmailer select recepients' => 'Seleziona il destinatario del messaggio',
    
  	//Email module
  	'mail account name required' => 'Nome account richiesto',
  	'mail account id required' => 'Id account richiesto',
  	'mail account server required' => 'Server richiesto',
  	'mail account password required' => 'Password rrichiesta',	
  
  	'session expired error' => 'La sessione è terminata per inattività dell\'utente. Rientra',
  	'unimplemented type' => 'Tipo non implementato',
  	'unimplemented action' => 'Azione non implementata',
  
  	'workspace own parent error' => 'Uno Progetto non può essere genitore di se stesso',
  	'task own parent error' => 'Una attività non può essere genitore di se stessa',
  	'task child of child error' => 'Una attività non può essere figlia di uno dei suoi discendenti',
  
  	'chart title required' => 'Titolo grafico richiesto.',
  	'chart title unique' => 'Il titolo del grafico deve essere unico.',
    'must choose at least one workspace error' => 'Devi scegliere almeno uno Progetto dove collocare l\'oggetto.',
    
    
    'user has contact' => 'C\'è già un contatto assegnato a questo utente',
    
    'maximum number of users reached error' => 'Il numero massimo di utenti è stato raggiunto',
	'maximum number of users exceeded error' => 'Il numero massimo di utenti è stato superato. L\'applicazione non funzionerà più finché il problema non sarà risolto.',
	'maximum disk space reached' => 'Quota disco esaurita. Per poter aggiungere nuovi oggetti devi cancellarne qualcuno, oppure contatta l\'amministratore.',
	'error db backup' => 'Errore durante la creazione del backup. Controlla la costante MYSQLDUMP_COMMAND.',
	'error create backup folder' => 'Errore durante la creazione della cartella di backup. Il backup non può essere completato',
	'error delete backup' => 'Errore durante la cancellazione del backup del database,',
	'success delete backup' => 'Backup cancellato',
    'name must be unique' => 'Spiacente, il nome selezionato è già stato assegnato',
   ); // array

?>