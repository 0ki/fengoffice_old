<?php 
  set_page_title(lang('groups'));
  
  if(owner_company()->canAddGroup(logged_user())) {
    add_page_action(lang('add group'), get_url('group', 'add_group'));
  } // if
?>

<div class="adminGroups">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('groups') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
<?php if(isset($groups) && is_array($groups) && count($groups)) { ?>
<table>
  <tr>
    <th><?php echo lang('name') ?></th>
    <th><?php echo lang('users') ?></th>
    <th><?php echo lang('options') ?></th>
  </tr>
<?php foreach($groups as $group) { ?>
  <tr>
    <td><a class="internalLink" href="<?php echo $group->getViewUrl() ?>"><?php echo clean($group->getName()) ?></a></td>
    <td style="text-align: center"><?php echo $group->countUsers() ?></td>
<?php 
  $options = array(); 
//  if($group->canAddUser(logged_user())) {
//    $options[] = '<a class="internalLink" href="' . $group->getAddUserUrl() . '">' . lang('add user') . '</a>';
//  } // if
//  if($group->canUpdatePermissions(logged_user())) {
//    $options[] = '<a class="internalLink" href="' . $group->getUpdatePermissionsUrl() . '">' . lang('permissions') . '</a>';
//  } // if
  if($group->canEdit(logged_user())) {
    $options[] = '<a class="internalLink" href="' . $group->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if($group->canDelete(logged_user())) {
    $options[] = '<a class="internalLink" href="' . $group->getDeleteGroupUrl() . '" onclick="return confirm(\'' . lang('confirm delete group') . '\')">' . lang('delete') . '</a>';
  } // if
?>
    <td><?php echo implode(' | ', $options) ?></td>
  </tr>
<?php } // foreach ?>
</table>
<?php } else { ?>
<?php echo lang('no groups in company') ?>
<?php } // if ?>
</div>
</div>