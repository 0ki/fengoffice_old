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
#moreOptions {
	margin-bottom: 20px;
	margin-left: 20px;
}
label {
	font-weight: bold;
}
table.options td {
	vertical-align: middle;
	padding: 5px 10px;
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
function showMoreOptions() {
	if (this.optionsVisible) {
		this.optionsVisible = false;
		this.innerHTML = 'More options';
		document.getElementById('moreOptions').style.display = 'none';
	} else {
		this.optionsVisible = true;
		this.innerHTML = 'Hide options';
		document.getElementById('moreOptions').style.display = 'block';
	}
}
var locales = {};
</script>
<?php
if (!isset($from) || $from == "") $from = "en_us";
if (!isset($to)) $to = ""; ?>
	
<h1>Translate OpenGoo<?php if ($to != "") echo " to $to"; ?></h1>

<p>This tool allows you to translate OpenGoo to a locale other than en_us. Your webserver needs permissions to write on the 'language' folder.</p> <?php

$handle = opendir(LANG_DIR); ?>
<table class="filters"><tbody>
<tr><td>
	<label>Choose a locale:</label>
	<form action="index.php" method="get" onsubmit="return localeChosen.call(this)">
		<input type="hidden" name="c" value="tool">
		<input type="hidden" name="a" value="translate">
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
	<label>Choose a file:</label>
	<form action="index.php" method="get">
		<input type="hidden" name="c" value="tool">
		<input type="hidden" name="a" value="translate">
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
		if ($start >= $added && $filter == "missing") $start -= $added;
		$pagesize = $_POST['pagesize'];
		if (!isset($pagesize)) $pagesize = 5; ?>
		<td>
		<label>View:</label>
		<form action="index.php" method="get">
			<input type="hidden" name="c" value="tool">
			<input type="hidden" name="a" value="translate">
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
		<td style="text-align:right">
			<br />
			<button style="margin-left:50px" type="submit" onclick="saveClick()">Save</button>
			<a href="#" onclick="showMoreOptions.call(this);return false;" style="margin-left:10px">More options</a>
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
		
		function saveClick() {
			var form = document.getElementById('langs');
			form.action += '&start=<?php echo $start?>';
			formSubmit();
			form.submit();
		}
		
		function pagesizeChange() {
			formSubmit();
			document.getElementById('langs').submit(); 
		}
		
		function formSubmit() {
			window.onbeforeunload = null;
		}
		
		</script>
		<form id="langs" onsubmit="formSubmit()" action="index.php?c=tool&a=translate&from=<?php echo $from ?>&to=<?php echo $to ?>&file=<?php echo $file ?>&filter=<?php echo $filter ?>" method="post">
			<div id="moreOptions" style="display:none">
				<table class="options"><tbody><tr><td>
					<label>Page size:</label>
					<select name="pagesize" onchange="pagesizeChange.call(this)" value="<?php echo $pagesize ?>">
						<option value="5"<?php if ($pagesize == 5) echo ' selected="selected"'; ?>>5</option>
						<option value="10"<?php if ($pagesize == 10) echo ' selected="selected"'; ?>>10</option>
						<option value="20"<?php if ($pagesize == 20) echo ' selected="selected"'; ?>>20</option>
						<option value="50"<?php if ($pagesize == 50) echo ' selected="selected"'; ?>>50</option>
						<option value="100"<?php if ($pagesize == 100) echo ' selected="selected"'; ?>>100</option>
					</select>
				</td><td>
					<a target="blank" href="index.php?c=tool&a=translate&download=<?php echo $to ?>">Download zipped translation files for <?php echo $to ?></a>
				</td></tr></tbody></table>
			</div>
			<input type="hidden" name="locale" value="<?php echo $to ?>" />
			<input type="hidden" name="file" value="<?php echo $file ?>" />
			<table class="lang"><tbody>
			<tr>
				<th class="key">Key</th>
				<th class="from"><?php echo $from ?></th>
				<th class="to">
					<?php echo $to ?>
				</th>
			</tr><?php
			$locales[$from][$file] = loadFileTranslations($from, $file);
			$locales[$to][$file] = array();
			if (is_file(LANG_DIR . "/" . $to . "/" . $file)) {
				$locales[$to][$file] = loadFileTranslations($to, $file);
			}
			$count = 0;
			foreach ($locales[$from][$file] as $key => $value) {
				if ($filter == "all" || $filter == "missing" && !isset($locales[$to][$file][$key])) {
					$count++;
					if ($count > $start && $count <= $start + $pagesize) { ?>
					<tr>
						<td class="key"><?php echo $key ?></td>
						<td class="from"><textarea readonly="readonly" tabindex="-1"><?php echo unescape_lang($value) ?></textarea></td> <?php
					if (!isset($locales[$to][$file]) || !isset($locales[$to][$file][$key])) { ?>
						<td class="to"><textarea name="lang[<?php echo $key ?>]" onfocus="textFocus.call(this)" onblur="textBlur.call(this)" onchange="textChange()"></textarea></td> <?php
					} else { ?>
						<td class="to"><textarea name="lang[<?php echo $key ?>]" onfocus="textFocus.call(this)" onblur="textBlur.call(this)" onchange="textChange()"><?php echo unescape_lang($locales[$to][$file][$key]) ?></textarea></td> <?php
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
				$remaining = min($start, $pagesize); ?>
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
			$remaining = min(array($pagesize, $count - $nextstart));
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