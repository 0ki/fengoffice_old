<?php

/**
 * Asado upgrade script will upgrade FengOffice 1.7.5 to FengOffice 2.0
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
		$this->setVersionFrom('1.7.5');
		$this->setVersionTo('2.0-beta3');
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
		if (version_compare($installed_version, '1.7.5') <= 0 && TABLE_PREFIX != "fo_") $t_prefix = "fo_";
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
		
		@set_time_limit(0);
		
		if($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
			$this->printMessage("Database schema transformations executed (total queries: $total_queries)");
		} else {
			$this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
			return false;
		}
		
		
		include ROOT . '/environment/classes/AutoLoader.class.php';
		include ROOT . '/environment/constants.php';
		
		if (!$callbacks = spl_autoload_functions()) $callbacks = array();
		foreach ($callbacks as $callback) {
			spl_autoload_unregister($callback);
		}
		spl_autoload_register('feng_upg_autoload');
		foreach ($callbacks as $callback) {
			spl_autoload_register($callback);
		}
		
		include ROOT . '/cache/autoloader.php';
		
		define('DONT_LOG', true);
		define('FORCED_TABLE_PREFIX', 'fo_');
		if (!defined('FILE_STORAGE_FILE_SYSTEM')) define('FILE_STORAGE_FILE_SYSTEM', 'fs');
		if (!defined('FILE_STORAGE_MYSQL')) define('FILE_STORAGE_MYSQL', 'mysql');
		if (!defined('MAX_SEARCHABLE_FILE_SIZE')) define('MAX_SEARCHABLE_FILE_SIZE', 1048576);
		
		try {
			DB::connect(DB_ADAPTER, array(
		      'host'    => DB_HOST,
		      'user'    => DB_USER,
		      'pass'    => DB_PASS,
		      'name'    => DB_NAME,
		      'persist' => DB_PERSIST
			));
			if(defined('DB_CHARSET') && trim(DB_CHARSET)) {
				DB::execute("SET NAMES ?", DB_CHARSET);
			}
		} catch(Exception $e) {
			$this->printMessage("Error connecting to database: ".$e->getMessage()."\n".$e->getTraceAsString());
		}
		
		try {
			$db_result = DB::execute("SELECT value FROM fo_config_options WHERE name = 'file_storage_adapter'");
			$db_result_row = $db_result->fetchRow();
			if($db_result_row['value'] == FILE_STORAGE_FILE_SYSTEM) {
				FileRepository::setBackend(new FileRepository_Backend_FileSystem(FILES_DIR, TABLE_PREFIX));
			} else {
				FileRepository::setBackend(new FileRepository_Backend_DB(TABLE_PREFIX));
			}
		
			PublicFiles::setRepositoryPath(ROOT . '/public/files');
			if (!defined('PUBLIC_FOLDER')) define('PUBLIC_FOLDER', 'public');
			if(trim(PUBLIC_FOLDER) == '') {
				PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'files');
			} else {
				PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'public/files');
			}
			
			$members = Members::findAll(array("conditions" => "`depth` > 1"));
			foreach ($members as $member) { /* @var $member Member */
				$parents = $member->getAllParentMembersInHierarchy();
				$obj_members = ObjectMembers::findAll(array("conditions" => "`is_optimization` = 0 AND `member_id` = ".$member->getId()));
				foreach ($obj_members as $om) {
					foreach ($parents as $parent) {
						$sql = "INSERT INTO ".$t_prefix."object_members (`object_id`, `member_id`, `is_optimization`) 
							VALUES	(".$om->getObjectId().", ".$parent->getId().", 1)
							ON DUPLICATE KEY UPDATE `object_id`=`object_id`";
						DB::execute($sql);
					}
				}
			}
			$this->printMessage("Finished generating Object Members");
			
			
			$sql = "";
			$first_row = true;
					
			$objects = Objects::findAll();
			foreach ($objects as $obj) {/* @var $obj ContentDataObject */
				$cobj = Objects::findObject($obj->getId());
				if ($cobj instanceof ContentDataObject) {
					$cobj->addToSearchableObjects(true);
					$cobj->addToSharingTable();
					
					// add mails to sharing table for account owners
					if ($cobj instanceof MailContent) {
						$macs = MailAccountContacts::findAll(array('conditions' => array('`account_id` = ?', $cobj->getAccountId())));
						$pgs = array();
						foreach ($macs as $mac) {
							$mac_pgs = ContactPermissionGroups::findAll(array("conditions" => "contact_id = ".$mac->getContactId()));
							foreach ($mac_pgs as $mac_pg) $pgs[$mac_pg->getPermissionGroupId()] = $mac_pg->getPermissionGroupId();
						}
						if ($sql == "") $sql = "INSERT INTO fo_sharing_table (group_id, object_id) VALUES ";
						foreach ($pgs as $pgid) {
							$sql .= ($first_row ? "" : ", ") . "($pgid, {$cobj->getId()})";
							$first_row = false;
						}
					}
				}
			}
			// add mails to sharing table for account owners
			if ($sql != "") DB::execute($sql);
			
			$this->printMessage("Searchable Objects & Sharing Table generated");
			
		} catch (Exception $e) {
			die("\nError occurred:\n-----------------\n".$e->getMessage()."\n".$e->getTraceAsString());
		}
		
		$this->printMessage('Feng Office has been upgraded. You are now running Feng Office '.$this->getVersionTo().' Enjoy!');
	} // execute
} // PastafrolaUpgradeScript

?>