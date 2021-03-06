<?php

define('SWIFTMAILER_LIBRARY_PATH', dirname(__FILE__));
require SWIFTMAILER_LIBRARY_PATH . '/lib/Swift.php';
require SWIFTMAILER_LIBRARY_PATH . '/lib/Swift/Connection/SMTP.php';
require SWIFTMAILER_LIBRARY_PATH . '/lib/Swift/Connection/NativeMail.php';


class SwiftLogger implements Swift_IPlugin {

	public $pluginName = 'SwiftLogger';
	
	protected $swift = null;

	public function loadBaseObject(&$object) {
		$this->swift = $object;
	}

	public function onLog() {
		if (defined('LOG_SWIFT') && LOG_SWIFT) {
			Logger::log("Swift Comm: " . $this->swift->lastTransaction['command']);
			Logger::log("Swift Resp: " . $this->swift->lastTransaction['response']);
		}
	}

	public function onError() {
		Logger::log("Swift Err: " . $this->swift->lastError);
	}
}

?>