<?php
class SearchController extends ApplicationController {
	
	static $MYSQL_MIN_WORD_LENGHT = 4 ;
	
	/**
	 * Debug mode (Dev only)
	 * @var unknown_type
	 */
	var $debug = 0 ;
	
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
	 * If $ignoreMinWordLength = false: 
	 * =>	Makes a standart fulltext always. 
	 * 		Depending on mysql configuration ft_min_word_len if the word wil be searched
	 * Else : 
	 * => 	If searchString has words with legth ft_min_word_len
	 * 		Makes a like query (Performance Killer)
	 * @var integer
	 */
	var $ignoreMinWordLength = true;
	
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
	var $wildCardSearch = true ;
	
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
		self::$MYSQL_MIN_WORD_LENGHT = (int)array_var(DB::executeOne("SHOW variables LIKE 'ft_min_word_len' "),"Value");
	}
	
	
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
		$minWordLength = $this->minWordLength($search_for);
		$useLike = ( $minWordLength && ($this->ignoreMinWordLength) && ($minWordLength < self::$MYSQL_MIN_WORD_LENGHT) );
		$search_pieces= explode(" ", $search_for);
		$search_string = "";
		if (!$useLike){
			// Prepare MATCH AGAINST string
			foreach ($search_pieces as $word ) {
				$search_string.= mysql_escape_string($word);
				if ($this->wildCardSearch) {
					$search_string.="*";
				}
				$search_string.=" ";
			}
			$search_string = substr($search_string, 0 , -1);
		}else{
			// USE Like Query
			$search_string = mysql_escape_string($search_for);
		}
		
		$this->search_for = $search_for ;
		$limit = $this->limit;
		$start = array_var($_REQUEST, 'start' , $this->start) ;
		$this->start = $start ;
		$limitTest = max( $this->limitTest , $this->limit);
		$filteredResults = 0 ;
		$uid = logged_user()->getId();
		
		
		$revisionObjectTypeId = ObjectTypes::findByName("file revision")->getId();
		
		$sql = "	
			SELECT  distinct(so.rel_object_id) AS id
			FROM ".TABLE_PREFIX."searchable_objects so
			INNER JOIN  ".TABLE_PREFIX."objects o ON o.id = so.rel_object_id 
			WHERE (
				(	
					o.object_type_id = $revisionObjectTypeId AND  
					EXISTS ( 
						SELECT id FROM fo_sharing_table WHERE object_id  = ( SELECT file_id FROM fo_project_file_revisions WHERE object_id = o.id ) 
						AND group_id IN (SELECT permission_group_id FROM ".TABLE_PREFIX."contact_permission_groups WHERE contact_id = $uid )
					)
					
				) 
				OR (
					so.rel_object_id IN (
			    		SELECT object_id FROM ".TABLE_PREFIX."sharing_table WHERE group_id  IN (
			      			SELECT permission_group_id FROM ".TABLE_PREFIX."contact_permission_groups WHERE contact_id = $uid
			    		)
			 		)
			 	)
			)".(($useLike)?"AND so.content LIKE '%$search_string%' " : "AND MATCH (so.content) AGAINST ('$search_string' IN BOOLEAN MODE) ")." 
			ORDER by o.updated_on DESC
			LIMIT $start, $limitTest ";
		
		
		$db_search_results = array();
		$timeBegin = time();
		$res = DB::execute($sql);
		$timeEnd = time();
		if ($this->debug) alert_r("<br>SQL:<br>".$sql. "<hr>TIME:".($timeEnd-$timeBegin) );
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
	
	private function minWordLength($str) {
		$min = null ;		
		foreach ( explode(" ", $str) as $word ){
			if ( $len = strlen_utf(trim($word)) ){
				if (is_null($min) || $len < $min) {
					$min = $len ;
				}
			}
		}
		return $min ;
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
