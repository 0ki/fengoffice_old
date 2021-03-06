<?php

  /**
  * Companies, generated on Sat, 25 Feb 2006 17:37:12 +0100 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class Companies extends BaseCompanies {
    
    /**
    * Return all registered companies
    *
    * @param void
    * @return array
    */
    static function getAll() {
      return Companies::findAll(array(
        'order' => '`client_of_id`'
      )); // findAll
    } // getAll
    
    /**
    * Return all companies that have system users
    *
    * @param void
    * @return array
    */
    static function getCompaniesWithUsers() {
      $user_table =  Users::instance()->getTableName();
      $companies_table =  Companies::instance()->getTableName();
      return Companies::findAll(array(
        'conditions' => array(" exists (select id from $user_table where $user_table.`company_id` = $companies_table.`id` )"),
        'order' => '`client_of_id`'
      )); // findAll
    } // getCompaniesWithUsers
  
    /**
    * Return owner company
    *
    * @access public
    * @param void
    * @return Company
    */
    static function getOwnerCompany() {
      return Companies::findOne(array(
        'conditions' => array('`client_of_id` = ?', 0)
      )); // findOne
    } // getOwnerCompany
    
    /**
    * Return company clients
    *
    * @param Company $company
    * @return array
    */
    static function getCompanyClients(Company $company) {
      return Companies::findAll(array(
        'conditions' => array('`client_of_id` = ?', $company->getId()),
        'order' => '`name`'
      )); // array
    } // getCompanyClients
    
  } // Companies

?>