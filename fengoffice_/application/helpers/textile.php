<?php

/**
 * Just textile the text and return
 *
 * @param string $text Input text
 * @param boolean $lite Skip lists, tables and blocks
 * @param boolean $encode Encode and return
 * @param boolean $noimage Don't insert images
 * @param boolean $strict Fix entities and fix whitespace
 * @param string $rel
 * @return string
 */
function do_textile($text, $lite = false, $encode = false, $noimage = false, $strict = false, $rel = '') {
	Env::useLibrary('textile');
	$textile = new Textile();
	return $textile->TextileThis($text, $lite, $encode, $noimage, $strict, $rel);
} // do_textile


function convert_to_links($text){
	//Replace full urls with hyperinks. Avoids " character for already rendered hyperlinks
	$text = preg_replace('@[^"](https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $text);

	//Convert every word starting with "www." into a hyperlink
	$text = preg_replace('@[>|\s](www.([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="http://$1">$1</a>', $text);
		
	//Convert every email address into an <a href="mailto:... hyperlink
	$text = preg_replace('/[^:a-zA-Z0-9](([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+)/i', '<a href="mailto:$1">$1</a>', $text);
	return $text;
}

?>