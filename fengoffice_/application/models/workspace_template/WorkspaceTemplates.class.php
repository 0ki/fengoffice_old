<?php

/**
 *  WorkspaceTemplates class
 *
 * @author Ignacio de Soto
 */
class WorkspaceTemplates extends BaseWorkspaceTemplates {
	
	 
	/**
	 * Returns all Templates of a Workspace
	 *
	 * @param integer $workspace_id
	 * @return array
	 */
	static function getTemplatesByWorkspace($workspace_id) {
		$all = self::findAll(array('conditions' => array('`workspace_id` = ?', $workspace_id) ));
		if (!is_array($all)) return array();
		$objs = array();
		foreach ($all as $obj) {
			$objs[] = get_object_by_manager_and_id($obj->getObjectId(), $obj->getObjectManager());
		}
		return $objs;
	}
	/**
	 * Returns all Workspaces an Template belongs to
	 *
	 * @param $object_manager
	 * @param $Template_id
	 * @return array
	 */
	static function getWorkspacesByTemplate($object_manager, $template_id, $wsCSV = null){
		$all = self::findAll(array('conditions' => "`object_manager` = '$object_manager' AND `template_id` = $template_id" . ($wsCSV ? " AND `workspace_id in` ($wsCSV)":'')));
		if (!is_array($all)) return array();
		$csv = "";
		foreach ($all as $w) {
			if ($csv != "") $csv .= ",";
			$csv .= $w->getWorkspaceId();
		}
		return Projects::findByCSVIds($csv);
	}
	/**
	 * Returns true if an Template is in a Workspace
	 *
	 * @param $object_manager
	 * @param $Template_id
	 * @param $workspace_id
	 * @return boolean
	 */
	static function isTemplateInWorkspace($object_manager, $template_id, $workspace_id){
		try {
			return count(self::find(array('conditions' => array("`object_manager` = ? AND `template_id` = ? AND `workspace_id` = ?", $object_manager, $template_id, $workspace_id)))) > 0;
		} catch (Exception $e) {
			return false;
		}
	} // isTemplateInWorkspace
	
	/**
	 * Returns one Workspace Template given WS id and template id and manager
	 *
	 * @param unknown_type $workspace_id
	 * @param unknown_type $task_template_id
	 * @param unknown_type $object_manager
	 */
	function getByTemplateAndWorkspace($workspace_id,$task_template_id,$object_manager){
		return self::find(array('conditions' => 
			array("`object_manager` = ? AND `template_id` = ".$task_template_id." AND `workspace_id` = ". $workspace_id, $object_manager)));		
	} //getByTemplateAndWorkspace
	
	/**
	 * delete all workspace-template associations for a given template
	 *
	 * @param unknown_type $task_template_id
	 * @param unknown_type $object_manager
	 * @return unknown
	 */
	function deleteByTemplate($task_template_id,$object_manager){
		return self::delete(array("`object_manager` = ? AND `template_id` = ".$task_template_id, $object_manager));		
	}
} // WorkspaceTemplates

?>