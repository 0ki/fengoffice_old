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
<?php $this->includeTemplate(get_template_path('company_card', 'company')) ?>

<fieldset><legend class="toggle_collapsed" onclick="og.toggle('companyUsers',this)"><?php echo lang('users') ?></legend>
<div id='companyUsers' style="display:none">
<?php
  $this->assign('users', $company->getUsers());
  $this->includeTemplate(get_template_path('list_users', 'administration'));
?>
</div>
</fieldset>

<fieldset><legend class="toggle_collapsed" onclick="og.toggle('companyContacts',this)"><?php echo lang('contacts') ?></legend>
<div id='companyContacts' style="display:none">
<?php
  $this->assign('contacts', $company->getContacts());
  $this->includeTemplate(get_template_path('list_contacts', 'contact'));
?>
</div>
</fieldset>