<?php

class Event {
	
	private $events = array();

	/**
	 * Add an event
	 *
	 * @param string $name
	 * @param unknown $data
	 */
	function addEvent($name, $data) {
		$this->events[] = array(
			"name" => $name,
			"data" => $data
		);
	}
	
	/**
	 * Get the events
	 *
	 * @return array
	 */
	function getEvents() {
		return $this->events;
	}
	
	/**
    * Return event service instance
    *
    * @param void
    * @return Event
    */
    function instance() {
      static $instance;
      if (!instance_of($instance, 'Event')) $instance = new Event();
      return $instance;
    } // instance
}

?>