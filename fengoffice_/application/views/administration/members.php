<?php
  set_page_title(lang('members'));
  
  if(User::canAdd(logged_user(), owner_company())) {
    add_page_action(lang('add user'), owner_company()->getAddUserUrl(), 'ico-add');
  } // if
?>

<div class="adminUsersList" style="height:100%;background-color:white">
  <div class="adminHeader">
  	<div class="adminTitle"><?php echo lang('users') . (config_option('max_users')?(' (' . Users::count() .' / ' .  config_option('max_users') . ')'):'') ?></div>
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">
  <?php
		foreach ($users_by_company as $company_row){
			$company = $company_row['details'];
			$users = $company_row['users'];
			tpl_assign('users', $users);
			tpl_assign('company', $company);
		?>
<div style='padding-bottom:20px;max-width:700px'>
<div style="padding:10px;background-color:#D7E5F5"><h1 style="font-size:140%;font-weight:bold"><a class="internalLink" href="<?php echo $company->getCardUrl() ?>"><?php echo clean($company->getName()) ?></a></h1></div>
<div id="usersList" style="border:1px solid #DDD">

  <?php $this->includeTemplate(get_template_path('list_users', 'administration')); ?>
  </div></div>
  <?php } // foreach ?>
  
  </div>
 </div>