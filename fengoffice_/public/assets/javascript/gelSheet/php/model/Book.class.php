<?php
/*  Gelsheet Project, version 0.0.1 (Pre-alpha)
 *  Copyright (c) 2008 - Ignacio Vazquez, Fernando Rodriguez, Juan Pedro del Campo
 *
 *  Ignacio "Pepe" Vazquez <elpepe22@users.sourceforge.net>
 *  Fernando "Palillo" Rodriguez <fernandor@users.sourceforge.net>
 *  Juan Pedro "Perico" del Campo <pericodc@users.sourceforge.net>
 *
 *  Gelsheet is free distributable under the terms of an GPL license.
 *  For details see: http://www.gnu.org/copyleft/gpl.html
 *
 */
	include_once("config/settings.php");

	include_once($cnf['site']['path']."/Connection.php");

	include_once($cnf['site']['path']."/model/Sheet.class.php");
	include_once($cnf['site']['path']."/model/FontStyle.class.php");

	/**
	 * Enter description here...
	 * @author Pepe
	 */
	class Book {

		public $bookId;
		public $bookName;
		public $userId;
		public $sheets=array();
		public $fontStyles= array();

		/**
		* Constructor.
	 	*/
		public function __construct($bookId=null, $bookName=null, $userId=null, $sheets=null, $fontStyles=null){
			$this->bookId = $bookId ;
			$this->bookName=$bookName;
			$this->userId=$userId;
			$this->sheets=$sheets;
			$this->fontStyles=$fontStyles;
		}

		/**
		 * Destructor.
		 */
		public function __destruct(){

		}


		/** Setters **/

		public function setId($bookId){
			$this->bookId = $bookId;
		}

		public function setName($name){
			$this->bookName=$name;
		}

		public function setUserId($uid){
			$this->userId=$uid;
		}

		/** Getters  **/

		public function getId(){
			return $this->bookId;
		}

		public function getName(){
			return $this->bookName;
		}

		public function getUserId() {
			return $this->userId;
		}

		public function getFontStyles() {
			if ( $this->fontStyles == null ) {
				// The object is not loaded, so have to access the db . . .
				if ( isset($this->bookId) ) {
					$this->loadFontStyles($this->bookId);

				}else {
					return null ;
					//BookId is not setted, set it first ...
				}
			}else
				return $this->fontStyles;
		}

		public function getFontStyle($fontId) {
			if ($this->fontStyles == null)
				$this->loadFontStyles($this->bookId);

			foreach ($this->fontStyles as $font){
				//echo "<br><pre>".print_r($font)."</pre><br>";
				if ($font->getId() == $fontId){

					return $font;

				}


			}


		}
		public function getSheets() {
			if ($this->sheets==null){
			// The object is not loaded, so have to access the db . . .
				if ( isset($this->bookId) ) {
					$this->loadSheets($this->bookId);

				}else {
					return null ;
					//BookId is not setted, set it first ...
				}
			}else
				return $this->sheets;
		}


		/*** Others  ***/
		public function addSheet($sheet){
			if ($this->sheets == null)
				$this->sheets = array();
			$this->sheets[]=$sheet;
		}

		public function addFontStyle($fontStyle){
			if ($this->fontStyles==null)
				$this->fontStyles = array();
			$this->fontStyles[]=$fontStyle;
		}

		public function delete($recursive = false){
			if ($recursive) {
				foreach ($this->sheets as $sheet){
					$sheet->delete(true);
				}
				foreach ($this->fontStyles as $fontStyle){
					$fontStyle->delete(true);
				}
			}
			$sql="delete from ".table('books'). " where BookId =".$this->bookId;
			mysql_query($sql);
		}

		public function load($BookId) {
			//$sql = "select * from books where BookId=$BookId ";
			$sql = "select * from ".table('books'). " where BookId=$BookId ";
			$result =  mysql_query($sql);
			if ($row = mysql_fetch_object($result)) {
				$this->bookId = $row->BookId;
				$this->bookName = $row->BookName;
				$this->userId = $row->UserId ;
			}
			$this->loadSheets($BookId);
			$this->loadFontStyles($BookId);
		}

		function loadFontStyles($BookId) {
			$sql = "select FontStyleId,BookId,FontId,FontSize,FontBold,FontItalic,FontUnderline,FontColor
					from ".table('fontStyles'). "
					where BookId=$BookId";
			$result = mysql_query($sql);

			while ($row = mysql_fetch_object($result)){
				//$fontStyleId = null,$bookId=null, $fontId =null, $fontSize =null ,  $fontBold =null, $fontItalic=null, $fontUnderline = null,$fontColor = null
				$fontStyle = 	new FontStyle(	$row->FontStyleId,
												$row->BookId,
												$row->FontId,
												$row->FontSize,
												$row->FontBold,
												$row->FontItalic,
												$row->FontUnderline,
												$row->FontColor
											);
				$this->addFontStyle($fontStyle);

			}
		}





		function loadSheets($BookId) {
			$sql = "select SheetId from ".table('sheets'). " where BookId=$BookId" ;
			$result =  mysql_query($sql);

			while ($row = mysql_fetch_object($result)){
				$sheet = new Sheet();
				$sheet->load($row->SheetId);
				$this->addSheet($sheet);
			}
		}

		/**
		 * Saves the book into de database.
		 * If the id isn't setted, automatically assigns one
		 *
		 **/
		public function save(){
			$update = false ; 
			$hasErrors = false;

			if(!isset($this->userId))
				$this->userId = 1;    //TODO: Remove only for debugging user must be always setted (logged user)

			//print print_r($this);
			$sql = "INSERT INTO ".table('books'). " (BookId, BookName, UserId) VALUES ($this->bookId,'$this->bookName',$this->userId)";

			//$this->delete(false);
			// ver que hacemos en caso de que exista..

			if (isset($this->bookId)) {
			// Edit book..
				
				//Check if the the id is correct..
				$res = mysql_query("SELECT BookId FROM ".table('books'). " where BookId=$this->bookId");
				if(!$res){
					$hasErrors = true;
					echo mysql_error();
				}

				$row = mysql_fetch_object($res);
				if (!$row) {
				//ERROR: trying to save a book that does exist. Must have null value the bookid
					
					if(!mysql_query($sql)){
						echo mysql_error();
						//$hasErrors = true;
					}

				}else {
				// OK: Delete.. and save it again
					$update = true;
					mysql_query("START TRANSACTION");
					$book_tmp = new Book();
					$book_tmp->load($this->bookId);
					$book_tmp->delete(true);


					if(!mysql_query($sql)){
						echo mysql_error();
						$hasErrors = true;
					}

				}

			}else {
				//SAVE AS...
				
				$sql = "INSERT INTO ".table('books'). " (BookName, UserId) VALUES ('$this->bookName',$this->userId)";
				$query = mysql_query($sql);
				if($query)
					$this->bookId= mysql_insert_id();
				else{
					
					echo mysql_error();echo "<hr>";
					$hasErrors = true;
				}
			}
			
			//COMMON CODE..
			if(!$hasErrors){
				foreach ($this->sheets as $sheet) {
					$sheet->bookId = $this->bookId;
					$hasErrors = $sheet->save();
				}
			}

			if(!$hasErrors){
				foreach ($this->fontStyles as $fontStyle) {
					$fontStyle->bookId = $this->bookId;
					$hasErrors = $fontStyle->save();
				}
			}
			if ($update) {
				//if update means that a transaction was started.. 
				//so check for errors and commit if ok
				 
				if (!$hasErrors)
					mysql_query("COMMIT");
				else 
					mysql_query("ROLLBACK") ;	
			}	
			return $hasErrors;
		}

		public function toJson(){
			//return json_encode($this);
			$json =  "{id:$this->bookId,name:\"$this->bookName\",sheets:[";
			$temp = "";
			
			foreach($this->sheets as $sheet){
				$temp.= ",".$sheet->toJson();
			}
			//$json.= substr($temp,1)."]}";
			$json.= substr($temp,1)."],";
			$json.= "fontStyles:[";
			$temp = '' ;
			if (is_array($this->fontStyles))
				foreach ( $this->fontStyles as $fontStyle ) {
					/* @var  $fontStyle FontStyle */
					$temp.= ",".$fontStyle->toJson();
				}
			$json.= substr($temp,1)."]";
			$json.= "}";
			return $json;
		}

		public function fromJson($obj){
			$this->bookId = $obj->bookId;
			$this->bookName=$obj->bookName;
			$this->userId=$obj->userId;

			foreach ($obj->sheets as $sheet){
				$newsheet = new Sheet();
				$newsheet->fromJson($sheet);
				$newsheet->bookId=$this->bookId;
				$this->addSheet($newsheet);
			}

			if (is_array($obj->fontStyles)) {
				foreach ($obj->fontStyles as $fontStyle){
					$newFontStyle = new FontStyle();
					$newFontStyle->fromJson($fontStyle);
					$newFontStyle->bookId=$this->bookId;
					$this->addFontStyle($newFontStyle);
				}
			}
		}
	}
?>
