Ext.onReady(function(){
	Ext.get("loading").hide();

	Ext.QuickTips.init();
	//Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

	new Ext.TabPanel({
		id: 'tabs-panel',
		region:'center',
		activeTab: 0,
		enableTabScroll: true,
		items: [
			new og.ContentPanel({
				title: lang('overview'),
				id: 'overview-panel',
				iconCls: 'ico-overview',
				autoRefresh: true,
				defaultContent: {
					type: "dashboard"
				}
			}),
			new og.ContentPanel({
				title: lang('messages'),
				id: 'messages-panel',
				iconCls: 'ico-messages',
				defaultContent: {
					type: "url",
					data: og.getUrl('message', 'main')
				}
			}),
			new og.ContentPanel({
				title: lang('contacts'),
				id: 'contacts-panel',
				iconCls: 'ico-contacts',
				defaultContent: {
					type: "contacts"
				}
			}),
			new og.ContentPanel({
				title: lang('calendar'),
				id: 'calendar-panel',
				iconCls: 'ico-calendar',
				defaultContent: {
					type: "url",
					data: og.getUrl('event','index')
				}
			}),
			new og.ContentPanel({
				title: lang('documents'),
				id: 'documents-panel',
				iconCls: 'ico-documents',
				defaultContent: {
					type: "files"
				}
			}),
			new og.ContentPanel({
				title: lang('tasks'),
				id: 'tasks-panel',
				iconCls: 'ico-tasks',
				defaultContent: {
					type: "tasks"
				}
			}),
			new og.ContentPanel({
				title: lang('web pages'),
				id: 'webpages-panel',
				iconCls: 'ico-webpages',
				defaultContent: {
					type: "webpages"
				}
			})
		]
	});
	
	var viewport = new Ext.Viewport({
		layout: 'border',
		items: [
			{
				xtype: 'panel',
				region: 'north',
				id: 'header-panel',
				el: 'header'
			},
			new Ext.BoxComponent({
				region: 'south',
				el: 'footer'
			}),
			helpPanel = new og.HelpPanel({
				region: 'east',
				collapsible: true,
				collapsed: false,
				split: true,
				width: 225,
				minSize: 175,
				maxSize: 400,
				id: 'help-panel',
				title: lang('help'),
				iconCls: 'ico-help'
			 }),
			 {
				region: 'west',
				id: 'menu-panel',
				title: lang('workspaces'),
				iconCls: 'ico-workspaces',
				split: true,
				width: 200,
				minSize: 175,
				maxSize: 400,
				collapsible: true,
				margins: '0 0 0 0',
				layout: 'border',
				items: [
					new og.WorkspacePanel(),
					new og.TagPanel()
				]
			},
			Ext.getCmp('tabs-panel')
		 ]
	});
	
    og.captureLinks();
    
    //Ext.getCmp('workspace-panel').select();
    
    if (og.initialURL) {
    	og.openLink(og.initialURL);
    }
});
