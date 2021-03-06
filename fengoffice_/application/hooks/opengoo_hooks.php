<?php
Hook::register("opengoo");

/* List of available hooks:
 * - render_page_actions($object:(ProjectDataObject), &$unused)
 * - render_object_properties($object:(ProjectDataObject), &$unused)
 * 
 * - reminder_email($reminder:(ObjectReminder), &$count:(count of reminders sent))
 * - render_userbox_crumbs($unused, &$array:(array of assoc(url, text, target)))
 * - autoload_javascripts($unused, &$array:(array of javascripts to load))
 */

function opengoo_reminder_email($reminder, &$ret) {
	$object = $reminder->getObject();
	$date = $object->getColumnValue($reminder->getContext());
	if ($reminder->getContext() == "due_date" && ($object instanceof ProjectTask || $object instanceof ProjectMilestone)) {
		if ($object->isCompleted()) {
			// don't send due date reminders for completed tasks
			$reminder->delete();
			return;
		}
	}
	if (!$date instanceof DateTimeValue) return;
	if ($date->getTimestamp() + 24*60*60 < DateTimeValueLib::now()->getTimestamp()) {
		// don't send reminders older than a day
		$reminder->delete();
		throw new Exception("Reminder too old");
	}
	Notifier::objectReminder($reminder);
	$reminder->delete();
	$ret++;
}

?>