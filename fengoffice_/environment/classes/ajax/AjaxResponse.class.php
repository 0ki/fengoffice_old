<?php

class AjaxResponse {

	public $events = array();

	public $contents = array();

	public $current = null;

	public $errorCode = 0;

	public $errorMessage = "";

	function __construct() {

	}

	function setEvents($events) {
		$this->events = $events;
	}

	function addContent($panel, $type, $data, $actions) {
		$this->contents[$panel] = array(
			"type" => $type,
			"data" => $data
		);
		if (isset($actions)) {
			$this->contents[$panel]["actions"] = $actions;
		}
	}

	function setCurrentContent($type, $data, $actions, $panel) {
		if ($type == 'empty') {
			$this->current = false;
			return;
		}
		$this->current = array(
			"type" => $type,
			"data" => $data
		);
		if (isset($actions)) {
			$this->current["actions"] = $actions;
		}
		if (isset($panel)) {
			$this->current["panel"] = $panel;
		} else {
			$this->current["panel"] = ajx_get_panel();
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