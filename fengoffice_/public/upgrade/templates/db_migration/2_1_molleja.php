-- <?php echo $table_prefix ?> fo_
-- <?php echo $default_charset ?> DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
-- <?php echo $default_collation ?> collate utf8_unicode_ci
-- <?php echo $engine ?> InnoDB

ALTER TABLE `<?php echo $table_prefix ?>members`
 ADD COLUMN `archived_by_id` INTEGER UNSIGNED NOT NULL,
 ADD COLUMN `archived_on` DATETIME NOT NULL,
 ADD INDEX `archived_on`(`archived_on`);

INSERT INTO `<?php echo $table_prefix ?>file_types` (`id` ,`extension` ,`icon` ,`is_searchable` ,`is_image`) VALUES
 ('34', 'odt', 'doc.png', '1', '0'), ('35', 'fodt', 'doc.png', '1', '0')
ON DUPLICATE KEY UPDATE id=id;