<h1 class="pageTitle"><span>Step <?php echo $current_step->getStepNumber() ?>:</span> Welcome</h1>
<p>OpenGoo is a free collaboration and project management system which includes a web office. OpenGoo is:</p>
<ul>
  <li><strong>Easy to use</strong> - basic set of tools that just work</li>
  <li><strong>Easy to install</strong> - here you are, just follow the instructions</li>
  <li><strong>100% free</strong> - free for all, even for commercial use</li>
  <li><strong>Web based</strong> - after installation the only thing you'll need is a web browser</li>
</ul>

<h2>Installation steps:</h2>
<ol>
<?php foreach($installer->getSteps() as $this_step) { ?>
  <li><?php echo clean($this_step->getName()) ?></li>
<?php } // foreach ?>
</ol>
<p>You should be done in a minute or two.</p>