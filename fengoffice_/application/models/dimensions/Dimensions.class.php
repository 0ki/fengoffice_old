<?php

  /**
  * Dimensions
  *
  * @author Diego Castiglioni <diego20@gmail.com>
  */
  class Dimensions extends BaseDimensions {
    
    
  	static function getAssociatedDimensions($associated_dimension_id, $associated_object_type, $get_properties = true) {
  		
  		if ($get_properties) {
  			$dim_field = 'associated_dimension_id';
  			$ot_field = 'associated_object_type_id';
  			$res_dim_field = 'dimension_id';
  		} else {
  			$dim_field = 'dimension_id';
  			$ot_field = 'object_type_id';
  			$res_dim_field = 'associated_dimension_id';
  		}
  		
  		$search_condition = "`$dim_field` = $associated_dimension_id AND `$ot_field` = $associated_object_type";
  		$associations = DimensionMemberAssociations::findAll(array('conditions' => $search_condition));
  		// TODO: Hacerlo recursivo cuando get_properties = true
  		
  		$dimensions = array();
  		foreach ($associations as $assoc) {
  			$dimensions[] = Dimensions::findById($assoc->getColumnValue($res_dim_field));
  		}
  		return $dimensions;
  	}
  	


	/**
	 * 
	 * Returns list of Dimensions where objects with $content_object_type_id can be located
	 * @param $content_object_type_id
	 * @author Pepe
	 */
	static function getAllowedDimensions($content_object_type_id) {
		$sql = "
			SELECT
				dotc.dimension_id AS dimension_id,
				d.name as dimension_name,
				d.code as dimension_code,
				d.options as dimension_options,
				BIT_OR(dotc.is_required) AS is_required,
				BIT_OR(dotc.is_multiple) AS is_multiple,
				d.is_manageable AS is_manageable
			
			FROM 
				".TABLE_PREFIX."dimension_object_type_contents dotc
				INNER JOIN ".TABLE_PREFIX."dimensions d ON d.id = dotc.dimension_id
				INNER JOIN ".TABLE_PREFIX."object_types t ON t.id = dotc.dimension_object_type_id
			
			WHERE 
				content_object_type_id = $content_object_type_id
			GROUP BY dimension_id
			ORDER BY is_required DESC, dimension_name ASC
		
		";
		$dimensions = array();
		$res= DB::execute($sql);
		return $res->fetchAll();
	}
	
	/**
	 * @return Dimension
	 */
	static function findByCode($code) {
		return self::findOne(array('conditions' => array("`code` = ?", $code)));
	}

    
  } // Dimensions 
