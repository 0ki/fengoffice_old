<?php

/**
 * Figazza upgrade script will upgrade OpenGoo 1.4.2 to OpenGoo 1.5-beta2
 *
 * @package ScriptUpgrader.scripts
 * @version 1.1
 * @author Ignacio de Soto <ignacio.desoto@opengoo.org>
 */
class FigazzaUpgradeScript extends ScriptUpgraderScript {

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
	 * Construct the FigazzaUpgradeScript
	 *
	 * @param Output $output
	 * @return FigazzaUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('1.4.2');
		$this->setVersionTo('1.5-beta2');
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
		
		// RUN QUERIES
		$total_queries = 0;
		$executed_queries = 0;
		$installed_version = installed_version();
		if (version_compare($installed_version, $this->getVersionFrom()) <= 0) {
			// upgrading from a version lower than this script's 'from' version
			$upgrade_script = tpl_fetch(get_template_path('db_migration/1_5_figazza'));
		} else {
			// upgrading from a pre-release of this version (beta, rc, etc)
			$upgrade_script = "";
		}

		if($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
			$this->printMessage("Database schema transformations executed (total queries: $total_queries)");
		} else {
			$this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
			return false;
		} // if
		
		// UPGRADE CUSTOM PROPERTY MULTIPLE VALUES
		if (version_compare($installed_version, $this->getVersionFrom()) <= 0) {
			$res = mysql_query("SELECT * FROM `".TABLE_PREFIX."custom_property_values` WHERE `custom_property_id` IN (SELECT `id` FROM `".TABLE_PREFIX."custom_properties` WHERE `is_multiple_values` = 1)");
			while ($row = mysql_fetch_assoc($res)) {
				$id = $row['id'];
				$cid = $row['custom_property_id'];
				$oid = $row['object_id'];
				$value = $row['value'];
				$values = explode(",", $value);
				$valuestrings = array();
				foreach ($values as $val) {
					$valuestrings[] = "($oid, $cid, '$val')";
				}
				$valuestring = implode(",", $valuestrings);
				mysql_query("INSERT INTO `".TABLE_PREFIX."custom_property_values` (`object_id`, `custom_property_id`, `value`) VALUES $valuestring");
				mysql_query("DELETE FROM `".TABLE_PREFIX."custom_property_values` WHERE `id` = $id");
			}
		}
		
		// UPGRADE PUBLIC FILES
		if (version_compare($installed_version, $this->getVersionFrom()) <= 0) {
			// load FileRepository classes
			include_once ROOT . "/library/filerepository/FileRepository.class.php";
			include_once ROOT . "/library/filerepository/errors/FileNotInRepositoryError.class.php";
			include_once ROOT . "/library/filerepository/errors/FileRepositoryAddError.class.php";
			include_once ROOT . "/library/filerepository/errors/FileRepositoryDeleteError.class.php";
			include_once ROOT . "/library/filerepository/backend/FileRepository_Backend.class.php";
			$res = mysql_query("SELECT `value` FROM `".TABLE_PREFIX."config_options` WHERE `name` = 'file_storage_adapter'");
			$row = mysql_fetch_assoc($res);
			$adapter = $row['value'];
			if ($adapter == 'mysql') {
				include_once ROOT . "/library/filerepository/backend/FileRepository_Backend_MySQL.class.php";
				FileRepository::setBackend(new FileRepository_Backend_MySQL($this->database_connection, TABLE_PREFIX));
			} else {
				include_once ROOT . "/library/filerepository/backend/FileRepository_Backend_FileSystem.class.php";
				FileRepository::setBackend(new FileRepository_Backend_FileSystem(ROOT . "/upload", $this->database_connection, TABLE_PREFIX));
			}
			$res = mysql_query("SELECT `id`, `avatar_file` FROM `".TABLE_PREFIX."users` WHERE `avatar_file` <> ''", $this->database_connection);
			$count = 0;
			while ($row = mysql_fetch_assoc($res)) {
				$avatar = $row['avatar_file'];
				$id = $row['id'];
				$path = ROOT . "/public/files/$avatar";
				if (is_file($path)) {
					$fid = FileRepository::addFile($path, array('type' => 'image/png'));
					mysql_query("UPDATE `".TABLE_PREFIX."users` SET `avatar_file` = '$fid' WHERE `id` = $id", $this->database_connection);
					$count++;
				}
			}
			$res = mysql_query("SELECT `id`, `picture_file` FROM `".TABLE_PREFIX."contacts` WHERE `picture_file` <> ''", $this->database_connection);
			while ($row = mysql_fetch_assoc($res)) {
				$picture = $row['picture_file'];
				$id = $row['id'];
				$path = ROOT . "/public/files/$picture";
				if (is_file($path)) {
					$fid = FileRepository::addFile($path, array('type' => 'image/png'));
					mysql_query("UPDATE `".TABLE_PREFIX."contacts` SET `picture_file` = '$fid' WHERE `id` = $id", $this->database_connection);
					$count++;
				}
			}
			$res = mysql_query("SELECT `id`, `logo_file` FROM `".TABLE_PREFIX."companies` WHERE `logo_file` <> ''", $this->database_connection);
			while ($row = mysql_fetch_assoc($res)) {
				$logo = $row['logo_file'];
				$id = $row['id'];
				$path = ROOT . "/public/files/$logo";
				if (is_file($path)) {
					$fid = FileRepository::addFile($path, array('type' => 'image/png'));
					mysql_query("UPDATE `".TABLE_PREFIX."companies` SET `logo_file` = '$fid' WHERE `id` = $id", $this->database_connection);
					$count++;
				}
			}
			$this->printMessage("$count public files migrated to upload directory.");
		}
		
		$this->printMessage('OpenGoo has been upgraded. You are now running OpenGoo '.$this->getVersionTo().' Enjoy!');
	} // execute
} // FigazzaUpgradeScript

?>