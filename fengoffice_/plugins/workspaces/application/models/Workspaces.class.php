<?php

class Workspaces extends BaseWorkspaces {

	function __construct() {
		parent::__construct();
		$this->object_type_name = 'workspace';
	}
	

    function getPublicColumns() {
        $cols = array(
            array(
            	'col' => 'description', 
            	'type' => DATA_TYPE_STRING, 
            	'large' => true ),
            array(
            	'col' => 'show_description_in_overview',
            	'type' => DATA_TYPE_BOOLEAN, 
            ),
            array(
            	'col' => 'color',
            	'type' => 'WSCOLOR', 
            )
        );
       
        foreach ($cols as &$col) {
            $col['col_lang'] = lang("field ". self::instance()->object_type_name ." ". $col['col']);
        }
        return $cols;
    }
    

} 