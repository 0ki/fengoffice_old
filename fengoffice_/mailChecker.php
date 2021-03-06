<?php

  if(!version_compare(phpversion(), '5.0', '>=')) {
    die('<strong>Installation error:</strong> in order to run OpenGoo you need PHP5. Your current PHP version is: ' . phpversion());
  } // if
  if(!defined('PUBLIC_FOLDER')) {
    define('PUBLIC_FOLDER', 'public'); // this file can be included through public/index.php
  } // if
  
  
  
  // ---------------------------------------------------
  //  Directories
  // ---------------------------------------------------
  
  define('ROOT', dirname(__FILE__));
  
  define('APPLICATION_PATH', ROOT . '/application');
  define('LIBRARY_PATH',     ROOT . '/library');
  define('FILES_DIR',        ROOT . '/upload'); // place where we will upload project files
  define('CACHE_DIR',        ROOT . '/cache');
  define('THEMES_DIR',       ROOT . '/public/assets/themes');
  
  set_include_path(ROOT . PATH_SEPARATOR . APPLICATION_PATH);
  
  // ---------------------------------------------------
  //  Fix some $_SERVER vars (taken from wordpress code)
  // ---------------------------------------------------
  
  // Fix for IIS, which doesn't set REQUEST_URI
  if(!isset($_SERVER['REQUEST_URI']) || trim($_SERVER['REQUEST_URI']) == '') {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME']; // Does this work under CGI?
    
    // Append the query string if it exists and isn't null
    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
      $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
    } // if
  } // if

  // Fix for PHP as CGI hosts that set SCRIPT_FILENAME to something ending in php.cgi for all requests
  if ( isset($_SERVER['SCRIPT_FILENAME']) && ( strpos($_SERVER['SCRIPT_FILENAME'], 'php.cgi') == strlen($_SERVER['SCRIPT_FILENAME']) - 7 ) ) {
	  $_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];
  } // if

  // Fix for Dreamhost and other PHP as CGI hosts
  if(strstr($_SERVER['SCRIPT_NAME'], 'php.cgi')) unset($_SERVER['PATH_INFO']);
  
  if(trim($_SERVER['PHP_SELF']) == '') $_SERVER['PHP_SELF'] = preg_replace("/(\?.*)?$/",'', $_SERVER["REQUEST_URI"]);
  
  // ---------------------------------------------------
  //  Check if script is installed
  // ---------------------------------------------------
  
  // If script is not installed config.php will return false. Othervise it will
  // return NULL. If we get false redirect to install folder
  if(!include_once(ROOT . '/config/config.php')) {
    print "OpenGoo is not installed. Please redirect your browser to <a href=\"" . PUBLIC_FOLDER . "/install\">" . PUBLIC_FOLDER . "/install</a> folder and follow installation procedure";
    die();
  } // if
  
  // ---------------------------------------------------
  //  config.php + extended config
  // ---------------------------------------------------
  
  define('PRODUCT_NAME', 'OpenGoo');
  if(!defined('PRODUCT_VERSION')) {
    define('PRODUCT_VERSION', '0.5.1');
  } // if
  
  define('MAX_SEARCHABLE_FILE_SIZE', 1048576); // if file type is searchable script will load its content into search index. Using this constant you can set the max filesize of the file that will be imported. Noone wants 500MB in search index for single file
  define('SESSION_LIFETIME', 3600);
  define('REMEMBER_LOGIN_LIFETIME', 1209600); // two weeks
  
  // Defaults
  define('DEFAULT_CONTROLLER', 'dashboard');
  define('DEFAULT_ACTION', 'index');
  define('DEFAULT_THEME', 'default');
  
  // Default cookie settings...
  define('COOKIE_PATH', '/');
  define('COOKIE_DOMAIN', '');
  define('COOKIE_SECURE', false);
  
  define('SLIMEY_PATH', ROOT_URL . '/public/assets/javascript/slimey/');
  
  // ---------------------------------------------------
  //  Init...
  // ---------------------------------------------------
  
  include_once 'environment/environment.php';
  
  // Lets prepare everything for autoloader
  require APPLICATION_PATH . '/functions.php'; // __autoload() function is defined here...
  @include ROOT . '/cache/autoloader.php';
  
  // Prepare logger... We might need it early...
  if(!Env::isDebugging()) {
    Logger::setSession(new Logger_Session('default'));
    Logger::setBackend(new Logger_Backend_File(CACHE_DIR . '/log.php'));
     
    set_error_handler('__production_error_handler');
    set_exception_handler('__production_exception_handler');
  } // if
  
  register_shutdown_function('__shutdown');
  
  // Connect to database...
  try {
    DB::connect(DB_ADAPTER, array(
      'host'    => DB_HOST,
      'user'    => DB_USER,
      'pass'    => DB_PASS,
      'name'    => DB_NAME,
      'persist' => DB_PERSIST
    )); // connect
    if(defined('DB_CHARSET') && trim(DB_CHARSET)) {
      DB::execute("SET NAMES ?", DB_CHARSET);
    } // if
  } catch(Exception $e) {
    if(Env::isDebugging()) {
      Env::dumpError($e);
    } else {
      Logger::log($e, Logger::FATAL);
      Env::executeAction('error', 'db_connect');
    } // if
  } // try
  
  // Init application
  if(Env::isDebugging()) {
    benchmark_timer_set_marker('Init application');
  } // if
  
  define('FILE_STORAGE_FILE_SYSTEM', 'fs');
  define('FILE_STORAGE_MYSQL', 'mysql');
  
  // Init flash!
  Flash::instance();
  MailUtilities::getmails();
		
  tpl_display(APPLICATION_PATH . "/views/cron/getmails.php");
  
?>