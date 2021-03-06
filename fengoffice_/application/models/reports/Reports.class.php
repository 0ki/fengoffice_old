<?php

/**
 *   Reports class
 *
 * @author Pablo Kamil <pablokam@gmail.com>
 */

class Reports extends BaseReports {

	/**
	 * Return specific report
	 *
	 * @param $id
	 * @return Report
	 */
	static function getReport($id) {
		return self::findOne(array(
			'conditions' => array("`id` = ?", $id)
		)); // findOne
	} //  getReport

	/**
	 * Return all reports for an object type
	 *
	 * @param $object_type
	 * @return array
	 */
	static function getAllReportsForObjectType($object_type) {
		return self::findAll(array(
			'conditions' => array("`object_type` = ?", $object_type)
		)); // findAll
	} //  getAllReportsForObjectType

	/**
	 * Return all reports
	 *
	 * @return array
	 */
	static function getAllReports() {
		return self::findAll();// findAll
	} //  getAllReports

	/**
	 * Return all reports
	 *
	 * @return array
	 */
	static function getAllReportsByObjectType() {
		$reports = self::findAll();// findAll
		$result = array();
		foreach ($reports as $report){
			if (array_key_exists($report->getObjectType(), $result))
			$result[$report->getObjectType()][] = $report;
			else
			$result[$report->getObjectType()] = array($report);
		}
		return $result;
	} //  getAllReports

	/**
	 * Execute a report and return results
	 *
	 * @param $id
	 * @param $params
	 *
	 * @return array
	 */
	static function executeReport($id, $params, $offset=0, $limit=50) {
		$results = array();
		$report = self::getReport($id);
		if($report instanceof Report){
			$conditionsFields = ReportConditions::getAllReportConditionsForFields($id);
			$conditionsCp = ReportConditions::getAllReportConditionsForCustomProperties($id);
			$table = '';
			$object = null;
			$controller = '';
			$view = '';
			eval('$managerInstance = ' . $report->getObjectType() . "::instance();");
			if($report->getObjectType() == 'Companies'){
				$table = 'companies';
				$controller = 'company';
				$view = 'card';
				$object = new Company();
			}else if($report->getObjectType() == 'Contacts'){
				$table = 'contacts';
				$controller = 'contact';
				$view = 'card';
				$object = new Contact();
			}else if($report->getObjectType() == 'MailContents'){
				$table = 'mail_contents';
				$controller = 'mail';
				$view = 'view';
				$object = new MailContent();
			}else if($report->getObjectType() == 'ProjectEvents'){
				$table = 'project_events';
				$controller = 'event';
				$view = 'viewevent';
				$object = new ProjectEvent();
			}else if($report->getObjectType() == 'ProjectFiles'){
				$table = 'project_files';
				$controller = 'files';
				$view = 'file_details';
				$object = new ProjectFile();
			}else if($report->getObjectType() == 'ProjectMilestones'){
				$table = 'project_milestones';
				$controller = 'milestone';
				$view = 'view';
				$object = new ProjectMilestone();
			}else if($report->getObjectType() == 'ProjectMessages'){
				$table = 'project_messages';
				$controller = 'message';
				$view = 'view';
				$object = new ProjectMessage();
			}else if($report->getObjectType() == 'ProjectTasks'){
				$table = 'project_tasks';
				$controller = 'task';
				$view = 'view_task';
				$object = new ProjectTask();
			}else if($report->getObjectType() == 'Users'){
				$table = 'users';
				$controller = 'user';
				$view = 'card';
				$object = new User();
			}else if($report->getObjectType() == 'ProjectWebpages'){
				$table = 'project_webpages';
				$controller = 'webpage';
				$view = 'view';
				$object = new ProjectWebpage();
			}else if($report->getObjectType() == 'Projects'){
				$table = 'projects';
				$controller = 'project';
				$view = '';
				$object = new Project();
			}
			$order_by = '';

			$sql = 'SELECT id FROM '.TABLE_PREFIX.$table.' t WHERE ';
			$manager = $report->getObjectType();
			$sql .= permissions_sql_for_listings(new $manager(), ACCESS_LEVEL_READ, logged_user(), 'project_id', 't');
			if(count($conditionsFields) > 0){
				foreach($conditionsFields as $condField){
					if ($condField->getFieldName() == 'workspace' || $condField->getFieldName() == 'tag' ){	//if has a tag or workspace condition
						if ($condField->getFieldName() == 'workspace'){
							//if is a workspace condition:
							$fiterUsingWorkspace = true;
							if ($condField->getIsParametrizable() && isset ($params['workspace'])){
								//if is parameter condition and is set the parameter
								$ws_value = $params['workspace'];
							}else{
								//if is a fixed workspace value and is set
								$val = $condField->getValue();
								if (isset($val)){
									$ws_value = $val;
								}else{
									//if there is no workspace to filter with it doesnt filter at all.
									$fiterUsingWorkspace = false;
								}
							}
						}
						if ($condField->getFieldName() == 'tag'){
							//if is a tag condition:
							$fiterUsingTag = true;
							if ($condField->getIsParametrizable() && isset ($params['tags'])){
								//if is parameter condition and is set the parameter
								$tags_csv = $params['tags'];
								$tags = explode(',', $tags_csv);
								$tag_value = trim($tags[0]);
							}else{
								//if is a fixed tag value and is set
								$tval = $condField->getValue();
								if (isset ($tval)){
									$tag_value = trim(trim($tval),',');									
								}else{
									//if there is no tag to filter with it doesnt filter at all.
									$fiterUsingTag = false;
								}
							}
						}
						
					}else{
						$skip_condition = false;
						$model = $report->getObjectType();
						$model_instance = new $model();
						$col_type = $model_instance->getColumnType($condField->getFieldName());
	
						$sql .= ' AND ';
						$dateFormat = 'm/d/Y';
						if(isset($params[$condField->getId()])){
							$value = $params[$condField->getId()];
							if ($col_type == DATA_TYPE_DATE || $col_type == DATA_TYPE_DATETIME)
							$dateFormat = user_config_option('date_format', 'd/m/Y');
						}else{
							$value = $condField->getValue();
						}
						if ($value == '' && $condField->getIsParametrizable()) $skip_condition = true;
						if (!$skip_condition) {
							if($condField->getCondition() == 'like' || $condField->getCondition() == 'not like'){
								$value = '%'.$value.'%';
							}
							if ($col_type == DATA_TYPE_DATE || $col_type == DATA_TYPE_DATETIME) {
								$dtValue = DateTimeValueLib::dateFromFormatAndString($dateFormat, $value);
								$value = $dtValue->format('Y-m-d');
							}
							if($condField->getCondition() != '%'){
								if ($col_type == DATA_TYPE_INTEGER || $col_type == DATA_TYPE_FLOAT) {
									$sql .= '`'.$condField->getFieldName().'` '.$condField->getCondition().' '.mysql_real_escape_string($value);
								}else{
									$sql .= '`'.$condField->getFieldName().'` '.$condField->getCondition().' \''.mysql_real_escape_string($value).'\'';
								}
							}else{
								$sql .= '`'.$condField->getFieldName().'` like "%'.mysql_real_escape_string($value).'"';
							}
						} else $sql .= ' true';
					}//else
				}//foreach
			}
			if(count($conditionsCp) > 0){

				foreach($conditionsCp as $condCp){
					$cp = CustomProperties::getCustomProperty($condCp->getCustomPropertyId());

					$skip_condition = false;
					$dateFormat = 'm/d/Y';
					if(isset($params[$cp->getName()])){
						$value = $params[$cp->getName()];
						if ($cp->getType() == 'date')
						$dateFormat = user_config_option('date_format', 'd/m/Y');
					}else{
						$value = $condCp->getValue();
					}
					if ($value == '' && $condCp->getIsParametrizable()) $skip_condition = true;
					if (!$skip_condition) {
						$sql .= ' AND ';
						$sql .= 't.id IN ( SELECT object_id as id FROM '.TABLE_PREFIX.'custom_property_values cpv WHERE ';
						$sql .= ' cpv.custom_property_id = '.$condCp->getCustomPropertyId();
						$fieldType = $object->getColumnType($condCp->getFieldName());

						if($condCp->getCondition() == 'like' || $condCp->getCondition() == 'not like'){
							$value = '%'.$value.'%';
						}
						if ($cp->getType() == 'date') {
							$dtValue = DateTimeValueLib::dateFromFormatAndString($dateFormat, $value);
							$value = $dtValue->format('Y-m-d H:i:s');
						}
						if($condCp->getCondition() != '%'){
							if ($cp->getType() == 'numeric') {
								$sql .= ' AND cpv.value '.$condCp->getCondition().' '.mysql_real_escape_string($value);
							}else{
								$sql .= ' AND cpv.value '.$condCp->getCondition().' "'.mysql_real_escape_string($value).'"';
							}
						}else{
							$sql .= ' AND cpv.value like "%'.mysql_real_escape_string($value).'"';
						}
						$sql .= ')';
					}
				}
			}
			// FILTER USING WORKSPACES AND TAGS
			if(isset($fiterUsingWorkspace)&& $fiterUsingWorkspace && $ws_value != 0)
			{
				if ($manager == 'Contacts'){
					$sql .= ' AND t.id IN (SELECT contact_id FROM ' . TABLE_PREFIX . 'project_contacts WHERE project_id = '. $ws_value .')';
				} else {
					$sql .= ' AND t.id IN (SELECT object_id FROM ' . TABLE_PREFIX . 'workspace_objects WHERE object_manager = \''. $manager .'\' AND workspace_id = '. $ws_value .')';
				}
			}
			if(isset($fiterUsingTag)&& $fiterUsingTag && $tag_value != '')
			{
				$sql .= ' AND t.id IN (SELECT rel_object_id FROM ' . TABLE_PREFIX . 'tags WHERE rel_object_manager = \''. $manager .'\' AND tag = \''. $tag_value .'\')';
			}
					
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();

			$totalResults = count($rows);
				
			$sql .= ' LIMIT '.$offset.','.$limit;
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();
			$ids = array();
			foreach($rows as $row){
				$ids[] = $row['id'];
			}
			if(count($ids) == 0) return;
				
			$results['pagination'] = Reports::getReportPagination($id, $params, $offset, $limit, $totalResults);

			$selectCols = 'distinct(t.id) as "id"';
			$titleCols = $managerInstance->getReportObjectTitleColumns();
			foreach($titleCols as $num => $title){
				$selectCols .= ', t.'.$title.' as "titleCol'.$num.'"';
			}
			$columnsFields = ReportColumns::getAllReportColumnNamesForFields($id);
			if(count($columnsFields) > 0){
				$first = true;
				foreach($columnsFields as $field){
					$selectCols .= ', t.'.$field;
					$results['columns'][] = lang('field '.$report->getObjectType().' '.$field);
					$first = false;
				}
			}
			$selectFROM = TABLE_PREFIX.$table.' t ';
			if (is_array($ids) && count($ids) > 0)
			$selectWHERE = ' WHERE t.id IN('.implode(',', $ids).')';
			else $selectWHERE = ' WHERE false'; // no objects to display
			$columnsCp = ReportColumns::getAllReportColumnsForCustomProperties($id);
			$first = true;
			$openPar = '';
			foreach($columnsCp as $id => $colCp){
				$cp = CustomProperties::getCustomProperty($colCp);
				$selectCols .= ', cpv'.$id.'.value as "'.$cp->getName().'"';
				$results['columns'][] = $cp->getName();
				$openPar .= '(';
				$selectFROM .= ' LEFT OUTER JOIN '.TABLE_PREFIX.'custom_property_values cpv'.$id.' ON (t.id = cpv'.$id.'.object_id AND cpv'.$id.'.custom_property_id = '.$colCp .'))';
				$first = false;
				if($report->getOrderBy() == $colCp){
					if($cp->getType() == 'date'){
						$order_by = 'ORDER BY STR_TO_DATE(cpv'.$id.'.value, "%Y-%m-%d %H:%i:%s") '.($report->getIsOrderByAsc() ? 'asc' : 'desc');
					}else{
						$order_by = 'ORDER BY cpv'.$id.'.value '.($report->getIsOrderByAsc() ? 'asc' : 'desc');
					}
				}
			}
			if($order_by == '') {
				if(is_numeric($report->getOrderBy())){
					$id = $report->getOrderBy();
					$openPar .= '(';
					$selectFROM .= ' LEFT OUTER JOIN '.TABLE_PREFIX.'custom_property_values cpv'.$id.' ON (t.id = cpv'.$id.'.object_id AND cpv'.$id.'.custom_property_id = '.$id . '))';
					$order_by = 'ORDER BY '.$report->getOrderBy();
				}else{
					if($object->getColumnType($report->getOrderBy()) == 'date'){
						$order_by = 'ORDER BY STR_TO_DATE(t.'.$report->getOrderBy().', "%Y-%m-%d %H:%i:%s") '.($report->getIsOrderByAsc() ? 'asc' : 'desc');
					}else{
						$order_by = 'ORDER BY t.'.$report->getOrderBy().' '.($report->getIsOrderByAsc() ? 'asc' : 'desc');
					}
				}
			}
			$sql = 'SELECT '.$selectCols.' FROM ('.$openPar.$selectFROM.') '.$selectWHERE.' GROUP BY id '.$order_by;
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();
			$rows = Reports::removeDuplicateRows($rows);
			foreach($rows as &$row){
				$title = $managerInstance->getReportObjectTitle($row);
				$id = $row['id'];
				unset($row['id']);
				$row = array_slice($row, count($titleCols));
				$row = array('link' => '<a class="internalLink" target="new" href="'.get_url($controller, $view, array('id' => $id)).'">'.$title.'</a>') + $row;
				foreach($row as $col => &$value){
					if(in_array($col, $managerInstance->getExternalColumns())){
						$value = self::getExternalColumnValue($col, $value);
					}
				}
				$row = str_replace('|', ',', $row);
			}
			array_unshift($results['columns'], '');
			$results['rows'] = $rows;
		}

		return $results;
	} //  executeReport
	
	static function removeDuplicateRows($rows){
		$duplicateIds = array();
		foreach($rows as $row){
			if (!isset($duplicateIds[$row['id']])) $duplicateIds[$row['id']] = 0;
			$duplicateIds[$row['id']]++;
		}
		foreach($duplicateIds as $id => $count){
			if($count < 2){
				unset($duplicateIds[$id]);
			}
		}
		$duplicateIds = array_keys($duplicateIds);
		foreach($rows as $row){
			if(in_array($row['id'], $duplicateIds)){
				alert(implode(',',array_keys($row)));
				foreach($row as $col => $value){
					$cp = CustomProperties::getCustomProperty($col);
					if($cp instanceof CustomProperty && $cp->getIsMultipleValues()){
						alert($cp->getCustomPropertyId());
					}
				}
			}
		}
		//alert(implode(',', array_keys($duplicateIds)));
		return $rows;
	}

	static function getReportPagination($report_id, $params, $offset, $limit, $total){
		if($total == 0) return '';
		$a_nav = array('[&lt;&lt;]', '[&lt;]', '[&gt;]', '[&gt;&gt;]');
		$page = intval($offset / $limit);
		$totalPages = ceil($total / $limit);
		if($totalPages == 1) return '';

		$parameters = '';
		if(is_array($params) && count($params) > 0){
			foreach($params as $id => $value){
				$parameters .= '&params['.$id.']='.$value;
			}
		}
		
		$nav = '';
		if($page != 0){
			$nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => '0', 'limit' => $limit)).$parameters.'">'.sprintf($a_nav[0], $offset).'</a>';
			$off = $offset - $limit;
			$nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => $off, 'limit' => $limit)).$parameters.'">'.$a_nav[1].'</a>&nbsp;';
		}
		for($i = 1; $i < $totalPages + 1; $i++){
			$off = $limit * ($i - 1);
			if(($i != $page + 1) && abs($i - 1 - $page) <= 2 ) $nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => $off, 'limit' => $limit)).$parameters.'">'.$i.'</a>&nbsp;&nbsp;';
			else if($i == $page + 1) $nav .= $i.'&nbsp;&nbsp;';
		}
		if($page < $totalPages - 1){
			$off = $offset + $limit;
			$nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => $off, 'limit' => $limit)).$parameters.'">'.$a_nav[2].'</a>';
			$off = $limit * ($totalPages - 1);
			$nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => $off, 'limit' => $limit)).$parameters.'">'.$a_nav[3].'</a>';
		}
		return $nav;
	}

	static function getExternalColumnValue($field, $id){
		$value = '';
		if($field == 'company_id' || $field == 'assigned_to_company_id'){
			$company = Companies::findById($id);
			if($company instanceof Company) $value = $company->getName();
		}else if($field == 'user_id' || $field == 'created_by_id' || $field == 'updated_by_id' || $field == 'assigned_to_user_id' || $field == 'completed_by_id'){
			$user = Users::findById($id);
			if($user instanceof User) $value = $user->getUsername();
		}else if($field == 'milestone_id'){
			$milestone = ProjectMilestones::findById($id);
			if($milestone instanceof ProjectMilestone) $value = $milestone->getName();
		}
		return $value;
	}

} // Reports

?>