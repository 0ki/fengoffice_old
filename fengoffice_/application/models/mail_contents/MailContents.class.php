<?php

/**
 * MailContents
 *
 * @author Carlos Palma <chonwil@gmail.com>
 */
class MailContents extends BaseMailContents {
	 
	public static function getWorkspaceString($ids = '?') {
		return " `id` IN (SELECT `object_id` FROM `" . TABLE_PREFIX . "workspace_objects` WHERE `object_manager` = 'MailContents' AND `workspace_id` IN ($ids)) ";
	}
	
	static function mailRecordExists($account_id, $uid, $folder = null) {
		$folder_cond = is_null($folder) ? '' : " AND `imap_folder_name` = '$folder'";
		$sql = "SELECT `id` FROM `". TABLE_PREFIX ."mail_contents` WHERE `account_id` = $account_id AND `uid` = '$uid' $folder_cond LIMIT 1";
		$rows = DB::executeAll($sql);
		return is_array($rows) && count($rows) > 0;
	}
	 
	/**
	 * Return mails that belong to specific project
	 *
	 * @param Project $project
	 * @return array
	 */
	static function getProjectMails(Project $project, $start = 0, $limit = 0) {
		$condstr = self::getWorkspaceString();
		return self::findAll(array(
			'conditions' => array($condstr, $project->getId()),
			'offset' => $start,
			'limit' => $limit,
		));
	} // getProjectMails

	function delete($condition) {
		if(isset($this) && instance_of($this, 'MailContents')) {
			// Delete contents from filesystem
			$sql = "SELECT `content_file_id` FROM ".self::instance()->getTableName(true)." WHERE $condition";
			$rows = DB::executeAll($sql);
				
			if (is_array($rows)) {
				$count = 0;$err=0;
				foreach ($rows as $row) {
					if (isset($row['content_file_id']) && $row['content_file_id'] != '') {
						try {
							FileRepository::deleteFile($row['content_file_id']);
							$count++;
						} catch (Exception $e) {
							$err++;
							Logger::log($e->getMessage());
						}
					}
				}
				Logger::log("Mails deleted: $count --- errors: $err");
			}
			$sql = "UPDATE ".self::instance()->getTableName(true)." SET `is_deleted` = 1 WHERE $condition";
			return DB::executeAll($sql);
			//return parent::delete($condition);
		} else {
			return MailContents::instance()->delete($condition);
		}
	}
	
	/**
	 * Returns a list of emails according to the requested parameters
	 *
	 * @param string $tag
	 * @param array $attributes
	 * @param Project $project
	 * @return array
	 */
	function getEmails($tag = null, $account_id = null, $state = null, $read_filter = "", $classif_filter = "", $project = null, $start = null, $limit = null, $order_by = 'sent_date', $dir = 'ASC') {
		// Check for accounts
		$accountConditions = "";
		$singleAccount = false;
		if (isset($account_id) && $account_id > 0) { //Single account
			$acc = MailAccounts::findById($account_id);
			if ($acc && $acc->canView(logged_user())) {
				$singleAccount = true;
				$accounts = array($acc);
			}
		} else { // All user accounts
			$accounts = MailAccounts::findAll(array(
      			'conditions' => '`user_id` = ' . logged_user()->getId())
			);
		}

		if (isset($accounts) && count($accounts) > 0) {
			$list = "";
			foreach ($accounts as $acc) {
				$list .= "," . $acc->getId();
			}
			$accountConditions = "`account_id` IN (" . substr($list, 1) . ")";
		}
		if ($accountConditions == "") {
			$accountConditions = "`account_id` = 0";  // cannot view any valid accounts but can see project emails
		}

		// Show deleted accounts' mails
		if (user_config_option('view deleted accounts emails', true)) {
			$accountConditions = "($accountConditions OR (SELECT count(*) FROM `" . TABLE_PREFIX . "mail_accounts` WHERE `id` = `account_id`) > 0)";
		}
					
		// Check for unclassified emails
		if ($classif_filter != '' && $classif_filter != 'all') {
			if ($classif_filter == 'unclassified') $classified = "AND NOT ";
			else $classified = "AND ";			
			$classified .= "`id` IN (SELECT `object_id` FROM `".TABLE_PREFIX."workspace_objects` WHERE `object_manager` = 'MailContents')";
		} else {
			$classified = "";
		}

		// Check for drafts emails
		if ($state == "draft") {
			$stateConditions = "AND state = '2'";
		} else if ($state == "sent") {
			$stateConditions = "AND state = '1'";
		} else if ($state == "received") {
			$stateConditions = "AND state = '0'";
		} else {
			$stateConditions = "";
		}

		// Check read emails
		if ($read_filter != "" && $read_filter != "all") {
			if ($read_filter == "unread") $read = "AND NOT ";
			else $read = "AND "; 
			$read .= "`id` IN (SELECT `rel_object_id` FROM `" . TABLE_PREFIX . "read_objects` `t` WHERE `user_id` = " . logged_user()->getId() . " AND `t`.`rel_object_manager` = 'MailContents' AND `t`.`is_read` = '1')";
		} else {
			$read = "";
		}

		//Check for tags
		if (!isset($tag) || $tag == '' || $tag == null) {
			$tagstr = ""; // dummy condition
		} else {
			$tagstr = "AND (SELECT count(*) FROM `" . TABLE_PREFIX . "tags` WHERE `" .
					TABLE_PREFIX . "mail_contents`.`id` = `" . TABLE_PREFIX . "tags`.`rel_object_id` AND `" .
					TABLE_PREFIX . "tags`.`tag` = " . DB::escape($tag) . " AND `" . TABLE_PREFIX . "tags`.`rel_object_manager` ='MailContents' ) > 0 ";
		}

		//Check for projects (uses accountConditions
		if ($project instanceof Project) {
			$pids = $project->getAllSubWorkspacesQuery(true, logged_user());
			$wspace_obj_string = self::getWorkspaceString($pids);

			if ($singleAccount) {
				$projectConditions = " AND ($accountConditions AND $wspace_obj_string)";
			} else {
				$projectConditions = " AND " . (logged_user()->isMemberOfOwnerCompany() ?
						$wspace_obj_string : "(($accountConditions AND $wspace_obj_string) OR ($wspace_obj_string AND `is_private` = 0))");
			}
		} else {
			$pids = logged_user()->getWorkspacesQuery();
			$wspace_obj_string = self::getWorkspaceString($pids);

			if ($singleAccount) {
				$projectConditions = "AND $accountConditions";
			} else {
				$projectConditions = "AND ($accountConditions OR $wspace_obj_string)" .
						(logged_user()->isMemberOfOwnerCompany() ? '' : " AND is_private = 0");
			}
		}
		$permissions = ' AND ( ' . permissions_sql_for_listings(MailContents::instance(), ACCESS_LEVEL_READ, logged_user(), ($project instanceof Project ? $project->getId() : 0)) .')';

		//$not_classified_by_other_user = " NOT EXISTS (SELECT `id` FROM $table_name mc WHERE mc.`subject` = $table_name.`subject` AND mc.`sent_date` = $table_name.`sent_date` AND mc.`from` = $table_name.`from` AND mc.`account_id` <> $table_name.`account_id` AND $wspace_obj_string)";
		$conditions = " `is_deleted` = 0 $projectConditions  $tagstr $classified $read $stateConditions $permissions";	//. " AND $not_classified_by_other_user";

		$page = (integer) ($start / $limit) + 1;
		$order = "$order_by $dir";

		return self::paginate(array(
			'conditions' => $conditions,
			'order' => $order
		), $limit, $page);
	}

} // MailContents

?>