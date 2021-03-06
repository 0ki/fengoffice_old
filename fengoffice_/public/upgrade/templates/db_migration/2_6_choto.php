-- <?php echo $table_prefix ?> <?php echo $table_prefix ?>
-- <?php echo $default_charset ?> DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
-- <?php echo $default_collation ?> collate utf8_unicode_ci
-- <?php echo $engine ?> InnoDB

CREATE TABLE `<?php echo $table_prefix ?>member_custom_properties` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `object_type_id` int(10) unsigned NOT NULL,
  `name` varchar(255) <?php echo $default_collation ?> NOT NULL,
  `type` varchar(255) <?php echo $default_collation ?> NOT NULL,
  `description` text <?php echo $default_collation ?> NOT NULL,
  `values` text <?php echo $default_collation ?> NOT NULL,
  `default_value` text <?php echo $default_collation ?> NOT NULL,
  `is_system` tinyint(1) NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `is_multiple_values` tinyint(1) NOT NULL,
  `property_order` int(10) NOT NULL,
  `visible_by_default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

CREATE TABLE IF NOT EXISTS `<?php echo $table_prefix ?>member_custom_property_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `custom_property_id` int(10) NOT NULL,
  `value` text <?php echo $default_collation ?> NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=<?php echo $engine ?> <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>widgets` (`name`,`title`,`plugin_id`,`path`,`default_options`,`default_section`,`default_order`,`icon_cls`) VALUES 
('active_context_info', 'active context info', 0, '', '', 'left', 0, 'ico-workspace')
ON DUPLICATE KEY UPDATE name=name;";

ALTER TABLE `<?php echo $table_prefix ?>custom_property_values` MODIFY COLUMN `value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE `<?php echo $table_prefix ?>members` ADD COLUMN `color` INTEGER UNSIGNED NOT NULL DEFAULT 0;

UPDATE <?php echo $table_prefix ?>members SET color=(SELECT color FROM <?php echo $table_prefix ?>workspaces w WHERE w.object_id=<?php echo $table_prefix ?>members.object_id) 
WHERE object_type_id=(SELECT id FROM <?php echo $table_prefix ?>object_types WHERE name='workspace');
	
INSERT INTO `<?php echo $table_prefix ?>contact_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
	('task panel', 'quick_add_task_view_dimensions_combos', '', 'ManageableDimensionsConfigHandler', '0', '0', 'dimensions ids for skip');
					
UPDATE `<?php echo $table_prefix ?>contact_config_options` 
	SET default_value = concat((SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces'),',', (SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='customer_project'),',', (SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='tags')) 
	WHERE name='quick_add_task_view_dimensions_combos';
					
INSERT INTO `<?php echo $table_prefix ?>contact_config_options` (`category_name`, `name`, `default_value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
	('time panel', 'add_timeslot_view_dimensions_combos', '', 'ManageableDimensionsConfigHandler', '0', '0', 'dimensions ids for skip'),
	('task panel', 'show_notify_checkbox_in_quick_add', '0', 'BoolConfigHandler', 0, 0, 'Show notification checkbox in quick add task view');
					
UPDATE `<?php echo $table_prefix ?>contact_config_options` 
	SET default_value = concat((SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='workspaces'),',', (SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='customer_project'),',', (SELECT `id` FROM `<?php echo $table_prefix ?>dimensions` WHERE `code`='tags')) 
	WHERE name='add_timeslot_view_dimensions_combos';

UPDATE `<?php echo $table_prefix ?>contact_config_categories` 
	SET is_system = 0 
	WHERE name='time panel';

UPDATE <?php echo $table_prefix ?>dimension_object_type_contents SET is_multiple=1 
 WHERE content_object_type_id =(SELECT id FROM <?php echo $table_prefix ?>object_types WHERE name = 'milestone') 
 AND dimension_object_type_id IN (SELECT id FROM <?php echo $table_prefix ?>object_types WHERE name IN ('customer','project','folder','project_folder','customer_folder'));

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES
('general', 'milestone_selector_filter', 'current_and_parents', 'MilestoneSelectorFilterConfigHandler', 0, 0, NULL);
