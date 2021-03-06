<?php

/**
 * PermissionContext class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class PermissionContext extends BasePermissionContext {
	
	function getMember(){
		return Members::findById($this->getMemberId());
	}
	
} // PermissionContext

?>