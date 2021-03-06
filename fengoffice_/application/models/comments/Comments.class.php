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
    
    static function getSubscriberComments(Project $workspace = null, $orderBy = '`created_on` DESC', $start = 0, $limit = 20) {
    	$tp = TABLE_PREFIX;
    	$user = logged_user();
    	$id = $user->getId();
    	$sql = "
    		SELECT `a`.`id` FROM `".$tp."comments` `a`, `".$tp."object_subscriptions` `b`
    		WHERE `object_id` = `rel_object_id` AND `object_manager` = `rel_object_manager`
    			AND `user_id` = $id
			ORDER BY $orderBy
		";
		$rows = DB::executeAll($sql);
		$comments = array();
		$s = 0; $count = 0;
		if (!is_array($rows)) return $comments;
		foreach ($rows as $row) {
			$comment = Comments::findById($row['id']);
			$add = false;
			$object = $comment->getObject();
			if ($object instanceof ApplicationDataObject && $object->canView($user)) {
				if ($workspace instanceof Project) {
					$workspaces = $comment->getWorkspaces();
					foreach ($workspaces as $w) {
						if ($w->getId() == $workspace->getId() || $workspace->isParentOf($w)) {
							$add = true;
							break;
						}
					}
				} else {
					$add = true;
				}
			}
			if ($add) {
				$s++;
				if ($s >= $start) {
					$comments[] = $comment;
					$count++;
					if ($count >= $limit - $start) break;
				}
			}
		}
    	return $comments;
    }
  } // Comments 

?>