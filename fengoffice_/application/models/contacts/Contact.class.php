<?php

/**
 * Contact class
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class Contact extends BaseContact
{
	/**
    * This project object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
	private $user;
	
	private $company;
    
    /**
    * Construct contact object
    *
    * @param void
    * @return User
    */
    function __construct() {
      parent::__construct();
    } // __construct
    
    /**
    * Check if this contact is member of specific company
    *
    * @access public
    * @param Company $company
    * @return boolean
    */
    function isMemberOf(Company $company) {
      return $this->getCompanyId() == $company->getId();
    } // isMemberOf
    
    // ---------------------------------------------------
    //  IMs
    // ---------------------------------------------------
    
    /**
    * Return true if this contact have at least one IM address
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasImValue() {
      return ContactImValues::count('`contact_id` = ' . DB::escape($this->getId()));
    } // hasImValue
    
    /**
    * Return all IM values
    *
    * @access public
    * @param void
    * @return array
    */
    function getImValues() {
      return ContactImValues::getByContact($this);
    } // getImValues
    
    /**
    * Return value of specific IM. This function will return null if IM is not found
    *
    * @access public
    * @param ImType $im_type
    * @return string
    */
    function getImValue(ImType $im_type) {
      $im_value = ContactImValues::findById(array('contact_id' => $this->getId(), 'im_type_id' => $im_type->getId()));
      return $im_value instanceof ContactImValue && (trim($im_value->getValue()) <> '') ? $im_value->getValue() : null;
    } // getImValue
    
    /**
    * Return default IM value. If value was not found NULL is returned
    *
    * @access public
    * @param void
    * @return string
    */
    function getDefaultImValue() {
      $default_im_type = $this->getDefaultImType();
      return $this->getImValue($default_im_type);
    } // getDefaultImValue
    
    /**
    * Return default contact IM type. If there is no default contact IM type NULL is returned
    *
    * @access public
    * @param void
    * @return ImType
    */
    function getDefaultImType() {
      return ContactImValues::getDefaultContactImType($this);
    } // getDefaultImType
    
    /**
    * Clear all IM values
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearImValues() {
      return ContactImValues::instance()->clearByContact($this);
    } // clearImValues
    
    // ---------------------------------------------------
    //  Retrive
    // ---------------------------------------------------
    
    /**
    * Return owner company
    *
    * @access public
    * @param void
    * @return Company
    */
    function getCompany() {
    	if(is_null($this->company)) {
      		$this->company = Companies::findById($this->getCompanyId());
    	}
      	return $this->company;
    } // getCompany
    
    /**
    * Return assigned User
    *
    * @access public
    * @param void
    * @return User
    */
    function getUser() {
    	if(is_null($this->user)) {
        $this->user = Users::findById($this->getUserId());
      } // if
      return $this->user;
    } // getCompany
    
    /**
    * Return display name for this contact.
    *
    * @access public
    * @param void
    * @return string
    */
    function getDisplayName() {
      $display = parent::getFirstName()." ".parent::getLastName();
      return trim($display);
    } // getDisplayName
    
    /**
    * Return display name with last name first for this contact
    *
    * @access public
    * @param void
    * @return string
    */
    function getReverseDisplayName() {
        if(clean(parent::getLastName()) == '')
        	$display = parent::getFirstName();
        else
    		$display = parent::getLastName().", ".parent::getFirstName();
      return trim($display);
    } // getDisplayName
    
    /**
    * Returns true if we have title value set
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasTitle() {
      return trim($this->getTitle()) <> '';
    } // hasTitle

    /**
    * Returns true if contact has an assigned user
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasUser() {
    	return ($this->getUserId() > 0 && $this->getUser() instanceOf User);
    } // hasTitle
    
    /**
    * Returns true if contact has an assigned company
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasCompany() {
    	return ($this->getCompanyId() > 0 && $this->getCompany() instanceOf Company);
    } // hasTitle
    
    
    // ---------------------------------------------------
    //  Picture file
    // ---------------------------------------------------
    
    /**
    * Set contact picture from $source file
    *
    * @param string $source Source file
    * @param integer $max_width Max picture widht
    * @param integer $max_height Max picture height
    * @param boolean $save Save user object when done
    * @return string
    */
    function setPicture($source, $max_width = 50, $max_height = 50, $save = true) {
      if(!is_readable($source)) return false;
      
      do {
        $temp_file = ROOT . '/cache/' . sha1(uniqid(rand(), true));
      } while(is_file($temp_file));
      
      try {
        Env::useLibrary('simplegd');
        
        $image = new SimpleGdImage($source);
        $thumb = $image->scale($max_width, $max_height, SimpleGdImage::BOUNDARY_DECREASE_ONLY, false);
        $thumb->saveAs($temp_file, IMAGETYPE_PNG);
        
        $public_filename = PublicFiles::addFile($temp_file, 'png');
        if($public_filename) {
          $this->setPictureFile($public_filename);
          if($save) {
            $this->save();
          } // if
        } // if
        
        $result = true;
      } catch(Exception $e) {
        $result = false;
      } // try
      
      // Cleanup
      if(!$result && $public_filename) {
        PublicFiles::deleteFile($public_filename);
      } // if
      @unlink($temp_file);
      
      return $result;
    } // setPicture
    
    /**
    * Delete picture
    *
    * @param void
    * @return null
    */
    function deletePicture() {
      if($this->hasPicture()) {
        PublicFiles::deleteFile($this->getPictureFile());
        $this->setPictureFile('');
      } // if
    } // deletePicture
    
    /**
    * Return path to the picture file. This function just generates the path, does not check if file really exists
    *
    * @access public
    * @param void
    * @return string
    */
    function getPicturePath() {
      return PublicFiles::getFilePath($this->getPictureFile());
    } // getPicturePath
    
    /**
    * Return URL of picture
    *
    * @access public
    * @param void
    * @return string
    */
    function getPictureUrl() {
      return $this->hasPicture() ? PublicFiles::getFileUrl($this->getPictureFile()) : get_image_url('avatar.gif');
    } // getPictureUrl
    
    /**
    * Check if this user has uploaded picture
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasPicture() {
      return (trim($this->getPictureFile()) <> '') && is_file($this->getPicturePath());
    } // hasPicture
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * This function will generate new user password, set it and return it
    *
    * @param boolean $save Save object after the update
    * @return string
    */
    function resetPassword($save = true) {
      $new_password = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);
      $this->setPassword($new_password);
      if($save) {
        $this->save();
      } // if
      return $new_password;
    } // resetPassword
    
    /**
    * Set password value
    *
    * @param string $value
    * @return boolean
    */
    function setPassword($value) {
      do {
        $salt = substr(sha1(uniqid(rand(), true)), rand(0, 25), 13);
        $token = sha1($salt . $value);
      } while(Users::tokenExists($token));
      
      $this->setToken($token);
      $this->setSalt($salt);
      $this->setTwister(StringTwister::getTwister());
    } // setPassword
    
    /**
    * Return twisted token
    *
    * @param void
    * @return string
    */
    function getTwistedToken() {
      return StringTwister::twistHash($this->getToken(), $this->getTwister());
    } // getTwistedToken
    
    /**
    * Check if $check_password is valid user password
    *
    * @param string $check_password
    * @return boolean
    */
    function isValidPassword($check_password) {
      return  sha1($this->getSalt() . $check_password) == $this->getToken();
    } // isValidPassword
    
    /**
    * Check if $twisted_token is valid for this user account
    *
    * @param string $twisted_token
    * @return boolean
    */
    function isValidToken($twisted_token) {
      return StringTwister::untwistHash($twisted_token, $this->getTwister()) == $this->getToken();
    } // isValidToken
    

    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return view contact URL of this contact
    *
    * @access public
    * @param void
    * @return string
    */
    function getViewUrl() {
      return get_url('contact', 'index');
    } // getAccountUrl
    
    /**
    * Show contact card page
    *
    * @access public
    * @param void
    * @return null
    */
    function getCardUrl() {
      return get_url('contact', 'card', $this->getId());
    } // getCardUrl
    
    /**
    * Return edit contact URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('contact', 'edit', $this->getId());
    } // getEditUrl
    
    /**
    * Return add contact URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getAddUrl() {
      return get_url('contact', 'add');
    } // getEditUrl
    
    /**
    * Return delete contact URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('contact', 'delete', $this->getId());
    } // getDeleteUrl
    
    /**
    * Return update picture URL
    *
    * @param string
    * @return string
    */
    function getUpdatePictureUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if(trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('contact', 'edit_picture', $attributes);
    } // getUpdatePictureUrl
    
    /**
    * Return delete picture URL
    *
    * @param void
    * @return string
    */
    function getDeletePictureUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if(trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('contact', 'delete_picture', $attributes);
    } // getDeletePictureUrl
    
    /**
    * Return assign to project URL
    *
    * @param void
    * @return string
    */
    function getAssignToProjectUrl($redirect_to = null) {
      $attributes = array('id' => $this->getId());
      if(trim($redirect_to) <> '') {
        $attributes['redirect_to'] = str_replace('&amp;', '&', trim($redirect_to));
      } // if
      
      return get_url('contact', 'assign_to_project', $attributes);
    } // getDeletePictureUrl
    
    // ---------------------------------------------------
    //  System functions
    // ---------------------------------------------------
    
    /**
    * Validate data before save
    *
    * @access public
    * @param array $errors
    * @return void
    */
    function validate(&$errors) {
      
      // Validate username if present
      if(!$this->validatePresenceOf('lastname') && !$this->validatePresenceOf('firstname')) {
        $errors[] = lang('contact identifier required');
      } // if
      
    } // validate
    
    /**
    * Delete this object
    *
    * @param void
    * @return boolean
    */
    function delete() {
      if($this->getUserId()) {
        return false;
      } // if
      
      $this->deletePicture();
      return parent::delete();
    } // delete
    
    // ---------------------------------------------------
    //  ApplicationDataObject implementation
    // ---------------------------------------------------
    
    /**
    * Return object name
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->getDisplayName();
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('contact');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getCardUrl();
    } // getObjectUrl
	
	// ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    
    /**
    * Returns true if $user can access this contact
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if(!$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't access contacts
      } // if
      return true;
    } // canView
    
    /**
     * Check if specific user can add contacts to specific project
     *
     * @access public
     * @param User $user
     * @param Project $project
     * @return booelean
     */
    function canAdd(User $user) {
    	if(!$user->isMemberOfOwnerCompany()) {
    		return false; // user that is not member of owner company can't access contacts
    	} // if
    	return true;
    } // canAdd
    
    /**
    * Check if specific user can edit this contact
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
    	if(!$user->isMemberOfOwnerCompany()) {
    		return false; // user that is not member of owner company can't access contacts
    	} // if
    	return true;
    } // canEdit
    
    /**
    * Check if specific user can delete this contact
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
       if ($user->getId() == $this->getCreatedById() || $user->isAdministrator()) {
    	return true; //
       }
       return false;
    } // canDelete
    
	// ---------------------------------------------------
    //  Roles
    // ---------------------------------------------------
    
    /**
    * Return all roles for this contact
    *
    * @access public
    * @return array
    */
    function getRoles()
    {
    	return ProjectContacts::getRolesByContact($this);
    }
    
    /**
     * Return the role for this contact in a specific project
     *
     * @param Project $project
     * @return ProjectContact
     */
    function getRole(Project $project)
    {
    	return ProjectContacts::getRole($this,$project);
    }

	// ---------------------------------------------------
    //  Addresses
    // ---------------------------------------------------

    
    function getFullHomeAddress()
    {
    	$result = $this->getHAddress();
    	
    	if ($this->getHZipcode() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getHZipcode();
    	}
    	
    	if ($this->getHCity() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getHCity();
    	}
    	
    	if ($this->getHState() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getHState();
    	}
    	
    	if ($this->getHCountry() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getHCountry();
    	}
    	
    	return $result;
    }

    /**
     * Returns the full work address
     *
     * @return string
     */
    function getFullWorkAddress()
    {
    	$result = $this->getWAddress();
    	
    	if ($this->getWZipcode() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getWZipcode();
    	}
    	
    	if ($this->getWCity() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getWCity();
    	}
    	
    	if ($this->getWState() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getWState();
    	}
    	
    	if ($this->getWCountry() != '')
    	{
    		if ($result != '')
    			$result .= ', ';
    		$result .= $this->getWCountry();
    	}
    	
    	return $result;
    }
}
?>