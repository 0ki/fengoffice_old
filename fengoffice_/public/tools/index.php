<?php
/**
 * To enable a tool you need to add it to the access.php file.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
body {
	padding: 5px 30px;
	font-family: Arial, sans-serif, serif;
	font-size: 12px;
}
</style>
</head>

<body>
	<h1>OpenGoo tools</h1>
	<ul>
	<li><a href="checklang.php">Check lang</a>
		<p>Checks if a set of translation files is missing any translations.</p>
	</li>
	<li><a href="mailChecker.php">Mail checker</a>
		<p>Checks email for all accounts in OpenGoo. You can configure a cron job to execute this file for automatic email checking.</p>
	</li>
	<li><a href="minify.php?minify=true">Minify CSS and Javascript</a>
		<p>Minifies javascript and CSS to improve OpenGoo loading times. After minifying you need to set the COMPRESSED_CSS and COMPRESSED_JS config options in config/config.php. This is more suitable for production environments than development, as you would need to rerun this tool whenever you edit a JS or CSS file, and the minified JS isn't useful for debugging.</p>
	</li>
	<li><a href="translate.php">Translate OpenGoo</a>
		<p>Provides a web user interface for translating OpenGoo to another language.</p>
	</li>
	</ul>
</body>

</html>