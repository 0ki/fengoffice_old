<?php
include("FCKeditor/fckeditor.php");
?>

<?php
  set_page_title($file->isNew() ? lang('New document') : lang('edit document'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($file->isNew() ? lang('add document') : lang('edit document'))
  ));
  
  add_stylesheet_to_page('project/documents.css');
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<?php if($file->isNew()) { ?>
<form action="<?php echo get_url('files', 'add_file') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo $file->getEditUrl() ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>


<?php
$oFCKeditor = new FCKeditor('FCKeditor1');
$oFCKeditor->BasePath = 'FCKeditor/';
$oFCKeditor->Width = '100%';
$oFCKeditor->Height = '400';
$oFCKeditor->Value = 'Save does not work yet. Its an alpha. You wanna hack it?';
$oFCKeditor->Create();
?>



  
  <?php echo submit_button(lang('Save')) ?>
  
</form>