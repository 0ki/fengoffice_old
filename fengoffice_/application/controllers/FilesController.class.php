<?php

/**
 * Controller that is responsible for handling project files related requests
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>
 */
class FilesController extends ApplicationController {

	/**
	 * Construct the FilesController
	 *
	 * @access public
	 * @param void
	 * @return FilesController
	 */
	function __construct() {
		parent::__construct();
		prepare_company_website_controller($this, 'website');
	} // __construct

	/**
	 * Show files index page (list recent files)
	 *
	 * @param void
	 * @return null
	 */
	function index() {
		tpl_assign('allParam', array_var($_GET,'all'));
		tpl_assign('userParam',  array_var($_GET,'user'));
		tpl_assign('projectParam',  array_var($_GET,'project'));
		tpl_assign('tagParam',  array_var($_GET,'tag'));
		tpl_assign('typeParam',  array_var($_GET,'type'));
		tpl_assign('tags', Tags::getTagNames());
		if(isset($error))
		tpl_assign('error', $error);
	} // index

	// ---------------------------------------------------
	//  Files
	// ---------------------------------------------------

	/**
	 * Show file details
	 *
	 * @param void
	 * @return null
	 */
	function file_details() {
		$this->addHelper('textile');
			
		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		$revisions = $file->getRevisions();
		if(!count($revisions)) {
			flash_error(lang('no file revisions in file'));
			ajx_current("empty");
			return;
		} // if

		tpl_assign('file', $file);
		tpl_assign('last_revision', $file->getLastRevision());
		tpl_assign('revisions', $revisions);
		tpl_assign('order', null);
		tpl_assign('page', null);
		ajx_set_no_toolbar(true);

	} // file_details

	function slideshow() {
		$this->setLayout('slideshow');
		$fileid = array_var($_GET, 'fileId');
		$file = ProjectFiles::instance()->findById($fileid);
		if(!$file->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		$content = $error = null;
		if (!$file) {
			$error = 'File not found';
		} else if (strcmp($file->getTypeString(), 'prsn') != 0) {
			$error = 'File is not a presentation';
		} else {
			$content = $file->getFileContent();
		}
		tpl_assign('error', $error);
		tpl_assign('content', $content);
	}//slideshow

	/**
	 * Download specific file
	 *
	 * @param void
	 * @return null
	 */
	function download_file() {
		$inline = (boolean) array_var($_GET, 'inline', false);
			
		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canDownload(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if

		download_contents($file->getFileContent(), $file->getTypeString(), $file->getFilename(), $file->getFileSize(), !$inline);
		die();
	} // download_file

	function checkout_file()
	{
		ajx_current("empty");
		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			return;
		} // if

		if(!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			return;
		} // if

		$file->setCheckedOutById(logged_user()->getId());
		$file->setCheckedOutOn(DateTimeValueLib::now());
		$file->setMarkTimestamps(false);
		
		try{
			DB::beginWork();
			$file->save();
			DB::commit();

			flash_success(lang('success checkout file'));
			ajx_current("reload");
		}
		catch(Exception $e)
		{
			DB::rollback();
			flash_error($e->getMessage());
		}
	}

	function undo_checkout(){
		ajx_current("empty");
		$file = ProjectFiles::findById(get_id());
		if(!$file instanceof ProjectFile) {
			flash_error(lang('file dnx'));
			return;
		} // if

		if(!$file->canCheckin(logged_user())) {
			flash_error(lang('no access permissions'));
			return;
		} // if
		
		$file->setCheckedOutById(0);
		$file->setCheckedOutOn(null);
		$file->setMarkTimestamps(false);
		
		try {
			Db::beginWork();
			$file->save();
			Db::commit();
			
			flash_success(lang("success undo checkout file"));
			ajx_current("reload");
		} catch (Exception $e){
			Db::rollback();
			flash_error($e->getMessage());
		}
	}
	
	/**
	 * Download specific revision
	 *
	 * @param void
	 * @return null
	 */
	function download_revision() {
		$inline = (boolean) array_var($_GET, 'inline', false);
		$revision = ProjectFileRevisions::findById(get_id());
		if(!($revision instanceof ProjectFileRevision)) {
			flash_error(lang('file revision dnx'));
			ajx_current("empty");
			return;
		} // if
			
		$file = $revision->getFile();
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!($file->canDownload(logged_user()))) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
			
		download_contents($revision->getFileContent(), $revision->getTypeString(), $file->getFilename(), $file->getFileSize(), !$inline);
		die();
	} // download_revision

	/**
	 * Add file
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function add_file() {
		$file_data = array_var($_POST, 'file');

		$file = new ProjectFile();
			
		tpl_assign('file', $file);
		tpl_assign('file_data', $file_data);
		tpl_assign('tags', Tags::getTagNames());
			
		if (is_array(array_var($_POST, 'file'))) {
			$ids = array_var($_POST, "ws_ids", "");
			$enteredWS = Projects::findByCSVIds($ids);
			$validWS = array();
			foreach ($enteredWS as $ws) {
				if (ProjectMessage::canAdd(logged_user(), $ws)) {
					$validWS[] = $ws;
				}
			}
			if (empty($validWS)) {
				flash_error(lang('must choose at least one workspace error'));
				ajx_current("empty");
				return;
			}
			
			$upload_option = array_var($file_data, 'upload_option');
			$uploaded_file = array_var($_FILES, 'file_file');
			$skipSettings = false;
			try {
				DB::beginWork();
				if ($upload_option && $upload_option != -1){
					$skipSettings = true;
					$file = ProjectFiles::findById($upload_option);
					
					if ($file->isCheckedOut()){
						if (!$file->canCheckin(logged_user())){
							flash_error(lang('no access permissions'));
							ajx_current("empty");
							return;
						}
						$file->setCheckedOutById(0);
					} else {  // Check for edit permissions
						if (!$file->canEdit(logged_user())){
							flash_error(lang('no access permissions'));
							ajx_current("empty");
							return;
						}
					}
				} else {
					$file->setFilename(array_var($file_data, 'name'));
					$file->setFromAttributes($file_data);
	
					if(!logged_user()->isMemberOfOwnerCompany()) {
						$file->setIsPrivate(false);
						$file->setIsImportant(false);
						$file->setCommentsEnabled(true);
						$file->setAnonymousCommentsEnabled(false);
					} // if
					$file->setIsVisible(true);
				}
				
				$file->save();
				$revision = $file->handleUploadedFile($uploaded_file, true); // handle uploaded file
				

				//Add properties
				if (!$skipSettings){
					$file->save_properties($file_data);
					$file->setTagsFromCSV(array_var($file_data, 'tags'));
					foreach ($validWS as $w) {
						$file->addToWorkspace($w);
					}
				}
				foreach ($validWS as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_ADD);
				}
				//Add links
			    $object_controller = new ObjectController();
			    $object_controller->link_to_new_object($file);
				DB::commit();
				//flash_success(array_var($file_data, 'add_type'));

				flash_success(lang('success add file', $file->getFilename()));
				ajx_current("back");
			} catch(Exception $e) {
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");

				// If we uploaded the file remove it from repository
				if(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
					FileRepository::deleteFile($revision->getRepositoryId());
				} // if
			} // try
		} // if
	} // add_file

	function save_document() {
		ajx_current("empty");
		$postFile = array_var($_POST, 'file');
		$fileId = array_var($postFile, 'id');
		if($fileId > 0) {
			//edit document
			try {
				// edit document
				$file = ProjectFiles::findById($fileId);
				if (!$file->canEdit(logged_user())) {
					flash_error(lang('no access permissions'));
					ajx_current("empty");
					return;
				} // if
				DB::beginWork();
				$post_revision = array_var($_POST, 'new_revision_document') == 'checked'; // change file?
				$revision_comment = '';

				$file_dt['name'] = $file->getFilename();
				$file_content = array_var($_POST, 'fileContent');
				$file_dt['size'] = strlen($file_content);
				$file_dt['type'] = 'text/html';
				$file_dt['tmp_name'] = './tmp/' . rand () ;
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler,$file_content);
				fclose($handler);
				$name = array_var($postFile, 'name');
				//eyedoc MOD
				if (!str_ends_with($name, ".html") && !str_ends_with($name, ".eyedoc")) {
					$name .= ".html";
				}//eyedoc MOD
				$file->setFilename($name);
				$file->save();
				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				$file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_EDIT);
				}
				DB::commit();
				unlink($file_dt['tmp_name']);

				flash_success(lang('success save file', $file->getFilename()));
				evt_add("document saved", array("id" => $file->getId(), "instance" => array_var($_POST, 'instanceName')));
				//$this->redirectTo('files', 'add_document', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();
				unlink($file_dt['tmp_name']);
				flash_error(lang('error while saving'), $e->getMessage());
				//$this->redirectToReferer(get_url('files'));
			} // try
		} else  {
			// new document
			if (!ProjectFile::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
			} // if

			// prepare the file object
			$file = new ProjectFile();
			$name = array_var($postFile, 'name');
			if (!str_ends_with($name, ".html")) {
				$name .= ".html";
			}
			$file->setFilename($name);
			$file->setIsVisible(true);

			$file->setIsPrivate(false);
			$file->setIsImportant(false);
			$file->setCommentsEnabled(true);
			$file->setAnonymousCommentsEnabled(false);

			//seteo esto para despues setear atributos
			$file_content = array_var($_POST, 'fileContent');
			$file_dt['name'] = array_var($postFile,'name');
			$file_dt['size'] = strlen($file_content);
			$file_dt['type'] = 'text/html';

			$file->setCreatedOn(new DateTimeValue(time()) );
			try {
				DB::beginWork();
				$file_dt['tmp_name'] = './tmp/' . array_var($postFile,'name');
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler, array_var($_POST, 'fileContent'));
				fclose($handler);

				$file->save();
				$file->addToWorkspace(active_or_personal_project());
				$file->setTagsFromCSV('');
				$revision = $file->handleUploadedFile($file_dt, true);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_ADD);
				}
				DB::commit();
				flash_success(lang('success save file', $file->getFilename()));
				evt_add("document saved", array("id" => $file->getId(), "instance" => array_var($_POST, 'instanceName')));
				unlink($file_dt['tmp_name']);
				//$this->redirectTo('files', 'add_document', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();

				unlink($file_dt['tmp_name']);
				// if we uploaded the file remove it from repository
				if	(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
					FileRepository::deleteFile($revision->getRepositoryId());
				} // if
				flash_error(lang('error while saving'));
				//$this->redirectToUrl(get_url('files'));
			} // try
		}
	}

	function save_presentation() {
		ajx_current("empty");
		$postFile = array_var($_POST, 'file');
		$fileid = array_var($postFile, 'id');
		if($fileid > 0) {
			//edit presentation
			try {
				$file = ProjectFiles::findById($fileid);
				if (!$file->canEdit(logged_user())) {
					flash_error(lang('no access permissions'));
					ajx_current("empty");
					return;
				} // if
				DB::beginWork();
				$post_revision = array_var($_POST, 'new_revision_document') == 'checked'; // change file?
				$revision_comment = '';

				$file_dt['name'] = $file->getFilename();
				$file_content = unescapeSLIM(array_var($_POST, 'slimContent'));
				$file_dt['size'] = strlen($file_content);
				$file_dt['type'] = 'prsn';
				$file_dt['tmp_name'] = './tmp/' . rand() ;
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler,$file_content);
				fclose($handler);
				$file->setFilename(array_var($postFile, 'name'));
				$file->save();
				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				$file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_EDIT);
				}
				DB::commit();
				unlink($file_dt['tmp_name']);

				flash_success(lang('success save file', $file->getFilename()));
				//$this->redirectTo('files', 'add_presentation', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();
				unlink($file_dt['tmp_name']);
				flash_error(lang('error while saving'));
				//$this->redirectToUrl(get_url('files'));
			} // try
		} else  {
			// new presentation
			if (!ProjectFile::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
			} // if

			// prepare the file object
			$file = new ProjectFile();
			$file->setFilename(array_var($postFile, 'name'));
			$file->setIsVisible(true);

			$file->setIsPrivate(false);
			$file->setIsImportant(false);
			$file->setCommentsEnabled(true);
			$file->setAnonymousCommentsEnabled(false);

			// search for destination folder
			/*deprecated $folder = null;
			 $folder_id = get_id('file[folder_id]');
			 if ($folder_id) {
				$folder = ProjectFolders::findById($folder_id);
				} // if
				if (($folder instanceof ProjectFolder) && !is_array($file_data)) {
				$file_data = array(
				'folder_id' => $folder->getId()
				); // array
				} // if
				//deprecated*/
				
			//seteo esto para despues setear atributos
			$file_content = unescapeSLIM(array_var($_POST, 'slimContent'));
			$file_dt['name'] = array_var($postFile, 'name');
			$file_dt['size'] = strlen($file_content);
			$file_dt['type'] = 'prsn';

			$file->setCreatedOn(new DateTimeValue(time()) );
			try {
				DB::beginWork();
				$file_dt['tmp_name'] = './tmp/' . array_var($postFile,'name');
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler, unescapeSLIM(array_var($_POST, 'slimContent')));
				fclose($handler);

				$file->save();
				$file->addToWorkspace(active_or_personal_project());
				$file->setTagsFromCSV('');
				$revision = $file->handleUploadedFile($file_dt, true);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_ADD);
				}
				DB::commit();
				flash_success(lang('success save file', $file->getFilename()));
				evt_add("presentation saved", array("id" => $file->getId()));
				unlink($file_dt['tmp_name']);
				//$this->redirectTo('files', 'add_presentation', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();

				//tpl_assign('error', $e);
				tpl_assign('file', new ProjectFile()); // reset file
				unlink($file_dt['tmp_name']);
				// if we uploaded the file remove it from repository
				if	(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
					FileRepository::deleteFile($revision->getRepositoryId());
				} // if
				flash_error(lang('error while saving'));
				//$this->redirectToUrl(get_url('files'));
			} // try
		}
	}

	function save_spreadsheet() {
		if (get_id() > 0) {
			//edit spreadsheet
			try {
				$file = ProjectFiles::findById(get_id());
				if (!$file->canEdit(logged_user())) {
					flash_error(lang('no access permissions'));
					ajx_current("empty");
					return;
				} // if
				DB::beginWork();
				$post_revision = array_var($_POST, 'new_revision_spreadsheet') == 'checked'; // change file?
				$revision_comment = '';
				$file_dt['name'] = $file->getFilename();
				$file_content = array_var($_POST, "TrimSpreadsheet");
				$file_dt['size'] = strlen($file_content);
				$file_dt['type'] = 'sprd';
				$file_dt['tmp_name'] = './tmp/' . rand () ;
				$handler=fopen($file_dt['tmp_name'], 'w');
				fputs($handler, $file_content);
				fclose($handler);
				$file->save();
				$file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_EDIT);
				}
				DB::commit();
				unlink($file_dt['tmp_name']);

				flash_success(lang('success save file', $file->getFilename()));
				$this->redirectTo('files', 'add_spreadsheet', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();
				unlink($file_dt['tmp_name']);
				tpl_assign('error', $e);
				flash_error(lang('error while saving'));
				$this->redirectToReferer(get_url('files'));
			} // try
		} else  {
			//new spreadsheet
			if(!ProjectFile::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
			} // if

			// create the file object
			$file = new ProjectFile();
			$postFile=array_var($_POST,'file');
			$file->setFilename(array_var($postFile,'name'));
			$file->setIsVisible(true);

			$file->setIsPrivate(false);
			$file->setIsImportant(false);
			$file->setCommentsEnabled(true);
			$file->setAnonymousCommentsEnabled(false);

			/* search for the destination folder //deprecated
			 $folder = null;
			 $folder_id = get_id('file[folder_id]');
			 if($folder_id) {
				$folder = ProjectFolders::findById($folder_id);
				} // if
				if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
				$file_data = array(
				'folder_id' => $folder->getId()
				); // array
				} // if
				//deprecated*/

			//seteo esto para despues setear atributos
			$file_content = array_var($_POST,"TrimSpreadsheet");
			$file_dt['name'] = array_var($postFile,'name');
			$file_dt['size'] = strlen($file_content);
			$file_dt['type'] = 'sprd';

			$file->setCreatedOn(new DateTimeValue(time()) );
			try {
				DB::beginWork();
				$file_dt['tmp_name'] = './tmp/' . array_var($postFile,'name');
				$handler=fopen($file_dt['tmp_name'], 'w');
				fputs($handler,array_var($_POST,"TrimSpreadsheet"));
				fclose($handler);

				$file->save();
				$file->addToWorkspace(active_or_personal_project()->getId());
				$file->setTagsFromCSV('');
				$revision = $file->handleUploadedFile($file_dt, true); // handle uploaded file
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_ADD);
				}
				DB::commit();
				unlink($file_dt['tmp_name']);
				flash_success(lang('success add file', $file->getFilename()));
				$this->redirectTo('files', 'add_spreadsheet', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();
					
				tpl_assign('error', $e);
				tpl_assign('file', new ProjectFile()); // reset file
				unlink($file_dt['tmp_name']);
				// if we uploaded the file remove it from repository
				if (isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
					FileRepository::deleteFile($revision->getRepositoryId());
				} // if
				flash_error(lang('error while saving'));
				$this->redirectToUrl(get_url('files'));
			} // try
		}//new spreadsheet
	}

	function text_edit() {
		$file_data = array_var($_POST, 'file');
		if (!isset($file_data)) {
			// open text file
			$file = ProjectFiles::findById(get_id());
			if (!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				ajx_current("empty");
				return;
			} // if

			if (!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

				
			tpl_assign('file', $file);
		} else {
			ajx_current("empty");
			// save new file content
			try {
				$file = ProjectFiles::findById(array_var($file_data, 'id'));
				if (!($file instanceof ProjectFile)) {
					flash_error(lang('file dnx'));
					ajx_current("empty");
					return;
				} // if
				if (!$file->canEdit(logged_user())) {
					flash_error(lang('no access permissions'));
					return;
				} // if
				DB::beginWork();
				$post_revision = array_var($_POST, 'new_revision_document') == 'checked'; // change file?
				$revision_comment = '';

				$file_dt['name'] = $file->getFilename();
				$file_content = iconv(mb_detect_encoding(array_var($_POST, 'fileContent'), array('UTF-8','ISO-8859-1')), array_var($file_data, 'encoding'),array_var($_POST, 'fileContent'));
				$file_dt['size'] = strlen($file_content);
				$file_dt['type'] = $file->getTypeString();
				$file_dt['tmp_name'] = './tmp/' . rand () ;
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler, $file_content);
				fclose($handler);
				//$file->setFilename(array_var($postFile, 'name'));
				$file->save();
				$file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_EDIT);
				}
				DB::commit();
				unlink($file_dt['tmp_name']);

				flash_success(lang('success save file', $file->getFilename()));
			} catch(Exception $e) {
				DB::rollback();
				unlink($file_dt['tmp_name']);
				flash_error(lang('error while saving'));
			} // try
		}// if
	} // text_edit

	function add_document() {
		//ajx_prevent_close(true);
		if (get_id() > 0) {
			//open a document

			$this->setTemplate('add_document');

			$file = ProjectFiles::findById(get_id());
			if (!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				ajx_current("empty");
				return;
			} // if

			if(!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

			$file_data = array_var($_POST, 'file');
			if (!is_array($file_data)) {
				$tag_names = $file->getTagNames();
				$file_data = array(
				//deprecated'folder_id' => $file->getFolderId(),
					'description' => $file->getDescription(),
					'is_private' => $file->getIsPrivate(),
					'is_important' => $file->getIsImportant(),
					'comments_enabled' => $file->getCommentsEnabled(),
					'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
					'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				); // array
			} // if

			tpl_assign('file', $file);
			tpl_assign('file_data', $file_data);
		} else {
			//new document
			if (!ProjectFile::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

			$file = new ProjectFile();
			$file_data = array_var($_POST, 'file');

			/*deprecated $folder = null;
			 $folder_id = get_id('folder_id');
			 if ($folder_id) {
				$folder = ProjectFolders::findById($folder_id);
				} // if

				if (($folder instanceof ProjectFolder) && !is_array($file_data)) {
				$file_data = array(
				'folder_id' => $folder->getId()
				); // array
				} // if
				//deprecated*/
			tpl_assign('file', $file);
			tpl_assign('file_data', $file_data);
		}//end new document
	} // add_document

	function add_spreadsheet() {
		if (get_id() > 0) {
			//open a spreadsheet
			$this->setTemplate('add_spreadsheet');
			$file = ProjectFiles::findById(get_id());

			if(!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				ajx_current("empty");
				return;
			} // if

			if(!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

			$file_data = array_var($_POST, 'file');
			if(!is_array($file_data)) {
				$tag_names = $file->getTagNames();
				$file_data = array(
				//deprecated 'folder_id' => $file->getFolderId(),
					'description' => $file->getDescription(),
					'is_private' => $file->getIsPrivate(),
					'is_important' => $file->getIsImportant(),
					'comments_enabled' => $file->getCommentsEnabled(),
					'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
					'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				); // array
			} // if
			tpl_assign('file', $file);
			tpl_assign('file_data', $file_data);
		} else {
			// edit a spreadsheet
			if (!ProjectFile::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

			$file = new ProjectFile();
			$file_data = array_var($_POST, 'file');

			/*deprecated $folder = null;
			 $folder_id = get_id('folder_id');
			 if ($folder_id) {
				$folder = ProjectFolders::findById($folder_id);
				} // if

				if (($folder instanceof ProjectFolder) && !is_array($file_data)) {
				$file_data = array(
				'folder_id' => $folder->getId()
				); // array
				} // if
				//deprecated */
			tpl_assign('file', $file);
			tpl_assign('file_data', $file_data);
		}
	} // add_spreadsheet

	function add_presentation() {
		if (get_id() > 0) {
			//open presentation
			$this->setTemplate('add_presentation');
			$file = ProjectFiles::findById(get_id());

			if (!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				ajx_current("empty");
				return;
			} // if

			if (!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

			$file_data = array_var($_POST, 'file');
			if (!is_array($file_data)) {
				$tag_names = $file->getTagNames();
				$file_data = array(
				//'folder_id' => $file->getFolderId(),
					'description' => $file->getDescription(),
					'is_private' => $file->getIsPrivate(),
					'is_important' => $file->getIsImportant(),
					'comments_enabled' => $file->getCommentsEnabled(),
					'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
					'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				); // array
			} // if
			tpl_assign('file', $file);
			tpl_assign('file_data', $file_data);
		} else {
			//new presentation
			if(!ProjectFile::canAdd(logged_user(), active_or_personal_project())) {
				flash_error(lang('no access permissions'));
				ajx_current("empty");
				return;
			} // if

			$file = new ProjectFile();
			$file_data = array_var($_POST, 'file');

			/*deprecated$folder = null;
			 $folder_id = get_id('folder_id');
			 if($folder_id) {
				$folder = ProjectFolders::findById($folder_id);
				} // if

				if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
				$file_data = array(
				'folder_id' => $folder->getId()
				); // array
				} // if
	   //deprecated*/
			tpl_assign('file', $file);
			tpl_assign('file_data', $file_data);
		}
	}

	function list_files() {
		ajx_current("empty");
		 
		/* get query parameters */
		$start = array_var($_GET,'start');
		$limit = array_var($_GET,'limit');
		if (! $start) {
			$start = 0;
		}
		if (! $limit) {
			$limit = config_option('files_per_page');
		}
		$order = array_var($_GET,'sort');
		$orderdir = array_var($_GET,'dir');
		$page = (integer) ($start / $limit) + 1;
		$hide_private = !logged_user()->isMemberOfOwnerCompany();
		$project_id = array_var($_GET, 'active_project', 0);
		$tag = array_var($_GET,'tag');
		$type = array_var($_GET,'type');
		$user = array_var($_GET,'user');

		/* if there's an action to execute, do so */
		if (array_var($_GET, 'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'objects'));
			list($succ, $err) =  ObjectController::do_delete_objects($ids,'ProjectFiles');
			if ($err > 0) {
				flash_error(lang('error delete objects', $err));
			} else {
				flash_success(lang('success delete objects', $succ));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'objects'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = ObjectController::do_tag_object($tagTag, $ids,'ProjectFiles');
			if ($err > 0) {
				flash_error(lang('error tag objects', $err));
			} else {
				flash_success(lang('success tag objects', $succ));
			}
		}

		$project = Projects::findById($project_id);
		/* perform query */
		$result = ProjectFiles::getProjectFiles($project, null,
				$hide_private, $order, $orderdir, $page, config_option('files_per_page'), false, $tag, $type, $user);
		if (is_array($result)) {
			list($objects, $pagination) = $result;
		} else {
			$objects = null;
			$pagination = 0 ;
		} // if

		/* prepare response object */
		$listing = array(
			"totalCount" => $pagination->getTotalItems(),
			"files" => array()
		);
		if($objects){
			foreach ($objects as $o) {
				$coName = "";
				$coId = 0;
				if ($o->getCheckedOutById() != 0)
				{
					if ($o->getCheckedOutById() == logged_user()->getId())
					$coName = "self";
					else
					{
						$coId = $o->getCheckedOutById();
						$coName = Users::findById($coId)->getUsername();
					}
				}

				$listing["files"][] = array(
					"id" => $o->getId(),
					"object_id" => $o->getId(),
					"name" => $o->getFilename(),
					"type" => $o->getObjectTypeName(),
					"mimeType" => $o->getTypeString(),
					"tags" => project_object_tags($o),
					"createdBy" => Users::findById($o->getCreatedById())->getDisplayName(),
					"createdById" => $o->getCreatedById(),
					"dateCreated" => $o->getCreatedOn()->getTimestamp(),
					"updatedBy" => Users::findById($o->getUpdatedById())->getDisplayName(),
					"updatedById" => $o->getUpdatedById(),
					"dateUpdated" => $o->getUpdatedOn()->getTimestamp(),
					"icon" => $o->getTypeIconUrl(),
					"size" => $o->getFileSize(),
					"project" => $o->getWorkspacesNamesCSV(logged_user()->getActiveProjectIdsCSV()),
					"projectId" => $o->getWorkspacesIdsCSV(logged_user()->getActiveProjectIdsCSV()),
					"workspaceColors" => $o->getWorkspaceColorsCSV(logged_user()->getActiveProjectIdsCSV()),
					"url" => $o->getOpenUrl(),
					"manager" => get_class($o->manager()),
					"checkedOutByName" => $coName,
					"checkedOutById" => $coId,
					"isModifiable" => $o->isModifiable() && $o->canEdit(logged_user()),
					"modifyUrl" => $o->getModifyUrl()
				);
			}
		}
		ajx_extra_data($listing);
		tpl_assign("listing", $listing);
	}

	function open_file() {
		$fileId = $_GET['id'];
		$file = ProjectFiles::findById($fileId);
		if (!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
		if ($file) {
			$this->redirectToUrl($file->getModifyUrl());
		} else {
			flash_error(lang('file dnx'));
			ajx_current("empty");
		}
	}

	/**
	 * Tag file
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function tag_file() {
		$tag = array_var($_GET, 'tag');
		$ids = explode(',', array_var($_GET, 'files'));
		list($succ, $err) = $this->do_tag_file($tag, $ids);
		if($err) {
			flash_error(lang('error tag files', $err));
		}
		if ($succ) {
			flash_success(lang('success tag files'), $succ);
		}
		ajx_current("empty");
	}

	function do_tag_file($tag, $ids) {
		$err = $succ = 0;
		foreach ($ids as $id) {
			if (trim($id) != '') {
				try {
					$file = ProjectFiles::findById($id);
					if (!$file->canEdit(logged_user())) {
						$err ++;
					} // if
					else {
						Tags::addObjectTag($tag, $file);
						$succ++;
					}
				} catch (Exception $e) {
					$err ++;
				}
			}
		}
		return array($succ, $err);
	}

	/**
	 * Edit file properties
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function edit_file() {
		$this->setTemplate('add_file');

		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
			
		$file_data = array_var($_POST, 'file');
		if(!is_array($file_data)) {
			$tag_names = $file->getTagNames();
			$file_data = array(
			//'folder_id' => $file->getFolderId(),
				'description' => $file->getDescription(),
				'is_private' => $file->getIsPrivate(),
				'is_important' => $file->getIsImportant(),
				'comments_enabled' => $file->getCommentsEnabled(),
				'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
				'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				'edit_name' => $file->getFilename(),
				'file_id' => get_id()
			); // array
		} // if
		tpl_assign('file', $file);
		tpl_assign('file_data', $file_data);
		
			
		if(is_array(array_var($_POST, 'file'))) {
			try {
				$ids = array_var($_POST, "ws_ids", "");
				$enteredWS = Projects::findByCSVIds($ids);
				$validWS = array();
				foreach ($enteredWS as $ws) {
					if (ProjectMessage::canAdd(logged_user(), $ws)) {
						$validWS[] = $ws;
					}
				}
				if (empty($validWS)) {
					flash_error(lang('must choose at least one workspace error'));
					ajx_current("empty");
					return;
				}
				
				$old_is_private = $file->isPrivate();
				$old_is_important = $file->getIsImportant();
				$old_comments_enabled = $file->getCommentsEnabled();
				$old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
					
				DB::beginWork();
				$handle_file      = array_var($file_data, 'update_file') == 'checked'; // change file?
				$post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
				$revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?

				$file->setFromAttributes($file_data);
				$file->setFilename(array_var($file_data, 'name'));

				if(!logged_user()->isMemberOfOwnerCompany()) {
					$file->setIsPrivate($old_is_private);
					$file->setIsImportant($old_is_important);
					$file->setCommentsEnabled($old_comments_enabled);
					$file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
				} // if
				//$file->setFilename(array_var($file_data, 'name'));
				$file->save();
				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				if($handle_file) {
					$file->handleUploadedFile(array_var($_FILES, 'file_file'), $post_revision, $revision_comment);
				} // if
				$file->save_properties($file_data);
				
				$file->removeFromWorkspaces(logged_user()->getActiveProjectIdsCSV());
				foreach ($validWS as $w) {
					$file->addToWorkspace($w);
				}
				foreach ($validWS as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_EDIT);
				}
				DB::commit();
				
				
				flash_success(lang('success edit file', $file->getFilename()));
				ajx_current("back");
			} catch(Exception $e) {
				//@unlink($file->getFilePath());
				DB::rollback();
				ajx_current("empty");
				flash_error($e->getMessage() . $e->getTraceAsString());
			} // try
		} // if
	} // edit_file

	function checkin_file() {
		$this->setTemplate('add_file');

		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
			
		$file_data = array_var($_POST, 'file');
		if(!is_array($file_data)) {
			$tag_names = $file->getTagNames();
			$file_data = array(
			//'folder_id' => $file->getFolderId(),
				'description' => $file->getDescription(),
				'is_private' => $file->getIsPrivate(),
				'is_important' => $file->getIsImportant(),
				'comments_enabled' => $file->getCommentsEnabled(),
				'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
				'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				'workspaces' => $file->getWorkspacesNamesCSV(logged_user()->getActiveProjectIdsCSV()),
			); // array
		} // if
		tpl_assign('file', $file);
		tpl_assign('file_data', $file_data);
		tpl_assign('checkin', true);
			
		if(is_array(array_var($_POST, 'file'))) {
			try {
				$old_is_private = $file->isPrivate();
				$old_is_important = $file->getIsImportant();
				$old_comments_enabled = $file->getCommentsEnabled();
				$old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
					
				DB::beginWork();
				$handle_file      = true; // change file?
				$post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
				$revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?

				$file->setFromAttributes($file_data);
				$file->setCheckedOutById(0);

				if(!logged_user()->isMemberOfOwnerCompany()) {
					$file->setIsPrivate($old_is_private);
					$file->setIsImportant($old_is_important);
					$file->setCommentsEnabled($old_comments_enabled);
					$file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
				} // if
				$file->save();
				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				if($handle_file) {
					$file->handleUploadedFile(array_var($_FILES, 'file_file'), $post_revision, $revision_comment);
				} // if
				$file->save_properties($file_data);
				
				$ws = $file->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_EDIT);
				}
				DB::commit();

				flash_success(lang('success add file', $file->getFilename()));
				ajx_current("back");
			} catch(Exception $e) {
				//@unlink($file->getFilePath());
				DB::rollback();
				flash_error($e->getMessage());
				ajx_current("empty");
			} // try
		} // if
	} // checkin_file

	/**
	 * Delete file
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_file() {
		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
			
		try {
			DB::beginWork();
			$file->delete();
			
			$ws = $file->getWorkspaces();
			foreach ($ws as $w) {
				ApplicationLogs::createLog($file, $w, ApplicationLogs::ACTION_DELETE);
			}
			DB::commit();

			flash_success(lang('success delete file', $file->getFilename()));
			ajx_current("back");
		} catch(Exception $e) {
			flash_error(lang('error delete file'));
			ajx_current("empty");
		} // try
	}

	function check_filename(){
		ajx_current("empty");
		$filename = array_var($_GET, 'filename');
		$files = ProjectFiles::getAllByFilename($filename, logged_user()->getActiveProjectIdsCSV());

		if (is_array($files) && count($files) > 0){
			$files_array = array();
			
			foreach ($files as $file){
				if ($file->getId() != array_var($_GET, 'id')){
					$files_array[] = array(
						"id" => $file->getId(),
						"name" => $file->getFilename(),
						"description" => $file->getDescription(),
						"type" => $file->getTypeString(),
						"size" => $file->getFilesize(),
						"created_by_id" => $file->getCreatedById(),
						"created_by_name" => Users::findById($file->getCreatedById())->getDisplayName(),
						"created_on" => $file->getCreatedOn()->getTimestamp(),
						"is_checked_out" => $file->isCheckedOut(),
						"checked_out_by_name" => $file->getCheckedOutByDisplayName(),
						"can_check_in" => $file->canCheckin(logged_user()),
						"can_edit" => $file->canEdit(logged_user()),
						"workspace_names" => $file->getWorkspacesNamesCSV(logged_user()->getActiveProjectIdsCSV()),
						"workspace_ids" => $file->getWorkspacesIdsCSV(logged_user()->getActiveProjectIdsCSV()),
						"workspace_colors" => $file->getWorkspaceColorsCSV(logged_user()->getActiveProjectIdsCSV()),
					);
				}
			}
			
			if (count($files_array) > 0){
				ajx_extra_data(array(
					"files" => $files_array
				));
			} else {
				ajx_extra_data(array(
					"id" => 0,
					"name" => $filename
				));
			}
		} else {
			ajx_extra_data(array(
				"id" => 0,
				"name" => $filename
			));
		}
	}

	function filenameExists($filename){
		$file = ProjectFiles::getByFilename($filename);
		return $file instanceof ProjectFile;
	}
	
	// ---------------------------------------------------
	//  Revisions
	// ---------------------------------------------------
	
	/**
	 * Update file revision (comment)
	 *
	 * @param void
	 * @return null
	 */
	function edit_file_revision() {
		$this->setTemplate('add_file_revision');
			
		$revision = ProjectFileRevisions::findById(get_id());
		if(!($revision instanceof ProjectFileRevision)) {
			flash_error(lang('file revision dnx'));
			ajx_current("empty");
			return;
		} // if
			
		$file = $revision->getFile();
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
			
		$revision_data = array_var($_POST, 'revision');
		if(!is_array($revision_data)) {
			$revision_data = array(
				'comment' => $revision->getComment(),
			); // array
		} // if
			
		tpl_assign('revision', $revision);
		tpl_assign('file', $file);
		tpl_assign('revision_data', $revision_data);
			
		if(is_array(array_var($_POST, 'revision'))) {
			try {
				DB::beginWork();
				$revision->setComment(array_var($revision_data, 'comment'));
				$revision->save();
				
				$ws = $revision->getWorkspaces();
				foreach ($ws as $w) {
					ApplicationLogs::createLog($revision, $w, ApplicationLogs::ACTION_EDIT, $revision->isPrivate());
				}
				DB::commit();

				flash_success(lang('success edit file revision'));
				ajx_current("back");
			} catch(Exception $e) {
				flash_error($e->getMessage());
				DB::rollback();
				ajx_current("empty");
			} // try
		} // if
	} // edit_file_revision

	/**
	 * Delete selected revision (if you have proper permissions)
	 *
	 * @param void
	 * @return null
	 */
	function delete_file_revision() {
		$revision = ProjectFileRevisions::findById(get_id());
		if(!($revision instanceof ProjectFileRevision)) {
			flash_error(lang('file revision dnx'));
			ajx_current("empty");
			return;
		} // if
			
		$file = $revision->getFile();
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			ajx_current("empty");
			return;
		} // if
			
		$all_revisions = $file->getRevisions();
		if(count($all_revisions) == 1) {
			flash_error(lang('cant delete only revision'));
			ajx_current("empty");
			return;
		} // if
			
		if(!$file->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		} // if
			
		try {
			DB::beginWork();
			$revision->delete();
			$ws = $revision->getWorkspaces();
			foreach ($ws as $w) {
				ApplicationLogs::createLog($revision, $w, ApplicationLogs::ACTION_DELETE);
			}
			DB::commit();

			flash_success(lang('success delete file revision'));
			ajx_current("reload");
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete file revision'));
			ajx_current("empty");
		} // try
	} // delete_file_revision


} // FilesController

?>