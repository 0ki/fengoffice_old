<?php
  set_page_title($file->isNew() ? lang('upload file') : lang('edit file'));
  /*project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($file->isNew() ? lang('add file') : lang('edit file'))
  ));
  if(ProjectFile::canAdd(logged_user(), active_project())) {
    if($current_folder instanceof ProjectFolder) {
      add_page_action(lang('add document'), $current_folder->getAddDocumentUrl());
      add_page_action(lang('add spreadsheet'), $current_folder->getAddSpreadsheetUrl());
      add_page_action(lang('add presentation'), $current_folder->getAddPresentationUrl());
      add_page_action(lang('upload file'), $current_folder->getAddFileUrl());
    } else {
      add_page_action(lang('add document'), get_url('files', 'add_document'));
      add_page_action(lang('add spreadsheet'), get_url('files', 'add_spreadsheet'));
      add_page_action(lang('add presentation'), get_url('files', 'add_presentation'));
      add_page_action(lang('upload file'), get_url('files', 'add_file'));
    } // if
  } // if
//  if(ProjectFolder::canAdd(logged_user(), active_project())) {
//    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
//  } // if
  */
  add_stylesheet_to_page('project/files.css');
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<?php if($file->isNew()) { ?>
<form action="<?php echo get_url('files', 'add_file') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo $file->getEditUrl() ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

<?php if($file->isNew()) { ?>
  <div class="hint">
    <div class="content">
      <div id="selectFileControl">
        <?php echo label_tag(lang('file'), 'fileFormFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => 'fileFormFile')) ?>
      </div>
<!--      <div id="selectFolderControl">
        <?php echo label_tag(lang('folder'), 'fileFormFolder') ?>
        <?php echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
      </div> -->
      <p><?php echo lang('upload file desc', format_filesize(get_max_upload_size())) ?></p>
    </div>
  </div>
<?php } else { ?>
  <div class="hint">
    <div class="header"><?php echo checkbox_field('file[update_file]', array_var($file_data, 'update_file'), array('class' => 'checkbox', 'id' => 'fileFormUpdateFile', 'onclick' => 'App.modules.addFileForm.updateFileClick()')) ?> <?php echo label_tag(lang('update file'), 'fileFormUpdateFile', false, array('class' => 'checkbox'), '') ?></div>
    
  <?php echo submit_button($file->isNew() ? lang('add file') : lang('edit file')) ?>
    <div class="content">
      <div id="updateFileDescription">
        <p><?php echo lang('replace file description') ?></p>
      </div>
      <div id="updateFileForm">
        <p><strong><?php echo lang('existing file') ?>:</strong> <a href="<?php echo $file->getDownloadUrl() ?>"><?php echo clean($file->getFilename()) ?></a> | <?php echo format_filesize($file->getFilesize()) ?></p>
        
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
      
      <script type="text/javascript">
        App.modules.addFileForm.updateFileClick();
        App.modules.addFileForm.versionFileChangeClick();
      </script>
      
    </div>
  </div>
<?php } // if ?>

<?php if(!$file->isNew()) { ?>
<!--  <div>
    <?php echo label_tag(lang('folder'), 'fileFormFolder', true) ?>
    <?php echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
  </div>
  -->
<?php } // if ?>
  <?php echo submit_button($file->isNew() ? lang('add file') : lang('edit file')) ?>
<!-- Permissions -->
<script language="javascript">
function add_user(source)
{
	var table,row,cell;
	var innerHtml='<?php 
	    $all_input = radio_field("__TOKEN__", false , array("id" => "__TOKEN__" . "__YES"  , "value" => 2));
	    $read_input = radio_field("__TOKEN__", false , array("id" => "__TOKEN__" . "__READ" , "value" => 1));
	    $no_input = radio_field("__TOKEN__", true , array("id" => "__TOKEN__" . "__NO", "value" => 0));
	    $all_label = label_tag(lang("all"), "__TOKEN__" . "__YES", false, array("class" => "yes_no"), "");
	    $read_label = label_tag(lang("read"), "__TOKEN__" ."__READ" , false, array("class" => "yes_no"), "");
	    $no_label = label_tag(lang("no"), "__TOKEN__" . "__NO", false, array("class" => "yes_no"), "");    
	    echo  $all_input . " " . $all_label . " " . $read_input . " " . $read_label . " " .  $no_input . " " . $no_label; ?>';
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
</script>
<fieldset>

    <legend><?php echo lang('permission') ?></legend>
    <?php echo render_sharing_users('users_for_sharing',array('id'=>'users_for_sharing')) . ' '; 
	echo input_field('addUserForSharing',lang('add user'),array('type' => 'button', 'onclick' => 'javascript:add_user("combo")')). ' ';
    echo input_field('users_for_sharing_text','',array('id'=>'users_for_sharing2')). ' ';
	echo input_field('addUserForSharing',lang('add user'),array('type' => 'button', 'onclick' => 'javascript:add_user("text")')). ' ';
	echo input_field('permission_groups',$users_csv,array('type' => 'hidden', 'id' => 'permission_groups'))?>
	<table cellpadding="0" cellspacing="0" id='permissions_table'>
	<tr><td>Username</td><td>Permissions</td></tr>
	<?php 
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
		}
	?>
	</table>
	<br /><span class="desc"><?php echo lang('file permissions description') ?></span>
</fieldset> 
<!-- End Permissions -->
  
  <fieldset>
    <legend><?php echo lang('tags') ?></legend>
    <?php echo show_project_tags_option(active_project(), 'allTagsCombo', array('id' => 'allTagsCombo'));
    	 echo show_addtag_button('allTagsCombo','fileFormTags',array('style'=> 'width:20px')); ?>
	<?php echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>

  </fieldset> 
  
  <fieldset>
    <legend><?php echo lang('description') ?></legend>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </fieldset>

  <!-- <div>
    <?php echo label_tag(lang('description'), 'fileFormDescription') ?>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </div> -->
  
<?php if(logged_user()->isMemberOfOwnerCompany()) { ?>
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
<?php } // if ?>

  <!--<fieldset>
    <legend><?php //echo lang('tags') ?></legend>
    <?php// echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </fieldset>-->
    <!-- <div class="formBlock">
    <?php echo label_tag(lang('tags'), 'fileFormTags') ?>
    <?php echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </div> -->
  
  <?php echo submit_button($file->isNew() ? lang('add file') : lang('edit file'),'s'	) ?>
  
</form>

<script language="javascript">
function preProcessTags()
{
	col = document.getElementsByName('tags');
	largo = col.length;
	txt = "";
	if(largo==0)
		return txt;
	for (i = 0; i < largo; i++) {
		if (col[i].checked) {
		txt = txt + col[i].value + ",";
		}
	}	
	document.getElementById('file[tags]').value= txt.substring(0,txt.length-1);
	//alert(document.getElementById('file[tags]').value);
}
</script>