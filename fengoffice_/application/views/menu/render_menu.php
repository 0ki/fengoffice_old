
<!-- <overview> -->
<div id="menuOverview" class="menuCont">
	<ul class="menu_places">
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/dashboard.png')?>" /><a class="internalLink" href="<?php echo get_url('dashboard', 'index') ?>"><?php echo lang('dashboard'); ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/account.png')?>" /><a class="internalLink" href="<?php echo get_url('account', 'index') ?>"><?php echo lang('account') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/help.png')?>" /><a href="javascript:og.showHelp()"><?php echo lang('help') ?></a></li>
	<li><hr /> </li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/logout.png')?>" /><a href="<?php echo get_url('access', 'logout') ?>"><?php echo lang('logout') ?></a></li>
	</ul>
</div>
<!-- </overview> -->

<!-- <files> -->
<div id="menuFiles" class="menuCont">
	<ul class="menu_places">
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/browse.png')?>" /><a class="internalLink" href="<?php echo get_url('files', 'index') ?>"><?php echo lang('all documents'); ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/me.png')?>" /><a class="internalLink" href="<?php echo get_url('files', 'index', array('user' => logged_user()->getId())) ?>"><?php echo lang('created by me'); ?></a></li>
	<li><a href="#" class="toggle_collapsed" onclick="og.toggle('menu_file_projects', this)"><?php echo lang('by project') ?></a>
		<ul id="menu_file_projects" class="menu_recent" style="display: none">
		<?php if (isset($active_projects) && is_array($active_projects) && count($active_projects)) {
			foreach($active_projects as $project) {
		?>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('project' => $project->getId())) ?>"><?php echo $project->getName() ?></a></li>
		<?php
			}
		}
		?>
		</ul>
	</li>
	<li><a href="#" class="toggle_collapsed" onclick="og.toggle('menu_file_tags', this)"><?php echo lang('by tag') ?></a>
		<ul id="menu_file_tags" class="menu_recent" style="display: none">
		<?php if (isset($tags) && is_array($tags) && count($tags)) {
			foreach($tags as $tag) {
		?>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('tag' => $tag)) ?>"><?php echo $tag ?></a></li>
		<?php
			}
		} else {
		?>
			<li><i>No tags yet</i></li>
		<?php } ?>
		</ul>
	</li>
	<li><a href="#" class="toggle_collapsed" onclick="og.toggle('menu_file_type', this)"><?php echo lang('by type') ?></a>
		<ul id="menu_file_type" class="menu_recent" style="display: none">
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('type' => 'txt')) ?>">Documents</a></li>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('type' => 'sprd')) ?>">Spreadsheets</a></li>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('type' => 'prsn')) ?>">Presentations</a></li>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('type' => 'image')) ?>">Images</a></li>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('type' => 'audio')) ?>">Audio</a></li>
			<li><a class="internalLink" href="<?php echo get_url('files', 'index', array('type' => 'video')) ?>">Video</a></li>
		</ul>
	</li>
	<!-- <recent documents> -->
	<li>
		<a href="#" class="toggle_collapsed" onclick="og.toggle('menu_file_recent', this)"><?php echo lang('recent documents') ?></a>
		<ul id="menu_file_recent" class="menu_recent" style="display: none">
		<?php if(isset($recent_files) && is_array($recent_files) && count($recent_files)) { ?>		
		<?php
			foreach($recent_files as $file) {
		?>
		<li>
			<a class="internalLink" href="<?php echo get_url('files', 'open_file', array('id' => $file->getId())) ?>"><?php echo $file->getFilename() ?></a>
		</li>
		<?php
			}
		} else {
		?>
			<li><i>No recent documents</i></li>
		<?php } ?>
		</ul>
	</li>
	<!-- </recent documents> -->
	</ul>
	<br>
	<ul class="menu_actions">
	<li><a class="internalLink" href="<?php echo get_url('files', 'add_document') ?>"><?php echo lang('add document'); ?></a></li>
	<li><a class="internalLink" href="<?php echo get_url('files', 'add_spreadsheet') ?>"><?php echo lang('add spreadsheet'); ?></a></li>
	<li><a class="internalLink" href="<?php echo get_url('files', 'add_presentation') ?>"><?php echo lang('add presentation'); ?></a></li>
	<li><a class="internalLink" href="<?php echo get_url('files', 'add_file') ?>"><?php echo lang('upload file'); ?></a></li>
	</ul>
</div>
<!-- </files> -->

<!-- <project> -->
<div id="menuProject" class="menuCont">
	<ul class="menu_places">
	<!--  li><img class="menu_place_ico" src="<?php echo get_image_url('menu/projects.png')?>" /><?php echo lang('current project') ?>:
		<select id="menu_projects_shortcut" onchange="if (this.value != '') location.href = this.value" value="">
			<?php
			if (isset($active_projects) && is_array($active_projects) && count($active_projects)) {
				foreach($active_projects as $project) {
			?>
			<option value="<?php echo $project->getOverviewUrl() ?>"<?php if (active_project()->getId() == $project->getId()) { echo ' selected="selected"'; } ?>><?php echo clean($project->getName()) ?></option>
			<?php
				}
			}
			?>
		</select>
	</li -->
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/overview.png')?>" /><a class="internalLink" href="<?php echo get_url('project', 'index') ?>"><?php echo lang('project').' '.lang('overview') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/messages.png')?>" /><a class="internalLink" href="<?php echo get_url('message', 'index') ?>"><?php echo lang('messages') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tasks.png')?>" /><a class="internalLink" href="<?php echo get_url('task', 'index') ?>"><?php echo lang('tasks') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/milestones.png')?>" /><a class="internalLink" href="<?php echo get_url('milestone', 'index') ?>"><?php echo lang('milestones') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/documents.png')?>" /><a class="internalLink" href="<?php echo get_url('files', 'index', array('project' => active_project()->getId())) ?>"><?php echo lang('files') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tags.png')?>" /><a class="internalLink" href="<?php echo get_url('project', 'tags') ?>"><?php echo lang('tags') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/forms.png')?>" /><a class="internalLink" href="<?php echo get_url('form', 'index') ?>"><?php echo lang('forms') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/people.png')?>" /><a class="internalLink" href="<?php echo get_url('project', 'people') ?>"><?php echo lang('people') ?></a></li>
	</ul>
	<br>
	<ul class="menu_actions">
	<li><a class="internalLink" href="<?php echo get_url('project', 'add') ?>"><?php echo lang('add project'); ?></a></li>
	</ul>
</div>
<!-- </project> -->

<?php
if (CompanyWebsite::instance()->getLoggedUser()->isAdministrator()) {
?>
<!-- <administration> -->
<div id="menuAdministration" class="menuCont">
	<ul class="menu_places">
		<!-- li><img class="menu_place_ico" src="<?php echo get_image_url('menu/administration.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'index') ?>"><?php echo lang('index') ?></a></li -->
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/company.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'company') ?>"><?php echo lang('company') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/members.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'members') ?>"><?php echo lang('members') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/clients.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'clients') ?>"><?php echo lang('clients') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/projects.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'projects') ?>"><?php echo lang('projects') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/configuration.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'configuration') ?>"><?php echo lang('configuration') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tools.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'tools') ?>"><?php echo lang('administration tools') ?></a></li>
		<!-- li><img class="menu_place_ico" src="<?php echo get_image_url('menu/upgrade.png')?>" /><a class="internalLink" href="<?php echo get_url('administration', 'upgrade') ?>"><?php echo lang('upgrade') ?></a></li -->
	</ul>
</div>
<!-- </administration> -->
<?php } ?>
