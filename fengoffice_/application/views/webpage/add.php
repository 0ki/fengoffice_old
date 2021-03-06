<?php 
  set_page_title($webpage->isNew() ? lang('add webpage') : lang('edit webpage'));
  if (!$webpage->isNew()) 
  	add_page_action(lang('delete webpage'), $webpage->getDeleteUrl(), 'ico-delete');
?>

<form class="internalForm" action="<?php echo $webpage->isNew() ? get_url('webpage', 'add') : $webpage->getEditUrl() ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('title'), 'webpageFormTitle', true) ?>
    <?php echo text_field('webpage[title]', array_var($webpage_data, 'title'), array('class' => 'long', 'id' => 'webpageFormTitle')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('url'), 'webpageFormURL', true) ?>
    <?php echo textarea_field('webpage[url]', array_var($webpage_data, 'url'), array('class' => 'short', 'id' => 'webpageFormURL')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('description'), 'webpageFormDesc') ?>
    <?php echo textarea_field('webpage[description]', array_var($webpage_data, 'description'), array('class' => 'short', 'id' => 'webpageFormDesc')) ?>
  </div>
  
	<fieldset>
	<legend class="toggle_collapsed" onclick="og.toggle('add_webpage_project_div',this)"><?php echo lang('workspace') ?></legend>
	<?php echo select_project('webpage[project_id]', active_projects(), array_var($webpage_data, 'project_id'), array('id'=>'add_webpage_project_div', 'style' => 'display:none')) ?>
	</fieldset>
<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
   <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_webpage_options_div',this)"><?php echo lang('properties') ?></legend>
 
  <div id="add_webpage_options_div" style="display:none">
    <label><?php echo lang('private webpage') ?>: <span class="desc">(<?php echo lang('private webpage desc') ?>)</span></label>
    <?php echo yes_no_widget('webpage[is_private]', 'webpageFormIsPrivate', array_var($webpage_data, 'is_private'), lang('yes'), lang('no')) ?>
	  <? echo render_object_properties('webpage',$webpage); ?>
  </div>
  </fieldset>
<?php } // if ?>
  
  <!--div class="formBlock">
    <?php //echo label_tag(lang('tags'), 'webpageFormTags') ?>
    <?php //echo show_project_tags_option(active_or_personal_project(), 'allTagsCombo', array('id' => 'allTagsCombo','style'=> 'width:100px'));
    	// echo show_addtag_button('allTagsCombo','webpageFormTags',array('style'=> 'width:20px')); ?>
    <?php // echo project_object_tags_widget('webpage[tags]', active_or_personal_project(), array_var($webpage_data, 'tags'), array('id' => 'webpageFormTags', 'class' => 'long')) ?>
  </div-->
    <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_webpage_tags_div',this)"><?php echo lang('tags') ?></legend>
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
	<?php echo autocomplete_textfield("webpage[tags]", array_var($webpage_data, 'tags'), 'allTags', array('id'=>'add_webpage_tags_div', 'style'=>'display:none', 'class' => 'long')); ?>
</fieldset>

 <?php if(!$webpage->isNew() && $webpage->canLinkObject(logged_user(), active_or_personal_project())) { ?>
<fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_webpage_linked_objects_div',this)"><?php echo lang('linked objects') ?></legend>
    <div style="display:none" id="add_webpage_linked_objects_div">
    <?php echo render_object_links($webpage, $webpage->canEdit(logged_user())) ?>
</div>
</fieldset>
<?php } // if ?>

  <?php echo submit_button($webpage->isNew() ? lang('add webpage') : lang('edit webpage')) ?>
</form>