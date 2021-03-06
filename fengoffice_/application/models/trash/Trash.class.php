<?php
class Trash {
	function purge_trash() {
		Env::useHelper("permissions");
		$days = config_option("days_on_trash", 0);
		$count = 0;
		if ($days > 0) {
			$date = DateTimeValueLib::now()->add("d", -$days);
			$managers = array(
				'Comments',
				'Companies',
				'Contacts',
				'MailContents',
				'ProjectCharts',
				'ProjectEvents',
				'ProjectFiles',
				'ProjectFileRevisions',
				'ProjectForms',
				'ProjectMessages',
				'ProjectMilestones',
				'ProjectTasks',
				'ProjectWebpages',
			);
			foreach ($managers as $manager_class) {
				$manager = new $manager_class();
				$prevcount = -1;
				while ($prevcount != $count) {
					$prevcount = $count;
					$objects = $manager->findAll(array(
							"include_trashed" => true,
							"conditions" => array("`trashed_by_id` > 0 AND `trashed_on` < ?", $date),
							"limit" => 100,
					));
					if (is_array($objects)) {
						// delete one by one because each one knows what else to delete
						foreach ($objects as $o) {
							try {
								DB::beginWork();
								$ws = $o->getWorkspaces();
								$o->delete();
								ApplicationLogs::createLog($o, $ws, ApplicationLogs::ACTION_DELETE);
								DB::commit();
								$count++;
							} catch (Exception $e) {
								DB::rollback();
								Logger::log("Error delting object in purge_trash: " . $e->getMessage(), Logger::ERROR);
							}
						}
					}
				}
			}			
		}
		return $count;
	}
}
?>