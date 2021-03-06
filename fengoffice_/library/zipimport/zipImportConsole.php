<?php

if ( !defined( 'DIRECTORY_SEPARATOR' ) ) {
	define( 'DIRECTORY_SEPARATOR',
	strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? '\\' : '/'
	) ;
}
define('CONSOLE_MODE', true);
define('APP_ROOT', realpath(dirname(__FILE__) . '/../../'));
define('TEMP_PATH', realpath(APP_ROOT . '/tmp/'));
  
// Include library
require_once APP_ROOT . '/index.php';
require_once APP_ROOT . '/library/zipimport/ZipImport.class.php';
require_once APP_ROOT . '/library/zipimport/ImportLogger.class.php';

ini_set('memory_limit', '256M');

if(!isset($argv) || !is_array($argv)) {
//	die('There is no input arguments');
} // if

/* IMPORT PARAMETERS */

if (isset($argv[1])) {
	$zip_path = $argv[1];
} else {
	ImportLogger::instance()->logError('Missing Parameter: zip file name');
	die('Missing Parameter: zip file name');
}
if (isset($argv[2])) {
	$parentWorkSpace = $argv[2];
} else {
	ImportLogger::instance()->logError('Missing Parameter: parent workspace id');
	die('Missing Parameter: parent workspace id');
}
if (isset($argv[3])) {
	$user_id = $argv[3];
} else {
	ImportLogger::instance()->logError('Missing Parameter: user id');
	die('Missing Parameter: user id');
}
/* ***************** */

	ImportLogger::instance()->log("Init Import ------------------------------------------------------------ \r\n");

	$imp = new ZipImport($parentWorkSpace);
	$imp->extractToTmpDir($zip_path); //APP_ROOT . '/prueba.zip'
	$imp->initUser($user_id);
	$imp->makeWorkSpaces();
	$imp->deleteTmpDir();

	ImportLogger::instance()->log("\r\nEnd Import -------------------------------------------------------------");
?>
