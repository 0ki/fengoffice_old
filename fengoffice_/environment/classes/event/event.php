<?php

/**
 * Add an event
 *
 * @param string $name
 * @param unknown_type $data
 */
function evt_add($name, $data) {
	Event::instance()->addEvent($name, $data);
}

/**
 * Returns the events
 *
 * @return array
 */
function evt_list() {
	return Event::instance()->getEvents();
}

?>