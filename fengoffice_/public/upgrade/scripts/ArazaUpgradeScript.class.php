<?php

/**
 * Araza upgrade script will upgrade FengOffice 3.1 to FengOffice 3.1.2.2
 *
 * @package ScriptUpgrader.scripts
 * @version 1.0
 */
class ArazaUpgradeScript extends ScriptUpgraderScript {

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
	 * Construct the ArazaUpgradeScript
	 *
	 * @param Output $output
	 * @return ArazaUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('3.1');
		$this->setVersionTo('3.1.2.2');
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
		
		include_once ROOT . "/public/upgrade/helpers/rebuild_tasks_tree.php";
		
		// RUN QUERIES
		$total_queries = 0;
		$executed_queries = 0;

		$upgrade_script = "";
		
		$v_from = array_var($_POST, 'form_data');
		$original_version_from = array_var($v_from, 'upgrade_from', $installed_version);
		
		
		// Set upgrade queries	
		if (version_compare($installed_version, '3.1.1') < 0) {
			if (!$this->checkColumnExists($t_prefix."project_tasks", "parents_path", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."project_tasks` ADD COLUMN `parents_path` varchar(255) NOT NULL default '';
				";
			}
			
			if (!$this->checkColumnExists($t_prefix."project_tasks", "depth", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."project_tasks` ADD COLUMN `depth` int(2) unsigned NOT NULL default '0';
				";
			}
			
			if (!$this->checkColumnExists($t_prefix."template_tasks", "parents_path", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."template_tasks` ADD COLUMN `parents_path` varchar(255) NOT NULL default '';
				";
			}
				
			if (!$this->checkColumnExists($t_prefix."template_tasks", "depth", $this->database_connection)) {
				$upgrade_script .= "
					ALTER TABLE `".$t_prefix."template_tasks` ADD COLUMN `depth` int(2) unsigned NOT NULL default '0';
				";
			}

			$upgrade_script .= rebuild_tasks_depth_and_parents_path($t_prefix."project_tasks", $this->database_connection);
			$upgrade_script .= rebuild_tasks_depth_and_parents_path($t_prefix."template_tasks", $this->database_connection);
		
			
		}		
		
		if (version_compare($installed_version, '3.1.2') < 0) {
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
				 ('general', 'last_sharing_table_rebuild', NOW(), 'StringConfigHandler', '1', '0', NULL)
				ON DUPLICATE KEY UPDATE name=name;
			";
			$upgrade_script .= "
				INSERT INTO `".$t_prefix."cron_events` (`name`, `recursive`, `delay`, `is_system`, `enabled`, `date`) VALUES
				('sharing_table_partial_rebuild', '1', '1440', '1', '1', '0000-00-00 00:00:00');
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
	
} // ArazaUpgradeScript
