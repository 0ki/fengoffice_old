<?php

  set_page_title(lang('contacts'));
?>
<div id="ContactsTabPanel" style="position:absolute;width:100%;height:100%">
</div>

<script type="text/javascript">

	    var contactsTabPanelExt = new Ext.TabPanel({
	        renderTo: 'ContactsTabPanel',
	        activeTab: <?php echo active_project()? '1' : '0' ?>,
			enableTabScroll: true,
	        plain:true,
	        region:'center',
	        autoHeight:false,
	        style:"height:100%; width:100%, position:absolute",
	        defaults:{autoScroll: true},
	        items:[
			new og.ContentPanel({
				title: '<?php echo lang('all contacts')?>',
				id: 'all_contacts-panel',
				defaultContent: {
					type: "url",
					data: og.getUrl('contact', 'index_all')
				}
			})<?php if (active_project()) {?>,
			new og.ContentPanel({
				title: '<?php echo lang('project contacts', active_project()->getName())?>',
				id: 'project_contacts-panel',
				defaultContent: {
					type: "url",
					data: og.getUrl('contact', 'index_project')
				}
			})
			<?php } ?>
	        ]
	    });
	    
	    
	    contactsTabPanelExt.setHeight(document.getElementById('ContactsTabPanel').clientHeight);
	    
	    og.captureLinks(contactsTabPanelExt.id, 'contacts-panel');
</script>