<?php

/**
* ProjectFiles, generated on Tue, 04 Jul 2006 06:46:08 +0200 by 
* DataObject generation tool
*
* @author Ilija Studen <ilija.studen@gmail.com>
*/
class ProjectFiles extends BaseProjectFiles {
    
	const ORDER_BY_NAME = 'name';
	const ORDER_BY_POSTTIME = 'dateCreated';
	const ORDER_BY_MODIFYTIME = 'dateUpdated';
	
	/**
	* Array of types that will script treat as images (provide thumbnail, add 
	* it to insert image editor function etc)
	*
	* @var array
	*/
	static public $image_types = array(
		'image/jpg', 'image/jpeg', 'image/pjpeg',
		'image/gif',
		'image/png'
	); // array
	
	/**
	* Return paged project files
	*
	* @param Project $project
	* @param ProjectFolder $folder
	* @param boolean $hide_private Don't show private files
	* @param string $order Order files by name or by posttime (desc)
	* @param integer $page Current page
	* @param integer $files_per_page Number of files that will be showed per single page
	* @param boolean $group_by_order Group files by order field
	* added by msaiz 03/10/07:
	* @param string for tag filter
	* @return array
	* 
	*/
	static function getProjectFiles($projectId = null, $folderId = null, $hide_private = false, $order = null, $orderdir = 'ASC', $page = null, $files_per_page = null, $group_by_order = false, $tag = null, $type_string = null, $userId = null) {
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
		if ((integer) $files_per_page < 1) {
			$files_per_page = 10;
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
				TABLE_PREFIX . "project_files.id = " . TABLE_PREFIX . "tags.rel_object_id and " .
				TABLE_PREFIX . "tags.tag = ? and " . TABLE_PREFIX . "tags.rel_object_manager ='ProjectFiles' ) > 0 ";
		}
		if ($type_string == '' || $type_string == null) {
			$type_string = '1';
			$typestr = " AND '1' = ? "; // dummy condition
		} else {
			$type_string .= '%';
			$typestr = " AND  (select count(*) from " . TABLE_PREFIX . "project_file_revisions where " .
				TABLE_PREFIX . "project_file_revisions.type_string LIKE ? AND " . TABLE_PREFIX .
				"project_files.id = " . TABLE_PREFIX . "project_file_revisions.file_id)";
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
		
		list($files, $pagination) = ProjectFiles::paginate(array(
				'conditions' => $conditions,
				'order' => $order_by
			), $files_per_page, $page);
		
		if ($group_by_order) {
			$grouped_files = array();
			if (is_array($files) && count($files)) {
				$today = DateTimeValueLib::now();
				foreach ($files as $file) {
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

					if (!isset($grouped_files[$group_by_str]) || !is_array($grouped_files[$group_by_str])) {
						$grouped_files[$group_by_str] = array();
					}
					$grouped_files[$group_by_str][] = $file;
				} // foreach
			} // if
			$files = is_array($grouped_files) ? $grouped_files : null;
		} // if
		
		return array($files, $pagination);
	} // getProjectFiles
	
	/**
	* Orphened files are files that are not part of any folder, but project itself
	*
	* @param Project $project
	* @param boolean $show_private
	* @return null
	*/
	static function getOrphanedFilesByProject(Project $project, $show_private = false) {
		if ($show_private) {
			$conditions = array('`project_id` =? AND `folder_id` = ?', $project->getId(), 0);
		} else {
			$conditions = array('`project_id` =? AND `folder_id` = ? AND `is_private` = ?', $project->getId(), 0, false);
		} // if
		
		return self::findAll(array(
			'conditions' => $conditions,
			'order' => '`filename`',
		));
	} // getOrphanedFilesByProject
	
	/**
	* Reaturn all project files
	*
	* @param Project $project
	* @return array
	*/
	static function getAllFilesByProject(Project $project) {
		return self::findAll(array(
			'conditions' => array('`project_id` = ?', $project->getId())
		)); // findAll
	} // getAllFilesByProject
	
	/**
	* Return files by URL. Files will be ordered by filename
	*
	* @param ProjectFolder $folder
	* @param boolean $show_private
	* @return array
	*/
	static function getByFolder(ProjectFolder $folder, $show_private = false) {
		$project = $folder->getProject();
		if (!($project instanceof Project)) {
			return null;
		} // if
		
		if ($show_private) {
			$conditions = array('`project_id` =? AND `folder_id` = ?', $project->getId(), $folder->getId());
		} else {
			$conditions = array('`project_id` =? AND `folder_id` = ? AND `is_private` = ?', $project->getId(), $this->getId(), false);
		} // if
		
		return self::findAll(array(
			'conditions' => $conditions,
			'order' => '`filename`',
		));
	} // getByFolder
	
	/**
	* Return file by name.
	*
	* @param $filename
	* @return array
	*/
	static function getByFilename($filename) {
		$conditions = array('`filename` = ?', $filename);
		
		return self::findOne(array(
			'conditions' => $conditions
		));
	} // getByFilename
	
	/**
	* Return files index page
	*
	* @param string $order_by
	* @param integer $page
	* @return string
	*/
	static function getIndexUrl($order_by = null, $page = null) {
		if (($order_by <> ProjectFiles::ORDER_BY_NAME) && ($order_by <> ProjectFiles::ORDER_BY_POSTTIME)) {
			$order_by = ProjectFiles::ORDER_BY_POSTTIME;
		} // if
		
		// #PAGE# is reserved as a placeholder
		if ($page <> '#PAGE#') {
			$page = (integer) $page > 0 ? (integer) $page : 1;
		} // if
		
		return get_url('files', 'index', array(
			'active_project' => active_project()->getId(),
			'order' => $order_by,
			'page' => $page
		)); // array
	} // getIndexUrl
	
	/**
	* Return important project files
	*
	* @param Project $project
	* @param boolean $include_private
	* @return array
	*/
	static function getImportantProjectFiles(Project $project, $include_private = false) {
		if ($include_private) {
			$conditions = array('`project_id` = ? AND `is_important` = ?', $project->getId(), true);
		} else {
			$conditions = array('`project_id` = ? AND `is_important` = ? AND `is_private` = ?', $project->getId(), true, false);
		} // if
		
		return self::findAll(array(
			'conditions' => $conditions,
			'order' => '`created_on`',
		));
	} // getImportantProjectFiles
	
	/**
	* Handle files uploaded using helper forms. This function will return array of uploaded 
	* files when finished
	*
	* @param Project $project
	* @param string $files_var_prefix If value of this variable is set only elements in $_FILES
	*   with key starting with $files_var_prefix will be handled
	* @return array
	*/
	static function handleHelperUploads(Project $project, $files_var_prefix = null) {
		if (!isset($_FILES) || !is_array($_FILES) || !count($_FILES)) {
			return null; // no files to handle
		} // if
		
		$uploaded_files = array();
		foreach( $_FILES as $uploaded_file_name => $uploaded_file) {
			if ((trim($files_var_prefix) <> '') && !str_starts_with($uploaded_file_name, $files_var_prefix)) {
				continue;
			} // if
			
			if (!isset($uploaded_file['name']) || !isset($uploaded_file['tmp_name']) || !is_file($uploaded_file['tmp_name'])) {
				continue;
			} // if
			
			$uploaded_files[$uploaded_file_name] = $uploaded_file;
		} // foreach
		
		if (!count($uploaded_file)) {
			return null; // no files to handle
		} // if
		
		$result = array(); // we'll put all files here
		$expiration_time = DateTimeValueLib::now()->advance(1800, false);
		
		foreach ($uploaded_files as $uploaded_file) {
			$file = new ProjectFile();
			
			$file->setProjectId($project->getId());
			$file->setFilename($uploaded_file['name']);
			$file->setIsVisible(false);
			$file->setExpirationTime($expiration_time);
			$file->save();
			
			$file->handleUploadedFile($uploaded_file); // initial version
			
			$result[] = $file;
		} // foreach
		
		return count($result) ? $result : null;
	} // handleHelperUploads
  
} // ProjectFiles 

?>