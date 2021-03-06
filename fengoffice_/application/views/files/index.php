<?php

  if($current_folder instanceof Projectfolder) {
    set_page_title(lang('folder') . ': ' . $current_folder->getName());
  } else {
    set_page_title(lang('files'));
  } // if
  
  project_tabbed_navigation(PROJECT_TAB_FILES);
  $files_crumbs = array(
    0 => array(lang('files'), get_url('files'))
  ); // array
  if($current_folder instanceof ProjectFolder) {
    $files_crumbs[] = array($current_folder->getName(), $current_folder->getBrowseUrl($order));
  } // if
  $files_crumbs[] = array(lang('index'));
  
  project_crumbs($files_crumbs);
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

/*  
  if(ProjectFolder::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
  } // if
*/
  
  add_stylesheet_to_page('project/files.css');

?>
<?php if(isset($files) && is_array($files) && count($files)) { ?>
<div id="files">
<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>
<?php $counter = 0; ?>
<?php foreach($files as $group_by => $grouped_files) { ?>
<h2><?php echo clean($group_by) ?></h2>



<div class="filesList">
<?php foreach($grouped_files as $file) { ?>
<?php $counter++; ?>
  <div class="listedFile <?php echo $counter % 2 ? 'even' : 'odd' ?>">


<?php if($file->isPrivate()) { ?>
// Private: Rather do it like Google (Owner / Collaborators / Viewers)
    <div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
<?php } // if ?>


 <!--   <div class="stub_check" style="float:left;">//chck</div>
    <div class="stub_important" style="float:left;">//!!</div> -->


    <div class="fileIcon"><img height="30" src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getFilename() ?>" /></div>


    <div class="fileInfo" >
      <div class="fileName" ><a href="<?php echo $file->getDetailsUrl() ?>" title="<?php echo lang('view file details') ?>"><?php echo clean($file->getFilename()) ?></a></div>
      
<?php if(($last_revision = $file->getLastRevision()) instanceof ProjectFileRevision) { ?>
      <div class="fileLastRevision">
<?php if($last_revision->getCreatedBy() instanceof User) { ?>
        <?php echo lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), $last_revision->getCreatedBy()->getDisplayName(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } else { ?>
        <?php echo lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } // if ?>
      </div>
<?php } // if ?>



    </div>
  </div>
<?php } // foreach ?>
</div>
<?php } // foreach ?>

<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>
</div>
<?php } else { ?>
<p><?php echo lang('no files on the page') ?></p>
<?php } // if ?>