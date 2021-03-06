<?php

  /**
  * ObjectUserPermission class
  * Written on Tue, 27 Oct 2007 16:53:08 -0300
  *
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  class ObjectUserPermission extends BaseObjectUserPermission {
    
    /**
    * Object 
    *
    * @var ObjectType
    */
    private $object;    
    
    /**
    * User
    *
    * @var ObjectType
    */
    private $user;    
    
    /**
    * Return parent object object
    *
    * @param void
    * @return ProjectObject
    */
    function getObject() {
      if(is_null($this->object)) {
        $this->object = ObjectUserPermissions::findById($this->getObjectId());
      } // if
      return $this->object;
    } // getObject
    
    /**
    * Return parent project
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if(is_null($this->project)) {
        $object = $this->getObject();
        if($object instanceof ProjectDataObject) $this->project = $object->getProject();
      } // if
      return $this->project;
    } // getProject
    
    /**
    * Return parent user
    *
    * @param void
    * @return User
    */
    function getUser() {
      if(is_null($this->user)) {
        $this->user = Users::findById($this->getUserId());
      } // if
      return $this->user;
    } // getUser
    
    /**
    * User can read object
    *
    * @param void
    * @return boolean
    */
    function readPermission() {
      $perm=$this->getPermission() ;
      return ($perm == 1) || ($perm == 2) ;
    } // getUser    
    
    /**
    * User can write object
    *
    * @param void
    * @return boolean
    */
    function writePermission() {
      $perm=$this->getPermission() ;
      return  ($perm == 2) ;
    } // getUser
    
    /**
    * User cannot access the object
    *
    * @param void
    * @return boolean
    */
    function cannotAccess() {
      $perm=$this->getPermission() ;
      return  ($perm == 0) ;
    } // getUser

        /**
    * Can $user view this object
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user)
    {
    	return $user->isProjectUser($this->getProject()) ;
    }
    /**
    * Check if this user can add a new object to this project. This method is called staticly
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project)
    {
    	return canView($user);
    }
    
    /**
    * Returns true if this user can edit this object
    *
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user)
    {
    	return canView($user);
    }
    
    /**
    * Returns true if this user can delete this object
    *
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user)
    {
    	return canView($user);
    }
    /**
    * Construct the object
    *
    * @param void
    * @return null
    */
    function __construct() {
      parent::__construct();
    } // __construct
    
    
  } // ObjectUserPermissions

?>