<?php

  /**
  * ProjectWebpages, generated on Wed, 15 Mar 2006 22:57:46 +0100 by 
  * DataObject generation tool
  *
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class ProjectWebpages extends BaseProjectWebpages {
  
    /**
    * Return all webpages that are involved in specific project
    *
    * @access public
    * @param Project $project
    * @param string $additional_conditions
    * @return array
    */
    function getWebpagesByProject(Project $project, $additional_conditions = null) {
      ProjectWebpages::findAll(array('conditions' => '`project_id` = ' . $project->getId()));
    } 
    
    
  } // ProjectWebpages 

?>