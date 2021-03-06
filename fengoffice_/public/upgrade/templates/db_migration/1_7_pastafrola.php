-- <?php echo $table_prefix ?> og_
-- <?php echo $default_charset ?> DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
-- <?php echo $default_collation ?> collate utf8_unicode_ci
-- <?php echo $engine ?> InnoDB

INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES
	('slim', 'ppt.png', 1, 0),
	('html', 'html.png', 1, 0),
	('webfile', 'webfile.png', 0, 0);

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
	('system', 'notification_from_address', '', 'StringConfigHandler', 1, 0, 'Address to use as from field in email notifications. If empty, users address is used'),
	('general', 'use_owner_company_logo_at_header', '0', 'BoolConfigHandler', '0', '0', NULL)
ON DUPLICATE KEY UPDATE id=id;

DELETE FROM `<?php echo $table_prefix ?>config_options` WHERE `category_name`='general' AND `name`='detect_mime_type_from_extension';

ALTER TABLE `<?php echo $table_prefix ?>administration_tools` ADD COLUMN `visible` BOOLEAN NOT NULL DEFAULT 1;
UPDATE `<?php echo $table_prefix ?>administration_tools` SET `visible`=0 WHERE `name`='mass_mailer';

ALTER TABLE `<?php echo $table_prefix ?>project_milestones`
 ADD COLUMN `is_urgent` BOOLEAN NOT NULL default '0';
 
ALTER TABLE `<?php echo $table_prefix ?>application_logs` MODIFY COLUMN `action` enum('upload','open','close','delete','edit','add','trash','untrash','subscribe','unsubscribe','tag','untag','comment','link','unlink','login','logout','archive','unarchive','move','copy','read','download') <?php echo $default_collation ?> default NULL;

INSERT INTO `<?php echo $table_prefix ?>user_ws_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES 
 ('dashboard', 'show activity widget', '1', 'BoolConfigHandler', 0, 1000, ''),
 ('dashboard', 'activity widget elements', '30', 'IntegerConfigHandler', '0', '1100', NULL),
 ('dashboard', 'workspace_description_widget_expanded', '1', 'BoolConfigHandler', 1, 0, ''),
 ('general', 'detect_mime_type_from_extension', '0', 'BoolConfigHandler', 0, 800, '')
ON DUPLICATE KEY UPDATE id=id;

INSERT INTO `<?php echo $table_prefix ?>workspace_objects` (`workspace_id`, `object_manager`, `object_id`, `created_by_id`, `created_on`)
  SELECT `project_id` as `workspace_id`, 'Contacts' as `object_manager`, `contact_id` as `object_id`, 0 as `created_by_id`, NOW() as `created_on` FROM `<?php echo $table_prefix ?>project_contacts`
  ON DUPLICATE KEY UPDATE `workspace_id` = `workspace_id`;

DELETE FROM `<?php echo $table_prefix ?>project_contacts` WHERE `role` = '';

CREATE TABLE  `<?php echo $table_prefix ?>application_read_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `taken_by_id` int(10) NOT NULL default '0',
  `rel_object_id` int(10) NOT NULL default '0',
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `action` enum('read','download') <?php echo $default_collation ?> default NULL,
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `object_key` (`rel_object_id`, `rel_object_manager`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

CREATE TABLE  `<?php echo $table_prefix ?>administration_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(50) NOT NULL default '',
  `log_data` text NOT NULL,
  `category` enum('system','security') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `category` (`category`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;


CREATE TABLE  `<?php echo $table_prefix ?>mail_datas` (
  `id` int(10) unsigned NOT NULL,
  `to` text <?php echo $default_collation ?> NOT NULL,
  `cc` text <?php echo $default_collation ?> NOT NULL,
  `bcc` text <?php echo $default_collation ?> NOT NULL,
  `subject` text <?php echo $default_collation ?>,
  `content` text <?php echo $default_collation ?>,
  `body_plain` longtext <?php echo $default_collation ?>,
  `body_html` longtext <?php echo $default_collation ?>,
  PRIMARY KEY (`id`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>mail_datas` (`id`, `to`, `cc`, `bcc`, `subject`, `content`, `body_plain`, `body_html`)
  SELECT `id`, `to`, `cc`, `bcc`, `subject`, `content`, `body_plain`, `body_html` FROM `<?php echo $table_prefix ?>mail_contents`;

ALTER TABLE `<?php echo $table_prefix ?>mail_contents`
  DROP COLUMN `to`,
  DROP COLUMN `cc`,
  DROP COLUMN `bcc`,
  DROP COLUMN `content`,
  DROP COLUMN `body_plain`,
  DROP COLUMN `body_html`;
ALTER TABLE `<?php echo $table_prefix ?>mail_contents`
  MODIFY COLUMN `subject` varchar(255) <?php echo $default_collation ?> NOT NULL default '';

ALTER TABLE `<?php echo $table_prefix ?>users`
  ADD COLUMN `type` varchar(10) <?php echo $default_collation ?> default NULL DEFAULT 'normal';

UPDATE `<?php echo $table_prefix ?>users` SET `type` = 'admin' WHERE `id` IN (SELECT `user_id` FROM `<?php echo $table_prefix ?>group_users` WHERE `group_id` = 10000000);

UPDATE `<?php echo $table_prefix?>user_ws_config_options` SET `config_handler_class` = 'DateFormatConfigHandler' WHERE `name` = 'date_format';
