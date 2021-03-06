<?php 

class PluginController extends ApplicationController {

	
	
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website'); 
	}
	
	
	function installPlugins($pluginIds = null ) {
		
		
		if (is_array($pluginIds)){
			foreach ($pluginIds as $id) {
				// Check if is not currently installed
				if ($plg = Plugins::instance()->findOne()){
					/* @var $plg Plugin */
					if ( !$plg->getIsInstalled() ) {
						$plg->install() ;
						$plg->activate() ;
					}
				}
				
			}
		}
		//Plugins::instance()->findAll(array(""));	
		
			
		
	}

}

