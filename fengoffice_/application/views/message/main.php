<?php
  set_page_title(lang('messages'));
  if(MailAccount::canAdd(logged_user())) {
    add_page_action(lang('add mail account'), get_url('mail', 'add_account'));
  } // if
?>
<div id="MessagesTabPanel" style="position:absolute;width:100%;height:100%">
</div>

<script type="text/javascript">

	    var messagesTabPanelExt = new Ext.TabPanel({
	        renderTo: 'MessagesTabPanel',
	        activeTab: 0,
			enableTabScroll: true,
	        plain:true,
			width: '100%',
			height: 500,
	        defaults:{autoScroll: true},
	        items:[
	        <?php if (active_project()) {?>
			new og.ContentPanel({
	        	defaults:{autoScroll: true},
				title: '<?php echo lang('messages')?>',
				id: 'project-messages-panel',
				defaultContent: {
					type: "url",
					data: og.getUrl('message', 'index')
				}
			}),
			new og.ContentPanel({
	        	defaults:{autoScroll: true},
				title: '<?php echo lang('project emails', active_project()->getName())?>',
				id: 'project_emails-panel',
				defaultContent: {
					type: "url",
					data: og.getUrl('mail', 'index_project')
				}
			}),<?php } ?>
			
			<?php if (isset($accounts)) { foreach($accounts as $acc) {?> 
			new og.ContentPanel({
	        	defaults:{autoScroll: true},
				title: '<?php echo $acc->getName() ?>',
				id: '<?php echo $acc->getId() ?>-email-panel',
				defaultContent: {
					type: "url",
					data: og.getUrl('mail', 'view_account', {id:"<?php echo $acc->getId() ?>"})
				}
			}),
			<?php } } ?>
	        ]
	    });
	    
	    messagesTabPanelExt.setHeight(document.getElementById('MessagesTabPanel').clientHeight);
	    
	    og.captureLinks(messagesTabPanelExt.id, 'messages-panel');
</script>
