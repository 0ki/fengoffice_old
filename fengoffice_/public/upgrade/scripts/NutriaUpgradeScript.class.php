<?php

/**
 * Nutria upgrade script will upgrade OpenGoo 1.3.1 to OpenGoo 1.4
 *
 * @package ScriptUpgrader.scripts
 * @version 1.4
 * @author Carlos Palma <chonwil@gmail.com>
 */
class NutriaUpgradeScript extends ScriptUpgraderScript {

	/**
	 * Array of files and folders that need to be writable
	 *
	 * @var array
	 */
	private $check_is_writable = array(
		'/config/config.php',
		'/config',
		'/public/files',
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
	 * Construct the NutriaUpgradeScript
	 *
	 * @param Output $output
	 * @return NutriaUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('1.3.1');
		$this->setVersionTo('1.4-beta2');
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
		// ---------------------------------------------------
		//  Connect to database
		// ---------------------------------------------------

		if($this->database_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
			if(mysql_select_db(DB_NAME, $this->database_connection)) {
				$this->printMessage('Upgrade script has connected to the database.');
			} else {
				$this->printMessage('Failed to select database ' . DB_NAME);
				return false;
			} // if
		} else {
			$this->printMessage('Failed to connect to database');
			return false;
		} // if

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

		tpl_assign('table_prefix', TABLE_PREFIX);
		if (defined('DB_ENGINE'))
		tpl_assign('engine', DB_ENGINE);
		else
		tpl_assign('engine', 'InnoDB');

		// ---------------------------------------------------
		//  Check test query
		// ---------------------------------------------------

		$test_table_name = TABLE_PREFIX . 'test_table';
		$test_table_sql = "CREATE TABLE `$test_table_name` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`name` varchar(50) $default_collation NOT NULL default '',
		PRIMARY KEY  (`id`)
		) ENGINE=InnoDB $default_charset;";

		if(@mysql_query($test_table_sql, $this->database_connection)) {
			$this->printMessage('Test query has been executed. Its safe to proceed with database migration.');
			@mysql_query("DROP TABLE `$test_table_name`", $this->database_connection);
		} else {
			$this->printMessage('Failed to executed test query. MySQL said: ' . mysql_error($this->database_connection), true);
			return false;
		} // if

		//return ;

		// ---------------------------------------------------
		//  Execute migration
		// ---------------------------------------------------

		$total_queries = 0;
		$executed_queries = 0;
		$installed_version = installed_version();
		if (version_compare($installed_version, $this->getVersionFrom()) <= 0) {
			// upgrading from a version lower than this script's 'from' version
			$upgrade_script = tpl_fetch(get_template_path('db_migration/1_4_nutria'));
		} else {
			// upgrading from a pre-release of this version (beta, rc, etc)
			$upgrade_script = "
			INSERT INTO `".TABLE_PREFIX."user_ws_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
				('task panel', 'noOfTasks', '8', 'IntegerConfigHandler', '0', '100', NULL),
				('calendar panel', 'start_monday', '', 'BoolConfigHandler', 0, 0, ''),
				('calendar panel', 'show_week_numbers', '', 'BoolConfigHandler', 0, 0, ''),
				('context help', 'show_reporting_panel_context_help', '1', 'BoolConfigHandler', '1', '0', NULL)
			ON DUPLICATE KEY UPDATE id=id;
			UPDATE `".TABLE_PREFIX."user_ws_config_options`
				SET `is_system` = 0 WHERE `name` IN ('start_monday', 'show_week_numbers');
			UPDATE `".TABLE_PREFIX."user_ws_config_categories`
				SET `is_system` = 0 WHERE `name` = 'calendar panel';
			INSERT INTO `".TABLE_PREFIX."config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
				('general', 'show_feed_links', '0', 'BoolConfigHandler', '0', '0', NULL),
				('mailing', 'user_email_fetch_count', '10', 'IntegerConfigHandler', 0, 0, 'How many emails to fetch when checking for email')
			ON DUPLICATE KEY UPDATE id=id;
			ALTER TABLE `".TABLE_PREFIX."custom_properties` ADD COLUMN `visible_by_default` TINYINT(1) NOT NULL DEFAULT 0 AFTER `property_order`;
			ALTER TABLE `".TABLE_PREFIX."custom_property_values` MODIFY COLUMN `value` text $default_collation NOT NULL;
			-- larger contact fields
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `firstname` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `lastname` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `middlename` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `department` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `job_title` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_city` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_state` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_zipcode` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_country` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_phone_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_phone_number2` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_fax_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_assistant_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `w_callback_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_city` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_state` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_zipcode` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_country` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_phone_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_phone_number2` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_fax_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_mobile_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `h_pager_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_city` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_state` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_zipcode` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_country` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_phone_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_phone_number2` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."contacts` MODIFY COLUMN `o_fax_number` varchar(50) $default_collation default NULL;
			
			ALTER TABLE `".TABLE_PREFIX."companies` MODIFY COLUMN `phone_number` varchar(50) $default_collation default NULL;
			ALTER TABLE `".TABLE_PREFIX."companies` MODIFY COLUMN `fax_number` varchar(50) $default_collation default NULL;
			";
		}

		if($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
			$this->printMessage("Database schema transformations executed (total queries: $total_queries)");
		} else {
			$this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
			return false;
		} // if
		
		// ---------------------------------------------------
		//  Add SEED to config file
		// ---------------------------------------------------
		
		$config_file = INSTALLATION_PATH . '/config/config.php';
		$config_lines = file($config_file);
		$new_config = array();
		foreach($config_lines as $line){
			$new_config[] = $line;
			if(trim($line) == "<?php"){
				$new_config[] = "  define('SEED', '".DB_USER.DB_PASS.rand(0,10000000000)."');\n";
			}
		}
		$new_content = join('', $new_config);
		$fp = fopen($config_file, 'w');
		fwrite($fp, $new_content); 

		$this->printMessage('OpenGoo has been upgraded. You are now running OpenGoo '.$this->getVersionTo().' Enjoy!');
	} // execute
} // NutriaUpgradeScript

?>