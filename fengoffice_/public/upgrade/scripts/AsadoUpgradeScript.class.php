<?php

/**
 * Pastafrola upgrade script will upgrade FengOffice 2.0-beta to FengOffice 2.0
 *
 * @package ScriptUpgrader.scripts
 * @version 1.1
 * @author Alvaro Torterola <alvaro.torterola@fengoffice.com>
 */
class AsadoUpgradeScript extends ScriptUpgraderScript {

	/**
	 * Array of files and folders that need to be writable
	 *
	 * @var array
	 */
	private $check_is_writable = array(
		'/config/config.php',
		'/config',
		'/cache',
		'/tmp',
		'/upload'
	 ); // array

	 /**
	 * Array of extensions taht need to be loaded
	 *
	 * @var array
	 */
	private $check_extensions = array(
		'mysql', 'gd', 'simplexml'
	); // array

	 /**
	 * Construct the PastafrolaUpgradeScript
	 *
	 * @param Output $output
	 * @return PastafrolaUpgradeScript
	 */
	function __construct(Output $output) {
		parent::__construct($output);
		$this->setVersionFrom('1.7.5');
		$this->setVersionTo('2.0-beta4');
	} // __construct

	function getCheckIsWritable() {
		return $this->check_is_writable;
	}

	function getCheckExtensions() {
		return $this->check_extensions;
	}
	
	/**
	 * Execute the script
	 *
	 * @param void
	 * @return boolean
	 */
	function execute() {
		// ---------------------------------------------------
		//  Check MySQL version
		// ---------------------------------------------------

		$mysql_version = mysql_get_server_info($this->database_connection);
		if($mysql_version && version_compare($mysql_version, '4.1', '>=')) {
			$constants['DB_CHARSET'] = 'utf8';
			@mysql_query("SET NAMES 'utf8'", $this->database_connection);
			tpl_assign('default_collation', $default_collation = 'collate utf8_unicode_ci');
			tpl_assign('default_charset', $default_charset = 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
		} else {
			tpl_assign('default_collation', $default_collation = '');
			tpl_assign('default_charset', $default_charset = '');
		} // if

		$installed_version = installed_version();
		
		$t_prefix = TABLE_PREFIX;
		if (version_compare($installed_version, '1.7.5') <= 0 && TABLE_PREFIX != "fo_") $t_prefix = "fo_";
		tpl_assign('table_prefix', $t_prefix);
		
		if (defined('DB_ENGINE')) tpl_assign('engine', DB_ENGINE);
		else tpl_assign('engine', 'InnoDB');

		// ---------------------------------------------------
		//  Execute migration
		// ---------------------------------------------------
		
		// RUN QUERIES
		$total_queries = 0;
		$executed_queries = 0;
		
		if (version_compare($installed_version, $this->getVersionFrom()) <= 0) {
			// upgrading from a version lower than this script's 'from' version
			$upgrade_script = tpl_fetch(get_template_path('db_migration/2_0_asado'));
		} else {
			// upgrading from a pre-release of this version (beta, rc, etc)
			$upgrade_script = "";
			
			if (version_compare($installed_version, '2.0-beta2') < 0) {
				$upgrade_script .= "
					ALTER TABLE `" . TABLE_PREFIX . "amounts`
					 ADD COLUMN `currency_id` smallint unsigned NOT NULL DEFAULT 0,
					 ADD COLUMN `exchange_rate` DECIMAL(20,10) NOT NULL DEFAULT 0;
					ALTER TABLE `" . TABLE_PREFIX . "quota_amounts`
					 ADD COLUMN `currency_id` smallint unsigned NOT NULL DEFAULT 0,
					 ADD COLUMN `exchange_rate` DECIMAL(20,10) NOT NULL DEFAULT 0;
					UPDATE `" . TABLE_PREFIX . "amounts` `a` SET `a`.`currency_id` = (
					 SELECT `p`.`currency_id` FROM `" . TABLE_PREFIX . "payments` `p` WHERE `p`.`object_id` = `a`.`payment_id`
					);
					UPDATE `" . TABLE_PREFIX . "amounts` `a` SET `a`.`exchange_rate` = (
					 SELECT `e`.`value` FROM `" . TABLE_PREFIX . "exchange_rates` `e` WHERE `e`.`currency_id` = `a`.`currency_id` ORDER BY `e`.`date` DESC LIMIT 1
					);
					UPDATE `" . TABLE_PREFIX . "quota_amounts` `a` SET `a`.`currency_id` = (
					 SELECT `q`.`currency_id` FROM `" . TABLE_PREFIX . "quotas` `q` WHERE `q`.`object_id` = `a`.`quota_id`
					);
					UPDATE `" . TABLE_PREFIX . "quota_amounts` `a` SET `a`.`exchange_rate` = (
					 SELECT `e`.`value` FROM `" . TABLE_PREFIX . "exchange_rates` `e` WHERE `e`.`currency_id` = `a`.`currency_id` ORDER BY `e`.`date` DESC LIMIT 1
					);
					ALTER TABLE `" . TABLE_PREFIX . "payments` DROP COLUMN `currency_id`;
					ALTER TABLE `" . TABLE_PREFIX . "quotas` DROP COLUMN `currency_id`;
					ALTER TABLE `" . TABLE_PREFIX . "currencies`
					 ADD COLUMN `is_default` BOOL NOT NULL DEFAULT 0;
					UPDATE `" . TABLE_PREFIX . "currencies` SET `is_default` = 1 WHERE `id` = 1;
					ALTER TABLE `" . TABLE_PREFIX . "exchange_rates`
					 ADD INDEX `currency`(`currency_id`, `date`),
					 ADD INDEX `date` USING BTREE(`date`);
					ALTER TABLE `" . TABLE_PREFIX . "quotas`
					 MODIFY COLUMN `pcp_assigned_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
					 MODIFY COLUMN `location_assigned_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
					 MODIFY COLUMN `period_assigned_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
					 MODIFY COLUMN `budgeted_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
					 MODIFY COLUMN `expected_amount` DECIMAL(20,10) NOT NULL DEFAULT 0,
					 MODIFY COLUMN `executed_amount` DECIMAL(20,10) NOT NULL DEFAULT 0;
					ALTER TABLE `" . TABLE_PREFIX . "quota_amounts`
					 MODIFY COLUMN `amount` DECIMAL(20,10) NOT NULL DEFAULT 0;
					ALTER TABLE `" . TABLE_PREFIX . "amounts`
					 MODIFY COLUMN `amount` DECIMAL(20,10) NOT NULL DEFAULT 0;
					ALTER TABLE `" . TABLE_PREFIX . "exchange_rates`
					 MODIFY COLUMN `value` DECIMAL(20,10) NOT NULL DEFAULT 0;
					ALTER TABLE `" . TABLE_PREFIX . "reports` CHANGE COLUMN `id` `object_id` INT(10) NOT NULL DEFAULT NULL AUTO_INCREMENT,
					 DROP PRIMARY KEY,
					 ADD PRIMARY KEY  USING BTREE(`object_id`);
					INSERT INTO `" . TABLE_PREFIX . "exchange_rates` (`currency_id`,`value`,`date`) VALUES
					 (2, 18.85, '2011-05-24 00:00:00'), 
					 (3, 26.513, '2011-05-24 00:00:00');
					INSERT INTO `" . TABLE_PREFIX . "dimension_object_type_contents` (`dimension_id`,`dimension_object_type_id`,`content_object_type_id`, `is_required`, `is_multiple`) VALUES
					 (2, 21, 25, 0, 1);";
			}
			
			
			if (version_compare($installed_version, '2.0-beta3') < 0) {
				$upgrade_script .= "
					ALTER TABLE `" . TABLE_PREFIX . "contact_permission_groups`
					  ADD INDEX `contact_id` (`contact_id`),
					  ADD INDEX `permission_group_id` (`permission_group_id`) ;
					ALTER TABLE `" . TABLE_PREFIX . "searchable_objects`
					  ADD INDEX `rel_obj_id` (`rel_object_id`);
					CREATE TABLE  `". TABLE_PREFIX . "sharing_table` (
					  `id` int(10) NOT NULL auto_increment,
					  `group_id` INTEGER UNSIGNED NOT NULL,
					  `object_id` INTEGER UNSIGNED NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `group_id` (`group_id`),
					  KEY `object_id` (`object_id`)  
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					UPDATE `". TABLE_PREFIX ."object_types` SET `handler_class`= 'ProjectFileRevisions' WHERE `id` = 17 ;
					ALTER TABLE `" . TABLE_PREFIX . "comments`
					  DROP COLUMN `is_private` ,
  					  DROP COLUMN `is_anonymous` ;
  					DROP TABLE `" . TABLE_PREFIX . "object_handins`;
					ALTER TABLE `" . TABLE_PREFIX . "project_files` 
					  DROP COLUMN `is_private`,
					  DROP COLUMN `is_important`,
					  DROP COLUMN `comments_enabled`,
					  DROP COLUMN `anonymous_comments_enabled`;
					ALTER TABLE `" . TABLE_PREFIX . "project_messages` 
					  DROP COLUMN `milestone_id`,
					  DROP COLUMN `additional_text`,
					  DROP COLUMN `is_important`,
					  DROP COLUMN `is_private`,
					  DROP COLUMN `comments_enabled`,
					  DROP COLUMN `anonymous_comments_enabled`;
					ALTER TABLE `" . TABLE_PREFIX . "project_milestones` 
					  DROP COLUMN `assigned_to_company_id`,
					  DROP COLUMN `assigned_to_contact_id`,
					  DROP COLUMN `is_private`;
					ALTER TABLE `" . TABLE_PREFIX . "project_tasks` 
					  DROP COLUMN `is_private`;
					ALTER TABLE `" . TABLE_PREFIX . "project_webpages` 
					  DROP COLUMN `is_private`;
					ALTER TABLE `" . TABLE_PREFIX . "mail_contents` 
					  DROP COLUMN `is_private`;
					ALTER TABLE `" . TABLE_PREFIX . "products`
					  MODIFY COLUMN `state` ENUM('Pendiente','En Operacion','Finalizado','Otro') ;
					ALTER TABLE `" . TABLE_PREFIX . "items` 
					  MODIFY COLUMN `type` ENUM('Contratacion Individual','Firma Consultora','Bienes y Servicios','Servicios distintos de consultoria','Obras','Otro'),
					  MODIFY COLUMN `state` ENUM('En Adquisicion','Adjudicado','Contratado','En Ejecucion','Ejecutado','En Operacion','Terminado','Cancelado','Otro'),
					  MODIFY COLUMN `acquisition_method` ENUM('Terna','Llamado a Firmas','Licitacion Abreviada','Licitacion Publica Nacional','Licitacion Publica Internacional','Comparacion de Precios','Contratacion Directa','Administracion Directa','Convenio','Otro');
					";
				
			}
			
			if (version_compare($installed_version, '2.0-beta4') < 0) {
				$upgrade_script .= "
					ALTER TABLE `" . TABLE_PREFIX . "members` ADD INDEX `object_id`(`object_id`);
					ALTER TABLE `" . TABLE_PREFIX . "searchable_objects` ADD INDEX `contact_id`(`contact_id`);
					ALTER TABLE `" . TABLE_PREFIX . "contacts` ADD COLUMN `personal_member_id` INTEGER UNSIGNED NOT NULL;
					ALTER TABLE `" . TABLE_PREFIX . "dimensions` 
					  ADD COLUMN `is_default` BOOLEAN NOT NULL,
					  ADD COLUMN `default_order` INTEGER UNSIGNED NOT NULL;
					ALTER TABLE `" . TABLE_PREFIX . "contacts` ADD COLUMN `disabled` BOOLEAN NOT NULL;
				";
			}
		}
		
		if($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
			$this->printMessage("Database schema transformations executed (total queries: $total_queries)");
		} else {
			$this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
			return false;
		}
		
		$this->printMessage('Feng Office has been upgraded. You are now running Feng Office '.$this->getVersionTo().' Enjoy!');
	} // execute
} // PastafrolaUpgradeScript

?>