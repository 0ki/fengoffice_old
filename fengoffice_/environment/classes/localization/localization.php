<?php

/**
 * Shortcut method for retriving single lang value
 *
 * @access public
 * @param string $neme
 * @return string
 */
function lang($name) {

	// Get function arguments and remove first one.
	$args = func_get_args();
	if(is_array($args)) array_shift($args);

	// Get value and if we have NULL done!
	$value = Localization::instance()->lang($name);
	if(is_null($value)) return $value;

	// We have args? Replace all %s with arguments
	if(is_array($args) && count($args)) {
		$i = 0;
		foreach($args as $arg) {
			$value = str_replace('{'.$i.'}', $arg, $value);
			$i++;
		} // foreach
	} // if

	// Done here...
	return $value;

} // lang

?>