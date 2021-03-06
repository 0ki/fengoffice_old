<?php

  /**
  * ObjectReminders, generated on Mon, 29 May 2006 03:51:15 +0200 by 
  * DataObject generation tool
  *
  * @author Ignacio de Soto <ignacio.desoto@opengoo.org>
  */
  class ObjectReminders extends BaseObjectReminders {
  
    /**
    * Return array of users that are subscribed to this specific message
    *
    * @param ProjectDataObject $message
    * @return array
    */
    static function getUsersByObject(ProjectDataObject $object) {
      $users = array();
      $Reminders = ObjectReminders::findAll(array(
        'conditions' => '`object_id` = ' . DB::escape($object->getId()) .
        		' AND `object_manager` = ' . DB::escape(get_class($object->manager()))
      )); // findAll
      if(is_array($Reminders)) {
        foreach($Reminders as $Reminder) {
          $user = $Reminder->getUser();
          if($user instanceof User) $users[] = $user;
        } // foreach
      } // if
      return count($users) ? $users : null;
    } // getUsersByMessage
    
    /**
    * Return array of objects that $user is subscribed to
    *
    * @param User $user
    * @return array
    */
    static function getObjectsByUser(User $user) {
      $objects = array();
      $Reminders = ObjectReminders::findAll(array(
        'conditions' => '`user_id` = ' . DB::escape($user->getId())
      )); // findAll
      if(is_array($Reminders)) {
        foreach($Reminders as $Reminder) {
          $object = $Reminder->getObject();
          if($object instanceof ProjectDataObject) $objects[] = $object;
        } // foreach
      } // if
      return $objects;
    } // getObjectsByUser
    
    /**
    * Clear Reminders by object
    *
    * @param ProjectDataObject $message
    * @return boolean
    */
    static function clearByObject(ProjectDataObject $object) {
      return ObjectReminders::delete(
      		'`object_id` = ' . DB::escape($object->getId()) .
      		' AND `object_manager` = ' . DB::escape(get_class($object->manager()))
      );
    } // clearByObject
    
    /**
    * Clear Reminders by user
    *
    * @param User $user
    * @return boolean
    */
    static function clearByUser(User $user) {
      return ObjectReminders::delete('`user_id` = ' . DB::escape($user->getId()));
    } // clearByUser
    
  } // ObjectReminders 

?>