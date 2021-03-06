<?php

/**
 * ProjectMilestones, generated on Sat, 04 Mar 2006 12:50:11 +0100 by
 * DataObject generation tool
 *
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class ProjectMilestones extends BaseProjectMilestones {

	function __construct() {
		parent::__construct();
		$this->object_type_name = 'milestone';
	}
	

	/**
	 * Returns milestones from active context and parent members of the active context
	 *
	 * @param User $user
	 * @return array
	 */
	static function getActiveMilestonesByUser(Contact $user, $context = null) {
		if (is_null($context)) {
			$context = active_context();
		}
		$parents = array();
		foreach ($context as $k => $member) {
			if ($member instanceof Member) {
				$tmp = $member->getParentMember();
				while ($tmp != null){
					$parents[] = $tmp->getId();
					$tmp = $tmp->getParentMember();
				}
			}
		}
		
		$extra_conditions = "";
		if (count($parents) > 0) {
			$extra_conditions = "OR EXISTS (SELECT `aux`.`object_id` FROM ".ObjectMembers::instance()->getTableName(true)." `aux` WHERE `aux`.`is_optimization` = 0 
				AND `aux`.`object_id`=`om`.`object_id` AND `aux`.`member_id` IN (".implode(",",$parents)."))";
		}
		
		$result = ProjectMilestones::getContentObjects($context, ObjectTypes::findById(ProjectMilestones::instance()->getObjectTypeId()), null, null, $extra_conditions);
		$milestones = $result->objects;
		return $milestones;
	} // getActiveMilestonesByUser

	/**
	 * Return active milestones that are assigned to the specific user and belongs to specific project
	 *
	 * @param User $user
	 * @param Project $project
	 * @return array
	 */
	static function getActiveMilestonesByUserAndProject(Contact $contact, $archived = false) {
		if ($archived) $archived_cond = "`archived_on` <> 0 AND ";
		else $archived_cond = "`archived_on` = 0 AND ";
		
		return self::findAll(array(
        	'conditions' => array('`is_template` = false AND (`assigned_to_contact_id` = ? OR `assigned_to_contact_id` = ? ) AND ' . $archived_cond . ' AND `completed_on` = ?', $contact->getId(), $contact->getCompanyId(), EMPTY_DATETIME),
        	'order' => '`due_date`'
        )); // findAll
	} // getActiveMilestonesByUserAndProject
	 

	/**
	 * Returns an unsaved copy of the milestone. Copies everything except open/closed state,
	 * anything that needs the task to have an id (like tags, properties, tasks),
	 * administrative info like who created the milestone and when, etc.
	 *
	 * @param ProjectMilestone $milestone
	 * @return ProjectMilestone
	 */
	function createMilestoneCopy(ProjectMilestone $milestone) {
		$new = new ProjectMilestone();
		$new->setObjectName($milestone->getObjectName());
		$new->setDescription($milestone->getDescription());
		$new->setIsUrgent($milestone->setIsUrgent());
		$new->setDueDate($milestone->getDueDate());
		return $new;
	}

	/**
	 * Copies tasks from milestoneFrom to milestoneTo.
	 *
	 * @param ProjectMilestone $milestoneFrom
	 * @param ProjectMilestone $milestoneTo
	 */
	function copyTasks(ProjectMilestone $milestoneFrom, ProjectMilestone $milestoneTo, $as_template = false) {
		//FIXME 
		foreach ($milestoneFrom->getTasks() as $sub) {
			if ($sub->getParentId() != 0) continue;
			$new = ProjectTasks::createTaskCopy($sub);
			$new->setIsTemplate($as_template);
			$new->setMilestoneId($milestoneTo->getId());
			if ($sub->getIsTemplate()) {
				$new->setFromTemplateId($sub->getId());
			}
			$new->save();
			
			$object_controller = new ObjectController();
			$members = $milestoneFrom->getMemberIds() ;
			if (count($members)) {
				$object_controller->add_to_members($new, $members);
			}
			
			/*
			foreach ($sub->getWorkspaces() as $workspace) {
				if (ProjectTask::canAdd(logged_user(), $workspace)) {
					$new->addToWorkspace($workspace);
				}
			}

			if (!$as_template && active_project() instanceof Project && ProjectTask::canAdd(logged_user(), active_project())) {
				$new->removeFromAllWorkspaces();
				$new->addToWorkspace(active_project());
			}
			
			*/
			$new->copyCustomPropertiesFrom($sub);
			$new->copyLinkedObjectsFrom($sub);
			ProjectTasks::copySubTasks($sub, $new, $as_template);
		}
	}

} // ProjectMilestones

?>