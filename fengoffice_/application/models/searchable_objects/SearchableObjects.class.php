<?php

  /**
  * SearchableObjects, generated on Tue, 13 Jun 2006 12:15:44 +0200 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class SearchableObjects extends BaseSearchableObjects {
    
    /**
    * Search for specific search string ($search_for) in specific project
    *
    * @param string $search_for Search string
    * @param Project $project Search in this project
    * @param boolean $include_private
    * @return array
    */
    static function search($search_for, Project $project, $include_private = false) {
      return SearchableObjects::doSearch(SearchableObjects::getSearchConditions($search_for, $project->getId(), $include_private));
    } // search
    
    /**
    * Search paginated
    *
    * @param string $search_for Search string
    * @param Project $project Search in this project
    * @param boolean $include_private
    * @param integer $items_per_page
    * @param integer $current_page
    * @return array
    */
    static function searchPaginated($search_for, $project_csvs, $include_private = false, $items_per_page = 10, $current_page = 1) {
        if ((defined('LUCENE_SEARCH') && LUCENE_SEARCH)) {
      		$conditions = SearchableObjects::getLuceneSearchConditions($search_for, $project_csvs, $include_private);
      		$hits = LuceneDB::findClean($conditions);
      		$pagination = new DataPagination(count($hits), $items_per_page, $current_page);
      		$items = SearchableObjects::doLuceneSearch($hits, $pagination->getItemsPerPage(), $pagination->getLimitStart());
        } else {
		    $conditions = SearchableObjects::getSearchConditions($search_for, $project_csvs, $include_private);
		    $tagconditions = SearchableObjects::getTagSearchConditions($search_for, $project_csvs);
		    $pagination = new DataPagination(SearchableObjects::countUniqueObjects($conditions, $tagconditions), $items_per_page, $current_page);
		    $items = SearchableObjects::doSearch($conditions, $tagconditions, $pagination->getItemsPerPage(), $pagination->getLimitStart());
		}
        return array($items, $pagination);
    } // searchPaginated
    
    static function searchByType($search_for, $project_csvs, $object_type = '', $include_private = false, $items_per_page = 10, $current_page = 1, $columns_csv = null, $user_id = 0) {
        $remaining = 0;
    	if ((defined('LUCENE_SEARCH') && LUCENE_SEARCH)) {
        	throw new Exception("Not implemented");
      		/*$conditions = SearchableObjects::getLuceneSearchConditions($search_for, $project_csvs, $include_private);
      		$hits = LuceneDB::findClean($conditions);
      		$pagination = new DataPagination(count($hits), $items_per_page, $current_page);
      		$items = SearchableObjects::doLuceneSearch($hits, $pagination->getItemsPerPage(), $pagination->getLimitStart());*/
        } else {
		    $conditions = SearchableObjects::getSearchConditions($search_for, $project_csvs, true, $object_type, $columns_csv, $user_id);
		    $count = SearchableObjects::countUniqueObjects($conditions);
		    $pagination = new DataPagination($count, $items_per_page, $current_page);
		    if ($count > 0)
		    	$items = SearchableObjects::doSearch($conditions, $pagination->getItemsPerPage(), $pagination->getLimitStart());
		    else
		    	$items = array();
		}
        return array($items, $pagination);
    } // searchPaginated
    
    
    function getLuceneSearchConditions($search_for, $project_csvs, $include_private = false){
    	$workspaces = str_replace(',', ' ', $project_csvs);
    	$wslist = explode(" ", $workspaces);
    	$wsList2 = array();
    	foreach ($wslist as $ws)
    		$wsList2[] = "ws" . $ws;
    	$workspaces = implode(" ", $wsList2);
    	return 'workspaces:('. $workspaces . ') AND text:(' . $search_for . ')';
    }
    
    /**
    * Prepare search conditions string based on input params
    *
    * @param string $search_for Search string
    * @param string $project_csvs Search in this project
    * @return array
    */
    function getSearchConditions($search_for, $project_csvs, $include_private = false, $object_type = '', $columns_csv = null, $user_id = 0) {
    	$otSearch = '';
    	$columnsSearch = '';
    	$wsSearch = '';
    	if (!is_null($columns_csv))
    		$columnsSearch = " AND `column_name` in (" . $columns_csv . ")";
    		
    	if ($object_type != '')
    		$otSearch = " AND `rel_object_manager` = '$object_type'";
    
    	if ($user_id > 0)
    		$wsSearch .= " AND (`user_id` = " . $user_id . " OR ";
    	else
    		$wsSearch .= " AND (";
    		
    	if ($object_type=="ProjectMessages" || $object_type == "ProjectFiles")
    		$wsSearch .= "`rel_object_id` IN (SELECT `object_id` FROM `".TABLE_PREFIX."workspace_objects` WHERE `object_manager` = '$object_type' && `workspace_id` IN ($project_csvs))";
    	else
    		$wsSearch .=  "`project_id` in ($project_csvs)";
    		
    	$wsSearch .= ')';
    
    	if($include_private) {
    		return DB::prepareString('MATCH (`content`) AGAINST (? IN BOOLEAN MODE)' .$wsSearch . $otSearch . $columnsSearch, array($search_for));
    	} else {
    		return DB::prepareString('MATCH (`content`) AGAINST (? IN BOOLEAN MODE) AND `is_private` = ?' .$wsSearch . $otSearch . $columnsSearch, array($search_for,  false));
    	} // if
    } // getSearchConditions
    
    /* Prepare search conditions string based on input params
    *
    * @param string $search_for Search string
    * @param string $project_csvs Search in this project
    * @return array
    */
    function getTagSearchConditions($search_for, $project_csvs) {
      return DB::prepareString(" tag = '$search_for' ");
    } // getTagSearchConditions
    
    
    /**
    * Do the lucene search
    *
    * @param string $conditions
    * @param integer $limit
    * @param integer $offset
    * @return array
    */
    function doLuceneSearch($hits, $limit = null, $offset = null) {
      if((integer) $limit > 0) {
        $offset = (integer) $offset > 0 ? (integer) $offset : 0;
      } // if
      
      $loaded = array();
      $objects = array();
      $c = $offset;
      while($hits[$c] && $c < $offset + $limit){
      	$hit = $hits[$c];
        $manager_class = $hit->manager;	
        $object_id = $hit->objectid;
        
        if(!isset($loaded[$manager_class . '-' . $object_id]) || !($loaded[$manager_class . '-' . $object_id])) {
          if(class_exists($manager_class)) {
            $object = get_object_by_manager_and_id($object_id, $manager_class);
            if($object instanceof ProjectDataObject) {
              $loaded[$manager_class . '-' . $object_id] = true;
              $objects[] = $object;
            } // if
          } // if
        } // if
        
        $c++;
      }
      
      return count($objects) ? $objects : null;
    } // doSearch
    
    /**
    * Do the search
    *
    * @param string $conditions
    * @param integer $limit
    * @param integer $offset
    * @return array
    */
    function doSearch($conditions, $limit = null, $offset = null) {
      $table_name = SearchableObjects::instance()->getTableName(true);
      //$tags_table_name = Tags::instance()->getTableName();
      
      $limit_string = '';
      if((integer) $limit > 0) {
        $offset = (integer) $offset > 0 ? (integer) $offset : 0;
        $limit_string = " LIMIT $offset, $limit";
      } // if
      
      $where = '';
      if(trim($conditions) <> '') $where = "WHERE $conditions";
      
      $sql = "SELECT `rel_object_manager`, `rel_object_id`, `column_name` FROM $table_name $where ORDER BY `rel_object_id` DESC $limit_string";
      $result = DB::executeAll($sql);
      if(!is_array($result)) return null;
      
      $loaded = array();
      $objects = array();
      
      foreach($result as $row) {
        $manager_class = array_var($row, 'rel_object_manager');
        $object_id = array_var($row, 'rel_object_id');
        
        if(!isset($loaded[$manager_class . '-' . $object_id]) || !($loaded[$manager_class . '-' . $object_id])) {
          if(class_exists($manager_class)) {
            $object = get_object_by_manager_and_id($object_id, $manager_class);
            if($object instanceof ApplicationDataObject) {
              $loaded[$manager_class . '-' . $object_id] = true;
              $objects[] = array('object' => $object, 'column_name' => array_var($row, 'column_name'));
            } // if
          } // if
        } // if
      } // foreach
      
      return count($objects) ? $objects : null;
    } // doSearch
    
    /**
    * Return number of unique objects
    *
    * @param string $conditions
    * @return integer
    */
    function countUniqueObjects($conditions) {
      $table_name = SearchableObjects::instance()->getTableName(true);
      //$tags_table_name = Tags::instance()->getTableName();
      $where = '';
      if(trim($conditions <> '')) $where = "WHERE $conditions";
      
      $sql = "SELECT distinct `rel_object_manager`, `rel_object_id` FROM $table_name $where";
      $result = DB::executeAll($sql);
      if(!is_array($result) || !count($result)) return 0;
      
      $counted = array();
      $counter = 0;
      foreach($result as $row) {
        if(!isset($counted[array_var($row, 'rel_object_manager') . array_var($row, 'rel_object_id')])) {
          $counted[array_var($row, 'rel_object_manager') . array_var($row, 'rel_object_id')] = true;
          $counter++;
        } // if
      } // foreach
      
      return $counter;
    } // countUniqueObjects
    
    /**
    * Drop all content from table related to $object
    *
    * @param ProjectDataObject $object
    * @return boolean
    */
    static function dropContentByObject(ApplicationDataObject $object) {
    	if (!(defined('LUCENE_SEARCH') && LUCENE_SEARCH))
    		return SearchableObjects::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ?', get_class($object->manager()), $object->getObjectId()));
    	else {
    		return LuceneDB::DeleteFromIndex($object, false);
    	}
    } // dropContentByObject
    
    /**
    * Drop column content from table related to $object
    *
    * @param ProjectDataObject $object
    * @return boolean
    */
    static function dropContentByObjectColumn(ApplicationDataObject $object, $column = '') {
    	if (!(defined('LUCENE_SEARCH') && LUCENE_SEARCH))
    		return SearchableObjects::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ? AND `column_name` = '. "'". $column . "'" , get_class($object->manager()), $object->getObjectId(), $column));
    	else {
    		return LuceneDB::DeleteFromIndex($object, false);
    	}
    } // dropContentByObject
    
    /**
    * Drop columns content from table related to $object
    *
    * @param ApplicationDataObject $object
    * @return boolean
    */
    static function dropContentByObjectColumns(ApplicationDataObject $object, $columns = array()) {
    	$columns_csv = "'" . implode("','",$columns) . "'";
    	
    	if (!(defined('LUCENE_SEARCH') && LUCENE_SEARCH))
    		return SearchableObjects::delete(array('`rel_object_manager` = ? AND `rel_object_id` = ? AND `column_name` in ('. $columns_csv . ')' , get_class($object->manager()), $object->getObjectId()));
    	else {
    		return LuceneDB::DeleteFromIndex($object, false);
    	}
    } // dropContentByObject
    
  } // SearchableObjects 

?>