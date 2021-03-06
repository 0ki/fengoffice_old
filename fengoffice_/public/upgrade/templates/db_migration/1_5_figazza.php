-- <?php echo $table_prefix ?> og_
-- <?php echo $default_charset ?> DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
-- <?php echo $default_collation ?> collate utf8_unicode_ci
-- <?php echo $engine ?> InnoDB

ALTER TABLE `<?php echo $table_prefix ?>users` ADD COLUMN `updated_by_id` int(10) unsigned default NULL;

INSERT INTO `<?php echo $table_prefix ?>user_ws_config_categories` (`name`, `is_system`, `type`, `category_order`) VALUES
 ('mails panel', 0, 0, 5)
ON DUPLICATE KEY UPDATE name=name;

INSERT INTO `<?php echo $table_prefix ?>user_ws_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES 
 ('mails panel', 'block_email_images', '1', 'BoolConfigHandler', '0', '0', NULL),
 ('mails panel', 'view deleted accounts emails', '1', 'BoolConfigHandler', '0', '0', NULL),
 ('mails panel', 'draft_autosave_timeout', '60', 'IntegerConfigHandler', '0', '0', NULL),
 ('mails panel', 'attach_docs_content', '0', 'BoolConfigHandler', '0', '0', NULL),
 ('general', 'amount_objects_to_show', '5', 'IntegerConfigHandler', '0', '0', NULL),
 ('general', 'last_mail_format', 'plain', 'StringConfigHandler', '1', '0', NULL),
 ('dashboard', 'show_two_weeks_calendar', '1', 'BoolConfigHandler', '0', '0', NULL)
ON DUPLICATE KEY UPDATE id=id;

UPDATE `<?php echo $table_prefix ?>user_ws_config_options` SET
 `is_system` = 1 WHERE `name` = 'custom_report_tab';

UPDATE `<?php echo $table_prefix ?>user_ws_config_options` SET
 `category_name` = 'calendar panel' WHERE `name` = 'work_day_start_time';

UPDATE `<?php echo $table_prefix ?>user_ws_config_options` SET
 `default_value` = 0 WHERE `name` = 'rememberGUIState';

ALTER TABLE `<?php echo $table_prefix ?>application_logs` MODIFY COLUMN `action` enum('upload','open','close','delete','edit','add','trash','untrash','subscribe','unsubscribe','tag','comment','link','unlink','login') <?php echo $default_collation ?> default NULL;

CREATE TABLE `<?php echo $table_prefix ?>template_parameters` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`template_id` INT( 10 ) NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`type` VARCHAR( 255 ) NOT NULL
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

CREATE TABLE IF NOT EXISTS `<?php echo $table_prefix ?>template_object_properties` (
`template_id` INT( 10 ) NOT NULL ,
`object_id` INT( 10 ) NOT NULL ,
`object_manager` varchar(255) NOT NULL,
`property` VARCHAR( 255 ) NOT NULL ,
`value` TEXT NOT NULL ,
PRIMARY KEY ( `template_id` , `object_id` ,`object_manager`, `property` )
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

ALTER TABLE `<?php echo $table_prefix ?>mail_contents` ADD COLUMN `cc` TEXT NOT NULL AFTER `to`;
ALTER TABLE `<?php echo $table_prefix ?>mail_contents` ADD COLUMN `bcc` TEXT NOT NULL AFTER `cc`;
ALTER TABLE `<?php echo $table_prefix ?>mail_contents` DROP COLUMN `date`;
ALTER TABLE `<?php echo $table_prefix ?>mail_contents` ADD INDEX `uid`(`uid`);

ALTER TABLE  `<?php echo $table_prefix ?>gs_fontStyles` MODIFY COLUMN `FontColor` varchar(7) <?php echo $default_collation ?> NOT NULL default '';
ALTER TABLE  `<?php echo $table_prefix ?>gs_fontStyles` ADD COLUMN `FontVAlign` int(11) NOT NULL default '0';
ALTER TABLE  `<?php echo $table_prefix ?>gs_fontStyles` ADD COLUMN `FontHAlign` int(11) NOT NULL default '0';

ALTER TABLE `<?php echo $table_prefix ?>custom_property_values` MODIFY COLUMN `object_id` INT(10) NOT NULL DEFAULT 0;
ALTER TABLE `<?php echo $table_prefix ?>custom_property_values` DROP PRIMARY KEY;
ALTER TABLE `<?php echo $table_prefix ?>custom_property_values` ADD COLUMN `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY;

CREATE TABLE  `<?php echo $table_prefix ?>gs_borderstyles` (
  `BorderStyleId` int(11) NOT NULL auto_increment,
  `BorderColor` varchar(7) <?php echo $default_collation ?>  default NULL,
  `BorderWidth` int(11) NOT NULL DEFAULT 0,
  `BorderStyle` varchar(64) DEFAULT NULL,
  `BookId` int(11) DEFAULT NULL, 
  PRIMARY KEY  (`BorderStyleId`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>gs_layoutstyles` (                          
  `LayoutStyleId` int(11) NOT NULL AUTO_INCREMENT,        
  `BorderLeftStyleId` int(11) DEFAULT NULL,               
  `BackgroundColor` varchar(7) <?php echo $default_collation ?> DEFAULT NULL,              
  `BorderRightStyleId` int(11) DEFAULT NULL,              
  `BorderTopStyleId` int(11) DEFAULT NULL,                
  `BorderBottomStyleId` int(11) DEFAULT NULL,             
  `BookId` int(11) DEFAULT NULL,                          
  PRIMARY KEY (`LayoutStyleId`)                           
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
 ('general', 'ask_administration_autentification', 0, 'BoolConfigHandler', 0, 0, NULL)
ON DUPLICATE KEY UPDATE id=id;

ALTER TABLE `<?php echo $table_prefix ?>mail_accounts`
 ADD COLUMN `last_checked` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 ADD COLUMN `is_default` BOOLEAN NOT NULL,
 ADD COLUMN `signature` text <?php echo $default_collation ?> NOT NULL,
 MODIFY COLUMN `del_from_server` INTEGER NOT NULL DEFAULT 0;

UPDATE `<?php echo $table_prefix ?>mail_accounts` SET `del_from_server` = -1 where `del_from_server` = 0;

ALTER TABLE `<?php echo $table_prefix ?>reports`
 ADD COLUMN `workspace` INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER `is_order_by_asc`,
 ADD COLUMN `tags` VARCHAR(45) NOT NULL AFTER `workspace`;

-- migrate weblinks to multiple workspaces
INSERT INTO `<?php echo $table_prefix ?>workspace_objects`
	(`workspace_id`,
	`object_manager`,
	`object_id`,
	`created_by_id`,
	`created_on`) 
SELECT
	`project_id` as `workspace_id`,
	'ProjectWebpages' as `object_manager`,
	`id` as `object_id`,
	`created_by_id`,
	`created_on`
FROM `<?php echo $table_prefix ?>project_webpages` where `project_id` <> 0;

ALTER TABLE `<?php echo $table_prefix ?>project_webpages` DROP COLUMN `project_id`;

-- migrate events to multiple workspaces
INSERT INTO `<?php echo $table_prefix ?>workspace_objects`
	(`workspace_id`,
	`object_manager`,
	`object_id`,
	`created_by_id`,
	`created_on`) 
SELECT
	`project_id` as `workspace_id`,
	'ProjectEvents' as `object_manager`,
	`id` as `object_id`,
	`created_by_id`,
	`created_on`
FROM `<?php echo $table_prefix ?>project_events` where `project_id` <> 0;

ALTER TABLE `<?php echo $table_prefix ?>project_events` DROP COLUMN `project_id`;

-- migrate tasks to multiple workspaces
INSERT INTO `<?php echo $table_prefix ?>workspace_objects`
	(`workspace_id`,
	`object_manager`,
	`object_id`,
	`created_by_id`,
	`created_on`) 
SELECT
	`project_id` as `workspace_id`,
	'ProjectTasks' as `object_manager`,
	`id` as `object_id`,
	`created_by_id`,
	`created_on`
FROM `<?php echo $table_prefix ?>project_tasks` where `project_id` <> 0;

ALTER TABLE `<?php echo $table_prefix ?>project_tasks` DROP COLUMN `project_id`,
 ADD COLUMN `repeat_end` DATETIME NOT NULL default '0000-00-00 00:00:00',
 ADD COLUMN `repeat_forever` tinyint(1) NOT NULL,
 ADD COLUMN `repeat_num` int(10) unsigned NOT NULL default '0',
 ADD COLUMN `repeat_d` int(10) unsigned NOT NULL,
 ADD COLUMN `repeat_m` int(10) unsigned NOT NULL,
 ADD COLUMN `repeat_y` int(10) unsigned NOT NULL,
 ADD COLUMN `repeat_by` varchar(15) <?php echo $default_collation ?> NOT NULL default '';

-- migrate milestones to multiple workspaces
INSERT INTO `<?php echo $table_prefix ?>workspace_objects`
	(`workspace_id`,
	`object_manager`,
	`object_id`,
	`created_by_id`,
	`created_on`) 
SELECT
	`project_id` as `workspace_id`,
	'ProjectMilestones' as `object_manager`,
	`id` as `object_id`,
	`created_by_id`,
	`created_on`
FROM `<?php echo $table_prefix ?>project_milestones` where `project_id` <> 0;

ALTER TABLE `<?php echo $table_prefix ?>project_milestones` DROP COLUMN `project_id`;

-- migrate charts to multiple workspaces
INSERT INTO `<?php echo $table_prefix ?>workspace_objects`
	(`workspace_id`,
	`object_manager`,
	`object_id`,
	`created_by_id`,
	`created_on`) 
SELECT
	`project_id` as `workspace_id`,
	'ProjectCharts' as `object_manager`,
	`id` as `object_id`,
	`created_by_id`,
	`created_on`
FROM `<?php echo $table_prefix ?>project_charts` where `project_id` <> 0;

ALTER TABLE `<?php echo $table_prefix ?>project_charts` DROP COLUMN `project_id`;

CREATE TABLE IF NOT EXISTS `<?php echo $table_prefix ?>queued_emails` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`to` text <?php echo $default_collation ?>,
	`from` text <?php echo $default_collation ?>,
	`subject` text <?php echo $default_collation ?>,
	`body` text <?php echo $default_collation ?>,
	`timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
	PRIMARY KEY (`id`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

UPDATE <?php echo $table_prefix ?>contacts AS o SET o.w_country = 'cd' WHERE o.w_country = 'zr';
UPDATE <?php echo $table_prefix ?>contacts AS o SET o.w_country = 'tl' WHERE o.w_country = 'tp';
UPDATE <?php echo $table_prefix ?>companies AS o SET o.country = 'cd' WHERE o.country = 'zr';
UPDATE <?php echo $table_prefix ?>companies AS o SET o.country = 'tl' WHERE o.country = 'tp';
