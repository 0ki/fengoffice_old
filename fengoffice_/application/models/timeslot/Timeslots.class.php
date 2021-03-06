<?php

/**
 * class Timeslots
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class Timeslots extends BaseTimeslots {

	/**
	 * Return object timeslots
	 *
	 * @param ProjectDataObject $object
	 * @return array
	 */
	static function getTimeslotsByObject(ProjectDataObject $object, User $user = null) {
		$userCondition = '';
		if ($user)
		$userCondition = ' and `user_id` = '. $user->getId();

		return self::findAll(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ?' . $userCondition, $object->getObjectId(), get_class($object->manager())),
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject
	
	static function getOpenTimeslotByObjectAndUser(ProjectDataObject $object, User $user) {
		$userCondition = ' and `user_id` = '. $user->getId();

		return self::findOne(array(
          'conditions' => array('`object_id` = ? AND `object_manager` = ? AND `end_time`= ? ' . $userCondition, $object->getObjectId(), get_class($object->manager()), EMPTY_DATETIME), 
          'order' => '`start_time`'
          )); // array
	} // getTimeslotsByObject

	/**
	 * Return number of timeslots for specific object
	 *
	 * @param ProjectDataObject $object
	 * @return integer
	 */
	static function countTimeslotsByObject(ProjectDataObject $object, User $user = null) {
		$userCondition = '';
		if ($user)
		$userCondition = ' and `user_id` = '. $user->getId();

		return self::count(array('`object_id` = ? AND `object_manager` = ?' . $userCondition, $object->getObjectId(), get_class($object->manager())));
	} // countTimeslotsByObject

	/**
	 * Drop timeslots by object
	 *
	 * @param ProjectDataObject
	 * @return boolean
	 */
	static function dropTimeslotsByObject(ProjectDataObject $object) {
		return self::delete(array('`object_manager` = ? AND `object_id` = ?', get_class($object->manager()), $object->getObjectId()));
	} // dropTimeslotsByObject

} // Comments

?>