<?php

/**
 * Asado upgrade script will upgrade FengOffice 2.0-beta to FengOffice 2.0
 *
 * @package ScriptUpgrader.scripts
 * @version 1.1
 * @author Alvaro Torterola <alvaro.torterola@fengoffice.com>
 */
class AsadoUpgradeScript extends ScriptUpgraderScript {

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
	 * Construct the PastafrolaUpgradeScript
	 *
	 * @param Output $output
	 * @return PastafrolaUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('2.0-beta');
		$this->setVersionTo('2.0-beta2');
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
		//if (version_compare($installed_version, '1.7.5') <= 0 && TABLE_PREFIX != "fo_") $t_prefix = "fo_";
		tpl_assign('table_prefix', $t_prefix);
		
		if (defined('DB_ENGINE')) tpl_assign('engine', DB_ENGINE);
		else tpl_assign('engine', 'InnoDB');

		// ---------------------------------------------------
		//  Execute migration
		// ---------------------------------------------------
		
		// RUN QUERIES
		$total_queries = 0;
		$executed_queries = 0;
		
		if (version_compare($installed_version, $this->getVersionFrom()) <= 0) {
			// upgrading from a version lower than this script's 'from' version
			$upgrade_script = tpl_fetch(get_template_path('db_migration/2_0_asado'));
		} else {
			// upgrading from a pre-release of this version (beta, rc, etc)
			$upgrade_script = "";
		}
		
		if($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
			$this->printMessage("Database schema transformations executed (total queries: $total_queries)");
		} else {
			$this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
			return false;
		}
		
		$this->printMessage('Feng Office has been upgraded. You are now running Feng Office '.$this->getVersionTo().' Enjoy!');
	} // execute
} // PastafrolaUpgradeScript

?>