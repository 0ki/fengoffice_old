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
		$condstr = self::getWorkspaceString();
		return self::findAll(array(
			'conditions' => array($condstr, $project->getId())
		));
    } // getProjectMails
  	
	private static function getWorkspaceString(){
		return '`id` IN (SELECT `object_id` FROM `'.TABLE_PREFIX.'workspace_objects` WHERE `object_manager` = \'MailContents\' AND `workspace_id` = ?)';
	}
    
  } // MailContents 

?>