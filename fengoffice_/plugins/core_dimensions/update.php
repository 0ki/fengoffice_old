<?php

/**
 * Add permissions for timeslots, templates and reports in persons dimension
 * @author Alvaro Torterola <alvaro.torterola@fengoffice.com>
 */
function core_dimensions_update_1_2() {
	DB::execute("
		INSERT INTO ".TABLE_PREFIX."dimension_object_type_contents (dimension_id, dimension_object_type_id, content_object_type_id, is_required, is_multiple)
		 SELECT (SELECT id FROM ".TABLE_PREFIX."dimensions WHERE code = 'feng_persons'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='person'), ot.id, 0, 1
		 FROM ".TABLE_PREFIX."object_types ot WHERE ot.type IN ('located')
		ON DUPLICATE KEY UPDATE dimension_id=dimension_id;
	");
	
	DB::execute("
		INSERT INTO ".TABLE_PREFIX."dimension_object_type_contents (dimension_id, dimension_object_type_id, content_object_type_id, is_required, is_multiple)
		 SELECT (SELECT id FROM ".TABLE_PREFIX."dimensions WHERE code = 'feng_persons'), (SELECT id FROM ".TABLE_PREFIX."object_types WHERE name='company'), ot.id, 0, 1
		 FROM ".TABLE_PREFIX."object_types ot WHERE ot.type IN ('located')
		ON DUPLICATE KEY UPDATE dimension_id=dimension_id;
	");
	
	DB::execute("
		INSERT INTO `".TABLE_PREFIX."contact_member_permissions` (`permission_group_id`, `member_id`, `object_type_id`, `can_write`, `can_delete`)
		 SELECT `c`.`permission_group_id`, `m`.`id`, `ot`.`id`, (`c`.`object_id` = `m`.`object_id`) as `can_write`, (`c`.`object_id` = `m`.`object_id`) as `can_delete`
		 FROM `".TABLE_PREFIX."contacts` `c` JOIN `".TABLE_PREFIX."members` `m`, `".TABLE_PREFIX."object_types` `ot`
		 WHERE `c`.`is_company`=0
		 	AND `c`.`user_type`!=0
		 	AND `ot`.`type` IN ('located')
		 	AND `m`.`dimension_id` IN (SELECT `id` FROM `".TABLE_PREFIX."dimensions` WHERE `code` = 'feng_persons')
		 	AND `c`.`object_id` = `m`.`object_id`
		ON DUPLICATE KEY UPDATE member_id=member_id;
	");
}