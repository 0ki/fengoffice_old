<?php

/**
 * Class that implements method common to all application objects (users, companies, projects etc)
 *
 * @version 1.0
 * @author Ilija Studen <ilija.studen@gmail.com>,  Marcos Saiz <marcos.saiz@opengoo.org>
 */
abstract class ApplicationDataObject extends DataObject {

	// ---------------------------------------------------
	//  Search
	// ---------------------------------------------------

	/**
	 * If this object is searchable search related methods will be unlocked for it. Else this methods will
	 * throw exceptions pointing that this object is not searchable
	 *
	 * @var boolean
	 */
	protected $is_searchable = false;

	/**
	 * Array of searchable columns
	 *
	 * @var array
	 */
	protected $searchable_columns = array();
	 
	/**
	 * Returns true if this object is searchable (maked as searchable and has searchable columns)
	 *
	 * @param void
	 * @return boolean
	 */
	function isSearchable() {
		return $this->is_searchable && is_array($this->searchable_columns) && (count($this->searchable_columns) > 0);
	} // isSearchable

	/**
	 * Returns array of searchable columns or NULL if this object is not searchable or there
	 * is no searchable columns
	 *
	 * @param void
	 * @return array
	 */
	function getSearchableColumns() {
		if(!$this->isSearchable()) return null;
		return $this->searchable_columns;
	} // getSearchableColumns

	/**
	 * This function will return content of specific searchable column. It can be overriden in child
	 * classes to implement extra behaviour (like reading file contents for project files)
	 *
	 * @param string $column_name Column name
	 * @return string
	 */
	function getSearchableColumnContent($column_name) {
		if(!$this->columnExists($column_name)) throw new Error("Object column '$column_name' does not exist");
		return (string) $this->getColumnValue($column_name);
	} // getSearchableColumnContent

	/**
	 * Clear search index that is associated with this object
	 *
	 * @param void
	 * @return boolean
	 */
	function clearSearchIndex() {
		return SearchableObjects::dropContentByObject($this);
	} // clearSearchIndex

	function addToSearchableObjects(){
		$columns_to_drop = array();
		if ($this->isNew())
		$columns_to_drop = $this->getSearchableColumns();
		else {
			foreach ($this->getSearchableColumns() as $column_name){
				if ($this->isColumnModified($column_name))
				$columns_to_drop[] = $column_name;
			}
		}
		 
		if (count($columns_to_drop) > 0){
			SearchableObjects::dropContentByObjectColumns($this,$columns_to_drop);

			foreach($columns_to_drop as $column_name) {
				$content = $this->getSearchableColumnContent($column_name);
				if(trim($content) <> '') {
					$searchable_object = new SearchableObject();
					 
					$searchable_object->setRelObjectManager(get_class($this->manager()));
					$searchable_object->setRelObjectId($this->getObjectId());
					$searchable_object->setColumnName($column_name);
					$searchable_object->setContent($content);
					$searchable_object->setProjectId(0);
					$searchable_object->setIsPrivate(false);
					 
					$searchable_object->save();
				} // if
			} // foreach
		} // if
		 
		//Add Unique ID to search
		if ($this->isNew()){
			$searchable_object = new SearchableObject();

			$searchable_object->setRelObjectManager(get_class($this->manager()));
			$searchable_object->setRelObjectId($this->getObjectId());
			$searchable_object->setColumnName('uid');
			$searchable_object->setContent($this->getUniqueObjectId());
			$searchable_object->setProjectId(0);
			$searchable_object->setIsPrivate(false);

			$searchable_object->save();
		}
	}

	function save() {
		$wasNew = $this->isNew();
		$result = parent::save();

		if ($result && $this->isSearchable()){
			$isNew = $this->isNew();
			$this->setNew($wasNew);
			$this->addToSearchableObjects();
			$this->setNew($isNew);
		}

		return $result;
	} // save
	 
	function delete(){
		if($this->isSearchable()) {
			$this->clearSearchIndex();
		} // if
		if($this->isLinkableObject()) {
			$this->clearLinkedObjects();
		} // if

		return parent::delete();
	}

	// ---------------------------------------------------
	//  Linked Objects (Replacement for attached files)
	// ---------------------------------------------------

	/**
	 * Mark this object as linkable to another object (in this case other project data objects can be linked to
	 * this object)
	 *
	 * @var boolean
	 */
	protected $is_linkable_object= true;

	/**
	 * Array of all linked objects
	 *
	 * @var array
	 */
	protected $all_linked_objects;

	/**
	 * Cached array of linked objects (filtered by users access permissions)
	 *
	 * @var array
	 */
	protected $linked_objects;

	/**
	 * Cached array of linked objects (filtered by users access permissions and excluding trashed objects)
	 *
	 * @var array
	 */
	protected $linked_objects_no_trashed;



	/**
	 * Cached author object reference
	 *
	 * @var User
	 */
	private $created_by = null;

	/**
	 * Cached reference to user who created last update on object
	 *
	 * @var User
	 */
	private $updated_by = null;


	/*
	 * Object type identifier
	 *
	 * ch - ProjectChart
	 * cm - Comment
	 * ct - Contact
	 * co - Company
	 * cp - Chart Parameter
	 * d - ProjectFile
	 * d - ProjectFileRevision
	 * ev - ProjectEvent
	 * fo - ProjectForm
	 * gp - Group
	 * me - ProjectMessage
	 * mc - Mail Content
	 * mi - ProjectMilestone
	 * ro - ProjectContact (Role)
	 * ta - ProjectTask
	 * tg - Tag
	 * ts - Timeslot
	 * us - User
	 * wp - WebPages
	 * ws - Project (Workspace)
	 */
	protected $objectTypeIdentifier = '';

	/**
	 * Return object ID
	 *
	 * @param void
	 * @return integer
	 */
	function getObjectId() {
		return $this->columnExists('id') ? $this->getId() : null;
	} // getObjectId

	/**
	 * Return object name
	 *
	 * @param void
	 * @return string
	 */
	function getObjectName() {
		return $this->columnExists('name') ? $this->getName() : null;
	} // getObjectName

	function getUniqueObjectId(){
		$oid = $this->getObjectId();
		if ($oid < 10)
			$oid = '00' . $oid;
		else if ($oid < 100)
			$oid = '0' . $oid;
		 
		return $this->objectTypeIdentifier . $oid;
	}

	/**
	 * Return object type name - message, user, project etc
	 *
	 * @param void
	 * @return string
	 */
	function getObjectTypeName() {
		return '';
	} // getObjectTypeName

	/**
	 * Return object URL
	 *
	 * @param void
	 * @return string
	 */
	function getObjectUrl() {
		return '#';
	} // getObjectUrl

	/**
	 * Return time when this object was created
	 *
	 * @param void
	 * @return DateTime
	 */
	function getObjectCreationTime() {
		return $this->columnExists('created_on') ? $this->getCreatedOn() : null;
	} // getObjectCreationTime

	/**
	 * Return time when this object was updated last time
	 *
	 * @param void
	 * @return DateTime
	 */
	function getObjectUpdateTime() {
		return $this->columnExists('updated_on') ? $this->getUpdatedOn() : $this->getObjectCreationTime();
	} // getOjectUpdateTime

	/**
	 * Return time when this object was updated last time
	 *
	 * @param void
	 * @return DateTime
	 */
	function getViewHistoryUrl() {
		return get_url('object','view_history',array('id'=> $this->getId(), 'manager'=> get_class($this->manager)));
	} // getViewHistoryUrl

	// ---------------------------------------------------
	//  Created by
	// ---------------------------------------------------

	/**
	 * Return user who created this message
	 *
	 * @access public
	 * @param void
	 * @return User
	 */
	function getCreatedBy() {
		if(is_null($this->created_by)) {
			if($this->columnExists('created_by_id')) $this->created_by = Users::findById($this->getCreatedById());
		} //
		return $this->created_by;
	} // getCreatedBy

	/**
	 * Return display name of author
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getCreatedByDisplayName() {
		$created_by = $this->getCreatedBy();
		return $created_by instanceof User ? $created_by->getDisplayName() : lang('n/a');
	} // getCreatedByDisplayName

	/**
	 * Return card URL of created by user
	 *
	 * @param void
	 * @return string
	 */
	function getCreatedByCardUrl() {
		$created_by = $this->getCreatedBy();
		return $created_by instanceof User ? $created_by->getCardUrl() : null;
	} // getCreatedByCardUrl

	// ---------------------------------------------------
	//  Updated by
	// ---------------------------------------------------

	/**
	 * Return user who updated this object
	 *
	 * @access public
	 * @param void
	 * @return User
	 */
	function getUpdatedBy() {
		if(is_null($this->updated_by)) {
			if($this->columnExists('updated_by_id')) $this->updated_by = Users::findById($this->getUpdatedById());
		} //
		return $this->updated_by;
	} // getCreatedBy

	/**
	 * Return display name of author
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getUpdatedByDisplayName() {
		$updated_by = $this->getUpdatedBy();
		return $updated_by instanceof User ? $updated_by->getDisplayName() : lang('n/a');
	} // getUpdatedByDisplayName

	/**
	 * Return card URL of created by user
	 *
	 * @param void
	 * @return string
	 */
	function getUpdatedByCardUrl() {
		$updated_by = $this->getUpdatedBy();
		return $updated_by instanceof User ? $updated_by->getCardUrl() : null;
	} // getUpdatedByCardUrl

	// ---------------------------------------------------
	//  Linked Objects
	// ---------------------------------------------------

	/**
	 * This function will return true if this object can have objects linked to it
	 *
	 * @param void
	 * @return boolean
	 */
	function isLinkableObject() {
		return $this->is_linkable_object;
	} // isLinkableObject

	/**
	 * Link object to this object
	 *
	 * @param ProjectDataObject $object
	 * @return LinkedObject
	 */
	function linkObject(ApplicationDataObject $object) {
		$manager_class = get_class($this->manager());
		$object_id = $this->getObjectId();

		$linked_object = LinkedObjects::findById(array(
        'rel_object_manager' => $manager_class,
        'rel_object_id' => $object_id,
        'object_id' => $object->getId(),
        'object_manager' => get_class($object->manager()),
		)); // findById

		if($linked_object instanceof LinkedObject) {
			return $linked_object; // Already linked
		}
		else
		{//check inverse link
			$linked_object = LinkedObjects::findById(array(
	        'rel_object_manager' => get_class($object->manager()),
	        'rel_object_id' => $object->getId(),
	        'object_id' => $object_id,
	        'object_manager' => $manager_class,
			)); // findById
			if($linked_object instanceof LinkedObject) {
				return $linked_object; // Already linked
			}
		} // if

		$linked_object = new LinkedObject();
		$linked_object->setRelObjectManager($manager_class);
		$linked_object->setRelObjectId($object_id);
		$linked_object->setObjectId($object->getId());
		$linked_object->setObjectManager(get_class($object->manager()));

		$linked_object->save();
		/*  if(!$object->getIsVisible()) {
		 $object->setIsVisible(true);
		 $object->setExpirationTime(EMPTY_DATETIME);
		 $object->save();
	  } // if*/
		return $linked_object;
	} // linkObject

	/**
	 * Return all linked objects
	 *
	 * @param void
	 * @return array
	 */
	function getAllLinkedObjects() {
		if(is_null($this->all_linked_objects)) {
			$this->all_linked_objects = LinkedObjects::getLinkedObjectsByObject($this);
		} // if
		return $this->all_linked_objects;
	} //  getAllLinkedObjects

	/**
	 * Return linked objects but filter the private ones if user is not a member
	 * of the owner company
	 *
	 * @param void
	 * @return array
	 */
	function getLinkedObjects() {
		if(logged_user()->isMemberOfOwnerCompany()) {
			$objects = $this->getAllLinkedObjects();
		} else {
			if (is_null($this->linked_objects)) {
				$this->linked_objects = LinkedObjects::getLinkedObjectsByObject($this, true);
			}
			$objects = $this->linked_objects;
		}
		if ($this instanceof ProjectDataObject && $this->isTrashed()) {
			$include_trashed = true;
		} else {
			$include_trashed = false;
		}
		if ($include_trashed) {
			return $objects;
		} else {
			$ret = array();
			if (is_array($objects) && count($objects)) {
				foreach ($objects as $o) {
					if (!$o instanceof ProjectDataObject || !$o->isTrashed()) {
						$ret[] = $o;
					}
				}
			}
			return $ret;
		}
	} // getLinkedObjects

	/**
	 * Drop all relations with linked objects for this object
	 *
	 * @param void
	 * @return null
	 */
	function clearLinkedObjects() {
		return LinkedObjects::clearRelationsByObject($this);
	} // clearLinkedObjects

	/**
	 * Return link objects url
	 *
	 * @param void
	 * @return string
	 */
	function getLinkObjectUrl() {
		return get_url('object', 'link_to_object', array(
        'manager' => get_class($this->manager()),
        'object_id' => $this->getObjectId()
		)); // get_url
	} // getLinkedObjectsUrl

	/**
	 * Return object properties url
	 *
	 * @param void
	 * @return string
	 */
	function getObjectPropertiesUrl() {
		return get_url('object', 'view_properties', array(
        'manager' => get_class($this->manager()),
        'object_id' => $this->getObjectId()
		)); // get_url
	} // getLinkedObjectsUrl

	/**
	 * Return unlink object URL
	 *
	 * @param ProjectDataObject $object
	 * @return string
	 */
	function getUnlinkObjectUrl(ApplicationDataObject $object) {
		return get_url('object', 'unlink_from_object', array(
        'manager' => get_class($this->manager()),
        'object_id' => $this->getObjectId(),
        'rel_object_id' => $object->getId(),
        'rel_object_manager' => get_class($object->manager()),
		)); // get_url
	} //  getUnlinkedObjectUrl


	/**
	 * Returns true if user can link an object to this object
	 *
	 * @param User $user
	 * @param Project $project
	 * @return boolean
	 */
	function canLinkObject(User $user) {
		if(!$this->isLinkableObject()) return false;
		return $this->canEdit($user);
	} // canLinkObject

	/**
	 * Check if $user can un-link $object from this object
	 *
	 * @param User $user
	 * @param ProjectDataObject $object
	 * @return booealn
	 */
	function canUnlinkObject(User $user, ApplicationDataObject $object) {
		return $this->canEdit($user);
	} // canUnlinkObject



	function getProject() {
		if (Env::isDebugging()) {
			//Logger::log("WARNING: Calling getProject() on an object with multiple workspaces.");
		}
		return null;
	}
	
	function copy() {
		$class = get_class($this);
		$copy = new $class();
		$cols = $this->getColumns();
		foreach ($cols as $col) {
			if ($col != 'id') {
				$copy->setColumnValue($col, $this->getColumnValue($col));
			}
		}
		return $copy;
	}

	function isTrashed() {
		return false;
	}


} // ApplicationDataObject

?>
