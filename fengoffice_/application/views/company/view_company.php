<?php
  if($company->canEdit(logged_user())) {
    add_page_action(lang('edit company'), $company->getEditUrl(), 'ico-edit');
    add_page_action(lang('edit company logo'), $company->getEditLogoUrl(), 'ico-picture');
    if(!$company->isOwner()) {
      add_page_action(lang('update permissions'), $company->getUpdatePermissionsUrl(), 'ico-properties');
    } // if
  } // if
  if(User::canAdd(logged_user(), $company)) {
    add_page_action(lang('add user'), $company->getAddUserUrl(), 'ico-add');
  } // if
  

?>



<div style="padding:7px">
<div class="company">
<?php

	tpl_assign('title', $title);
	tpl_assign('show_linked_objects', false);
	tpl_assign('object', $company);
	tpl_assign('iconclass', 'ico-large-company');
	tpl_assign("content_template", array('company_content', 'company'));
	
	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>

