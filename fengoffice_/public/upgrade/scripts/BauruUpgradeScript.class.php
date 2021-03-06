<?php

/**
 * Bauru upgrade script will upgrade FengOffice 3.3.2-beta to FengOffice 3.4.1
 *
 * @package ScriptUpgrader.scripts
 * @version 1.0
 */
class BauruUpgradeScript extends ScriptUpgraderScript {

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
	 * Construct the BauruUpgradeScript
	 *
	 * @param Output $output
	 * @return BauruUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('3.3.2-beta');
		$this->setVersionTo('3.4.1');
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
		if (version_compare($installed_version, '3.4-beta') < 0) {
			// dummy query
			$upgrade_script .= "
				UPDATE ".$t_prefix."config_options SET is_system=1 WHERE name='messages_per_page';
			";
		}
		
		if (version_compare($installed_version, '3.4-rc') < 0) {
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."contact_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
					('general', 'timeReportTaskStatus', 'all', 'StringConfigHandler', 1, 0, '')
				ON DUPLICATE KEY UPDATE name=name;
			";
		}
		
		if (version_compare($installed_version, '3.4.0.16') < 0) {
			// fix contacts that were created from emails and have some user fields
			$upgrade_script .= "
				ALTER TABLE `".$t_prefix."contact_emails`
				CHANGE `email_address` `email_address` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';
			";
		}
		
		if (version_compare($installed_version, '3.4.1-beta') < 0) {
			// fix contacts that were created from emails and have some user fields
			$upgrade_script .= "
				delete from ".$t_prefix."permission_groups
				where id in (select permission_group_id from ".$t_prefix."contacts where user_type=0 and permission_group_id>0);
				
				delete from ".$t_prefix."system_permissions
				where permission_group_id in (select permission_group_id from ".$t_prefix."contacts where user_type=0 and permission_group_id>0);
				
				update ".$t_prefix."contacts set
				  permission_group_id=0,
				  token='', salt='', twister='',
				  display_name='', username='', company_id=0
				where user_type=0 and permission_group_id>0;
			";
			
			if (!$this->checkColumnExists($t_prefix."custom_properties", "is_special", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."custom_properties`
					 ADD COLUMN `is_special` BOOLEAN NOT NULL DEFAULT 0,
					 ADD COLUMN `is_disabled` BOOLEAN NOT NULL DEFAULT 0;
				";
			}
			
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
				 ('mailing', 'show company logo in notifications', '1', 'BoolConfigHandler', 0, 0, NULL)
				ON DUPLICATE KEY UPDATE name=name;
			";
			
			$upgrade_script .= "
				CREATE TABLE IF NOT EXISTS `".$t_prefix."object_selector_temp_values` (
				  `user_id` int(11) NOT NULL DEFAULT 0,
				  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				  `value` text COLLATE utf8_unicode_ci NOT NULL,
				  PRIMARY KEY (`user_id`,`identifier`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			";
			
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."cron_events` (`name`, `recursive`, `delay`, `is_system`, `enabled`, `date`) VALUES	
				 ('clean_object_selector_temp_selection', '1', '360', '1', '1', '0000-00-00 00:00:00')
				ON DUPLICATE KEY UPDATE name=name;
			";
			
			$upgrade_script .= "
				UPDATE `".$t_prefix."contacts` SET username=TRIM(CONCAT(first_name,' ',surname))
				WHERE user_type>0 AND username='';
			";
			
			// custom property for job title
			$upgrade_script .= "
				INSERT INTO ".$t_prefix."custom_properties (`object_type_id`,`name`,`code`,`type`,`visible_by_default`,`is_special`) VALUES
				((SELECT id FROM ".$t_prefix."object_types WHERE name='contact'), 'Job title', 'job_title', 'text', 1, 1);
			";
			$upgrade_script .= "
				INSERT INTO ".$t_prefix."custom_property_values (`object_id`,`custom_property_id`,`value`) SELECT
					c.object_id, (SELECT cp.id FROM ".$t_prefix."custom_properties cp WHERE cp.code='job_title'), c.job_title
					FROM ".$t_prefix."contacts c WHERE c.job_title<>''
				ON DUPLICATE KEY UPDATE ".$t_prefix."custom_property_values.object_id=".$t_prefix."custom_property_values.object_id;
			";
			$upgrade_script .= "
				ALTER TABLE `".$t_prefix."custom_property_values`
				ADD INDEX `object_id_custom_property_id` (`object_id`, `custom_property_id`);
			";
		}
		
		if (version_compare($installed_version, '3.4.1-rc') < 0) {
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."contact_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
					('calendar panel', 'displayed events amount', '3', 'IntegerConfigHandler', 0, 0, '')
				ON DUPLICATE KEY UPDATE name=name;
			";
			
			$upgrade_script .= "
				UPDATE `".$t_prefix."object_types` SET `table_name` = 'project_file_revisions' WHERE `name` = 'file revision';
			";
			
			$upgrade_script .= "
				ALTER TABLE `".$t_prefix."members` ADD INDEX (`name`);
			";
		}
		
		if (version_compare($installed_version, '3.4.1') < 0) {
			// add total worked time column to tasks
			$upgrade_script .= "
				ALTER TABLE `".$t_prefix."project_tasks` ADD `total_worked_time` int(10) unsigned NOT NULL DEFAULT 0;
			";
			// add index by total worked time
			$upgrade_script .= "
				ALTER TABLE `".$t_prefix."project_tasks` ADD INDEX `total_worked_time` (`total_worked_time`);
			";
			
			// calculate total worked time foreach task
			$upgrade_script .= "
				UPDATE ".$t_prefix."project_tasks SET total_worked_time = (
					SELECT (SUM(GREATEST(TIMESTAMPDIFF(MINUTE,start_time,end_time),0)) - SUM(subtract/60)) 
					FROM ".$t_prefix."timeslots ts 
					WHERE ts.rel_object_id=".$t_prefix."project_tasks.object_id
				)
			";
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
	
} // BauruUpgradeScript
