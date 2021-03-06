<?php

  /**
  * Base application controller
  *
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  abstract class ApplicationController extends PageController {
  
    /**
    * Add application level constroller
    *
    * @param void
    * @return null
    */
    function __construct() {
      parent::__construct();
      $this->addHelper('application');
    } // __construct
    
    /**
    * Set page sidebar
    *
    * @access public
    * @param string $template Path of sidebar template
    * @return null
    * @throws FileDnxError if $template file does not exists
    */
    protected function setSidebar($template) {
      tpl_assign('content_for_sidebar', tpl_fetch($template));
    } // setSidebar
    
    /**
    * Set help
    *
    * @access public
    * @param string $template Path of sidebar template
    * @return null
    * @throws FileDnxError if $template file does not exists
    */
    protected function setHelp($template) {
    	if (array_var($_GET, 'show_help') == 'true')
        	$content = array("type" => "html", "data" => tpl_fetch(Env::getTemplatePath($template, "help")));
        else
        	$content = array("type" => "urlonshow", "data" => get_url('help', $template));
        	
        ajx_extra_data(array('help_content' => $content));
    } // setHelp
  
  } // ApplicationController

?>