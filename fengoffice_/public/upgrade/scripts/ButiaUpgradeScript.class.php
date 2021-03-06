<?php

/**
 * Butia upgrade script will upgrade FengOffice 3.1.5.3 to FengOffice 3.2-beta2
 *
 * @package ScriptUpgrader.scripts
 * @version 1.0
 */
class ButiaUpgradeScript extends ScriptUpgraderScript {

	/**
	 * Array of files and folders that need to be writable
	 *
	 * @var array
	 */
	private $check_is_writable = array(
		'/config/config.php',
		'/config',
		'/cache',
		'/tmp',
		'/upload'
	 ); // array

	 /**
	 * Array of extensions taht need to be loaded
	 *
	 * @var array
	 */
	private $check_extensions = array(
		'mysql', 'gd', 'simplexml'
	); // array

	 /**
	 * Construct the ButiaUpgradeScript
	 *
	 * @param Output $output
	 * @return ButiaUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('3.1.5.3');
		$this->setVersionTo('3.2-beta2');
	} // __construct

	function getCheckIsWritable() {
		return $this->check_is_writable;
	}

	function getCheckExtensions() {
		return $this->check_extensions;
	}
	
	/**
	 * Execute the script
	 *
	 * @param void
	 * @return boolean
	 */
	function execute() {
		if (!@mysql_ping($this->database_connection)) {
			if ($dbc = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
				if (mysql_select_db(DB_NAME, $dbc)) {
					$this->printMessage('Upgrade script has connected to the database.');
				} else {
					$this->printMessage('Failed to select database ' . DB_NAME);
					return false;
				}
				$this->setDatabaseConnection($dbc);
			} else {
				$this->printMessage('Failed to connect to database');
				return false;
			}
		}
		
		// ---------------------------------------------------
		//  Check MySQL version
		// ---------------------------------------------------

		$mysql_version = mysql_get_server_info($this->database_connection);
		if($mysql_version && version_compare($mysql_version, '4.1', '>=')) {
			$constants['DB_CHARSET'] = 'utf8';
			@mysql_query("SET NAMES 'utf8'", $this->database_connection);
			tpl_assign('default_collation', $default_collation = 'collate utf8_unicode_ci');
			tpl_assign('default_charset', $default_charset = 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
		} else {
			tpl_assign('default_collation', $default_collation = '');
			tpl_assign('default_charset', $default_charset = '');
		} // if

		$installed_version = installed_version();
		$t_prefix = TABLE_PREFIX;
		$additional_upgrade_steps = array();
						
		// RUN QUERIES
		$total_queries = 0;
		$executed_queries = 0;

		$upgrade_script = "";
		
		$v_from = array_var($_POST, 'form_data');
		$original_version_from = array_var($v_from, 'upgrade_from', $installed_version);
		
		
		// Set upgrade queries	
		if (version_compare($installed_version, '3.2-beta') < 0) {
			$upgrade_script .= "
				CREATE TABLE IF NOT EXISTS `".$t_prefix."external_calendar_properties` (
				  `external_calendar_id` int(10) unsigned NOT NULL,
				  `key` varchar(255) ".$default_collation." NOT NULL,
				  `value` text  ".$default_collation." NOT NULL, 
				  PRIMARY KEY (`external_calendar_id`,`key`)
				) ENGINE=InnoDB ".$default_charset.";
			";	
			
			$upgrade_script .= "
				TRUNCATE TABLE `".$t_prefix."external_calendar_users`;
				ALTER TABLE `".$t_prefix."external_calendar_users` MODIFY auth_pass text;
			";
			
			$upgrade_script .= "
				UPDATE `".$t_prefix."project_events` SET ext_cal_id=0
				WHERE ext_cal_id > 0;
			";
			
			$upgrade_script .= "
				TRUNCATE TABLE `".$t_prefix."external_calendars`;
				ALTER TABLE  `".$t_prefix."external_calendars` CHANGE `calendar_user` `original_calendar_id` varchar(255);
			";
			
			if (!$this->checkColumnExists($t_prefix."external_calendars", "sync", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."external_calendars` ADD COLUMN `sync` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER calendar_feng;
				";
			}
			
			if (!$this->checkColumnExists($t_prefix."external_calendars", "related_to", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."external_calendars` ADD COLUMN `related_to` VARCHAR( 255 ) NOT NULL DEFAULT '' AFTER sync;
				";
			}
			
			$upgrade_script .= "
				CREATE TABLE IF NOT EXISTS `".$t_prefix."template_instantiated_parameters` (
				  `template_id` INTEGER UNSIGNED NOT NULL,
				  `instantiation_id` INTEGER UNSIGNED NOT NULL,
				  `parameter_name` VARCHAR(255) NOT NULL DEFAULT '',
				  `value` TEXT NOT NULL,
				  PRIMARY KEY (`template_id`, `instantiation_id`, `parameter_name`)
				) ENGINE = InnoDB;
			";
			
			if (!$this->checkColumnExists($t_prefix."project_tasks", "instantiation_id", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."project_tasks` ADD COLUMN `instantiation_id` INTEGER UNSIGNED NOT NULL DEFAULT 0;
				";
			}
			
			if (!$this->checkColumnExists($t_prefix."queued_emails", "cc", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."queued_emails`
					 ADD COLUMN `cc` TEXT NOT NULL AFTER `to`,
					 ADD COLUMN `bcc` TEXT NOT NULL AFTER `cc`;
				";
			}
			
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
				 ('system', 'last_template_instantiation_id', '0', 'IntegerConfigHandler', '1', '0', NULL)
				ON DUPLICATE KEY UPDATE name=name;
			";
			
			
			// max member permissions by role
			if (!$this->checkTableExists($t_prefix.'max_role_object_type_permissions', $this->database_connection)) {
				$upgrade_script .= "
					CREATE TABLE `".$t_prefix."max_role_object_type_permissions` (
					  `role_id` INTEGER UNSIGNED NOT NULL,
					  `object_type_id` INTEGER UNSIGNED NOT NULL,
					  `can_delete` BOOLEAN NOT NULL,
					  `can_write` BOOLEAN NOT NULL,
					  PRIMARY KEY (`role_id`, `object_type_id`)
					) ENGINE = InnoDB;
				";
				$upgrade_script .= "
					INSERT INTO `".$t_prefix."max_role_object_type_permissions` SELECT * FROM `".$t_prefix."role_object_type_permissions`;
				";
				
				$upgrade_script .= "
					DELETE FROM `".$t_prefix."role_object_type_permissions` 
					WHERE object_type_id=(select id from ".$t_prefix."object_types where name='report') 
						AND role_id IN (SELECT id FROM ".$t_prefix."permission_groups WHERE `type`='roles' AND name IN ('Guest Customer','Guest','Non-Exec Director'));
				";
			}
			
			
			if (!$this->checkColumnExists($t_prefix."template_parameters", "default_value", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."template_parameters`
					 ADD COLUMN `default_value` TEXT NOT NULL;
				";
			}
			
			
			if($mysql_version && version_compare($mysql_version, '5.6', '>=')) {
				$upgrade_script .= "
					CREATE TABLE `".$t_prefix."searchable_objects_new` (
						`rel_object_id` int(10) unsigned NOT NULL default '0',
						`column_name` varchar(50) collate utf8_unicode_ci NOT NULL default '',
						`content` text collate utf8_unicode_ci NOT NULL,
						`contact_id` int(10) unsigned NOT NULL default '0',
						PRIMARY KEY  (`rel_object_id`,`column_name`),
						FULLTEXT KEY `content` (`content`),
						KEY `rel_obj_id` (`rel_object_id`)
					) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
				";
				$upgrade_script .= "
					INSERT INTO `".$t_prefix."searchable_objects_new` SELECT * FROM `".$t_prefix."searchable_objects` ORDER BY rel_object_id, column_name;
					RENAME TABLE `".$t_prefix."searchable_objects` TO `".$t_prefix."searchable_objects_old`;
					RENAME TABLE `".$t_prefix."searchable_objects_new` TO `".$t_prefix."searchable_objects`;
					DROP TABLE `".$t_prefix."searchable_objects_old`;
				";
			}
			
		}
		
		
		// Execute all queries
		if(!$this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
			$this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
			return false;
		}
		$this->printMessage("Database schema transformations executed (total queries: $total_queries)");
		
		
		$this->printMessage('Feng Office has been upgraded. You are now running Feng Office '.$this->getVersionTo().' Enjoy!');

		tpl_assign('additional_steps', $additional_upgrade_steps);

	} // execute
	
} // ButiaUpgradeScript
