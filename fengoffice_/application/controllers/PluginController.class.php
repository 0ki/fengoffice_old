<?php 

class PluginController extends ApplicationController {
	
	function scanPlugins() {
		$plugins = array();
		$dir =	ROOT."/plugins";
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if (is_dir($dir ."/". $file) && $file!="." && $file!=".."){
					if (file_exists($dir ."/". $file . "/info.php" )){
						$plugin_info = include_once $dir ."/". $file . "/info.php";
						array_push($plugins, $plugin_info);
					}
				}
			}
			closedir($dh);
		} 
		usort($plugins, 'plugin_sort') ;
		foreach ($plugins as $plg){
			if (! Plugins::instance()->findOne(array("conditions"=>"name = '".$plg['name'] ."'")) ) {
				$plugin = new Plugin();
				//if ( isset($plg["id"]) && is_numeric($plg["id"]) ) {
					//$plugin->setId($plg['id']);
				//}
				$plugin->setName($plg["name"]);
				$plugin->setIsActivated(0);
				$plugin->setIsInstalled(0);
				$plugin->save();					
			}
		}
	} 
	
	function uninstall() {
		ajx_current("empty");
		$id=array_var($_POST,'id');
		if ( $plg  = Plugins::instance()->findById($id)) {
			if (!$plg->isInstalled()) return ;
			$plg->setIsInstalled(0);
			$plg->save();
		}
	}
	
	function install(){
		ajx_current("empty");
		$id=array_var($_POST,'id');
		if ( $plg  = Plugins::instance()->findById($id)) {
			//if ($plg->isInstalled()) return ;
			$name = $plg->getName();
			
			if ($this->executeInstaller($name)){
				$plg->setIsInstalled(1);
				$plg->save();
			}else{
				throw new ErrorException("Error installing plg");
			}	
		}
	}
	
	function activate(){
		ajx_current("empty");
		$id=array_var($_POST,'id');
		if ( $plg  = Plugins::instance()->findById($id)) {
			$plg->activate();
		}
	}
	
	function deactivate() {
		ajx_current("empty");
		$id=array_var($_POST,'id');
		if ( $plg  = Plugins::instance()->findById($id)) {
			$plg->deactivate();
		}
	}
	
	function __construct() {
		parent::__construct();
		
		if(!can_manage_plugins(logged_user())) {
			flash_error(lang('no access permissions'));
			ajx_current("empty");
			return;
		}
		prepare_company_website_controller($this, 'website'); 
	}
	
	function index() {
		require_javascript("og/modules/plugins.js");
		$this->scanPlugins(); // If there are plguins not scanned		
		$plugins = Plugins::instance()->findAll(array(
			"order"=>"name ASC",
		));
				
		tpl_assign('plugins', $plugins);
	}
	
	/**
	 * @author Ignacio Vazquez - elpepe.uy@gmail.com
	 * @param array of string $pluginNames
	 * TODO avoid using mysql functions - (copied from installer)
	 */
	private function executeInstaller($name) {
		
		$table_prefix = TABLE_PREFIX;
		tpl_assign('table_prefix', $table_prefix);
		
		$default_charset = 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';
		tpl_assign('default_charset', $default_charset);
		
		$default_collation = 'collate utf8_unicode_ci';
		tpl_assign('default_collation', $default_collation);
		
		$engine = DB_ENGINE;
		tpl_assign('engine', $engine);
		
		
		$path = ROOT . "/plugins/$name/info.php";
		if (file_exists ( $path )) {
			DB::beginWork ();
			$pluginInfo = include_once $path;
			//0. Check if exists in plg table
			$sql = "SELECT id FROM " . TABLE_PREFIX . "plugins WHERE name = '$name' ";
			$res = @mysql_query ( $sql );
			if (! $res) {
				DB::rollback ();
				return false;
			}
			$plg_obj = mysql_fetch_object ( $res );
			if (! $plg_obj) {
				//1. Insert into PLUGIN TABLE
				$cols = "name, is_installed, is_activated";
				$values = "'$name', 1, 1 ";
				if (is_numeric ( array_var ( $pluginInfo, 'id' ) )) {
					$cols = "id, " . $cols;
					$values = array_var ( $pluginInfo, 'id' ) . ", " . $values;
				}
				$sql = "INSERT INTO " . TABLE_PREFIX . "plugins ($cols) VALUES ($values) ";
				if (@mysql_query ( $sql )) {
					$id = @mysql_insert_id ();
					$pluginInfo ['id'] = $id;
				} else {
					echo "ERROR: " . mysql_error ();
					@mysql_query ( 'ROLLBACK' );
					return false;
				}
			} else {
				$id = $plg_obj->id;
				$pluginInfo ['id'] = $id;
			}
			//2. IF Plugin defines types, INSERT INTO ITS TABLE
			if (count ( array_var ( $pluginInfo, 'types' ) )) {
				foreach ( $pluginInfo ['types'] as $k => $type ) {
					if (isset ( $type ['name'] )) {
						$sql = "
							INSERT INTO " . TABLE_PREFIX . "object_types (name, handler_class, table_name, type, icon, plugin_id)
							 	VALUES (
							 	'" . array_var ( $type, "name" ) . "', 
							 	'" . array_var ( $type, "handler_class" ) . "', 
							 	'" . array_var ( $type, "table_name" ) . "', 
							 	'" . array_var ( $type, "type" ) . "', 
							 	'" . array_var ( $type, "icon" ) . "', 
								$id
							)";
						if (@mysql_query ( $sql )) {
							$pluginInfo ['types'] [$k] ['id'] = @mysql_insert_id ();
							$type ['id'] = @mysql_insert_id ();
						
						} else {
							echo $sql . "<br/>";
							echo mysql_error () . "<br/>";
							DB::rollback ();
							return false;
						}
					
					}
				}
			}
			//2. IF Plugin defines tabs, INSERT INTO ITS TABLE
			if (count ( array_var ( $pluginInfo, 'tabs' ) )) {
				foreach ( $pluginInfo ['tabs'] as $k => $tab ) {
					if (isset ( $tab ['title'] )) {
						$type_id = array_var ( $type, "id" );
						$sql = "
							INSERT INTO " . TABLE_PREFIX . "tab_panels (
								id,
								title, 
								icon_cls, 
								refresh_on_context_change, 
								default_controller, 
								default_action, 
								initial_controller, 
								initial_action, 
								enabled, 
								type,  
								plugin_id, 
								object_type_id )
						 	VALUES (
						 		'" . array_var ( $tab, 'id' ) . "', 
						 		'" . array_var ( $tab, 'title' ) . "', 
						 		'" . array_var ( $tab, 'icon_cls' ) . "',
						 		'" . array_var ( $tab, 'refresh_on_context_change' ) . "',
						 		'" . array_var ( $tab, 'default_controller' ) . "',
						 		'" . array_var ( $tab, 'default_action' ) . "',
								'" . array_var ( $tab, 'initial_controller' ) . "',
								'" . array_var ( $tab, 'initial_action' ) . "',
								'" . array_var ( $tab, 'enabled', 1 ) . "',
								'" . array_var ( $tab, 'type' ) . "',
								$id,
								" . array_var ( $tab, 'object_type_id' ) . "
							)";
						
						if (! @mysql_query ( $sql )) {
							echo $sql;
							echo mysql_error ();
							DB::rollback ();
							return false;
						}
						
						// INSERT INTO TAB PANEL PERMISSSION
						$sql = "
							INSERT INTO " . TABLE_PREFIX . "tab_panel_permissions (
								permission_group_id,
								tab_panel_id 
							)
						 	VALUES ( 1,'" . array_var ( $tab, 'id' ) . "' ),  ( 2,'" . array_var ( $tab, 'id' ) . "' )  ON DUPLICATE KEY UPDATE permission_group_id = permission_group_id ";
						
						if (! @mysql_query ( $sql )) {
							echo $sql;
							echo mysql_error ();
							@mysql_query ( 'ROLLBACK' );
							DB::rollback ();
							return false;
						}
					}
				}
			}
			
			// Create schema sql query
			
			$schema_creation = ROOT . "/plugins/$name/install/sql/mysql_schema.php";
			if (file_exists ( $schema_creation )) {
				$total_queries = 0;
				$executed_queries = 0;
				if (executeMultipleQueries ( tpl_fetch ( $schema_creation ), $total_queries, $executed_queries )) {
					logger::log ( "Schema created for plugin $name " );
				} else {
					//echo tpl_fetch ( $schema_creation );
					echo mysql_error() ;
					echo "llega <br>";
					DB::rollback ();
					return false;
				}
			}
			// Create schema sql query
			$schema_query = ROOT . "/plugins/$name/install/sql/mysql_initial_data.php";
			if (file_exists ( $schema_query )) {
				$total_queries = 0;
				$executed_queries = 0;
				if (executeMultipleQueries ( tpl_fetch ( $schema_query ), $total_queries, $executed_queries )) {
					logger::log ( "Initial data loaded for plugin  '$name'." . mysql_error () );
				} else {
					echo mysql_error ();
					DB::rollback ();
					return false;
				}
			}
			
			$install_script = ROOT . "/plugins/$name/install/install.php";
			if (file_exists ( $install_script )) {
				include_once $install_script;
			}
			DB::commit ();
			return true;
		}
		return false;
	}
	
}

