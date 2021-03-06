<?php

	chdir(dirname(__FILE__));
	define("CONSOLE_MODE", true);
	define('PUBLIC_FOLDER', 'public');
	include "init.php";

	if (!logged_user()) {
		die("not logged in");
	}  
	function groupUpgrade(){
		echo "<li> INIT group Upgrade ".date("h:i:s") ;
		$otids = array(3,5,6,10,11,13,14,16,17,24,25,26,34);
		$i = 0 ;
		try {
			DB::beginWork();
			foreach ( PermissionGroups::instance()->findAll(array("conditions"=>"")) as $pg ){
				/* @var $pg PermissionGroup  */
				
				foreach ( Dimensions::instance()->findAll(array("conditions"=>"defines_permissions")) as $d ){
					/* @var $d Dimension   */
	
					if ( ContactDimensionPermissions::instance()->count(array("conditions" => "dimension_id = ".$d->getId(). " AND permission_type = 'allow all' ")) ) {
						
						foreach ($d->getAllMembers() as $m) {
							foreach ($otids as $tid){
								if( ! ContactMemberPermissions::instance()->count(array("conditions"=>
									"permission_group_id = ".$pg->getId() .
									" AND member_id=".$m->getId().
									" AND object_type_id = ".$tid
								))){
									//$i ++; echo " $i ";
									//echo " | ".$d->getId(). ",".$pg->getId() .",".$tid .",".$m->getId();
									$cmp = new ContactMemberPermission();
									$cmp->setMemberId($m->getId());
									$cmp->setPermissionGroupId($pg->getId());
									$cmp->setObjectTypeId($tid);
									$cmp->setCanWrite(1);
									$cmp->setCanDelete(1);
									$cmp->save();
									
								}							
							}
						}
					}
				}
			}
			DB::commit();
			
		}catch (Exception $e){
			DB::rollback();
		}
		
		echo "<li> END group Upgrade ". date("h:i:s") ;
		return true ;
	}
	
	function searchUpgrade() {
		echo "<li> INIT search Upgrade" ;
		
		$ctrl  = new ObjectController();
			
		foreach ( Objects::findAll() as $obj ){
			/* @var $obj Object */
			$instance = Objects::findObject($obj->getId());
			
			/* @var $instance ContentDataObject */
			if ($instance->isSearchable()){
				
				$instance->setObject($obj);
				$instance->addToSearchableObjects(1);
				$instance->addToSharingTable();
			}
		}
		
		
		echo "<li> END search Upgrade" ;
		return true;
	}

		
	
	echo "<h2>Feng 2 - Beta2 to Beta Data Upgrade</h2>";
	echo "<ol>";
	groupUpgrade()  or die("<li>Unable to make the Group Upgrade</ol>");
	searchUpgrade()  or die("</li>Unable to make the Search Upgrade<ol>");
	echo "</ol>";