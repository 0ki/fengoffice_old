<?php header ("Content-Type: text/html; charset=utf-8", true); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title><?php echo clean(CompanyWebsite::instance()->getCompany()->getFirstName()) . ' - ' . PRODUCT_NAME ?></title>
	<?php echo link_tag(with_slash(ROOT_URL)."favicon.ico", "rel", "shortcut icon") ?>
	<?php echo add_javascript_to_page("og/app.js") // loaded first because it's needed for translating?>
	<?php echo add_javascript_to_page(get_url("access", "get_javascript_translation")); ?>
	<!--[if IE 7]>
	<?php echo stylesheet_tag("og/ie7.css"); ?>
	<![endif]-->
	<!--[if IE 8]>
	<?php echo stylesheet_tag("og/ie8.css"); ?>
	<![endif]-->
	
	<?php echo meta_tag('content-type', 'text/html; charset=utf-8', true) ?>
<?php

	$version = product_version();
	if (defined('COMPRESSED_CSS') && COMPRESSED_CSS) {
		echo stylesheet_tag("ogmin.css");
	} else {
		echo stylesheet_tag('website.css');
	}
	
	// Include plguin specif stylesheets
	foreach (Plugins::instance()->getActive() as $p) {
		/* @var $p Plugin */
		$css_file =	PLUGIN_PATH ."/".$p->getSystemName()."/public/assets/css/".$p->getSystemName().".css" ;
		if (is_file($css_file)) {
			echo stylesheet_tag(ROOT_URL."/plugins/".$p->getSystemName()."/public/assets/css/".$p->getSystemName().".css" );
			echo "\n";// exit;
		}
	}
	
	
	
	$theme = config_option('theme', DEFAULT_THEME);
	if (is_file(PUBLIC_FOLDER . "/assets/themes/$theme/stylesheets/custom.css")) {
		echo stylesheet_tag('custom.css');
	}
	$css = array();
	Hook::fire('autoload_stylesheets', null, $css);
	foreach ($css as $c) {
		echo stylesheet_tag($c);
	}

	if (defined('COMPRESSED_JS') && COMPRESSED_JS) {
		$jss = array("ogmin.js");
	} else {
		$jss = include "javascripts.php";
	}
	Hook::fire('autoload_javascripts', null, $jss);
	if (defined('USE_JS_CACHE') && USE_JS_CACHE) {
		echo add_javascript_to_page(with_slash(ROOT_URL)."public/tools/combine.php?version=$version&type=javascript&files=".implode(',', $jss));
	} else {
		foreach ($jss as $onejs) {
			echo add_javascript_to_page($onejs);
		}
	}
	$ext_lang_file = get_ext_language_file(get_locale());
	if ($ext_lang_file)	{
		echo add_javascript_to_page("extjs/locale/$ext_lang_file");
	}
	echo add_javascript_to_page("ckeditor/ckeditor.js");
	
	// Include plguin specif js
	foreach (Plugins::instance()->getActive() as $p) {
		/* @var $p Plugin */
		$js_file =	PLUGIN_PATH ."/".$p->getSystemName()."/public/assets/javascript/".$p->getSystemName().".js" ;
		if (is_file($js_file)) {
			add_javascript_to_page(ROOT_URL."/plugins/".$p->getSystemName()."/public/assets/javascript/".$p->getSystemName().".js");
			//echo javascript_tag(ROOT_URL."/plugins/".$p->getSystemName()."/public/assets/javascript/".$p->getSystemName().".js" );
			echo "\n";
		}
	}
	
	?>
	<?php if (config_option("show_feed_links")) { ?>
		<link rel="alternate" type="application/rss+xml" title="<?php echo clean(owner_company()->getName()) ?> RSS Feed" href="<?php echo logged_user()->getRecentActivitiesFeedUrl() ?>" />
	<?php } ?>
	<style>
		#loading {
		    font-size: 20px;
		    left: 45%;
		    position: absolute;
		    top: 45%;
			color: #333333;
			font-family: verdana,arial,helvetica,sans-serif;
    		line-height: 150%;
		}
	</style>
</head>
<body id="body" <?php echo render_body_events() ?>>

<iframe name="_download" style="display:none"></iframe>

<div id="loading">
	<img src="<?php echo get_image_url("layout/loading.gif") ?>" width="32" height="32" style="margin-right:8px;" align="absmiddle"/><?php echo lang("loading") ?>...
</div>

<div id="subWsExpander" onmouseover="clearTimeout(og.eventTimeouts['swst']);" onmouseout="og.eventTimeouts['swst'] = setTimeout('og.HideSubWsTooltip()', 2000);" style="display:none;top:10px;"></div>

<?php echo render_page_javascript() ?>
<?php echo render_page_inline_js() ?>
<?php 
	$use_owner_company_logo = false;
	if (owner_company()->hasLogo()) {
		$use_owner_company_logo = true; 
	}
?>
<!-- header -->
<div id="header">
	<div id="headerContent">
	    <table class="headerLogoAndWorkspace"><tr><td>
			<div id="logodiv">
                <img src="<?php echo ($use_owner_company_logo) ? owner_company()->getLogoUrl() : 's.gif' ?>" />
                <div>
                <?php if(!$use_owner_company_logo){?>
                    <a style="color: #fff; font-size: 10px;" href="index.php?c=contact&a=edit_logo&id=<?php echo owner_company()->getObjectId(); ?>">Change Logo</a>
                <?php } ?>
                    <h1><?php echo owner_company()->getObjectName() ?></h1>
                </div>
            </div>
		</td><td>
			
		</td></tr></table>
		<div style="float: right; z-index: 10000; padding-top:15px;">
			<div id="searchbox">
				<form name='search_form' class="internalForm" action="<?php echo ROOT_URL . '/index.php' ?>" method="get">
					<table><tr><td>
					<input name="search_for" placeholder="<?php echo lang('search') . "..."?>">
					
					</td>
					<td id="searchboxSearch">
						<div id="searchboxButton"></div>
						<input style="display:none" id="searchButtonReal" type="submit" />
						<input type="hidden" name="c" value="search" />
						<input type="hidden" name="a" value="search" />
						<input type="hidden" name="current" value="search" />
						<input type="hidden" id="hfVars" name="vars" value="dashboard" />
					</td>
					<td style="padding-left:10px">
						<div id="quickAdd" style="display: none"></div>
					</td>
					</tr></table>
				</form>		
			</div>			
			<div id="userboxWrapper">
				<h2>
				<a href="#" onclick="showUserOptionsPanel()"><?php echo logged_user()->getDisplayName(); ?></a></h2>
				<a href="#" class="account" onclick="showUserOptionsPanel()">&nbsp;</a>								
			</div>
			<div class="u-clear"></div>
			<?php echo render_user_box(logged_user())?>
		</div>
		<?php Hook::fire('render_page_header', null, $ret) ?>
        <script>
            
            /*** User Settings Panel ***/ 
            
            /**
            * Slide to show/hide user setting panel
            */
            function showUserOptionsPanel()
            {
                $('div.user-box-actions').slideToggle();  
            }
            
            /**
            * Save selected colors to Organization settings
            */            
            function saveBrandColors (element)
            {
                element.disabled = true;  
                var colors = '';
                $('div.theme-color-picker form input[type=text]').each(function(inx, obj){colors += obj.value;});            
                $.post('index.php?c=administration&a=scolors', 'colors=' + colors,
                    function ()
                    {
                         $('li.theme-color-picker-wrapper').slideUp();
                         element.disabled = false;  
                    }
                ); 
            }
                        
            /*** Brand color-picker ***/
            
            brand_colors = '<?php echo owner_company()->getBrandColors(); ?>'.split('#');         
            
            /**
            * Create style sheet for current colors
            */
            function createBrandColorsSheet ()
            {
                var back = brand_colors[1];
                var front = brand_colors[2];
                var fontFace = brand_colors[3];
                var fontTitle = brand_colors[4];               
                var cssRules = '.x-accordion-hd, ul.x-tab-strip li {background: #' + front + '}';
                cssRules += 'ul.x-tab-strip li {border-color: #' + front + '}';
                cssRules += '#header, #userboxWrapper h2 a {background-color: #' + back + '}';
                cssRules += '.x-accordion-hd, .x-tab-strip span.x-tab-strip-text {color: #' + fontFace + '}';                     
                cssRules += '#logodiv h1, #userboxWrapper h2 a {color: #' + fontTitle + '}'; 
                
                var styleElement = document.createElement("style");
                styleElement.type = "text/css";
                if (styleElement.styleSheet) 
                    styleElement.styleSheet.cssText = cssRules;
                else 
                    styleElement.appendChild(document.createTextNode(cssRules));
                
                document.getElementsByTagName("head")[0].appendChild(styleElement);     
            }
            
            /**
            * OnReady events
            */ 
            $(document).ready(
                function()
                {
                    createBrandColorsSheet();
                    $('.back-color-value').val('#'+brand_colors[1]);
                    $('.front-color-value').val('#'+brand_colors[2]);
                    $('.face-font-color-value').val('#'+brand_colors[3]);
                    $('.title-font-color-value').val('#'+brand_colors[4]);

                    $('.back-color-value, .front-color-value, .face-font-color-value, .title-font-color-value').modcoder_excolor({
                       round_corners : false,
                       shadow : false,
                       background_color : '#eeeeee',
                       backlight : false,
                       callback_on_ok : function() {
                            brand_colors[1] = $('.back-color-value').val().substring(1,7);
                            brand_colors[2] = $('.front-color-value').val().substring(1,7);
                            brand_colors[3] = $('.face-font-color-value').val().substring(1,7);
                            brand_colors[4] = $('.title-font-color-value').val().substring(1,7);
                            createBrandColorsSheet();
                       }
                    });
                }
            );
        </script>
	</div>
</div>
<!-- /header -->

<!-- footer -->
<div id="footer">
	<div id="copy">
		<?php if(0 && is_valid_url($owner_company_homepage = owner_company()->getHomepage())) { 
		//FIXME Pepe getHomepage not defined
			?>
			<?php echo lang('footer copy with homepage', date('Y'), $owner_company_homepage, clean(owner_company()->getObjectName())) ?>
		<?php } else { ?>
			<?php echo lang('footer copy without homepage', date('Y'), clean(owner_company()->getObjectName())) ?>
		<?php } // if ?>
	</div>
	<?php Hook::fire('render_page_footer', null, $ret) ?>
	<div id="productSignature"><?php echo product_signature() ?></div>
</div>
<!-- /footer -->

<script>
		
	
// OG config options
og.hostName = '<?php echo ROOT_URL ?>';
og.sandboxName = <?php echo defined('SANDBOX_URL') ? "'".SANDBOX_URL."'" : 'false'; ?>;
og.maxUploadSize = '<?php echo get_max_upload_size() ?>';
<?php //FIXME initialWS for initialMembers
$initialWS = user_config_option('initialWorkspace');
if ($initialWS === "remember") {
	$initialWS = user_config_option('lastAccessedWorkspace', 0);
}
?>
og.initialWorkspace = '<?php echo $initialWS ?>';
<?php $qs = (trim($_SERVER['QUERY_STRING'])) ? "&" . $_SERVER['QUERY_STRING'] : "";  ?>
og.initialURL = '<?php echo ROOT_URL . "/?active_project=$initialWS" . $qs ?>';
<?php if (user_config_option("rememberGUIState")) { ?>
og.initialGUIState = <?php echo json_encode(GUIController::getState()) ?>;
<?php } ?>
<?php if (user_config_option("autodetect_time_zone", null)) {
$now = DateTimeValueLib::now(); ?>
og.usertimezone = og.calculate_time_zone(new Date(<?php echo $now->getYear() ?>,<?php echo $now->getMonth() - 1 ?>,<?php echo $now->getDay() ?>,<?php echo $now->getHour() ?>,<?php echo $now->getMinute() ?>,<?php echo $now->getSecond() ?>));
og.initialURL += '&utz=' + og.usertimezone;
<?php } ?>
og.CurrentPagingToolbar = <?php echo defined('INFINITE_PAGING') && INFINITE_PAGING ? 'og.InfinitePagingToolbar' : 'og.PagingToolbar' ?>;
og.loggedUser = {
	id: <?php echo logged_user()->getId() ?>,
	username: <?php echo json_encode(logged_user()->getUsername()) ?>,
	displayName: <?php echo json_encode(logged_user()->getDisplayName()) ?>,
	isAdmin: <?php echo logged_user()->isAdministrator() ? 'true' : 'false' ?>,
	isGuest: <?php echo logged_user()->isGuest() ? 'true' : 'false' ?>,
	tz: <?php echo logged_user()->getTimezone() ?>
};
og.zipSupported = <?php echo zip_supported() ? 1 : 0 ?>;
og.hasNewVersions = <?php
	if (config_option('upgrade_last_check_new_version', false) && logged_user()->isAdministrator()) {
		echo json_encode(lang('new Feng Office version available', "#", "og.openLink(og.getUrl('administration', 'upgrade'))"));
	} else {
		echo "false";
	}
?>;
og.config = {
	'files_per_page': <?php echo json_encode(config_option('files_per_page', 10)) ?>,
	'time_format_use_24': <?php echo json_encode(config_option('time_format_use_24', 0)) ?>,
	'days_on_trash': <?php echo json_encode(config_option("days_on_trash", 0)) ?>,
	'checkout_notification_dialog': <?php echo json_encode(config_option('checkout_notification_dialog', 0)) ?>,
	'enable_notes_module': <?php echo json_encode(module_enabled("messages")) ?>,
	'enable_email_module': <?php echo json_encode(module_enabled("mails", defined('SHOW_MAILS_TAB') && SHOW_MAILS_TAB)) ?>,
	'enable_contacts_module': <?php echo json_encode(module_enabled("contacts")) ?>,
	'enable_calendar_module': <?php echo json_encode(module_enabled("calendar")) ?>,
	'enable_documents_module': <?php echo json_encode(module_enabled("documents")) ?>,
	'enable_tasks_module': <?php echo json_encode(module_enabled("tasks")) ?>,
	'enable_weblinks_module': <?php echo json_encode(module_enabled('weblinks')) ?>,
	'enable_time_module': <?php echo json_encode(module_enabled("time") && can_manage_time(logged_user())) ?>,
	'enable_reporting_module': <?php echo json_encode(module_enabled("reporting")) ?>
};
og.preferences = {
	'rememberGUIState': <?php echo user_config_option('rememberGUIState') ? '1' : '0' ?>,
	'show_unread_on_title': <?php echo user_config_option('show_unread_on_title') ? '1' : '0' ?>,
	'email_polling': <?php echo json_encode(user_config_option('email_polling')) ?> ,
	'email_check_acc_errors': <?php echo json_encode(user_config_option('mail_account_err_check_interval')) ?> ,
	'date_format': <?php echo json_encode(user_config_option('date_format')) ?>,
	'start_monday': <?php echo user_config_option('start_monday') ? '1' : '0' ?>,
	'draft_autosave_timeout': <?php echo json_encode(user_config_option('draft_autosave_timeout')) ?>,
	'drag_drop_prompt': <?php echo json_encode(user_config_option('drag_drop_prompt')) ?>,
	'mail_drag_drop_prompt': <?php echo json_encode(user_config_option('mail_drag_drop_prompt')) ?>
};

Ext.Ajax.timeout = <?php echo get_max_execution_time()*1100 // give a 10% margin to PHP's timeout ?>;
og.musicSound = new Sound();
og.systemSound = new Sound();

var quickAdd = new og.QuickAdd({renderTo:'quickAdd'});
//og.quickAdd = quickAdd ;
var searchbutton = new Ext.Button({renderTo:'searchboxButton', text: lang('search'), type:'submit', handler:function(){document.getElementById('searchButtonReal').click()} });

<?php if (!defined('DISABLE_JS_POLLING') || !DISABLE_JS_POLLING) { ?>
setInterval(function() {
	og.openLink(og.getUrl('object', 'popup_reminders'), {
		hideLoading: true,
		hideErrors: true,
		preventPanelLoad: true
	});
}, 60000);
<?php } ?>

<?php if (Plugins::instance()->isActivePlugin('mail')) { ?>
	og.loadEmailAccounts('view');
	og.loadEmailAccounts('edit');
	og.loggedUserHasEmailAccounts = <?php echo logged_user()->hasEmailAccounts() ? 'true' : 'false' ?>;
	og.emailFilters = {};
	og.emailFilters.classif = '<?php echo user_config_option('mails classification filter') ?>';
	og.emailFilters.read = '<?php echo user_config_option('mails read filter') ?>';
	og.emailFilters.account = '<?php echo user_config_option('mails account filter') ?>';
	if (og.emailFilters.account != 0 && og.emailFilters.account != '') {
		og.emailFilters.accountName = '<?php
			$acc_id = user_config_option('mails account filter');
			$acc = $acc_id > 0 ? MailAccounts::findById($acc_id) : null; 
			echo ($acc instanceof MailAccount ? mysql_real_escape_string($acc->getName()) : ''); 
		?>';
	} else og.emailFilters.accountName = '';
<?php } ?>
og.lastSelectedRow = {messages:0, mails:0, contacts:0, documents:0, weblinks:0, overview:0, linkedobjs:0, archived:0};



og.dimensionPanels = [
	<?php
	$dimensionController = new DimensionController() ;
	$first = true ; 
	$dimensions = $dimensionController->get_context() ;
	foreach ( $dimensions['dimensions'] AS $dimension ):
		/* @var $dimension Dimension */
		$title = ( $dimension->getOptions() && isset ($dimension->getOptions(1)->useLangs) && ($dimension->getOptions(1)->useLangs) )   ? lang($dimension->getCode()) : $dimension->getName(); 
		if (!$first): ?>,<?php endif; $first = false ;?>                      
		{	
			reloadDimensions: <?php echo json_encode( DimensionMemberAssociations::instance()->getDimensionsToReload($dimension->getId()) ) ; ?>,
			xtype: 'member-tree',
			id: 'dimension-panel-<?php echo $dimension->getId() ; ?>',
			dimensionId: <?php echo $dimension->getId() ; ?>,
			dimensionCode: '<?php echo $dimension->getCode() ; ?>',
			dimensionOptions: <?php echo ( $dimension->getOptions() ) ?  $dimension->getOptions() : '""' ; ?>,
			isDefault: '<?php echo (int) $dimension->isDefault() ; ?>',
			title: "<?php echo $title ?>",
			multipleSelection: <?php echo (int)$dimension->getAllowsMultipleSelection() ?>,
			isRoot: <?php echo (int) $dimension->getIsRoot(); ?>,
			requiredObjectTypes: <?php echo json_encode($dimension->getRequiredObjectTypes()) ?>,
			hidden: <?php echo (int) ! $dimension->getIsRoot(); ?>,
			isManageable: <?php echo (int) $dimension->getIsManageable() ?>,
					
			minHeight: 10
			//animate: false,
			//animCollapse: false
		}	
	<?php endforeach; ?>
];
if (! og.dimensionPanels.length ){
	alert("In order to continue, you need to create dimensions (directly from database).\nSorry about this,\n\n--- The Feng 2.0 Team ---");
}
og.contextManager.construct();
og.objPickerTypeFilters = [];
<?php
	$pg_id = logged_user()->getPermissionGroupId();
	$obj_picker_type_filters = ObjectTypes::findAll(array("conditions" => "`type` = 'content_object'
		AND (plugin_id IS NULL OR plugin_id IN (SELECT distinct(id) FROM ".TABLE_PREFIX."plugins WHERE is_installed = 1 AND is_activated = 1 ))
		AND `name` <> 'file revision' AND `id` NOT IN (
			SELECT `object_type_id` FROM ".TabPanels::instance()->getTableName(true)." WHERE `enabled` = 0
		) AND `id` IN (
			SELECT `tp`.`object_type_id` FROM ".TabPanels::instance()->getTableName(true)." `tp` WHERE EXISTS (
				SELECT `tpp`.`tab_panel_id` FROM ".TabPanelPermissions::instance()->getTableName(true)." `tpp` WHERE `tpp`.`permission_group_id` = $pg_id AND `tp`.`id` = `tpp`.`tab_panel_id`
			)
		) OR `type` = 'comment' OR `name` = 'milestone'"));
	
	foreach ($obj_picker_type_filters as $type) {
		if (! $type instanceof  ObjectType ) continue ;
		/* @var $type ObjectType */
		$linkable = $type->getIsLinkableObjectType();
		if ($linkable) {
?>
			og.objPickerTypeFilters.push({
				id: '<?php echo $type->getName() ?>',
				name: '<?php echo lang($type->getName()) ?>',
				type: '<?php echo $type->getName() ?>',
				filter: 'type',
				iconCls: 'ico-<?php echo $type->getIcon() ?>'
			});
<?php
		}
	}
?>
	var searchForm = document.getElementById("searchbox").getElementsByTagName("form")[0] ;
	H5F.setup(searchForm);
</script>
<?php include_once(Env::getLayoutPath("listeners"));?>

	<div id="quick-form" > 
		<div class="close" ></div>
		<div class="form-container"></div>
	</div>
</body>
</html>
