<?php

/**
 * Handle all timeslot related requests
 *
 * @version 1.0
 * @author Carlos Palma <chonwil@gmail.com>
 */
class TimeslotController extends ApplicationController {

	/**
	 * Construct the TimeslotController
	 *
	 * @access public
	 * @param void
	 * @return TimeslotController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * Open timeslot
	 *
	 * @param void
	 * @return null
	 */
	function open() {
		$this->setTemplate('add_timeslot');

		$object_id = get_id('object_id');
		$object_manager = array_var($_GET, 'object_manager');

		if(!is_valid_function_name($object_manager)) {
			flash_error(lang('invalid request'));
			ajx_current("empty");
			return;
		} // if

		$object = get_object_by_manager_and_id($object_id, $object_manager);
		if(!($object instanceof ProjectDataObject) || !($object->canEdit(logged_user()))) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$timeslot = new Timeslot();
		$dt = DateTimeValueLib::now();
		$timeslot->setStartTime($dt);
		$timeslot->setUserId(logged_user()->getId());
		$timeslot->setObjectManager($object_manager);
		$timeslot->setObjectId($object_id);
		
		try{
			DB::beginWork();
			$timeslot->save();
			ApplicationLogs::createLog($timeslot, $timeslot->getWorkspaces(), ApplicationLogs::ACTION_OPEN);
			DB::commit();
				
			flash_success(lang('success open timeslot'));
			ajx_current("reload");
		} catch (Exception $e) {
			DB::rollback();
			ajx_current("empty");
			flash_error($e->getMessage());
		} // try
	} 
	
	function add_timespan() {

		$object_id = get_id('object_id');
		$object_manager = array_var($_GET, 'object_manager');

		if(!is_valid_function_name($object_manager)) {
			flash_error(lang('invalid request'));
			ajx_current("empty");
			return;
		} // if

		$object = get_object_by_manager_and_id($object_id, $object_manager);
		if(!($object instanceof ProjectDataObject) || !($object->canEdit(logged_user()))) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$timeslot_data = array_var($_POST, 'timeslot');
		$hours = array_var($timeslot_data, 'time');
		$hours = - $hours;
		
		$timeslot = new Timeslot();
		$dt = DateTimeValueLib::now();
		$dt2 = DateTimeValueLib::now();
		$timeslot->setEndTime($dt);
		$dt2 = $dt2->add('h', $hours);
		$timeslot->setStartTime($dt2);
		$timeslot->setDescription(array_var($timeslot_data, 'description'));
		$timeslot->setUserId(logged_user()->getId());
		$timeslot->setObjectManager($object_manager);
		$timeslot->setObjectId($object_id);
		
		try{
			DB::beginWork();
			$timeslot->save();
			ApplicationLogs::createLog($timeslot, $timeslot->getWorkspaces(), ApplicationLogs::ACTION_OPEN);
			DB::commit();
				
			flash_success(lang('success create timeslot'));
			ajx_current("reload");
		} catch (Exception $e) {
			DB::rollback();
			ajx_current("empty");
			flash_error($e->getMessage());
		} // try
	} 
	
	/*
	 * Close timeslot
	 *
	 * @param void
	 * @return null
	 */
	function close() {
		$this->setTemplate('add_timeslot');

		$timeslot = Timeslots::findById(get_id());
		if(!($timeslot instanceof Timeslot)) {
			flash_error(lang('timeslot dnx'));
			ajx_current("empty");
			return;
		} // if

		$object = $timeslot->getObject();
		if(!($object instanceof ProjectDataObject)) {
			flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
		} // if
		
		if(!($object->canEdit(logged_user()))) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		$timeslot_data = array_var($_POST, 'timeslot');
		$timeslot->close();
		$timeslot->setFromAttributes($timeslot_data);
		
		try{
			DB::beginWork();
			if (array_var($_GET, 'cancel') && array_var($_GET, 'cancel') == 'true')
				$timeslot->delete();
			else
				$timeslot->save();
			ApplicationLogs::createLog($timeslot, $timeslot->getWorkspaces(), ApplicationLogs::ACTION_CLOSE);
			DB::commit();
				
			if (array_var($_GET, 'cancel') && array_var($_GET, 'cancel') == 'true')
				flash_success(lang('success cancel timeslot'));
			else
				flash_success(lang('success close timeslot'));
				
			ajx_current("reload");
		} catch (Exception $e) {
			DB::rollback();
			ajx_current("empty");
			flash_error($e->getMessage());
		} // try
	} 
	
	function pause() {
		ajx_current("empty");

		$timeslot = Timeslots::findById(get_id());
		if(!($timeslot instanceof Timeslot)) {
			flash_error(lang('timeslot dnx'));
			return;
		} // if

		$object = $timeslot->getObject();
		if(!($object instanceof ProjectDataObject)) {
			flash_error(lang('object dnx'));
			return;
		} // if
		
		if(!($object->canEdit(logged_user()))) {
			flash_error(lang('no access permissions'));
			return;
		} // if
		
		try{
			DB::beginWork();
			$timeslot->pause();
			$timeslot->save();
			DB::commit();
				
			flash_success(lang('success pause timeslot'));
			ajx_current("reload");
		} catch (Exception $e) {
			DB::rollback();
			flash_error($e->getMessage());
		} // try
	} 
	
	function resume() {
		ajx_current("empty");

		$timeslot = Timeslots::findById(get_id());
		if(!($timeslot instanceof Timeslot)) {
			flash_error(lang('timeslot dnx'));
			return;
		} // if

		$object = $timeslot->getObject();
		if(!($object instanceof ProjectDataObject)) {
			flash_error(lang('object dnx'));
			return;
		} // if
		
		if(!($object->canEdit(logged_user()))) {
			flash_error(lang('no access permissions'));
			return;
		} // if
		
		try{
			DB::beginWork();
			$timeslot->resume();
			$timeslot->save();
			DB::commit();
				
			flash_success(lang('success pause timeslot'));
			ajx_current("reload");
		} catch (Exception $e) {
			DB::rollback();
			flash_error($e->getMessage());
		} // try
	} 

	/**
	 * Edit timeslot
	 *
	 * @param void
	 * @return null
	 */
	function edit() {
		$this->setTemplate('add_timeslot');
		
		$timeslot = Timeslots::findById(get_id());
		if(!($timeslot instanceof Timeslot)) {
			flash_error(lang('timeslot dnx'));
			ajx_current("empty");
			return;
		} // if

		$object = $timeslot->getObject();
		if(!($object instanceof ProjectDataObject)) {
			flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
		} // if
		
		if(!($object->canEdit(logged_user()))) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		
		$timeslot_data = array_var($_POST, 'timeslot');
		if(!is_array($timeslot_data)) {
			$timeslot_data = array(
          		'description' => $timeslot->getDescription(),
          		'start_time' => $timeslot->getStartTime(),
          		'end_time' => $timeslot->getEndTime()
			); // array
		} // if

		tpl_assign('timeslot_form_object', $object);
		tpl_assign('timeslot', $timeslot);
		tpl_assign('timeslot_data', $timeslot_data);
		
		if(is_array(array_var($_POST, 'timeslot'))) {
			try {
				$timeslot->setDescription(array_var($timeslot_data, 'description'));
       			
				$st = getDateValue(array_var($timeslot_data, 'start_value'),DateTimeValueLib::now());
				$st->setHour(array_var($timeslot_data, 'start_hour'));
				$st->setMinute(array_var($timeslot_data, 'start_minute'));
				
				$et = getDateValue(array_var($timeslot_data, 'end_value'),DateTimeValueLib::now());
				$et->setHour(array_var($timeslot_data, 'end_hour'));
				$et->setMinute(array_var($timeslot_data, 'end_minute'));
				
				$st = new DateTimeValue($st->getTimestamp() - logged_user()->getTimezone() * 3600);
				$et = new DateTimeValue($et->getTimestamp() - logged_user()->getTimezone() * 3600);
       			$timeslot->setStartTime($st);
				$timeslot->setEndTime($et);
				
				if ($timeslot->getStartTime() > $timeslot->getEndTime()){
					flash_error(lang('error start time after end time'));
					ajx_current("empty");
					return;
				}
				
				$seconds = array_var($timeslot_data,'subtract_seconds',0);
				$minutes = array_var($timeslot_data,'subtract_minutes',0);
				$hours = array_var($timeslot_data,'subtract_hours',0);
				
				$subtract = $seconds + 60 * $minutes + 3600 * $hours;
				if ($subtract < 0){
					flash_error(lang('pause time cannot be negative'));
					ajx_current("empty");
					return;
				}
				
				$testEndTime = new DateTimeValue($timeslot->getEndTime()->getTimestamp());
				
				$testEndTime->add('s',-$subtract);
				
				if ($timeslot->getStartTime() > $testEndTime){
					flash_error(lang('pause time cannot exceed timeslot time'));
					ajx_current("empty");
					return;
				}
				
				$timeslot->setSubtract($subtract);
				
				DB::beginWork();
				$timeslot->save();
				DB::commit();

				flash_success(lang('success edit timeslot'));
				ajx_current("back");
			} catch(Exception $e) {
				DB::rollback();
				flash_error(lang('error edit timeslot'));
				ajx_current("empty");
			} // try
		}
	} // edit

	/**
	 * Delete specific timeslot
	 *
	 * @param void
	 * @return null
	 */
	function delete() {

		$timeslot = Timeslots::findById(get_id());
		if(!($timeslot instanceof Timeslot)) {
			flash_error(lang('timeslot dnx'));
			ajx_current("empty");
			return;
		} // if

		$object = $timeslot->getObject();
		if(!($object instanceof ProjectDataObject)) {
			flash_error(lang('object dnx'));
			ajx_current("empty");
			return;
		} // if

		if(trim($object->getObjectUrl())) $redirect_to = $object->getObjectUrl();

		if(!$timeslot->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {
			DB::beginWork();
			$timeslot->delete();
			ApplicationLogs::createLog($timeslot, $object->getWorkspaces(), ApplicationLogs::ACTION_DELETE);
			$object->onDeleteTimeslot($timeslot);
			DB::commit();

			flash_success(lang('success delete timeslot'));
			ajx_current("reload");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete timeslot'));
			ajx_current("empty");
		} // try

	} // delete

} // TimeslotController

?>