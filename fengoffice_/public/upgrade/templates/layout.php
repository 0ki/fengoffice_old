<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
  <title><?php echo clean($upgrader->getName()) ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <link rel="stylesheet" href="assets/style.css" media="all" />
</head>
<body>
  <div id="wrapper">
    <div id="header">
      <h1><?php echo clean($upgrader->getName()) ?></h1>
      <div id="installationDesc"><?php echo clean($upgrader->getDescription()) ?></div>
    </div>
<?php
$installed_version = installed_version();
$scripts = $upgrader->getScriptsSince($installed_version);
if (count($scripts) > 0) {
?>
    <form class="internalForm" action="index.php" id="upgraderForm" method="post">
      <div id="upgraderControls">
        <table class="formBlock">
          <tr>
            <th colspan="2">Upgrade</th>
          </tr>
<?php if ($installed_version == "unknown") { ?>
          <tr>
            <td class="optionLabel"><label for="upgradeFormFrom">Upgrade from: </label></td>
            <td>
              <select name="form_data[upgrade_from]" id="upgradeFormFrom">
	<?php foreach($scripts as $script) { ?>
                <option <?php if ($script->getVersionTo() == "1.2") echo 'selected="selected"'; ?> value="<?php echo clean($script->getVersionFrom()) ?>">OpenGoo <?php echo clean($script->getVersionFrom()) ?></option>
	<?php } // foreach ?>
              </select>
            </td>
          </tr>
<?php } else { ?>
		<tr>
			<td class="optionLabel"><label>Upgrade from: </label></td>
			<td>
				<input name="form_data[upgrade_from]" type="hidden" value="<?php echo $installed_version ?>" />
				<?php echo $installed_version ?></td>
		</tr>
<?php } ?>
          <tr>
            <td class="optionLabel"><label for="upgradeFormTo">Upgrade to: </label></td>
            <td>
              <select name="form_data[upgrade_to]" id="upgradeFormTo">
	<?php foreach($scripts as $script) { ?>
                <option <?php if ($script->getVersionTo() == "1.2") echo 'selected="selected"'; ?> value="<?php echo clean($script->getVersionTo()) ?>">OpenGoo <?php echo clean($script->getVersionTo()) ?></option>
	<?php } // foreach ?>
              </select>
            </td>
          </tr>
        </table>
        <button type="submit" accesskey="s">Upgrade (Alt+S)</button>
      </div>
      <input type="hidden" name="submited" value="submited" />
    </form>
<?php } else { ?>
	<div style="padding: 20px">You already have upgraded to the latest possible version.</div>
<?php } ?>
      <div id="content">
<?php if(isset($status_messages) && count($status_messages)) { ?>
        <ul>
<?php foreach($status_messages as $status_message) { ?>
          <li><?php echo $status_message ?></li>
<?php } // foreach ?>
        </ul>
<?php } // if ?>
      </div>

	<div class="back"><a href="../../">Back to OpenGoo</a></div>
    <div id="footer">&copy; <?php echo date('Y') ?> <a href="http://www.OpenGoo.org/">OpenGoo</a>. All rights reserved.</div>
  </div>

</body>
</html>