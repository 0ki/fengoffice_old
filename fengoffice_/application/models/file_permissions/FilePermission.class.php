<?php

  /**
  * ProjectFile class
  * Written on Tue, 27 Oct 2007 16:53:08 -0300
  *
  * @author Marcos Saiz <marcos.saiz@opengoo.org>
  */
  class FilePermission extends BaseFilePermission {
    
    /**
    * File 
    *
    * @var FileType
    */
    private $file;    
    
    /**
    * User
    *
    * @var FileType
    */
    private $user;    
    
    /**
    * Return parent file object
    *
    * @param void
    * @return ProjectFile
    */
    function getFile() {
      if(is_null($this->file)) {
        $this->file = FilePermissions::findById($this->getFileId());
      } // if
      return $this->file;
    } // getFile
    
    /**
    * Return parent project
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if(is_null($this->project)) {
        $file = $this->getFile();
        if($file instanceof ProjectFile) $this->project = $file->getProject();
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
        $this->user = FilePermissions::findById($this->getUserId());
      } // if
      return $this->user;
    } // getUser
    
    /**
    * User can read file
    *
    * @param void
    * @return boolean
    */
    function readPermission() {
      $perm=$this->getPermission() ;
      return ($perm == 1) || ($perm == 2) ;
    } // getUser    
    
    /**
    * User can write file
    *
    * @param void
    * @return boolean
    */
    function writePermission() {
      $perm=$this->getPermission() ;
      return  ($perm == 2) ;
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
    
    
  } // FilePermissions

?>