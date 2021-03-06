<? //Creado: Marcos Saiz - 25/07/2007?>
<?php
  set_page_title(lang('save document') );
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array(lang('save document'))
  ));
  
  add_stylesheet_to_page('project/documents.css');
?>
Documento guardado