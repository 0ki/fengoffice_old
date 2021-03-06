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
		if (is_ajax_request()) {
			prepare_company_website_controller($this, 'ajax');
		} else {
			prepare_company_website_controller($this, 'website');
		}
	} // __construct

	/**
	 * Show files index page (list recent files)
	 *
	 * @param void
	 * @return null
	 */
	function index() {
		if (is_ajax_request()) {
			$this->setLayout('ajaxfull');
		} else {
			$this->setLayout('full');
		}
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
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!$file->canView(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		$revisions = $file->getRevisions();
		if(!count($revisions)) {
			flash_error(lang('no file revisions in file'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		tpl_assign('file', $file);
		//deprecated tpl_assign('folder', $file->getFolder());
		tpl_assign('last_revision', $file->getLastRevision());
		tpl_assign('revisions', $revisions);
		tpl_assign('order', null);
		tpl_assign('page', null);
		tpl_assign('important_files', $file->getProject()->getImportantFiles());
		 
		// This variables are required for the sidebar
		//deprecated tpl_assign('current_folder', $file->getFolder());
		//deprecated tpl_assign('folders', active_project()->getFolders());
		 
		//deprecated $this->setSidebar(get_template_path('index_sidebar', 'files'));
		 
	} // file_details

	function slideshow() {
		$this->setLayout('slideshow');
		$fileid = array_var($_GET, 'fileId');
		$file = ProjectFiles::instance()->findById($fileid);
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
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!$file->canDownload(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		download_contents($file->getFileContent(), $file->getTypeString(), $file->getFilename(), $file->getFileSize(), !$inline);
		die();
	} // download_file
	
	
	function checkout_file()
	{
		$file = ProjectFiles::findById(get_id());
		$file->setCheckedOutById(logged_user()->getId());
		$file->setCheckedOutOn(new DateTimeValue(time()));
		try{
			DB::beginWork();
			$file->save();
			DB::commit();
		}
		catch(Exception $e)
		{
			DB::rollback();
		}
		self::download_file();
	}

	/**
	 * Download specific revision
	 *
	 * @param void
	 * @return null
	 */
	function download_revision() {
		$revision = ProjectFileRevisions::findById(get_id());
		if(!($revision instanceof ProjectFileRevision)) {
			flash_error(lang('file revision dnx'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		$file = $revision->getFile();
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!($revision->canDownload(logged_user()))) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		download_contents($revision->getFileContent(), $revision->getTypeString(), $file->getFilename(), $file->getFileSize());
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
		if (is_array($file_data) && array_var($file_data, 'project_id')) {
			$projectId = array_var($file_data, 'project_id');
			$project = Projects::findById($projectId);
		}
		if (!isset($project)) {
			$project = active_or_personal_project();
		}
		if(!ProjectFile::canAdd(logged_user(), $project)) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		$file = new ProjectFile();
		//deprecated $folder = null;
		//deprecated $folder_id = get_id('folder_id');
		//deprecated if($folder_id) {
		//deprecated 	$folder = ProjectFolders::findById($folder_id);
		//deprecated } // if
		 
		//deprecated if(($folder instanceof ProjectFolder) && !is_array($file_data)) {
		//deprecated 	$file_data = array(
		//deprecated		'folder_id' => $folder->getId()
		//deprecated	); // array
		//deprecated } // if
		 
		tpl_assign('file', $file);
		tpl_assign('file_data', $file_data);
		tpl_assign('tags', Tags::getTagNames());
		 
		if(is_array(array_var($_POST, 'file'))) {
			$this->setLayout("html");
			$this->setTemplate(get_template_path("json"));
			try {
				DB::beginWork();
				$uploaded_file = array_var($_FILES, 'file_file');
				$file->setFromAttributes($file_data);

				if(!logged_user()->isMemberOfOwnerCompany()) {
					$file->setIsPrivate(false);
					$file->setIsImportant(false);
					$file->setCommentsEnabled(true);
					$file->setAnonymousCommentsEnabled(false);
				} // if
				$file->setFilename(array_var($uploaded_file, 'name'));
				$file->setProjectId($project->getId());
				$file->setIsVisible(true);
				$file->save();

				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				$revision = $file->handleUploadedFile($uploaded_file, true); // handle uploaded file

				//Add properties
				$file->save_properties($file_data);			

				ApplicationLogs::createLog($file, $project, ApplicationLogs::ACTION_ADD);
				DB::commit();

				//flash_success(lang('success add file', $file->getFilename()));
				$object = array(
					"errorCode" => 0,
					"errorMessage" => lang('success add file', $file->getFilename()),
					"current" => array(
						"type" => "url",
						"data" => $file->getDetailsUrl()
					)
				);
				tpl_assign("object", $object);
				//$this->redirectToUrl($file->getDetailsUrl());
			} catch(Exception $e) {
				DB::rollback();
				$object = array(
					"errorCode" => $e->getCode() || 1,
					"errorMessage" => $e->getMessage()
				);
				tpl_assign("object", $object);

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
					//$this->redirectToReferer(get_url('files'));
				} // if
				DB::beginWork();
				$post_revision = array_var($_POST, 'new_revision_document') == 'checked'; // change file?
				$revision_comment = '';

				$file_dt['name'] = $file->getFilename();
				$file_content = array_var($_POST, 'fileContent');
				$file_dt['size'] = strlen($file_content);
				$file_dt['type'] = 'txt';
				$file_dt['tmp_name'] = './tmp/' . rand () ;
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler,$file_content);
				fclose($handler);
				$file->setFilename(array_var($postFile, 'name'));
				$file->save();
				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				$file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();
				unlink($file_dt['tmp_name']);

				flash_success(lang('success save file', $file->getFilename()));
				//$this->redirectTo('files', 'add_document', array('id' => $file->getId()));
			} catch(Exception $e) {
				DB::rollback();
				unlink($file_dt['tmp_name']);
				flash_error(lang('error while saving'));
				//$this->redirectToReferer(get_url('files'));
			} // try
		} else  {
			// new document
			if (active_project() && !ProjectFile::canAdd(logged_user(), active_project())) {
				flash_error(lang('no access permissions'));
				//$this->redirectToReferer(get_url('files'));
			} // if

			// prepare the file object
			$file = new ProjectFile();
			$file->setFilename(array_var($postFile, 'name'));
			$file->setProjectId(active_or_personal_project()->getId());
			$file->setIsVisible(true);

			$file->setIsPrivate(false);
			$file->setIsImportant(false);
			$file->setCommentsEnabled(true);
			$file->setAnonymousCommentsEnabled(false);

			// search for destination folder
			//deprecated $folder = null;
			//deprecated $folder_id = get_id('file[folder_id]');
			//deprecated if ($folder_id) {
			//deprecated 	$folder = ProjectFolders::findById($folder_id);
			//deprecated } // if
			//deprecated if (($folder instanceof ProjectFolder) && !is_array($file_data)) {
			//deprecated 	$file_data = array(
			//deprecated		'folder_id' => $folder->getId()
			//deprecated	); // array
			//deprecated} // if

			//seteo esto para despues setear atributos
			$file_content = array_var($_POST, 'fileContent');
			$file_dt['name'] = array_var($postFile,'name');
			$file_dt['size'] = strlen($file_content);
			$file_dt['type'] = 'txt';

			$file->setCreatedOn(new DateTimeValue(time()) );
			try {
				DB::beginWork();
				$file_dt['tmp_name'] = './tmp/' . array_var($postFile,'name');
				$handler = fopen($file_dt['tmp_name'], 'w');
				fputs($handler, array_var($_POST, 'fileContent'));
				fclose($handler);

				$file->save();
				$file->setTagsFromCSV('');
				$revision = $file->handleUploadedFile($file_dt, true);
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_ADD);
				DB::commit();
				flash_success(lang('success save file', $file->getFilename()));
				evt_add("file saved", array("id" => $file->getId()));
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
		$this->setLayout("html");
		$this->setTemplate("save_file");
		if(get_id() > 0) {
			//edit presentation
			try {
				$file = ProjectFiles::findById(get_id());
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
				$file->save();
				$file->setTagsFromCSV(array_var($file_data, 'tags'));
				$file->handleUploadedFile($file_dt, $post_revision, $revision_comment);
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();
				unlink($file_dt['tmp_name']);

				//flash_success(lang('success save file', $file->getFilename()));
				//$this->redirectTo('files', 'add_presentation', array('id' => $file->getId()));
				tpl_assign('error', lang('success save file', $file->getFilename()));
				tpl_assign('success', "true");
			} catch(Exception $e) {
				DB::rollback();
				unlink($file_dt['tmp_name']);
				//tpl_assign('error', $e);
				//flash_error(lang('error while saving'));
				//$this->redirectToUrl(get_url('files'));
				tpl_assign('success', "false");
				tpl_assign('error', $e->getMessage());
			} // try
		} else  {
			// new presentation
			if (active_project() && !ProjectFile::canAdd(logged_user(), active_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
			} // if

			// prepare the file object
			$file = new ProjectFile();
			$postFile = array_var($_POST, 'file');
			$file->setFilename(array_var($postFile, 'name'));
			$file->setProjectId(active_or_personal_project()->getId());
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
				$file->setTagsFromCSV('');
				$revision = $file->handleUploadedFile($file_dt, true);
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_ADD);
				DB::commit();
				//flash_success(lang('success save file', $file->getFilename()));
				unlink($file_dt['tmp_name']);
				//$this->redirectTo('files', 'add_presentation', array('id' => $file->getId()));
				tpl_assign('error', lang('success save file', $file->getFilename()));
				tpl_assign('success', "true");
				tpl_assign('forward', get_url('files', 'add_presentation', array('id' => $file->getId())));
			} catch(Exception $e) {
				DB::rollback();

				//tpl_assign('error', $e);
				tpl_assign('file', new ProjectFile()); // reset file
				unlink($file_dt['tmp_name']);
				// if we uploaded the file remove it from repository
				if	(isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
					FileRepository::deleteFile($revision->getRepositoryId());
				} // if
				//flash_error(lang('error while saving'));
				//$this->redirectToUrl(get_url('files'));
				tpl_assign('success', "false");
				tpl_assign('error', $e->getMessage());
			} // try
		}
	}

	function save_spreadsheet() {
		if (get_id() > 0) {
			//edit spreadsheet
			try {
				$file = ProjectFiles::findById(get_id());
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
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_EDIT);
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
			if(active_project() && !ProjectFile::canAdd(logged_user(), active_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
			} // if
				
			// create the file object
			$file = new ProjectFile();
			$postFile=array_var($_POST,'file');
			$file->setFilename(array_var($postFile,'name'));
			$file->setProjectId(active_or_personal_project()->getId());
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
				$file->setTagsFromCSV('');
				$revision = $file->handleUploadedFile($file_dt, true); // handle uploaded file
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_ADD);
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


	function add_document() {
		if (is_ajax_request()) {
			$this->setLayout('ajaxfull');
		} else {
			$this->setLayout('full');
		}
		if (get_id() > 0) {
			//open a document

			$this->setTemplate('add_document');
				
			$file = ProjectFiles::findById(get_id());
			if (!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				$this->redirectToReferer(get_url('files'));
			} // if
				
			if(!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
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
			if (active_project() && !ProjectFile::canAdd(logged_user(), active_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
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
		if (is_ajax_request()) {
			$this->setLayout('ajaxfull');
		} else {
			$this->setLayout('full');
		}
		if (get_id() > 0) {
			//open a spreadsheet
			$this->setTemplate('add_spreadsheet');
			$file = ProjectFiles::findById(get_id());

			if(!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				$this->redirectToReferer(get_url('files'));
			} // if
				
			if(!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
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
			if (active_project() && !ProjectFile::canAdd(logged_user(), active_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
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
		if (is_ajax_request()) {
			$this->setLayout('ajaxfull');
		} else {
			$this->setLayout('full');
		}
		if (get_id() > 0) {
			//open presentation
			$this->setTemplate('add_presentation');
			$file = ProjectFiles::findById(get_id());

			if (!($file instanceof ProjectFile)) {
				flash_error(lang('file dnx'));
				$this->redirectToReferer(get_url('files'));
			} // if
				
			if (!$file->canEdit(logged_user())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
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
			if(active_project() && !ProjectFile::canAdd(logged_user(), active_project())) {
				flash_error(lang('no access permissions'));
				$this->redirectToReferer(get_url('files'));
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
		$this->setLayout('json');
    	$this->setTemplate(get_template_path('json'));
    	
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
		$project = array_var($_GET,'active_project');
		$tag = array_var($_GET,'tag');
		$type = array_var($_GET,'type');
		$user = array_var($_GET,'user');

		/* if there's an action to execute, do so */
		if (array_var($_GET, 'action') == 'delete') {
			$ids = explode(',', array_var($_GET, 'objects'));
			list($succ, $err) =  ObjectController::do_delete_objects($ids,'ProjectFiles');
			if ($err > 0) {
				tpl_assign('errCode', -1);
				tpl_assign('errMsg', lang('error delete objects', $err));
			} else {
				tpl_assign('errCode', 0);
				tpl_assign('errMsg', lang('success delete objects', $succ));
			}
		} else if (array_var($_GET, 'action') == 'tag') {
			$ids = explode(',', array_var($_GET, 'objects'));
			$tagTag = array_var($_GET, 'tagTag');
			list($succ, $err) = ObjectController::do_tag_object($tagTag, $ids,'ProjectFiles');
			if ($err > 0) {
				tpl_assign('errCode', -1);
				tpl_assign('errMsg', lang('error tag objects', $err));
			} else {
				evt_add("tag added", array("name" => $tagTag));
				tpl_assign('errCode', 0);
				tpl_assign('errMsg', lang('success tag objects', $succ));
			}
		}

		/* perform query */
		$result = ProjectFiles::getProjectFiles($project, null ,
		$hide_private, $order, $orderdir, $page, config_option('files_per_page'), false, $tag, $type, $user);
		if (is_array($result)) {
			list($objects, $pagination) = $result;
		} else {
			$objects = null;
			$pagination = 0 ;
		} // if
		
		/* prepare response object */
		$object = array(
			"totalCount" => $pagination->getTotalItems(),
			"events" => evt_list(),
			"errorCode" => isset($errCode)?$errCode:0,
			"errorMessage" => isset($errMsg)?$errMsg:"",
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
				
				$object["files"][] = array(
					"id" => $o->getId(),
					"object_id" => $o->getId(),
					"name" => $o->getFilename(),
					"type" => $o->getTypeString(),
					"tags" => project_object_tags($o, $o->getProject(), true),
					"createdBy" => Users::findById($o->getCreatedById())->getUsername(),
					"createdById" => $o->getCreatedById(),
					"dateCreated" => $o->getCreatedOn()->getTimestamp(),
					"updatedBy" => Users::findById($o->getUpdatedById())->getUsername(),
					"updatedById" => $o->getUpdatedById(),
					"dateUpdated" => $o->getUpdatedOn()->getTimestamp(),
					"icon" => $o->getTypeIconUrl(),
					"size" => $o->getFileSize(),
					"project" => $o->getProject()->getName(),
					"projectId" => $o->getProjectId(),
					"url" => $o->getOpenUrl(),
					"manager" => get_class($o->manager()),
					"checkedOutByName" => $coName,
					"checkedOutById" => $coId
				);
	    	}
		}
    	tpl_assign("object", $object);
	}

	function open_file() {
		$fileId = $_GET['id'];
		$file = ProjectFiles::findById($fileId);
		if ($file) {
			if (strcmp('sprd', $file->getTypeString()) == 0) {
				$this->redirectTo('files', 'add_spreadsheet', array('id' => $fileId));
			} else if (strcmp('txt', $file->getTypeString()) == 0) {
				$this->redirectTo('files', 'add_document', array('id' => $fileId));
			} else if (strcmp('prsn', $file->getTypeString()) == 0) {
				$this->redirectTo('files', 'add_presentation', array('id' => $fileId));
			} else {
				$this->redirectTo('files', 'file_details', array('id' => $fileId));
			}
		} else {
			flash_error(lang('file dnx'));
			$this->redirectToReferer(get_url('files'));
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
		$this->redirectToUrl(get_url('files'));
	}

	function do_tag_file($tag, $ids) {
		$err = $succ = 0;
		foreach ($ids as $id) {
			if (trim($id) != '') {
				try {
					$file = ProjectFiles::findById($id);
					Tags::addFileTag($tag, $id, $file->getProject());
					$succ++;
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
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
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
				'project_id' => $file->getProjectId(),
			); // array
		} // if
		tpl_assign('file', $file);
		tpl_assign('file_data', $file_data);
		 
		if(is_array(array_var($_POST, 'file'))) {
			$this->setLayout("html");

			$this->setTemplate("save_file");
			tpl_assign('success', "false");
			try {
				$old_is_private = $file->isPrivate();
				$old_is_important = $file->getIsImportant();
				$old_comments_enabled = $file->getCommentsEnabled();
				$old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
					
				DB::beginWork();
				$handle_file      = array_var($file_data, 'update_file') == 'checked'; // change file?
				$post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
				$revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?

				$file->setFromAttributes($file_data);

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
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();

				//flash_success(lang('success add file', $file->getFilename()));
				tpl_assign('forward', $file->getDetailsUrl());
				tpl_assign('error', lang('success add file', $file->getFilename()));
				tpl_assign('success', "true");
			} catch(Exception $e) {
				//@unlink($file->getFilePath());
				DB::rollback();
				tpl_assign('error', $e);
			} // try
		} // if
	} // edit_file
	
	function checkin_file() {
		$this->setTemplate('add_file');

		$file = ProjectFiles::findById(get_id());
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		$file_data = array_var($_POST, 'file');		
		if(!is_array($file_data)) {
			$tag_names = $file->getTagNames();
			$file_data = array(
				'folder_id' => $file->getFolderId(),
				'description' => $file->getDescription(),
				'is_private' => $file->getIsPrivate(),
				'is_important' => $file->getIsImportant(),
				'comments_enabled' => $file->getCommentsEnabled(),
				'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
				'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
				'project_id' => $file->getProjectId(),
			); // array
		} // if
		tpl_assign('file', $file);
		tpl_assign('file_data', $file_data);
		tpl_assign('checkin', true);
		 
		if(is_array(array_var($_POST, 'file'))) {
			$this->setLayout("html");
			$this->setTemplate(get_template_path("json"));
			tpl_assign('success', "false");
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
				ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_EDIT);
				DB::commit();

				$object = array(
					"errorCode" => 0,
					"errorMessage" => lang('success add file', $file->getFilename()),
					"current" => array(
						"type" => "url",
						"data" => $file->getDetailsUrl()
					)
				);
				tpl_assign("object", $object);
			} catch(Exception $e) {
				//@unlink($file->getFilePath());
				DB::rollback();
				$object = array(
					"errorCode" => $e->getCode() || 1,
					"errorMessage" => $e->getMessage()
				);
				tpl_assign("object", $object);
			} // try
		} // if
	} // edit_file

	/**
	 * Delete files given by a comma-separated list of their ids
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_files(){
		$ids = explode(',', array_var($_GET, 'files'));
		list($succ, $err) = $this->do_delete_files($ids);
		if($err) {
			flash_error(lang('error delete files', $err));
		}
		if ($succ) {
			flash_success(lang('success delete files'), $succ);
		}
		$this->redirectTo('files');
	}

	function do_delete_files($ids) {
		$err = 0; // count errors
		$succ = 0; // count files deleted
		foreach ($ids as $id) {
			try {
				if(trim($id)!=''){
					FilesController::delete_file_by_id($id);
					$succ ++;
				}
			} catch(Exception $e) {
				$err ++;
			} // try
		}
		return array($succ, $err);
	}

	/**
	 * Delete file
	 *
	 * @access public
	 * @param void
	 * @return null
	 */
	function delete_file_by_id($fileId) {
		$file = ProjectFiles::findById($fileId);
		 
		if(!$file->canEdit(logged_user())) {
			return ;
		} // if
		DB::beginWork();
		$file->delete();
		ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_DELETE);
		DB::commit();

	} // delete_file

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
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!$file->canEdit(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		try {
			DB::beginWork();
			$file->delete();
			ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete file', $file->getFilename()));
		} catch(Exception $e) {
			flash_error(lang('error delete file'));
		} // try
		 
		$this->redirectTo('files');
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
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		$file = $revision->getFile();
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		if(!$revision->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
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
				ApplicationLogs::createLog($revision, $revision->getProject(), ApplicationLogs::ACTION_EDIT, $revision->isPrivate());
				DB::commit();

				flash_success(lang('success edit file revision'));
				$this->redirectToUrl($revision->getDetailsUrl());
			} catch(Exception $e) {
				tpl_assign('error', $e);
				DB::rollback();
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
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		$file = $revision->getFile();
		if(!($file instanceof ProjectFile)) {
			flash_error(lang('file dnx'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		$all_revisions = $file->getRevisions();
		if(count($all_revisions) == 1) {
			flash_error(lang('cant delete only revision'));
			$this->redirectToReferer($file->getDetailsUrl());
		} // if
		 
		if(!$revision->canDelete(logged_user())) {
			flash_error(lang('no access permissions'));
			$this->redirectToReferer(get_url('files'));
		} // if
		 
		try {
			DB::beginWork();
			$revision->delete();
			ApplicationLogs::createLog($revision, $revision->getProject(), ApplicationLogs::ACTION_DELETE);
			DB::commit();

			flash_success(lang('success delete file revision'));
		} catch(Exception $e) {
			DB::rollback();
			flash_error(lang('error delete file revision'));
		} // try
		 
		$this->redirectToUrl($file->getDetailsUrl());
	} // delete_file_revision


} // FilesController

?>