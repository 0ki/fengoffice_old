<?php

/**
 * Check if $object is valid $class instance
 *
 * @access public
 * @param mixed $object Variable that need to be checked agains classname
 * @param string $class Classname
 * @return null
 */
function instance_of($object, $class) {
	return $object instanceof $class;
} // instance_of

/**
 * Show var dump. pre_var_dump() is used for testing only!
 *
 * @access public
 * @param mixed $var
 * @return null
 */
function pre_var_dump($var) {
	print '<pre>';
	var_dump($var);
	print '</pre>';
} // pre_var_dump

/**
 * This function will return clean variable info
 *
 * @param mixed $var
 * @param string $indent Indent is used when dumping arrays recursivly
 * @param string $indent_close_bracet Indent close bracket param is used
 *   internaly for array output. It is shorter that var indent for 2 spaces
 * @return null
 */
function clean_var_info($var, $indent = '&nbsp;&nbsp;', $indent_close_bracet = '') {
	if(is_object($var)) {
		return 'Object (class: ' . get_class($var) . ')';
	} elseif(is_resource($var)) {
		return 'Resource (type: ' . get_resource_type($var) . ')';
	} elseif(is_array($var)) {
		$result = 'Array (';
		if(count($var)) {
			foreach($var as $k => $v) {
				$k_for_display = is_integer($k) ? $k : "'" . clean($k) . "'";
				$result .= "\n" . $indent . '[' . $k_for_display . '] => ' . clean_var_info($v, $indent . '&nbsp;&nbsp;', $indent_close_bracet . $indent);
			} // foreach
		} // if
		return $result . "\n$indent_close_bracet)";
	} elseif(is_int($var)) {
		return '(int)' . $var;
	} elseif(is_float($var)) {
		return '(float)' . $var;
	} elseif(is_bool($var)) {
		return $var ? 'true' : 'false';
	} elseif(is_null($var)) {
		return 'NULL';
	} else {
		return "(string) '" . clean($var) . "'";
	} // if
} // clean_var_info

/**
 * Equivalent to htmlspecialchars(), but allows &#[0-9]+ (for unicode)
 *
 * This function was taken from punBB codebase <http://www.punbb.org/>
 *
 * @param string $str
 * @return string
 */
function clean($str) {
	$str = preg_replace('/&(?!#[0-9]+;)/s', '&amp;', $str);
	$str = str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $str);

	return $str;
} // clean

/**
 * Convert entities back to valid characteds
 *
 * @param string $escaped_string
 * @return string
 */
function undo_htmlspecialchars($escaped_string) {
	$search = array('&amp;', '&lt;', '&gt;');
	$replace = array('&', '<', '>');
	return str_replace($search, $replace, $escaped_string);
} // undo_htmlspecialchars

/**
 * This function will return true if $str is valid function name (made out of alpha numeric characters + underscore)
 *
 * @param string $str
 * @return boolean
 */
function is_valid_function_name($str) {
	$check_str = trim($str);
	if($check_str == '') return false; // empty string

	$first_char = substr_utf($check_str, 0, 1);
	if(is_numeric($first_char)) return false; // first char can't be number

	return (boolean) preg_match("/^([a-zA-Z0-9_]*)$/", $check_str);
} // is_valid_function_name


/**
 * Check if specific string is valid sha1() hash
 *
 * @param string $hash
 * @return boolean
 */
function is_valid_hash($hash) {
	return ((strlen($hash) == 32) || (strlen($hash) == 40)) && (boolean) preg_match("/^([a-f0-9]*)$/", $hash);
} // is_valid_hash

/**
 * Return variable from hash (associative array). If value does not exists
 * return default value
 *
 * @access public
 * @param array $from Hash
 * @param string $name
 * @param mixed $default
 * @return mixed
 */
function array_var(&$from, $name, $default = null) {
	if(is_array($from)) return isset($from[$name]) ? $from[$name] : $default;
	return $default;
} // array_var

/**
 * This function will return $str as an array
 *
 * @param string $str
 * @return array
 */
function string_to_array($str) {
	if(!is_string($str) || (strlen($str) == 0)) return array();

	$result = array();
	for($i = 0, $strlen = strlen($str); $i < $strlen; $i++) {
		$result[] = $str[$i];
	} // if

	return $result;
} // string_to_array

/**
 * This function will return ID from array variables. Default settings will get 'id'
 * variable from $_GET. If ID is not found function will return NULL
 *
 * @param string $var_name Variable name. Default is 'id'
 * @param array $from Extract ID from this array. If NULL $_GET will be used
 * @param mixed $default Default value is returned in case of any error
 * @return integer
 */
function get_id($var_name = 'id', $from = null, $default = null) {
	$var_name = trim($var_name);
	if($var_name == '') return $default; // empty varname?

	if(is_null($from)) $from = $_GET;

	if(!is_array($from)) return $default; // $from is array?
	if(!is_valid_function_name($var_name)) return $default; // $var_name is valid?

	$value = array_var($from, $var_name, $default);
	return is_numeric($value) ? (integer) $value : $default;
} // get_id

/**
 * This function checks wether the current http request is ajax, so as to know
 * wether we should send the whole page or only the content.
 */

/**
 * This function checks wether the current http request is ajax
 */
function is_ajax_request() {
	return array_var($_GET, 'ajax') == 'true';
} // is_ajax_request


/**
 * This function checks wether the current http request is an upload
 */
function is_upload_request() {
	return array_var($_GET, 'upload') == 'true';
} // is_upload_request

/**
 * Flattens the array. This function does not preserve keys, it just returns
 * array indexed form 0 .. count - 1
 *
 * @access public
 * @param array $array If this value is not array it will be returned as one
 * @return array
 */

function array_flat($array) {
	// Not an array
	if(!is_array($array)) return array($array);

	// Prepare result
	$result = array();

	// Loop elemetns
	foreach($array as $value) {

		// Subelement is array? Flat it
		if(is_array($value)) {
			$value = array_flat($value);
			foreach($value as $subvalue) $result[] = $subvalue;
		} else {
			$result[] = $value;
		} // if
	} // if

	// Return result
	return $result;
} // array_flat

/**
 * Replace first $search_for with $replace_with in $in. If $search_for is not found
 * original $in string will be returned...
 *
 * @access public
 * @param string $search_for Search for this string
 * @param string $replace_with Replace it with this value
 * @param string $in Haystack
 * @return string
 */
function str_replace_first($search_for, $replace_with, $in) {
	$pos = strpos($in, $search_for);
	if($pos === false) {
		return $in;
	} else {
		return substr($in, 0, $pos) . $replace_with . substr($in, $pos + strlen($search_for), strlen($in));
	} // if
} // str_replace_first

/**
 * String starts with something
 *
 * This function will return true only if input string starts with
 * niddle
 *
 * @param string $string Input string
 * @param string $niddle Needle string
 * @return boolean
 */
function str_starts_with($string, $niddle) {
	return substr($string, 0, strlen($niddle)) == $niddle;
} // end func str_starts with

/**
 * String ends with something
 *
 * This function will return true only if input string ends with
 * niddle
 *
 * @param string $string Input string
 * @param string $niddle Needle string
 * @return boolean
 */
function str_ends_with($string, $niddle) {
	return substr($string, strlen($string) - strlen($niddle), strlen($niddle)) == $niddle;
} // end func str_ends_with

/**
 * Return path with trailing slash
 *
 * @param string $path Input path
 * @return string Path with trailing slash
 */

function with_slash($path) {
	return str_ends_with($path, '/') ? $path : $path . '/';
} // end func with_slash

/**
 * Remove trailing slash from the end of the path (if exists)
 *
 * @param string $path File path that need to be handled
 * @return string
 */

function without_slash($path) {
	return str_ends_with($path, '/') ? substr($path, 0, strlen($path) - 1) : $path;
} // without_slash


/**
 * Check if selected email has valid email format
 *
 * @param string $user_email Email address
 * @return boolean
 */
function is_valid_email($user_email) {
	$chars = EMAIL_FORMAT;
	if(strstr($user_email, '@') && strstr($user_email, '.')) {
		return (boolean) preg_match($chars, $user_email);
	} else {
		return false;
	} // if
} // end func is_valid_email

/**
 * Verify the syntax of the given URL.
 *
 * @access public
 * @param $url The URL to verify.
 * @return boolean
 */
function is_valid_url($url) {
	if(str_starts_with(strtolower($url), 'http://localhost')) return true;
	return preg_match(URL_FORMAT, $url);
} // end func is_valid_url

/**
 * Redirect to specific URL (header redirection)
 *
 * @access public
 * @param string $to Redirect to this URL
 * @param boolean $die Die when finished
 * @return void
 */
function redirect_to($to, $die = true) {
	$to = trim($to);
	if(strpos($to, '&amp;') !== false) {
		$to = str_replace('&amp;', '&', $to);
	} // if
	if (is_ajax_request()) {
		$to = make_ajax_url($to);
	}
	header('Location: ' . $to);
	if($die) die();
} // end func redirect_to

/**
 * Redirect to referer
 *
 * @access public
 * @param string $alternative Alternative URL is used if referer is not valid URL
 * @return null
 */
function redirect_to_referer($alternative = nulls) {
	$referer = get_referer();
	if(true || !is_valid_url($referer)) {
		if (is_ajax_request()) {
			$alternative = make_ajax_url($alternative);
		}
		redirect_to($alternative);
	} else {
		if (is_ajax_request()) {
			$referer = make_ajax_url($referer);
		}
		redirect_to($referer);
	} // if
} // redirect_to_referer


/**
 * Return referer URL
 *
 * @param string $default This value is returned if referer is not found or is empty
 * @return string
 */
function get_referer($default = null) {
	return array_var($_SERVER, 'HTTP_REFERER', $default);
} // get_referer

/**
 * This function will return max upload size in bytes
 *
 * @param void
 * @return integer
 */
function get_max_upload_size() {
	return min(
	php_config_value_to_bytes(ini_get('upload_max_filesize')),
	php_config_value_to_bytes(ini_get('post_max_size'))
	); // max
} // get_max_upload_size

/**
 * Convert PHP config value (2M, 8M, 200K...) to bytes
 *
 * This function was taken from PHP documentation
 *
 * @param string $val
 * @return integer
 */

function php_config_value_to_bytes($val) {
	$val = trim($val);
	$last = strtolower($val{strlen($val)-1});
	switch($last) {
		// The 'G' modifier is available since PHP 5.1.0
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	} // if

	return $val;
} // php_config_value_to_bytes

// ==========================================================
//  POST and GET
// ==========================================================

/**
 * This function will strip slashes if magic quotes is enabled so
 * all input data ($_GET, $_POST, $_COOKIE) is free of slashes
 *
 * @access public
 * @param void
 * @return null
 */
function fix_input_quotes() {
	if(get_magic_quotes_gpc()) {
		array_stripslashes($_GET);
		array_stripslashes($_POST);
		array_stripslashes($_COOKIE);
	} // if
} // fix_input_quotes

/**
 * This function will walk recursivly thorugh array and strip slashes from scalar values
 *
 * @param array $array
 * @return null
 */
function array_stripslashes(&$array) {
	if(!is_array($array)) return;
	foreach($array as $k => $v) {
		if(is_array($array[$k])) {
			array_stripslashes($array[$k]);
		} else {
			$array[$k] = stripslashes($array[$k]);
		} // if
	} // foreach
	return $array;
} // array_stripslashes

/**
 * escapes this characters: & ' " < >
 */
function escapeSLIM($rawSLIM) {
	return rawurlencode($rawSLIM);
}

/**
 * unescapes: &amp; &#39; &quot; &lt; &gt;
 */
function unescapeSLIM($encodedSLIM) {
	return rawurldecode($encodedSLIM);
}


function make_ajax_url($url) {
	$q = strpos($url, '?');
	$n = strpos($url, '#');
	if ($q === false) {
		if ($n === false) {
			return $url . "?ajax=true";
		} else {
			return substr($url, 0, $n) . "?ajax=true" . substr($url, $n);
		}
	} else {
		return substr($url, 0, $q + 1) . "ajax=true&" . substr($url, $q + 1);
	}
}
?>