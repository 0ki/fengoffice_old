<?php
// Set page title and set crumbs to index
if($user->canUpdateProfile(logged_user())) {
	add_page_action(lang('update profile'),$user->getEditProfileUrl(), 'ico-edit', null, null, true);
	add_page_action(lang('update avatar'), $user->getUpdateAvatarUrl(), 'ico-picture', null, null, true);
	add_page_action(lang('change password'), $user->getEditPasswordUrl(), 'ico-password', null, null, true);
} // if
if($user->getId() == logged_user()->getId()){
	add_page_action(lang('edit preferences'), $user->getEditPreferencesUrl(), 'ico-administration', null, null, true);
}
if($user->canUpdatePermissions(logged_user())) {
	add_page_action(lang('permissions'), $user->getUpdatePermissionsUrl(), 'ico-permissions', null, null, true);
} // if

?>



<div style="padding: 7px">
<div class="user"><?php

$description = "";
if($description != '') $description .= '<br/>';

tpl_assign('description', $description);
tpl_assign('title', clean($user->getDisplayName()));
tpl_assign('show_linked_objects', false);
tpl_assign('object', $user);
tpl_assign('iconclass', 'ico-large-user');
tpl_assign("content_template", array('user_card', 'contact'));
tpl_assign('is_user', true);

$this->includeTemplate(get_template_path('view', 'co'));
?></div>
</div>
