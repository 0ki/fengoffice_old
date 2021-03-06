<?php
abstract class DimensionObject extends ContentDataObject {
	
	
	public function getPath( $asString = true ) {
		$member = Members::findOneByObjectId($this->getId());
		$parents = array();
		foreach ( $member->getAllParentMembersInHierarchy(false) as $parent ){
			$parents[] = $parent->getName();
		}
		$parents = array_reverse($parents);
		
		
		if ($asString) {
			if(count($parents)) {
				return "(".implode(" | ", $parents).")";
			}else{
				return "";
			}
		}else{
			return $parents ;
		}	
	}
	
	
	
	
}