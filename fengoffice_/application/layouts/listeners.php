<?php
?>

<script>
//some event handlers
og.eventManager.addListener('tag changed', 
 	function (tag){ 
 		if (Ext.getCmp('tabs-panel').getActiveTab().id == 'calendar-panel') {
 			og.openLink('<?php echo get_url('event')?>',
 				{caller:'calendar-panel',
 				get:{tag:tag.name}}
 			);
 		}
 		if (Ext.getCmp('tabs-panel').getActiveTab().id == 'tasks-panel') {
 			og.openLink('<?php echo get_url('task')?>',
 				{caller:'tasks-panel',
 				get:{tag:tag.name}}
 			);
 		}
 	}
);
og.eventManager.addListener('company added', 
 	function (company){ 
 		if (Ext.get('profileFormCompany')){
 			var select = Ext.get('profileFormCompany');
			select.insertHtml('afterBegin', '<option selected="selected" value="' + company.id + '">' + company.name + '</option>');
 		}
 	}
);

og.eventManager.addListener('debug',
	function (text){
		og.msg(lang('debug'), text);
	}
);
</script>