<?php
?>

<script>
//some event handlers
og.eventManager.addListener('tag changed', 
 	function (tag){ 
 		if (Ext.getCmp('tabs-panel').getActiveTab().id == 'calendar-panel') {
 			og.openLink(og.getUrl('event', cal_actual_view, {day: calToolbarDateMenu.picker.getValue().format('d'), month: calToolbarDateMenu.picker.getValue().format('n'), year: calToolbarDateMenu.picker.getValue().format('Y'), user_filter: 0, state_filter: -1}), 
 				{caller:'calendar-panel',
 				get:{tag:tag.name}}
 			);
 		}
 		if (Ext.getCmp('tabs-panel').getActiveTab().id == 'tasks-panel') {
 			og.openLink('<?php echo get_url('task','new_list_tasks')?>',
 				{caller:'tasks-panel',
 				get:{tag:tag.name}}
 			);
 		}
 	}
);
og.eventManager.addListener('workspace changed', 
 	function (ws){ 
 		if (Ext.getCmp('tabs-panel').getActiveTab().id == 'calendar-panel') {
 			og.openLink(og.getUrl('event', cal_actual_view, {day: calToolbarDateMenu.picker.getValue().format('d'), month: calToolbarDateMenu.picker.getValue().format('n'), year: calToolbarDateMenu.picker.getValue().format('Y'), user_filter: 0, state_filter: -1}), 
 				{caller:'calendar-panel'}
 			);
 		}
 	}
);

og.eventManager.addListener('company added', 
 	function (company) {
 		var elems = document.getElementsByName("contact[company_id]");
 		for (var i=0; i < elems.length; i++) {
 			if (elems[i].tagName == 'SELECT') {
	 			var opt = document.createElement('option');
	        	opt.value = company.id;
		        opt.innerHTML = company.name;
	 			elems[i].appendChild(opt);
 			}
 		}
 	}
);

og.eventManager.addListener('debug',
	function (text){
		og.msg(lang('debug'), text);
	}
);
</script>