<?php
class SearchController extends ApplicationController {
	
	/**
	 * @var boolean
	 */
	var $showQueryTime = false ;
	
	
	/**
	 * Search string
	 * @var unknown_type
	 */
	var $search_for ;
	
	/**
	 * Page size
	 * @var unknown_type
	 */
	var $limit = 10;
	
	/**
	 * Start integer
	 * @var unknown_type
	 */
	var $start = 0 ;
	
	/**
	 * Real limit  SQL satatement.
	 * We dont make a 'count' on SQL. 
	 * This will help to guess to total results, o at least, if render the 'next' button  
	 * Should be Greater than limit, because of PHP result filters
	 * @var int
	 */
	var $limitTest = 30 ;
	 
	/**
	 * Max content size to show on results view
	 * @var unknown_type
	 */
	var $contentSize = 200;
	
	/**
	 * If true search for prefixes, giving more results.
	 * @var boolean
	 */
	var $wildcardSeach = true ;
	
	/**
	 * Max title size to show on results view
	 * @var integer
	 */
	var $titleSize = 100;
	
	/**
	 * True to filter duplicated results in PHP
	 * This may cause errors on "total" pagination
	 * @var boolean
	 */
	var $filterDuplicate = true ;
	
	/**
	 * Max number of links to show on pagination
	 * @var unknown_type
	 */
	var $maxPageLinks = 5 ;
	
	/**
	 * @var StdClass
	 */
	var $pagination = null  ;
	
	function __construct() {
		$this->pagination = new StdClass();
		parent::__construct();
		prepare_company_website_controller($this, 'website');
		ajx_set_panel("search");
		
	} // __construct
	
	
	/**
	 * Execute search
	 * TODO: Performance gus: 
	 * Fetch only ids and execute a select statement by pk (fer each result)
	 * @param void
	 * @return null
	 */
	function search() {
		// Init vars
		$search_for = array_var($_GET, 'search_for');
		$search_pieces= explode(" ", $search_for);
		$search_string = "";
		foreach ($search_pieces as $word ) {
			$search_string.= mysql_escape_string($word);
			if ($this->wildcardSeach) {
				$search_string.="*";
			}
			$search_string.=" ";
		}
		$search_string = substr($search_string, 0 , -1);
		
		$this->search_for = $search_for ;
		$limit = $this->limit;
		$start = array_var($_REQUEST, 'start' , $this->start) ;
		$this->start = $start ;
		$limitTest = max( $this->limitTest , $this->limit);
		$filteredResults = 0 ;
		$uid = logged_user()->getId();
		
		
		// Build main SQL
		$sql = "	
			SELECT  distinct(so.rel_object_id) AS id
			FROM ".TABLE_PREFIX."searchable_objects so
			INNER JOIN  ".TABLE_PREFIX."objects o ON o.id = so.rel_object_id 
			WHERE
				so.rel_object_id IN (
			    SELECT object_id FROM ".TABLE_PREFIX."sharing_table WHERE group_id  IN (
			      SELECT permission_group_id FROM ".TABLE_PREFIX."contact_permission_groups WHERE contact_id = $uid
			    )
			 )
			AND MATCH (so.content) AGAINST ('$search_string' IN BOOLEAN MODE)
			ORDER by o.updated_on DESC
			LIMIT $start, $limitTest ";
		//
		$db_search_results = array();
		$timeBegin = time();
		$res = DB::execute($sql);
		$timeEnd = time();
		while ($row = $res->fetchRow() ) {
			$search_results_ids[] = $row['id'] ;
		}
		// Prepare results for view to avoid processing at presentation layer 
		$search_results = $this->prepareResults($search_results_ids, $null, $limit);
		
		// Calculate or approximate total for pagination
		$total = count($search_results_ids) + $start ;
		
		if ( count ( $search_results_ids ) < $limitTest ) {
			$total = count($search_results_ids) + $start ;
		}else{
			$total = "Many" ;
		}
		//$total -= $filteredResults ;
		$this->total = $total ;
		
		// Pagination
		$this->buildPagination($search_results);
		
		// Extra data
		$extra = new stdClass() ;
		if ($this->showQueryTime) {
			$extra->time = $timeEnd-$timeBegin ;
		}
		//$extra->filteredResults = $filteredResults ;
		
		// Template asigns
		tpl_assign('pagination', $this->pagination);
		tpl_assign('search_string', $search_for);
		tpl_assign('search_results', $search_results);
		tpl_assign('extra', $extra );

		//Ajax 
		if (!$total){
			$this->setTemplate('no_results');
		}
		ajx_set_no_toolbar(true);
		
	}
	
	/**
	 * Build pagination based on $total, $limit and $search_results
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param unknown_type $search_results
	 */
	private function buildPagination($search_results) {
		$start = $this->start;
		$limit = $this->limit;
		$total = $this->total;
		$search_for = $this->search_for ;
		$this->pagination = new StdClass() ;
		$this->pagination->currentPage = ceil (( $start+1 ) / $limit)  ;
		$this->pagination->currentStart = $start+1 ;
		$this->pagination->currentEnd = $start + count($search_results) ;
		$this->pagination->hasNext = ( count($search_results) == $limit ) ;
		$this->pagination->hasPreviews = ($start-$limit >= 0); 
		$this->pagination->nextUrl = get_url("search", "search" , array("start" => $start+$limit , "search_for"=>$search_for));
		$this->pagination->previewsUrl = get_url("search", "search" , array("start" => $start-$limit , "search_for"=>$search_for));
		$this->pagination->total = $total ;
		$this->pagination->nextPages = array();
		$this->pagination->links = $this->buildPaginationLinks();			
	}
	
	
	
	/**
	 * Map parameters and make some grouping, orders limits not done in DB
	 * 
	 * 
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param unknown_type array of int 
	 * @param unknown_type $filtered_results
	 * @param unknown_type $total
	 */
	private function prepareResults($ids, &$filtered_results, $limit) {
		$return = array();
		foreach ($ids as $search_result_id) {
			$search_results = array();
			if (!$limit) break;
			if (!is_numeric($search_result_id)) continue;
			
			$obj = Objects::findObject($search_result_id);
			/* @var $obj ContentDataObject */
			
			/*$search_result = DB::executeOne("		
				SELECT  o.id AS id, 
						o.name,  
						o.created_on as created_on,
						c.object_id as created_by_id, 
						c.username AS created_by_name, 
						t.name as type, 
						t.handler_class as handler
	
				FROM ".TABLE_PREFIX."objects o  
				LEFT JOIN ".TABLE_PREFIX."object_types t on o.object_type_id = t.id
				LEFT JOIN ".TABLE_PREFIX."contacts c ON c.object_id = o.created_by_id
				
				WHERE
					o.id =  $search_result_id");*/
			
			$search_result['title'] = $this->prepareTitle($obj->getObjectName());
			$search_result['url'] = $obj->getViewUrl();
			$search_result['created_by'] = $this->prepareCreatedBy($obj->getCreatedByDisplayName(), $obj->getCreatedById()) ;
			$search_result['updated_by'] = $this->prepareCreatedBy($obj->getUpdatedByDisplayName(), $obj->getUpdatedById()) ;
			$search_result['type'] = $obj->getObjectTypeName() ;
			$search_result['created_on'] = friendly_date($obj->getCreatedOn()) ;
			$search_result['updated_on'] = friendly_date($obj->getUpdatedOn()) ;
			$search_result['content'] = $this->highlightResult($obj->getSummary(array(
				"size" => $this->contentSize,
				"near" => $this->search_for  
			)));

			//$search_result['url'] = $this->prepareUrl($search_result['id'], $search_result['handler']);
			

			
			$return[] = $search_result;
			$limit--;
		}
		return $return  ;
		
	} 	
		
	private function prepareCreatedBy($name,$id){
		return "<a href='".get_url('contact', 'card', array('id'=>$id))."'>".$name."</a>";
	}
	
	private function prepareContent($content) {
		return $this->highlightResult($this->cutResult($content, $this->contentSize));
	}

	private function prepareUrl($id, $handler) {
		if($handler) {
			eval('$item_class = '.$handler.'::instance()->getItemClass(); $instance = new $item_class();');
			$instance->setObjectId($id);
			$instance->setId($id);
			return $instance->getViewUrl();
		}else{
			return "#";
		} 

		
	}
	
	private function prepareTitle($title){
		if (!$title) {
			return lang("empty title");
		}
		return $this->highlightResult($this->cutResult($title, $this->titleSize));
	}
	
	/**
	 * Emphaisis around search keywords
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param unknown_type $content
	 */
	private function highlightResult($text) {
		$pieces = explode(" ", $this->search_for);
		
		foreach ($pieces as $word) {
			$text = str_ireplace($word, "<em>".$word."</em>", $text) ;
		}
		return $text;
    }

    
	private function buildPaginationLinks() {
		$currentPage = $this->pagination->currentPage ;
		$links = array();
		$totalPages = ceil( $this->total / $this->limit ) ;
		if ( is_numeric($this->total) ){
			$links_count =  ceil ( min ( $this->maxPageLinks, $totalPages )) ;
		}
		$startPage = min ( max(1,$currentPage - floor($links_count / 2) ), max(1,$totalPages - $links_count) );
		$endPage =  min ($totalPages , $startPage + $this->maxPageLinks  ) ; 
		//alert_r($totalPages) ;
		for ($i = $startPage ; $i <=$endPage ; $i++) {
			$links[$i] = get_url("search", "search" , array(
				"start" =>  ($i-1 ) * $this->limit , 
				"search_for"=>$this->search_for)
			);
		}
		return $links ;
	}		
	
	
	/**
	 * Cut results 
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param unknown_type $content
	 * @param unknown_type $size
	 */
	private function cutResult($content, $size = 200  ) {

		$position = strpos($content,$this->search_for);
		$spacesBefore = min(10, $position); 
		if (strlen($content) > $size ){
			return substr($content , $position - $spacesBefore, $size)."...";
			
		}else{
			return $content ;
		}
	}
	

}
