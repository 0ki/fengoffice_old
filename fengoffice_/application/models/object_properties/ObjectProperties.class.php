<?php

  /**
  *   ObjectProperty class
  * Written on Tue, 27 Oct 2007 16:53:08 -0300
  *
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  class  ObjectProperties extends  BaseObjectProperties {

        
    /**
    * Reaturn all properties that an object has
    *
    * @param PrjectDataObject $obj
    * @return array
    */
    static function getAllPropertiesByObject(ProjectDataObject $obj) {
      return self::findAll(array(
        'conditions' => array("`rel_object_id` = ? and `rel_object_manager` = ?", $obj->getId(), get_class($obj->manager()))
        
      )); // findAll
    } //  getAllPropertiesByObject
        
    /**
    * Return one property, given the object and the property name
    *
    * @param PrjectDataObject $obj
    * @param String $property_name
    * @return array
    */
    static function getPropertyByName(ProjectDataObject $obj, $property_name) {
      return self::findOne(array(
        'conditions' => array("`rel_object_id` = ? and `rel_object_manager` = ? and `name` = '?' ",
        				 $obj->getId(), get_class($obj->manager()), $property_name)
      )); // findAll
    } //  getProperty
        
    /**
    * Return one property given the id
    *
    * @param int $prop_id
    * @return array
    */
    static function getProperty($prop_id) {
      return self::findOne(array(
        'conditions' => array("`id` = ? ", $prop_id)
      )); // findOne
    } //  getProperty
        
    /**
    * Return one property given, the object and the property name
    *
    * @param PrjectDataObject $obj
    * @param String $property_name
    * @return array
    */
    static function getAllProperties(ProjectDataObject $obj, $property_name) {
      return self::findAll(array(
        'conditions' => array("`rel_object_id` = ? and `rel_object_manager` = ? and `name` = '?' ",
        				 $obj->getId(), get_class($obj->manager()), $property_name)
      )); // findAll
    } //  getAllProperties
    
    static function deleteAllByObject(ProjectDataObject $object){
    	return self::delete('`rel_object_id` = '.$object->getId()." and `rel_object_manager` = '" . get_class($object->manager()) . "'");      
    }
  
  } // ObjectProperties

?>