<?php

if (!function_exists('json_encode')) {
	require_once 'library/json/FastJSON.php';
	function json_encode($object) {
		return FastJSON::encode($object);
	}
}

if (!function_exists('json_decode')) {
	require_once 'library/json/FastJSON.php';
	function json_decode($json_string) {
		return FastJSON::decode($json_string);
	}
}

?>