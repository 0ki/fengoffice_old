<?php

/**
 * Help controller
 *
 * @version 1.0
 * @author Carlos Palma <chonwil@gmail.com>
 */
class HelpController extends ApplicationController {
 	
	/* Construct the HelpController
	 *
	 * @access public
	 * @param void
	 * @return HelpController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct
	
	function view_message(){
		
	}
} // HelpController

?>