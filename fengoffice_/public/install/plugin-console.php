<?php
$argv or die("Are you using console ? \n");
$usage = "USAGE: plugin-console.php COMMAND [list, install, activate, deactivate, update] PLUGIN_NAME \n" ;
chdir(dirname(__FILE__) . '/../..');
define("CONSOLE_MODE", true);
define("PLUGIN_MANAGER_CONSOLE", true );
require_once 'init.php';

if(!isset($argv) || !is_array($argv)) {
	die("There is no input arguments\n");
} // if

$command = array_var($argv, 1);
$arg1 = array_var($argv, 2);
$usr = Contacts::findOne(array("conditions"=>"user_type = 1"));
$usr or die("User not found\n");
CompanyWebsite::instance()->logUserIn($usr);

$ctrl = new PluginController();
trim($command) or die("Command is required \n".$usage);

if ($command == 'list' ) {
	foreach ($ctrl->index() as $plg){
		/* @var $plg Plugin */
		echo "---------------------------------------------\n";
		echo "NAME: \t\t".$plg->getSystemName() ."\n" ;
		echo "VERSION: \t".$plg->getVersion() ."\n"  ;
		echo "STATUS: \t".( ($plg->isInstalled())?'Installed ':'Uninstalled ' ).( ($plg->isActive())?'Activated ':'Inactive ' ) ."\n";

		if ( $plg->updateAvailable() ) {
			echo "*** There is a new version of this plugin *** \n";
		}
	}
}else{
	$arg1 or die("Plugin is required \n$usage");
	$plg = Plugins::instance()->findOne(array("conditions"=>" name = '$arg1'"));
	$plg or die("ERROR: plugin $arg1 not found\n");
	
	switch($command) {
		case 'update':
			$ctrl->update($plg->getId());
			break;
		case 'install':
			$ctrl->install($plg->getId());
			break;
		case 'activate':
			$plg->activate();
			break;
		case 'deactivate':
			$plg->deactivate();
			break;
		case 'uninstall':
			$ctrl->uninstall($plg->getId());
			break;
		default:
			die("Invalid command \n$usage");
			break;	
	}
	
}

echo "\n";