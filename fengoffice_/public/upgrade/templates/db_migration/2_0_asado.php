-- <?php echo $table_prefix ?> og_
-- <?php echo $default_charset ?> DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
-- <?php echo $default_collation ?> collate utf8_unicode_ci
-- <?php echo $engine ?> InnoDB

ALTER TABLE `<?php echo $table_prefix ?>amounts`
 ADD COLUMN `currency_id` smallint unsigned NOT NULL DEFAULT 0,
 ADD COLUMN `exchange_rate` DECIMAL(20,10) NOT NULL DEFAULT 0;

ALTER TABLE `<?php echo $table_prefix ?>quota_amounts`
 ADD COLUMN `currency_id` smallint unsigned NOT NULL DEFAULT 0,
 ADD COLUMN `exchange_rate` DECIMAL(20,10) NOT NULL DEFAULT 0;

UPDATE `<?php echo $table_prefix ?>amounts` `a` SET `a`.`currency_id` = (
 SELECT `p`.`currency_id` FROM `<?php echo $table_prefix ?>payments` `p` WHERE `p`.`object_id` = `a`.`payment_id`
);

UPDATE `<?php echo $table_prefix ?>amounts` `a` SET `a`.`exchange_rate` = (
 SELECT `e`.`value` FROM `<?php echo $table_prefix ?>exchange_rates` `e` WHERE `e`.`currency_id` = `a`.`currency_id` ORDER BY `e`.`date` DESC LIMIT 1
);

UPDATE `<?php echo $table_prefix ?>quota_amounts` `a` SET `a`.`currency_id` = (
 SELECT `q`.`currency_id` FROM `<?php echo $table_prefix ?>quotas` `q` WHERE `q`.`object_id` = `a`.`quota_id`
);

UPDATE `<?php echo $table_prefix ?>quota_amounts` `a` SET `a`.`exchange_rate` = (
 SELECT `e`.`value` FROM `<?php echo $table_prefix ?>exchange_rates` `e` WHERE `e`.`currency_id` = `a`.`currency_id` ORDER BY `e`.`date` DESC LIMIT 1
);

ALTER TABLE `<?php echo $table_prefix ?>payments`
 DROP COLUMN `currency_id`;

ALTER TABLE `<?php echo $table_prefix ?>quotas`
 DROP COLUMN `currency_id`;

ALTER TABLE `<?php echo $table_prefix ?>currencies`
 ADD COLUMN `is_default` BOOL NOT NULL DEFAULT 0;

UPDATE `<?php echo $table_prefix ?>currencies` SET `is_default` = 1 WHERE `id` = 1;

ALTER TABLE `<?php echo $table_prefix ?>exchange_rates`
 ADD INDEX `currency`(`currency_id`, `date`),
 ADD INDEX `date` USING BTREE(`date`);

ALTER TABLE `<?php echo $table_prefix ?>quotas`
 MODIFY COLUMN `pcp_assigned_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
 MODIFY COLUMN `location_assigned_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
 MODIFY COLUMN `period_assigned_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
 MODIFY COLUMN `budgeted_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
 MODIFY COLUMN `expected_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
 MODIFY COLUMN `executed_amount` DECIMAL(20,10) NOT NULL DEFAULT 0;

ALTER TABLE `<?php echo $table_prefix ?>quota_amounts`
 MODIFY COLUMN `amount` DECIMAL(20,10) NOT NULL DEFAULT 0;

ALTER TABLE `<?php echo $table_prefix ?>amounts`
 MODIFY COLUMN `amount` DECIMAL(20,10) NOT NULL DEFAULT 0;

ALTER TABLE `<?php echo $table_prefix ?>exchange_rates`
 MODIFY COLUMN `value` DECIMAL(20,10) NOT NULL DEFAULT 0;

ALTER TABLE `<?php echo $table_prefix ?>reports` CHANGE COLUMN `id` `object_id` INT(10) NOT NULL DEFAULT NULL AUTO_INCREMENT,
 DROP PRIMARY KEY,
 ADD PRIMARY KEY  USING BTREE(`object_id`);
 
INSERT INTO `<?php echo $table_prefix ?>exchange_rates` (`currency_id`,`value`,`date`) VALUES
 (2, 18.85, '2011-05-24 00:00:00'), 
 (3, 26.513, '2011-05-24 00:00:00');
 
INSERT INTO `<?php echo $table_prefix ?>dimension_object_type_contents` (`dimension_id`,`dimension_object_type_id`,`content_object_type_id`, `is_required`, `is_multiple`) VALUES
 (2, 21, 25, 0, 1);
 
 
ALTER TABLE `<?php echo $table_prefix ?>contact_permission_groups`
 ADD INDEX `contact_id` (`contact_id`),
 ADD INDEX `permission_group_id` (`permission_group_id`);

ALTER TABLE `<?php echo $table_prefix ?>searchable_objects`
 ADD INDEX `rel_obj_id` (`rel_object_id`);

CREATE TABLE  `<?php echo $table_prefix ?>sharing_table` (
 `id` int(10) NOT NULL auto_increment,
 `group_id` INTEGER UNSIGNED NOT NULL,
 `object_id` INTEGER UNSIGNED NOT NULL,
 PRIMARY KEY (`id`),
 KEY `group_id` (`group_id`),
 KEY `object_id` (`object_id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
