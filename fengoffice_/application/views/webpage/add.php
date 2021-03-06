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

<?php 
  set_page_title($webpage->isNew() ? lang('add webpage') : lang('edit webpage'));
  $project = active_or_personal_project();
  $projects =  active_projects();
  if (!$webpage->isNew()) 
  	add_page_action(lang('delete webpage'), "javascript:if(confirm(lang('confirm delete webpage'))) og.openLink('" . $webpage->getDeleteUrl()."');", 'ico-delete');
?>

<form style='height:100%;background-color:white' class="internalForm" action="<?php echo $webpage->isNew() ? get_url('webpage', 'add') : $webpage->getEditUrl() ?>" method="post">

<div class="webpage">
<div class="coInputHeader">
	<div class="coInputHeaderUpperRow">
	<div class="coInputTitle"><table style="width:535px">
	<tr><td><?php echo $webpage->isNew() ? lang('new webpage') : lang('edit webpage') ?>
	</td><td style="text-align:right"><?php echo submit_button($webpage->isNew() ? lang('add webpage') : lang('save changes'),'s',array('style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	
	</div>
	<div>
		<?php echo label_tag(lang('title'), 'webpageFormTitle', true) ?>
   		<?php echo text_field('webpage[title]', array_var($webpage_data, 'title'), array('class' => 'title', 'tabindex' => '1', 'id' => 'webpageFormTitle')) ?>
  	</div>
	
	<div style="padding-top:5px">
		<?php if (isset ($projects) && count($projects) > 0) { ?>
			<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('add_webpage_select_workspace_div', this)"><?php echo lang('workspace') ?></a> - 
		<?php } ?>
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('add_webpage_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('add_webpage_description_div', this)"><?php echo lang('description') ?></a> - 
		<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('add_webpage_properties_div', this)"><?php echo lang('properties') ?></a>
		<?php if($webpage->isNew() || $webpage->canLinkObject(logged_user(), $project)) { ?> - 
			<a href="#" class="option" tabindex=0 onclick="og.toggleAndBolden('add_webpage_linked_objects_div', this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">


    <div id="add_webpage_select_workspace_div" style="display:none">
	<fieldset>
	<legend><?php echo lang('workspace') ?></legend>
		<?php echo select_project('webpage[project_id]', $projects, array_var($webpage_data, 'project_id')) ?>
	</fieldset>
    </div>
  
    <div id="add_webpage_tags_div" style="display:none">
    <fieldset>
    <legend>
    	<?php echo lang('tags') ?></legend>
		<?php echo autocomplete_textfield("webpage[tags]", array_var($webpage_data, 'tags'), 'allTags', array('class' => 'long')); ?>
	</fieldset>
	</div>

	<div id="add_webpage_description_div" style="display:none">
	<fieldset>
	<legend>
		<?php echo label_tag(lang('description'), 'webpageFormDesc') ?> </legend>
    	<?php echo textarea_field('webpage[description]', array_var($webpage_data, 'description'), array('class' => 'short', 'id' => 'webpageFormDesc')) ?>
    </fieldset>
	</div>
  
	<div id='add_webpage_properties_div' style="display:none">
	<fieldset>
	<legend><?php echo lang('properties') ?></legend>
		<?php echo render_object_properties('webpage', $webpage); ?>
	</fieldset>
	</div>
  
  
 <?php if($webpage->isNew() || $webpage->canLinkObject(logged_user(), $project)) { ?>
 <div style="display:none" id="add_webpage_linked_objects_div">
<fieldset>
    <legend><?php echo lang('linked objects') ?></legend>
  	  <table style="width:100%;margin-left:2px;margin-right:3px" id="tbl_linked_objects">
	   	<tbody></tbody>
		</table>
    <?php echo render_object_links($webpage, $webpage->canEdit(logged_user())) ?>
</fieldset>
</div>
<?php } // if ?>

  <div>
    <?php echo label_tag(lang('url'), 'webpageFormURL', true) ?>
    <?php echo text_field('webpage[url]', array_var($webpage_data, 'url'), array('class' => 'title', 'tabindex' => '2', 'id' => 'webpageFormURL')) ?>
  </div>
  
  <?php echo submit_button($webpage->isNew() ? lang('add webpage') : lang('save changes'), 's', 
  	array('tabindex' => '3')) ?>
  </div>
 </div>
</form>

<script type="text/javascript">
	Ext.get('webpageFormTitle').focus();
</script>