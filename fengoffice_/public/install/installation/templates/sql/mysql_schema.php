CREATE TABLE `<?php echo $table_prefix ?>administration_tools` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `controller` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `action` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>application_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `taken_by_id` int(10) unsigned default NULL,
  `project_id` int(10) unsigned NOT NULL default '0',
  `rel_object_id` int(10) NOT NULL default '0',
  `object_name` text <?php echo $default_collation ?>,
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `action` enum('upload','open','close','delete','edit','add') <?php echo $default_collation ?> default NULL,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_silent` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `rel_object_manager` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `text` text <?php echo $default_collation ?>,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_anonymous` tinyint(1) unsigned NOT NULL default '0',
  `author_name` varchar(50) <?php echo $default_collation ?> default NULL,
  `author_email` varchar(100) <?php echo $default_collation ?> default NULL,
  `author_homepage` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `object_id` (`rel_object_id`,`rel_object_manager`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>companies` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `client_of_id` smallint(5) unsigned default NULL,
  `name` varchar(50) <?php echo $default_collation ?> default NULL,
  `email` varchar(100) <?php echo $default_collation ?> default NULL,
  `homepage` varchar(100) <?php echo $default_collation ?> default NULL,
  `address` varchar(100) <?php echo $default_collation ?> default NULL,
  `address2` varchar(100) <?php echo $default_collation ?> default NULL,
  `city` varchar(50) <?php echo $default_collation ?> default NULL,
  `state` varchar(50) <?php echo $default_collation ?> default NULL,
  `zipcode` varchar(30) <?php echo $default_collation ?> default NULL,
  `country` varchar(10) <?php echo $default_collation ?> default NULL,
  `phone_number` varchar(30) <?php echo $default_collation ?> default NULL,
  `fax_number` varchar(30) <?php echo $default_collation ?> default NULL,
  `logo_file` varchar(44) <?php echo $default_collation ?> default NULL,
  `timezone` float(2,1) NOT NULL default '0.0',
  `hide_welcome_info` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `client_of_id` (`client_of_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>config_categories` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_system` tinyint(1) unsigned NOT NULL default '0',
  `category_order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `order` (`category_order`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>config_options` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `category_name` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `value` text <?php echo $default_collation ?>,
  `config_handler_class` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_system` tinyint(1) unsigned NOT NULL default '0',
  `option_order` smallint(5) unsigned NOT NULL default '0',
  `dev_comment` varchar(255) <?php echo $default_collation ?> default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `order` (`option_order`),
  KEY `category_id` (`category_name`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>eventtypes` (
  `id` int(11) NOT NULL auto_increment,
  `typename` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `typedesc` text <?php echo $default_collation ?>,
  `typecolor` varchar(6) <?php echo $default_collation ?> NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>file_repo` (
  `id` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `content` longblob NOT NULL,
  `order` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `order` (`order`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>file_repo_attributes` (
  `id` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `attribute` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `value` text <?php echo $default_collation ?> NOT NULL,
  PRIMARY KEY  (`id`,`attribute`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>file_types` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `extension` varchar(10) <?php echo $default_collation ?> NOT NULL default '',
  `icon` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `is_searchable` tinyint(1) unsigned NOT NULL default '0',
  `is_image` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `extension` (`extension`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>groups` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` TEXT <?php echo $default_collation ?> NOT NULL,
  `created_on` DATETIME NOT NULL,
  `created_by_id` INTEGER UNSIGNED NOT NULL,
  `updated_on` DATETIME NOT NULL,
  `updated_by_id` INTEGER UNSIGNED NOT NULL,
  	`can_edit_company_data` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_security` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_workspaces` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_configuration` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_contacts` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 10000000 <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>group_users` (
  `group_id` INTEGER UNSIGNED NOT NULL,
  `user_id` INTEGER UNSIGNED NOT NULL,
  `created_on` DATETIME NOT NULL,
  `created_by_id` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(`group_id`, `user_id`),
  INDEX `USER`(`user_id`)
) ENGINE = InnoDB;

CREATE TABLE `<?php echo $table_prefix ?>linked_objects` (
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `object_id` int(10) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',  
  PRIMARY KEY(`rel_object_manager`,`rel_object_id`,`object_id`,`object_manager`)  
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>im_types` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `icon` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>message_subscriptions` (
  `message_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`message_id`,`user_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>object_user_permissions` (
  `rel_object_id` INTEGER UNSIGNED NOT NULL,
  `rel_object_manager` VARCHAR(50) NOT NULL,
  `user_id` INTEGER UNSIGNED NOT NULL,
  `can_read` TINYINT(1) UNSIGNED NOT NULL,
  `can_write` TINYINT(1) UNSIGNED NOT NULL,
  PRIMARY KEY(`rel_object_id`, `user_id`, `rel_object_manager`)
) ENGINE = InnoDB <?php echo $default_charset ?>;

CREATE TABLE  `<?php echo $table_prefix ?>object_properties` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rel_object_id` int(10) unsigned NOT NULL,
  `rel_object_manager` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_companies` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `company_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`company_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE  `<?php echo $table_prefix ?>project_events` (
  `id` int(11) NOT NULL auto_increment,
  `created_by_id` int(11) NOT NULL default '0',
  `updated_by_id` int(11) default NULL,
  `updated_on` datetime default NULL,
  `created_on` datetime default NULL,
  `start` datetime default NULL,
  `duration` datetime default NULL,
  `eventtype` int(4) default 1,
  `subject` varchar(255) <?php echo $default_collation ?> default NULL,
  `description` text <?php echo $default_collation ?>,
  `private` char(1) <?php echo $default_collation ?> NOT NULL default '0',
  `repeat_end` date default NULL,
  `repeat_forever` TINYINT(1) UNSIGNED NOT NULL,
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

CREATE TABLE `<?php echo $table_prefix ?>project_file_revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `file_id` int(10) unsigned NOT NULL default '0',
  `file_type_id` smallint(5) unsigned NOT NULL default '0',
  `repository_id` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `thumb_filename` varchar(44) <?php echo $default_collation ?> default NULL,
  `revision_number` int(10) unsigned NOT NULL default '0',
  `comment` text <?php echo $default_collation ?>,
  `type_string` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `file_id` (`file_id`),
  KEY `updated_on` (`updated_on`),
  KEY `revision_number` (`revision_number`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `filename` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `description` text <?php echo $default_collation ?>,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_important` tinyint(1) unsigned NOT NULL default '0',
  `is_locked` tinyint(1) unsigned NOT NULL default '0',
  `is_visible` tinyint(1) unsigned NOT NULL default '0',
  `expiration_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `anonymous_comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default '0',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default '0',
  `checked_out_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `checked_out_by_id` int(10) unsigned DEFAULT 0,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_forms` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `description` text <?php echo $default_collation ?> NOT NULL,
  `success_message` text <?php echo $default_collation ?> NOT NULL,
  `action` enum('add_comment','add_task') <?php echo $default_collation ?> NOT NULL default 'add_comment',
  `in_object_id` int(10) unsigned NOT NULL default '0',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned NOT NULL default '0',
  `is_visible` tinyint(1) unsigned NOT NULL default '0',
  `is_enabled` tinyint(1) unsigned NOT NULL default '0',
  `order` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `milestone_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned default NULL,
  `title` varchar(100) <?php echo $default_collation ?> default NULL,
  `text` text <?php echo $default_collation ?>,
  `additional_text` text <?php echo $default_collation ?>,
  `is_important` tinyint(1) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `anonymous_comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `milestone_id` (`milestone_id`),
  KEY `project_id` (`project_id`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_milestones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned default NULL,
  `name` varchar(100) <?php echo $default_collation ?> default NULL,
  `description` text <?php echo $default_collation ?>,
  `due_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `assigned_to_company_id` smallint(10) NOT NULL default '0',
  `assigned_to_user_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(10) unsigned default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `due_date` (`due_date`),
  KEY `completed_on` (`completed_on`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_tasks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned default NULL,
  `project_id` INTEGER UNSIGNED NOT NULL,
  `title` TEXT <?php echo $default_collation ?>,
  `text` text <?php echo $default_collation ?>,
  `due_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `assigned_to_company_id` smallint(5) unsigned default NULL,
  `assigned_to_user_id` int(10) unsigned default NULL,
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(10) unsigned default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,   
  `started_on` DATETIME DEFAULT NULL,
  `started_by_id` INTEGER UNSIGNED NOT NULL,
  `priority` INTEGER UNSIGNED,
  `state` INTEGER UNSIGNED,
  `order` int(10) unsigned  default '0',
  `milestone_id` INTEGER UNSIGNED,
  `is_private` BOOLEAN NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `completed_on` (`completed_on`),
  KEY `created_on` (`created_on`),
  KEY `order` (`order`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_users` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  `can_read_messages` tinyint(1) unsigned default '0',
  `can_write_messages` tinyint(1) unsigned default '0',
  `can_read_tasks` tinyint(1) unsigned default '0',
  `can_write_tasks` tinyint(1) unsigned default '0',
  `can_read_milestones` tinyint(1) unsigned default '0',
  `can_write_milestones` tinyint(1) unsigned default '0',
  `can_read_files` tinyint(1) unsigned default '0',
  `can_write_files` tinyint(1) unsigned default '0',
  `can_read_events` tinyint(1) unsigned default '0',
  `can_write_events` tinyint(1) unsigned default '0',
  `can_read_weblinks` tinyint(1) unsigned default '0',
  `can_write_weblinks` tinyint(1) unsigned default '0',
  `can_read_mails` tinyint(1) unsigned default '0',
  `can_write_mails` tinyint(1) unsigned default '0',
  `can_read_contacts` tinyint(1) unsigned default '0',
  `can_write_contacts` tinyint(1) unsigned default '0',
  `can_read_comments` tinyint(1) unsigned default '0',
  `can_write_comments` tinyint(1) unsigned default '0',
  `can_assign_to_owners` tinyint(1) unsigned NOT NULL default '0',
  `can_assign_to_other` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`user_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>projects` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> default NULL,
  `description` text <?php echo $default_collation ?>,
  `show_description_in_overview` tinyint(1) unsigned NOT NULL default '0',
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(11) default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  `color` int(10) unsigned default 0,
  `parent_id` int(10) unsigned NOT NULL default 0,
  PRIMARY KEY  (`id`),
  KEY `completed_on` (`completed_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>searchable_objects` (
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `column_name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `content` text <?php echo $default_collation ?> NOT NULL,
  `project_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rel_object_manager`,`rel_object_id`,`column_name`),
  KEY `project_id` (`project_id`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `tag` (`tag`),
  KEY `object_id` (`rel_object_id`,`rel_object_manager`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>user_im_values` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `im_type_id` tinyint(3) unsigned NOT NULL default '0',
  `value` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_default` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`im_type_id`),
  KEY `is_default` (`is_default`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `company_id` smallint(5) unsigned NOT NULL default '0',
  `personal_project_id` int(10) unsigned NOT NULL default '0',
  `username` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `email` varchar(100) <?php echo $default_collation ?> default NULL,
  `token` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `salt` varchar(13) <?php echo $default_collation ?> NOT NULL default '',
  `twister` varchar(10) <?php echo $default_collation ?> NOT NULL default '',
  `display_name` varchar(50) <?php echo $default_collation ?> default NULL,
  `title` varchar(30) <?php echo $default_collation ?> default NULL,
  `avatar_file` varchar(44) <?php echo $default_collation ?> default NULL,
  `office_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `fax_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `mobile_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `home_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `timezone` float(2,1) NOT NULL default '0.0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_visit` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_activity` datetime NOT NULL default '0000-00-00 00:00:00',
  	`can_edit_company_data` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_security` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_workspaces` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_configuration` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`can_manage_contacts` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, 
  `auto_assign` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `last_visit` (`last_visit`),
  KEY `company_id` (`company_id`),
  KEY `last_login` (`last_login`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

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
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',	
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

-- save gui state
CREATE TABLE  `<?php echo $table_prefix ?>guistate` (
  `user_id` int(10) unsigned NOT NULL default '1',
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB <?php echo $default_charset ?>;