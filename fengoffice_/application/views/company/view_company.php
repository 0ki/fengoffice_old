<?php
  if(User::canAdd(logged_user(), $company)) {
    add_page_action(lang('add user'), $company->getAddUserUrl(), 'ico-add');
  } // if
  if(Contact::canAdd(logged_user())) {
    add_page_action(lang('add contact'), $company->getAddContactUrl(), 'ico-add');
  } // if
  if($company->canEdit(logged_user())) {
    add_page_action(lang('edit company'), $company->getEditUrl(), 'ico-edit');
    add_page_action(lang('edit company logo'), $company->getEditLogoUrl(), 'ico-picture');
    if(!$company->isOwner()) {
      add_page_action(lang('update permissions'), $company->getUpdatePermissionsUrl(), 'ico-properties');
    } // if
    if ($company->canDelete(logged_user())){
    	add_page_action(lang('delete'), "javascript:if(confirm(lang('confirm delete company'))) og.openLink('" . $company->getDeleteClientUrl() ."');", 'ico-delete');
    }
  } // if
  

?>



<div style="padding:7px">
<div class="company">
<?php
	if(isset($title) && $title != '')
		tpl_assign('title', clean($title));
	tpl_assign('show_linked_objects', false);
	tpl_assign('object', $company);
	tpl_assign('iconclass', 'ico-large-company');
	tpl_assign("content_template", array('company_content', 'company'));
	
	$this->includeTemplate(get_template_path('view', 'co'));
?>
</div>
</div>

