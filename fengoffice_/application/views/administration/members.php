<?php
  set_page_title(lang('members'));
  
  if(User::canAdd(logged_user(), owner_company())) {
    add_page_action(lang('add user'), owner_company()->getAddUserUrl(), 'ico-add');
  } // if

?>
<?php $this->includeTemplate(get_template_path('list_users', 'administration')) ?>