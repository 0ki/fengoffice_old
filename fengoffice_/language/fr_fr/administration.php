<?php return array(
	'administration tool name test_mail_settings' => 'Paramètres du courriel de test',
	'administration tool desc test_mail_settings' => 'Utilisez cet outil pour envoyer un courriel de test, et vérifier que OpenGoo est bien configuré.',
	'administration tool name mass_mailer' => 'Outil de Mass mailing',
	'administration tool desc mass_mailer' => 'Utilisez cet outil pour envoyer des messages aux groupes d\'utilisateurs enregistrés.',
	'configuration' => 'Configuration',
	'mail transport mail()' => 'Paramètres PHP par défaut',
	'mail transport smtp' => 'Serveur SMTP',
	'secure smtp connection no' => 'Non',
	'secure smtp connection ssl' => 'Oui, utiliser SSL',
	'secure smtp connection tls' => 'Oui, utiliser TLS',
	'file storage file system' => 'Système de fichiers',
	'file storage mysql' => 'Base de données (MySQL)',
	'config category name general' => 'Général',
	'config category desc general' => 'Paramètres principaux d\'OpenGoo.',
	'config category name mailing' => 'Courriel',
	'config category desc mailing' => 'Utilisez ces paramètre pour piloter OpenGoo dans sa façon d\'envoyer les courriels. Vous pouvez utiliser les options de configuration fournies dans votre php.ini ou utiliser celles-ci pour paramétrer d\'autres serveurs SMTP.',
	'config option name site_name' => 'Nom du site',
	'config option desc site_name' => 'Cette valeur s\'affichera sur la page du tableau de bord',
	'config option name file_storage_adapter' => 'Dossier d\'enregistrement des fichiers ',
	'config option desc file_storage_adapter' => 'Sélectionnez où seront stockés les documents chargés. <strong>Changer de dossier rendra les fichiers chargés précédemment indisponible</strong>.',
	'config option name default_project_folders' => 'Dossiers par Défaut',
	'config option desc default_project_folders' => 'Les dossiers qui seront créés en même temps que le contexte. Chaque nom de dossier doit figurer sur une nouvelle ligne. Les lignes en double ou vides seront ignorées',
	'config option name theme' => 'Thème ',
	'config option desc theme' => 'Utilisez les thèmes pour change l\'apparence d\'OpenGoo',
	'config option name upgrade_check_enabled' => 'Activer la vérification de mise à jour',
	'config option desc upgrade_check_enabled' => 'Si oui, le système vérifiera chaque jour s\'il existe une nouvelle version d\'OpenGoo à télécharger',
	'config option name exchange_compatible' => 'Mode compatibilité pour Microsoft Exchange ',
	'config option desc exchange_compatible' => 'Si vous utilisez Microsoft Exchange Server cochez cette option pour éviter des problèmes connus.',
	'config option name mail_transport' => 'Transport du courriel ',
	'config option desc mail_transport' => 'Vous pouvez utiliser les valeurs PHP par défaut pour envoyer des courriels ou spécifier le serveur SMTP',
	'config option name smtp_server' => 'Serveur SMTP ',
	'config option name smtp_port' => 'Port SMTP ',
	'config option name smtp_authenticate' => 'Utiliser l\'authentification SMTP ',
	'config option name smtp_username' => 'Nom d\'utilisateur SMTP ',
	'config option name smtp_password' => 'Mot de passe SMTP ',
	'config option name smtp_secure_connection' => 'Utiliser une connexion SMTP sécurisée ',
	'can edit company data' => 'Peut éditer les données de la société',
	'can manage security' => 'Peut gérer la sécurité',
	'can manage workspaces' => 'Peut gérer les contextes',
	'can manage configuration' => 'Peut gérer la configuration',
	'can manage contacts' => 'Peut gérer les contacts',
	'group users' => 'Utilisateurs du groupe',
	'user ws config category name dashboard' => 'Options du tableau de bord',
	'user ws config category name task panel' => 'Options des tâches',
	'user ws config option name show pending tasks widget' => 'Afficher le widget des tâches en attente ',
	'user ws config option name pending tasks widget assigned to filter' => 'Afficher le widget des tâches affectées à ',
	'user ws config option name show late tasks and milestones widget' => 'Afficher le widget des tâches et jalons en retard ',
	'user ws config option name show messages widget' => 'Afficher le widget de notes ',
	'user ws config option name show comments widget' => 'Afficher le widget de commentaires ',
	'user ws config option name show documents widget' => 'Afficher le widget de documents ',
	'user ws config option name show calendar widget' => 'Afficher le widget du mini calendrier ',
	'user ws config option name show charts widget' => 'Afficher le widget des graphiques ',
	'user ws config option name show emails widget' => 'Afficher le widget des courriels ',
	'user ws config option name my tasks is default view' => 'Tâches qui me sont affectées comme vue par défaut ',
	'user ws config option desc my tasks is default view' => 'Si \'Non\' est sélectionné, la vue par défaut du panneau des tâches affichera toutes les tâches',
	'user ws config option name show tasks in progress widget' => 'Afficher le widget des tâches en cours ',
	'user ws config option desc can notify from quick add' => 'Case à cocher pour notifier aux utilisateurs affectés les ajouts express sur les tâches',
	'backup process desc' => 'Effectuer une sauvegarde permet d\'enregistrer l\'état en cours de la totalité de l\'application dans un dossier compressé.<br /> La sauvegarde du système et de sa base de données ne prend que quelques secondes. <br /><br />Le processus de sauvegarde se déroule en trois étapes : <br />1 - Lancer le processus de sauvegarde , <br />2 - Télécharger la sauvegarde. <br /> 3 - En Option, une sauvegarde peut être détruite manuellement, pour ne plus être disponible dans le futur. <br />',
	'start backup' => 'Lancement du processus de sauvegarde',
	'start backup desc' => 'Lancer un processus de sauvegarde implique de supprimer les sauvegardes précédentes avant d\'en générer une nouvelle.',
	'download backup' => 'Télécharger une sauvegarde',
	'download backup desc' => 'Pour télécharger une sauvegarde, vous devez en premier lieu en générer une.',
	'delete backup' => 'Supprimer la sauvegarde',
	'delete backup desc' => 'Supprime la dernière sauvegarde et la rendre indisponible au téléchargement. <br />La suppression des sauvegardes après téléchargement est fortement recommandé.',
	'backup' => 'Sauvegarde',
	'backup menu' => 'Menu de sauvegarde',
	'last backup' => 'Dernière sauvegarde créée le',
	'no backups' => 'Il n\'y a pas de sauvegarde à télécharger',
	'user ws config option name always show unread mail in dashboard' => 'Toujours afficher les courriels non lus dans le tableau de bord ',
	'user ws config option desc always show unread mail in dashboard' => 'Choisir \'Non\' dans le contexte actuel implique que les courriels non lus seront affichés.',
	'workspace emails' => 'Courriels du contexte',
	'user ws config option name tasksShowWorkspaces' => 'Afficher les contextes',
	'user ws config option name tasksShowTime' => 'Afficher les heures',
	'user ws config option name tasksShowDates' => 'Afficher les dates',
	'user ws config option name tasksShowTags' => 'Afficher les étiquettes',
	'user ws config option name tasksGroupBy' => 'Regroupé par',
	'user ws config option name tasksOrderBy' => 'Trié par',
	'user ws config option name task panel status' => 'Statuts',
	'user ws config option name task panel filter' => 'Filtré par',
	'user ws config option name task panel filter value' => 'Valeur de Filtre',
	'config option name days_on_trash' => 'Nombre de jours dans la corbeille ',
	'config option name time_format_use_24' => 'Utiliser un format 24 heures pour les descriptions',
	'config option name work_day_start_time' => 'Début de la journée de travail',
	'templates' => 'Modèles',
	'add template' => 'Ajouter un modèle',
	'no templates' => 'Il n\'y a pas de modèles à afficher.',
	'template name required' => 'Le nom du modèle est requis',
	'new template' => 'Nouveau modèle',
	'edit template' => 'Éditer le modèle',
	'template dnx' => 'Le modèle n\'existe pas',
	'success edit template' => 'Le modèle a été modifié',
	'log add cotemplates' => '{0} ajouté',
	'can manage templates' => 'Peut gérer les modèles',
	'log edit cotemplates' => '{0} modifié',
	'objects' => 'Objets',
	'objects in template' => 'Objets dans le modèle',
	'no objects in template' => 'Il n\'y a pas d\'objets dans ce modèle',
	'add to a template' => 'Ajouter à un modèle',
	'success delete template' => 'Le modèle a été supprimé',
	'error delete template' => 'Erreur de suppression du modèle',
	'assign template to workspace' => 'Affecter le modèle au contexte',
	'config option desc work_day_start_time' => 'Définir l\'heure à laquelle commence la journée de travail',
	'confirm delete template' => 'Êtes-vous certain de vouloir supprimer ce modèle ?',
	'add an object to template' => 'Ajouter un objet à ce modèle',
	'success add object to template' => 'Objet ajouté au modèle',
	'object type not supported' => 'Ce type d\'objet n\'est pas supporté par le modèle',
	'config option desc days_on_trash' => 'Combien de jours un contenu est conservé dans la corbeille avant d\'être automatiquement supprimé. Spécifiez 0 pour ne pas supprimer automatiquement les objets de la corbeille.',
	'config option desc time_format_use_24' => 'Si la description du temps est activée, elle sera vue comme \'hh:mm\' de 00:00 à 23:59, et sinon, les heures iront de 1 à 12 en utilisant AM ou PM.',
	'you are adding object to template' => 'Vous avez ajouté {0} \'{1}\' à un modèle. Choisissez un modèle ci-dessous ou créez-en un nouveau pour ce(tte) {0}.',
	'config option name enable_email_module' => 'Activer le module \'Courriel\' ',
	'config option desc enable_email_module' => 'Détermine si l\'onglet \'Courriel\' est activé dans OpenGoo.',
	'config category name modules' => 'Modules',
	'config option name enable_notes_module' => 'Activer le module \'Notes\' ',
	'config option name enable_contacts_module' => 'Activer le module \'Contacts\' ',
	'config option name enable_calendar_module' => 'Activer le module \'Calendrier\' ',
	'config option name enable_documents_module' => 'Activer le module \'Documents\' ',
	'config option name enable_tasks_module' => 'Activer le module \'Tâches\' ',
	'config option name enable_weblinks_module' => 'Activer le module \'Liens Web\' ',
	'config option name enable_time_module' => 'Activer le module \'Temps\' ',
	'config option name enable_reporting_module' => 'Activer le module \'Rapports\' ',
	'user ws config category name general' => 'Général',
	'user ws config option name localization' => 'Localisation ',
	'user ws config option name initialWorkspace' => 'Contexte initial ',
	'cron event name create_backup' => 'Effectuer une sauvegarde',
	'next execution' => 'Prochaine exécution',
	'delay between executions' => 'Intervalle d\'exécution',
	'enabled' => 'activé',
	'automatic upgrade' => 'Mise à Jour automatique',
	'start automatic upgrade' => 'Démarrer la Mise à Jour automatique',
	'config category desc modules' => 'Utilisez ces paramètres pour activer ou désactiver les modules d\'OpenGoo. Désactiver un module le retirera seulement de l\'interface graphique sans affecter les permissions aux utilisateurs pour créer ou éditer des contenus.',
	'user ws config option name time_format_use_24' => 'Utiliser un format 24 heures pour la description du temps ',
	'cron events' => 'Évènements programmés ',
	'about cron events' => 'A propos des évènements programmés',
	'cron events info' => 'Les évènements programmés vous permettent d\'exécuter périodiquement des tâches dans OpenGoo sans être connecté au système. Pour activer des évènements programmés, vous devez configurer une tâche cron qui exécute périodiquement le fichier "cron.php" situé à la racine d\'OpenGoo. La périodicité à laquelle une tâche cron s\'exécute détermine le moment ou les évènements programmés seront exécutés. Par exemple, si vous programmez l\'exécution d\'une tâche cron toutes les 5 minutes, et que vous configurez un évènement programmé pour gérer des mises à jour chaque minute, les mises à jour se feront toutes les 5 minutes seulement. Demandez à votre administrateur système ou à votre hébergeur pour aller plus loin avec les tâches cron (Vous pouvez aussi demander des exemples sur le forum d\'OpenGoo).',
	'cron event name check_mail' => 'Relever les courriels',
	'cron event desc check_mail' => 'Cet évènement programmé relèvera les nouveaux messages de tous les comptes de messagerie du système.',
	'cron event name purge_trash' => 'Vider la corbeille',
	'cron event desc send_reminders' => 'Cet évènement programmé enverra des rappels par courriel.',
	'cron event name check_upgrade' => 'Vérifier les mises à jour',
	'success update cron events' => 'Évènements programmés modifiés ',
	'manual upgrade' => 'Mise-à-jour manuelle',
	'cron event name send_reminders' => 'Envoi de rappels',
	'cron event desc check_upgrade' => 'Cet évènement programmé vérifiera la disponibilité de nouvelles versions d\'OpenGoo.',
	'no cron events to display' => 'Il n\'y a pas d\'évènements programmés à afficher',
	'user ws config option name rememberGUIState' => 'Se souvenir de l\'état de l\'interface utilisateur ',
	'user ws config option name work_day_start_time' => 'Début de la journée de travail ',
	'user ws config option desc work_day_start_time' => 'Détermine l\'heure de début de la journée de travail',
	'cron event desc purge_trash' => 'Cet évènement programmé effacera des objets plus anciens que le nombre de jours défini par le paramètre \'Nombre de jours dans la corbeille\'.',
	'cron event desc create_backup' => 'Effectuer une sauvegarde récupérable dans la section \'Sauvegarde\' du panneau d\'administration.',
	'user ws config option desc localization' => 'Les libellés et les dates seront affichées en fonction de ce paramètre local. Nécessite un rafraichissement. ',
	'user ws config option desc initialWorkspace' => 'Ce paramètre permet de choisir quel contexte sera sélectionné lors de la connexion, ou vous pouvez choisir de se souvenir du dernier contexte visualisé.',
	'user ws config option desc time_format_use_24' => 'Si actif, les heures seront affichées comme \'hh:mm\' de 00:00 à 23:59, et sinon, les heures seront affichées de 1 à 12 en utilisant AM (Ante Meridiem) ou PM (Post Meridiem).',
	'automatic upgrade desc' => 'La mise à jour automatique permet de télécharger la nouvelle version, de l\'extraire automatiquement de lancer la procédure de mise à jour . Le serveur web doit avoir des droits d\'accès en écriture pour tous les dossiers.',
	'manual upgrade desc' => 'Pour mettre à jour OpenGoo vous devez télécharger une nouvelle version, l\'extraire à la racine de votre répertoire d\'installation et aller à <a href="public/upgrade">\'public/upgrade\'</a> dans votre navigateur pour lancer la procédure de mise à jour.',
	'user ws config option desc rememberGUIState' => 'Cela permet d\'enregistrer l\'état de l\'interface graphique (taille des panneaux, état plié/déplié, etc...) pour la prochaine connexion. Attention : cette fonctionnalité est encore en version BETA.',
	'config option name use_minified_resources' => 'Utiliser les ressources compressées',
	'config option desc use_minified_resources' => 'Utilise des ressources Javascript et CSS compressées pour accroitre les performances. Vous devez recompresser JS et CSS si vous les modifiez en utilisant l\'outils minify.php dans public/tools.',
	'user ws config option name can notify from quick add' => 'La notification des tâches est activée par défaut ',
	'config category name passwords' => 'Mots de passe',
	'config category desc passwords' => 'Modifiez ces paramètres pour changer les options de mot-de-passe.',
	'config option name checkout_notification_dialog' => 'Message de notification de nouvelles versions des documents ',
	'config option desc checkout_notification_dialog' => 'Si activé, l\'utilisateur devra choisir entre éditer ou lire le fichier téléchargé.',
	'config option name file_revision_comments_required' => 'Commentaires obligatoires sur les révisions de fichiers ',
	'config option name currency_code' => 'Devise ',
	'config option desc currency_code' => 'Symbole monétaire',
	'config option name min_password_length' => 'Longueur minimale du mot-de-passe ',
	'config option name password_metacharacters' => 'Méta-caractères pour le mot-de-passe ',
	'config option name password_expiration' => 'Expiration du mot-de-passe (en jours) ',
	'config option name validate_password_history' => 'Valider l\'historique des mots-de-passe ',
	'can manage reports' => 'Peut gérer les rapports',
	'user ws config category name calendar panel' => 'Options du calendrier',
	'user ws config option name show_tasks_context_help' => 'Afficher l\'aide contextuelle pour les tâches',
	'user ws config option name start_monday' => 'Démarrer la semaine le lundi ',
	'user ws config option name show_week_numbers' => 'Afficher les numéros de semaine ',
	'user ws config option name date_format' => 'Format de date ',
	'user ws config option name show_context_help' => 'Afficher l\'aide contextuelle ',
	'show context help always' => 'Toujours',
	'show context help never' => 'Jamais',
	'show context help until close' => 'Jusqu\'à sa fermeture',
	'backup config warning' => 'Attention : Votre configuration et les dossiers tmp ne seront pas sauvegardés.',
	'cron event name send_notifications_through_cron' => 'Envoyer une notification à travers \'Cron\'',
	'cron event name backup' => 'Sauvegarde OpenGoo',
	'select object type' => 'Choisissez un type d\'objet',
	'select one' => 'Choisir',
	'email type' => 'Courriel',
	'user ws config option name show getting started widget' => 'Afficher le widget de bienvenue ',
	'user ws config option desc start_monday' => 'Montrera le calendrier en commençant la semaine le lundi',
	'user ws config option name descriptive_date_format' => 'Description du format de date ',
	'config option desc min_password_length' => 'Nombre minimum de caractères requis pour le mot-de-passe',
	'config option name password_numbers' => 'Nombres dans le mot-de-passe ',
	'config option desc password_numbers' => 'Quantité de nombres requis dans le mot-de-passe',
	'config option name password_uppercase_characters' => 'Caractères majuscules dans le mot-de-passe ',
	'config option desc password_uppercase_characters' => 'Quantité de caractères majuscules requise dans le mot-de-passe',
	'config option name user_email_fetch_count' => 'Limite de récupération du courriel ',
	'config option desc password_metacharacters' => 'Nombre de méta-caractères requis pour le mot-de-passe (par ex.: ., $, *)',
	'config option desc password_expiration' => 'Nombre de jours pour lequel le nouveau mot-de-passe est valide (0 pour désactiver cette option)',
	'config option name password_expiration_notification' => 'Notification d\'expiration du mot-de-passe (jours avant) ',
	'config option desc password_expiration_notification' => 'Nombre de jours avant lequel alerter l\'utilisateur de l\'expiration de son mot-de-passe (0 pour désactiver cette option)',
	'user ws config option name show dashboard info widget' => 'Afficher le widget de description du contexte',
	'user ws config option desc show_tasks_context_help' => 'Si actif, un boite d\'aide contextuelle sera affichée dans le panneau des tâches',
	'user ws config option desc date_format' => 'Format de modèle à appliquer aux valeurs de date.',
	'custom properties updated' => 'Propriétés personnalisées mises à jour',
	'user ws config option name noOfTasks' => 'Définir le nombre de tâches affichées par défaut ',
	'config option name checkout_for_editing_online' => 'Verrouiller automatiquement lors de l\'édition en ligne ',
	'user ws config option desc show_week_numbers' => 'Affiche les numéros de semaine dans les vues mensuelles et quotidiennes.',
	'user ws config option desc descriptive_date_format' => 'Format de modèle à appliquer à la description des valeurs de date.',
	'config option desc file_revision_comments_required' => 'Si actif, l\'ajout de révisions de nouveau fichier impose de fournir un nouveau commentaire à chaque révision.',
	'config option name show_feed_links' => 'Montrer les liens d\'abonnement ',
	'config option name account_block' => 'Compte bloqué à l\'expiration du mot-de-passe ',
	'config option desc account_block' => 'Bloque le compte utilisateur lors de l\'expiration du mot-de-passe (nécessite des privilèges d\'administration pour réactiver le compte utilisateur)',
	'config option name new_password_char_difference' => 'Vérifier une différence de caractères avec le nouveau mot-de-passe selon l\'historique ',
	'config option desc new_password_char_difference' => 'Vérifier qu\'un nouveau mot-de-passe diffère au moins de 3 caractères par rapport aux dix derniers mots-de-passe utilisés par l\'utilisateur',
	'config option desc validate_password_history' => 'Vérifier qu\'un nouveau mot-de-passe ne correspond pas aux dix derniers utilisés par l\'utilisateur',
	'user ws config option desc show_context_help' => 'Choisir si vous voulez toujours voir l\'aide, ne jamais la voir ou la voir jusqu\'à ce que chaque boite soit fermée.',
	'config option desc show_feed_links' => 'Cela vous autorise à voir les liens RSS ou iCal pour l\'utilisateur connecté à travers le système, ainsi il peut y souscrire. ATTENTION : ces liens contiennent des informations qui peuvent connecter un utilisateur au système. Si un utilisateur indésirable partage un de ces liens il peut compromettre toutes ses informations.',
	'config option desc user_email_fetch_count' => 'Nombre de messages à récupérer quand l\'utilisateur clique sur le bouton "Relever les messages". Utiliser une valeur importante peut provoquer des erreurs de dépassement limite de temps. Utilisez 0 pour aucune limite. Notez que cela ne peut affecter la remontée des messages au travers du \'cron\' (programmateur d\'évènements).',
	'config option desc checkout_for_editing_online' => 'Quand un utilisateur édite un document en ligne, celui ci est automatiquement verrouillé. Ainsi personne ne peux l\'éditer en même temps',
	'cron event desc send_notifications_through_cron' => 'Si cet évènement est actif, la notification de courriel sera envoyé à travers le programmateur \'cron\' et non pas quand il est généré par OpenGoo.',
	'cron event desc backup' => 'Si cet évènement est actif, OpenGoo sera sauvegardé régulièrement. Le propriétaire de l\'installation pourra télécharger des sauvegardes grâce au panneau d\'administration. Les sauvegardes d\'OpenGoo sont conservées sous forme de fichier zip dans le répertoire \'tmp/backup\'',
	'autentify password title' => 'Authentification',
	'autentify password desc' => 'Vous devez vous authentifier pour accéder au panneau d\'administration.<br/> Rentrez votre mot de passe ',
	'config option name ask_administration_autentification' => 'Protéger la panneau d\'administration',
	'config option desc ask_administration_autentification' => 'Afficher une demande d\'authentification pour accéder la panneau d\'administration',
	'user ws config category name mails panel' => 'Options de messagerie',
	'user ws config option name view deleted accounts emails' => 'Afficher les messages des comptes de messagerie supprimés',
	'user ws config option desc view deleted accounts emails' => 'Vous permet d\'afficher les messages des comptes de messagerie supprimés (pour utiliser cette fonction,  quand vous supprimez votre compte, vous devez choisir de ne pas supprimer les messages)',
	'user ws config option name block_email_images' => 'Ne pas charger les images de l\'email',
	'user ws config option desc block_email_images' => 'Ne pas afficher les images contenues dans les messages',
	'user ws config option name draft_autosave_timeout' => 'Intervalle de sauvegarde des brouillons',
	'user ws config option desc draft_autosave_timeout' => 'Secondes entre chaque sauvegarde automatique des brouillons (0 pour désactiver la sauvegarde automatique)',
	'add a parameter to template' => 'Ajouter un paramètre pour ce modèle ',
	'parameters' => 'Paramètres',
	'user ws config option name amount_objects_to_show' => 'Nombre d\'objets liés à afficher',
	'user ws config option desc amount_objects_to_show' => 'Nombre d\'objets liés à afficher dans la vue de l\'objet',
	'user ws config option name show_two_weeks_calendar' => 'Afficher deux semaines dans le widget de calendrier',
	'user ws config option desc show_two_weeks_calendar' => 'Affiche deux semaines dans le widget de calendrier',
	'user ws config option name attach_docs_content' => 'Contenu des fichiers joints',
	'user ws config option desc attach_docs_content' => 'Si cette option est réglée sur "Oui", les fichiers joints seront ajoutés au message comme des pièces jointes ordinaires. Sur "Non", les fichiers seront ajoutés comme des liens.',
	'edit default user preferences' => 'Modifier les préférences utilisateur par défaut',
	'default user preferences' => 'Préférences utilisateur par défaut',
	'default user preferences desc' => 'Choisissez les valeurs par défaut des préférences utilisateur.
Ces valeurs ne s\'appliquent qu\'aux utilisateurs n\'ayant pas encore modifié leurs options. ',
); ?>
