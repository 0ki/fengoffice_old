<?php
$allowed = include 'access.php';
if (!in_array('translate.php', $allowed)) die("This tool is disabled.");

header("Content-Type: text/html; charset=UTF-8");
define('LANG_DIR', 'language');
define('TEST_LIST_PATH', 'all_langs.txt');
chdir("../.."); 

function escape($string) {
	// TODO: this function needs to be checked for special cases
	// replace multiple backslashes for one
	// (this doesn't allow more than one consecutive backslash but eases escaping the string)
	$string = preg_replace("/[\\\\]+/", "\\", $string);
	// the form sends quotes with a leading backlash, so first remove those extra backslashes and then escape the string
	return str_replace(array("\\'", "\\\"", "'", "\r\n", "\r", "\n"), array("'", "\"", "\\'", "\\n", "\\n", "\\n"), $string);
}

function unescape($string) {
	$string = preg_replace("/[\\\\]+/", "\\", $string);
	return str_replace(array("\\'", "\\n", "\\\\"), array("'", "\n", "\\"), $string);
}

function loadFileTranslations($locale, $file) {
	if (substr($file, -4) == ".php") {
		return include LANG_DIR . "/" . $locale . "/" . $file;
	} else if (substr($file, -3) == ".js") {
		$contents = file_get_contents(LANG_DIR . "/" . $locale . "/" . $file);
		$contents = preg_replace("/.*addLangs\s*\(\s*\{\s*/s", "", $contents);
		$contents = preg_replace("/\s*\}\s*\)\s*;\s*$/", "", $contents);
		$matches = array();
		preg_match_all("/\s*'(.*)'\s*:\s*'(.*[^\\\\])'\s*,?/", $contents, $matches, PREG_SET_ORDER);
		$lang = array();
		foreach ($matches as $match) {
			$lang[$match[1]] = $match[2];
		}
		return $lang;
	} else {
		return array();
	}
}


// save submissions
$lang = $_POST['lang'];
$added = 0;
if (isset($lang)) {
	$file = $_POST['file'];
	$locale = $_POST['locale'];
	$rootfile = LANG_DIR . "/" . $locale . ".php";
	$dirname = LANG_DIR . "/" . $locale;
	$filename = $dirname . "/" . $file;
	if (!is_file($rootfile)) {
		$f = fopen($rootfile, "w");
		fwrite($f, '<?php if(!isset($this) || !($this instanceof Localization)) {
			throw new InvalidInstanceError(\'$this\', $this, "Localization", "File \'" . __FILE__ . "\' can be included only from Localization class");
		} ?>');
		fclose($f);
	}
	if (!is_dir($dirname)) {
		mkdir($dirname);
	}
	if (!is_file($filename)) {
		// create the file
		$f = fopen($filename, "w");
		fclose($f);
	}
	$all = loadFileTranslations($locale, $file);
	if (!is_array($all)) $all = array();
	foreach ($lang as $k => $v) {
		if (trim($v) != "") {
			if (!isset($all[$k])) {
				$added++;
			}
			$all[$k] = $v;
		}
	}
	$f = fopen($filename, "w");
	// write the translations to the file
	if (substr($file, -4) == ".php") {
		fwrite($f, "<?php return array(\n");
		foreach ($all as $k => $v) {
			fwrite($f, "\t'$k' => '" . escape("$v"). "',\n");
		}
		fwrite($f, "); ?>\n");
	} else if (substr($file, -3) == ".js") {
		$total = count($all);
		fwrite($f, "locale = '$locale';\n");
		fwrite($f, "addLangs({\n");
		$count = 0;
		foreach ($all as $k => $v) {
			$count++;
			fwrite($f, "\t'$k': '" . escape($v). "'");
			if ($count == $total) {
				fwrite($f, "\n");
			} else {
				fwrite($f, ",\n");
			}
		}
		fwrite($f, "});\n");
	}
	fclose($f);
}
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
table.lang {
	width: 100%;
	border-collapse: collapse;
}
table.lang th {
	background-color: #DDD;
}
table.lang td.key {
	background-color: #EEE;
}
table.lang th, table.lang td {
	vertical-align: top;
	padding: 5px;
	border: 1px solid #888;
}
table.filters td {
	vertical-align: top;
	padding: 5px 10px;
}
th.key {
	width: 20%;
}
th.from, th.to {
	width: 40%;
}
table.lang td.from, table.lang td.to {
	padding: 0px;
}
table.lang td.from textarea, table.lang td.to textarea {
	width: 100%;
	background: white;
	border: 0px;
	margin: 0px;
	color: black;
	overflow-y: auto;
}
td.empty {
	text-align: center;
	font-style: italic;
}
table.lang td.from textarea.focus, table.lang td.to textarea.focus {
	background-color: #EEFFEE;
}
</style>
<script>
function addLangs(langs) {
	locales[locale][file] = {};
	for (var k in langs) {
		locales[locale][file][k] = langs[k];
	}
}
function escLang(text) {
	return text.replace(/'/g, "\\'").replace(/\n/g, "\\n").replace(/</g, "&lt;");
}
var locales = {};
</script>
</head>

<body> <?php
$from = $_GET["from"];
$to = $_GET["to"];
if (!isset($from) || $from == "") $from = "en_us";
if (!isset($to)) $to = ""; ?>
	
<h1>Translate OpenGoo<?php if ($to != "") echo " to $to"; ?></h1>

<p>This tool allows you to translate OpenGoo to a locale other than en_us. Your webserver needs permissions to write on the 'language' folder.</p> <?php

$handle = opendir(LANG_DIR); ?>
<table class="filters"><tbody>
<tr><td>
	<b>Choose a locale:</b>
	<form action="translate.php" method="get" onsubmit="return localeChosen.call(this)">
		<input type="hidden" name="from" value="<?php echo $from ?>" />
		<script>
			function localeChosen() {
				var select = this.getElementsByTagName("select")[0];
				if (select.value == "new") {
					var locale = prompt("Enter a new locale:");
					if (locale) {
						this.to.value = locale;
						this.submit();
					}
				} else if (select.value != "") {
					this.to.value = select.value;
					this.submit();
				}
				return false;
			}
		</script>
		<input type="hidden" name="to" value="" />
		<select onchange="localeChosen.call(this.parentNode)">
			<option value="" <?php if ($to == "") echo ' selected="selected"' ?>>-- Choose a locale --</option> <?php
			$exists = false;
			while (false !== ($f = readdir($handle))) {
				if ($f != "." && $f != ".." && $f != "CVS" && $f != "en_us" && is_dir(LANG_DIR . "/" . $f)) { ?>
					<option value="<?php echo $f?>"<?php if($to == $f) echo ' selected="selected"' ?>>
						<?php echo $f ?>
					</option> <?php
					if ($f == $to) {
						$exists = true;
					}
				}
			}
			if ($to != "" && !$exists) { ?>
				<option value="<?php echo $to ?>" selected="selected"><?php echo $to ?></option> <?php
			}
			?>
			<option value="new">&lt;New&gt;</option>
		</select>
		<button type="submit">Go</button>
	</form> <br />
</td><?php

closedir($handle);

if ($to != "") { 
	// load translation files
	$locales[$from] = array();
	$locales[$to] = array(); ?>
	<script>
		locales['<?php echo $from ?>'] = {};
		locales['<?php echo $to ?>'] = {};
		base = '<?php echo $from ?>';
	</script> <?php
	$handle = opendir(LANG_DIR . "/" . $from);
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != ".." && $file != "CVS") {
			$locales[$from][$file] = array();
		}
	}
	closedir($handle);
	// finished loading translation files

	$file = $_GET["file"];
	if (!isset($file)) $file = ""; ?>
	<td>
	<b>Choose a file:</b>
	<form action="translate.php" method="get">
		<input type="hidden" name="from" value="<?php echo $from ?>" />
		<input type="hidden" name="to" value="<?php echo $to ?>" />
		<script>
			function fileChosen() {
				if (this.value != "") {
					this.parentNode.submit();
				}
			}
		</script>
		<select name="file" onchange="fileChosen.call(this)">
			<option value="" <?php if ($file == "") echo ' selected="selected"' ?>>-- Choose a file --</option> <?php
			foreach ($locales[$from] as $fromFile => $fromLangs) { ?>
				<option value="<?php echo $fromFile?>"<?php if($file == $fromFile) echo ' selected="selected"' ?>>
					<?php echo $fromFile ?>
				</option> <?php
			} ?>
		</select>
		<button type="submit">Go</button>
	</form>
	</td> <?php
	if ($file != "") { 
		$filter = $_GET["filter"];
		if (!isset($filter)) $filter = "all";
		$start = $_GET['start'];
		if (!isset($start)) $start = 0;
		if ($start >= $added && $filter == "missing") $start -= $added; ?>
		<td>
		<b>View:</b>
		<form action="translate.php" method="get">
			<input type="hidden" name="from" value="<?php echo $from ?>" />
			<input type="hidden" name="to" value="<?php echo $to ?>" />
			<input type="hidden" name="file" value="<?php echo $file ?>" />
			<script>
				function filterChosen() {
					this.parentNode.submit();
				}
			</script>
			<select name="filter" onchange="filterChosen.call(this)">
				<option value="missing" <?php if ($filter == "missing") echo ' selected="selected"' ?>>Missing</option>
				<option value="all" <?php if ($filter == "all") echo ' selected="selected"' ?>>All</option>
			</select>
			<button type="submit">Go</button>
		</form>
		</td>
		</tr></tbody></table>
		<script>
		function textChange() {
			window.onbeforeunload = function() {
				return "You have done some changes. If you leave you'll lose all changes you have made";
			};
		}
		
		function textFocus() {
			this.select();
			this.className += " focus";
		}
		
		function textBlur() {
			this.className = (" " + this.className + " ").replace(/\s+focus\s+/g, " ");
		}
		
		function formSubmit() {
			window.onbeforeunload = null;
		}
		
		</script>
		<form id="langs" onsubmit="formSubmit()" action="translate.php?from=<?php echo $from ?>&to=<?php echo $to ?>&file=<?php echo $file ?>&filter=<?php echo $filter ?>" method="post">
			<input type="hidden" name="locale" value="<?php echo $to ?>" />
			<input type="hidden" name="file" value="<?php echo $file ?>" />
			<table class="lang"><tbody>
			<tr>
				<th class="key">Key</th>
				<th class="from"><?php echo $from ?></th>
				<th class="to"><?php echo $to ?><button type="submit" onclick="document.getElementById('langs').action += '&start=<?php echo $start?>'" style="position:relative;top:-50px">Save</button></th>
			</tr><?php
			$locales[$from][$file] = loadFileTranslations($from, $file);
			$locales[$to][$file] = array();
			if (is_file(LANG_DIR . "/" . $to . "/" . $file)) {
				$locales[$to][$file] = loadFileTranslations($to, $file);
			}
			$count = 0;
			$pagesize = 5;
			foreach ($locales[$from][$file] as $key => $value) {
				if ($filter == "all" || $filter == "missing" && !isset($locales[$to][$file][$key])) {
					$count++;
					if ($count > $start && $count <= $start + $pagesize) { ?>
					<tr>
						<td class="key"><?php echo $key ?></td>
						<td class="from"><textarea readonly="readonly" tabindex="-1"><?php echo unescape($value) ?></textarea></td> <?php
					if (!isset($locales[$to][$file]) || !isset($locales[$to][$file][$key])) { ?>
						<td class="to"><textarea name="lang[<?php echo $key ?>]" onfocus="textFocus.call(this)" onblur="textBlur.call(this)" onchange="textChange()"></textarea></td> <?php
					} else { ?>
						<td class="to"><textarea name="lang[<?php echo $key ?>]" onfocus="textFocus.call(this)" onblur="textBlur.call(this)" onchange="textChange()"><?php echo unescape($locales[$to][$file][$key]) ?></textarea></td> <?php
					} ?>
					</tr> <?php
					}
				}
			}
			if ($count == 0) {
				if ($filter == "missing") { ?>
					<tr><td class="empty" colspan="3">No <b>missing</b> translations to display in <b><?php echo $file ?></b>. Choose "All" in the "View" combobox if you want to see all translations in <b><?php echo $file ?></b> or choose another file in the "Choose a file" combobox.</td></tr> <?php
				} else { ?>
					<tr><td class="empty" colspan="3">No translations to display in <b><?php echo $file ?></b>. Try choosing a different file in the "Choose a file" combobox.</td></tr> <?php
				}
			} ?>
			</tbody></table> <br /> <?php
			if ($start > 0) {
				$remaining = min($start, 5); ?>
				<button onclick="this.parentNode.action += '&start=<?php echo $start - $remaining?>'" type="submit">Previous <?php echo $remaining  ?></button><?php
			}
			/*if ($filter == 'missing') {
				// when pressing Next you are saving current langs, and thus removing them from the
				// 'missing' category, so the Next button doesn't need to change the $start value to
				// show you new items
				$nextstart = $start + $pagesize;
			} else {
				$nextstart = $start + $pagesize;
			}*/
			$nextstart = $start + $pagesize;
			$remaining = min(array(5, $count - $nextstart));
			if ($remaining > 0) { ?>
				<button onclick="this.parentNode.action += '&start=<?php echo $nextstart ?>'" type="submit">Next <?php echo $remaining  ?></button><?php
			}
			if ($count > 0) { ?>
				Showing <?php echo $start + 1 ?> to <?php echo min($start + $pagesize, $count) ?> of <?php echo $count ?> <?php
			} ?>
		</form><?php
	} else { ?>
		</tr></tbody></table> <?php
	}
} ?>

</body>
</html>