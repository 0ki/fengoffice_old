<?php 

  if($project->isNew()) {
    set_page_title(lang('add workspace'));
    administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
    administration_crumbs(array(
      array(lang('workspaces'), get_url('administration', 'projects')),
      array(lang('add project'))
    ));
  } else {
    set_page_title(lang('edit workspace'));
    administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
    administration_crumbs(array(
      array(lang('workspaces'), get_url('administration', 'projects')),
      array(lang('edit project'))
    ));
  } // if
  
?>
<div style="padding:8px">
<?php if($project->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('project', 'add') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $project->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'projectFormName', true) ?>
    <?php echo text_field('project[name]', array_var($project_data, 'name'), array('class' => 'long', 'id' => 'projectFormName')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('description'), 'projectFormDescription') ?>
    <?php echo textarea_field('project[description]', array_var($project_data, 'description'), array('id' => 'projectFormDescription')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('show project desciption in overview')) ?>
    <?php echo yes_no_widget('project[show_description_in_overview]', 'projectFormShowDescriptionInOverview', array_var($project_data, 'show_description_in_overview'), lang('yes'), lang('no')) ?>
  </div>
  
  <?php echo submit_button($project->isNew() ? lang('add workspace') : lang('edit workspace')) ?>
</form>
</div>