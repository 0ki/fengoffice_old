<?php

/**
* ProjectEvents, generated on Tue, 04 Jul 2006 06:46:08 +0200 by 
* DataObject generation tool
*
* @author Marcos Saiz <marcos.saiz@gmail.com>
*/
class ProjectEvents extends BaseProjectEvents {
    
	const ORDER_BY_NAME = 'name';
	const ORDER_BY_POSTTIME = 'dateCreated';
	const ORDER_BY_MODIFYTIME = 'dateUpdated';
	
	/**
	* Return paged project Events
	*
	* @param Project $project
	* @param boolean $hide_private Don't show private Events
	* @param string $order Order Events by name or by posttime (desc)
	* @param integer $page Current page
	* @param integer $Events_per_page Number of Events that will be showed per single page
	* @param boolean $group_by_order Group Events by order field
	* added by msaiz 03/10/07:
	* @param string for tag filter
	* @return array
	* 
	*/
/*	static function getProjectEvents($projectId = null, $folderId = null, $hide_private = false, $order = null, $orderdir = 'ASC', $page = null, $Events_per_page = null, $group_by_order = false, $tag = null, $type_string = null, $userId = null) {
		if ($order == self::ORDER_BY_POSTTIME) {
			$order_by = '`created_on` ' . $orderdir;
		} else if ($order == self::ORDER_BY_MODIFYTIME) {
			$order_by = '`updated_on` ' . $orderdir;
		} else {
			$order_by = '`filename`' . $orderdir;
		} // if
		
		if ((integer) $page < 1) {
			$page = 1;
		} // if
		if ((integer) $Events_per_page < 1) {
			$Events_per_page = 10;
		} // if
		
		
		if ($projectId == null || $projectId == 0) {
			$projectId = '1';
			$projectstr = " AND '1' = ? "; // this would generate a dummy condition
		} else {
			$projectstr = " AND `project_id` = ? ";
		}
		if ($tag == '' || $tag == null) {
			$tag = '1';
			$tagstr = " AND '1' = ? "; // dummy condition
		} else {
			$tagstr = " AND (select count(*) from " . TABLE_PREFIX . "tags where " .
				TABLE_PREFIX . "Project_Events.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = ? and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectEvents' ) > 0 ";
		}
		if ($type_string == '' || $type_string == null) {
			$type_string = '1';
			$typestr = " AND '1' = ? "; // dummy condition
		} else {
			$type_string .= '%';
			$typestr = " AND  (select count(*) from " . TABLE_PREFIX . "project_file_revisions where " .
				TABLE_PREFIX . "project_file_revisions.type_string LIKE ? AND " . TABLE_PREFIX .
				"project_Events.id = " . TABLE_PREFIX . "project_file_revisions.file_id)";
		}
		if ($userId == null || $userId == 0) {
			$userId = '1';
			$userstr = " AND '1' = ?"; // dummy condition
		} else {
			$userstr = " AND `created_by_id` = ? ";
		}
		if ($folderId == null || $folderId == 0) {
			$folderId = '1';
			$folderstr = " AND '1' = ? "; // dummy condition
		} else {
			$folderstr = " AND `folder_id` = ? ";
		}
		if ($hide_private) {
			$permissionstr = " AND NOT `is_private` ";
		} else {
			$permissionstr = "";
		}
		
		$otherConditions = $folderstr . $projectstr . $tagstr . $typestr . $userstr . $permissionstr;
		
		if ($hide_private) {
			$conditions = array('`is_private` = ? AND `is_visible` = ?' . $otherConditions, false, true, $folderId, $projectId, $tag, $type_string, $userId);
		} else {
			$conditions = array('`is_visible` = ?' . $otherConditions, true, $folderId, $projectId, $tag, $type_string, $userId);
		}
		
		list($Events, $pagination) = ProjectEvents::paginate(array(
				'conditions' => $conditions,
				'order' => $order_by
			), $Events_per_page, $page);
		
		if ($group_by_order) {
			$grouped_Events = array();
			if (is_array($Events) && count($Events)) {
				$today = DateTimeValueLib::now();
				foreach ($Events as $file) {
					$group_by_str = '';
					if ($order == self::ORDER_BY_POSTTIME) {
						$created_on = $file->getCreatedOn();
						if($created_on->getYear() == $today->getYear()) {
							$group_by_str = format_descriptive_date($created_on);
						} else {
							$group_by_str = format_date($created_on);
						} // if
					} else {
						$group_by_str = strtoupper(substr_utf($file->getFilename(), 0, 1));
					} // if

					if (!isset($grouped_Events[$group_by_str]) || !is_array($grouped_Events[$group_by_str])) {
						$grouped_Events[$group_by_str] = array();
					}
					$grouped_Events[$group_by_str][] = $file;
				} // foreach
			} // if
			$Events = is_array($grouped_Events) ? $grouped_Events : null;
		} // if
		
		return array($Events, $pagination);
	} // getProjectEvents
*/	

	/**
	* Reaturn all calednar Events
	*
	* @param Project $project
	* @return array
	*/
	static function getAllEventsByProject(Project $project) {
		return self::findAll(array(
			'conditions' => array('project_id', $project->getId())
		)); // findAll
	} // getAllEventsByProject
	
	  
} // ProjectEvents 

?>