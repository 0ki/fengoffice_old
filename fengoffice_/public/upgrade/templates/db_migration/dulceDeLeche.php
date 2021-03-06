-- <?php echo $table_prefix ?> og_
-- <?php echo $default_charset ?> DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
-- <?php echo $default_collation ?> collate utf8_unicode_ci

-- Create table file_permissions if it did not exist (for young Opengoo versions or ActiveCollab 0.7.1)
CREATE TABLE IF NOT EXISTS `<?php echo $table_prefix ?>file_permissions` (
  `file_id` INTEGER UNSIGNED NOT NULL,
  `user_id` INTEGER UNSIGNED NOT NULL,
  `permission` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(`file_id`, `user_id`)
) ENGINE = InnoDB <?php echo $default_charset ?>;

-- Rename attached files to linked objects
ALTER TABLE `<?php echo $table_prefix ?>attached_files` RENAME TO `<?php echo $table_prefix ?>linked_objects`,
 CHANGE COLUMN `file_id` `object_id` INTEGER UNSIGNED NOT NULL DEFAULT 0,
 ADD COLUMN `object_manager` VARCHAR(50) NOT NULL AFTER `created_by_id`,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY(`rel_object_manager`, `rel_object_id`, `object_id`, `object_manager`);
 UPDATE <?php echo $table_prefix ?>linked_objects SET object_manager='ProjectFiles';
 
 ALTER TABLE `<?php echo $table_prefix ?>projects`,
 ADD COLUMN `color` INTEGER UNSIGNED NOT NULL AFTER `updated_by_id` DEFAULT 0;
 
-- Create new task IDs for tasklists
SET @aa = (SELECT max(s.id) FROM <?php echo $table_prefix ?>project_tasks s);
-- Copy task lists to tasks
UPDATE <?php echo $table_prefix ?>project_task_lists o SET o.id = o.id + @aa;
-- Set parent for old tasks
UPDATE <?php echo $table_prefix ?>project_tasks o SET o.task_list_id = o.task_list_id + @aa;
-- Update application logs that used to be for task lists
UPDATE <?php echo $table_prefix ?>application_logs 
	SET rel_object_manager='ProjectTasks', rel_object_id=rel_object_id + @aa
	WHERE rel_object_manager='ProjectTaskLists';
-- Change tasks table structure
ALTER TABLE `<?php echo $table_prefix ?>project_tasks` CHANGE COLUMN `task_list_id` `parent_id` INTEGER UNSIGNED DEFAULT NULL;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks` ADD COLUMN `project_id` INTEGER UNSIGNED NOT NULL AFTER `parent_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `title` TEXT AFTER `project_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `started_on` DATETIME DEFAULT NULL AFTER `updated_by_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `started_by_id` INTEGER UNSIGNED DEFAULT NULL AFTER `started_on`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `milestone_id` INTEGER UNSIGNED AFTER `order`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `is_private` BOOLEAN NOT NULL default '0' AFTER `milestone_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `priority` INTEGER UNSIGNED AFTER `started_by_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD COLUMN `state` INTEGER UNSIGNED  AFTER `priority`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  MODIFY COLUMN `order` INTEGER UNSIGNED DEFAULT 0;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  DROP INDEX `task_list_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks`  ADD INDEX `parent_id`(`parent_id`);

-- Insert previous task lists
INSERT INTO `<?php echo $table_prefix ?>project_tasks` (`id`, `milestone_id`, `project_id`, `title`, `text`, `is_private`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) SELECT * from `<?php echo $table_prefix ?>project_task_lists`;
-- Delete task_list	 table
 DROP TABLE `<?php echo $table_prefix ?>project_task_lists` ;

-- Add object properties table
CREATE TABLE  `<?php echo $table_prefix ?>object_properties` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rel_object_id` int(10) unsigned NOT NULL,
  `rel_object_manager` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

-- Add Object Handins Table
CREATE TABLE  `<?php echo $table_prefix ?>object_handins` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` text,
  `text` text,
  `responsible_user_id` int(10) unsigned default NULL,
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `rel_object_manager` varchar(50) NOT NULL,
  `order` int(10) unsigned default '0',
  `completed_by_id` int(10) unsigned default NULL,
  `completed_on` datetime default NULL,
  `responsible_company_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

-- Rename file permissions to object permissions
ALTER TABLE `<?php echo $table_prefix ?>file_permissions` RENAME TO `<?php echo $table_prefix ?>object_user_permissions`;
ALTER TABLE `<?php echo $table_prefix ?>object_user_permissions` CHANGE COLUMN `file_id` `rel_object_id` INTEGER UNSIGNED NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>object_user_permissions` ADD COLUMN `rel_object_manager` VARCHAR(50) NOT NULL AFTER `rel_object_id`;
ALTER TABLE `<?php echo $table_prefix ?>object_user_permissions` DROP PRIMARY KEY;
ALTER TABLE `<?php echo $table_prefix ?>object_user_permissions` ADD PRIMARY KEY(`rel_object_id`, `user_id`, `rel_object_manager`);
UPDATE `<?php echo $table_prefix ?>object_user_permissions` SET rel_object_manager = 'ProjectFiles';

-- Create tables for contact management
CREATE TABLE `<?php echo $table_prefix ?>contacts`(
	`id` int(10) unsigned NOT NULL auto_increment,
	`firstname` varchar(40) <?php echo $default_collation ?> default NULL,
	`lastname` varchar(40) <?php echo $default_collation ?> default NULL,
	`middlename` varchar(40) <?php echo $default_collation ?> default NULL,
	`department` varchar(40) <?php echo $default_collation ?> default NULL,
	`job_title` varchar(40) <?php echo $default_collation ?> default NULL,
	`company_id` int(10) <?php echo $default_collation ?> default NULL,
	`email` varchar(100) <?php echo $default_collation ?> default NULL,
	`email2` varchar(100) <?php echo $default_collation ?> default NULL,
	`email3` varchar(100) <?php echo $default_collation ?> default NULL,
	`w_web_page` text <?php echo $default_collation ?> default NULL,
	`w_address` varchar(200) <?php echo $default_collation ?> default NULL,
	`w_city` varchar(25) <?php echo $default_collation ?> default NULL,
	`w_state` varchar(25) <?php echo $default_collation ?> default NULL,
	`w_zipcode` varchar(25) <?php echo $default_collation ?> default NULL,
	`w_country` varchar(25) <?php echo $default_collation ?> default NULL,
    `w_phone_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `w_phone_number2` varchar(20) <?php echo $default_collation ?> default NULL,
    `w_fax_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `w_assistant_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `w_callback_number` varchar(20) <?php echo $default_collation ?> default NULL,
	`h_web_page` text <?php echo $default_collation ?> default NULL,
	`h_address` varchar(200) <?php echo $default_collation ?> default NULL,
	`h_city` varchar(25) <?php echo $default_collation ?> default NULL,
	`h_state` varchar(25) <?php echo $default_collation ?> default NULL,
	`h_zipcode` varchar(25) <?php echo $default_collation ?> default NULL,
	`h_country` varchar(25) <?php echo $default_collation ?> default NULL,
    `h_phone_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `h_phone_number2` varchar(20) <?php echo $default_collation ?> default NULL,
    `h_fax_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `h_mobile_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `h_pager_number` varchar(20) <?php echo $default_collation ?> default NULL,
	`o_web_page` text <?php echo $default_collation ?> default NULL,
	`o_address` varchar(200) <?php echo $default_collation ?> default NULL,
	`o_city` varchar(25) <?php echo $default_collation ?> default NULL,
	`o_state` varchar(25) <?php echo $default_collation ?> default NULL,
	`o_zipcode` varchar(25) <?php echo $default_collation ?> default NULL,
	`o_country` varchar(25) <?php echo $default_collation ?> default NULL,
    `o_phone_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `o_phone_number2` varchar(20) <?php echo $default_collation ?> default NULL,
    `o_fax_number` varchar(20) <?php echo $default_collation ?> default NULL,
    `o_birthday` datetime default NULL,
    `picture_file` varchar(44) <?php echo $default_collation ?> default NULL,
	`timezone` float(2,1) NOT NULL default '0.0',
	`notes` text <?php echo $default_collation ?> default NULL,
	`user_id` int(10),
	`created_by_id` int(10),
	`is_private` tinyint(1) unsigned NOT NULL default '0',
	
    `created_on`  datetime NOT NULL default '0000-00-00 00:00:00',
    `updated_on`  datetime NOT NULL default '0000-00-00 00:00:00',

  PRIMARY KEY  (`id`),
  KEY user_id (`user_id`),
  KEY created_by_id (`created_by_id`),
  KEY company_id (`company_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE  `<?php echo $table_prefix ?>contact_im_values` (
  `contact_id` int(10) unsigned NOT NULL default '0',
  `im_type_id` tinyint(3) unsigned NOT NULL default '0',
  `value` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_default` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`contact_id`,`im_type_id`),
  KEY `is_default` (`is_default`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE  `<?php echo $table_prefix ?>project_contacts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `contact_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `role` varchar(255) <?php echo $default_collation ?> default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

-- Create tables for project webpage support
CREATE TABLE  `<?php echo $table_prefix ?>project_webpages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `url` varchar(500) <?php echo $default_collation ?> NOT NULL default '',
  `title` varchar(100) <?php echo $default_collation ?> default '',
  `description` varchar(255) <?php echo $default_collation ?> default '',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',	
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

--- Tables and data for calendar
CREATE TABLE  `<?php echo $table_prefix ?>project_events` (
  `id` int(11) NOT NULL auto_increment,
  `created_by_id` int(11) NOT NULL default '0',
  `updated_by_id` int(11) default NULL,
  `updated_on` datetime default NULL,
  `created_on` datetime default NULL,
  `start` datetime default NULL,
  `duration` datetime default NULL,
  `eventtype` int(4) default NULL,
  `subject` varchar(255) <?php echo $default_collation ?> default NULL,
  `description` text <?php echo $default_collation ?>,
  `private` char(1) <?php echo $default_collation ?> NOT NULL default '0',
  `repeat_end` date default NULL,
  `repeat_num` mediumint(9) NOT NULL default '0',
  `repeat_d` smallint(6) NOT NULL default '0',
  `repeat_m` smallint(6) NOT NULL default '0',
  `repeat_y` smallint(6) NOT NULL default '0',
  `repeat_h` smallint(6) NOT NULL default '0',
  `type_id` int(11) NOT NULL default '0',
  `special_id` int(11) NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>eventtypes` (
  `id` int(11) NOT NULL auto_increment,
  `typename` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `typedesc` text <?php echo $default_collation ?>,
  `typecolor` varchar(6) <?php echo $default_collation ?> NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>event_reminders` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `notification_date` DATETIME NOT NULL,
  `notify_by` VARCHAR(50) <?php echo $default_collation ?> NOT NULL,
  `sent` BOOLEAN NOT NULL,
  `created_by_id` INTEGER UNSIGNED NOT NULL,
  `created_on` DATETIME NOT NULL,
  `event_id` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE = InnoDB <?php echo $default_charset ?>;

-- add permissions for project users, 
ALTER TABLE `<?php echo $table_prefix ?>project_users` ADD COLUMN `can_manage_events` TINYINT(1) UNSIGNED NOT NULL AFTER `can_manage_tasks`;
-- Default: people who could manage tasks can now manage events
UPDATE `<?php echo $table_prefix ?>project_users` SET can_manage_events = can_manage_tasks;
-- 
-- Dumping data for table `cal_eventtypes`
-- 
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Birthday', 'Someone''s Birthday', 'F1EA74');
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Important', 'Something Important or Critical', 'FFAAAA');
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Boring', 'Boring Everyday Stuff', '999999');
INSERT INTO `<?php echo $table_prefix ?>eventtypes` (`typename`, `typedesc`, `typecolor`) VALUES ('Holiday', 'A Holiday', 'A4CAE6');

CREATE TABLE  `<?php echo $table_prefix ?>mail_accounts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `email` varchar(100) <?php echo $default_collation ?> default '',
  `password` varchar(40) <?php echo $default_collation ?> default '',
  `server` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `is_imap` int(1) NOT NULL default '0',
  `incoming_ssl` int(1) NOT NULL default '0',
  `incoming_ssl_port` int default '995',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE  `<?php echo $table_prefix ?>mail_contents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `account_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned default '0',
  `uid` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `from` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `to` text <?php echo $default_collation ?> NOT NULL,
  `date` timestamp,
  `sent_date` timestamp,
  `subject` text <?php echo $default_collation ?>,
  `content` longtext <?php echo $default_collation ?> NOT NULL,
  `body_plain` longtext <?php echo $default_collation ?>,
  `body_html` longtext <?php echo $default_collation ?>,
  `has_attachments` int(1) NOT NULL default '0',
  `size` int(10) NOT NULL default '0',
  `is_deleted` int(1) NOT NULL default '0',
  `is_shared` INT(1) NOT NULL default '0',
  `is_private` INT(1) NOT NULL default 0,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

--Allows for check in & checkout functionality
ALTER TABLE `<?php echo $table_prefix ?>project_files` ADD COLUMN `checked_out_on` datetime NOT NULL default '0000-00-00 00:00:00' AFTER `updated_by_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_files` ADD COLUMN `checked_out_by_id` int(10) UNSIGNED DEFAULT 0 AFTER `checked_out_on`;


ALTER TABLE `<?php echo $table_prefix ?>_users` ADD COLUMN `personal_project_id` INTEGER UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `<?php echo $table_prefix ?>tags` DROP COLUMN `project_id` , ROW_FORMAT = DYNAMIC;

-- save gui state
CREATE TABLE  `opengoo`.`<?php echo $table_prefix ?>guistate` (
  `user_id` int(10) unsigned NOT NULL default '1',
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB <?php echo $default_charset ?>;
