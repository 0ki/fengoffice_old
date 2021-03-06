<?php

define('SESSION_EXPIRED_ERROR_CODE', 2009);

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

function ajx_unset_current() {
	AjaxResponse::instance()->unsetCurrentContent();
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
function ajx_add($panel, $type = null, $data = null, $actions = null, $notbar = null, $preventClose = null) {
	AjaxResponse::instance()->addContent($panel, $type, $data, $actions, $notbar, $preventClose);
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
 * Sets the target panel of the request.
 *
 * @param string $panel
 */
function ajx_set_panel($panel) {
	AjaxResponse::instance()->currentPanel = $panel;
}

/**
 * Returns the target panel of the request.
 *
 * @return string
 */
function ajx_get_panel($controller = null, $action = null) {
	if (isset(AjaxResponse::instance()->currentPanel)) {
		return AjaxResponse::instance()->currentPanel;
	} else {
		return array_var($_GET, 'current');
	}
}

/**
 * Checks whether the user is logged in and if not returns an error response.
 *
 */
function ajx_check_login() {
	if (is_ajax_request() && !logged_user() instanceof User && (array_var($_GET, 'c') != 'access' || array_var($_GET, 'a') != 'relogin')) {
		// error, user not logged in => return error message
		$response = AjaxResponse::instance();
		$response->setCurrentContent("empty");
		$response->setError(SESSION_EXPIRED_ERROR_CODE, lang("session expired error"));
			
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

function ajx_set_no_toolbar($nt = true){
	AjaxResponse::instance()->notbar = $nt;
}

function ajx_prevent_close($preventClose = true){
	AjaxResponse::instance()->preventClose = $preventClose;
}

function ajx_replace($replace = true) {
	AjaxResponse::instance()->replace = $replace;
}
?>