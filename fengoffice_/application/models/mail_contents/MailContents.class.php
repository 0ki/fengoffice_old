<?php

  /**
  * MailContents
  *
  * @author Carlos Palma <chonwil@gmail.com>
  */
  class MailContents extends BaseMailContents {
  	
  	    /**
    * Return mails that belong to specific project
    *
    * @param Project $project
    * @return array
    */
    static function getProjectMails(Project $project) {
       $conditions = array('`project_id` = ?', $project->getId());
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
    } // getProjectMails
  	
  } // MailContents 

?>