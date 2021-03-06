<?php

  /**
  * Comments, generated on Wed, 19 Jul 2006 22:17:32 +0200 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class Comments extends BaseComments {
    
    /**
    * Return object comments
    *
    * @param ProjectDataObject $object
    * @param boolean $exclude_private Exclude private comments
    * @return array
    */
    static function getCommentsByObject(ProjectDataObject $object, $exclude_private = false) {
      if($exclude_private) {
        return self::findAll(array(
          'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ? AND `is_private` = ?', $object->getObjectId(), get_class($object->manager()), 0),
          'order' => '`created_on`'
        )); // array
      } else {
        return self::findAll(array(
          'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object->getObjectId(), get_class($object->manager())),
          'order' => '`created_on`'
        )); // array
      } // if
    } // getCommentsByObject
    
    /**
    * Return number of comments for specific object
    *
    * @param ProjectDataObject $object
    * @param boolean $exclude_private Exclude private comments
    * @return integer
    */
    static function countCommentsByObject(ProjectDataObject $object, $exclude_private = false) {
      if($exclude_private) {
        return self::count(array('`rel_object_id` = ? AND `rel_object_manager` = ? AND `is_private` = ?', $object->getObjectId(), get_class($object->manager()), 0));
      } else {
        return self::count(array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object->getObjectId(), get_class($object->manager())));
      } // if
    } // countCommentsByObject
  
    /**
    * Drop comments by object
    *
    * @param ProjectDataObject
    * @return boolean
    */
    static function dropCommentsByObject(ProjectDataObject $object) {
      return Comments::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()));
    } // dropCommentsByObject
    
    static function getSubscriberComments(Project $workspace = null, $tag = null, $orderBy = 'created_on', $orderDir = "DESC", $start = 0, $limit = 20) {    	
    	$oc = new ObjectController();
    	$queries = $oc->getDashboardObjectQueries($workspace, $tag, false, false, $orderBy);
		$query = '';
		foreach ($queries as $name => $q){
			if (str_ends_with($name, "Comments")) {
				if($query == '') {
					$query = $q;
				} else { 
					$query .= " \n UNION \n" . $q;
				}
			}
		}
		$query .= " ORDER BY `order_value` ";
		if ($orderDir != "ASC" && $orderDir != "DESC") $orderDir = "DESC";
		$query .= " " . $orderDir . " ";

		$query .=  " LIMIT " . $start . "," . $limit . " ";
    	$res = DB::execute($query);

    	$objects = array();
    	if (!$res) return $objects;
    	$rows = $res->fetchAll();
    	if (!$rows) return $objects;
    	foreach ($rows as $row){
    		$manager = $row['object_manager_value'];
    		$id = $row['oid'];
    		if ($id && $manager) {
    			$obj = get_object_by_manager_and_id($id, $manager);    			
    			if ($obj->canView(logged_user())) {
    				$objects[] = $obj;
    			}
    		}
    	}
    	return $objects;
    }
  } // Comments 

?>