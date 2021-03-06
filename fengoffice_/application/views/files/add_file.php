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
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>


<form style='height:100%;background-color:white' name="addFileForm" action="<?php echo $submit_url ?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
  <?php tpl_display(get_template_path('form_errors'));?>
  <input id="hfExistingFileId" name='file[existing_file_id]' type="hidden" value="0">
  <input id="hfFileIsNew" type="hidden" value="<?php echo $file->isNew()?>">
  <input id="hfAddFileAddType" name='file[add_type]' type="hidden" value="regular">
  <input id="fileFormNewFilenameH" type="hidden"/>
  <input id="fileFormFilenameH" type="hidden"/>
  <input id="hfFileId" name='file[file_id]' type="hidden" value="<?php echo array_var($file_data, 'file_id') ?>">
  <input id="hfEditFileName" name='file[edit_name]' type="hidden" value="<?php echo array_var($file_data, 'edit_name') ?>">
    

<div class="file">
<div class="coInputHeader">
<div class="coInputHeaderUpperRow">
<div class="coInputTitle"><table style="width:535px"><tr><td><?php echo $file->isNew() ? lang('upload file') : (isset($checkin) ? lang('checkin file') : lang('file properties')) ?>
	</td><td style="text-align:right"><?php echo submit_button($file->isNew() ? lang('add file') : (isset($checkin) ? lang('checkin file') : lang('save changes')),'s',array("onclick" => 'javascript:submitMe(document.addFileForm)', 'style'=>'margin-top:0px;margin-left:10px')) ?></td></tr></table>
	</div>
	</div>
	<?php if ($enableUpload) { 
		if ($file->isNew()) {?>
		
    <div id="selectFileControlDiv">
        <?php echo label_tag(lang('file'), 'fileFormFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => 'fileFormFile', 'class' => 'title', 'onchange' => 'javascript:updateFileName();checkFileName()')) ?>
    	<p><?php echo lang('upload file desc', format_filesize(get_max_upload_size())) ?></p>  
    </div>
    <?php }} // if ?>
    
    
    
    <div id="addFileFilenameDNX" style="display:none">
      	<?php echo label_tag(lang('new filename'), 'fileFormFilename') ?>
        <?php echo text_field('file[name]',$file->getFilename(), array("id" => 'fileFormFilename', 'onchange' => 'javascript:checkFileName(this.value)')) ?>
		<br/>
    </div>
      
	
	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('add_file_select_workspace_div',this)"><?php echo lang('workspace') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_file_tags_div', this)"><?php echo lang('tags') ?></a> - 
		<a href="#" class="option" onclick="og.toggleAndBolden('add_file_description_div',this)"><?php echo lang('description') ?></a> -
  		<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('add_file_options_div',this)"><?php echo lang('options') ?></a> -
		<?php } ?>
		<a href="#" class="option" onclick="og.toggleAndBolden('add_file_properties_div',this)"><?php echo lang('properties') ?></a>
  		<?php if(!$file->isNew() && $file->canLinkObject(logged_user())) { ?> -
			<a href="#" class="option" onclick="og.toggleAndBolden('add_file_linked_objects_div',this)"><?php echo lang('linked objects') ?></a>
		<?php } ?>
	</div>
</div>
<div class="coInputSeparator"></div>
<div class="coInputMainBlock">



<?php if ($enableUpload) { ?>
  <?php if($file->isNew()) { //----------------------------------------------------ADD   ?>
    <div class="content">
      <div id="addFileFilenameCheck" style="display:none">
  		<h2><?php echo lang("checking filename") ?></h2>
	  </div>
      
      <div id="addFileFilenameExists" style="display:none">
      	<h2><?php echo lang("duplicate filename")?></h2>
      	<p><?php echo lang("filename exists") ?></p>
      	
      	<div id="addFileExistingFileInfo"></div>
      	
      	<table><tr>
      	  <td style="padding-top:5px;padding-right:5px">
      	    <?php echo radio_field('file[new_filename_check]',true, array("id" => 'radioAddFileNewName', "value" => "true")) ?>
      	  </td><td>
      	    <?php echo label_tag(lang('new filename'), 'fileFormNewFilename') ?>
            <?php echo text_field('file[new_filename]', array_var($file_data, 'new_filename'),array('id' => 'fileFormNewFilename',
         	  'onchange' => 'javascript:checkFileName(this.value)')) ?>
		  </td></tr>
		  <tr><td>
		    <?php echo radio_field('file[new_filename_check]', false, array("value" => "false"))?>
      	  </td><td>
      		<div id="fileNotCheckedOut" style="display:none">
      			<?php echo label_tag(lang('add as revision'), 'fileFormCheckAddRevision', false,null,'')  ?>
      		</div>
      		<div id="fileCheckedOutPermission" style="display:none">
      			<?php echo label_tag(lang('add file check in'), 'fileFormCheckInAddRevision', false,null,'')  ?>
      		</div>
      		<div id="fileCheckedOut" style="display:none">
      		</div>
      		<div id="fileCheckedOutNoPermission" style="display:none">
      			<?php echo lang("no permission to check in") ?>
      		</div>
		  </td></tr>
		</table>
      </div>
    </div>
    
   <?php }  else {//----------------------------------------------------------------EDIT
	if (!isset($checkin)) {?>
      <div class="header">
    	<?php echo checkbox_field('file[update_file]', array_var($file_data, 'update_file'), array('class' => 'checkbox', 'id' => 'fileFormUpdateFile', 'onclick' => 'App.modules.addFileForm.updateFileClick()')) ?> <?php echo label_tag(lang('update file'), 'fileFormUpdateFile', false, array('class' => 'checkbox'), '') ?>
      </div>
    <?php } // if ?>
    <div class="content">
    <?php if (!isset($checkin)) {?>
    
      <div id="updateFileDescription">
        <p><?php echo lang('replace file description') ?></p>
      </div>
      <?php } // if ?>
      <div id="updateFileForm"  style="<?php echo isset($checkin) ? '': 'display:none' ?>">
        <p><strong><?php echo lang('existing file') ?>:</strong> <a target="_blank" href="<?php echo $file->getDownloadUrl() ?>"><?php echo clean($file->getFilename()) ?></a> | <?php echo format_filesize($file->getFilesize()) ?></p>
        <div>
          <?php echo label_tag(lang('new file'), 'fileFormFile', true) ?>
          <?php echo file_field('file_file', null, array('id' => 'fileFormFile')) ?>
        </div>
        <div id="revisionControls">
          <div>
            <?php echo checkbox_field('file[version_file_change]', array_var($file_data, 'version_file_change', true), array('id' => 'fileFormVersionChange', 'class' => 'checkbox', 'onclick' => 'App.modules.addFileForm.versionFileChangeClick()')) ?> <?php echo label_tag(lang('version file change'), 'fileFormVersionChange', false, array('class' => 'checkbox'), '') ?>
          </div>
          <div id="fileFormRevisionCommentBlock">
            <?php echo label_tag(lang('revision comment'), 'fileFormRevisionComment') ?>
            <?php echo textarea_field('file[revision_comment]', array_var($file_data, 'revision_comment'), array('class' => 'short')) ?>
          </div>
        </div>
      </div>
    <?php if (!isset($checkin)) {?>
      <script type="text/javascript">
        App.modules.addFileForm.updateFileClick();
        App.modules.addFileForm.versionFileChangeClick();
      </script>
      <?php } // if ?>
    </div>
<?php } // if ?>
<?php } // if enableupload ?> 



 <div id="add_file_select_workspace_div" style="display:none">
 <fieldset >
    <legend><?php echo lang('workspace') ?></legend>
	  <?php if ($file->isNew()) {
			echo select_workspaces('ws_ids', $projects, array($project), 'ws_ids');
		} else {
			echo select_workspaces('ws_ids', $projects, $file->getWorkspaces(), 'ws_ids');
		} ?>
	  
	  <?php if (!$file->isNew()) {?>
	    <div id="addFileFilenameCheck" style="display:none">
  		  <h2><?php echo lang("checking filename") ?></h2>
	    </div>
        <div id="addFileFilenameExists" style="display:none">
          <h2><?php echo lang("duplicate filename")?></h2>
      	  <?php echo lang("filename exists edit") ?>
        </div>
      <?php } // if ?>
  </fieldset>
  </div>
  
  <div id="add_file_tags_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('tags') ?></legend>
    <script type="text/javascript">
    	var allTags = [<?php
    		$coma = false;
    		$tags = Tags::getTagNames();
    		if (is_array($tags))
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
	<?php echo autocomplete_textfield("file[tags]", array_var($file_data, 'tags'), 'allTags', array('id'=>'add_file_tags_div', 'class' => 'long')); ?>
  </fieldset> 
  </div>
  
  
  <div id="add_file_description_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('description') ?></legend>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </fieldset>
  </div>

  
  <?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
  <div id="add_file_options_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
  		<div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('private file') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[is_private]', 'fileFormIsPrivate', array_var($file_data, 'is_private'), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('private file desc') ?></div>
	    </div>
	    
	    <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('important file') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[is_important]', 'fileFormIsImportant', array_var($file_data, 'is_important'), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('important file desc') ?></div>
	    </div>
	    
	    <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[comments_enabled]', 'fileFormEnableComments', array_var($file_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
	    </div>
	    
	    <div class="objectOption">
	      <div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
	      <div class="optionControl"><?php echo yes_no_widget('file[anonymous_comments_enabled]', 'fileFormEnableAnonymousComments', array_var($file_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
	      <div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
	    </div>
  </fieldset>
  </div>
  <?php } // if ?>

  <div id="add_file_properties_div" style="display:none">
  <fieldset>
    <legend><?php echo lang('properties') ?></legend>
      <? echo render_object_properties('file',$file); ?>
  </fieldset>
  </div>
  
  <?php if(!$file->isNew() && $file->canLinkObject(logged_user())) { ?>
  <div style="display:none" id="add_file_linked_objects_div">
  <fieldset>
    <legend><?php echo lang('linked objects') ?></legend>
      <?php echo render_object_links($file, $file->canEdit(logged_user())) ?>
  </fieldset>
  </div>
  <?php } // if ?>
  

  <div id="fileSubmitButton" style="display:inline">
  <?php 
  if (!$file->isNew())  //Edit file
  	if (isset($checkin) && $checkin)
	  echo submit_button(lang('checkin file'),'s',array("onclick" => 'javascript:submitMe(document.addFileForm)'));
	else
	  echo submit_button(lang('save changes'),'s',array("onclick" => 'javascript:submitMe(document.addFileForm)'));
  else //New file
    echo submit_button(lang('add file'),'s',array("id" => 'addFileButton', "onclick" => 'javascript:submitMe(document.addFileForm)'));
  ?>
  </div>
  
</div>
</form>
