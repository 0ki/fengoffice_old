<?php
/* ProjectCharts
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class ProjectCharts extends BaseProjectCharts {

	public static function getWorkspaceString($ids = '?') {
		return " `id` IN (SELECT `object_id` FROM `" . TABLE_PREFIX . "workspace_objects` WHERE `object_manager` = 'ProjectCharts' AND `workspace_id` IN ($ids)) ";
	}
	
	/**
	 * Return charts that belong to specific project
	 *
	 * @param Project $project
	 * @return array
	 */
	static function getProjectCharts(Project $project) {
		$conditions = array(self::getWorkspaceString(), $project->getId());

		return self::findAll(array(
			'conditions' => $conditions,
			'order' => '`created_on` DESC',
		)); // findAll
	} // getProjectCharts
	 
} // ProjectCharts
?>