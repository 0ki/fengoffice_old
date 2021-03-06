<?php
include("fckeditor/fckeditor.php");
?>

<?php
  set_page_title($file->isNew() ? lang('new document') : lang('edit document') . ' - ' . $file->getFilename());
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($file->isNew() ? lang('add document') : lang('edit document'))
  ));

  add_stylesheet_to_page('project/documents.css');
?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<?php if($file->isNew()) { ?>
<form action="<?php echo get_url('files', 'save_document') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo get_url('files', 'save_document',array(
	        'id' => $file->getId(), 
	        'active_project' =>  $file->getProjectId())) ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>


<?php
$oFCKeditor = new FCKeditor('FCKeditor1');
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Width = '100%';
$oFCKeditor->Height = '400';
	$sSkin = 'office2003';
	$sSkinPath = '../fckeditor/editor/skins/' + $sSkin + '/';
//	$oFCKeditor->Config['SkinPath'] = $sSkinPath;
if($file->isNew())
	$oFCKeditor->Value = '';
else
	$oFCKeditor->Value = $file->getFileContent();
$oFCKeditor->Create();
?>



      <div>
    <?php if($file->isNew()){
    	echo label_tag(lang('name'), 'fileFormName');

    
    	echo text_field('file[name]', array_var($file_data, 'name'), array('id' => 'fileFormName'));
    }
    else 
    { 
    	echo input_field('new_revision_document','checked', array('type' => 'checkbox' , 'width' => '20' )) . lang('create new revision');
    } 
    ?>
  </div>
  <?php echo submit_button(lang('Save')) ?>
   
</form>