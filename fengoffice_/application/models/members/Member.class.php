<?php

/**
 * Member class
 *
 * @author Diego Castiglioni <diego20@gmail.com>
 */
class Member extends BaseMember {

	
	private $parent_member = null;
	
	private $skip_validations = array();
	
	private $icon_class = null;
	
	function getAllChildrenObjectTypeIds(){
		return DimensionObjectTypeHierarchies::getAllChildrenObjectTypeIds(
    		   $this->getDimensionId(), $this->getObjectTypeId());
	}
	
	function getAllChildrenSorted() {
		$all_children = array();
		
		$children = $this->getAllChildren();
		foreach ($children as $child) {
			$all_children[] = $child;
			$all_children = array_merge($all_children, $child->getAllChildrenSorted());
		}
		
		return $all_children;
	}
	
	function getAllChildren($recursive = false) {
		$child_members = array();
		$members = Members::findAll(array('conditions' => '`parent_member_id` = ' . $this->getId()));
		foreach ($members as $mem){
			$child_members[] = $mem;
			if ($recursive) {
				$children = $mem->getAllChildren($recursive);
				$child_members = array_merge($child_members, $children);
			}
		}
		
		return $child_members;
	}
	
	function getAllChildrenIds($recursive = false) {
		$result = array();
		//if recursive is false, only the first level of children will be returned
		$childs = $this->getAllChildren($recursive);
		foreach ($childs as $child) {
			$result[] = $child->getId();
		}
		return $result;
	}
	
	function getAllChildrenIdsByType($type_id) {
		$result = array();
		//all children in hierarchy
		$childs = $this->getAllChildren(true);
		foreach ($childs as $child) {
			if ($child->getObjectTypeId()== $type_id)
				$result[] = $child->getId();
		}
		return $result;
	}
	
	function getAllChildrenInHierarchy(){
		
		$members = array();		
		$children = $this->getAllChildren();
		foreach ($children as $child){
				$members[] = $child;
				$members = array_merge($child->getAllChildrenInHierarchy(),$members);
		}
		
		return $members;
	}

	/**
	 * Returns all the parent members that are in the same hierachic line, including itself if param is set to true
	 * @return array of Member
	 */
	function getAllParentMembersInHierarchy($include_itself = false){
		
		$child = $this;
		$members = array();		
		
		if ($include_itself){
			while($child != null){
				$members [] = $child;
				$child = $child->getParentMember();
			}
		}
		else{
			while ($child->getParentMember()!= null){
				$child = $child->getParentMember();
				$members [] = $child;
			}
		}
		return $members;
	}
	
	/**
	 * Returns the parent member or null if there isn't one
	 * @return Member
	 */
	function getParentMember() {
		if ($this->parent_member == null){
			if ($this->getParentMemberId() != 0) 
				 $this->parent_member = Members::findById($this->getParentMemberId());
		}
		return $this->parent_member;
	}
	
	
	function canBeReadByContact($permission_group_ids){
		return ContactMemberPermissions::ContactCanReadMember($permission_group_ids, $this->getId());
	}
	
	/**
	 * @return Dimension
	 * Returns the dimension associated to this member
	 */
	function getDimension() {
		return Dimensions::findById($this->getDimensionId());
	}
	
	
	function getDimensionRestrictedObjectTypeIds($restricted_dimension_id, $is_required = true){
		return DimensionMemberRestrictionDefinitions::getRestrictedObjectTypeIds($this->getDimensionId(), $this->getObjectTypeId(), $restricted_dimension_id, $is_required);
	}
	
	
	function satisfiesRestriction($member_id){
		$restriction_value = MemberRestrictions::findOne(array('conditions' => '`member_id` = ' . 
							 $member_id. ' AND `restricted_member_id` = '. $this->getId()));
		if ($restriction_value != null) return true;
		else return false;
	}
	
	function delete() {
		// change parent of child nodes
		$child_members = $this->getAllChildren();
		if (is_array($child_members)) {
			$parent = $this->getParentMember();
			foreach($child_members as $child) {
				$child->setParentMemberId($this->getParentMemberId());
				if ($parent instanceof Member) {
					$child->setDepth($parent->getDepth()+1);
				} else $child->setDepth(1);
				$child->save();
			}
		}
		
		// delete member restrictions
		MemberRestrictions::delete(array("`member_id` = ?", $this->getId()));
		MemberRestrictions::delete(array("`restricted_member_id` = ?", $this->getId()));
		
		// delete member properties
		MemberPropertyMembers::delete(array("`member_id` = ?", $this->getId()));
		MemberPropertyMembers::delete(array("`property_member_id` = ?", $this->getId()));
		
		// delete permissions
		ContactMemberPermissions::delete(array("member_id = ?", $this->getId()));
		
		// delete member objects (if they don't belong to another member)
		$sql = "SELECT `o`.`object_id` FROM `".ObjectMembers::instance()->getTableName()."` `o` WHERE `o`.`is_optimization`=0 AND `o`.`member_id`=".$this->getId()." AND NOT EXISTS (
			SELECT `om`.`object_id` FROM `".ObjectMembers::instance()->getTableName()."` `om` WHERE `om`.`object_id`=`o`.`object_id` AND `om`.`is_optimization`=0 AND `om`.`member_id`<>".$this->getId().")";
		$result = DB::execute($sql);
    	$rows = $result->fetchAll();
    	if (!is_null($rows)) {
	    	foreach ($rows as $row) {
	    		$obj = Objects::findById(array_var($row, 'object_id'));
	    		$obj->delete();
	    	}
    	}
		
		// delete object if member is a dimension_object
		if ($this->getObjectId()) {
			$object = Objects::findObject($this->getObjectId());
			$object->delete();
		}
		
		return parent::delete();
	}

	
	function canContainObject($object_type_id){
		$dotc = DimensionObjectTypeContents::findOne(array('conditions' => '`dimension_id` = '.$this->getDimensionId().' AND 
				`dimension_object_type_id` = '.$this->getObjectTypeId().' AND `content_object_type_id` = '.$object_type_id));
		if (!is_null($dotc)) return true;
		return false;
	}
	
	
	function canBeDeleted(&$error_message) {
		$childs = $this->getAllChildren();
		if (MemberPropertyMembers::isMemberAssociated($this->getId())){
			$error_message = "cannot delete member is associated";
			return false;
		}
		if (count($childs) == 0) {
			return true;
		} else {
			if ($this->getParentMemberId() > 0) 
				$child_ots = DimensionObjectTypeHierarchies::getAllChildrenObjectTypeIds($this->getDimensionId(), $this->getParentMember()->getObjectTypeId(), false);
			foreach ($childs as $child) {
				// check if child can be put in the parent (or root)
				if ($this->getParentMemberId() == 0) {
					$dim_ot = DimensionObjectTypes::findOne(array("conditions" => array("`dimension_id` = ? AND `object_type_id` = ?", $this->getDimensionId(), $child->getObjectTypeId())));
					if (!$dim_ot->getIsRoot()){
						$error_message = "cannot delete member cannot be root";
						return false;
					}
				} else {
					if (!in_array($child->getObjectTypeId(), $child_ots)){
						$error_message = "cannot delete member childs cannot be moved to parent";
						return false;
					}
				}
			}
			return $can;
		}
	}
	
	function validate(&$errors) {
		if (!array_var($this->skip_validations, 'presence of name')) {
			if (!$this->validatePresenceOf('name')) $errors[] = lang('name required');
		}
		if (!array_var($this->skip_validations, 'uniqueness of parent - name')) {
			if ($this->getParentMemberId() == 0) {
				if (!$this->validateUniquenessOf('name', 'dimension_id')) $errors[] = lang('member name already exists in dimension', $this->getName());
			} else {
				if (!$this->validateUniquenessOf('name', 'parent_member_id')) $errors[] = lang('member name already exists', $this->getName());
			}
		}
	}
	
	/*
	 * It would be nice to be able to add extra validations to the validator
	 */
	function add_skip_validation($validation) {
		if (!array_key_exists($validation, $this->skip_validations)) {
			$this->skip_validations[$validation] = true;
		}
	}
	/**
	 * @deprecated
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function getColor() {
		$ot = ObjectTypes::findById($this->getObjectTypeId());
		$color = null;
		if ($ot instanceof ObjectType) {
			$color = $ot->getColor();
		}
		if ($color == null) $color = 11;
		return $color;
	}
	
	/**
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function getIconClass() {
		if (!$this->icon_class) {
			$type = ObjectTypes::instance()->findById($this->getObjectTypeId());
			$this->icon_class = $type->getIconClass();
		}
		return $this->icon_class;
	}
	
	/**
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * Returns the memeber relations grouped by dimension  
	 */
	function getRelatedMembers() {
	
		$ids = $this->getAllChildrenIds(true);
		$ids[] = $this->getId();
		
		$sql = "SELECT DISTINCT
					d.id AS dimension_id,
					d.name AS dimension_name ,
					m.id AS member_id,
					m.name as member_name,
					m.parent_member_id as parent
				
				FROM 
					".TABLE_PREFIX."member_property_members p
				INNER JOIN  
					".TABLE_PREFIX."dimension_member_associations a ON a.id = p.association_id
				INNER JOIN  
					".TABLE_PREFIX."dimensions d  ON a.associated_dimension_id = d.id
				INNER JOIN  
					".TABLE_PREFIX."members m ON p.property_member_id = m.id
				WHERE p.member_id IN (".implode(",", $ids).") AND is_active = 1
				ORDER BY dimension_name, member_name";
				
		$rows = DB::executeAll($sql);
		$res = array();
		foreach ($rows as $row) {
			$res[$row['dimension_name']][] = $row ;		
		}
		return $res  ;
	}
	
	/**
	 * Returnrs true if members accepts child nodes, false otherwise
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 */
	function allowChilds() {
		return count(DimensionObjectTypes::getChildObjectTypes($this->getId()));
	}

	
	
}