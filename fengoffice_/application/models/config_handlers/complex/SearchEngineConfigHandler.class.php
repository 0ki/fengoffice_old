<?php

  /**
  * Select search engine
  *
  * @version 1.0
  * @author Ignacio de Soto <ignacio.desoto@opengoo.org>
  */
  class SearchEngineConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();
      
      $option_attributes = $this->getValue() == 'like' ? array('selected' => 'selected') : null;
      $options[] = option_tag('MySQL LIKE (beta)', 'like', $option_attributes);
      
      $option_attributes = $this->getValue() == 'match' ? array('selected' => 'selected') : null;
      $options[] = option_tag('MySQL MATCH', 'match', $option_attributes);
      
      return select_box($control_name, $options);
    } // render
  
  } // SearchEngineConfigHandler

?>