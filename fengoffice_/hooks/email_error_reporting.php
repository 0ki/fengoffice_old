<?php
Hook::register('email_error_reporting');

define('EMAIL_ERRORS_LOGFILE', '/datos/email_errors/email_errors_log');

$dirname = substr(EMAIL_ERRORS_LOGFILE, 0, strrpos(EMAIL_ERRORS_LOGFILE, '/'));
if (is_dir($dirname)) {
	
	function fatal_handler() {
		$error = error_get_last();
		if( $error !== NULL) {
			
			if (strpos($error["file"], "swift") !== FALSE) {
				file_put_contents(EMAIL_ERRORS_LOGFILE, ROOT_URL."\n".print_r($error, 1), FILE_APPEND);
			}
		}
	}
	register_shutdown_function( "fatal_handler" );
}