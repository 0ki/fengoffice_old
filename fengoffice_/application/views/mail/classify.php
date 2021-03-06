<script type="text/javascript">
function showProjectTagsDiv()
{
	var sel = document.getElementById('classifyFormProject');
	for (var i = 1; i < sel.options.length; i++)
	{
		var div = document.getElementById('ProjectTags'+sel.options[i].value);
		div.style.display =sel.options[i].selected? 'inline':'none';
	} 
}
</script>

<div id="divClassify">
<form id='formClassify' name='formClassify' class="internalForm" action="<?php echo get_url('mail','classify', array('id'=>$email->getId())) ?>" method="post">

<h2><?php echo lang('classify email subject', $email->getSubject()) ?></h2>

<fieldset>
<legend><?php echo lang('project') ?></legend>
<?php echo select_project('classification[project_id]', $projects, array_var($classification_data, 'project_id'), array('id' => 'classifyFormProject', 'onChange' => 'showProjectTagsDiv()')); ?>
</fieldset>

<?php foreach($projects as $project) {?>
<div id="ProjectTags<?php echo $project->getId()?>" style="display:none">
<fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('ProjectTagsFS<?php echo $project->getId() ?>',this)"><?php echo lang('tags') ?></legend>
    <script type="text/javascript">
    	var allTags = [<?php
    		$coma = false;
    		$tags = Tags::getTagNames();
    		foreach ($tags as $tag) {
    			if ($coma) {
    				echo ",";
    			} else {
    				$coma = true;
    			}
    			echo "'" . $tag . "'";
    		}
    	?>];
    </script>
	<?php echo autocomplete_textfield("classification[tag_".$project->getId()."]", array_var($classification_data, 'tag_'. $project->getId()), 'allTags', array('id'=>'ProjectTagsFS'.$project->getId(), 'style'=>'display:none', 'class' => 'long')); ?>
  </fieldset>
   </div>
   <?php } ?> 
   
   <?php if ($email->getHasAttachments()) {?>
   <fieldset>
   <legend><?php echo lang('add attachments to project') ?></legend>
   <?php 
   $c = 0;
   foreach($parsedEmail["Attachments"] as $att) { 
   		echo checkbox_field('classification[att_'.$c.']', true, array('id' => 'classifyFormAddAttachment'.$c));?>
    <label for="<?php echo 'classifyFormAddAttachment'.$c ?>" class="yes_no"><?php echo $att["FileName"] ?></label>
    <?php $c++;
   }?>
   </fieldset>
<?php } ?>

<?php echo submit_button(lang('classify email')) ?>
</form>
</div>