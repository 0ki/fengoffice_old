<?php
/**
 * 
 * Tasks Notification Checkbox config handler
 * 
 * @author Carlos Palma
 *
 */
class TNChkConfigHandler extends ConfigHandler {

	/**
	 * Constructor
	 *
	 * @param void
	 * @return LocalizationConfigHandler
	 */
	function __construct() {
		
	} // __construct

	/**
	 * Render form control
	 *
	 * @param string $control_name
	 * @return string
	 */
	function render($control_name) {
		$options = array( 
			option_tag(lang('no'), 0, $this->getValue() == 0 ? array('selected' => true) : null),
			option_tag(lang('yes'), 1, $this->getValue() == 1 ? array('selected' => true) : null),
			option_tag(lang('auto'), 2, $this->getValue() == 2 ? array('selected' => true) : null));
		

		return select_box($control_name, $options);
	} // render

} // LocalizationConfigHandler

?>