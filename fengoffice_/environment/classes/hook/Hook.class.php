<?php
class Hook {
	static private $hooks = array();
	
	static function register($hook) {
		self::$hooks[] = $hook;
	}
	
	static function fire($function, $argument, &$ret) {
		foreach (self::$hooks as $hook) {
			$callback = $hook."_".$function;
			if (function_exists($callback)) {
				$callback($argument, $ret);
			}
		}
	}
	
	static function init() {
		$handle = opendir("application/hooks");
		while ($file = readdir($handle)) {
			if (is_file("application/hooks/$file")) {
				include_once "application/hooks/$file";
			}
		}
		closedir($handle);
	}
}
?>