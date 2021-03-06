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
	static function executeReport($id, $params, $order_by_col = '', $order_by_asc = true, $offset=0, $limit=50, $to_print = false) {
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
			$allConditions = permissions_sql_for_listings(new $manager(), ACCESS_LEVEL_READ, logged_user(), 'project_id', 't');
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
							$wsCondition = $condField->getCondition();
						}
						if ($condField->getFieldName() == 'tag'){
							//if is a tag condition:
							$fiterUsingTag = true;
							if ($condField->getIsParametrizable() && isset ($params['tag'])){
								//if is parameter condition and is set the parameter
								$tags_csv = $params['tag'];
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
							$tagCondition = $condField->getCondition();
						}
						
					}else{
						$skip_condition = false;
						$model = $report->getObjectType();
						$model_instance = new $model();
						$col_type = $model_instance->getColumnType($condField->getFieldName());
	
						$allConditions .= ' AND ';
						$dateFormat = 'm/d/Y';
						if(isset($params[$condField->getId()])){
							$value = $params[$condField->getId()];
							if ($col_type == DATA_TYPE_DATE || $col_type == DATA_TYPE_DATETIME)
							$dateFormat = user_config_option('date_format');
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
									$allConditions .= '`'.$condField->getFieldName().'` '.$condField->getCondition().' '.mysql_real_escape_string($value);
								}else{
									$allConditions .= '`'.$condField->getFieldName().'` '.$condField->getCondition().' \''.mysql_real_escape_string($value).'\'';
								}
							}else{
								$allConditions .= '`'.$condField->getFieldName().'` like "%'.mysql_real_escape_string($value).'"';
							}
						} else $allConditions .= ' true';
					}//else
				}//foreach
			}
			if(count($conditionsCp) > 0){

				foreach($conditionsCp as $condCp){
					$cp = CustomProperties::getCustomProperty($condCp->getCustomPropertyId());

					$skip_condition = false;
					$dateFormat = 'm/d/Y';
					if(isset($params[$condCp->getId()."_".$cp->getName()])){
						$value = $params[$condCp->getId()."_".$cp->getName()];
						if ($cp->getType() == 'date')
						$dateFormat = user_config_option('date_format');
					}else{
						$value = $condCp->getValue();
					}
					if ($value == '' && $condCp->getIsParametrizable()) $skip_condition = true;
					if (!$skip_condition) {
						$allConditions .= ' AND ';
						$allConditions .= 't.id IN ( SELECT object_id as id FROM '.TABLE_PREFIX.'custom_property_values cpv WHERE ';
						$allConditions .= ' cpv.custom_property_id = '.$condCp->getCustomPropertyId();
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
								$allConditions .= ' AND cpv.value '.$condCp->getCondition().' '.mysql_real_escape_string($value);
							}else{
								$allConditions .= ' AND cpv.value '.$condCp->getCondition().' "'.mysql_real_escape_string($value).'"';
							}
						}else{
							$allConditions .= ' AND cpv.value like "%'.mysql_real_escape_string($value).'"';
						}
						$allConditions .= ')';
					}
				}
			}
			// FILTER USING WORKSPACES AND TAGS
			if(isset($fiterUsingWorkspace)&& $fiterUsingWorkspace && $ws_value != 0)
			{
				$parentWS = Projects::findById($ws_value);
				if($parentWS instanceof Project){
					$subWorkspaces = $parentWS->getSubWorkspaces();
					foreach($subWorkspaces as $subWS){
						$ws_value .= ','.$subWS->getId();
					}
				}
				if ($manager == 'Contacts'){
					$allConditions .= ' AND t.id '.($wsCondition == '=' ? 'IN' : 'NOT IN').' (SELECT contact_id FROM ' . TABLE_PREFIX . 'project_contacts WHERE project_id IN ( '. $ws_value .'))';
				} else {
					$allConditions .= ' AND t.id '.($wsCondition == '=' ? 'IN' : 'NOT IN').' (SELECT object_id FROM ' . TABLE_PREFIX . 'workspace_objects WHERE object_manager = \''. $manager .'\' AND workspace_id IN ( '. $ws_value .'))';
				}
			}
			if(isset($fiterUsingTag)&& $fiterUsingTag && $tag_value != '')
			{
				$allConditions .= ' AND t.id '.($tagCondition == '=' ? 'IN' : 'NOT IN').' (SELECT rel_object_id FROM ' . TABLE_PREFIX . 'tags WHERE rel_object_manager = \''. $manager .'\' AND tag = \''. $tag_value .'\')';
			}
			if ($manager != 'Projects' && $manager != 'Users') {
				$allConditions .= ' AND t.trashed_by_id = 0 ';
			}
			
			$sql .= $allConditions;
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();

			$totalResults = count($rows);
			$results['pagination'] = Reports::getReportPagination($id, $params, $order_by_col, $order_by_asc, $offset, $limit, $totalResults);

			$selectCols = 'distinct(t.id) as "id"';
			$titleCols = $managerInstance->getReportObjectTitleColumns();
			$titleColAlias = array();
			foreach($titleCols as $num => $title){
				$selectCols .= ', t.'.$title.' as "titleCol'.$num.'"';
				$titleColAlias['titleCol'.$num] = $title;
			}

			$selectFROM = TABLE_PREFIX.$table.' t ';
			$selectWHERE = "WHERE $allConditions";
			
			$order = $order_by_col != '' ? $order_by_col : $report->getOrderBy();
			$order_asc = $order_by_col != '' ? $order_by_asc : $report->getIsOrderByAsc();
			$allColumns = ReportColumns::getAllReportColumns($id);
			if(is_array($allColumns) && count($allColumns) > 0){
				$first = true;
				$openPar = '';
				foreach($allColumns as $column){
					if ($column->getCustomPropertyId() == 0) {
						$field = $column->getFieldName();
						if ($managerInstance->columnExists($field)) {
							$selectCols .= ', t.'.$field;
							$results['columns'][] = lang('field '.$report->getObjectType().' '.$field);
							$results['db_columns'][lang('field '.$report->getObjectType().' '.$field)] = $field;
							$first = false;
						}
					} else {
						$colCp = $column->getCustomPropertyId();
						$cp = CustomProperties::getCustomProperty($colCp);
						if ($cp instanceof CustomProperty) {
							$selectCols .= ', cpv'.$colCp.'.value as "'.$cp->getName().'"';
							$results['columns'][] = $cp->getName();
							$results['db_columns'][$cp->getName()] = $colCp;
							
							$openPar .= '(';
							$selectFROM .= ' LEFT OUTER JOIN '.TABLE_PREFIX.'custom_property_values cpv'.$colCp.' ON (t.id = cpv'.$colCp.'.object_id AND cpv'.$colCp.'.custom_property_id = '.$colCp .'))';
							$first = false;
							if($order == $colCp){
								if($cp->getType() == 'date'){
									$order_by = 'ORDER BY STR_TO_DATE(cpv'.$colCp.'.value, "%Y-%m-%d %H:%i:%s") '.($order_asc ? 'asc' : 'desc');
								}else{
									$order_by = 'ORDER BY cpv'.$colCp.'.value '.($order_asc ? 'asc' : 'desc');
								}
							}
						}
					}
				}
			}
			if($order_by == '') {
				if(is_numeric($order)){
					$id = $order;
					$openPar .= '(';
					$selectFROM .= ' LEFT OUTER JOIN '.TABLE_PREFIX.'custom_property_values cpv'.$id.' ON (t.id = cpv'.$id.'.object_id AND cpv'.$id.'.custom_property_id = '.$id . '))';
					$order_by = 'ORDER BY '.$order;
				}else{
					if($object->getColumnType($order) == 'date'){
						$order_by = 'ORDER BY STR_TO_DATE(t.'.$order.', "%Y-%m-%d %H:%i:%s") '.($order_asc ? 'asc' : 'desc');
					}else{
						$order_by = 'ORDER BY t.'.$order.' '.($order_asc ? 'asc' : 'desc');
					}
				}
			}
			if ($to_print) $limit_str = '';
			else $limit_str = ' LIMIT ' . $offset . ',' . $limit;
			
			$sql = 'SELECT '.$selectCols.' FROM ('.$openPar.$selectFROM.') '.$selectWHERE.' GROUP BY id '.$order_by . $limit_str;
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();
			$rows = Reports::removeDuplicateRows($rows);
			$reportObjTitleCols = array();
			foreach($rows as &$row){
				foreach($row as $col => $value){
					if(isset($titleColAlias[$col])){
						$reportObjTitleCols[$titleColAlias[$col]] = $value;
					}
				}
				$title = $managerInstance->getReportObjectTitle($reportObjTitleCols);
				$id = $row['id'];
				unset($row['id']);
				$row = array_slice($row, count($titleCols));
				$row = array('link' => '<a class="internalLink" target="new" href="'.get_url($controller, $view, array('id' => $id)).'">'.$title.'</a>') + $row;
				foreach($row as $col => &$value){
					if(in_array($col, $managerInstance->getExternalColumns())){
						$value = self::getExternalColumnValue($col, $value);
					}
					if(self::isReportColumnEmail($value)){
						if(logged_user()->hasMailAccounts()){
							$value = '<a class="internalLink" href="'.get_url('mail', 'add_mail', array('to' => clean($value))).'">'.clean($value).'</a></div>'; 		
						}else{
							$value = '<a class="internalLink" target="_self" href="mailto:'.clean($value).'">'.clean($value).'</a></div>'; 
						}
					}
				}
				$row = str_replace('|', ',', $row);
			}
			if (is_array($results['columns'])) {
				array_unshift($results['columns'], '');
			} else {
				$results['columns'] = array('');
			}
			$results['rows'] = $rows;
		}

		return $results;
	} //  executeReport
	
	function isReportColumnEmail($col){
		return preg_match(EMAIL_FORMAT, $col);
	}
	
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
				foreach($row as $col => $value){
					$cp = CustomProperties::getCustomProperty($col);
					if($cp instanceof CustomProperty && $cp->getIsMultipleValues()){

					}
				}
			}
		}
		return $rows;
	}

	static function getReportPagination($report_id, $params, $order_by='', $order_by_asc=true, $offset, $limit, $total){
		if($total == 0) return '';
		$a_nav = array(
			'<span class="x-tbar-page-first" style="padding-left:16px"/>', 
			'<span class="x-tbar-page-prev" style="padding-left:16px"/>', 
			'<span class="x-tbar-page-next" style="padding-left:16px"/>', 
			'<span class="x-tbar-page-last" style="padding-left:16px"/>'
		);
		$page = intval($offset / $limit);
		$totalPages = ceil($total / $limit);
		if($totalPages == 1) return '';

		$parameters = '';
		if(is_array($params) && count($params) > 0){
			foreach($params as $id => $value){
				$parameters .= '&params['.$id.']='.$value;
			}
		}
		if($order_by != ''){
			$parameters .= '&order_by='.$order_by.'&order_by_asc='.($order_by_asc ? 1 : 0);
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
			else if($i == $page + 1) $nav .= '<b>'.$i.'</b>&nbsp;&nbsp;';
		}
		if($page < $totalPages - 1){
			$off = $offset + $limit;
			$nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => $off, 'limit' => $limit)).$parameters.'">'.$a_nav[2].'</a>';
			$off = $limit * ($totalPages - 1);
			$nav .= '<a class="internalLink" href="'.get_url('reporting', 'view_custom_report', array('id' => $report_id, 'offset' => $off, 'limit' => $limit)).$parameters.'">'.$a_nav[3].'</a>';
		}
		return $nav . "<br/><span class='desc'>&nbsp;".lang('total').": $totalPages ".lang('pages').'</span>';
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