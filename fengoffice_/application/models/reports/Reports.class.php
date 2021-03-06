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
	static function executeReport($id, $params) {
		$results = array();
		$report = self::getReport($id);
		if($report instanceof Report){
			$conditionsFields = ReportConditions::getAllReportConditionsForFields($id);
			$conditionsCp = ReportConditions::getAllReportConditionsForCustomProperties($id);
			$table = '';
			$object = null;
			if($report->getObjectType() == 'Companies'){
				$table = 'companies';
				$object = new Company();
			}else if($report->getObjectType() == 'Contacts'){
				$table = 'contacts';
				$object = new Contact();
			}else if($report->getObjectType() == 'MailContents'){
				$table = 'mail_contents';
				$object = new MailContent();
			}else if($report->getObjectType() == 'ProjectEvents'){
				$table = 'project_events';
				$object = new ProjectEvent();
			}else if($report->getObjectType() == 'ProjectFiles'){
				$table = 'project_files';
				$object = new ProjectFile();
			}else if($report->getObjectType() == 'ProjectMilestones'){
				$table = 'project_milestones';
				$object = new ProjectMilestone();
			}else if($report->getObjectType() == 'ProjectMessages'){
				$table = 'project_messages';
				$object = new ProjectMessage();
			}else if($report->getObjectType() == 'ProjectTasks'){
				$table = 'project_tasks';
				$object = new ProjectTask();
			}else if($report->getObjectType() == 'Users'){
				$table = 'users';
				$object = new User();
			}else if($report->getObjectType() == 'ProjectWebpages'){
				$table = 'project_webpages';
				$object = new ProjectWebpage();
			}else if($report->getObjectType() == 'Projects'){
				$table = 'projects';
				$object = new Project();
			}
			$order_by = '';
			
			$sql = 'SELECT id FROM '.TABLE_PREFIX.$table.' t WHERE ';
			$manager = $report->getObjectType();
			$sql .= permissions_sql_for_listings(new $manager(), ACCESS_LEVEL_READ, logged_user(), 'project_id', 't');
			if(count($conditionsFields) > 0){
				foreach($conditionsFields as $condField){
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
						$quotes = true;
						if($condField->getCondition() == 'like' || $condField->getCondition() == 'not like'){
							$value = '%'.$value.'%';
						}
						if($condField->getCondition() == '%'){
							$mod = explode(',', $value);
							$value = $mod[0].' = '.$mod[1];
							$quotes = false;
						}
						if ($col_type == DATA_TYPE_DATE || $col_type == DATA_TYPE_DATETIME) {
							$dtValue = DateTimeValueLib::dateFromFormatAndString($dateFormat, $value);
							$value = $dtValue->format('Y-m-d');
						}
						if($quotes){
							$sql .= '`'.$condField->getFieldName().'` '.$condField->getCondition().' \''.$value.'\'';
						}else{
							$sql .= '`'.$condField->getFieldName().'` '.$condField->getCondition().' '.$value;
						}
					} else $sql .= ' true';
				}				
			}
			if(count($conditionsCp) > 0){
				
				foreach($conditionsCp as $condCp){
					$cp = CustomProperties::getCustomProperty($condCp->getCustomPropertyId());
					
					$skip_condition = false;
					$dateFormat = 'm/d/Y';
					if(isset($params[$cp->getName()])){
						$value = $params[$cp->getName()];
						if ($cp->getType() == 'date') $dateFormat = user_config_option('date_format', 'd/m/Y');
					}else{
						$value = $condCp->getValue();
					}
					if ($value == '' && $condCp->getIsParametrizable()) $skip_condition = true;
					if (!$skip_condition) {
						$sql .= ' AND ';
						$sql .= 't.id IN ( SELECT object_id as id FROM '.TABLE_PREFIX.'custom_property_values cpv WHERE ';
						$sql .= ' cpv.custom_property_id = '.$condCp->getCustomPropertyId();
						$fieldType = $object->getColumnType($condCp->getFieldName());
						
						$quotes = true;
						if($condCp->getCondition() == 'like' || $condCp->getCondition() == 'not like'){
							$value = '%'.$value.'%';
						}
						if($condCp->getCondition() == '%'){
							$mod = explode(',', $value);
							$value = $mod[0].' = '.$mod[1];
							$quotes = false;
						}
						if ($cp->getType() == 'date') {
							$dtValue = DateTimeValueLib::dateFromFormatAndString($dateFormat, $value);
							$value = $dtValue->format('Y-m-d');
						}
						if($quotes){
							$sql .= ' AND cpv.value '.$condCp->getCondition().' "'.$value.'"';
						}else{
							$sql .= ' AND cpv.value '.$condCp->getCondition().' '.$value;
						}
						$sql .= ')';
					}
				}
			}
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();
			$ids = array();
			foreach($rows as $row){
				$ids[] = $row['id'];
			}

			if(count($ids) == 0) return;

			$selectCols = '';
			$columnsFields = ReportColumns::getAllReportColumnNamesForFields($id);
			if(count($columnsFields) > 0){
				$first = true;
				foreach($columnsFields as $field){
					if(!$first) $selectCols .= ' , ';
					$selectCols .= 't.'.$field;
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
				if(!$first || count($columnsFields) > 0) $selectCols .= ', ';
				$cp = CustomProperties::getCustomProperty($colCp);
				$selectCols .= ' cpv'.$id.'.value as "'.$cp->getName().'"';
				$results['columns'][] = $cp->getName();
				$openPar .= '(';
				$selectFROM .= ' LEFT OUTER JOIN '.TABLE_PREFIX.'custom_property_values cpv'.$id.' ON (t.id = cpv'.$id.'.object_id AND cpv'.$id.'.custom_property_id = '.$colCp .'))';
				$first = false;
				if($report->getOrderBy() == $colCp){
					$order_by = 'ORDER BY cpv'.$id.'.value';
				}
			}
			if($order_by == '') {
				if(is_numeric($report->getOrderBy())){
					$id = $report->getOrderBy();
					$openPar .= '(';
					$selectFROM .= ' LEFT OUTER JOIN '.TABLE_PREFIX.'custom_property_values cpv'.$id.' ON (t.id = cpv'.$id.'.object_id AND cpv'.$id.'.custom_property_id = '.$id . '))';
					$order_by = 'ORDER BY '.$report->getOrderBy();
				}else{
					$order_by = 'ORDER BY t.'.$report->getOrderBy();
				}
			}
			$sql = 'SELECT '.$selectCols.' FROM ('.$openPar.$selectFROM.') '.$selectWHERE.' '.$order_by;
			$rows = DB::executeAll($sql);
			if (is_null($rows)) $rows = array();
			$results['rows'] = $rows;
		}

		return $results;
	} //  executeReport

} // Reports

?>