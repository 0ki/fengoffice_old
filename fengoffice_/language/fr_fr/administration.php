<?php return array(
	'administration tool name test_mail_settings' => 'Paramètres du courriel de test',
	'administration tool desc test_mail_settings' => 'Utilisez ce simple outils pour envoyer un courriel de test, et vérifier que OpenGoo est bien configuré',
	'administration tool name mass_mailer' => 'Outils de Mass mailing',
	'administration tool desc mass_mailer' => 'Utilisez ce simple outils pour envoyer des messages aux groupes d\'utilisateurs enregistrés',
	'configuration' => 'Configuration',
	'mail transport mail()' => 'Paramètres PHP par défaut',
	'mail transport smtp' => 'Serveur SMTP',
	'secure smtp connection no' => 'Non',
	'secure smtp connection ssl' => 'Oui, utiliser SSL',
	'secure smtp connection tls' => 'Oui, utiliser TLS',
	'file storage file system' => 'Système de fichiers',
	'file storage mysql' => 'Base de données (MySQL)',
	'config category name general' => 'Général',
	'config category desc general' => 'Paramètres principaux d\'OpenGoo',
	'config category name mailing' => 'Mailing',
	'config category desc mailing' => 'Utilisez ces paramètre pour piloter OpenGoo dans sa façon d\'envoyer les courriels. Vous pouvez utiliser les options de configuration fourni dans votre php.ini ou utiliser celles-ci pour paramétrer d\'autres serveurs SMTP',
	'config option name site_name' => 'Nom du site',
	'config option desc site_name' => 'Cette valeur s\'affichera sur la page de l\'aperçu général',
	'config option name file_storage_adapter' => 'Dossier d\'enregistrement des Fichiers',
	'config option desc file_storage_adapter' => 'Sélectionnez où seront stockés les documents chargés. <strong>Changer de dossier rendra les fichiers chargés précèdemment indisponible</strong>.',
	'config option name default_project_folders' => 'Dossiers par Défaut',
	'config option desc default_project_folders' => 'Les dossiers qui seront créés quand le contexte l\'est. Chaque nom de dossier devrait avoir une nouvelle ligne. Les lignes en double ou vides seront ignorées',
	'config option name theme' => 'Thème',
	'config option desc theme' => 'Utilisez les thèmes pour change l\'apparence d\'OpenGoo',
	'config option name upgrade_check_enabled' => 'Activer la vérification de mise-à-jour',
	'config option desc upgrade_check_enabled' => 'Si oui, le système vérifiera chaque jour s\'il existe une nouvelle version d\'OpenGoo à télécharger',
	'config option name exchange_compatible' => 'Mode compatibilité pour Microsoft Exchange',
	'config option desc exchange_compatible' => 'Si vous utilisez Microsoft Exchange Server cochez cette option pour éviter des problèmes connus.',
	'config option name mail_transport' => 'Transport courriel',
	'config option desc mail_transport' => 'Vous pouvez utiliser les valeurs PHP par défaut pour envoyer des courriels ou spécifier le serveur SMTP',
	'config option name smtp_server' => 'Serveur SMTP',
	'config option name smtp_port' => 'Port SMTP',
	'config option name smtp_authenticate' => 'Utiliser l\'authentification SMTP',
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
	'user ws config option desc can notify from quick add' => 'Une checkbox est cochée pour notifier aux utilisateurs affectés les ajouts express sur les tâches',
	'backup process desc' => 'Un backup enregistre l\'état en cours de toute l\'application dans un dossier compressé.<br> Générer un backup du système et de sa base de données peut prendre quelques secondes, ainsi faire un backup est un processus qui se déroule en trois étapes: <br>1.- Lancer le processus de backup , <br>2.- Télécharger le backup. <br> 3.- En Option, un backup peut être détruit manuellement, pour ne plus être disponible dans le futur. <br> ',
	'start backup' => 'Lancement du processus de backup',
	'start backup desc' => 'Lancer un processus de backup implique de supprimer les backups précédents, et d\'en générer un nouveau.',
	'download backup' => 'Télécharger un backup',
	'download backup desc' => 'Pour télécharger un backup vous devez en premier lieu générer un backup.',
	'delete backup' => 'Supprimer le backup',
	'delete backup desc' => 'Supprimer le dernier backup puisqu\'il n\'est pas disponible au téléchargement. Supprimer les backups après téléchargement est fortement recommandé.',
	'backup' => 'Backup',
	'backup menu' => 'Backup Menu',
	'last backup' => 'Dernier backup a été créé sur',
	'no backups' => 'il n\'y a pas de backups à télécharger',
	'user ws config option name always show unread mail in dashboard' => 'Toujours afficher les courriels non lus dans le tableau de bord',
	'user ws config option desc always show unread mail in dashboard' => 'Choisir Non dans le contexte en cours implique que les courriels non lus seront affichés.',
	'workspace emails' => 'Courriels de contexte',
	'user ws config option name tasksShowWorkspaces' => 'Voir contextes',
	'user ws config option name tasksShowTime' => 'Voir heures',
	'user ws config option name tasksShowDates' => 'Voir dates',
	'user ws config option name tasksShowTags' => 'Voir étiquettes',
	'user ws config option name tasksGroupBy' => 'Groupé par',
	'user ws config option name tasksOrderBy' => 'Trié par',
	'user ws config option name task panel status' => 'Statuts',
	'user ws config option name task panel filter' => 'Filtré par',
	'user ws config option name task panel filter value' => 'Valeur de Filtre',
	'config option name days_on_trash' => 'Jours dans la corbeille',
	'config option name time_format_use_24' => 'Utiliser un format 24 heures pour les descriptions',
	'config option name work_day_start_time' => 'Début du jour de travail',
	'templates' => 'Modèles',
	'add template' => 'Ajouter des modèles',
	'no templates' => 'Il n\'y a pas de modèles',
	'template name required' => 'Le nom du modèle est requis',
	'new template' => 'Nouveau modèle',
	'edit template' => 'Éditer le modèle',
	'template dnx' => 'Le modèle n\'existe pas',
	'success edit template' => 'Le modèle a bien été modifié',
	'log add cotemplates' => '{0} ajouté',
	'can manage templates' => 'Peut gérer les modèles',
	'log edit cotemplates' => '{0} modifié',
	'objects' => 'Objets',
	'objects in template' => 'Objets dans le modèle',
	'no objects in template' => 'Il n\'y a pas d\'objets dans ce modèle',
	'add to a template' => 'Ajouter à un modèle',
	'success delete template' => 'Le modèle a bien été supprimé',
	'error delete template' => 'Erreur de suppression du modèle',
	'assign template to workspace' => 'Affecter le modèle au contexte',
	'config option desc work_day_start_time' => 'Définir l\'heure pour laquelle le jour de travail commence',
	'confirm delete template' => 'Êtes-vous sûr de vouloir supprimer ce modèle ?',
	'add an object to template' => 'Ajouter un objet à ce modèle',
	'success add object to template' => 'Objet bien ajouté au modèle',
	'object type not supported' => 'Ce type d\'objet n\'est pas supporté par le modèle',
	'config option desc days_on_trash' => 'Combien de jours un contenu est conservé dans la corbeille avant d\'être automatiquement supprimé. Si c\'est 0, les objets ne seront pas supprimés de la corbeille.',
	'config option desc time_format_use_24' => 'Si la description du temps est activée, elle sera vue comme \'hh:mm\' de 00:00 à 23:59, et sinon, les heures iront de 1 à 12 en utilisant AM ou PM.',
	'you are adding object to template' => 'Vous avez ajouté {0} \'{1}\' à un modèle. Choisir un modèle ci-dessous ou créez-en un nouveau pour ce {0}.',
	'config option name enable_email_module' => 'Activer le module de courriel',
	'config option desc enable_email_module' => 'Déterminer quand l\'onglet courriel sera disponible dans OpenGoo.',
	'config category name modules' => 'Modules',
	'config option name enable_notes_module' => 'Activer le module Notes',
	'config option name enable_contacts_module' => 'Activer le module Contacts',
	'config option name enable_calendar_module' => 'Activer le module Calendrier',
	'config option name enable_documents_module' => 'Activer le module Documents',
	'config option name enable_tasks_module' => 'Activer le module Tâches',
	'config option name enable_weblinks_module' => 'Activer le module Liens Web',
	'config option name enable_time_module' => 'Activer le module Temps',
	'config option name enable_reporting_module' => 'Activer le module Reporting',
	'user ws config category name general' => 'Général',
	'user ws config option name localization' => 'Localisation',
	'user ws config option name initialWorkspace' => 'Contexte initial',
	'cron event name create_backup' => 'Créer une sauvegarde',
	'next execution' => 'Exécution suivante',
	'delay between executions' => 'Délais entre exécutions',
	'enabled' => 'activé',
	'automatic upgrade' => 'Mise à Jour automatique',
	'start automatic upgrade' => 'Démarrer la Mise à Jour automatique',
	'config category desc modules' => 'Utiliser ces paramètres pour activer ou désactiver les modules d\'OpenGoo. Désactiver un module le chachera seulement de l\'interface graphique sans affecter les permissions aux utilisateurs pour créer ou éditer des contenus.',
	'user ws config option name time_format_use_24' => 'Utiliser un format 24 heures pour la description du temps',
	'cron events' => 'Évènements programmés ',
	'about cron events' => 'A propos des évènements programmés',
	'cron events info' => 'Les évènements programmés vous permette d\'exécuter des tâches dans OpenGoo périodiquement sans être connecté au système. Pour activer des évènements programmés, vous devez configurer un travail Cron (du grec Chronos) qui exécute périodiquement le fichier "cron.php" situé à la racine d\'OpenGoo. La périodicité à laquelle un travail cron déterminera le moment ou les évènements programmés seront exécutés. Par exemple, si vous programmer le travail cron pour tourner toutes les 5 minutes, et vous configurer un évènement programmé pour gérer des mises-à-jours chaque minute, évidemment les mises-à-jours se feront toutes les 5 minutes. Pour en savoir plus sur les travaux cron, demandez-nous des exemples sur le forum d\'OpenGoo.',
	'cron event name check_mail' => 'Vérifier les courriels',
	'cron event desc check_mail' => 'Cet évènement programmé vérifiera les nouveaux courriels dans tous les comptes courriels du système.',
	'cron event name purge_trash' => 'Vider la corbeille',
	'cron event desc send_reminders' => 'Cet évènement programmé enverra des rappels par courriel.',
	'cron event name check_upgrade' => 'Vérifier les mises-à-jour.',
	'success update cron events' => 'Évènements programmés bien modifiés ',
	'manual upgrade' => 'Mise-à-jour manuelle',
	'cron event name send_reminders' => 'Envoi de rappels',
	'cron event desc check_upgrade' => 'Cet évènement programmé vérifiera de nouvelles versions d\'OpenGoo.',
	'no cron events to display' => 'Il n\'y a pas d\'évènements programmés à afficher',
	'user ws config option name rememberGUIState' => 'Se souvenir de l\'état de l\'interface utilisateur',
	'user ws config option name work_day_start_time' => 'Début de la journée de travail',
	'user ws config option desc work_day_start_time' => 'Détermine l\'heure du début de la journée de travail',
	'cron event desc purge_trash' => 'Cet évènement programmé effacera des objets plus vieux du nombre de jours défini par le paramètre \'Jours dans la corbeille\'.',
	'cron event desc create_backup' => 'Créer une sauvegarde récupérable dans la section Backup du panneau d\'administration.',
	'user ws config option desc localization' => 'Les libellés et les dates seront affichées en fonction de ce paramètre local. Nécessite un rafraichissement. ',
	'user ws config option desc initialWorkspace' => 'Ce paramètre permet de choisir quel contexte sera sélectionné lors de la connexion, ou vous pouvez choisir de se souvenir du dernier contexte visualisé.',
	'user ws config option desc time_format_use_24' => 'Si actif, la description des heures seront affichées comme \'hh:mm\' de 00:00 à 23:59, et sinon, les heures seront de 1 à 12 en utilisant AM (Ante Meridiem) ou PM (Post Meridiem).',
	'automatic upgrade desc' => 'Cette mise-à-jour automatique sera téléchargée et la nouvelle version extraire automatiquement, et déroulera la procédure de mise-à-jour. Le serveur web doit avoir des droits d\'accès en écriture pour tous les dossiers.',
	'manual upgrade desc' => 'Pour mettre à jour OpenGoo vous devez télécharger une nouvelle version, l\'extraire à la racine de votre répertoire d\'installation et aller à <a href="public/upgrade">\'public/upgrade\'</a> dans votre navigateur pour dérouler la procédure de mise-à-jour.',
	'user ws config option desc rememberGUIState' => 'Cela permet d\'enregistrer l\'état de l\'interface graphique (taille des panneaux, état plié/déplié, etc...) pour la prochaine connexion. Attention : cette fonctionnalité est encore en version BETA.',
); ?>
