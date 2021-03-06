<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>[slide show title here]</title>
<!-- metadata -->
<meta name="generator" content="S5" />
<meta name="version" content="S5 1.1" />
<meta name="presdate" content="20050728" />
<meta name="author" content="Eric A. Meyer" />
<meta name="company" content="Complex Spiral Consulting" />
<!-- configuration parameters -->
<meta name="defaultView" content="slideshow" />
<meta name="controlVis" content="hidden" />
<!-- style sheet links -->

<link rel="stylesheet" href="ui/default/slides.css" type="text/css" media="projection" id="slideProj" />
<link rel="stylesheet" href="ui/default/outline.css" type="text/css" media="screen" id="outlineStyle" />
<link rel="stylesheet" href="ui/default/print.css" type="text/css" media="print" id="slidePrint" />
<link rel="stylesheet" href="ui/default/opera.css" type="text/css" media="projection" id="operaFix" />
<!-- S5 JS -->
<script src="ui/default/slides.js" type="text/javascript"></script>
</head>
<body>

<!--
<?php session_start(); ?>
-->
<div class="layout">
<div id="controls"><!-- DO NOT EDIT --></div>
<div id="currentSlide"><!-- DO NOT EDIT --></div>
<div id="header"></div>
<div id="footer">
<h1>[location/date of presentation]</h1>

<h2>[slide show title here]</h2>
</div>

</div>


<div class="presentation">

<?php 
echo $_SESSION["s5content"];
?>


</div>

</body>
</html>
