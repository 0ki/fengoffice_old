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
<script type="text/javascript">
    	var allTags = [<?php
    		$coma = false;
    		$tags = Tags::getTagNames();
    		if($tags){
	    		foreach ($tags as $tag) {
	    			if ($coma) {
	    				echo ",";
	    			} else {
	    				$coma = true;
	    			}
	    			echo "'" . $tag . "'";
	    		}//foreach
    		} //if
    	?>];
    </script>
    <form id='formClassify' name='formClassify' style='height:100%;background-color:white'  class="internalForm" action="<?php echo get_url('mail','classify', array('id'=>$email->getId())) ?>" method="post">
    
<div class="emailClassify">
  <div class="coInputHeader">
  <div class="coInputHeaderUpperRow">
  	<div class="coInputTitle"><?php echo lang('classify email subject', $email->getSubject()) ?></div>
  </div>
  </div>
  
  
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">

  <fieldset>
<legend><?php echo lang('project') ?></legend>
<?php echo select_project('classification[project_id]', $projects, array_var($classification_data, 'project_id'), array('id' => 'classifyFormProject')); ?>
<?php echo label_tag(lang('tags')) ?>
	<?php echo autocomplete_textfield("classification[tag]", array_var($classification_data, 'tag'), 'allTags', array('id'=>'ProjectTagsFS', 'class' => 'long')); ?>
</fieldset>
   
   <?php if ($email->getHasAttachments()) {?>
   <fieldset>
   <legend><?php echo lang('add attachments to project') ?></legend>
   <?php 
   $c = 0;
   foreach($parsedEmail["Attachments"] as $att) { 
   	    $fName = iconv_mime_decode($att["FileName"], 0, "UTF-8");
   		echo checkbox_field('classification[att_'.$c.']', true, array('id' => 'classifyFormAddAttachment'.$c));?>
    <label for="<?php echo 'classifyFormAddAttachment'.$c ?>" class="yes_no"><?php echo $fName ?></label>
    <?php $c++;
   }?>
   </fieldset>
<?php } ?>

<?php echo submit_button(lang('classify email')) ?>
  </div>
</div>
</form>