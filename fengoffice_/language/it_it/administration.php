<?php return array(
	'administration tool name test_mail_settings' => 'Test configurazione email',
	'administration tool desc test_mail_settings' => 'Usa questo semplice strumento per inviare emails di test e controllare se il mailer di Feng Office è ben configurato',
	'administration tool name mass_mailer' => 'Spedizione massiva',
	'administration tool desc mass_mailer' => 'Semplice strumento per inviare messaggi di testo a qualunque gruppo di utenti registrato nel sistema',
	'configuration' => 'Configurazione',
	'mail transport mail()' => 'Configurazione di default di PHP',
	'mail transport smtp' => 'Server SMTP',
	'secure smtp connection no' => 'No',
	'secure smtp connection ssl' => 'Si, usa SSL',
	'secure smtp connection tls' => 'Si, usa TLS',
	'file storage file system' => 'File system',
	'file storage mysql' => 'Database (MySQL)',
	'config category name general' => 'Generale',
	'config category desc general' => 'Configurazione generale di Feng Office',
	'config category name mailing' => 'Sistema di posta elettronica',
	'config category desc mailing' => 'Usa queste preferenze per configurare come Feng Office gestisce l\'invio di  email. Puoi usare le opzioni configurazione fornite in php.ini o configurarlo affinché usi un altro server SMTP.',
	'config option name site_name' => 'Nome del sito',
	'config option desc site_name' => 'Valore visualizzato come nome del sito nella pagina del Sommario',
	'config option name file_storage_adapter' => 'Deposito File',
	'config option desc file_storage_adapter' => 'Seleziona dove vuoi memorizzare i documenti caricati. <strong>Cambiando deposito i file precedentemente caricati non saranno più disponibili</strong>.',
	'config option name default_project_folders' => 'Cartelle di default',
	'config option desc default_project_folders' => 'Cartelle che saranno create alla creazione del Progetto. Un nome per riga. Linee duplicate o vuote saranno ignorate',
	'config option name theme' => 'Tema',
	'config option desc theme' => 'L\'uso dei temi consente di personalizzare l\'aspetto di Feng Office. Premere Refresh per apportare le modifiche.',
	'config option name days_on_trash' => 'Giorni nel cestino',
	'config option desc days_on_trash' => 'Numero dei giorni per cui un oggetto resta cestinato prima di essere automaticamente cancellato. Indica 0 per impedire lo svuotamento del cestino.',
	'config option name time_format_use_24' => 'Usa il formato orario a 24 ore',
	'config option desc time_format_use_24' => 'Se abilitato il tempo sarà visualizzato come \'hh:mm\' da 00:00 a 23:59, se disabilitato le ore andranno da 1 a 12 AM o PM.',
	'config option name upgrade_check_enabled' => 'Abilita controllo aggiornamenti',
	'config option desc upgrade_check_enabled' => 'Se abilitato il sistema controllerà una volta al giorno la disponibilità di una versione aggiornata di Feng Office disponibile per il download',
	'config option name work_day_start_time' => 'Ora inizio giornata di lavoro',
	'config option desc work_day_start_time' => 'Specifica a che ora inizia una giornata lavorativa',
	'config option name exchange_compatible' => 'Modalità compatibile con Microsoft Exchange',
	'config option desc exchange_compatible' => 'Se usi Microsoft Exchange Server scegli Si per evitare problemi di spedizione posta.',
	'config option name mail_transport' => 'Trasporto Mail',
	'config option desc mail_transport' => 'Puoi usare la configurazione di default di PHP per l\'invio email o specificare un server SMTP',
	'config option name smtp_server' => 'Server SMTP',
	'config option name smtp_port' => 'Porta SMTP',
	'config option name smtp_authenticate' => 'Usa autenticazione SMTP',
	'config option name smtp_username' => 'Nome utente SMTP',
	'config option name smtp_password' => 'Password SMTP',
	'config option name smtp_secure_connection' => 'Usa una connessione SMTP sicura',
	'can edit company data' => 'Puoi modificare i dati della Società',
	'can manage security' => 'Puoi amministrare la sicurezza',
	'can manage workspaces' => 'Può amministrare i Progetti',
	'can manage configuration' => 'Può amministrare la configurazione',
	'can manage contacts' => 'Può amministrare i contatti',
	'group users' => 'Gruppo utenti',
	'user ws config category name dashboard' => 'Opzioni Sommario',
	'user ws config category name task panel' => 'Opzioni Attività',
	'user ws config option name show pending tasks widget' => 'Mostra lo strumento attività da completare',
	'user ws config option name pending tasks widget assigned to filter' => 'Mostra le attività assegnate a',
	'user ws config option name show late tasks and milestones widget' => 'Mostra le attività recenti e i traguardi',
	'user ws config option name show messages widget' => 'Mostra le Note',
	'user ws config option name show comments widget' => 'Mostra i Commenti',
	'user ws config option name show documents widget' => 'Mostra i Documenti',
	'user ws config option name show calendar widget' => 'Mostra il Mini Calendario',
	'user ws config option name show charts widget' => 'Mostra i Grafici',
	'user ws config option name show emails widget' => 'Mostra le email ',
	'user ws config option name my tasks is default view' => 'La vista di default è quella delle attività a me assegnate',
	'user ws config option desc my tasks is default view' => 'Se disabilitata, la vista di default del pannello attività mostrerà tutte le attività',
	'user ws config option name show tasks in progress widget' => 'Mostra lo strumento \'Attività in corso\'',
	'user ws config option desc can notify from quick add' => 'Abilita la casella così che gli utenti assegnati possono essere notificati dopo l\'aggiunta a una attività',
	'backup process desc' => 'Un backup salva lo stato corrente dell\'intera applicazione in una cartella compressa. Può essere usato per salvare una installazione di Feng Office. <br> Generare il backup di database e filesystem può durare un pò, ed è un processo  in tre passi: <br>1.- Lanciare la procedura di backup, <br>2.- Scaricare il backup. <br> 3.- Opzionalmente, il backup può essere cancellato manualmente, in questo caso non sarà più disponibile. <br> ',
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
	'user ws config option name tasksShowTags' => 'Mostra etichette',
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
	'can manage templates' => 'Può amministrare modelli',
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
	'you are adding object to template' => 'Stai aggiungendo {0} \'{1}\' ad un modello. Scegli uno dei modelli seguenti o creane uno nuovo.',
	'success add object to template' => 'L\'oggetto è stato aggiunto al modello',
	'object type not supported' => 'Questo tipo di oggetto non è supportato dai modelli',
	'assign template to workspace' => 'Assegna modello a Progetto',
	'config category name modules' => 'Moduli',
	'config category desc modules' => 'Usa questo parametro per abilitare o disabilitare i moduli di Feng Office. I moduli disabilitati non sono visibili nell\'interfaccia grafica. L\'operazione non cancella il permesso dell\'utente a creare o modificare il contenuto degli oggetti. ',
	'config option name enable_notes_module' => 'Abilita modulo Note',
	'config option name enable_email_module' => 'Abilita modulo Email',
	'config option name enable_contacts_module' => 'Abilita modulo Contatti',
	'config option name enable_calendar_module' => 'Abilita modulo Calendario',
	'config option name enable_documents_module' => 'Abilita modulo Documenti',
	'config option name enable_tasks_module' => 'Abilita modulo Attività',
	'config option name enable_weblinks_module' => 'Abilita modulo Collegamenti Web',
	'config option name enable_time_module' => 'Abilita modulo Tempo',
	'config option name enable_reporting_module' => 'Abilita modulo reports',
	'user ws config category name general' => 'Generale',
	'user ws config option name localization' => 'Localizzazione',
	'user ws config option desc localization' => 'Etichette e date saranno visualizzato in accordo a questa localizzazione. Aggiornare per attivare le modifiche.',
	'user ws config option name initialWorkspace' => 'Progetto iniziale',
	'user ws config option desc initialWorkspace' => 'Questo parametro ti lascia scegliere il Progetto  proposto al login, puoi anche scegliere che ti venga proposto l\'ultimo Progetto visualizzato.',
	'user ws config option name rememberGUIState' => 'Ricorda lo stato dell\'interfaccia utente',
	'user ws config option desc rememberGUIState' => 'Permette di salvare lo stato dell\'interfaccia grafica (dimensione dei pannelli, stato espanso/compresso, ecc.) per il prossimo login. Caratteristica ancora in BETA',
	'user ws config option name time_format_use_24' => 'Orario in formato 24 ore',
	'user ws config option desc time_format_use_24' => 'Se abilitato il formato ora sarà \'hh:mm\' dalle 00:00 alle 23:59, se non abilitato le ore andranno da 1 a 12 AM o PM.',
	'user ws config option name work_day_start_time' => 'Ora di inizio della giornata lavorativa',
	'user ws config option desc work_day_start_time' => 'Specifica l\'ora d\'inizio del giorno lavorativo',
	'config option name use_minified_resources' => 'Usa risorse minimizzate',
	'config option desc use_minified_resources' => 'Usa Javascript compresso e CSS per migliorare le prestazioni. Avrai bisogno di ricomprimere JS e CSS in caso di loro modifica utilizzando public/tools.',
	'user ws config option name can notify from quick add' => 'Notifica attività marcata di default',
	'cron events' => 'Eventi temporizzati',
	'about cron events' => 'Sulla temporizzazione degli eventi...',
	'cron events info' => 'Gli eventi temporizzati ti permettono di eseguire attività in Feng Office periodicamente, senza bisogno di entrare nel sistema. Per abilitare gli eventi temporizzati devi configurare un lavoro a tempo (cron job) che esegua il file "cron.php", collocato nella root di Feng Office. La periodicità del cron job determinerà quella degli eventi temporizzati di Feng Office. Per esempio, un cron job con frequenza cinque minuti che attivi un evento che controlli la presenza di upgrade ogni minuto, attiverà detto evento solo ogni cinque minuti. Per sapere come configurare un cron job contatta l\'amministratore del sistema o il provider internet.',
	'cron event name check_mail' => 'Controlla la posta',
	'cron event desc check_mail' => 'Questo evento temporizzato controllerà la presenza di nuove mail per tutti gli account email noti al sistema.',
	'cron event name purge_trash' => 'Svuota il cestino',
	'cron event desc purge_trash' => 'Questo evento temporizzato cancellerà gli oggetti più vecchi di quanto specificato dal parametro di configurazione \'Giorni di permanenza nel cestino\'.',
	'cron event name send_reminders' => 'Invia promemoria',
	'cron event desc send_reminders' => 'Questo evento temporizzato invierà email di promemoria.',
	'cron event name check_upgrade' => 'Controlla aggiornamento',
	'cron event desc check_upgrade' => 'Questo evento temporizzato controllerà la disponibilità di nuove versioni di Feng Office.',
	'cron event name create_backup' => 'Crea backup',
	'cron event desc create_backup' => 'Crea un backup scaricabile dalla sezione di amministrazione Backup.',
	'next execution' => 'Prossima esecuzione',
	'delay between executions' => 'Ritardo fra esecuzioni successive',
	'enabled' => 'Abilitato',
	'no cron events to display' => 'Non ci sono eventi temporizzati da mostrare',
	'success update cron events' => 'Eventi temporizzati aggiornati con successo',
	'manual upgrade' => 'Aggiornamento manuale',
	'manual upgrade desc' => 'Per aggiornare manualmente Feng Office occorre scaricare la nuova versione, estrarla nella root dell\'istallazione corrente e puntare il browser all\'URL <a href="public/upgrade">\'public/upgrade\'</a> per avviare la procedura di aggiornamento.',
	'automatic upgrade' => 'Aggiornamento automatico',
	'automatic upgrade desc' => 'L\'aggiornamento automatico scaricherà, estrarrà ed avvierà automaticamente la procedura di aggiornamento. È necessario che il server web abbia i permessi di scrittura su ogni cartella.',
	'start automatic upgrade' => 'Avvia aggiornamento automatico',
	'config category name passwords' => 'Passwords',
	'config category desc passwords' => 'Usa queste preferenze per amministrare le opzioni per la password',
	'config option name checkout_notification_dialog' => 'Notifica per il rilascio dei documenti',
	'config option desc checkout_notification_dialog' => 'Se abilitato, durante lo scaricamento l\'utente dovrà scegliere tra la modifica e la sola lettura.',
	'config option name file_revision_comments_required' => 'Richiesti i commenti per la revisione del file',
	'config option desc file_revision_comments_required' => 'Se definito, aggiungere un nuovo file di revisioni richiede agli utenti di fornire un nuovo commento per ogni revisione.',
	'config option name currency_code' => 'Valuta',
	'config option desc currency_code' => 'Simbolo valuta',
	'config option name min_password_length' => 'Lunghezza minima password',
	'config option desc min_password_length' => 'Minimo numero di caratteri richiesti per la password',
	'config option name password_numbers' => 'Numeri nella password',
	'config option desc password_numbers' => 'Numero di cifre richieste per la password',
	'config option name password_uppercase_characters' => 'Caratteri maiuscoli richiesti nella password',
	'config option desc password_uppercase_characters' => 'Numero dei caratteri maiuscoli richiesti per la password',
	'config option name password_metacharacters' => 'Metacaratteri password',
	'config option desc password_metacharacters' => 'Totale metacaratteri richiesti per la password (es. ., $, *)',
	'config option name password_expiration' => 'Scadenza password in giorni',
	'config option desc password_expiration' => 'Numero giorni di validità di una nuova password (0 per non fare scadere la password)',
	'config option name password_expiration_notification' => 'Notifica scadenza password (anticipo giorni)',
	'config option desc password_expiration_notification' => 'Numero dei giorni di anticipo per la notifica della scadenza della password (0 per disabilitare l\'opzione)',
	'config option name account_block' => 'Blocco account su scadenza password',
	'config option desc account_block' => 'Blocco dell\'account utente alla scadenza della password (potrà essere riabilitata solo dall\'amministratore)',
	'config option name new_password_char_difference' => 'Convalida la nuova password rispetto a quelle già usate',
	'config option desc new_password_char_difference' => 'Conferma che la nuova password differisce per almeno 3 caratteri dalle ultime 10 usate ',
	'config option name validate_password_history' => 'Convalida storico password',
	'config option desc validate_password_history' => 'Conferma che la nuova password è diversa dalle ultime 10 usate',
	'config option name checkout_for_editing_online' => 'Blocco automatico del file durante la modifica',
	'config option desc checkout_for_editing_online' => 'Quando un utente modifica un documento questo sarà bloccato in automatico in modo da evitare modifiche contemporanee dello stesso file da parte di altri utenti',
	'can manage reports' => 'Può amministrare rapporti',
	'user ws config category name calendar panel' => 'Opzioni calendario',
	'user ws config option name show dashboard info widget' => 'Mostra la Descrizione progetto',
	'user ws config option name show getting started widget' => 'Mostra lo strumento Partenza',
	'user ws config option name show_tasks_context_help' => 'Mostra l\'aiuto contestuale per le attività',
	'user ws config option desc show_tasks_context_help' => 'Se abilitato, comparirà un aiuto contestuale nel pannello delle attività',
	'user ws config option name start_monday' => 'La settimana inizia di Lunedì',
	'user ws config option desc start_monday' => 'Mostrerà il calendario con Lunedì come primo giorno della settimana. Premere Refresh per applicare la modifica.',
	'user ws config option name date_format' => 'Formato data',
	'user ws config option desc date_format' => 'Formato da applicare ai valori di tipo data.
Code explanations: d = Day number (2 digits with leading zeros), D = Day name (three letters), j = Day number, l = Complete day name, m = Month number (with leading zeros), M = Month name (three letters), n = Month number, F = Complete month name, Y = Year (4 digits), y = Year (2 digits). Remember that you refresh is required to apply the changes.',
	'user ws config option name descriptive_date_format' => 'Formato descrittivo delle date',
	'user ws config option desc descriptive_date_format' => 'Formato da applicare ai valori descrittivi delle date. Vedi formato data precedente. Premi Aggiorna per applicare la modifica.',
	'backup config warning' => 'Attenzione: le cartelle config e tmp non saranno salvate',
	'cron event name send_notifications_through_cron' => 'Invia la notifica via cron',
	'cron event desc send_notifications_through_cron' => 'Abilitando questo evento le notifiche email saranno inviate via cron e non quando vengono generate da Feng Office',
	'cron event name backup' => 'Backup Feng Office',
	'cron event desc backup' => 'Abilitando questo evento si ottiene il backup periodico di Feng Office . Il proprietario dell\'installazione potrà scaricare i backup tramite il pannello di amministrazione. I backup sono mantenuti come file compressi (zip) nella cartella \'tmp/backup\'',
	'select object type' => 'Scegli il tipo di oggetto',
	'select one' => '--scegli--',
	'email type' => 'Email ',
	'custom properties updated' => 'Proprietà personalizzate aggiornate',
	'autentify password title' => 'Autenticazione Password',
	'autentify password desc' => 'Hai richiesto di accedere al pannello di amministrazione.<br/> Prego reinserire la password',
	'config option name show_feed_links' => 'Visualizza collegamenti feed',
	'config option desc show_feed_links' => 'Consente di visualizzare i link RSS oppure i feeds tipo iCal all\'utente collegato al sistema, in modo da poterli sottoscrivere. <strong>ATTENZIONE: Questi link contengono informazioni che possono consentire la login dell\'utente al sistema. Se un utente non autorizzato condivide uno di questi link può venire compromessa l\'integrità di tutte le informazioni contenute nel sistema.</strong>',
	'config option name ask_administration_autentification' => 'Autenticazione dell\'Amministratore',
	'config option desc ask_administration_autentification' => 'Indica se viene richiesta la password quando si accede al pannello di amministrazione',
	'config option name smtp_address' => 'Indirizzo server SMTP',
	'config option desc smtp_address' => 'Opzionale. Alcuni server richiedono che tu usi un indirizzo email da questo server per inviare email. Non immettere nulla per usare l\'indirizzo email dell\'utente.',
	'config option name user_email_fetch_count' => 'Numero max di email da leggere',
	'config option desc user_email_fetch_count' => 'Quante email vengono lette dal server quando un utente clicca su "Controlla nuova posta". Usando un numero alto di questo valore possono avvenire errori di timeout. Usare 0 per nessun limite. Nota che questo valore non influisce sul numero di email da leggere tramite Cron.',
	'user ws config category name mails panel' => 'Opzioni email',
	'user ws config option name show_week_numbers' => 'Visualizza numero di settimane',
	'user ws config option desc show_week_numbers' => 'Visualizza numero di settimane nelle viste Settimanale e Mensile.',
	'user ws config option name show_context_help' => 'Visualizza help contestuale',
	'user ws config option desc show_context_help' => 'Indica se vuoi vedere l\'help, oppure vederlo fino a che il box non sia chiuso oppure non vederlo più.',
	'user ws config option name view deleted accounts emails' => 'Visualizza le email di account cancellati',
	'user ws config option desc view deleted accounts emails' => 'Abilita la visualizzazione di email relative ad account cancellati (quando cancelli un account non devi cancellare le email per usare questa funzione)',
	'user ws config option name block_email_images' => 'Blocca le immagini nelle email',
	'user ws config option desc block_email_images' => 'Non visualizza le immagini incorporate nelle email.',
	'user ws config option name draft_autosave_timeout' => 'Intervallo di salvataggio automatico delle email in fase di scrittura',
	'user ws config option desc draft_autosave_timeout' => 'Secondi fra ogni salvataggio automatico per le mail in formato bozza (0 per disabilitare il salvataggio automatico)',
	'show context help always' => 'Sempre',
	'show context help never' => 'Mai',
	'show context help until close' => 'Fino alla chiusura',
	'can manage time' => 'Può gestire il tempo',
	'add a parameter to template' => 'Aggiungi un parametro per questo template',
	'parameters' => 'Parametri',
	'user ws config option name noOfTasks' => 'Imposta il numero di attività da visualizzare come default',
	'user ws config option name amount_objects_to_show' => 'Numero di oggetti collegati da visualizzare',
	'user ws config option desc amount_objects_to_show' => 'Imposta il numero di oggetti collegati da visualizzare',
	'user ws config option name show_two_weeks_calendar' => 'Visualizza due settimane',
	'user ws config option desc show_two_weeks_calendar' => 'Imposta il calendario per visualizzare due settimane',
	'user ws config option name attach_docs_content' => 'Allega il contenuto dei files',
	'user ws config option desc attach_docs_content' => 'Quando questa opzione è "Yes" i file sono allegati come normali files allegati alla mail. Quando questa opzione è "No" verrà linkato un collegamento al file.',
	'edit default user preferences' => 'Modifica le preferenze utente predefinite',
	'default user preferences' => 'Preferenze utente predefinite',
	'default user preferences desc' => 'Imposta i valori predefiniti per le preferenze utente. Questi verranno applicati quando l\'utente non ha ancora scelto un valore per un\'opzione.',
	'can add mail accounts' => 'Può aggiungere account email',
	'user ws config option name max_spam_level' => 'Max livello spam permesso',
	'user ws config option desc max_spam_level' => 'Quando si recuperano le email, i messaggi con la valutazione di Spam più alta di questo valore verranno trasmessi nella cartella "Posta indesiderata". Impostare 0 per il filtraggio massimo, 10 per non applicare alcun filtro. Questa opzione funziona soltanto se sul vostro server di posta è configurato un sistema AntiSpam.',
	'mail accounts' => 'Accounts Email',
	'incoming server' => 'Server in entrata',
	'outgoing server' => 'Server in uscita',
	'no email accounts' => 'Nessun account email',
	'user ws config option name create_contacts_from_email_recipients' => 'Crea contatti da destinatari email',
	'user ws config option desc create_contacts_from_email_recipients' => 'Quando questa opzione è "Yes" verrà automaticamente creato un contatto per ciascun indirizzo email a cui è stata inviata una email. Devi avere però l\'autorizzazione "Può gestire i contatti".',
	'user ws config option name drag_drop_prompt' => 'Azione da eseguire su drag and drop sul progetto',
	'user ws config option desc drag_drop_prompt' => 'Scegliere quale azione eseguire quando verrà trascinato un oggetto sul Progetto.',
	'drag drop prompt option' => 'Richiesta utente per una azione',
	'drag drop move option' => 'Muovere al nuovo progetto e perdere i precedenti progetti',
	'drag drop keep option' => 'Aggiungere a nuovo progetto e mantenere i precedenti progetti',
	'user ws config option name mail_drag_drop_prompt' => 'Classificare gli allegati alle email su operazione di trascinamento?',
	'user ws config option desc mail_drag_drop_prompt' => 'Scegliere cosa fare quando un allegato email viene trascinato su un progetto.',
	'mail drag drop prompt option' => 'Richiesta utente per una azione',
	'mail drag drop classify option' => 'Classificare allegati',
	'mail drag drop dont option' => 'Non classificare allegati',
	'user ws config option name show_emails_as_conversations' => 'Visualizzare le email come conversazioni',
	'user ws config option desc show_emails_as_conversations' => 'Se abilitato, le email verranno raggruppate per conversazione, visualizzando tutte le email che appartengono allo stessa conversazioneg (risposte, inoltri, etc) come una riga nella lista.',
	'user ws config option name autodetect_time_zone' => 'Rilevazione automatica del fuso orario',
	'user ws config option desc autodetect_time_zone' => 'Quando questa opzione è abilitata, il fuso orario verrà rilevato automaticamente dalle impostazioni del browser.',
	'user ws config option name search_engine' => 'Motore di ricerca',
	'user ws config option desc search_engine' => 'Scegli il motore di ricerca da usare. "LIKE" effettuerà una ricerca più esaustiva ma più lenta di "MATCH".',
); ?>
