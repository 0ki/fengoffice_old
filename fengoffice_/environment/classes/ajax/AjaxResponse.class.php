<?php

class AjaxResponse {

	public $events = array();

	public $contents = array();

	public $current = null;

	public $errorCode = 0;

	public $errorMessage = "";
	
	public $notbar = false;
	
	public $preventClose = false;
	
	public $replace = false;
	
	function __construct() {

	}

	function setEvents($events) {
		$this->events = $events;
	}
	
	function addContent($panel, $type = null, $data = null, $actions = null, $notbar = null, $preventClose = null) {
		$this->contents[$panel] = array(
			"type" => $type,
			"data" => $data
		);
		if (isset($actions)) {
			$this->contents[$panel]["actions"] = $actions;
		}
		if (isset($notbar)) {
			$this->contents[$panel]["notbar"] = $notbar;
		}
		if (isset($preventClose)) {
			$this->contents[$panel]["preventClose"] = $preventClose;
		}
	}

	function setCurrentContent($type, $data = null, $actions = null, $panel = null) {
		if ($type == 'empty') {
			$this->current = false;
			return;
		}
		
		if (isset($panel)) {
			$dpanel = $panel;
		} else {
			$dpanel = ajx_get_panel();
		}
		 
		$this->current = array(
			"type" => $type,
			"data" => $data,
			"actions" => $actions,
			"panel" => $dpanel,
			"notbar" => $this->notbar,
			"preventClose" => $this->preventClose,
			"replace" => $this->replace,
		);
		if ($type == 'html') {
			$this->current["url"] = "index.php?" . $_SERVER['QUERY_STRING'];
		}
	}
	
	function unsetCurrentContent() {
		$this->current = null;
	}
	
	/**
	 * Adds attributes other than the default (errorCode, events, current, etc.)
	 * @access public
	 * @param array
	 */
	function addExtraData($data) {
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$this->$k = $v;
			}
		}
	}
	
	function hasCurrent() {
		return $this->current !== null;
	}

	function setError($errorCode, $errorMessage) {
		$this->errorCode = $errorCode;
		$this->errorMessage = $errorMessage;
	}

	/**
	 * Return AjaxResponse instance
	 *
	 * @access public
	 * @param void
	 * @return AjaxResponse
	 */
	static function &instance() {
		static $instance;

		// Check instance...
		if(!instance_of($instance, 'AjaxResponse')) {
			$instance = new AjaxResponse();
		} // if

		// Return instance...
		return $instance;

	} // end func instance


}

?>