<?php

  /**
  * EventTypes
  *
  * @author Marcos Saiz <marcos.saiz@gmail.com>
  */
  class EventTypes extends BaseEventTypes {
    
    /**
    * Return Event type object by extension
    *
    * @access public
    * @param void
    * @return EventType
    */
    static function getById($id) {
      return self::findOne(array(
        'conditions' => '`id` = ' . DB::escape($extension)
      )); // findOne
    } // getByExtension
  
  } // EventTypes 

?>