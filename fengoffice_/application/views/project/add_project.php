<?php
	$user = logged_user();
	
  	if(!$project->isNew() && $project->canDelete(logged_user())) {
  		add_page_action(lang('delete'),  $project->getDeleteUrl() , 'ico-delete');
  	} // if
  	
  	$genid = gen_id();
?>
<form style="height:100%;background-color:white" class="internalForm" action="<?php echo $project->isNew() ? get_url('project', 'add') : $project->getEditUrl()?>" method="post">

<?php
  $quoted_permissions = array();
  foreach($permissions as $permission_id => $permission_text) {
    $quoted_permissions[] = "'$permission_id'";
  } // foreach
?>
    <script type="text/javascript" src="<?php echo get_javascript_url('modules/updateUserPermissions.js') ?>"></script>
    <script type="text/javascript">
        App.modules.updatePermissionsForm.project_permissions = new Array(<?php echo implode(', ', $quoted_permissions) ?>);

    </script>
    
<div class="adminAddProject">
  <div class="adminHeader">
  	<div class="adminHeaderUpperRow">
  		<div class="adminTitle"><table style="width:535px"><tr><td>
  			<?php echo $project->isNew() ? lang('new workspace') : lang('edit workspace') ?>
  		</td><td style="text-align:right">
  			<?php echo submit_button($project->isNew() ? lang('add workspace') : lang('save changes'), 's', array('style'=>'margin-top:0px;margin-left:10px')) ?>
  		</td></tr></table></div>
  	</div>
  	
  	<div>
    <?php echo label_tag(lang('name'), 'projectFormName', true) ?>
    <?php echo text_field('project[name]', array_var($project_data, 'name'), 
    	array('class' => 'title', 'id' => 'projectFormName', 'tabindex' => '1')) ?>
    </div>
  
  
  	<div style="padding-top:5px">
		<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>workspace_description',this)"><?php echo lang('description') ?></a> - 
		<?php if ($project->canChangePermissions(logged_user())) { ?>
			<a href="#" class="option" onclick="og.toggleAndBolden('<?php echo $genid ?>workspace_permissions',this)"><?php echo lang('edit permissions') ?></a>
		<?php } ?>
	</div>
  
  </div>
  <div class="adminSeparator"></div>
  <div class="adminMainBlock">

	<div id="<?php echo $genid ?>workspace_description" style="display:none">
	<fieldset>	
	<legend><?php echo lang('description') ?></legend>
		<?php echo textarea_field('project[description]', array_var($project_data, 'description'), array('id' => 'projectFormDescription')) ?>
		<?php echo label_tag(lang('show project desciption in overview')) ?>
		<?php echo yes_no_widget('project[show_description_in_overview]', 'projectFormShowDescriptionInOverview', array_var($project_data, 'show_description_in_overview'), lang('yes'), lang('no')) ?>
	</fieldset>
	</div>

	<!-- permissions -->
	<?php if ($project->canChangePermissions(logged_user())) { ?>
		<div id="<?php echo $genid ?>workspace_permissions" style="display:none">
		<fieldset>
		<legend><?php echo lang('edit permissions') ?></legend>
		
		<label><?php echo lang('edit permissions explanation') ?></label>
		<?php if (isset($companies) && is_array($companies) && count($companies)) { ?>
			<div id="projectCompanies">
			<?php foreach ($companies as $company) { ?>
				<?php if ($company->countUsers() > 0) { ?>
				<fieldset>
				<legend><?php echo clean($company->getName()) ?></legend>
					<div class="projectCompany" style="border:0">
					<div class="projectCompanyLogo"><img src="<?php echo $company->getLogoUrl() ?>" alt="<?php echo clean($company->getName()) ?>" /></div>
					<div class="projectCompanyMeta">
						<div class="projectCompanyTitle">
					<?php if($company->isOwner()) { ?>
						<!-- <label><?php //echo clean($compangetName()) ?></label>-->
							<input type="hidden" name="project_company_<?php echo $company->getId() ?>" value="checked" />
					<?php } else { ?>
							<?php echo checkbox_field('project_company_' . $company->getId(), $company->isProjectCompany(active_or_personal_project()), array('id' => $genid . 'project_company_' . $company->getId(), 'onclick' => "App.modules.updatePermissionsForm.companyCheckboxClick(" . $company->getId() . ",'".$genid."')")) ?> <label for="<?php echo 'project_company_' . $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
					<?php } // if ?>
						</div>
						<div class="projectCompanyUsers" id="<?php echo $genid ?>project_company_users_<?php echo $company->getId() ?>">
							<table class="blank">
					<?php if ($users = $company->getUsers()) { ?>
<?php						 foreach ($users as $user) { ?>
								<tr class="user">
									<td>
<?php							 if ($user->isAccountOwner()) { ?>
										<img src="<?php echo icon_url('ok.gif') ?>" alt="" /> <label class="checkbox"><?php echo clean($user->getDisplayName()) ?></label>
										<input type="hidden" name="<?php echo 'project_user_' . $user->getId() ?>" value="checked" />
<?php							 } else { ?>
										<?php echo checkbox_field('project_user_' . $user->getId(), $user->isProjectUser(active_or_personal_project()), array('id' => $genid . 'project_user_' . $user->getId(), 'onclick' => "App.modules.updatePermissionsForm.userCheckboxClick(" . $user->getId() . ", " . $company->getId() . ",'".$genid."')")) ?> <label class="checkbox" for="<?php echo 'project_user_' . $user->getId() ?>"><?php echo clean($user->getDisplayName()) ?></label>
<?php							 } // if ?>
<?php							 if($user->isAdministrator()) {?> 
										<span class="desc">(<?php echo lang('administrator') ?>)</span>
<?php							 } // if ?>
									</td>
									<td>
							<?php if(!$company->isOwner()) { ?>
										<div class="projectUserPermissions" id="<?php echo $genid ."user_".$user->getId() ?>_permissions">
										<div><?php echo checkbox_field('project_user_' . $user->getId() . '_all', $user->hasAllProjectPermissions(active_or_personal_project()), array('id' => $genid . 'project_user_' . $user->getId() . '_all', 'onclick' => "App.modules.updatePermissionsForm.userPermissionAllCheckboxClick(" . $user->getId() . ",'".$genid."')")) ?> <label for="<?php echo 'project_user_' . $user->getId() . '_all' ?>" class="checkbox" style="font-weight: bolder"><?php echo lang('all permissions') ?></label></div>
								<?php foreach ($permissions as $permission_id => $permission_text) { ?>						
										<div><?php echo checkbox_field('project_user_' . $user->getId() . "_$permission_id", $user->hasProjectPermission(active_or_personal_project(), $permission_id), array('id' => $genid . 'project_user_' . $user->getId() . "_$permission_id", 'onclick' => "App.modules.updatePermissionsForm.userPermissionCheckboxClick(" . $user->getId() . ",'".$genid."')")) ?> <label for="<?php echo 'project_user_' . $user->getId() . "_$permission_id" ?>" class="checkbox normal"><?php echo $permission_text ?></label></div>
								<?php } // foreach ?>
										</div>
									<script type="text/javascript">
										if (!document.getElementById( '<?php echo $genid ?>project_user_<?php echo $user->getId() ?>').checked) {
											document.getElementById( '<?php echo $genid ?>user_<?php echo $user->getId() ?>_permissions').style.display = 'none';
										} // if
									</script>
							<?php } // if ?>
									</td>
								</tr>
						<?php } // foreach ?>
					<?php } else { ?>
								<tr>
								<td colspan="2"><?php echo lang('no users in company') ?></td>
								</tr>
					<?php } // if ?>
							</table>
						</div>
						<div class="clear"></div>
					</div>
					</div>
					<?php if (!$company->isOwner()) { ?>
						<script type="text/javascript">
							if(!document.getElementById( '<?php echo $genid ?>project_company_<?php echo $company->getId() ?>').checked) {
								document.getElementById( '<?php echo $genid ?>project_company_users_<?php echo $company->getId() ?>').style.display = 'none';
							} // if
						</script>
					<?php } // if ?>
				</fieldset>
				<?php } // if ?>
			<?php } // foreach ?>
			</div>
		<?php } // if ?>
		</fieldset>
		</div>
	<?php } // if ?>
	<!-- /permissions -->
		
	<?php if (($project->getId() != $user->getPersonalProjectId() || $user->isAdministrator()) && isset ($projects) && count($projects) > 0) { ?>
	<fieldset>
	<legend><?php echo lang('parent workspace') ?></legend>
		<?php echo select_project('project[parent_id]', $projects, $project->isNew()?active_project()?active_project()->getId():0:$project->getParentId(), null, true) ?>
	</fieldset>
	<?php } ?>
    
    <?php echo label_tag(lang('workspace color')) ?>
		<input type="hidden" id="workspace_color" name="project[color]" value="<?php echo $project->isNew()?0:$project->getColor() ?>" />
		<div>
			<script type="text/javascript">
			function wsColorChoose(obj, color) {
				var elements = document.getElementsByName("wsColor-<?php echo $genid ?>");
				for (var i = 0; i < elements.length; i++){
					var p = elements[i];
					if (p.className) {
						if (p.className.indexOf('ico-color'+color+' ') >= 0) {
							p.className = 'ico-color' + color + ' ws-color-chooser-selected';
							document.getElementById('workspace_color').value = color;
						} else {
							p.className = p.className.replace(/ws-color-chooser-selected/ig, 'ws-color-chooser');
						}
					}
				}
			}
			</script>
			<table><tr><td><img class="ico-color0 ws-color-chooser" name="wsColor-<?php echo $genid ?>" onclick="wsColorChoose(this, 0)" src="<?php echo EMPTY_IMAGE ?>"/></td>
				<td>	
    		<?php for ($i=1; $i <= 12; $i++) {
				$class = "ico-color$i " . ($project->getColor() != $i?"ws-color-chooser":"ws-color-chooser-selected");
				echo "<img src=\"".EMPTY_IMAGE."\" name=\"wsColor-$genid\" class=\"$class\" onclick=\"wsColorChoose(this, $i)\" />";
			} ?></td></tr><tr><td></td><td>	
    		<?php for ($i=13; $i <= 24; $i++) {
				$class = "ico-color$i " . ($project->getColor() != $i?"ws-color-chooser":"ws-color-chooser-selected");
				echo "<img src=\"".EMPTY_IMAGE."\" name=\"wsColor-$genid\" class=\"$class\" onclick=\"wsColorChoose(this, $i)\" />";
			} ?></td></tr></table>
		</div>
		
	<?php echo submit_button($project->isNew() ? lang('add workspace') : lang('save changes'), 's', array('tabindex' => '2')) ?>
</div>
</div>
</form>

<script type="text/javascript">
	Ext.get('projectFormName').focus();
</script>
