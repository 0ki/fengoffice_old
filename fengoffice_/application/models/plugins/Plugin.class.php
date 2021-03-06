<?php

/**
 * Plugin class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class Plugin extends BasePlugin {
	var $systemName = null ;
	
	function getSystemName(){
		if (!$this->systemName) {
			$this->systemName =  str_replace(
				array(' ', '-','ñ','á','é','í','ó','ú','.'), 
				array('_'. '_','n','a','e','i','o','u',''), 
				strtolower($this->getName())
			);
		}
		return $this->systemName ;
	}
	
	
	/**
	 * Returns the path of the controller folder 
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function getControllerPath() {
		return ROOT."/plugins/".$this->getSystemName()."/application/controllers/" ;
	}
	
	
	/**
	 * Returns the path of the plugin folder  
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function getHooksPath() {
		return ROOT."/plugins/".$this->getSystemName()."/hooks/" ;
	}
	

	
	
	/**
	 * Returns the path to the view folder 
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function getViewPath() {
		return ROOT."/plugins/".$this->getSystemName()."/application/views/" ;
	}
	
	
	/**
	 * 
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function getLanguagePath() {
		return PLUGIN_PATH . "/" .$this->getSystemName()."/language" ;
	}
	
}