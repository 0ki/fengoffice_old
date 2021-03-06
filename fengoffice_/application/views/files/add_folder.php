<?php
  set_page_title($folder->isNew() ? lang('add folder') : lang('edit folder'));
  
  if(ProjectFile::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add file'), get_url('files', 'add_file'), 'ico-add');
  } // if
//  if(ProjectFolder::canAdd(logged_user(), active_project())) {
//    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
//  } // if
  
?>
<?php if($folder->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('files', 'add_folder') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $folder->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <div>
    <?php echo label_tag(lang('name'), 'folderFormName') ?>
    <?php echo text_field('folder[name]', array_var($folder_data, 'name'), array('id' => 'folderFormName')) ?>
  </div>
  
  <?php echo submit_button($folder->isNew() ? lang('add folder') : lang('edit folder')) ?>
  
</form>