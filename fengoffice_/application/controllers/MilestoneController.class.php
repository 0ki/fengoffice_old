<?php

/**
 * Milestone controller
 *
 * @package Taus.application
 * @subpackage controller
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class MilestoneController extends ApplicationController {

	/**
	 * Construct the MilestoneController
	 *
	 * @access public
	 * @param void
	 * @return MilestoneController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct
//
//	/**
//	 * List all milestones in specific (this) project
//	 *
//	 * @access public
//	 * @param void
//	 * @return null
//	 */
//	function index() {
//		$this->addHelper('textile');
//		$project = active_or_personal_project();
//
//		tpl_assign('late_milestones', $project->getLateMilestones());
//		tpl_assign('today_milestones', $project->getTodayMilestones());
//		tpl_assign('upcoming_milestones', $project->getUpcomingMilestones());
//		tpl_assign('completed_milestones', $project->getCompletedMilestones());
//
//		$this->setSidebar(get_template_path('index_sidebar', 'milestone'));
//	} // index

	/**
	 * Show view milestone page
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function view() {
		$this->addHelper('textile');

		$milestone = ProjectMilestones::findById(get_id());
		if(!($milestone instanceof ProjectMilestone)) {
			flash_error(lang('milestone dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$milestone->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('milestone', $milestone);
	} // view

	/**
	 * Show and process add milestone form
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add() {
		$this->setTemplate('add_milestone');

		if(!ProjectMilestone::canAdd(logged_user(), active_or_personal_project())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$milestone_data = array_var($_POST, 'milestone');
		if(!is_array($milestone_data)) {
			$milestone_data = array(
				'due_date' => DateTimeValueLib::now(),
			); // array
		} // if
		$milestone = new ProjectMilestone();
		tpl_assign('milestone_data', $milestone_data);
		tpl_assign('milestone', $milestone);

		if (is_array(array_var($_POST, 'milestone'))) {
			$milestone_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'milestone_due_date_month', 1), array_var($_POST, 'milestone_due_date_day', 1), array_var($_POST, 'milestone_due_date_year', 1970));

			$assigned_to = explode(':', array_var($milestone_data, 'assigned_to', ''));

			$milestone->setFromAttributes($milestone_data);
			if(!logged_user()->isMemberOfOwnerCompany()) $milestone->setIsPrivate(false);

			$milestone->setProjectId(active_or_personal_project()->getId());
			$milestone->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$milestone->setAssignedToUserId(array_var($assigned_to, 1, 0));

			try {
				DB::beginWork();

				$milestone->save();
				$milestone->setTagsFromCSV(array_var($milestone_data, 'tags'));
				ApplicationLogs::createLog($milestone, active_or_personal_project(), ApplicationLogs::ACTION_ADD);

				DB::commit();

				// Send notification
				try {
					if(array_var($milestone_data, 'send_notification') == 'checked') {
						Notifier::milestoneAssigned($milestone); // send notification
					} // if
				} catch(Exception $e) {

				} // try

				flash_success(lang('success add milestone', $milestone->getName()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // add

	/**
	 * Show and process edit milestone form
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit() {
		$this->setTemplate('add_milestone');

		$milestone = ProjectMilestones::findById(get_id());
		if(!($milestone instanceof ProjectMilestone)) {
			flash_error(lang('milestone dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$milestone->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}

		$milestone_data = array_var($_POST, 'milestone');
		if(!is_array($milestone_data)) {
			$tag_names = $milestone->getTagNames();
			$milestone_data = array(
          'name'        => $milestone->getName(),
          'due_date'    => $milestone->getDueDate(),
          'description' => $milestone->getDescription(),
          'assigned_to' => $milestone->getAssignedToCompanyId() . ':' . $milestone->getAssignedToUserId(),
          'tags'        => is_array($tag_names) ? implode(', ', $tag_names) : '',
          'is_private'  => $milestone->isPrivate(),
			); // array
		} // if

		tpl_assign('milestone_data', $milestone_data);
		tpl_assign('milestone', $milestone);

		if(is_array(array_var($_POST, 'milestone'))) {
			$old_owner = $milestone->getAssignedTo(); // remember the old owner
			$milestone_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'milestone_due_date_month', 1), array_var($_POST, 'milestone_due_date_day', 1), array_var($_POST, 'milestone_due_date_year', 1970));

			$assigned_to = explode(':', array_var($milestone_data, 'assigned_to', ''));

			$old_is_private  = $milestone->isPrivate();
			$milestone->setFromAttributes($milestone_data);
			if(!logged_user()->isMemberOfOwnerCompany()) $milestone->setIsPrivate($old_is_private);

			$milestone->setProjectId(active_or_personal_project()->getId());
			$milestone->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
			$milestone->setAssignedToUserId(array_var($assigned_to, 1, 0));

			try {
				DB::beginWork();
				$milestone->save();
				$milestone->setTagsFromCSV(array_var($milestone_data, 'tags'));

				ApplicationLogs::createLog($milestone, $milestone->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();

				// If owner is changed send notification but don't break submission
				try {
					$new_owner = $milestone->getAssignedTo();
					if(array_var($milestone_data, 'send_notification') == 'checked') {
						if($old_owner instanceof User) {
							// We have a new owner and it is different than old owner
							if($new_owner instanceof User && $new_owner->getId() <> $old_owner->getId()) Notifier::milestoneAssigned($milestone);
						} else {
							// We have new owner
							if($new_owner instanceof User) Notifier::milestoneAssigned($milestone);
						} // if
					} // if
				} catch(Exception $e) {

				} // try

				flash_success(lang('success edit milestone', $milestone->getName()));
				ajx_current("start");

			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // edit

	/**
	 * Delete single milestone
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete() {
		$milestone = ProjectMilestones::findById(get_id());
		if(!($milestone instanceof ProjectMilestone)) {
			flash_error(lang('milestone dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$milestone->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			DB::beginWork();
			$milestone->delete();
			ApplicationLogs::createLog($milestone, $milestone->getProject(), ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success deleted milestone', $milestone->getName()));
			ajx_current("start");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete milestone'));
			ajx_current("empty");
		} // try
	} // delete

	/**
	 * Complete specific milestone
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function complete() {
		$milestone = ProjectMilestones::findById(get_id());
		if(!($milestone instanceof ProjectMilestone)) {
			flash_error(lang('milestone dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$milestone->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			$milestone->setCompletedOn(DateTimeValueLib::now());
			$milestone->setCompletedById(logged_user()->getId());

			DB::beginWork();
			$milestone->save();
			ApplicationLogs::createLog($milestone, $milestone->getProject(), ApplicationLogs::ACTION_CLOSE);
			DB::commit();

			flash_success(lang('success complete milestone', $milestone->getName()));
			$this->redirectToReferer($milestone->getViewUrl());
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error complete milestone'));
			ajx_current("empty");
		} // try

	} // complete

	/**
	 * Open specific milestone
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function open() {
		$milestone = ProjectMilestones::findById(get_id());
		if(!($milestone instanceof ProjectMilestone)) {
			flash_error(lang('milestone dnx'));
			ajx_current("empty");
			return;
		} // if

		if(!$milestone->canChangeStatus(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		try {

			$milestone->setCompletedOn(null);
			$milestone->setCompletedById(0);

			DB::beginWork();
			$milestone->save();
			ApplicationLogs::createLog($milestone, $milestone->getProject(), ApplicationLogs::ACTION_OPEN);
			DB::commit();

			flash_success(lang('success open milestone', $milestone->getName()));
			$this->redirectToReferer($milestone->getViewUrl());

		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error open milestone'));
			ajx_current("empty");
		} // try

	} // open

} // MilestoneController

?>