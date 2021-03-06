<?php
$allowed = include 'access.php';
if (!in_array('minify.php', $allowed)) die("This tool is disabled.");

// include libraries
include_once '../../library/jsmin/JSMin.class.php';
include_once '../../library/cssmin/CSSMin.class.php';


// process arguments
$minify = isset($_GET['minify']);


// process javascripts
echo "Concatenating javascripts ... \n";
$files = include "../../application/layouts/javascripts.php";

$jsmin = "";
foreach ($files as $file) {
	$jsmin .= file_get_contents("../assets/javascript/$file") . "\n";
}
echo "Done!<br>\n";

if ($minify) {
	echo "Minifying javascript ... \n";
	$jsmin = JSMin::minify($jsmin);
	echo "Done!<br>\n";
}

echo "Writing to file 'ogmin.js' ... ";
file_put_contents("../assets/javascript/ogmin.js", $jsmin);
echo "Done!<br>";

echo "<br>";


// process CSS

function changeUrls($css, $base) {
	return preg_replace("/url\s*\(\s*['\"]?([^\)'\"]*)['\"]?\s*\)/i", "url(".$base."/$1)", $css);
}

function parseCSS($filename, $filebase, $imgbase) {
	$css = file_get_contents($filebase.$filename);
	$imports = explode("@import", $css);
	$cssmin = changeUrls($imports[0], $imgbase);
	for ($i=1; $i < count($imports); $i++) {
		$split = explode(";", $imports[$i], 2);
		$import = trim($split[0], " \t\n\r\0\x0B'\"");
		$cssmin .= parseCSS($import, $filebase, $imgbase."/".dirname($import));
		$cssmin .= changeUrls($split[1], $imgbase);
	}
	return $cssmin;	
}

echo "Concatenating CSS ... ";
$cssmin = parseCSS("website.css", "../assets/themes/default/stylesheets/", ".");
echo "Done!<br>";

if ($minify) {
	echo "Minifying CSS ... ";
	$cssmin = CSSMin::minify($cssmin);
	echo "Done!<br>";
}

echo "Writing to file 'ogmin.css' ... ";
file_put_contents("../assets/themes/default/stylesheets/ogmin.css", $cssmin);
echo "Done!<br>";

?>