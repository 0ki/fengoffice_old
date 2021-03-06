<?php
  set_page_title($file->isNew() ? lang('upload file') : lang('edit file') . ": " . $file->getFilename());
  add_stylesheet_to_page('project/files.css');
?>

<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<form action="<?php
if ($file->isNew()){
	echo get_url('files', 'add_file');
} else if (isset($checkin) && $checkin){
	echo $file->getCheckinUrl();
} else {
	echo $file->getEditUrl();
}

 ?>" method="post" enctype="multipart/form-data" onsubmit="og.submit(this)">

<?php tpl_display(get_template_path('form_errors'));
	$enableUpload = $file->isNew() 
	|| (isset($checkin) && $checkin) 
	|| ($file->getCheckedOutById() == 0 && logged_user()->isAdministrator())
	|| ($file->getCheckedOutById() == logged_user()->getId());
?>

  <div class="hint">
  <?php if ($enableUpload) { ?>
  <table style="width:100%"><tr><td style="width:50%">
<?php if($file->isNew()) { ?>
    <div class="content">
      <div id="selectFileControl">
        <?php echo label_tag(lang('file'), 'fileFormFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => 'fileFormFile')) ?>
      </div>
<!--      <div id="selectFolderControl">
        <?php // echo label_tag(lang('folder'), 'fileFormFolder') ?>
        <?php //deprecated echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
      </div> -->
      <p><?php echo lang('upload file desc', format_filesize(get_max_upload_size())) ?></p>
    </div>
<?php } else { 
	if ($enableUpload && !isset($checkin)) {?>
    	<div class="header"><?php echo checkbox_field('file[update_file]', array_var($file_data, 'update_file'), array('class' => 'checkbox', 'id' => 'fileFormUpdateFile', 'onclick' => 'App.modules.addFileForm.updateFileClick()')) ?> <?php echo label_tag(lang('update file'), 'fileFormUpdateFile', false, array('class' => 'checkbox'), '') ?></div>
    <?php } // if ?>
    <div class="content">
    <?php if (!isset($checkin)) {?>
      <div id="updateFileDescription">
        <p><?php echo lang('replace file description') ?></p>
      </div>
      <?php } // if ?>
      <div id="updateFileForm">
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
</td><td style="width:50%">
<?php } // if enableupload ?> 

 <fieldset >
    <legend class="toggle_collapsed" onclick="og.toggle('add_file_project_div',this)"><?php echo lang('workspace') ?></legend>
    <div id="add_file_project_div" style="display:none">
	<select id="file[project_id]" name="file[project_id]">
		<?php
		// add project combo
		$active_projects = logged_user()->getActiveProjects();
		if ($file->isNew()) {
			$projId = active_or_personal_project()->getId();
		} else {
			$projId = $file->getProjectId();
		}
		if (isset($active_projects) && is_array($active_projects) && count($active_projects)) {
			foreach($active_projects as $project) { //list all projects, marking the active as selected
		?>
		<option value="<?php echo $project->getId() ?>"<?php if ($projId == $project->getId()) { echo ' selected="selected"'; } ?>><?php echo clean($project->getName()) ?></option>
		<?php
			}
		}
		?>
	  </select>
	</div>
  </fieldset>

<!-- Permissions -->
<!-- script language="javascript">
function add_user(source)
{
	var table,row,cell;
	var innerHtml='<?php /*
	    $all_input = radio_field("__TOKEN__", false , array("id" => "__TOKEN__" . "__YES"  , "value" => 2));
	    $read_input = radio_field("__TOKEN__", false , array("id" => "__TOKEN__" . "__READ" , "value" => 1));
	    $no_input = radio_field("__TOKEN__", true , array("id" => "__TOKEN__" . "__NO", "value" => 0));
	    $all_label = label_tag(lang("all"), "__TOKEN__" . "__YES", false, array("class" => "yes_no"), "");
	    $read_label = label_tag(lang("read"), "__TOKEN__" ."__READ" , false, array("class" => "yes_no"), "");
	    $no_label = label_tag(lang("no"), "__TOKEN__" . "__NO", false, array("class" => "yes_no"), "");    
	    echo  $all_input . " " . $all_label . " " . $read_input . " " . $read_label . " " .  $no_input . " " . $no_label; */?>';
	var username = 0;
	if (source=='combo')
		username=document.getElementById('users_for_sharing').value;
	if (source=='text')
		username=document.getElementById('users_for_sharing2').value;
	if( username != 0 && username != '')
	{
		innerHtml=innerHtml.replace(/__TOKEN__/g, username );
		tablee = (document.all) ? document.all.permissions_table : 
				document.getElementById('permissions_table');
		row = tablee.insertRow(-1);
		row.height=20;
		cell = row.insertCell(0);
		cell.innerHTML = username;
		cell = row.insertCell(1);
		cell.align='center';
		cell.innerHTML = innerHtml;
		document.getElementById('permission_groups').value = document.getElementById('permission_groups').value + ' , ' + username;
	}	
}
</script --> 
<!-- fieldset>

    <legend><?php echo lang('permission') ?></legend>
    <?php echo render_sharing_users('users_for_sharing',array('id'=>'users_for_sharing')) . ' '; 
	echo input_field('addUserForSharing',lang('add user'),array('type' => 'button', 'onclick' => 'javascript:add_user("combo")')). ' ';
	echo "<br />";
    echo input_field('users_for_sharing_text','',array('id'=>'users_for_sharing2')). ' ';
	echo input_field('addUserForSharing',lang('add user'),array('type' => 'button', 'onclick' => 'javascript:add_user("text")')). ' ';
	echo input_field('permission_groups',$users_csv,array('type' => 'hidden', 'id' => 'permission_groups'))?>
	<table cellpadding="0" cellspacing="0" id='permissions_table'>
	<tr><td>Username</td><td>Permissions</td></tr>
	<?php /*
		foreach ($file_permissions as $perm)
		{
			$user_name=Users::findById($perm->getUserId())->getUsername();
		    $all_input = radio_field($user_name, $perm->getPermission()==2 , array("id" => $user_name . "__YES"  , "value" => 2));
		    $read_input = radio_field($user_name, $perm->getPermission()==1 , array("id" => $user_name . "__READ" , "value" => 1));
		    $no_input = radio_field($user_name, false , array("id" => $user_name . "__NO", "value" => 0));
		    $all_label = label_tag(lang("all"), $user_name . "__YES", false, array("class" => "yes_no"), "");
		    $read_label = label_tag(lang("read"), $user_name ."__READ" , false, array("class" => "yes_no"), "");
		    $no_label = label_tag(lang("no"), $user_name . "__NO", false, array("class" => "yes_no"), ""); 
			echo '<tr><td>' . $user_name .'</td><td align="center">';   
		    echo  $all_input . " " . $all_label . " " . $read_input . " " . $read_label . " " .  $no_input . " " . $no_label; 
		    echo '</td></tr>' ;
		}*/
	?>
	</table>
	<br /><span class="desc"><?php echo lang('file permissions description') ?></span>
</fieldset --> 
<!-- End Permissions -->
  
  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_file_tags_div',this)"><?php echo lang('tags') ?></legend>
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
	<?php echo autocomplete_textfield("file[tags]", array_var($file_data, 'tags'), 'allTags', array('id'=>'add_file_tags_div', 'style'=>'display:none', 'class' => 'long')); ?>

  </fieldset> 
  
  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('fileFormDescription',this)"><?php echo lang('description') ?></legend>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short',  'style'=>'display:none', 'id' => 'fileFormDescription')) ?>
  </fieldset>

  <!-- <div>
    <?php echo label_tag(lang('description'), 'fileFormDescription') ?>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </div> -->
  
<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
  <fieldset>
    <legend  class="toggle_collapsed" onclick="og.toggle('add_file_options_div',this)"><?php echo lang('options') ?></legend>
    <div id='add_file_options_div' style="display:none">
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
    </div>
  </fieldset>
<?php } // if ?>

  <fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_file_properties_div',this)"><?php echo lang('properties') ?></legend>
      <div id='add_file_properties_div' style="display:none">
	  <? echo render_object_properties('file',$file); ?>
  </div>
  </fieldset> 
  <!--<fieldset>
    <legend><?php //echo lang('tags') ?></legend>
    <?php// echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </fieldset>-->
    <!-- <div class="formBlock">
    <?php echo label_tag(lang('tags'), 'fileFormTags') ?>
    <?php echo project_object_tags_widget('file[tags]', active_or_personal_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </div> -->
  
<?php if($file->canLinkObject(logged_user(), active_or_personal_project())) { ?>
<fieldset>
    <legend class="toggle_collapsed" onclick="og.toggle('add_file_linked_objects_div',this)"><?php echo lang('linked objects') ?></legend>
    <div style="display:none" id="add_file_linked_objects_div">
    <?php echo render_object_links($file, $file->canEdit(logged_user())) ?>
</div>
</fieldset>
<?php } // if ?>
<?php if ($enableUpload) { ?>
</td></tr></table>
<?php } ?>
  <?php if (isset($checkin) && $checkin) {
  	echo submit_button(lang('checkin file'));
  } else{
  	echo submit_button($file->isNew() ? lang('add file') : lang('edit file'));
  } ?>
</div>

</form>
