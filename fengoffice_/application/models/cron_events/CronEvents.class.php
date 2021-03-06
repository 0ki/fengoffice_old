<?php

/**
 * CronEvents
 *
 * @author Ignacio de Soto <ignacio.desoto@opengoo.org>
 */
class CronEvents extends BaseCronEvents {

	function getDueEvents($date = null) {
		if (!$date instanceof DateTimeValue) $date = DateTimeValueLib::now();
		$events = self::findAll(array(
			'conditions' => array(
				'`date` <= ?',
				$date
			)
		));
		if (!is_array($events)) return array();
		return $events;
	}
	
	function getUserEvents() {
		return self::findAll(array(
			'conditions' => array(
				'`is_system` = ?',
				false
			)
		));
	}
	
} // CronEvents

?>