<?php

/**
 * Main application file. Use this file to register new classes to auto loader
 * service, define application level constants, init specific application
 * resources etc
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */

define('FILE_STORAGE_FILE_SYSTEM', 'fs');
define('FILE_STORAGE_MYSQL', 'mysql');

// Init flash!
Flash::instance();
include_once APPLICATION_PATH . '/functions.php';
try {
	CompanyWebsite::init();
	// if two days since last upgrade check => check for upgrades
	$lastUpgradeCheck = config_option('upgrade_last_check_datetime', 0);
	if ($lastUpgradeCheck instanceof DateTimeValue) $lastUpgradeCheck = $lastUpgradeCheck->getTimestamp();
	if ($lastUpgradeCheck < DateTimeValueLib::now()->getTimestamp() - 60*60*24*2) {
		VersionChecker::check(true);
	}
	$locale = user_config_option("localization", DEFAULT_LOCALIZATION);
	Localization::instance()->loadSettings($locale, ROOT . '/language');

	if(config_option('file_storage_adapter', 'mysql') == FILE_STORAGE_FILE_SYSTEM) {
		FileRepository::setBackend(new FileRepository_Backend_FileSystem(FILES_DIR));
	} else {
		FileRepository::setBackend(new FileRepository_Backend_MySQL(DB::connection()->getLink(), TABLE_PREFIX));
	} // if

	PublicFiles::setRepositoryPath(ROOT . '/public/files');
	if(trim(PUBLIC_FOLDER) == '') {
		PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'files');
	} else {
		PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'public/files');
	} // if

	// Owner company or administrator doen't exist? Let the user create them
} catch(OwnerCompanyDnxError $e) {
	Localization::instance()->loadSettings(DEFAULT_LOCALIZATION, ROOT . '/language');
	Env::executeAction('access', 'complete_installation');
} catch(AdministratorDnxError $e) {
	Localization::instance()->loadSettings(DEFAULT_LOCALIZATION, ROOT . '/language');
	Env::executeAction('access', 'complete_installation');

	// Other type of error? We need to break here
}  catch(Exception $e) {
	Localization::instance()->loadSettings(DEFAULT_LOCALIZATION, ROOT . '/language');
	if(Env::isDebugging()) {
		Env::dumpError($e);
	} else {
		Logger::log($e, Logger::FATAL);
		Env::executeAction('error', 'system');
	} // if
} // try

?>