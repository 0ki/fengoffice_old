<?php

class AjaxResponse {

	public $events = array();

	public $contents = array();

	public $current = null;

	public $errorCode = 0;

	public $errorMessage = "";
	
	public $notbar = false;
	
	public $contentProperty = "current";

	function __construct() {

	}

	function setEvents($events) {
		$this->events = $events;
	}
	
	function setContentProperty($property) {
		$this->contentProperty = $property;
	}

	function addContent($panel, $type = null, $data = null, $actions = null) {
		$this->contents[$panel] = array(
			"type" => $type,
			"data" => $data
		);
		if (isset($actions)) {
			$this->contents[$panel]["actions"] = $actions;
		}
		if ($this->notbar)
			$this->current["notbar"] = true;
	}

	function setCurrentContent($type, $data = null, $actions = null, $panel = null) {
		$prop = $this->contentProperty;
		if ($type == 'empty') {
			$this->$prop = false;
			return;
		}
		
		if (isset($panel)) {
			$dpanel = $panel;
		} else {
			$dpanel = ajx_get_panel();
		}
		 
		$this->$prop = array(
			"type" => $type,
			"data" => $data,
			"actions" => $actions,
			"panel" => $dpanel,
			"notbar" => $this->notbar
		);
	}
	
	function unsetCurrentContent() {
		$prop = $this->contentProperty;
		$this->$prop = null;
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