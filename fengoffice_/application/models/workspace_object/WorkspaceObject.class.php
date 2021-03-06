<?php

/**
 *  WorkspaceObject class
 *
 * @author Ignacio de Soto
 */
class WorkspaceObject extends BaseWorkspaceObject {

	/**
	 * Returns the Workspace
	 *
	 * @return Project
	 */
	function getWorkspace() {
		return Projects::findById($this->getWorkspaceId());
	}
	
	function getObject() {
		return get_object_by_manager_and_id($this->getObjectId(), $this->getObjectManager());
	}
} // WorkspaceObject

?>