INSERT INTO `<?php echo $table_prefix ?>dimensions` (`code`, `name`, `is_root`, `is_manageable`, `allows_multiple_selection`, `defines_permissions`, `is_system`,`default_order`, `options` ) VALUES
 ('workspaces', 'Workspaces', 1, 1, 0, 1, 1,-10,'{"defaultAjax":{"controller":"dashboard", "action": "init_overview"}, "quickAdd":true,"showInPaths":true}'),
 ('tags', 'Tags', 1, 1, 0, 0, 1,-9,'{"defaultAjax":{"controller":"dashboard", "action": "init_overview"},"quickAdd":true,"showInPaths":true}');

INSERT INTO `<?php echo $table_prefix ?>dimension_object_types` (`dimension_id`, `object_type_id`, `is_root`) VALUES
 ((SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces'), (SELECT `id` FROM `<?php echo $table_prefix ?>object_types` WHERE `name`='workspace'), 1),
 ((SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='tags'), (SELECT `id` FROM `<?php echo $table_prefix ?>object_types` WHERE `name`='tag'), 1);

INSERT INTO `<?php echo $table_prefix ?>dimension_object_type_hierarchies` (`dimension_id`, `parent_object_type_id`, `child_object_type_id`) VALUES
 ((SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces'), (SELECT `id` FROM `<?php echo $table_prefix ?>object_types` WHERE `name`='workspace'), (SELECT `id` FROM `<?php echo $table_prefix ?>object_types` WHERE `name`='workspace'));

INSERT INTO `<?php echo $table_prefix ?>dimension_object_type_contents` (`dimension_id`,`dimension_object_type_id`,`content_object_type_id`, `is_required`, `is_multiple`)
 SELECT 
 	(SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces'),
 	(SELECT `id` FROM `<?php echo $table_prefix ?>object_types` WHERE `name`='workspace'),
 	`id`, 0, 1
 FROM `<?php echo $table_prefix ?>object_types` 
 WHERE `type` IN ('content_object', 'comment', 'located')
 ON DUPLICATE KEY UPDATE dimension_id=dimension_id;

INSERT INTO `<?php echo $table_prefix ?>dimension_object_type_contents` (`dimension_id`,`dimension_object_type_id`,`content_object_type_id`, `is_required`, `is_multiple`)
 SELECT 
 	(SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='tags'),
 	(SELECT `id` FROM `<?php echo $table_prefix ?>object_types` WHERE `name`='tag'),
 	`id`, 0, 1
 FROM `<?php echo $table_prefix ?>object_types` 
 WHERE `type` IN ('content_object', 'comment', 'located')
 ON DUPLICATE KEY UPDATE dimension_id=dimension_id;

INSERT INTO `<?php echo $table_prefix ?>contact_dimension_permissions` (`permission_group_id`, `dimension_id`, `permission_type`) VALUES
 (1, (SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces'), 'allow all');


DELETE FROM `<?php echo $table_prefix ?>config_options` WHERE `name` IN (
	'user_email_fetch_count',
	'sent_mails_sync',
	'check_spam_in_subject'
);

DELETE FROM `<?php echo $table_prefix ?>contact_config_options` WHERE `name` IN (
	'view deleted accounts emails',
	'block_email_images',
	'draft_autosave_timeout',
	'attach_docs_content',
	'email_polling',
	'show_unread_on_title',
	'max_spam_level',
	'create_contacts_from_email_recipients',
	'mail_drag_drop_prompt',
	'show_emails_as_conversations',
	'mails account filter',
	'mails classification filter',
	'mails read filter',
	'hide_quoted_text_in_emails',
	'mail_account_err_check_interval',
	'classify_mail_with_conversation',
	'TM show time type',
	'TM report show time type',
	'TM user filter',
	'TM tasks user filter',
	'show emails widget',
	'always show unread mail in dashboard',
	'emails_widget_expanded',
	'show_context_help',
	'show charts widget',
	'show dashboard info widget',
	'drag_drop_prompt',
	'rememberGUIState'
);

UPDATE `<?php echo $table_prefix ?>contact_config_options` 
 SET default_value = concat(default_value,',', (SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces') ) 
 WHERE name='root_dimensions';

DELETE FROM `<?php echo $table_prefix ?>contact_config_categories` WHERE `name` IN (
	'time panel',
	'mails panel'
);

DELETE FROM `<?php echo $table_prefix ?>administration_tools` WHERE `name` IN (
	'mass_mailer'
);

DELETE FROM `<?php echo $table_prefix ?>cron_events` WHERE `name` IN (
	'check_mail',
	'check_upgrade'	
);
