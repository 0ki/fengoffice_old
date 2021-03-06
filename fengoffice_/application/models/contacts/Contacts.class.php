<?php

  /**
  * Contacts, generated on Sat, 25 Feb 2006 17:37:12 +0100 by 
  * DataObject generation tool
  *
  * @author Carlos Palma <chonwil@gmail.com>
  */
  class Contacts extends BaseContacts {
    
    /**
    * Return all Contacts
    *
    * @param void
    * @return array
    */
    function getAll() {
      return self::findAll();
    } // getAll
    
    /**
    * Return Contact object by email
    *
    * @param string $email
    * @return Contact
    */
    static function getByEmail($email) {
      $rows = self::find(array(
        'conditions' => "`email` = '". mysql_real_escape_string($email) 
      					."' OR `email2` = '" . mysql_real_escape_string($email) 
      					."' OR `email3` = '" . mysql_real_escape_string($email)."'" 
      )); // find
      if (count($rows) == 1)
      	return $rows[0];
      else
      	return null; //Doesnt return any contacts
    } // getByEmail
    
    /**
    * Return Contacts grouped by company
    *
    * @param void
    * @return array
    */
    static function getGroupedByCompany() {
      $companies = Companies::getAll();
      if(!is_array($companies) || !count($companies)) {
        return null;
      } // if
      
      $result = array();
      foreach($companies as $company) {
        $Contacts = $company->getContacts();
        if(is_array($Contacts) && count($Contacts)) {
          $result[$company->getName()] = array(
            'details' => $company,
            'Contacts' => $Contacts,
          ); // array
        } // if
      } // foreach
      
      return count($result) ? $result : null;
    } // getGroupedByCompany
        
    /**
     * Get contacts in a given project
     *
     * @param Project $project
     * @param array $arguments
     * @param integer $items_per_page
     * @param integer $current_page
     * @return array
     */
    function getByProject(Project $project, $arguments = null, $items_per_page = 10, $current_page = 1)
    {
    	if(!is_array($arguments)) $arguments = array();
      $conditions = array_var($arguments, 'conditions', '');
      $rolesTableName = ProjectContacts::instance()->getTableName(true);
      	  
      $pagination = new DataPagination($this->count($conditions), $items_per_page, $current_page);
      
      if (strlen($conditions) > 0)
          $conditions .= "`trashed_by_id` = 0 AND ".$this->getTableName(true).".id = $rolesTableName.contact_id";
      else
      	  $conditions = '`trashed_by_id` = 0 AND ' . $this->getTableName(true).".id = $rolesTableName.contact_id";
      $conditions .= " AND $rolesTableName.project_id = ".$project->getId();
      
      $offset = $pagination->getLimitStart();
      $limit = $pagination->getItemsPerPage();
      
      $sql = "SELECT ". $this->getTableName(true) .".* FROM " . $this->getTableName(true) . ", $rolesTableName" . 
      " WHERE $conditions ORDER BY UPPER(lastname) ASC, UPPER(firstname) ASC LIMIT $offset, $limit";
      
      // Run!
      $rows = DB::executeAll($sql);
      
      if(!is_array($rows) || (count($rows) < 1)) $items =  null;

      $objects = array();
      if (isset($rows))
      {
      	foreach($rows as $row) {
      		$object = $this->loadFromRow($row);
      		if(instance_of($object, $this->getItemClass())) $objects[] = $object;
      	} // foreach
      }
      $items = count($objects) ? $objects : null;
      $pagination->setTotalItems(count($objects));

      return array($items, $pagination);
    }
	
	/**
	 * Set user_id to 0 for all users that that previously were associated with a recently deleted user
	 *
	 */
	function updateUserIdOnUserDelete($user_id){
		if(!is_numeric($user_id))
			return false;
		$c = new Contact();
		$name = $c->getTableName(true);
		$sql = "UPDATE " . $name  . " SET user_id = 0 WHERE user_id = " .$user_id ;
		return DB::execute($sql);
	}
  } // Contacts 
  
?>