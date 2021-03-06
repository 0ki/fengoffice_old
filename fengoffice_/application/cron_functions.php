<?php

function check_mail() {
	_log("Checking email...");
	MailUtilities::getmails(null, $err, $succ, $errAcc, $received);
	_log("$received emails fetched.");
}

function purge_trash() {
	_log("Purging trash...");
	$count = Trash::purge_trash();
	_log("$count objects deleted.");
}

function check_upgrade() {
	_log("Checking for upgrades...");
	$version_feed = VersionChecker::check(true);
	if (!($version_feed instanceof VersionsFeed)) {
		_log("Error checking for upgrades.");
	} else {
		if ($version_feed->hasNewVersions(product_version())) {
			_log("Found new versions.");
		} else {
			_log("No new versions.");
		}
	}
}

function send_reminders() {
	_log("Sending reminders...");
	$sent = 0;
	$ors = ObjectReminders::getDueReminders();
	foreach ($ors as $or) {
		$function = $or->getType();
		try {
			$ret = 0;
			Hook::fire($function, $or, $ret);
			$sent += $ret;
		} catch (Exception $ex) {
			_log("Error sending reminder: " . $ex->getMessage());
		}
	}
	_log("$sent reminders sent.");
}

function _log($message) {
	echo date("Y-m-d H:i:s") . " - $message\n";
}

?>