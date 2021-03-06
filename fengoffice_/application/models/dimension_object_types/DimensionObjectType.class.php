<?php

/**
 * DimensionObjectType class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class DimensionObjectType extends BaseDimensionObjectType {
	
	function getOptions($decoded = false ) {
		$js = $this->getColumnValue("options");
		if ($decoded) {
			return json_decode ($js);
		}
		return $js ;
	}
	
	function getObjectType() {
		return ObjectTypes::instance()->findById($this->getObjectTypeId());
	}

}
