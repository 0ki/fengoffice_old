<div style="padding:20px">
<?php 

	if($project->isNew()) {
		echo "<h1>".lang('add workspace')."</h1>";
		administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
		administration_crumbs(array(
			array(lang('workspaces'), get_url('administration', 'projects')),
			array(lang('add project'))
		));
	} else {
		echo "<h1>".lang('edit workspace')." - ".$project->getName()."</h1>";
		administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
		administration_crumbs(array(
			array(lang('workspaces'), get_url('administration', 'projects')),
			array(lang('edit project'))
		));
	} // if
	
?>
<?php if($project->isNew()) { ?>
<form class="internalForm" action="<?php echo get_url('project', 'add') ?>" method="post">
<?php } else { ?>
<form class="internalForm" action="<?php echo $project->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

	<fieldset>
	<legend class="toggle_expanded" onclick="og.toggle('workspace_name', this)"><b><?php echo lang('name') ?></b></legend>
	<div id="workspace_name">
		<span class="error"><b>*</b></span> <?php echo text_field('project[name]', array_var($project_data, 'name'), array('class' => 'long', 'id' => 'projectFormName')) ?>
		<?php echo label_tag(lang('workspace color')) ?>
		<input type="hidden" id="workspace_color" name="project[color]" value="<?php echo $project->isNew()?0:$project->getColor() ?>" />
		<div>
			<script type="text/javascript">
			function wsColorChoose(obj, color) {
				var p = obj.parentNode.firstChild;
				while (p) {
					if (p.className) {
						if (p.className.indexOf('ico-color'+color) >= 0) {
							p.className = 'ico-color' + color + ' ws-color-chooser-selected';
							document.getElementById('workspace_color').value = color;
						} else {
							p.className = p.className.replace(/ws-color-chooser-selected/ig, 'ws-color-chooser');
						}
					}
					p = p.nextSibling;
				}
			}
			</script>
			<?php for ($i=0; $i < 8; $i++) {
				$class = "ico-color$i " . ($project->getColor() != $i?"ws-color-chooser":"ws-color-chooser-selected");
				echo "<img src=\"http://www.extjs.com/s.gif\" class=\"$class\" onclick=\"wsColorChoose(this, $i)\" />";
			} ?>
		</div>
	</div>
	</fieldset>

	<fieldset>	
	<legend class="toggle_collapsed" onclick="og.toggle('workspace_description', this)"><b><?php echo lang('description') ?></b></legend>
	<div id="workspace_description" style="display:none">
		<?php echo textarea_field('project[description]', array_var($project_data, 'description'), array('id' => 'projectFormDescription')) ?>
	
		<?php echo label_tag(lang('show project desciption in overview')) ?>
		<?php echo yes_no_widget('project[show_description_in_overview]', 'projectFormShowDescriptionInOverview', array_var($project_data, 'show_description_in_overview'), lang('yes'), lang('no')) ?>
	</div>
	</fieldset>

	<!-- permissions -->
	<?php if ($project->canChangePermissions(logged_user())) { ?>
		<script type="text/javascript">
		</script>
		
		<fieldset>
		<legend class="toggle_collapsed" onclick="og.toggle('workspace_permissions', this)"><b><?php echo lang('edit permissions') ?></b></legend>
		<div id="workspace_permissions" style="display:none">
		<label><k><?php echo lang('edit permissions explanation') ?></k></label>
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
							<?php echo checkbox_field('project_company_' . $company->getId(), $company->isProjectCompany(active_or_personal_project()), array('id' => 'project_company_' . $company->getId(), 'onclick' => "App.modules.updatePermissionsForm.companyCheckboxClick(" . $company->getId() . ")")) ?> <label for="<?php echo 'project_company_' . $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
					<?php } // if ?>
						</div>
						<div class="projectCompanyUsers" id="project_company_users_<?php echo $company->getId() ?>">
							<table class="blank">
					<?php if ($users = $company->getUsers()) { ?>
						<?php foreach ($users as $user) { ?>
								<tr class="user">
									<td>
							<?php if ($user->isAccountOwner()) { ?>
										<img src="<?php echo icon_url('ok.gif') ?>" alt="" /> <label class="checkbox"><?php echo clean($user->getDisplayName()) ?></label>
										<input type="hidden" name="<?php echo 'project_user_' . $user->getId() ?>" value="checked" />
							<?php } else { ?>
										<?php echo checkbox_field('project_user_' . $user->getId(), $user->isProjectUser(active_or_personal_project()), array('id' => 'project_user_' . $user->getId(), 'onclick' => "App.modules.updatePermissionsForm.userCheckboxClick(" . $user->getId() . ", " . $company->getId() . ")")) ?> <label class="checkbox" for="<?php echo 'project_user_' . $user->getId() ?>"><?php echo clean($user->getDisplayName()) ?></label>
							<?php } // if ?>
							<?php if($user->isAdministrator()) { ?>
										<span class="desc">(<?php echo lang('administrator') ?>)</span>
							<?php } // if ?>
									</td>
									<td>
							<?php if(!$company->isOwner()) { ?>
										<div class="projectUserPermissions" id="user_<?php echo $user->getId() ?>_permissions">
										<div><?php echo checkbox_field('project_user_' . $user->getId() . '_all', $user->hasAllProjectPermissions(active_or_personal_project()), array('id' => 'project_user_' . $user->getId() . '_all', 'onclick' => "App.modules.updatePermissionsForm.userPermissionAllCheckboxClick(" . $user->getId() . ")")) ?> <label for="<?php echo 'project_user_' . $user->getId() . '_all' ?>" class="checkbox" style="font-weight: bolder"><?php echo lang('all permissions') ?></label></div>
								<?php foreach ($permissions as $permission_id => $permission_text) { ?>						
										<div><?php echo checkbox_field('project_user_' . $user->getId() . "_$permission_id", $user->hasProjectPermission(active_or_personal_project(), $permission_id), array('id' => 'project_user_' . $user->getId() . "_$permission_id", 'onclick' => "App.modules.updatePermissionsForm.userPermissionCheckboxClick(" . $user->getId() . ")")) ?> <label for="<?php echo 'project_user_' . $user->getId() . "_$permission_id" ?>" class="checkbox normal"><?php echo $permission_text ?></label></div>
								<?php } // foreach ?>
										</div>
							<?php } // if ?>
									</td>
								</tr>
							<?php if(!$company->isOwner()) { ?>
									<script type="text/javascript">
										if (!document.getElementById('project_user_<?php echo $user->getId() ?>').checked) {
											document.getElementById('user_<?php echo $user->getId() ?>_permissions').style.display = 'none';
										} // if
									</script>
							<?php } // if ?>
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
							if(!document.getElementById('project_company_<?php echo $company->getId() ?>').checked) {
								document.getElementById('project_company_users_<?php echo $company->getId() ?>').style.display = 'none';
							} // if
						</script>
					<?php } // if ?>
				</fieldset>
				<?php } // if ?>
			<?php } // foreach ?>
			</div>
		<?php } // if ?>
		</div>
		</fieldset>
	<?php } // if ?>
	<!-- /permissions -->
		
	<?php echo submit_button($project->isNew() ? lang('add workspace') : lang('edit workspace')) ?>
</form>
</div>
