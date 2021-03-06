INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES
	('test_mail_settings', 'administration', 'tool_test_email', 1),
	('mass_mailer', 'administration', 'tool_mass_mailer', 2);

INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES
	('system', 1, 0),
	('general', 0, 1),
	('mailing', 0, 2),
	('modules', 0, 3);

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
	('system', 'project_logs_per_page', '10', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'messages_per_page', '5', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'max_avatar_width', '50', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'max_avatar_height', '50', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'logs_per_project', '5', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'max_logo_width', '50', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'max_logo_height', '50', 'IntegerConfigHandler', 1, 0, NULL),
	('system', 'files_per_page', '50', 'IntegerConfigHandler', 1, 0, NULL),
	('general', 'upgrade_last_check_datetime', '2006-09-02 13:46:47', 'DateTimeConfigHandler', 1, 0, 'Date and time of the last upgrade check'),
	('general', 'upgrade_last_check_new_version', '0', 'BoolConfigHandler', 1, 0, 'True if system checked for the new version and found it. This value is used to hightligh upgrade tab in the administration'),
	('general', 'file_storage_adapter', 'fs', 'FileStorageConfigHandler', 0, 0, 'What storage adapter should be used? fs or mysql'),
	('general', 'theme', 'default', 'ThemeConfigHandler', 0, 0, NULL),
	('general', 'days_on_trash', '30', 'IntegerConfigHandler', 0, 0, 'Days before a file is deleted from trash. 0 = Not deleted'),
	('mailing', 'exchange_compatible', '0', 'BoolConfigHandler', 0, 0, NULL),
	('mailing', 'mail_transport', 'mail()', 'MailTransportConfigHandler', 0, 0, 'Values: ''mail()'' - try to emulate mail() function, ''smtp'' - use SMTP connection'),
	('mailing', 'smtp_server', '', 'StringConfigHandler', 0, 0, ''),
	('mailing', 'smtp_port', '25', 'IntegerConfigHandler', 0, 0, NULL),
	('mailing', 'smtp_authenticate', '0', 'BoolConfigHandler', 0, 0, 'Use SMTP authentication'),
	('mailing', 'smtp_username', '', 'StringConfigHandler', 0, 0, NULL),
	('mailing', 'smtp_password', '', 'PasswordConfigHandler', 0, 0, NULL),
	('mailing', 'smtp_secure_connection', 'no', 'SecureSmtpConnectionConfigHandler', 0, 0, 'Values: no, ssl, tls'),
	('modules', 'enable_notes_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable notes tab.'),
	('modules', 'enable_email_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable email tab.'),
	('modules', 'enable_contacts_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable contacts tab.'),
	('modules', 'enable_calendar_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable calendar tab.'),
	('modules', 'enable_documents_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable documents tab.'),
	('modules', 'enable_tasks_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable tasks tab.'),
	('modules', 'enable_weblinks_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable weblinks tab.'),
	('modules', 'enable_time_module', '1', 'BoolConfigHandler', 0, 0, 'Enable or disable time tab.'),
	('modules', 'enable_reporting_module', '0', 'BoolConfigHandler', 0, 0, 'Enable or disable reporting tab.');

INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES
	('zip', 'archive.png', 0, 0),
	('rar', 'archive.png', 0, 0),
	('bz', 'archive.png', 0, 0),
	('bz2', 'archive.png', 0, 0),
	('gz', 'archive.png', 0, 0),
	('ace', 'archive.png', 0, 0),
	('mp3', 'audio.png', 0, 0),
	('wma', 'audio.png', 0, 0),
	('ogg', 'audio.png', 0, 0),
	('doc', 'doc.png', 0, 0),
	('xls', 'xls.png', 0, 0),
	('gif', 'image.png', 0, 1),
	('jpg', 'image.png', 0, 1),
	('jpeg', 'image.png', 0, 1),
	('png', 'image.png', 0, 1),
	('mov', 'mov.png', 0, 0),
	('pdf', 'pdf.png', 0, 0),
	('psd', 'psd.png', 0, 0),
	('rm', 'rm.png', 0, 0),
	('svg', 'svg.png', 0, 0),
	('swf', 'swf.png', 0, 0),
	('avi', 'video.png', 0, 0),
	('mpeg', 'video.png', 0, 0),
	('mpg', 'video.png', 0, 0),
	('qt', 'mov.png', 0, 0),
	('vob', 'video.png', 0, 0),
	('txt', 'doc.png', 1, 0),
	('ppt', 'ppt.png', 0, 0);

INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES
	('ICQ', 'icq.gif'),
	('AIM', 'aim.gif'),
	('MSN', 'msn.gif'),
	('Yahoo!', 'yahoo.gif'),
	('Skype', 'skype.gif'),
	('Jabber', 'jabber.gif');

INSERT INTO `<?php echo $table_prefix ?>user_ws_config_categories` (`name`, `is_system`, `type`, `category_order`) VALUES 
	('general', 0, 0, 0),
	('dashboard', 0, 0, 1),
	('task panel', 0, 0, 2),
	('time panel', 1, 0, 3),
	('calendar panel', 1, 0, 4);

INSERT INTO `<?php echo $table_prefix ?>user_ws_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES 
 ('dashboard', 'show calendar widget', '1', 'BoolConfigHandler', 0, 80, ''),
 ('dashboard', 'show late tasks and milestones widget', '1', 'BoolConfigHandler', 0, 100, ''),
 ('dashboard', 'show pending tasks widget', '1', 'BoolConfigHandler', 0, 200, ''),
 ('dashboard', 'pending tasks widget assigned to filter', '0:0', 'UserCompanyConfigHandler', 0, 210, ''),
 ('dashboard', 'show emails widget', '1', 'BoolConfigHandler', 0, 300, ''),
 ('dashboard', 'show messages widget', '1', 'BoolConfigHandler', 0, 400, ''),
 ('dashboard', 'show documents widget', '1', 'BoolConfigHandler', 0, 500, ''),
 ('dashboard', 'show charts widget', '1', 'BoolConfigHandler', 0, 600, ''),
 ('dashboard', 'show tasks in progress widget', '1', 'BoolConfigHandler', 0, 700, ''),
 ('dashboard', 'show comments widget', '1', 'BoolConfigHandler', 0, 800, ''),
 ('dashboard', 'show dashboard info widget', '1', 'BoolConfigHandler', 0, 900, ''),
 ('dashboard', 'always show unread mail in dashboard', '0', 'BoolConfigHandler', 0, 10, 'when false, active workspace email is shown'),
 ('dashboard', 'calendar_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'emails_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'messages_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'active_tasks_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'pending_tasks_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'late_tasks_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'comments_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'documents_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'charts_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('dashboard', 'dashboard_info_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('task panel', 'can notify from quick add', '1', 'BoolConfigHandler', 0, 0, 'Notification checkbox default value'),
 ('task panel', 'tasksShowWorkspaces', '1', 'BoolConfigHandler', 1, 0, ''),
 ('task panel', 'tasksShowTime', '1', 'BoolConfigHandler', 1, 0, ''),
 ('task panel', 'tasksShowDates', '1', 'BoolConfigHandler', 1, 0, ''),
 ('task panel', 'tasksShowTags', '1', 'BoolConfigHandler', 1, 0, ''),
 ('task panel', 'tasksGroupBy', 'milestone', 'StringConfigHandler', 1, 0, ''),
 ('task panel', 'tasksOrderBy', 'priority', 'StringConfigHandler', 1, 0, ''),
 ('task panel', 'task panel status', '1', 'IntegerConfigHandler', 1, 0, ''),
 ('task panel', 'task panel filter', 'assigned_to', 'StringConfigHandler', 1, 0, ''),
 ('task panel', 'task panel filter value', '0:0', 'UserCompanyConfigHandler', 1, 0, ''),
 ('time panel', 'TM show time type', '0', 'IntegerConfigHandler', 1, 0, ''),
 ('time panel', 'TM report show time type', '0', 'IntegerConfigHandler', 1, 0, ''),
 ('time panel', 'TM user filter', '0', 'IntegerConfigHandler', 1, 0, ''),
 ('time panel', 'TM tasks user filter', '0', 'IntegerConfigHandler', 1, 0, ''),
 ('general', 'localization', 'en_us', 'LocalizationConfigHandler', 0, 100, ''),
 ('general', 'initialWorkspace', '0', 'InitialWorkspaceConfigHandler', 0, 200, ''),
 ('general', 'lastAccessedWorkspace', '0', 'IntegerConfigHandler', 1, 0, ''),
 ('general', 'rememberGUIState', '0', 'BoolConfigHandler', 0, 300, ''),
 ('general', 'work_day_start_time', '9:00', 'TimeConfigHandler', 0, 400, 'Work day start time'),
 ('general', 'time_format_use_24', '0', 'BoolConfigHandler', 0, 500, 'Use 24 hours time format'),
 ('calendar panel', 'calendar view type', 'viewweek', 'StringConfigHandler', 1, 0, ''),
 ('calendar panel', 'calendar user filter', '0', 'IntegerConfigHandler', 1, 0, ''),
 ('calendar panel', 'calendar status filter', '', 'StringConfigHandler', 1, 0, '');


INSERT INTO `<?php echo $table_prefix ?>cron_events` (`name`, `recursive`, `delay`, `is_system`, `enabled`, `date`) VALUES
	('check_mail', '1', '10', '0', '1', '0000-00-00 00:00:00'),
	('purge_trash', '1', '1440', '1', '1', '0000-00-00 00:00:00'),
	('check_upgrade', '1', '1440', '0', '1', '0000-00-00 00:00:00'), 
	('send_reminders', '1', '10', '0', '1', '0000-00-00 00:00:00');

-- GelSheet
INSERT INTO `<?php echo $table_prefix ?>gs_fonts` VALUES
	(1, 'Arial'),
	(2, 'Times New Roman'),
	(3, 'Verdana'),
	(4, 'Courier'),
	(5, 'Lucida Sans Console'),
	(6, 'Tahoma');
	
INSERT INTO `<?php echo $table_prefix ?>gs_users` VALUES  (1, 'Open', 'Goo', 'open', 'goo', 1);

INSERT INTO `<?php echo $table_prefix ?>object_reminder_types` (`name`) VALUES
  ('reminder_email'),
  ('reminder_popup');