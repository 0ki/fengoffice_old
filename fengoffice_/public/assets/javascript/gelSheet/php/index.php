<?php
/*  Gelsheet Project, version 0.0.1 (Pre-alpha)
 *  Copyright (c) 2008 - Ignacio Vazquez, Fernando Rodriguez, Juan Pedro del Campo
 *
 *  Ignacio "Pepe" Vazquez <elpepe22@users.sourceforge.net>
 *  Fernando "Palillo" Rodriguez <fernandor@users.sourceforge.net>
 *  Juan Pedro "Perico" del Campo <pericodc@users.sourceforge.net>
 *
 *  Gelsheet is free distributable under the terms of an GPL license.
 *  For details see: http://www.gnu.org/copyleft/gpl.html
 *
 */
	/**** Scripts that must be included: autoloader is only for objects ****/  
	include_once './config/settings.php'	;
	include_once './util/db_functions.php'	;
	include_once './util/lang/languages.php';
	/***********************************************************************/
	
	/**
	 * Enter description here...
	 *
	 * @param String $classname
	 */
	function __autoload($classname){
		global $cnf ;
		if(isset($cnf['path'][$classname])){
			include_once ($cnf['site']['path']."/". $cnf['path'][$classname]);
		}
		else {
			echo $classname. ": Class don't exist in the config file";
		}
	}

	/**
	 * Takes param from REQUEST..
	 * and makes an array..
	 * Magic Prefix Params (Thanks pepe!)
	 *
	 */
	function splitParameters($param_prefix = "param") {
		$params = array();
		$more_params = true;
		$i=1;
		while($more_params){
			if (isset($_REQUEST[$param_prefix.$i]) ) {				
				$param = $_REQUEST[$param_prefix.$i] ;
				array_push($params,$param);
				$i++;
			}else {
				$more_params = false ;
			}
		}
		return $params;
	}

	$connection  = new Connection();
	$controller = $_REQUEST['c']."Controller";
	$method = $_REQUEST['m'];
	$params = splitParameters("param");

	if (class_exists($controller)) {
		if (method_exists($controller, $method)) {
			$cont = new $controller();
			$php_params = "'". implode("','",$params) . "'";
			eval('$cont->$method('.rawurldecode($php_params).');');
		}
	}

?>