<?php

function log_wd($msg) {
	$msg = print_r($msg,1);
	file_put_contents(dirname(__FILE__)."/log.txt", date("H:i:s")." - $msg\n", FILE_APPEND);
}

use Sabre\DAV;
use Sabre\DAV\Auth;

$this_dir = dirname(__FILE__);
$plugin_dir = "/plugins/webdav";
// The autoloader
require_once $this_dir.$plugin_dir.'/library/SabreDAV/vendor/autoload.php';
// Wrappers
require_once $this_dir.$plugin_dir.'/connector/WebDAVDirectory.class.php';
require_once $this_dir.$plugin_dir.'/connector/WebDAVFile.class.php';
require_once $this_dir.$plugin_dir.'/connector/FengWebDavAuth.php';
require_once $this_dir.$plugin_dir.'/connector/WebDAVEventsHandler.php';

chdir($this_dir);
//chdir($this_dir."/../..");
define("CONSOLE_MODE", true);
define('PUBLIC_FOLDER', 'public');
require_once "init.php";

//chdir($this_dir);

Env::useHelper('webdav_member_functions', 'webdav');
Env::useHelper('webdav_file_functions', 'webdav');
Env::useHelper('permissions');


// Now we're creating a whole bunch of objects
$rootDirectory = new WebDAVDirectory('/');

// The server object is responsible for making sense out of the WebDAV protocol
$server = new DAV\Server($rootDirectory);

// If your server is not on your webroot, make sure the following line has the correct information
// set base dir
$basedir = str_replace("\\", "/", ROOT);
$basedir = str_replace($_SERVER['DOCUMENT_ROOT'], "", $basedir);
//$server->setBaseUri($basedir."/plugins/webdav/server.php");
$server->setBaseUri($basedir."/server.php");

// The lock manager is reponsible for making sure users don't overwrite
// each others changes.
$lockBackend = new DAV\Locks\Backend\File('cache/webdav_locks');
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);

// This ensures that we get a pretty index in the browser, but it is
// optional.
$server->addPlugin(new DAV\Browser\Plugin());

// Authentication plugin
$authBackend = new FengWebDavAuth();
$authBackend->setRealm('SabreDAV');
$authPlugin = new Auth\Plugin($authBackend);

// Adding the plugin to the server.
$server->addPlugin($authPlugin);

// Add override events plugin 
$eventsPlugin = new WebDAVEventsHandler();
$server->addPlugin($eventsPlugin);

// All we need to do now, is to fire up the server
$server->exec();

?>