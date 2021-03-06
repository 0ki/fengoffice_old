<?php

class AjaxResponse {

	public $events = array();
	
	public $scripts = array();

	public $contents = null;

	public $current = null;

	public $errorCode = 0;

	public $errorMessage = "";
		
	function __construct() {
		$this->contents = new stdClass();
	}

	function setEvents($events) {
		$this->events = $events;
	}
	
	function addScript($url) {
		$this->scripts[] = is_valid_url($url) ? $url : get_javascript_url($url);
	}
	
	function addContent($panel, $type = null, $data = null, $actions = null, $notbar = null, $preventClose = null, $noback = null) {
		$this->contents->$panel = array(
			"type" => $type,
			"data" => $data
		);
		if (isset($actions)) {
			$this->contents->$panel["actions"] = $actions;
		}
		if (isset($notbar)) {
			$this->contents->$panel["notbar"] = $notbar;
		}
		if (isset($noback)) {
			$this->contents->$panel["noback"] = $noback;
		}
		if (isset($preventClose)) {
			$this->contents->$panel["preventClose"] = $preventClose;
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
			$dpanel = array_var($_GET, 'current', "");
		}
		 
		$this->current = array(
			"type" => $type,
			"data" => $data,
			"actions" => $actions,
			"panel" => $dpanel,
		);
		// extra current content config
		if (isset($this->notbar)) {
			$this->current["notbar"] = $this->notbar;
			unset($this->notbar);
		}
		if (isset($this->preventClose)) {
			$this->current["preventClose"] = $this->preventClose;
			unset($this->preventClose);
		}
		if (isset($this->replace)) {
			$this->current["replace"] = $this->replace;
			unset($this->replace);
		}
		if (isset($this->noback)) {
			$this->current["noback"] = $this->noback;
			unset($this->noback);
		}
		if (isset($this->onleave)) {
			$this->current["onleave"] = $this->onleave;
			unset($this->onleave);
		}
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