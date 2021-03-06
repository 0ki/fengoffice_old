<?php

  return array(
  
    // ---------------------------------------------------
    //  Administration tools
    // ---------------------------------------------------
    
    'administration tool name test_mail_settings' => 'Paramètres du courriel de test',
    'administration tool desc test_mail_settings' => 'Utilisez ce simple outils pour envoyer un courriel de test, et vérifier que Opengoo est bien configuré',
    'administration tool name mass_mailer' => 'Outils de Mass mailing',
    'administration tool desc mass_mailer' => 'Utilisez ce simple outils pour envoyer des messages aux groupes d\'utilisateurs enregistrés',
  
    // ---------------------------------------------------
    //  Configuration categories and options
    // ---------------------------------------------------
  
    'configuration' => 'Configuration',
    
    'mail transport mail()' => 'Paramètres PHP par défaut',
    'mail transport smtp' => 'Serveur SMTP',
    
    'secure smtp connection no'  => 'Non',
    'secure smtp connection ssl' => 'Oui, utiliser SSL',
    'secure smtp connection tls' => 'Oui, utiliser TLS',
    
    'file storage file system' => 'Système de fichiers',
    'file storage mysql' => 'Base de données (MySQL)',
    
    // Categories
    'config category name general' => 'Général',
    'config category desc general' => 'Paramètres principaux d\'OpenGoo',
    'config category name mailing' => 'Mailing',
    'config category desc mailing' => 'Utilisez ces paramètre pour piloter OpenGoo dans sa façon d\'envoyer les courriels. Vous pouvez utiliser les options de configuration fourni dans votre php.ini ou utiliser celles-ci pour paramètrer d\'autres serveurs SMTP',
    
    // ---------------------------------------------------
    //  Options
    // ---------------------------------------------------
    
    // General
    'config option name site_name' => 'Nom du site',
    'config option desc site_name' => 'Cette valeur s\'affichera sur la page de l\'aperçu général',
    'config option name file_storage_adapter' => 'Dossier d\'enregistrement des Fichiers',
    'config option desc file_storage_adapter' => 'Selectionnez où seront stockés les documents chargés. <strong>Changer de dossier rendra les fichiers chargés précèdemment indisponible</strong>.',
    'config option name default_project_folders' => 'Dossiers par Défaut',
    'config option desc default_project_folders' => 'Les dossiers qui seront créés quand le contexte l\'est. Chaque nom de dossier devrait avoir une nouvelle ligne. Les lignes en double ou vides seront ignorées',
    'config option name theme' => 'Thème',
    'config option desc theme' => 'Utilisez les thèmes pour change l\'apparence d\'OpenGoo',
    
    'config option name upgrade_check_enabled' => 'Activer la vérification de mise-à-jour',
    'config option desc upgrade_check_enabled' => 'Si oui, le système vérifiera chaque jour s\'il existe une nouvelle version d\'OpenGoo à télécharger',
    
    // Mailing
    'config option name exchange_compatible' => 'Microsoft Exchange mode compatibilité',
    'config option desc exchange_compatible' => 'Si vous utilisez Microsoft Exchange Server cochez cette option pour éviter les problèmes connus.',
    'config option name mail_transport' => 'Transport courriel',
    'config option desc mail_transport' => 'Vous pouvez utiliser les valeurs PHP par défaut pour envoyer des courriels ou spécifier le serveur SMTP',
    'config option name smtp_server' => 'Serveur SMTP',
    'config option name smtp_port' => 'Port SMTP',
    'config option name smtp_authenticate' => 'Utiliser l\'authentication SMTP',
    'config option name smtp_username' => 'Nom d\'utilisateur SMTP',
    'config option name smtp_password' => 'Mot-de-passe SMTP',
    'config option name smtp_secure_connection' => 'Utiliser une connexion SMTP sécurisée',
  
 	'can edit company data' => 'Peut éditer les données de la société',
  	'can manage security' => 'Peut gérer la sécurité',
  	'can manage workspaces' => 'Peut gérer les contextes',
  	'can manage configuration' => 'Peut gérer la configuration',
  	'can manage contacts' => 'Peut gérer les contacts',
  	'group users' => 'Groupe utilisateurs',
    
  	
  	'user ws config category name dashboard' => 'Options de l\'aperçu général',
  	'user ws config category name task panel' => 'Options des tâches',
  	'user ws config option name show pending tasks widget' => 'Voir le widget des tâches en attente',
  	'user ws config option name pending tasks widget assigned to filter' => 'Voir le widget des tâches affectées à',
  	'user ws config option name show late tasks and milestones widget' => 'Voir le widget des tâches et jalons en retard',
  	'user ws config option name show messages widget' => 'Voir le widget de note',
  	'user ws config option name show comments widget' => 'Voir le widget de commentaires',
  	'user ws config option name show documents widget' => 'Voir le widget de documents',
  	'user ws config option name show calendar widget' => 'Voir le widget du mini calendrier',
  	'user ws config option name show charts widget' => 'Voir le widget des graphiques',
  	'user ws config option name show emails widget' => 'Voir le widget des courriels',
  	
  	'user ws config option name my tasks is default view' => 'Tâches affectées à moi est la vue par défaut',
  	'user ws config option desc my tasks is default view' => 'Si non est sélectionné, la vue par défaut du panneau des tâches montrera toutes les tâches',
  	'user ws config option name show tasks in progress widget' => 'Voir le widget \'des tâches en cours\' ',
  	'user ws config option name can notify from quick add' => 'Checkbox de notification en ajout express',
  	'user ws config option desc can notify from quick add' => 'Une checkbox est cochée pour notifier aux utilisateurs affectés les ajouts express sur les tâches',
 	
  	'backup process desc' => 'Un backup enregistre l\'état en cours de toute l\'application dans un dossier compressé.<br> Générer un backup du système et de sa base de données peut prendre quelques secondes, ainsi faire un backup est un processus qui se déroule en trois étapes: <br>1.- Lancer le processus de backup , <br>2.- Télécharger le backup. <br> 3.- En Option, un backup peut être détruit manuellement, pour ne plus être disponible dans le futur. <br> ',
  	'start backup' => 'Lancement du processus de backup',
    'start backup desc' => 'Launcer un processus de backup impique de supprimer les backups précédents, et d\'en générer un nouveau.',
  	'download backup' => 'Télécharger un backup',
    'download backup desc' => 'Pour télécharger un backup vous devez en premier lieu générer un backup.',
  	'delete backup' => 'Supprimer le backup',
    'delete backup desc' => 'Supprimer le dernier backup puisqu\'il n\'est pas disponible au téléchargement. Supprimer les backups après téléchargement est fortement recommandé.',
    'backup' => 'Backup',
    'backup menu' => 'Backup Menu',
   	'last backup' => 'Dernier backup a été créé sur',
   	'no backups' => 'il n\'y a pas de backups à télécharger',
   	
   	'user ws config option name always show unread mail in dashboard' => 'Always show unread email in dashboard',
   	'user ws config option desc always show unread mail in dashboard' => 'When NO is chosen emails from the active workspace will be shown',
   	'workspace emails' => 'Courriels de contexte',
  	'user ws config option name tasksShowWorkspaces' => 'Voir contextes',
  	'user ws config option name tasksShowTime' => 'Voir heures',
  	'user ws config option name tasksShowDates' => 'Voir dates',
  	'user ws config option name tasksShowTags' => 'Voir étiquettes',
  	'user ws config option name tasksGroupBy' => 'Groupé par',
  	'user ws config option name tasksOrderBy' => 'Trié par',
  	'user ws config option name task panel status' => 'Status',
  	'user ws config option name task panel filter' => 'Filtré par',
  	'user ws config option name task panel filter value' => 'Valeur de Filtre',
  	); // array

?>