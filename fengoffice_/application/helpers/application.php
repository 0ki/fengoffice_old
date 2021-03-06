<?php

  /**
  * Application helpers. This helpers are injected into the controllers
  * through ApplicationController constructions so they are available in
  * whole application
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  
  /**
  * Render user box
  *
  * @param User $user
  * @return null
  */
  function render_user_box(User $user) {
    tpl_assign('_userbox_user', $user);
    tpl_assign('_userbox_projects', $user->getActiveProjects());
    return tpl_fetch(get_template_path('user_box', 'application'));
  } // render_user_box 
   
  /**
  * Render project users combo.
  *
  * @param String $name
  * @param array $attributes
  * @return String All users I am sharing something with.
  */
  function render_sharing_users($name, $attributes = null) {
  	//TODO:  This functions must be rebuilt
  	$perms= ObjectUserPermissions::getAllPermissionsByUser(logged_user());  	
    $options = array(option_tag(lang('none'), 0));
  	$my_id = logged_user()->getId();
  	foreach ($perms as $perm)
  	{
  		$file_id=$perm->getFileId();
  		if(trim($file_id) !='')
  		{
	  		$users = ObjectUserPermissions::getAllPermissionsByObjectIdAndManager($file_id, 'ProjectFiles');
	  		foreach ($users as $user_perm)
	  		{
	  			$user_id=$user_perm->getUserId();
	  			if($user_id!=null && trim($user_id)!='' && $user_id!=$my_id)
	  			{
		  			$user = Users::findById($user_id);
			  		if($user != null )
			  		{//foreach user
			  			$options[] = option_tag($user->getUserName(),$user->getUserName());
			  		}
	  			}  
	  		}
  		}
  	}
  	$options=array_unique($options);
  	return select_box($name,$options, $attributes);
  } // render_user_box
  
  /**
  * This function will render system notices for this user
  *
  * @param User $user
  * @return string
  */
  function render_system_notices(User $user) {
    if(!$user->isAdministrator()) return;
    
    $system_notices = array();
    if(config_option('upgrade_check_enabled', false) && config_option('upgrade_last_check_new_version', false)) $system_notices[] = lang('new OpenGoo version available', get_url('administration', 'upgrade'));
    
    if(count($system_notices)) {
      tpl_assign('_system_notices', $system_notices);
      return tpl_fetch(get_template_path('system_notices', 'application'));
    } // if
  } // render_system_notices
  
  /**
  * Render select company box
  *
  * @param integer $selected ID of selected company
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_company($name, $selected = null, $attributes = null) {
    $companies = Companies::getAll();
    $options = array(option_tag(lang('none'), 0));
    if(is_array($companies)) {
      foreach($companies as $company) {
        $option_attributes = $company->getId() == $selected ? array('selected' => 'selected') : null;
        $company_name = $company->getName();
        if($company->isOwner()) $company_name .= ' (' . lang('owner company') . ')';
        $options[] = option_tag($company_name, $company->getId(), $option_attributes);
      } // foreach
    } // if
    return select_box($name, $options, $attributes);
  } // select_company
  
  /**
  * Render select project box
  *
  * @param integer $selected ID of selected project
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_project($name, $projects, $selected = null, $attributes = null) {
    $options = array(option_tag(lang('none'), 0));
    if(is_array($projects)) {
      foreach($projects as $project) {
        $option_attributes = $project->getId() == $selected ? array('selected' => 'selected') : null;
        $project_name = $project->getName();
        $options[] = option_tag($project_name, $project->getId(), $option_attributes);
      } // foreach
    } // if
    return select_box($name, $options, $attributes);
  } // select_project
  
  /**
  * Render assign to SELECT
  *
  * @param string $list_name Name of the select control
  * @param Project $project Selected project, if NULL active project will be used
  * @param integer $selected ID of selected user
  * @param array $attributes Array of select box attributes, if needed
  * @return null
  */
  function assign_to_select_box($list_name, $project = null, $selected = null, $attributes = null) {
    if(is_null($project)) {
      $project = active_or_personal_project();
    } // if
    if(!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    $logged_user = logged_user();
    
    $can_assign_to_owners = $logged_user->isMemberOfOwnerCompany() || $logged_user->getProjectPermission($project, ProjectUsers::CAN_ASSIGN_TO_OWNERS);
    $can_assign_to_other = $logged_user->isMemberOfOwnerCompany() || $logged_user->getProjectPermission($project, ProjectUsers::CAN_ASSIGN_TO_OTHER);
    
    $grouped_users = $project->getUsers(true);
    
    $options = array(option_tag(lang('anyone'), '0:0'));
    if(is_array($grouped_users) && count($grouped_users)) {
      foreach($grouped_users as $company_id => $users) {
        $company = Companies::findById($company_id);
        if(!($company instanceof Company)) {
          continue;
        } // if
        
        // Check if $logged_user can assign task to members of this company
        if($company_id <> $logged_user->getCompanyId()) {
          if($company->isOwner()) {
            if(!$can_assign_to_owners) {
              continue;
            } // if
          } else {
            if(!$can_assign_to_other) {
              continue;
            } // if
          } // if
        } // if
        
        $options[] = option_tag('--', '0:0'); // separator
        
        $option_attributes = $company->getId() . ':0' == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($company->getName(), $company_id . ':0', $option_attributes);
        
        if(is_array($users)) {
          foreach($users as $user) {
            $option_attributes = $company_id . ':' . $user->getId() == $selected ? array('selected' => 'selected') : null;
            $options[] = option_tag($company->getName() . ': ' . $user->getDisplayName(), $company_id . ':' . $user->getId(), $option_attributes);
          } // foreach
        } // if
        
      } // foreach
    } // if
    
    return select_box($list_name, $options, $attributes);
  } // assign_to_select_box
  
  /**
  * Renders select milestone box
  *
  * @param string $name
  * @param Project $project
  * @param integer $selected ID of selected milestone
  * @param array $attributes Array of additional attributes
  * @return string
  * @throws InvalidInstanceError
  */
  function select_milestone($name, $project = null, $selected = null, $attributes = null) {
    if(is_null($project)) $project = active_project();
    if(/*$project &&*/ !($project instanceof Project)) throw new InvalidInstanceError('$project', $project, 'Project');
    
    if(is_array($attributes)) {
      if(!isset($attributes['class'])) $attributes['class'] = 'select_milestone';
    } else {
      $attributes = array('class' => 'select_milestone');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    //if($project)
    	$milestones = $project->getOpenMilestones();
    /*else{
    	$projects=logged_user()->getActiveProjects();    	
    	foreach ($projects as $p)
    		$milestones[]=$p->getOpenMilestones();
    }  */  	
    if(is_array($milestones)) {
      foreach($milestones as $milestone) {
        $option_attributes = $milestone->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($milestone->getName(), $milestone->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_milestone
  
  /**
  * Render select task list box
  *
  * @param string $name Form control name
  * @param Project $project
  * @param integer $selected ID of selected object
  * @param boolean $open_only List only active task lists (skip completed)
  * @param array $attach_data Additional attributes
  * @return string
  */
  function select_task_list($name, $project = null, $selected = null, $open_only = false, $attributes = null) {
    if(is_null($project)) $project = active_project();
    if(!($project instanceof Project)) throw new InvalidInstanceError('$project', $project, 'Project');
    
    if(is_array($attributes)) {
      if(!isset($attributes['class'])) $attributes['class'] = 'select_task_list';
    } else {
      $attributes = array('class' => 'select_task_list');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    $task_lists = $open_only ? $project->getOpenTasks() : $project->getTasks();
    if(is_array($task_lists)) {
      foreach($task_lists as $task_list) {
        $option_attributes = $task_list->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($task_list->getTitle(), $task_list->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_task_list
  
  /**
  * Return select message control
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected message
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_message($name, $project = null, $selected = null, $attributes = null) {
    if(is_null($project)) $project = active_project();
    if(!($project instanceof Project)) throw new InvalidInstanceError('$project', $project, 'Project');
    
    if(is_array($attributes)) {
      if(!isset($attributes['class'])) $attributes['class'] = 'select_message';
    } else {
      $attributes = array('class' => 'select_message');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    $messages = $project->getMessages();
    if(is_array($messages)) {
      foreach($messages as $messages) {
        $option_attributes = $messages->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($messages->getTitle(), $messages->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_message
  
  /**
  * Render select folder box
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected folder
  * @param array $attributes Select box attributes
  * @return string
  */
  function select_project_folder($name, $project = null, $selected = null, $attributes = null) {
    if(is_null($project)) {
      $project = active_project();
    } // if
    if(!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    if(is_array($attributes)) {
      if(!isset($attributes['class'])) $attributes['class'] = 'select_folder';
    } else {
      $attributes = array('class' => 'select_folder');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    
    $folders = $project->getFolders();
    if(is_array($folders)) {
      foreach($folders as $folder) {
      	$option_attributes = $folder->getId() == $selected ? array('selected' => true) : null;
      	$options[] = option_tag($folder->getName(), $folder->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_project_folder
  
  /**
  * Select a project data object
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected object
  * @param array $exclude_files Array of IDs of objects that need to be excluded (already linked to object etc)
  * @param array $attributes
  * @return string
  */   
  function select_project_object($name, $project = null, $selected = null, $exclude_files = null, $attributes = null) {
  	// look for project
  	if(is_null($project)) {
      $project = active_project();
    } // if
    if(!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    // look for selection
    $sel_id = 0;
    $sel_type = '';
    if(is_array($selected))
    {
	    $sel_id = $selected['id'];
	    $sel_type = $selected['type'];    	
    }
  	//default non-value
  	$all_options = array(option_tag(lang('none'), 0)); // array of options
  	//milestones
    $milestones = $project->getOpenMilestones();
    if(is_array($milestones)) {
      $all_options[] = option_tag('', 0); // separator
      foreach($milestones as $milestone) {
        $option_attributes = $sel_type=='ProjectMilestone' && $milestone->getId() == $selected ? array('selected' => 'selected') : null;
        $all_options[] = option_tag('Milestone:: ' . $milestone->getName(), $milestone->getId() . '::' . 
        					get_class($milestone->manager()), $option_attributes);
      } // foreach
    } // if
  	//tasklists
  	$tasks = $project->getOpenTasks();
    if(is_array($tasks)) {
      $all_options[] = option_tag('', 0); // separator
      foreach($tasks as $task) {
        $option_attributes = $sel_type=='ProjectTask' && $task->getId() == $selected ? array('selected' => 'selected') : null;
        $all_options[] = option_tag('Task:: ' . $task->getTitle(), $task->getId() . '::' . 
        					get_class($task->manager()), $option_attributes);
      } // foreach
    } // if
  	//messages
  	$messages = $project->getMessages();
    if(is_array($messages)) {
      $all_options[] = option_tag('', 0); // separator
      foreach($messages as $message) {
        $option_attributes = $sel_type=='ProjectMessage' && $message->getId() == $sel_id ? array('selected' => 'selected') : null;
        $all_options[] = option_tag('Message:: ' . $message->getTitle(), $message->getId() . '::' . 
        					get_class($message->manager()), $option_attributes);
      } // foreach
    } // if
  	
  	//all files are orphans
  	$orphaned_files = $project->getOrphanedFiles();
    if(is_array($orphaned_files)) {
      $all_options[] = option_tag('', 0); // separator
      foreach($orphaned_files as $file) {
        if(is_array($exclude_files) && in_array($file->getId(), $exclude_files)) continue;
        
        $option_attrbutes = $sel_type=='ProjectFile' && $file->getId() == $selected ? array('selected' => true) : null;
        $all_options[] = option_tag('File:: ' . $file->getFilename(), $file->getId() . '::' . 
        					get_class($file->manager()), $option_attrbutes);
      } // foreach
    } // if
    
  	return select_box($name, $all_options, $attributes);
  }
  
  /**
  * Select a single project file
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected file
  * @param array $exclude_files Array of IDs of files that need to be excluded (already attached to object etc)
  * @param array $attributes
  * @return string
  */
  function select_project_file($name, $project = null, $selected = null, $exclude_files = null, $attributes = null) {
    if(is_null($project)) {
      $project = active_project();
    } // if
    if(!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    $all_options = array(option_tag(lang('none'), 0)); // array of options
    
    $folders = $project->getFolders();
    if(is_array($folders)) {
      foreach($folders as $folder) {
        $files = $folder->getFiles();
        if(is_array($files)) {
          $options = array();
          foreach($files as $file) {
            if(is_array($exclude_files) && in_array($file->getId(), $exclude_files)) continue;
            
            $option_attrbutes = $file->getId() == $selected ? array('selected' => true) : null;
            $options[] = option_tag($file->getFilename(), $file->getId(), $option_attrbutes);
          } // if
          
          if(count($options)) {
            $all_options[] = option_tag('', 0); // separator
            $all_options[] = option_group_tag($folder->getName(), $options);
          } // if
        } // if
      } // foreach
    } // if
    
    $orphaned_files = $project->getOrphanedFiles();
    if(is_array($orphaned_files)) {
      $all_options[] = option_tag('', 0); // separator
      foreach($orphaned_files as $file) {
        if(is_array($exclude_files) && in_array($file->getId(), $exclude_files)) continue;
        
        $option_attrbutes = $file->getId() == $selected ? array('selected' => true) : null;
        $all_options[] = option_tag($file->getFilename(), $file->getId(), $option_attrbutes);
      } // foreach
    } // if
    
    return select_box($name, $all_options, $attributes);
  } // select_project_file
  
  /**
  * Show project tags combo
  *
  * @param Project $project
  * @Param array $attributes Array of control attributes
  * @return string
  */
  function show_project_tags_option(Project $project, $comboName, $attributes) {
  	$options=array();
  	foreach ($project->getTagNames() as $tag) {
  		$tag=trim($tag);
  		if(strcmp($tag,""))
  		{//foreach tag
  			$options[] = option_tag($tag,$tag);
  		}  		
  	}
    return select_box($comboName,$options,$attributes);
  } 
  
  /**
   * Show button with javascript to add tag from combo to text box
   * $src source control name
   * $dest destination control name
   */
  function show_addtag_button($src,$dest, $attributes= null)
  {
  	$src='document.getElementById(\'' . $src .'\').value';
  	$dest='document.getElementById(\'' . $dest . '\').value';
  	$js='javascript:'.   		
  		'if(' . $dest . '==\'\') '.
  			' ' . $dest . ' = ' . $src . '; '. 
  		' else '.
  		// check whether the tag es included, if it is, do not add it
  		// if (dest.substring(1+ dest.lastIndexOf(",",dest.indexOf(src)), dest.indexOf(",",1+dest.lastIndexOf(",",dest.indexOf(src)))).trim().replace(/^\s+|\s+$/g, '') == src)
  			//'if (!((' . $dest . ' + \',\').substring(1+ ' . $dest . '.lastIndexOf(",",' . $dest . '.indexOf(' . $src . ')), ' . $dest . '.indexOf(",",1+' . $dest . '.lastIndexOf(",",' . $dest . '.indexOf(' . $src . ')))).replace(/^\s+|\s+$/g, \'\') == ' . $src . '))' .
  			' ' . $dest . ' = '.
  				' ' . $dest . '  + ", " +(' . $src . ')';
  	$attributes['type']= 'button';
  	$attributes['onclick'] = $js;
  	return input_field('addTagButton','>',$attributes);
  	
  }
  
  /**
  * Return project object tags widget
  *
  * @param string $name
  * @param Project $project
  * @param string $value
  * @Param array $attributes Array of control attributes
  * @return string
  */
  function project_object_tags_widget($name, Project $project, $value, $attributes) {
    return text_field($name, $value, $attributes) . '<br /><span class="desc">' . lang('tags widget description') . '</span>';
  } // project_object_tag_widget

  
  /**
  * Render comma separated tags of specific object that link on project tag page
  *
  * @param ProjectDataObject $object
  * @param Project $project
  * @return string
  */
  function project_object_tags(ApplicationDataObject $object, Project $project) {
    $tag_names = $object->getTagNames();
    if(!is_array($tag_names) || !count($tag_names)) return '--';
    
    $links = array();
    foreach($tag_names as $tag_name) {
    	$links[] = '<a href="#" onclick="Ext.getCmp(\'tag-panel\').select(\'' . clean($tag_name) . '\')">' . clean($tag_name) . '</a>';
	} // foreach
    return implode(', ', $links);
  } // project_object_tags
  
  /**
  * Show object comments block
  *
  * @param ProjectDataObject $object Show comments of this object
  * @return null
  */
  function render_object_comments(ProjectDataObject $object) {
    if(!$object->isCommentable()) return '';
    tpl_assign('__comments_object', $object);
    return tpl_fetch(get_template_path('object_comments', 'comment'));
  } // render_object_comments
  
  /**
  * Render post comment form for specific project object
  *
  * @param ProjectDataObject $object
  * @param string $redirect_to
  * @return string
  */
  function render_comment_form(ProjectDataObject $object) {
    $comment = new Comment();
    
    tpl_assign('comment_form_comment', $comment);
    tpl_assign('comment_form_object', $object);
    return tpl_fetch(get_template_path('post_comment_form', 'comment'));
  } // render_post_comment_form
  
  /**
  * This function will render the code for objects linking section of the form. Note that 
  * this need to be part of the existing form. It allows uploading of a new file to directly link to the object.
  *
  * @param string $prefix name prefix
  * @param integer $max_controls Max number of controls
  * @return string
  */
  function render_linked_objects($prefix = 'linked_objects', $max_controls = 5) {
    static $ids = array();
    static $js_included = false;
    
    $linked_objects_id = 0;
    do {
      $linked_objects_id++;
    } while(in_array($linked_objects_id, $ids));
    
    $old_js_included = $js_included;
    $js_included = true;
    
    tpl_assign('linked_objects_js_included', $old_js_included);
    tpl_assign('linked_objects_id', $linked_objects_id);
    tpl_assign('linked_objects_prefix', $prefix);
    tpl_assign('linked_objects_max_controls', (integer) $max_controls);
    return tpl_fetch(get_template_path('linked_objects', 'object'));
  } // render_linked_objects
  
  /**
  * List all fields attached to specific object
  *
  * @param ProjectDataObject $object
  * @param boolean $can_remove Logged user can remove linked objects
  * @return string
  */
  function render_object_links(ProjectDataObject $object, $can_remove = false, $shortDisplay = false, $enableAdding=true) {
    tpl_assign('linked_objects_object', $object);
    tpl_assign('shortDisplay', $shortDisplay);
    tpl_assign('enableAdding', $enableAdding);
    tpl_assign('linked_objects', $object->getLinkedObjects());
    return tpl_fetch(get_template_path('list_linked_objects', 'object'));
  } // render_object_links
  
  /**
   * Creates a button that shows an object picker to link the object given by $object with the one selected in 
   * the it.
   *
   * @param ProjectDataObject $object
   */
  function render_link_to_object($object, $text=null){
  		$id = $object->getId();
  		$manager = get_class($object->manager());
  		if($text==null)
  		$text=lang('link object');
  		$result = '';
  		$result .= '<a href="#">';
		$result .=  label_tag($text,null,false,
			array('onclick' => "og.ObjectPicker.show(function (data){ if(data) og.openLink('" . get_url('object','link_object') . 
			"&object_id=$id&manager=$manager&rel_object_id='+data[0].data.object_id + '&rel_manager=' + data[0].data.manager);})", 
			'id'=>'object_linker' , 'type' => 'button' ),'');
		$result .= '</a>';
		return $result;
  }
  
  function render_link_to_object_2($object, $text=null){
  		$id = $object->getId();
  		$manager = get_class($object->manager());
  		if($text==null)
  		$text=lang('link object');
  		$result = '';
  		$result .= '<a href="#" onclick="og.ObjectPicker.show(function (data){ if(data) og.openLink(\''
  		. get_url('object','link_object') . '&object_id=' . $id . '&manager=' . $manager . '&rel_object_id=\'+data[0].data.object_id + \'&rel_manager=\' + data[0].data.manager);})">';
		$result .=  $text;
		$result .= '</a>';
		return $result;
  }
  
  /**
  * Render application logs
  * 
  * This helper will render array of log entries. Options array of is array of template options and it can have this 
  * fields:
  * 
  * - show_project_column - When we are on project dashboard we don't actually need to display project column because 
  *   all entries are related with current project. That is not the situation on dashboard so we want to have the 
  *   control over this. This option is true by default
  *
  * @param array $log_entries
  * @return null
  */
  function render_application_logs($log_entries, $options = null) {
    tpl_assign('application_logs_entries', $log_entries);
    tpl_assign('application_logs_show_project_column', array_var($options, 'show_project_column', true));
    return tpl_fetch(get_template_path('render_application_logs', 'application'));
  } // render_application_logs
  
  /**
  * Render text that says when action was tacken and by who
  *
  * @param ApplicationLog $application_log_entry
  * @return string
  */
  function render_action_taken_on_by(ApplicationLog $application_log_entry) {
    if($application_log_entry->isToday()) { 
      $result = '<span class="desc">' . lang('today') . ' ' . clean(format_time($application_log_entry->getCreatedOn()));
    } elseif($application_log_entry->isYesterday()) { 
      //return '<span class="desc">' . lang('yesterday') . ' ' . clean(format_time($application_log_entry->getCreatedOn()));
      $result = '<span class="desc">' . lang('yesterday');
    } else { 
      $result = '<span class="desc">' . clean(format_date($application_log_entry->getCreatedOn()));
    } // if
    $result .= '</span>';
    
    $taken_by = $application_log_entry->getTakenBy();
    return $taken_by instanceof User ? $result . ', <a class="internalLink" href="' . $taken_by->getCardUrl() . '">' . clean($taken_by->getDisplayName()) . '</a>' : $result;
  } // render_action_taken_on
  
  /**
  * Render menu
  *
  * @param $menu_option
  * @return null
  */
  function render_menu($tags, $active_projects, $recent_files) {
    tpl_assign('tags', $tags);
	tpl_assign('active_projects', $active_projects);
	tpl_assign('recent_files', $recent_files);
    return tpl_fetch(get_template_path('render_menu', 'menu'));
  } // render_menu

	/**
	* Comma separated values from a set of options.
	*
	* @param string $name Control name
	* @param string $value Initial value
	* @param string $jsArray name of a JS array to get options from
	* @param array $attributes Other control attributes
	* @return string
	*/
	function autocomplete_textfield($name, $value, $jsArray, $attributes) {
		if (!$attributes) {
			$attributes = array();
		}
		$class = 'textfield' . ($attributes['class']?" ".$attributes['class']:"");
		unset($attributes['class']);
		$keypress = 'return og.autoComplete.keypress.call(this, event)';
		$keyup = 'og.autoComplete.keyup.call(this, event, ' . $jsArray . ')';
		$blur = 'og.autoComplete.blur.call(this)';
		$attrs = 'class="' . $class . '" name="' . $name . '" onkeypress="' . $keypress . '" onkeyup="' . $keyup . '" onblur="' . $blur . '"';
		foreach ($attributes as $k => $v) {
			$attrs .= ' ' . $k . '="' . $v . '"';
		}
		return '<textarea wrap="off" rows="1" ' . $attrs . '>' . $value . "</textarea>";
	}
	
	/**
	 * Auxiliar to render_object_properties
	 *
	 * @param string  $object_name
	 * @param int  $i 
	 */
	function aux_print_blank_row($object_name, $i){
		return "<tr style='background: " . (($i % 2) ? '#fff' : '#e8e8e8') . "'><td>" .
			         text_field($object_name . "[property$i][name]", '' ) . " </td> <td>" .
			         text_field($object_name . "[property$i][value]", '') . " </td> <td>" .
			         text_field($object_name . "[property$i][id]", '',array('type' => 'hidden')) ." </td> </tr>";
	}
	/**
	 * Renders the current object properties. If no properties
	 *
	 * @param ProjectDataObject $object
	 * @param string $object_name is the name of the array that will hold the [propertyX] fields
	 * @return unknown
	 */
	function render_object_properties( $object_name,ProjectDataObject $object=null){
		$output = "<table class='blank'> <tr> <th>".  lang('name') . ":</th><th>" . lang('value') . ":</th> </tr>";
		if($object)
			$properties = ObjectProperties::getAllPropertiesByObject($object);
		if($object && $properties){
			$i=0;
			foreach($properties as $property) {								
			    $output .= "<tr style='background: " . (($i % 2) ? '#fff' : '#e8e8e8') . "'><td>" .
			         text_field($object_name . "[property$i][name]", $property->getPropertyName()) . " </td> <td>" .
			         text_field($object_name . "[property$i][value]", $property->getPropertyValue()) . " </td> <td>" .
			         text_field($object_name . "[property$i][id]", $property->getId(),array('type' => 'hidden')) . " </td> </tr>";
			    $i++;
			} // for	
			$output .= aux_print_blank_row($object_name, $i);
		} // if
		else { //no object, print empty table
			for($i = 0; $i < 4; $i++) {	
			    $output .= aux_print_blank_row($object_name, $i);
			} // for			
		}
		$output.= "</table>  ";
		return $output;
	}
?>