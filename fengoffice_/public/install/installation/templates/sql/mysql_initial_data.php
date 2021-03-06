INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('test_mail_settings', 'administration', 'tool_test_email', 1);
INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('mass_mailer', 'administration', 'tool_mass_mailer', 2);

INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('system', 1, 0);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('general', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('mailing', 0, 2);

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'project_logs_per_page', '10', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'messages_per_page', '5', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_avatar_width', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_avatar_height', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'logs_per_project', '5', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_logo_width', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_logo_height', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'files_per_page', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'upgrade_last_check_datetime', '2006-09-02 13:46:47', 'DateTimeConfigHandler', 1, 0, 'Date and time of the last upgrade check');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'upgrade_last_check_new_version', '0', 'BoolConfigHandler', 1, 0, 'True if system checked for the new version and found it. This value is used to hightligh upgrade tab in the administration');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'upgrade_check_enabled', '1', 'BoolConfigHandler', 0, 0, 'Upgrade check enabled / dissabled');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'file_storage_adapter', 'fs', 'FileStorageConfigHandler', 0, 0, 'What storage adapter should be used? fs or mysql');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'theme', 'default', 'ThemeConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'exchange_compatible', '0', 'BoolConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'mail_transport', 'mail()', 'MailTransportConfigHandler', 0, 0, 'Values: ''mail()'' - try to emulate mail() function, ''smtp'' - use SMTP connection');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_server', '', 'StringConfigHandler', 0, 0, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_port', '25', 'IntegerConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_authenticate', '0', 'BoolConfigHandler', 0, 0, 'Use SMTP authentication');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_username', '', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_password', '', 'PasswordConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_secure_connection', 'no', 'SecureSmtpConnectionConfigHandler', 0, 0, 'Values: no, ssl, tls');

INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('zip', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('rar', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('bz', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('bz2', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('gz', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('ace', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mp3', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('wma', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('ogg', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('doc', 'doc.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('xsl', 'doc.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('gif', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('jpg', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('jpeg', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('png', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mov', 'mov.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('pdf', 'pdf.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('psd', 'psd.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('rm', 'rm.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('svg', 'svg.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('swf', 'swf.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('avi', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mpeg', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mpg', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('qt', 'mov.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('vob', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('txt', 'doc.png', 1, 0);

INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('ICQ', 'icq.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('AIM', 'aim.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('MSN', 'msn.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('Yahoo!', 'yahoo.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('Skype', 'skype.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('Jabber', 'jabber.gif');


-- 
-- Dumping data for table `cal_eventtypes`
-- 
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Birthday', 'Someone''s Birthday', 'F1EA74');
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Important', 'Something Important or Critical', 'FFAAAA');
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Boring', 'Boring Everyday Stuff', '999999');
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Holiday', 'A Holiday', 'A4CAE6');

-- 
-- Dumping data for table `user_ws_config_categories`
-- 
INSERT INTO `<?php echo $table_prefix ?>user_ws_config_categories` (`id`,`name`,`is_system`,`type`,`category_order`) VALUES  (1,'dashboard',0,0,0);
INSERT INTO `<?php echo $table_prefix ?>user_ws_config_categories` (`id`,`name`,`is_system`,`type`,`category_order`) VALUES  (2,'task panel',0,0,1);

-- 
-- Dumping data for table `user_ws_config_options`
-- 
INSERT INTO `<?php echo $table_prefix ?>user_ws_config_options` (`id`,`category_name`,`name`,`default_value`,`config_handler_class`,`is_system`,`option_order`,`dev_comment`) VALUES 
(1,'dashboard','show calendar widget','1','BoolConfigHandler',0,0,''),
 (2,'dashboard','show late tasks and milestones widget','1','BoolConfigHandler',0,100,''),
 (3,'dashboard','show pending tasks widget','1','BoolConfigHandler',0,200,''),
 (4,'dashboard','pending tasks widget assigned to filter','0:0','UserCompanyConfigHandler',0,210,''),
 (5,'dashboard','show emails widget','1','BoolConfigHandler',0,300,''),
 (6,'dashboard','show messages widget','1','BoolConfigHandler',0,400,''),
 (7,'dashboard','show documents widget','1','BoolConfigHandler',0,500,''),
 (8,'dashboard','show charts widget','1','BoolConfigHandler',0,600,''),
 (9,'task panel','my tasks is default view','1','BoolConfigHandler',0,0,'');
 

-- Milanga
INSERT INTO `<?php echo $table_prefix ?>user_ws_config_options` (`id`,`category_name`,`name`,`default_value`,`config_handler_class`,`is_system`,`option_order`,`dev_comment`) VALUES 
 (10,'dashboard','show tasks in progress widget','1','BoolConfigHandler',0,0,''),
 (11,'task panel','can notify from quick add','0','BoolConfigHandler',0,0,''),
 (12,'task panel','tasksShowWorkspaces','1','BoolConfigHandler',1,0,''),
 (13,'task panel','tasksShowTime','1','BoolConfigHandler',1,0,''),
 (14,'task panel','tasksShowDates','1','BoolConfigHandler',1,0,''),
 (15,'task panel','tasksShowTags','1','BoolConfigHandler',1,0,''),
 (16,'task panel','tasksGroupBy','milestone','StringConfigHandler',1,0,''),
 (17,'task panel','tasksOrderBy','priority','StringConfigHandler',1,0,''),
 (18,'task panel','task panel status','1','IntegerConfigHandler',1,0,''),
 (19,'task panel','task panel filter','assigned_to','StringConfigHandler',1,0,''),
 (20,'task panel','task panel filter value','0:0','UserCompanyConfigHandler',1,0,''),
 (21,'dashboard','show comments widget','1','BoolConfigHandler',0,0,''),
 (22,'dashboard','always show unread mail in dashboard','0','BoolConfigHandler',0,10,'when false, active workspace email is shown');
