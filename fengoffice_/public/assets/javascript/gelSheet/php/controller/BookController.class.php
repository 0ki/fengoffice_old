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


	class BookController{


		public function __construct(){}

		public function __destruct(){}


		public function saveBook($book, $inputFormat = 'jsonss', $outputFormat = 'dbs'){

		//echo "save book ".$inputFormat." ".$outputFormat."<hr>";
			
			$book = stripslashes($book);
			//$book= '{"bookId":null,"bookName":"PPEPEPEPE","sheets":[{"sheetId":null,"cells":[{"dataRow":"0","dataColumn":"1","cellFormula":"PPP","fontStyleId":"0","layoutStyleId":"0"}]}],"fontStyles":[{"fontStyleId":"0","fontId":"1","fontBold":"0","fontItalic":"0","fontSize":"10","fontColor":"#000000","fontUnderline":"0"}]}';
		//$book = "{bookId:null,bookName:'PPEPEPEPE', sheets:[{sheetId:null,cells:[{dataRow:'0',dataColumn:'1',cellFormula:'PPP',fontStyleId:'0,layoutStyleId:'0'}]}],fontStyles:[{fontStyleId:'0',fontId:'1',fontBold:'0',fontItalic:'0',fontSize:'10',fontColor:'#000000',fontUnderline:'0'}]}";
			//echo $book;
			$newBook = new Book();
		
			switch ($inputFormat) {
				case 'json':
					$json_obj = json_decode($book);
					//var_dump($json_obj);
					//var_dump($book);
					if(!isset($json_obj)){
						echo "{'Error':2,'Message':'Ups!!! Sorry, Book has not received properly to server. Be aware you are running an alpha version.','Data':0}";
						exit();
					}
					$newBook->fromJson($json_obj);
					break ;

				case 'xml':

					break ;

				case 'yml';
					break ;

				default :
					$json_obj = json_decode($book);
					$newBook->fromJson($json_obj);
					break ;
			}

			$controller= new ExportController();

			switch($outputFormat) {
				case 'db':
					$newBook->save();
					break;

				case 'xls':
					$controller->generateBook($newBook, $outputFormat);
					break;

				case 'xlsx':
					$controller->generateBook($newBook, $outputFormat);
					break;

				case 'pdf':
					$controller->generateBook($newBook, $outputFormat);
					break;

				case 'ods':
					$controller->generateBook($newBook, $outputFormat);
					break;

					default:
					
					$errors =  $newBook->save();
					if(!$errors)
						echo "{'Error':0,'Message':'Book saved succesfully','Data':{'BookId':".$newBook->getId()."}}";
					else
						echo "{'Error':1,'Message':'Ups!!! Sorry, Book could not be saved. Be aware you are running an alpha version.','Data':0}";
					break;
			}
		}


		/*returns the book. id cant be null*/
		public function find ($id= null){

			if ($id!= null){

				$book= new Book();
				$book->load($id);

				return $book;

			}
			else{

				return -1;

			}
		}

		public function getBooks(){

			$sql = "select * from ".table('books');
			$result= mysql_query($sql);

			while($row = mysql_fetch_object($result)){

				$books[] = array(
					'bookId'	=>	$row->bookId	,
					'bookName'	=> 	$row->bookName
				);

			}

			return $books;


		}
		
		
		/**
		 * Edit the book info
		 * 
		 * @param Book $book
		 * @param unknown_type $inputFormat
		 */
		public function editBook($book, $inputFormat = 'json'){
			/* @var $conn Connection  */
			

			$book = stripslashes($book);
			$newBook = new Book();
			switch ($inputFormat) {
				case 'json':
					print $book.'<hr>' ;
					echo strlen($book);
					$json_obj = json_decode($book);
					//var_dump($json_obj);EXIT ;
					$newBook->fromJson($json_obj);
				break ;

				case 'xml':
				break ;

				case 'yml';
				break ;

				default :
					$json_obj = json_decode($book);
					$newBook->fromJson($json_obj);
				break ;
			}
			$bookId = $newBook->bookId;
			
			$toDelete = new Book();
			$toDelete->load($bookId);
			echo $bookId."<hr>";
			var_dump($toDelete) ;
			exit;
			mysql_query ( "START TRANSACTION ");
			$toDelete->delete(true);
			$error = new OutputMessage('asdfjh');
			if($error->isdebugging)
				$error->addMessage("mysqlerror",mysql_error());
			throw $error;
			echo "<hr>xxxxx" ;
			
			$ok = $newBook->save();
			mysql_query ( "COMMIT ") ;
			//$ok = true ; exit ;
			//TODO What return this ????
			if ($ok) {
				echo "entra commit";
				mysql_query ( "COMMIT ") ;
			}	
			
		}
		
		function deleteBook($bookId) {
			if (@mysql_query("START TRANSACTION") &&
					@mysql_query("DELETE FROM `" . table('cells') . "` WHERE `SheetId` IN (SELECT `SheetId` FROM `" . table('sheets') . "` WHERE `BookId` = $bookId)") &&
					@mysql_query("DELETE FROM `" . table('mergedCells') . "` WHERE `SheetId` IN (SELECT `SheetId` FROM `" . table('sheets') . "` WHERE `BookId` = $bookId)") &&
					@mysql_query("DELETE FROM `" . table('rows') . "` WHERE `SheetId` IN (SELECT `SheetId` FROM `" . table('sheets') . "` WHERE `BookId` = $bookId)") &&
					@mysql_query("DELETE FROM `" . table('columns') . "` WHERE `SheetId` IN (SELECT `SheetId` FROM `" . table('sheets') . "` WHERE `BookId` = $bookId)") &&
					@mysql_query("DELETE FROM `" . table('sheets') . "` WHERE `BookId` = $bookId") &&
					@mysql_query("DELETE FROM `" . table('fontStyles') . "` WHERE `BookId` = $bookId") &&
					@mysql_query("DELETE FROM `" . table('books') . "` WHERE `BookId` = $bookId") &&
					@mysql_query("COMMIT")) {
				echo "{'Error':0,'Message':'Book $bookId deleted succesfully','Data':{'BookId':".$bookId."}}";	
			} else {
				$err = str_replace("'", '"', mysql_error());
				echo "{'Error':1,'Message':'Error deleting book: $err','Data':{'BookId':$bookId}}";
			}
		}
	}


?>