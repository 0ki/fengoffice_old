<?php
//  if($group->canEdit(logged_user())) {
//    add_page_action(lang('edit group'), $group->getEditUrl());
//    add_page_action(lang('edit group logo'), $group->getEditLogoUrl());
//    if(!$group->isOwner()) {
//      add_page_action(lang('update permissions'), $group->getUpdatePermissionsUrl());
//    } // if
//  } // if
//  if(User::canAdd(logged_user(), $group)) {
//    add_page_action(lang('add user'), $group->getAddUserUrl());
//  } // if

?>
<?php // $this->includeTemplate(get_template_path('group_card', 'group')) ?>
<?php echo label_tag(clean($group->getName())) ?>
<fieldset><legend class="toggle_collapsed" onclick="og.toggle('groupUsers',this)"><?php echo lang('users') ?></legend>
<div id='groupUsers' style="display:none">
<?php
  $this->assign('users', $group->getUsers($group->getId()));
  $this->includeTemplate(get_template_path('list_users', 'administration'));
?>
</div>
</fieldset>
