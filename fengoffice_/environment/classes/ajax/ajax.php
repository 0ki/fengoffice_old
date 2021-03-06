<?php

/**
 * Set the current panel's content. Expects the panel'd id, the type of content
 * (html, url), the data (html code, url), and the page actions.
 * If type is 'empty' the current content isn't changed. The other parameters are ignored.
 *
 * @param string $type
 * @param string $data
 * @param array $actions
 * @param string $panel
 */
function ajx_current($type, $data = null, $actions = null, $panel = null) {
	AjaxResponse::instance()->setCurrentContent($type, $data, $actions, $panel);
}

/**
 * Add content for a panel. Expects the panel's id, the type of content
 * (html, url), the data (html code, url), and the page actions.
 *
 * @param string $panel
 * @param string $type
 * @param string $data
 * @param array $actions
 */
function ajx_add($panel, $type = null, $data = null, $actions = null) {
	AjaxResponse::instance()->addContent($panel, $type, $data, $actions);
}

/**
 * Set the error message. If code is 0 it's a success message,
 * otherwise it's an error message.
 *
 * @param number $code
 * @param string $message
 */
function ajx_error($code, $message) {
	AjaxResponse::instance()->setError($code, $message);
}

/**
 * Returns the target panel of the request.
 *
 * @return string
 */
function ajx_get_panel($controller = null, $action = null) {
	if ($controller instanceof AccountController) {
		return "account";
	} else if ($controller instanceof AdministrationController) {
		return "administration";
	} else if ($action == 'search') {
		return "search";
	} else {
		return array_var($_GET, 'current');
	}
}

/**
 * Checks whether the user is logged in and if not returns an error response.
 *
 */
function ajx_check_login() {
	if (is_ajax_request() && !logged_user() instanceof User) {
		// error, user not logged in => return error message
		$response = AjaxResponse::instance();
		$response->setCurrentContent("empty");
		$response->setError(1, lang("session expired error"));
			
		// display the object as json
		tpl_assign("object", $response);
		$content = tpl_fetch(Env::getTemplatePath("json"));
		tpl_assign("content_for_layout", $content);
		tpl_display(Env::getLayoutPath("json"));
		exit();
	}
}

/**
 * Adds attributes other than the default (errorCode, events, current, etc.)
 * @access public
 * @param array
 */
function ajx_extra_data($data) {
	AjaxResponse::instance()->addExtraData($data);
}

?>