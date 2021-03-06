<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
  <title><?php echo $installation_name ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <link rel="stylesheet" href="assets/style.css" media="all" />
</head>
<body>
  <div id="wrapper">

    <div id="warning" style="border: 2px solid red; background-color: lightYellow; width: 675px; font-family: Verdana, sans-serif; font-size: 14px; padding: 10px; font-weight: bold;">
      <u>Warning:</u> This software is in beta stage, which means that it is not yet a final version of the product, and thus may contain unresolved errors or unimplemented features.
    </div>
    <br/>
	
    <div id="header">
      <h1><?php echo $installation_name ?></h1>
      <div id="installationDesc"><?php echo clean($installation_description) ?></div>
    </div>
    <form class="internalForm" action="<?php echo $current_step->getStepUrl() ?>" id="installerForm" method="post">
      <?php $this->includeTemplate(get_template_path('__step_errors.php')) ?>
      <div id="content"><?php echo $content_for_layout ?></div>
      <?php $this->includeTemplate(get_template_path('__step_controls.php')) ?>
      <input type="hidden" name="submited" value="submited" />
    </form>
    <div id="footer">&copy; <?php echo date('Y') ?> <a href="http://www.OpenGoo.org/">OpenGoo</a>. All rights reserved.</div>
  </div>

</body>
</html>