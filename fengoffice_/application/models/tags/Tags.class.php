<?php

  /**
  * Tags, generated on Wed, 05 Apr 2006 06:44:54 +0200 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class Tags extends BaseTags {
  
    /**
    * Return tags for specific object
    *
    * @access public
    * @param ProjectDataObject $object
    * @param string $manager_class
    * @return array
    */
    function getTagsByObject(ProjectDataObject $object, $manager_class) {
      return self::findAll(array(
        'conditions' => array('`rel_object_id` = ? AND `rel_object_manager` = ?', $object->getObjectId(), get_class($object->manager())),
        'order' => '`tag`'
      )); // findAll
    } // getTagsByObject
    
    /**
    * Return tag names as array for specific object
    *
    * @access public
    * @param ProjectDataObject $object
    * @param string $manager_class
    * @return array
    */
    function getTagNamesByObject(ProjectDataObject $object, $manager_class) {
      $rows = DB::executeAll('SELECT `tag` FROM ' .  self::instance()->getTableName(true) . ' WHERE `rel_object_id` = ? AND `rel_object_manager` = ? ORDER BY `tag`', $object->getId(), $manager_class);
      
      if(!is_array($rows)) return null;
      
      $tags = array();
      foreach($rows as $row) $tags[] = $row['tag'];
      return $tags;
    } // getTagNamesByObject
	
	/**
    * Return tag names as array ordered by occurrence
    *
    * @access public
    * @return array
    */
    function getTagNames() {
      $rows = DB::executeAll('SELECT DISTINCT `tag`, count(`tag`) `count` FROM ' .  self::instance()->getTableName(true) . 'GROUP BY `tag` ORDER BY `count` DESC');
      
      if(!is_array($rows)) return null;
      
      $tags = array();
      foreach($rows as $row) $tags[] = $row['tag'];
      return $tags;
    } // getTagNames
    
    /**
    * Return tag names as array for project file id
    *
    * @access public
    * @param int $fileId
    * @return array
    */
    function getTagNamesByFileId( $fileId) {
      $rows = DB::executeAll('SELECT `tag` FROM ' .  self::instance()->getTableName(true) . ' WHERE `rel_object_id` = ? AND `rel_object_manager` =\'ProjectFiles\' ORDER BY `tag`', $fileId);
      
      if(!is_array($rows)) return null;
      
      $tags = array();
      foreach($rows as $row) $tags[] = $row['tag'];
      return $tags;
    } // getTagNamesByFileId
    
    /**
    * Clear tags of specific object
    *
    * @access public
    * @param ProjectDataObject $object
    * @param string $manager_class
    * @return boolean
    */
    function clearObjectTags(ProjectDataobject $object, $manager_class) {
      $tags = $object->getTags(); // save the tags list
      if(is_array($tags)) {
        foreach($tags as $tag) $tag->delete();
      } // if
    } // clearObjectTags
    
    /**
    * Delete a tag for a project object
    *
    * @access public
    * @param tag to delete
    * @param int fileID
    * @param Project $project
    * @return null
    */
    
    function deleteObjectTag($tag_name, $object_id, $manager_class, $project = null) {
      if (!(isset($object_id) && $object_id))
      	return true;
      $file=ProjectFiles::findById($object_id);
      $prevTags=Tags::getTagsByObject($file,$manager_class);
      foreach($prevTags as $tag_iter) {
      	if(strcmp($tag_name,$tag_iter->getTag())==0)
      	{
      		$tag_iter->delete();
      		return true;
      	}
      }  
         
      return true;
    } //  addFileTags

    
    /**
    * Add tags for a project file
    *
    * @access public
    * @param string $tag_name tag to be added
    * @param int fileID
    * @param Project $project
    * @return null
    */
    function addFileTag($tag_name, $fileId, $project = null) {
      if (!(isset($fileId) && $fileId))
      	return true;
      $prevTags=Tags::getTagNamesByFileId($fileId);
      foreach($prevTags as $tag_iter) {
      	if(strcmp($tag_name,$tag_iter)==0)
      		return true; //tag already added
      }  
      if(strcmp(trim($tag_name) , '')) {
        $tag = new Tag();
        
        if($project instanceof Project) $tag->setProjectId($project->getId());
        $tag->setTag($tag_name);
        $tag->setRelObjectId($fileId);
        $tag->setRelObjectManager('ProjectFiles');
        $tag->setIsPrivate(false);            
        $tag->save();
      } // if
         
      return true;
    } //  addFileTags
    
    /**
    * Set tags for specific object
    *
    * @access public
    * @param array $tags Array of tags... Can be NULL or empty
    * @param ProjectDataObject $object
    * @param string $manager_class
    * @param Project $project
    * @return null
    */
    function setObjectTags($tags, ProjectDataObject $object, $manager_class, $project = null) {
      self::clearObjectTags($object, $manager_class);
      if(is_array($tags) && count($tags)) {
        foreach($tags as $tag_name) {
          
          if(trim($tag_name) <> '') {
            $tag = new Tag();
            
            if($project instanceof Project) $tag->setProjectId($project->getId());
            $tag->setTag($tag_name);
            $tag->setRelObjectId($object->getId());
            $tag->setRelObjectManager($manager_class);
            $tag->setIsPrivate($object->isPrivate());
            
            $tag->save();
          } // if
          
        } // foreach
      } // if
      return true;
    } // setObjectTags
    
    /**
    * Return unique tag names used on project objects
    *
    * @access public
    * @param Project $project
    * @return array
    */
    function getProjectTagNames(Project $project, $exclude_private = false) {
      if($exclude_private) {
        $rows = DB::executeAll("SELECT DISTINCT `tag` FROM " . self::instance()->getTableName(true) . ' WHERE `project_id` = ? AND `is_private` = ? ORDER BY `tag`', $project->getId(), 0);
      } else {
        $rows = DB::executeAll("SELECT DISTINCT `tag` FROM " . self::instance()->getTableName(true) . ' WHERE `project_id` = ? ORDER BY `tag`', $project->getId());
      } // if
      if(!is_array($rows) || !count($rows)) return null;
      
      $tags = array();
      foreach($rows as $row) {
        $tags[] = $row['tag'];
      } // foreach
      
      return $tags;
    } // getProjectTagNames
    
    /**
    * Return array of project objects. Optional filters are by tag and / or by object class
    *
    * @access public
    * @param Project $project
    * @param string $tag Return objects that are tagged with specific tag
    * @param string $class Return only object that match specific class (manager class name)
    * @param boolean $exclude_private Exclude private objects from listing
    * @return array
    */
    function getProjectObjects(Project $project, $tag = null, $class = null, $exclude_private = false) {
      $conditions = '`project_id` = ' . DB::escape($project->getId());
      if(trim($tag) <> '') $conditions .= ' AND `tag` = ' . DB::escape($tag);
      if(trim($class) <> '') $conditions .= ' AND `rel_object_manager` = ' .  DB::escape($class);
      if($exclude_private) $conditions .= ' AND `is_private` = ' . DB::escape(0);
      
      $tags = self::findAll(array(
        'conditions' => $conditions,
        'order_by' => '`created_on`'
      )); // findById
      
      if(!is_array($tags)) return null;
      
      $objects = array();
      foreach($tags as $tag_object) {
        $object = $tag_object->getObject();
        if($object instanceof ProjectDataObject) $objects[] = $object;
      } // foreach
      
      return count($objects) ? $objects : null;
      
    } // getProjectObjects
    
    /**
    * Returns number of objects tagged with specific tag
    *
    * @access public
    * @param string $tag Tag name
    * @param Project $project Only objects that belong to this project
    * @param boolean $exclude_private Exclude private objects from listing
    * @return integer
    */
    function countProjectObjectsByTag($tag, Project $project, $exclude_private = false) {
      if($exclude_private) {
        $row = DB::executeOne("SELECT COUNT(`id`) AS 'row_count' FROM " . self::instance()->getTableName(true) . " WHERE `tag` = ? AND `project_id` = ? AND `is_private` = ?", $tag, $project->getId(), 0);
      } else {
        $row = DB::executeOne("SELECT COUNT(`id`) AS 'row_count' FROM " . self::instance()->getTableName(true) . " WHERE `tag` = ? AND `project_id` = ?", $tag, $project->getId());
      } // if
      return array_var($row, 'row_count', 0);
    } // countProjectObjectsByTag
    
  } // Tags 

?>