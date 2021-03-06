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
require_once("config/settings.php");

/**
 * Estructura de la Coneccion, mantiene la coneccion con la base
 * de datos
 */

if (! class_exists("Connection") ) { 

class Connection{

	/**
	 * Constructor.
	 * Conecta con la base de datos
	 */
	public function __construct($host=null, $user=null, $pwd=null,$schema=null){
		global $cnf;
		//TODO: Sacar por los por defecto
		/*$this->host 	= 'localhost';
		$this->user 	= 'opengoo';
		$this->password = 'opengoo';
		$this->schema 	= 'excel';
		*/
		
		$this->host = $cnf['db']['url'] ;
		$this->user = $cnf['db']['user'] ;
		$this->password = $cnf['db']['pass'];
		$this->schema 	= $cnf['db']['name'];
		
		
		if(isset($host))
			$this->host = $host;
		if(isset($user))
			$this->user = $user;
		if(isset($pwd))
			$this->password = $pwd;
		if(isset($schema))
			$this->schema = $schema;
		$this->connect();
	}

	/**
	 * Destructor.
	 * Desconecta la conexion activa.
	 */
	public function __destruct(){
		$this->disconnect();
	}
 

	/**
	 * Conecta con la base de datos
	 */
	public function connect(){
		$this->enlace = mysql_connect($this->host, $this->user, $this->password);
		if (!$this->enlace)
    		die('Could not connect: ' . mysql_error());
    	mysql_select_db($this->schema) or die('No pudo seleccionarse la BD.');
	}

	/**
	 * Cierra la conexion
	 */
	public function disconnect(){
		if($this->enlace)
			mysql_close($this->enlace);
	}
	 /**  Setea la base de datos de la conecion
	 */
	public function setSchema($schema){
		$this->schema = $schema;
	}

	/**
	 * Retorna el host de la coneccion
	 */
	public function getSchema(){
		return $this->schema;
	}

	 /**
	  *  Setea el host de la conecion
	 */
	public function setHost($host){
		$this->host = $host;
	}

	/**
	 * Retorna el host de la coneccion
	 */
	public function getHost(){
		return $this->host;
	}

	 /**
	  *  Setea el Usuario de la coneccion
	 */
	public function setUser($user){
		$this->user = $user;
	}

	/**
	 * Retorna el Usuario de la coneccion
	 */
	public function getUser(){
		return $this->user;
	}
 	/**
	  *  Setea el password de la coneccion
	 */
	public function setPassword($password){
		$this->password = $password;
	}


	/**
	 * Retorna el host de la coneccion
	 */
	public function getPassword(){
		return $this->password;
	}

	/**
	 * Setea la cadena de error
	 */
	public function setError($error){
		$this->strError = $error;
	}

	/**
	 * Retorna el ultimo error registrado
	 */
	public function getError(){
		return $this->strError;
	}

}
}
?>
