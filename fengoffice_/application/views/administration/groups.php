<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('groups'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_GROUPS);
  administration_crumbs(lang('groups'));
  
  if(owner_company()->canAddGroup(logged_user())) {
    add_page_action(lang('add group'), get_url('group', 'add_group'));
  } // if

?>
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
  if($group->canAddUser(logged_user())) {
    $options[] = '<a class="internalLink" href="' . $group->getAddUserUrl() . '">' . lang('add user') . '</a>';
  } // if
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