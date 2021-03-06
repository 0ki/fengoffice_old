<?php
  	if ($file->isNew()){
		$submit_url = get_url('files', 'add_file');
	} else if (isset($checkin) && $checkin){
		$submit_url = $file->getCheckinUrl();
	} else {
		$submit_url = $file->getEditUrl();
	}
	
	$project = active_or_personal_project();
	$projects =  active_projects();
	
	$enableUpload = $file->isNew() 
	|| (isset($checkin) && $checkin) || ($file->getCheckedOutById() == 0 && logged_user()->isAdministrator()) 
	|| ($file->getCheckedOutById() == logged_user()->getId()); 
	$genid = gen_id();
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>


<form style='height:100%;background-color:white' id="<?php echo $genid ?>addfile" name="<?php echo $genid ?>addfile" action="<?php echo $submit_url ?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
  <?php tpl_display(get_template_path('form_errors'));?>
  <input id="<?php echo $genid ?>hfFileIsNew" type="hidden" value="<?php echo $file->isNew()?>">
  <input id="<?php echo $genid ?>hfAddFileAddType" name='file[add_type]' type="hidden" value="regular">
  <input id="<?php echo $genid ?>hfFileId" name='file[file_id]' type="hidden" value="<?php echo array_var($file_data, 'file_id') ?>">
  <input id="<?php echo $genid ?>hfEditFileName" name='file[edit_name]' type="hidden" value="<?php echo array_var($file_data, 'edit_name') ?>">
    

<div class="file">
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
<div class="coInputTitle"><table style="width:535px"><tr><td><?php echo $file->isNew() ? lang('upload file') : (isset($checkin) ? lang('checkin file') : lang('file properties')) ?>
	</td><td style="text-align:right"><?php echo submit_button($file->isNew() ? lang('add file') : (isset($checkin) ? lang('checkin file') : lang('save changes')),'s',array("onclick" => 'javascript:submitMe(\'' . $genid .'\')', 'style'=>'margin-top:0px;margin-left:10px','id' => $genid.'add_file_submit1')) ?></td></tr></table>
	</div>
	</div>
	<?php if ($enableUpload) { 
		if ($file->isNew()) {?>
		
    <div id="<?php echo $genid ?>selectFileControlDiv">
        <?php echo label_tag(lang('file'), $genid . 'fileFormFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => $genid . 'fileFormFile', 'class' => 'title', 'size' => '88', 'onchange' => 'javascript:og.updateFileName(\'' . $genid .  '\');og.checkFileName(\'' . $genid .  '\',this.value)')) ?>
    	<p><?php echo lang('upload file desc', format_filesize(get_max_upload_size())) ?></p>
    </div>
    <?php }} // if ?>
    
    
    
    <div id="<?php echo $genid ?>addFileFilename" style="<?php echo $file->isNew()? 'display:none' : '' ?>">
      	<?php echo label_tag(lang('new filename'), $genid .'fileFormFilename') ?>
        <?php echo text_field('file[name]',$file->getFilename(), array("id" => $genid .'fileFormFilename',  'onblur' => 'javascript:og.onBlurFileName()', 'onchange' => ('javascript:og.checkFileName(\'' . $genid .  '\',this.value)'))) ?>
		<br/>
    </div>
      
	
	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_file_select_workspace_div',this)"><?php echo lang('workspace') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_file_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_file_description_div',this)"><?php echo lang('description') ?></a> -
  		<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_file_options_div',this)"><?php echo lang('options') ?></a> -
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_file_properties_div',this)"><?php echo lang('properties') ?></a>
  		<?php if($file->isNew() || $file->canLinkObject(logged_user())) { ?> -
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>add_file_linked_objects_div',this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">



<?php if ($enableUpload) { ?>
  <?php if($file->isNew()) { //----------------------------------------------------ADD   ?>
    <div class="content">
      <div id="<?php echo $genid ?>addFileFilenameCheck" style="display:none">
  		<h2><?php echo lang("checking filename") ?></h2>
	  </div>
      
      <div id="<?php echo $genid ?>addFileFilenameExists" style="display:none">
      	<h2><?php echo lang("duplicate filename")?></h2>
      	<p><?php echo lang("filename exists") ?></p>
      	
      	<div style="padding-top:10px">
      	<table ><tr>
      	  <td style="height:20px;padding-right:4px">
      	    <?php echo radio_field('file[upload_option]',true, array("id" => $genid . 'radioAddFileUploadAnyway', "value" => -1)) ?>
      	  </td><td>
      	    <?php echo lang('upload anyway')?>
		  </td></tr>
		</table>
		<table id="<?php echo $genid ?>upload-table">
		</table>
		</div>
      </div>
    </div>
    
   <?php }  else {//----------------------------------------------------------------EDIT?>
    <div class="content">
    <?php if (!isset($checkin)) {?>
      
    
      <div class="header">
    	<?php echo checkbox_field('file[update_file]', array_var($file_data, 'update_file'), array('class' => 'checkbox', 'id' => $genid . 'fileFormUpdateFile', 'onclick' => 'App.modules.addFileForm.updateFileClick(\'' . $genid .'\')')) ?> <?php echo label_tag(lang('update file'), $genid .'fileFormUpdateFile', false, array('class' => 'checkbox'), '') ?>
      </div>
      <div id="<?php echo $genid ?>updateFileDescription">
        <p><?php echo lang('replace file description') ?></p>
      </div>
      <?php } // if ?>
      <div id="<?php echo $genid ?>updateFileForm"  style="<?php echo isset($checkin) ? '': 'display:none' ?>">
        <p><strong><?php echo lang('existing file') ?>:</strong> <a target="_blank" href="<?php echo $file->getDownloadUrl() ?>"><?php echo clean($file->getFilename()) ?></a> | <?php echo format_filesize($file->getFilesize()) ?></p>
        <div>
          <?php echo label_tag(lang('new file'), $genid.'fileFormFile', true) ?>
          <?php echo file_field('file_file', null, array('id' => $genid.'fileFormFile')) ?>
        </div>
        <div id="<?php echo $genid ?>revisionControls">
          <div>
            <?php echo checkbox_field('file[version_file_change]', array_var($file_data, 'version_file_change', true), array('id' => $genid.'fileFormVersionChange', 'class' => 'checkbox', 'onclick' => 'App.modules.addFileForm.versionFileChangeClick(\'' . $genid .'\')')) ?> <?php echo label_tag(lang('version file change'), 'fileFormVersionChange', false, array('class' => 'checkbox'), '') ?>
          </div>
          <div id="<?php echo $genid ?>fileFormRevisionCommentBlock">
            <?php echo label_tag(lang('revision comment'), $genid.'fileFormRevisionComment') ?>
            <?php echo textarea_field('file[revision_comment]', array_var($file_data, 'revision_comment'), array('class' => 'short')) ?>
          </div>
        </div>
      </div>
    <?php if (!isset($checkin)) {?>
      <script type="text/javascript">
        App.modules.addFileForm.updateFileClick('<?php echo $genid ?>');
        App.modules.addFileForm.versionFileChangeClick('<?php echo $genid ?>');
      </script>
      <?php } // if ?>
    </div>
<?php } // if ?>
<?php } // if enableupload ?> 



 <div id="<?php echo $genid ?>add_file_select_workspace_div" style="display:none">
 <fieldset >
    <legend><?php echo lang('workspace') ?></legend>
	  <?php if ($file->isNew()) {
			echo select_workspaces('ws_ids', $projects, array($project), $genid.'ws_ids');
		} else {
			echo select_workspaces('ws_ids', $projects, $file->getWorkspaces(), $genid.'ws_ids');
		} ?>
	  
	  <?php if (!$file->isNew()) {?>
	    <div id="<?php echo $genid ?>addFileFilenameCheck" style="display:none">
  		  <h2><?php echo lang("checking filename") ?></h2>
	    </div>
        <div id="<?php echo $genid ?>addFileFilenameExists" style="display:none">
          <h2><?php echo lang("duplicate filename")?></h2>
      	  <?php echo lang("filename exists edit") ?>
        </div>
      <?php } // if ?>
  </fieldset>
  </div>
  
  <div id="<?php echo $genid ?>add_file_tags_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('tags') ?></legend>
    <?php echo autocomplete_textfield("file[tags]", array_var($file_data, 'tags'), Tags::getTagNames(), lang("enter tags desc"), array("class" => "long")); ?>
  </fieldset> 
  </div>
  
  
  <div id="<?php echo $genid ?>add_file_description_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('description') ?></legend>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => $genid.'fileFormDescription')) ?>
  </fieldset>
  </div>

  
  <?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
  <div id="<?php echo $genid ?>add_file_options_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
  		<?php /* <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('private file') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[is_private]', 'fileFormIsPrivate', array_var($file_data, 'is_private'), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('private file desc') ?></div>
	    </div>
	    
	    <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('important file') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[is_important]', 'fileFormIsImportant', array_var($file_data, 'is_important'), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('important file desc') ?></div>
	    </div>
	    */ ?>
	    <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[comments_enabled]', $genid.'fileFormEnableComments', array_var($file_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
	    </div>
	    
	    <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[anonymous_comments_enabled]', $genid.'fileFormEnableAnonymousComments', array_var($file_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
	    </div>
  </fieldset>
  </div>
  <?php } // if ?>

  <div id="<?php echo $genid ?>add_file_properties_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('properties') ?></legend>
      <?php echo render_object_properties('file',$file); ?>
  </fieldset>
  </div>
  
  <?php if($file->isNew() || $file->canLinkObject(logged_user())) { ?>
  <div style="display:none" id="<?php echo $genid ?>add_file_linked_objects_div">
  <fieldset>
    <legend><?php echo lang('linked objects') ?></legend>
  	  <table style="width:100%;margin-left:2px;margin-right:3px" id="<?php echo $genid ?>tbl_linked_objects">
	   	<tbody></tbody>
		</table>
      <?php echo render_object_links($file, $file->canEdit(logged_user())) ?>
  </fieldset>
  </div>
  <?php } // if ?>
  

  <div id="<?php echo $genid ?>fileSubmitButton" style="display:inline">
  <input type="hidden" name="upload_id" value="<?php echo $genid ?>" />
  <?php 
  if (!$file->isNew())  //Edit file
  	if (isset($checkin) && $checkin)
	  echo submit_button(lang('checkin file'),'s',array("id" => $genid.'add_file_submit2', "onclick" => 'javascript:submitMe(\'' . $genid .'\')'));
	else
	  echo submit_button(lang('save changes'),'s',array("id" => $genid.'add_file_submit2', "onclick" => 'javascript:submitMe(\'' . $genid .'\')'));
  else //New file
    echo submit_button(lang('add file'),'s',array("id" => $genid.'add_file_submit2', "onclick" => 'javascript:submitMe(\'' . $genid .'\')'));
  ?>
  </div>
  
</div>
</div>
</form>
