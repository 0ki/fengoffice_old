<?php
/**
 * 	
 * Enter description here ...
 * @author Pepe
 *
 */
abstract class ContentDataObjects extends DataManager {
	
	protected $object_type_name = null;
	
	private $object_type_id = null;
	
	private $foundRows = null ;
	
	function getFoundRows() {
		return $this->foundRows ;
	}
	
	function getObjectTypeId() {
		if (!$this instanceof ContentDataObjects || is_null($this->object_type_name)) {
			return null;
		}		
		if (is_null($this->object_type_id)) {
			$ot = ObjectTypes::findByName($this->object_type_name);
			if ($ot instanceof ObjectType) {
				$this->object_type_id = $ot->getId();
			}
		}
		
		return $this->object_type_id;
	}
	
	
	/**
	 * Returns the fields visible to the user, e.g. for add/edit forms
	 * Must be overriden by the specific object classes
	 */
	function getPublicColumns() {
		return array();
	}
	
	/**
	 * Return column type
	 *
	 * @access public
	 * @param string $column_name
	 * @return string
	 */
	function getCOColumnType($column_name, $columns) {
		if(isset($columns[$column_name])) {
			return $columns[$column_name];
		} else {
			return Objects::instance()->getColumnType($column_name);
		}
	}
	
	/**
	 * Retuns a new instance of a concrete object managed by this class
	 * This method is required to be overriden by classes that manage 'dimension_objects'
	 */
	function newDimensionObject() {
		$ot = ObjectTypes::findById($this->getObjectTypeId());
		eval('$manager = '.$ot->getHandlerClass().'::instance();');
		eval('$object = new '.$manager->getItemClass().'();');
		return $object;
	}
	
	
	function sqlFields($all = true) {
		$common_fields = array() ;
		foreach ( Objects::getColumns() as $col ) {
			$common_fields[] = "o.$col AS `$col`";
		}
		if (!$all) {
			return $common_fields ;
		}else{
			$extra_fields = array();
			$columns = $this->getColumns();
			foreach ( $columns as $col ) {
				if ($col != "id") 
					$extra_fields[] = "m.$col AS `$col`";
			}
			$columns = null;
			$fields = array_merge($common_fields,$extra_fields);
			return $fields ;
		}
		
	}
	
	/**
	 * 
	 * FAST PAGINATE ! DONT DELETE.. CAN BE USED IN THE FUTURE
	 * @author Pepe
	 */
	/*
	function paginate($arguments = null, $items_per_page = 10, $current_page = 1) {
	
		
		if (isset ( $this ) && instance_of ( $this, 'ContentDataObjects' )) {
			if (! is_array ( $arguments ))	$arguments = array ();
			$conditions = $this->prepareConditions( array_var ( $arguments, 'conditions' ) );
			$object_table = $this->getTableName();
			
			if (defined ( 'INFINITE_PAGING' ) && INFINITE_PAGING)
				$count = 10000000;
			$fields = $this->sqlFields() ;
			
			$sql = "SELECT SQL_CALC_FOUND_ROWS 
						".implode(", ",$fields)."
					FROM 
						".TABLE_PREFIX."objects o INNER JOIN $object_table  m ON o.id  = m.object_id						
					WHERE 
						$conditions
					LIMIT ".($current_page - 1) * $items_per_page . ", $items_per_page
			";
						
			
			$res = DB::execute($sql);
			$items = $res->fetchAll();			
			$className = $this->getItemClass();
			$messages = array() ;
			foreach ($items as $item) {
				$object = new $className;
				$object->loadFromRow($item);
				$objects[] = $object ;
			}
			
			$num_rows = DB::executeOne("SELECT FOUND_ROWS() AS total")  ;
			$total = $num_rows["total"];
			$pagination = new DataPagination ( $total , $items_per_page, $current_page );
			return array ($objects, $pagination );
		} else {
			return ContentDataObjects::instance()->paginate ( $arguments, $items_per_page, $current_page );
		} // if
    } // paginate

    */
    
	/**
    * Do a SELECT query over database with specified arguments
    *
    * @access public
    * @param array $arguments Array of query arguments. Fields:
    * 
    *  - one - select first row
    *  - conditions - additional conditions
    *  - order - order by string
    *  - offset - limit offset, valid only if limit is present
    *  - limit
    * 
    * @return one or many objects
    * @throws DBQueryError
    */
    function find($arguments = null) {
      
      if (isset($arguments['conditions'])) {
      	$conditions = $arguments['conditions'];
      } else if (isset($arguments['condition'])) {
      	$conditions = $arguments['condition'];
      } else {
      	$conditions = '';
      }
    	
      // Collect attributes...
      $one        = (boolean) array_var($arguments, 'one', false);
      $id         = (boolean) array_var($arguments, 'id', false);
      $distinct   = (boolean) array_var($arguments, 'distinct', false);
      $conditions = $this->prepareConditions( $conditions );
      $order_by   = array_var($arguments, 'order', '');
      $offset     = (integer) array_var($arguments, 'offset', 0);
      $limit      = (integer) array_var($arguments, 'limit', 0);
      $join		  = array_var($arguments, 'join');
      
	  // limit = 1 when findOne is invoked
      if ($one) {
      	$limit = 1;
      }
      
      
      $table_prefix = defined('FORCED_TABLE_PREFIX') && FORCED_TABLE_PREFIX ? FORCED_TABLE_PREFIX : TABLE_PREFIX;

      // Prepare query parts
      //$where_string = trim($conditions) == '' ? '' : "WHERE " . preg_replace("/\s+in\s*\(\s*\)/i", " = -1", $conditions);
      $where_string = trim($conditions) == '' ? '' : "WHERE " . trim($conditions);
      $order_by_string = trim($order_by) == '' ? '' : "ORDER BY $order_by";
      $limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';
      $distinct = $distinct ? "DISTINCT " : "";
      $join_string = "";
      if (is_array($join) && array_var($join, 'table') && array_var($join, 'jt_field') && (array_var($join, 'e_field') || array_var($join, 'j_sub_q'))) {
      	if (array_var($join, 'e_field')) {
      		$join_cond = "e." . array_var($join, 'e_field');
      	} else {
      		$join_cond = "(" . array_var($join, 'j_sub_q') . ")";
      	}
      	if ( isset($join['join_type']) && in_array(strtoupper(trim($join['join_type'])) , array("INNER", "LEFT")) ){
      		$join_type = trim(strtoupper($join['join_type']));
      	}else{
      		$join_type = "INNER";
      	}
      	$join_string = "$join_type JOIN " . array_var($join, 'table') . " jt ON jt." . array_var($join, 'jt_field') . " = " . $join_cond;
      }
      
      // Prepare SQL
      $sql = "
      	SELECT $distinct" . ($id ? '`id`' : 'e.*, o.* ') . " 
      	FROM " . $this->getTableName(true) . " e
      	INNER JOIN ".$table_prefix."objects o ON o.id = e.object_id 
        $join_string $where_string $order_by_string $limit_string";

      // Run!
      $rows = DB::executeAll($sql);

      // Empty?
      if(!is_array($rows) || (count($rows) < 1)) return null;
      
      // return only ids?
      if ($id) {
      	$ids = array();
      	foreach ($rows as $row) {
      		$ids[] = $row['id'];
      	}
      	return $ids;
      }
      
      // If we have one load it, else loop and load many
      if($one) {
        return $this->loadFromRow($rows[0]);
      } else {
        $objects = array();
        foreach($rows as $row) {
          $object = $this->loadFromRow($row);
          if(instance_of($object, $this->getItemClass())) $objects[] = $object;
        } // foreach
        return count($objects) ? $objects : null;
      } // if
    } // find

    
    
    
    
		
	/**
    * Return number of rows in this table
    *
    * @access public
    * @param string $conditions Query conditions
    * @return integer
    */
    function count($conditions = null) {
      // Don't do COUNT(*) if we have one PK column
      $escaped_pk = is_array($pk_columns = $this->getPkColumns()) ? '*' : DB::escapeField($pk_columns);
      
      $conditions = $this->prepareConditions($conditions);
      $where_string = trim($conditions) == '' ? '' : "WHERE $conditions";
      $row = DB::executeOne("
      	SELECT COUNT($escaped_pk) AS 'row_count' 
      	FROM " . $this->getTableName(true) . " e
      	INNER JOIN ".TABLE_PREFIX."objects o ON o.id = e.object_id 
        $where_string ");
      return (integer) array_var($row, 'row_count', 0);
    } // count

    

	


	
	
	/**
    * Load row from database based on ID
    *
    * @access public
    * @param mixed $id
    * @return array
    */
    function loadRow($id) {
        $ocols = Objects::getColumns();
        $tcols = $this->getColumns();
    	$columns = array_map('db_escape_field', array_merge ($ocols, $tcols ) );
    	$table_prefix = defined('FORCED_TABLE_PREFIX') && FORCED_TABLE_PREFIX ? FORCED_TABLE_PREFIX : TABLE_PREFIX;
    	
      	$sql = sprintf("
      		SELECT %s 
      		FROM %s	INNER JOIN `".$table_prefix."objects` o
      		ON o.id = %s.object_id 
      		WHERE %s", 
      	
        	implode(', ', array_merge( $columns )), 
        	$this->getTableName(true), 
        	$this->getTableName(true),         	
        	$this->getConditionsById($id)
		); // sprintf
		
		$ocols = null;
		$tcols = null;
		$columns = null;
		
		return DB::executeOne($sql);
    } 
	
	
	private function check_include_trashed(& $arguments = null) {
		if (!array_var($arguments, 'include_trashed', false)) {
			$columns = $this->getColumns();
			if (array_search("trashed_on", $columns) != false) {
				$conditions = array_var($arguments, 'conditions', '');
				if (is_array($conditions)) {
					$conditions[0] = "`trashed_on` = " . DB::escape(EMPTY_DATETIME). " AND (".$conditions[0].")";
				} else if ($conditions != '') {
					$conditions = "`trashed_on` = " . DB::escape(EMPTY_DATETIME). " AND ($conditions)";
				} else {
					$conditions = "`trashed_on` = " . DB::escape(EMPTY_DATETIME);
				}
				$arguments['conditions'] = $conditions;
			}
			$columns = null;
		}
	}


	function findById($id, $force_reload = false) {
		$co = parent::findById($id, $force_reload);
		if (!is_null($co)) {
			$co->setObject(Objects::findById($id, $force_reload));
		}
		return $co;
	}
	
	/**
	 * Fermormance FIX: getContentObjects replacement
	 * @param array $args 
	 *		order = null  -  may be performance killer depending on the order criteria  
	 * 		order_dir = null 
	 * 		extra_conditions = null : extra sql 'inyection' - may be performance killer depending on the injected query  
	 * 		join_params = null : extra join table
	 * 		trashed = false 
	 *	 	archived = false
	 * 		start = 0 
	 * 		limit = null	
	 * 		ignore_context
	 *		include_deleted 
	 *		count_results : if true calc found rows else show 'many'	 
	 *      extra_member_ids : Search also objects in this slist of members 
	 *      member_ids : force to search objects in this list of members (strinct)
	 *  	 
	 */
	public function listing($args = array()) {
		$result = new stdClass;
		$result->objects =array();
		$result->total =array();
		$type_id  = self::getObjectTypeId();
		$SQL_BASE_JOIN = '';
		$SQL_EXTRA_JOINS = '';
		$SQL_TYPE_CONDITION = 'true';
		$SQL_FOUND_ROWS = '';

		if (isset($args['count_results'])) {
			$count_results = $args['count_results'];
		} else {
			$count_results = defined('INFINITE_PAGING') ? !INFINITE_PAGING : false;
		}
		
		//get only the number of results without limit not data
		if (isset($args['only_count_results'])){
			$only_count_results = $args['only_count_results'];
		}else{
			$only_count_results = false;
		}
		
		$return_raw_data = array_var($args,'raw_data');
		$start = array_var($args,'start');
		$limit = array_var($args,'limit');
		$member_ids = array_var($args, 'member_ids');
		$extra_member_ids =  array_var($args,'extra_member_ids');
		$ignore_context = array_var($args,'ignore_context');
		$include_deleted = (bool) array_var($args,'include_deleted');
		$select_columns = array_var($args, 'select_columns');
		if (empty($select_columns)) {
			$select_columns = array('*');
		}
		
		//template objects
		$template_objects = (bool) array_var($args,'template_objects',false);
				
		$handler_class = "Objects";
	
		if ($type_id){
			// If isset type, is a concrete instance linsting. Otherwise is a generic listing of objects
			$type = ObjectTypes::findById($type_id); /* @var $object_type ObjectType */
			$handler_class = $type->getHandlerClass();
			$table_name = self::getTableName();
			
	    	// Extra Join statements
	    	if ($this instanceof ContentDataObjects && $this->object_type_name == 'timeslot') {
	    		// if object is a timeslot and is related to a content object => check for members of the related content object.
	    		$SQL_BASE_JOIN = " INNER JOIN  $table_name e ON IF(e.rel_object_id > 0, e.rel_object_id, e.object_id) = o.id ";
	    		$SQL_TYPE_CONDITION = "object_type_id = IF(e.rel_object_id > 0, (SELECT z.object_type_id FROM ".TABLE_PREFIX."objects z WHERE z.id = e.rel_object_id), $type_id)";
	    	} else {
	    		$SQL_BASE_JOIN = " INNER JOIN  $table_name e ON e.object_id = o.id ";
	    		$SQL_TYPE_CONDITION = "o.object_type_id = $type_id";
	    	}
			$SQL_EXTRA_JOINS = self::prepareJoinConditions(array_var($args,'join_params'));
			
		}
		
		if (!$ignore_context && !$member_ids) {
			$members = active_context_members(false); // Context Members Ids
		} elseif ( count($member_ids) ) {
			$members = $member_ids;
		}
		
		if  (is_array($extra_member_ids)) {
			if (isset($members)) {
				$members = array_merge($members, $extra_member_ids);
			} else {
				$members = $extra_member_ids;
			}
		}
		
		// Order statement
    	$SQL_ORDER = self::prepareOrderConditions(array_var($args,'order'), array_var($args,'order_dir'));
		
		// Prepare Limit SQL 
		if (is_numeric(array_var($args,'limit')) && array_var($args,'limit')>0){
			$SQL_LIMIT = "LIMIT ".array_var($args,'start',0)." , ".array_var($args,'limit');
		}else{
			$SQL_LIMIT = '' ;
		}
		
		$SQL_CONTEXT_CONDITION = " true ";
		if (!empty($members) && count($members)) {
			$SQL_CONTEXT_CONDITION = "(EXISTS (SELECT om.object_id
					FROM  ".TABLE_PREFIX."object_members om
					WHERE	om.member_id IN (" . implode ( ',', $members ) . ") AND o.id = om.object_id
					GROUP BY object_id
					HAVING count(member_id) = ".count($members)."
			))";
			
		}
		
		// Trash && Archived CONDITIONS
    	$trashed_archived_conditions = self::prepareTrashandArchivedConditions(array_var($args,'trashed'), array_var($args,'archived'));
    	$SQL_TRASHED_CONDITION = ($include_deleted) ? ' TRUE '  : $trashed_archived_conditions[0];
    	$SQL_ARCHIVED_CONDITION =($include_deleted) ? ' AND TRUE ' :  $trashed_archived_conditions[1];
    	
		// Extra CONDITIONS
		if (array_var($args,'extra_conditions')) {
			$SQL_EXTRA_CONDITIONS = array_var($args,'extra_conditions') ;	
		}else{
			$SQL_EXTRA_CONDITIONS = '';
		}
		
		$SQL_COLUMNS = implode(',', $select_columns);
		
		if (logged_user() instanceof Contact) {
			$uid = logged_user()->getId();
			// Build Main SQL
					
			$permissions_condition = "o.id IN (
					SELECT sh.object_id FROM ".TABLE_PREFIX."sharing_table sh
					WHERE o.id = sh.object_id
					AND sh.group_id  IN (SELECT permission_group_id FROM ".TABLE_PREFIX."contact_permission_groups WHERE contact_id = $uid)
			)";
			
			if (logged_user()->isAdministrator() ||($this instanceof Contacts && $this->object_type_name == 'contact' && can_manage_contacts(logged_user()))) {
				$permissions_condition = "true";
			}
			
			if($template_objects){
				$permissions_condition = "true";
				$SQL_BASE_JOIN .= " INNER JOIN  ".TABLE_PREFIX."template_tasks temob ON temob.object_id = o.id ";
			}
			$sql = "
				SELECT $SQL_FOUND_ROWS $SQL_COLUMNS FROM ".TABLE_PREFIX."objects o
				$SQL_BASE_JOIN
				$SQL_EXTRA_JOINS
				WHERE
					$permissions_condition
					AND	$SQL_CONTEXT_CONDITION
					AND $SQL_TYPE_CONDITION
					AND $SQL_TRASHED_CONDITION $SQL_ARCHIVED_CONDITION $SQL_EXTRA_CONDITIONS
				$SQL_ORDER
				$SQL_LIMIT";
			
			$sql_total = "
				SELECT count(o.id) as total FROM ".TABLE_PREFIX."objects o
				$SQL_BASE_JOIN
				$SQL_EXTRA_JOINS
				WHERE
					$permissions_condition
					AND	$SQL_CONTEXT_CONDITION
					AND $SQL_TYPE_CONDITION
					AND $SQL_TRASHED_CONDITION $SQL_ARCHIVED_CONDITION $SQL_EXTRA_CONDITIONS";

			
		    if(!$only_count_results){
				// Execute query and build the resultset
		    	$rows = DB::executeAll($sql);
		    	
		    	if ($return_raw_data) {
		    		$result->objects = $rows;
		    	} else {
		    		if($rows && is_array($rows)) {
		    			foreach ($rows as $row) {
		    				if ($handler_class) {
		    					$phpCode = '$co = '.$handler_class.'::instance()->loadFromRow($row);';
		    					eval($phpCode);
		    				}
		    				if ( $co ) {
		    					$result->objects[] = $co;
		    				}
		    			}
		    		}
		    	}
				if ($count_results) {
					$total = DB::executeOne($sql_total);
					$result->total = $total['total'];	
				}else{
					if  ( count($result->objects) >= $limit ) {
						$result->total = 10000000;
					}else{
						$result->total = $start + count($result->objects);
					}
				}
		    }else{
		    	$total = DB::executeOne($sql_total);
		    	$result->total = $total['total'];		    	
		    }
		} else {
			$result->objects = array();
			$result->total = 0;
		}
		
		return $result;
	}
	
	/**
	 * @deprecated by listing(args) 
	 * @param unknown_type $context
	 * @param unknown_type $object_type
	 * @param unknown_type $order
	 * @param unknown_type $order_dir
	 * @param unknown_type $extra_conditions
	 * @param unknown_type $join_params
	 * @param unknown_type $trashed
	 * @param unknown_type $archived
	 * @param unknown_type $start
	 * @param unknown_type $limit
	 */
	static function getContentObjects($context, $object_type, $order=null, $order_dir=null, $extra_conditions=null, $join_params=null, $trashed=false, $archived=false, $start = 0 , $limit=null){
		$table_name = $object_type->getTableName();
		$object_type_id = $object_type->getId();
		
		//Join conditions
		$join_conditions = self::prepareJoinConditions($join_params);
		
    	//Trash && Archived conditions
    	$conditions = self::prepareTrashandArchivedConditions($trashed, $archived);
    	$trashed_cond = $conditions[0];
    	$archived_cond = $conditions[1];
    	
    	//Order conditions
    	$order_conditions = self::prepareOrderConditions($order, $order_dir);
    	
    	//Extra conditions
		if (!$extra_conditions) $extra_conditions = "";
		
		//Dimension conditions
    	$member_conditions = self::prepareDimensionConditions($context, $object_type_id);
    	if ($member_conditions == "") $member_conditions = "true";
    	
    	$limit_query = "";
    	if ($limit !== null) {
    		$limit_query = "LIMIT $start , $limit " ;
    	} 
    	
    	$sql_count = "SELECT COUNT( DISTINCT `om`.`object_id` ) AS total FROM `".TABLE_PREFIX."object_members` `om` 
    		INNER JOIN `".TABLE_PREFIX."objects` `o` ON `o`.`id` = `om`.`object_id`
    		INNER JOIN `".TABLE_PREFIX."$table_name` `e` ON `e`.`object_id` = `o`.`id`
    		$join_conditions WHERE $trashed_cond $archived_cond AND ($member_conditions) $extra_conditions";
    	$total = array_var(DB::executeOne($sql_count), "total");	
    		
    	$sql = "SELECT DISTINCT `om`.`object_id` FROM `".TABLE_PREFIX."object_members` `om` 
    		INNER JOIN `".TABLE_PREFIX."objects` `o` ON `o`.`id` = `om`.`object_id`
    		INNER JOIN `".TABLE_PREFIX."$table_name` `e` ON `e`.`object_id` = `o`.`id`
    		$join_conditions WHERE $trashed_cond $archived_cond AND ($member_conditions) $extra_conditions $order_conditions
    		$limit_query
    		";
		
	    $result = DB::execute($sql);
    	$rows = $result->fetchAll();
    	$objects = array();
    	$handler_class = $object_type->getHandlerClass();
    	if (!is_null($rows)) {
    		$ids = array();
	    	foreach ($rows as $row) {
	    		$ids[] = array_var($row, 'object_id');
	    	}
	    	if (count($ids) > 0) {
	    		$join_str = "";
	    		if ($join_params) {
	    			$join_str = ', "join" => array(';
	    			
		    		if (isset($join_params['join_type'])) $join_str .= '"join_type" => "'. $join_params['join_type']  .'",';
		    		if (isset($join_params['table'])) $join_str .= '"table" => "' . $join_params['table'] .'",';
		    		if (isset($join_params['jt_field'])) $join_str .= '"jt_field" => "' . $join_params['jt_field'] .'",';
		    		if (isset($join_params['e_field'])) $join_str .= '"e_field" => "' . $join_params['e_field'] .'",';
		    		if (isset($join_params['j_sub_q'])) $join_str .= '"j_sub_q" => "' . $join_params['j_sub_q'] .'",';
		    		if (str_ends_with($join_str, ",")) $join_str = substr($join_str, 0, strlen($join_str)-1);
		    		$join_str .= ')';
	    		}
	    		$phpCode = '$objects = '.$handler_class.'::findAll(array("conditions" => "`e`.`object_id` IN ('.implode(',', $ids).')", "order" => "'.str_replace("ORDER BY ", "", $order_conditions).'"'.$join_str.'));';
	    		eval($phpCode);
	    	}
    	}
    	

    	$result = new stdClass();
    	$result->objects = $objects ;
    	$result->total = $total ;
    	
    	return $result ;
	}
	
	static function prepareJoinConditions($join_params){
        if (!$join_params) {
    		$join_conditions = "";
        } else {
    		if (isset($join_params['join_type'])){
    			$join_type = strtoupper($join_params['join_type']);
    		}else{
    			$join_type = "INNER";
    		}
	    	
    		if (array_var($join_params, 'e_field')) {
	      		$on_cond = "`e`.`".$join_params['e_field']."` = `jt`.`".$join_params['jt_field']."`";
	      		if (array_var($join_params, 'on_extra')) {
	      			$on_cond = "`e`.`".$join_params['e_field']."` = `jt`.`".$join_params['jt_field']."` ".$join_params['on_extra'];
	      		}
	      	} else if (array_var($join_params, 'j_sub_q')) {
	      		$on_cond = "`jt`.`".$join_params['jt_field']."` = (" . array_var($join_params, 'j_sub_q') . ")";
	      	}
    		$join_conditions = $join_type." JOIN `".$join_params['table']."` `jt` ON " . $on_cond;
    	}
    	return $join_conditions;
    }
    
    
    static function prepareTrashAndArchivedConditions($trashed, $archived){
        $trashed_cond = "`o`.`trashed_on` " .($trashed ? ">" : "="). " " . DB::escape(EMPTY_DATETIME);
    	if ($trashed) {
    		$archived_cond = "";
    	} else {
    		$archived_cond = "AND `o`.`archived_on` " .($archived ? ">" : "="). " " . DB::escape(EMPTY_DATETIME);
    	}
    	if ($trashed && Plugins::instance()->isActivePlugin('mail')) {
    		$mcot_id = MailContents::instance()->getObjectTypeId();
    		$trashed_cond .= " AND IF(o.object_type_id=$mcot_id, NOT (SELECT mcx.is_deleted FROM ".TABLE_PREFIX."mail_contents mcx WHERE mcx.object_id=o.id), 1)";
    	}
    	return array($trashed_cond, $archived_cond);
    }
    
    
    static function prepareOrderConditions($order, $order_dir){
    	$order_conditions = "";
    	if (is_null($order_dir)) $order_dir = "DESC";
    	if ($order && $order_dir){
    		if (!is_array($order)) $order_conditions = "ORDER BY $order $order_dir";
    		else {
    			$i = 0;
    			foreach($order as $o){
    				switch ($o) {
    					case 'dateDeleted': $o = 'trashed_on'; break;
    					case 'dateUpdated': $o = 'updated_on'; break;
    					case 'dateCreated': $o = 'created_on'; break;
    					case 'dateArchived': $o = 'archived_on'; break;
    					default: break;
    				}
    				if ($i==0)$order_conditions.= "ORDER BY $o $order_dir";
    				else $order_conditions.= ", $o $order_dir";
    				$i++;
    			}
    		}
    	}
    	return $order_conditions;
    }
    
    static function prepareDimensionConditions($context, $object_type_id){
  	
    	//get contact's permission groups ids
    	$pg_ids = ContactPermissionGroups::getPermissionGroupIdsByContactCSV(logged_user()->getId(), false);    	

    	$all_dim_in_all_conditions = "";
    	$dm_conditions = "";
    	
    	$context_dimensions = array ();
    	$selection_members = array();// - stores the ids of all members selected in context
    	$selected_dimensions = array();// - stores the ids of all dimensions selected in context
    	$properties = array(); //- stores associations between dimensions
    	$redefined_context = array();// - if there are dimensions that are associated to another dimension in the context, we may need to redefine the context

    	foreach ($context as $selection) {
    		if ($selection instanceof Member){
    			$selection_members[]=$selection;
    		}
    	}
    	
    	$member_count = 0;
    	foreach ($context as $selection) {
    		if ($selection instanceof Member){
    			// condiciones para filtrar por el miembro seleccionado
    			$member_count++;
    			$dimension = $selection->getDimension();
    			$dimension_id = $dimension->getId();
    			$selected_dimensions[] = $dimension;
    			$context_dimensions[$dimension_id]['allowed_members'] = array(); // - stores the ids of the members where we must search for objects
    			
    			
    		   	$context_dimensions[$dimension_id]['allowed_members'][] =  $selection->getId();
    			
    			$children = $selection->getAllChildrenInHierarchy();
    			foreach($children as $child) {
    				$context_dimensions[$dimension_id]['allowed_members'][] = $child->getId();
    			}
    			
    			if ($dimension->canContainObjects()){
    				$allowed_members = $context_dimensions[$dimension_id]['allowed_members'];
    				$dm_conditions .= self::prepareQuery($dm_conditions, $dimension, $allowed_members, $object_type_id, $pg_ids, 'AND', $selection_members);
    				$redefined_context[] = $dimension_id;
    			}
    			else{ 
	    		    //let's check if this dimension is property of another	
	    			$associated_dimensions_ids = $dimension->getAssociatedDimensions();
	    			if (count($associated_dimensions_ids)>0){
	    				foreach ($associated_dimensions_ids as $aid){
	    					$properties[$dimension_id][] = $aid;
	    				}
	    			}
    			}
    		}
    		else{
    			// condiciones para cuando se selecciona "all" en todas las dimensiones visibles
    			$all_members = $selection->getAllMembers();
    			foreach($all_members as $member) {
    				$context_dimensions[$selection->getId()]['allowed_members'][] = $member->getId();
    			}
    			//get all the content object type ids that can hang in the dimension
    			if ($selection->canContainObjects()){
    				if (!isset($context_dimensions[$selection->getId()])) $context_dimensions[$selection->getId()] = array();
	    			$allowed_members = array_var($context_dimensions[$selection->getId()], 'allowed_members', array());
	    			$all_dim_in_all_conditions .= self::prepareQuery($all_dim_in_all_conditions, $selection, $allowed_members, $object_type_id, $pg_ids, 'OR', $selection_members, true);
    			}
    		}
    	}
    	
    	// Si esta parado en 'all' de todas las dimensiones visibles aplico la condicion de que el objeto pertenezca a algun miembro de las dimensiones al cual yo tenga permisos
    	if ($member_count == 0) $dm_conditions .= $all_dim_in_all_conditions;
    	
    	if(count($properties)>0){
    		foreach ($properties as $property=>$values){
    			foreach ($values as $dim_id){
    				if (!in_array($dim_id, $redefined_context)){
    					$redefined_context[] = $dim_id;
    				}
    			}
    		}
    		return self::prepareAssociationConditions($redefined_context, $context_dimensions, $properties, $object_type_id, $pg_ids, $selection_members);
	    }
    	
    	$dimensions = Dimensions::findAll();
    	foreach ($dimensions as $dimension){
    		if ($dimension->canContainObjects() && !in_array($dimension, $context) && !in_array($dimension, $selected_dimensions) &&
    			!($dimension->getOptions(1) && isset($dimension->getOptions(1)->hidden) && $dimension->getOptions(1)->hidden)){
    			$member_ids = array();
    			$all_members = $dimension->getAllMembers();
    			foreach($all_members as $member) {
    				$member_ids[] = $member->getId();
    			}
    			$dm_conditions .= self::prepareQuery($dm_conditions, $dimension, $member_ids, $object_type_id, $pg_ids, 'OR', $selection_members, true);
    		}
	    }
    	
    	
    	return $dm_conditions;
    }
    
    /**
     * @deprecated
     * Enter description here ...
     * @param unknown_type $dm_conditions
     * @param unknown_type $dimension
     * @param unknown_type $member_ids
     * @param unknown_type $object_type_id
     * @param unknown_type $pg_ids
     * @param unknown_type $operator
     * @param unknown_type $selection_members
     * @param unknown_type $all
     */
    static function prepareQuery($dm_conditions, $dimension, $member_ids, $object_type_id, $pg_ids, $operator, $selection_members, $all = false){
    	$permission_conditions ="";
    	$member_ids_csv = count($member_ids) > 0 ? implode(",", $member_ids) : '0';
    	$check = $dimension->getDefinesPermissions() && !$dimension->hasAllowAllForContact($pg_ids);
    	if ($check){
    		
    	    // context permissions
    	    $context_conditions = "";
    	    $context_permission_member_ids = array();
    		$context_permission_member_ids = ContactMemberPermissions::getActiveContextPermissions(logged_user(),$object_type_id, $selection_members, $member_ids);
    		if (count($context_permission_member_ids)!= 0) {
		    	$context_conditions .= "OR EXISTS (SELECT `om2`.`object_id` FROM `".TABLE_PREFIX."object_members` `om2` WHERE
	    							`om2`.`object_id` = `om`.`object_id` AND `o`.`object_type_id` = $object_type_id 
	    							AND `om2`.`member_id` IN (" .implode(",", $context_permission_member_ids)."))";
		    }
	    	
    		$permission_conditions = "AND EXISTS (SELECT `cmp`.`member_id` FROM `".TABLE_PREFIX."contact_member_permissions` 
    						`cmp` WHERE `om2`.`member_id` = `cmp`.`member_id` AND `cmp`.`permission_group_id` IN ($pg_ids) AND 
    						`o`.`object_type_id` = `cmp`.`object_type_id`) $context_conditions";
    		
    	}
    	$not_exists = "OR NOT EXISTS (SELECT `om2`.`object_id` FROM `".TABLE_PREFIX."object_members` `om2` WHERE
    						`om2`.`object_id` = `om`.`object_id` AND `om2`.`member_id` IN (".$member_ids_csv.")
    						AND `om2`.`is_optimization` = 0)";
    	
    	$dm_condition = "EXISTS (SELECT `om2`.`object_id` FROM `".TABLE_PREFIX."object_members` `om2` WHERE
    						`om2`.`object_id` = `om`.`object_id` AND `om2`.`member_id` IN (".$member_ids_csv.")
    						AND `om2`.`is_optimization` = 0 $permission_conditions)";
    	
    	if ($all){
    		$condition = "($dm_condition $not_exists)";
    		$operator = "AND";
    	} 
    	else $condition = $dm_condition;
    	$dm_conditions = $dm_conditions != "" ? " $operator $condition" : " $condition";
    	
    	return $dm_conditions;
    }
    
    
    static function prepareAssociationConditions($redefined_context, $dimensions, $properties, $object_type_id, $pg_ids, $selection_members){
    	
    	$is_property = array();
    	foreach ($properties as $p=>$value){
	    		//obtener miembros de la dimension asociada que tienen como propiedad los miembros seleccionados de esta dimension
	    		foreach ($value as $v){
	    			$associations = DimensionMemberAssociations::getAllAssociations($v, $p);
			    		if (!is_null($associations)){
			    			foreach ($associations as $association){
			    				$is_property[$v] = true;
			    				$v_ids_csv = is_array($dimensions[$v]['allowed_members']) && count($dimensions[$v]['allowed_members']) > 0 ? implode(",",$dimensions[$v]['allowed_members']) : '0';
			    				$p_ids_csv = is_array($dimensions[$p]['allowed_members']) && count($dimensions[$p]['allowed_members']) > 0 ? implode(",",$dimensions[$p]['allowed_members']): '0';
			    				$prop_members = MemberPropertyMembers::getAssociatedMembers($association->getId(),$v_ids_csv, $p_ids_csv);
			    				if (count($prop_members)>0)
			    					$property_members[] = $prop_members;
			    			}
			    		}
	    		}
	    }
    		
    	// intersect the allowed members for each property
    	$member_intersection = array_var($property_members, 0, array());
    	if (count($property_members) > 1) {
    		$k = 1;
    		while ($k < count($property_members)) {
    			$member_intersection = array_intersect($member_intersection, $property_members[$k++]);
    		}
    	}

    	$association_conditions = "";
    	foreach ($redefined_context as $key=>$value){
	    		$dimension = Dimensions::getDimensionById($value);
	    		if (!isset($is_property[$value])) $member_ids = $dimensions[$value]['allowed_members'];
	    		else $member_ids = $member_intersection;
	    		$association_conditions.= self::prepareQuery($association_conditions, $dimension, $member_ids,$object_type_id, $pg_ids, 'AND', $selection_members);
    	}
    	$dims = Dimensions::findAll();
    	foreach ($dims as $dim){
    		if (!in_array($dim->getId(), $redefined_context) && !isset($properties[$dim->getId()]) && $dim->canContainObjects()){
    			$member_ids = array();
    			$all_members = $dim->getAllMembers();
    			foreach($all_members as $member) {
    				$member_ids[] = $member->getId();
    			}
		    	$association_conditions.= self::prepareQuery($association_conditions, $dim, $member_ids, $object_type_id, $pg_ids, 'OR', $selection_members, true);
	    			
    		}
    	}
    	
    	return $association_conditions;
    }
    
    
    
    
    function getExternalColumnValue($field, $id) {
    	return "";
    }
    
    
    
	function populateTimeslots($objects_list){
		if (is_array($objects_list) && count($objects_list) > 0 && $objects_list[0]->allowsTimeslots() && $objects_list[0] instanceof ContentDataObject){
			$ids = array();
			$objects = array();
			for ($i = 0; $i < count($objects_list); $i++){
				$ids[] = $objects_list[$i]->getId();
				$objects[$objects_list[$i]->getId()] = $objects_list[$i];
				$objects_list[$i]->timeslots = array();
				$objects_list[$i]->timeslots_count = 0;
			}
			if (count($ids > 0)){
				$result = Timeslots::instance()->listing(array(
					"extra_conditions" => ' AND `e`.`object_id` in (' . implode(',', $ids) . ')'
				));
				$timeslots = $result->objects;
				for ($i = 0; $i < count($timeslots); $i++){
					$object = $objects[$timeslots[$i]->getRelObjectId()];
					$object->timeslots[] = $timeslots[$i];
					$object->timeslots_count = count($object->timeslots);
				}
			}
		}
	}
	
	
	private $member_info_cache = array();
	function getCachedMembersInfo($member_ids) {
		if ($member_ids == null) $member_ids = array();
		
		$res = array();
		$not_found = array();
		foreach ($member_ids as $mid) {
			if (isset($this->member_info_cache[$mid])) {
				$res[] = $this->member_info_cache[$mid];
			} else {
				$not_found[] = $mid;
			}
		}
		
		if (count($not_found) > 0) {
			$db_res = DB::execute("SELECT id, name, dimension_id, object_type_id FROM ".TABLE_PREFIX."members WHERE id IN (".implode(",",$not_found).")");
			$members = $db_res->fetchAll();
			if (is_array($members)) {
				foreach ($members as $m) {
					$this->member_info_cache[$m['id']] = $m;
					$res[] = $m;
				}
			}
		}
		
		return $res;
	}
}