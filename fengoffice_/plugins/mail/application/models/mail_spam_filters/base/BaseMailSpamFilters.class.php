<?php
/**
 * BaseMailSpamFilters class
 * Generado el 9/2/2012
 * @author Andres Botta <andres@iugo.com.uy>
 */
abstract class BaseMailSpamFilters extends DataManager {

	/**
	 * Column name => Column type map
	 *
	 * @var array
	 * @static
	 */
	static private $columns = array(
		'id' => DATA_TYPE_INTEGER,
		'account_id' => DATA_TYPE_INTEGER,
		'text_type' => DATA_TYPE_BOOLEAN,
		'text' => DATA_TYPE_STRING,
		'spam_state' => DATA_TYPE_STRING
	);

	/**
	 * Construct
	 *
	 * @return BaseMailSpamFilters
	 */
	function __construct() {
		Hook::fire('object_definition', 'MailSpamFilter', self::$columns);
		parent::__construct('MailSpamFilter', 'mail_spam_filters', true);
	} // __construct

	// -------------------------------------------------------
	//  Description methods
	// -------------------------------------------------------

	/**
	 * Return array of object columns
	 *
	 * @access public
	 * @param void
	 * @return array
	 */
	function getColumns() {
		return array_keys(self::$columns);
	} // getColumns

	/**
	 * Return column type
	 *
	 * @access public
	 * @param string $column_name
	 * @return string
	 */
	function getColumnType($column_name) {
		if(isset(self::$columns[$column_name])) {
			return self::$columns[$column_name];
		} else {
			return DATA_TYPE_STRING;
		} // if
	} // getColumnType

	/**
	 * Return array of PK columns. If only one column is PK returns its name as string
	 *
	 * @access public
	 * @param void
	 * @return array or string
	 */
	function getPkColumns() {
		return 'id';
	} // getPkColumns

	/**
	 * Return name of first auto_incremenent column if it exists
	 *
	 * @access public
	 * @param void
	 * @return string
	 */
	function getAutoIncrementColumn() {
		return 'id';
	} // getAutoIncrementColumn

	// -------------------------------------------------------
	//  Finders
	// -------------------------------------------------------

	/**
	 * Do a SELECT query over database with specified arguments
	 *
	 * @access public
	 * @param array $arguments Array of query arguments. Fields:
	 *
	 *  - one - select first row
	 *  - conditions - additional conditions
	 *  - order - order by string
	 *  - offset - limit offset, valid only if limit is present
	 *  - limit
	 *
	 * @return one or MailAccounts objects
	 * @throws DBQueryError
	 */
	function find($arguments = null) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::find($arguments);
		} else {
			return MailSpamFilters::instance()->find($arguments);
			//$instance =& MailAccounts::instance();
			//return $instance->find($arguments);
		} // if
	} // find

	/**
	 * Find all records
	 *
	 * @access public
	 * @param array $arguments
	 * @return one or MailAccounts objects
	 */
	function findAll($arguments = null) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::findAll($arguments);
		} else {
			return MailSpamFilters::instance()->findAll($arguments);
			//$instance =& MailAccounts::instance();
			//return $instance->findAll($arguments);
		} // if
	} // findAll

	/**
	 * Find one specific record
	 *
	 * @access public
	 * @param array $arguments
	 * @return MailAccount
	 */
	function findOne($arguments = null) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::findOne($arguments);
		} else {
			return MailSpamFilters::instance()->findOne($arguments);
			//$instance =& MailAccounts::instance();
			//return $instance->findOne($arguments);
		} // if
	} // findOne

	/**
	 * Return object by its PK value
	 *
	 * @access public
	 * @param mixed $id
	 * @param boolean $force_reload If true cache will be skipped and data will be loaded from database
	 * @return MailAccount
	 */
	function findById($id, $force_reload = false) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::findById($id, $force_reload);
		} else {
			return MailSpamFilters::instance()->findById($id, $force_reload);
			//$instance =& MailAccounts::instance();
			//return $instance->findById($id, $force_reload);
		} // if
	} // findById

	/**
	 * Return number of rows in this table
	 *
	 * @access public
	 * @param string $conditions Query conditions
	 * @return integer
	 */
	function count($condition = null) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::count($condition);
		} else {
			return MailSpamFilters::instance()->count($condition);
			//$instance =& MailAccounts::instance();
			//return $instance->count($condition);
		} // if
	} // count

	/**
	 * Delete rows that match specific conditions. If $conditions is NULL all rows from table will be deleted
	 *
	 * @access public
	 * @param string $conditions Query conditions
	 * @return boolean
	 */
	function delete($condition = null) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::delete($condition);
		} else {
			return MailSpamFilters::instance()->delete($condition);
			//$instance =& MailAccounts::instance();
			//return $instance->delete($condition);
		} // if
	} // delete

	/**
	 * This function will return paginated result. Result is an array where first element is
	 * array of returned object and second populated pagination object that can be used for
	 * obtaining and rendering pagination data using various helpers.
	 *
	 * Items and pagination array vars are indexed with 0 for items and 1 for pagination
	 * because you can't use associative indexing with list() construct
	 *
	 * @access public
	 * @param array $arguments Query argumens (@see find()) Limit and offset are ignored!
	 * @param integer $items_per_page Number of items per page
	 * @param integer $current_page Current page number
	 * @return array
	 */
	function paginate($arguments = null, $items_per_page = 10, $current_page = 1) {
		if(isset($this) && instance_of($this, 'MailSpamFilters')) {
			return parent::paginate($arguments, $items_per_page, $current_page);
		} else {
			return MailSpamFilters::instance()->paginate($arguments, $items_per_page, $current_page);
			//$instance =& MailAccounts::instance();
			//return $instance->paginate($arguments, $items_per_page, $current_page);
		} // if
	} // paginate

	/**
	 * Return manager instance
	 *
	 * @return MailSpamFilters
	 */
	function instance() {
		static $instance;
		if(!instance_of($instance, 'MailSpamFilters')) {
			$instance = new MailSpamFilters();
		} 
		return $instance;
	}

} 