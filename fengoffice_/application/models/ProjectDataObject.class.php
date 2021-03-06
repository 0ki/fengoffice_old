<?php

  /**
  * Abstract class that implements methods that share all project objects (tags manipulation, 
  * retriving data about object creator etc)
  * 
  * Project object is application object with few extra functions
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  abstract class ProjectDataObject extends ApplicationDataObject {
    
    /**
    * Cached parent project reference
    *
    * @var Project
    */
    protected $project = null;
    
    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * If true this object will not throw object not taggable exception and will make tag methods available
    *
    * @var boolean
    */
    protected $is_taggable = false;
    
    // ---------------------------------------------------
    //  Comments
    // ---------------------------------------------------
    
    /**
    * Set this property to true if you want to let users post comments on this objects
    *
    * @var boolean
    */
    protected $is_commentable = false;
    
    /**
    * Cached array of all comments
    *
    * @var array
    */
    protected $all_comments;
    
    /**
    * Cached array of comments
    *
    * @var array
    */
    protected $comments;
    
    /**
    * Number of all comments
    *
    * @var integer
    */
    protected $all_comments_count;
    
    /**
    * Number of comments. If user is not member of owner company private comments 
    * will be excluded from the count
    *
    * @var integer
    */
    protected $comments_count;
    
    
    
    /**
     * Whether the object can have properties
     *
     * @var bool
     */
    protected $is_property_container = true;

    /**
    * Return owner project. If project_id field does not exists NULL is returned
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if($this->isNew() && function_exists('active_project')) {
      	if(active_project())
        	return active_project();
        else 
        	return personal_project();
      } // if
      
      if(is_null($this->project)) {
        if($this->columnExists('project_id')) $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    /**
     * Returns the object's workspaces
     *
     * @return array
     */
    function getWorkspaces() {
    	if ($this->isNew()) {
    		return array(active_or_personal_project());
    	} else if ($this instanceof ProjectFile || $this instanceof ProjectMessage) {
    		return WorkspaceObjects::getWorkspacesByObject($this->getObjectManagerName(), $this->getObjectId());
    	} else {
    		$project = $this->getProject();
    		if ($project)
    			return array($project);
    		else
    			return null;
    	}
    }
    
    /**
     * Returns the object¡s workspaces names separated by a comma
     *
     * @return unknown
     */
  	function getWorkspacesNamesCSV() {
    	if ($this->isNew()) {
    		return active_or_personal_project()->getName();
    	} else {
    		//TODO Begin Remove for multiple workspaces
    		if ($this->getProject() instanceof Project)
    			return $this->getProject()->getName();
    		if ($this instanceof MailContent)
    			return '';
    		//End todo
    		$ws = WorkspaceObjects::getWorkspacesByObject($this->getObjectManagerName(), $this->getObjectId());
    		$names = array();
    		foreach ($ws as $w) {
    			$names[] = $w->getName();
    		}
    		return join(", ", $names);
    	}
    }
    
  	function getWorkspacesIdsCSV() {
    	if ($this->isNew()) {
    		return active_or_personal_project()->getId();
    	} else {
    		//TODO Begin Remove for multiple workspaces
    		if ($this->getProject() instanceof Project)
    			return $this->getProject()->getId();
    		if ($this instanceof MailContent)
    			return '';
    		//End todo
    		$ws = WorkspaceObjects::getWorkspacesByObject($this->getObjectManagerName(), $this->getObjectId());
    		$ids = array();
    		foreach ($ws as $w) {
    			$ids[] = $w->getId();
    		}
    		return join(", ", $ids);
    	}
    }
  
  	function getWorkspaceColorsCSV() {
    	if ($this->isNew()) {
    		return active_or_personal_project()->getColor();
    	} else {
    		//TODO Begin Remove for multiple workspaces
    		if ($this->getProject() instanceof Project)
    			return $this->getProject()->getColor();
    		if ($this instanceof MailContent)
    			return '';
    		//End todo
    		$ws = WorkspaceObjects::getWorkspacesByObject($this->getObjectManagerName(), $this->getObjectId());
    		$ids = array();
    		foreach ($ws as $w) {
    			$ids[] = $w->getColor();
    		}
    		return join(", ", $ids);
    	}
    }
    
    /**
     * Returns true if the object is in workspace $w.
     *
     * @param Project $w
     * @return boolean
     */
    function hasWorkspace($w) {
    	$object_manager = $this->getObjectManagerName();
    	$object_id = $this->getId();
    	$workspace_id = $w->getId(); 
    	$exists = WorkspaceObjects::findOne(array("conditions" => array("`workspace_id` = ? AND `object_manager` = ? AND `object_id` = ? ", $workspace_id, $object_manager, $object_id)));
    	return $exists != null;
    }
    
    /**
     * Adds the object to workspace $w.
     *
     * @param Project $w
     */
    function addToWorkspace($w) {
    	if (!$this->hasWorkspace($w)) {
    		$wo = new WorkspaceObject();
    		$wo->setObjectManager($this->getObjectManagerName());
    		$wo->setObjectId($this->getId());
    		$wo->setWorkspaceId($w->getId());
    		$wo->setCreatedById(logged_user()->getId());
    		$wo->setCreatedOn(DateTimeValueLib::now());
    		$wo->save();
    	}
    }
    
  	/**
  	 * Returns the object's manager's name.
  	 *
  	 * @return string
  	 */
  	function getObjectManagerName() {
  		return get_class($this->manager());
  	}
    
    /**
     * Removes the object from workspace $w.
     *
     * @param Project $w
     */
    function removeFromWorkspace($w) {
    	WorkspaceObjects::delete(array("`workspace_id` = ? AND `object_manager` = ? AND `object_id` = ?", $w->getId(), $this->getObjectManagerName(), $this->getId()));
    }
    
    /**
     * Remove from all workspaces.
     *
     */
    function removeFromAllWorkspaces() {
    	WorkspaceObjects::delete(array("`object_manager` = ? AND `object_id` = ?", $this->getObjectManagerName(), $this->getId()));
    }
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Can $user view this object
    *
    * @param User $user
    * @return boolean
    */
    abstract function canView(User $user);
    
    /**
    * Check if this user can add a new object to this project. This method is called staticly
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    abstract function canAdd(User $user, Project $project);
    
    /**
    * Returns true if this user can edit this object
    *
    * @param User $user
    * @return boolean
    */
    abstract function canEdit(User $user);
    
    /**
    * Returns true if this user can delete this object
    *
    * @param User $user
    * @return boolean
    */
    abstract function canDelete(User $user);
    
    /**
    * Check if specific user can comment on this object
    *
    * @param User $user
    * @return boolean
    * @throws InvalidInstanceError if $user is not instance of User or AnonymousUser
    */
    function canComment($user) {
      if(!($user instanceof User) && !($user instanceof AnonymousUser)) {
        throw new InvalidInstanceError('user', $user, 'User or AnonymousUser');
      } // if
      
      // Access permissions
      if($user instanceof User) {
        if($user->isAdministrator()) return true; // admins have all the permissions
        $project = $this->getProject();
        if(!($project instanceof Project)) return false;
        if(!$user->isProjectUser($project)) return false; // not a project member
      } // if
      
      if(!$this->isCommentable()) return false;
      if($this->columnExists('comments_enabled') && !$this->getCommentsEnabled()) return false;
      if($user instanceof AnonymousUser) {
        if($this->columnExists('anonymous_comments_enabled') && !$this->getAnonymousCommentsEnabled()) return false;
      } // if
      return true;
    } // canComment
    
    // ---------------------------------------------------
    //  Private
    // ---------------------------------------------------
    
    /**
    * Returns true if this object is private, false otherwise
    *
    * @param void
    * @return boolean
    */
    function isPrivate() {
      if($this->columnExists('is_private')) {
        return $this->getIsPrivate();
      } else {
        return false;
      } // if
    } // isPrivate
    
    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * Returns true if this project is taggable
    *
    * @param void
    * @return boolean
    */
    function isTaggable() {
      return $this->is_taggable;
    } // isTaggable
    
    /**
    * Return tags for this object
    *
    * @param void
    * @return array
    */
    function getTags() {
      if(!$this->isTaggable()) throw new Error('Object not taggable');
      return Tags::getTagsByObject($this, get_class($this->manager()));
    } // getTags
    
    /**
    * Return tag names for this object
    *
    * @access public
    * @param void
    * @return array
    */
    function getTagNames() {
      if(!$this->isTaggable()) 
      	throw new Error('Object not taggable');
      return Tags::getTagNamesByObject($this, get_class($this->manager()));
    } // getTagNames
    
    /**
    * Delete tag for this object
    *
    * @access public
    * @param void
    * @return array
    */
    function deleteTag( $tag) {
      if(!$this->isTaggable()) throw new Error('Object not taggable');
      return Tags::deleteObjectTag($tag, $this->getId(), get_class($this->manager()));
    } // deleteTag
    
    /**
    * Explode input string and set array of tags
    *
    * @param string $input
    * @return boolean
    */
    function setTagsFromCSV($input) {
      $tag_names = array();
      if(trim($input)) {
      	$tag_set = array();
        $tags = explode(',', $input);
        foreach($tags as $k => $v) {
        	$tag = trim($v);
          if($tag <> '' && array_var($tag_set, $tag) == null) {
          		$tag_names[] = $tag;
          		$tag_set[$tag] = true;
          }
        } // foreach
      } // if
      return $this->setTags($tag_names);
    } // setTagsFromCSV
    
    /**
    * Set object tags. This function accepts tags as params
    *
    * @access public
    * @param void
    * @return boolean
    */
    function setTags() {
      if(!$this->isTaggable()) 
      	throw new Error('Object not taggable');
      $args = array_flat(func_get_args());
      Tags::setObjectTags($args, $this, get_class($this->manager()), $this->getProject());
      if ($this->isSearchable())
	  	$this->addTagsToSearchableObject();
	  return true;
    } // setTags
    
    /**
    * Clear object tags
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearTags() {
      if(!$this->isTaggable()) throw new Error('Object not taggable');
      return Tags::clearObjectTags($this, get_class($this->manager()));
    } // clearTags
    
   
    // ---------------------------------------------------
    //  Commentable
    // ---------------------------------------------------
    
    /**
    * Returns true if users can post comments on this object
    *
    * @param void
    * @return boolean
    */
    function isCommentable() {
      return (boolean) $this->is_commentable;
    } // isCommentable
    
    /**
    * Attach comment to this object
    *
    * @param Comment $comment
    * @return Comment
    */
    function attachComment(Comment $comment) {
      $manager_class = get_class($this->manager());
      $object_id = $this->getObjectId();
      
      if(($object_id == $comment->getRelObjectId()) && ($manager_class == $comment->getRelObjectManager())) {
        return true;
      } // if
      
      $comment->setRelObjectId($object_id);
      $comment->setRelObjectManager($manager_class);
      
      $comment->save();
      return $comment;
    } // attachComment
    
    /**
    * Return all comments
    *
    * @param void
    * @return boolean
    */
    function getAllComments() {
      if(is_null($this->all_comments)) {
        $this->all_comments = Comments::getCommentsByObject($this);
      } // if
      return $this->all_comments;
    } // getAllComments
    
    /**
    * Return object comments, filter private comments if user is not member of owner company
    *
    * @param void
    * @return array
    */
    function getComments() {
      if(logged_user() && logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllComments();
      } // if
      if(is_null($this->comments)) {
        $this->comments = Comments::getCommentsByObject($this, true);
      } // if
      return $this->comments;
    } // getComments
    
    /**
    * This function will return number of all comments
    *
    * @param void
    * @return integer
    */
    function countAllComments() {
      if(is_null($this->all_comments_count)) {
        $this->all_comments_count = Comments::countCommentsByObject($this);
      } // if
      return $this->all_comments_count;
    } // countAllComments
    
    /**
    * Return total number of comments
    *
    * @param void
    * @return integer
    */
    function countComments() {
      if(logged_user()->isMemberOfOwnerCompany()) {
        return $this->countAllComments();
      } // if
      if(is_null($this->comments_count)) {
        $this->comments_count = Comments::countCommentsByObject($this, true);
      } // if
      return $this->comments_count;
    } // countComments
    
    /**
    * Return # of specific object
    *
    * @param Comment $comment
    * @return integer
    */
    function getCommentNum(Comment $comment) {
      $comments = $this->getComments();
      if(is_array($comments)) {
        $counter = 0;
        foreach($comments as $object_comment) {
          $counter++;
          if($comment->getId() == $object_comment->getId()) return $counter;
        } // foreach
      } // if
      return 0;
    } // getCommentNum
    
    /**
    * Returns true if this function has associated comments
    *
    * @param void
    * @return boolean
    */
    function hasComments() {
      return (boolean) $this->countComments();
    } // hasComments
    
    /**
    * Clear object comments
    *
    * @param void
    * @return boolean
    */
    function clearComments() {
      return Comments::dropCommentsByObject($this);
    } // clearComments
    
    /**
    * This event is triggered when we create a new comments
    *
    * @param Comment $comment
    * @return boolean
    */
    function onAddComment(Comment $comment) {
    	if ($this->isSearchable()){
	        $project = $this->getProject();
	        $searchable_object = new SearchableObject();
			            
			$searchable_object->setRelObjectManager(get_class($this->manager()));
			$searchable_object->setRelObjectId($this->getObjectId());
			$searchable_object->setColumnName('comment' . $comment->getId());
			$searchable_object->setContent($comment->getText());
			if($project instanceof Project) $searchable_object->setProjectId($project->getId());
			     $searchable_object->setIsPrivate($this->isPrivate());
			            
			$searchable_object->save();
    	}
		return true;
    } // onAddComment
    
    /**
    * This event is trigered when comment that belongs to this object is updated
    *
    * @param Comment $comment
    * @return boolean
    */
    function onEditComment(Comment $comment) {
    	if ($this->isSearchable()){
	        SearchableObjects::dropContentByObjectColumn($this,'comment' . $comment->getId());
	        $project = $this->getProject();
	        $searchable_object = new SearchableObject();
			            
			$searchable_object->setRelObjectManager(get_class($this->manager()));
			$searchable_object->setRelObjectId($this->getObjectId());
			$searchable_object->setColumnName('comment' . $comment->getId());
			$searchable_object->setContent($comment->getText());
			if($project instanceof Project) $searchable_object->setProjectId($project->getId());
			     $searchable_object->setIsPrivate($this->isPrivate());
			            
			$searchable_object->save();
    	}
		return true;
    } // onEditComment
    
    /**
    * This event is triggered when comment that belongs to this object is deleted
    *
    * @param Comment $comment
    * @return boolean
    */
    function onDeleteComment(Comment $comment) {
		if ($this->isSearchable())
			SearchableObjects::dropContentByObjectColumn($this,'comment' . $comment->getId());
    } // onDeleteComment
    
    /**
    * Per object comments lock. If there is no `comments_enabled` column this
    * function will return false
    *
    * @param void
    * @return boolean
    */
    function commentsEnabled() {
      return $this->columnExists('comments_enabled') ? (boolean) $this->getCommentsEnabled() : false;
    } // commentsEnabled
    
    /**
    * This function will return true if anonymous users can post comments on 
    * this object. If column `anonymous_comments_enabled` does not exists this 
    * function will return true
    *
    * @param void
    * @return boolean
    */
    function anonymousCommentsEnabled() {
      return $this->columnExists('anonymous_comments_enabled') ? (boolean) $this->getAnonymousCommentsEnabled() : false;
    } // anonymousCommentsEnabled
    
    // ---------------------------------------------------
    //  Object Properties
    // ---------------------------------------------------
    /**
     * Returns whether an object can have properties
     *
     * @return bool
     */
    function isPropertyContainer(){
    	return $this->is_property_container;
    }
    
    /**
     * Given the object_data object (i.e. file_data) this function
     * updates all ObjectProperties (deleting or creating them when necessary)
     *
     * @param  $object_data
     */
    function save_properties($object_data){
		$properties = array();
		for($i = 0; $i < 200; $i++) {
			if(isset($object_data["property$i"]) && is_array($object_data["property$i"]) &&
					(trim(array_var($object_data["property$i"], 'id')) <> '' || trim(array_var($object_data["property$i"], 'name')) <> '' ||
					trim(array_var($object_data["property$i"], 'value')) <> '')) {
            	$name = array_var($object_data["property$i"], 'name');
              	$id = array_var($object_data["property$i"], 'id');
              	$value = array_var($object_data["property$i"], 'value');
				if($id && trim($name)=='' && trim($value)=='' ){
					$property = ObjectProperties::findById($id);
					$property->delete( 'id = $id');
				}else{
					if($id){
						{
							SearchableObjects::dropContentByObjectColumn($this, 'property' . $id);
							$property = ObjectProperties::findById($id);
						}
					}else{
						$property = new ObjectProperty();
						$property->setRelObjectId($this->getId());
						$property->setRelObjectManager(get_class($this->manager()));
					}
					$property->setFromAttributes($object_data["property$i"]);
					$property->save();
					
					if ($this->isSearchable())
						$this->addPropertyToSearchableObject($property);
				}				
			} // if
			else break;
		} // for

    }
    
    
    // ---------------------------------------------------
    //  System
    // ---------------------------------------------------
    
    /**
    * Save object. If object is searchable this function will add conetent of searchable fields 
    * to search index
    *
    * @param void
    * @return boolean
    */
    function save() {
    	return parent::save();
    } // save
    
  	function addToSearchableObjects(){
  		$columns_to_drop = array();
    	if ($this->isNew())
    		$columns_to_drop = $this->getSearchableColumns();
    	else {
	    	foreach ($this->getSearchableColumns() as $column_name){
	    		if ($this->isColumnModified($column_name))
	    			$columns_to_drop[] = $column_name;
	    	}
    	}
    	
    	if (count($columns_to_drop) > 0){
    		SearchableObjects::dropContentByObjectColumns($this,$columns_to_drop);
    		
	        foreach($columns_to_drop as $column_name) {
	          $content = $this->getSearchableColumnContent($column_name);
	          if(trim($content) <> '') {
	            $searchable_object = new SearchableObject();
	            
	            $searchable_object->setRelObjectManager(get_class($this->manager()));
	            $searchable_object->setRelObjectId($this->getObjectId());
	            $searchable_object->setColumnName($column_name);
	            $searchable_object->setContent($content);
		        if($this->getProject() instanceof Project) 
		           	$searchable_object->setProjectId($this->getProject()->getId());
		        else
		           	$searchable_object->setProjectId(0);
	            $searchable_object->setIsPrivate(false);
	            
	            $searchable_object->save();
	          } // if
	        } // foreach
    	} // if
    }
    
    function addPropertyToSearchableObject(ObjectProperty $property){
    	$searchable_object = new SearchableObject();
	            
	    $searchable_object->setRelObjectManager(get_class($this->manager()));
	    $searchable_object->setRelObjectId($this->getObjectId());
	    $searchable_object->setColumnName('property'.$property->getId());
	    $searchable_object->setContent($property->getPropertyValue());
		if($this->getProject() instanceof Project) 
		   	$searchable_object->setProjectId($this->getProject()->getId());
		else
		   	$searchable_object->setProjectId(0);
	    $searchable_object->setIsPrivate(false);
	    
	    $searchable_object->save();
    }
    
    function addTagsToSearchableObject(){
    	$tag_names = $this->getTagNames();
    	
	    if (is_array($tag_names)){
			if (!$this->isNew())
    			SearchableObjects::dropContentByObjectColumn($this,'tags');
    		
	       	$searchable_object = new SearchableObject();
	           
	        $searchable_object->setRelObjectManager(get_class($this->manager()));
	        $searchable_object->setRelObjectId($this->getObjectId());
	        $searchable_object->setColumnName('tags');
	        $searchable_object->setContent(implode(' ', $tag_names));
	        if($this->getProject() instanceof Project) 
	           	$searchable_object->setProjectId($this->getProject()->getId());
	        else
	           	$searchable_object->setProjectId(0);
	        $searchable_object->setIsPrivate($this->isPrivate());
	            
	        $searchable_object->save();
	    }
    }
    
    function clearObjectProperties(){
    	ObjectProperties::deleteAllByObject($this);
    }
    /**
    * Delete object and drop content from search table
    *
    * @param void
    * @return boolean
    */
    function delete() {
      if($this->isTaggable()) {
        $this->clearTags();
      } // if
      if($this->isCommentable()) {
        $this->clearComments();
      } // if
      if($this->isLinkableObject()) {
        $this->clearLinkedObjects();
      } // if
      if($this->isPropertyContainer()){
      	$this->clearObjectProperties();
      }
      WorkspaceObjects::delete(array("`object_manager` = ? AND `object_id` = ?", $this->getObjectManagerName(), $this->getId()));
      return parent::delete();
    } // delete
    
  function getDashboardObject(){
    	if($this->getUpdatedById()){
    		$updated_by_id = $this->getUpdatedById();
    		$updated_by_name = $this->getUpdatedByDisplayName();
    		$updated_on=($this->getObjectUpdateTime())?$this->getObjectUpdateTime()->getTimestamp(): lang('n/a');
    	}else {
    		if($this->getCreatedById())
    			$updated_by_id = $this->getCreatedById();
    		else
    			$updated_by_id = lang('n/a');
    		$updated_by_name = $this->getCreatedByDisplayName();
    		$updated_on =($this->getObjectCreationTime())? $this->getObjectCreationTime()->getTimestamp(): lang('n/a');
    	}
    	
    	
    	
    	
    	return array(
				"id" => $this->getObjectTypeName() . $this->getId(),
				"object_id" => $this->getId(),
				"name" => $this->getObjectName(),
				"type" => $this->getObjectTypeName(),
				"tags" => project_object_tags($this),
				"createdBy" => $this->getCreatedByDisplayName(),// Users::findById($this->getCreatedBy())->getUsername(),
				"createdById" => $this->getCreatedById(),
				"dateCreated" => ($this->getObjectCreationTime())?$this->getObjectCreationTime()->getTimestamp():lang('n/a'),
				"updatedBy" => $updated_by_name,
				"updatedById" => $updated_by_id,
				"dateUpdated" => $updated_on,
				"project" => $this->getWorkspacesNamesCSV(),
				"projectId" => $this->getWorkspacesIdsCSV(),
    			"workspaceColors" => $this->getWorkspaceColorsCSV(),
				"url" => $this->getObjectUrl(),
				"manager" => get_class($this->manager())
			);
    }
    
  } // ProjectDataObject

?>