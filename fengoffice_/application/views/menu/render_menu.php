
<!-- <overview> -->
<div id="overview" class="menuhandle" onclick="layoutSelectMenu(this)" onmouseover="layoutMenuOver(this)" onmouseout="layoutMenuOut(this)">
	<img class="menu_ico" src="<?php echo get_image_url('layout/overview.png')?>"><span class="menu_text"><?php echo lang('overview') ?></span>
</div>
<div id="overviewcont" class="menucont" style="display: none;">
	<ul class="menu_places">
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/dashboard.png')?>"><a href="<?php echo get_url('dashboard', 'index') ?>"><?php echo lang('dashboard'); ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/projects.png')?>"><a href="<?php echo get_url('dashboard', 'my_projects') ?>"><?php echo lang('my projects') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/documents.png')?>"><a href="<?php echo get_url('files', 'index') ?>"><?php echo lang('my documents') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tasks.png')?>"><a href="<?php echo get_url('task', 'index') ?>"><?php echo lang('my tasks') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/account2.png')?>"><a href="<?php echo get_url('account', 'index') ?>"><?php echo lang('account') ?></a></li>
	</ul>
	<br>
	<ul class="menu_actions">
	<li><a href="<?php echo get_url('project', 'add') ?>"><?php echo lang('add project'); ?></a></li>
	</ul>
</div>
<!-- </overview> -->

<!-- <files> -->
<div id="files" class="menuhandle" onclick="layoutSelectMenu(this)" onmouseover="layoutMenuOver(this)" onmouseout="layoutMenuOut(this)">
	<img class="menu_ico" src="<?php echo get_image_url('layout/files.png')?>"><span class="menu_text"><?php echo lang('documents') ?></span>
</div>
<div id="filescont" class="menucont" style="display: none;">
	<ul class="menu_places">
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/browse.png')?>"><a href="<?php echo get_url('files', 'index', array('active_project' => logged_user()->getPersonalProject()->getId())) ?>"><?php echo lang('browse documents'); ?></a></li>
	<!-- <recent documents> -->
	<?php if(isset($application_logs_entries) && is_array($application_logs_entries) && count($application_logs_entries)) { ?>
	<li>
		<img class="menu_place_ico" src="<?php echo get_image_url('menu/recent.png')?>"><?php echo lang('recent documents') ?>:
		<ul class="menu_recent">
		
		<?php
			$i = 1;
			$recent_files = array();
			foreach ($application_logs_entries as $application_log_entry) {
				$object = $application_log_entry->getObject();
				if ($object instanceof ProjectFile) {
					$recent_files[$object->getObjectName()] = $object;
					$i++;
					if ($i > 3) {
						break;
					}
				}
			}
			foreach ($recent_files as $filename => $file) {
		?>
		<li>
			<a href="<?php echo $file->getObjectUrl() ?>"><?php echo $filename ?></a>
		</li>
		<?php
			}
		?>
		</ul>
	</li>
	<?php } ?>
	<!-- </recent documents> -->
	</ul>
	<br>
	<ul class="menu_actions">
	<li><a href="<?php echo get_url('files', 'add_document', array('active_project' => logged_user()->getPersonalProject()->getId())) ?>"><?php echo lang('add document'); ?></a></li>
	<li><a href="<?php echo get_url('files', 'add_spreadsheet', array('active_project' => logged_user()->getPersonalProject()->getId())) ?>"><?php echo lang('add spreadsheet'); ?></a></li>
	<li><a href="<?php echo get_url('files', 'add_presentation', array('active_project' => logged_user()->getPersonalProject()->getId())) ?>"><?php echo lang('add presentation'); ?></a></li>
	<li><a href="<?php echo get_url('files', 'add_file', array('active_project' => logged_user()->getPersonalProject()->getId())) ?>"><?php echo lang('upload file'); ?></a></li>
	</ul>
</div>
<!-- </files> -->

<!-- <project> -->
<div id="project" class="menuhandle" onclick="layoutSelectMenu(this)" onmouseover="layoutMenuOver(this)" onmouseout="layoutMenuOut(this)">
	<img class="menu_ico" src="<?php echo get_image_url('layout/project.png')?>"><span class="menu_text"><?php echo lang('project') ?></span>
</div>
<div id="projectcont" class="menucont" style="display: none;">
	<ul class="menu_places">
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/projects.png')?>"><?php echo lang('select') ?>:
		<select id="menu_projects_shortcut" onchange="if (this.value != '') location.href = this.value" value="">
			<option value="">-- Choose --</option>
			<?php
			if(isset($active_projects) && is_array($active_projects) && count($active_projects)) {
				foreach($active_projects as $project) {
			?>
			<option value="<?php echo $project->getOverviewUrl() ?>"><?php echo clean($project->getName()) ?></option>
			<?php
				}
			}
			?>
		</select>
	</li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/overview.png')?>"><a href="<?php echo get_url('project', 'index') ?>"><?php echo lang('project').' '.lang('overview') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/messages.png')?>"><a href="<?php echo get_url('message', 'index') ?>"><?php echo lang('messages') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tasks.png')?>"><a href="<?php echo get_url('task', 'index') ?>"><?php echo lang('tasks') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/milestones.png')?>"><a href="<?php echo get_url('milestone', 'index') ?>"><?php echo lang('milestones') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/documents.png')?>"><a href="<?php echo get_url('files', 'index') ?>"><?php echo lang('files') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tags.png')?>"><a href="<?php echo get_url('project', 'tags') ?>"><?php echo lang('tags') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/forms.png')?>"><a href="<?php echo get_url('form', 'index') ?>"><?php echo lang('forms') ?></a></li>
	<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/people.png')?>"><a href="<?php echo get_url('project', 'people') ?>"><?php echo lang('people') ?></a></li>
	</ul>
</div>
<!-- </project> -->

<!-- <administration> -->
<div id="administration" class="menuhandle" onclick="layoutSelectMenu(this)" onmouseover="layoutMenuOver(this)" onmouseout="layoutMenuOut(this)">
	<img class="menu_ico" src="<?php echo get_image_url('layout/options.png')?>"><span class="menu_text"><?php echo lang('administration') ?></span>
</div>
<div id="administrationcont" class="menucont" style="display: none;">
	<ul class="menu_places">
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/administration.png')?>"><a href="<?php echo get_url('administration', 'index') ?>"><?php echo lang('index') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/members.png')?>"><a href="<?php echo get_url('administration', 'members') ?>"><?php echo lang('members') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/clients.png')?>"><a href="<?php echo get_url('administration', 'clients') ?>"><?php echo lang('clients') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/projects.png')?>"><a href="<?php echo get_url('administration', 'projects') ?>"><?php echo lang('projects') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/configuration.png')?>"><a href="<?php echo get_url('administration', 'configuration') ?>"><?php echo lang('configuration') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/tools.png')?>"><a href="<?php echo get_url('administration', 'tools') ?>"><?php echo lang('administration tools') ?></a></li>
		<li><img class="menu_place_ico" src="<?php echo get_image_url('menu/upgrade.png')?>"><a href="<?php echo get_url('administration', 'upgrade') ?>"><?php echo lang('upgrade') ?></a></li>
	</ul>
</div>
<!-- </administration> -->

<script>
layoutCurrent = document.getElementById('<?php echo $selected_menu_option ?>cont');
layoutCurrent.style.display = 'block';
</script>