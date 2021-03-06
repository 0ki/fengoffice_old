Ext.onReady(function(){
	Ext.get("loading").hide();
		
	// fix cursor not showing on message boxs
	Ext.MessageBox.getDialog().on("show", function(d) {
		var div = Ext.get(d.el);
		div.setStyle("overflow", "auto");
		var text = div.select(".ext-mb-textarea", true);
		if (!text.item(0))
			text = div.select(".ext-mb-text", true);
		if (text.item(0))
			text.item(0).dom.select();
	});

	/*Ext.state.Manager.setProvider(new og.HttpProvider({
		saveUrl: og.getUrl('gui', 'save_state'),
		readUrl: og.getUrl('gui', 'read_state'),
		autoRead: false
	}));
	Ext.state.Manager.getProvider().initState(og.initialGUIState);*/
	
	today_date = new Date();
	Ext.QuickTips.init();

	var tab_panel = new Ext.TabPanel({
		id: 'tabs-panel',
		region:'center',
		activeTab: 0,
		enableTabScroll: true,
		items: [
			new og.ContentPanel({
				title: lang('overview'),
				id: 'overview-panel',
				iconCls: 'ico-overview',
				refreshOnWorkspaceChange: true,
				refreshOnTagChange: true,
				defaultContent: {
					type: "url",
					data: og.getUrl('dashboard','index')
				},
				initialContent: {
					type: "url",
					data: og.initialURL
				}
			}),
			new og.ContentPanel({
				title: lang('messages'),
				id: 'messages-panel',
				iconCls: 'ico-messages',
				refreshOnWorkspaceChange: true,
				defaultContent: {
					type: "panel",
					data: "messages"
				}
			}),
			new og.ContentPanel({
				title: lang('email') + ' (BETA)',
				id: 'mails-panel',
				iconCls: 'ico-email',
				refreshOnWorkspaceChange: true,
				defaultContent: {
					type: "panel",
					data: "mails"
				}
			}),
			new og.ContentPanel({
				title: lang('contacts'),
				id: 'contacts-panel',
				iconCls: 'ico-contacts',
				refreshOnWorkspaceChange: true,
				defaultContent: {
					type: "panel",
					data: "contacts"
				}
			}),
			new og.ContentPanel({
				title: lang('calendar'),
				id: 'calendar-panel',
				iconCls: 'ico-calendar',
				refreshOnWorkspaceChange: false, //the handler is in listeners.php
				defaultContent: {
					type: "url",
					data: og.getUrl('event', cal_actual_view, {day: today_date.format('d'), month: today_date.format('n'), year: today_date.format('Y'), user_filter: 0, state_filter: -1})
				},
				baseCls: '',
				tbar: og.CalendarToolbarItems
			}),
			new og.ContentPanel({
				title: lang('documents'),
				id: 'documents-panel',
				iconCls: 'ico-documents',
				refreshOnWorkspaceChange: true,
				defaultContent: {
					type: "panel",
					data: "files"
				}
			}),
			new og.ContentPanel({
				title: lang('tasks'),
				id: 'tasks-panel',
				iconCls: 'ico-tasks',
				refreshOnWorkspaceChange: true,
				defaultContent: {
					type: "url",
					data: og.getUrl('task','new_list_tasks')
				}
			}),
			new og.ContentPanel({
				title: lang('web pages'),
				id: 'webpages-panel',
				iconCls: 'ico-webpages',
				refreshOnWorkspaceChange: true,
				defaultContent: {
					type: "panel",
					data: "webpages"
				}
			})/*,
			new og.ContentPanel({
				title: lang('reporting'),
				id: 'reporting-panel',
				iconCls: 'ico-reporting',
				refreshOnWorkspaceChange: false,
				defaultContent: {
					type: "url",
					data: og.getUrl('reporting','index')
				}
			})*/
		]
	});
	
	if (og.hideMailsTab == 1) tab_panel.remove('mails-panel');
	
	var viewport = new Ext.Viewport({
		layout: 'border',
		stateful: false,
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
				collapsed: true,
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
				bodyBorder: false,
				minSize: 175,
				maxSize: 400,
				collapsible: true,
				margins: '0 0 0 0',
				layout: 'border',
				stateful: false,
				items: [{
					id: 'workspaces-tree',
					xtype: 'wspanel',
					wstree: {
						listeners: {
							workspaceselect: function(ws) {
								og.eventManager.fireEvent('workspace changed', ws);
								og.updateWsCrumbs(ws);
							}
						}
					},
					listeners: {
						render: function() {
							this.getTopToolbar().setHeight(25);
						}
					}
				},{
					xtype: 'tagpanel',
					tagtree: {
						listeners: {
							tagselect: function(tag) {
								og.eventManager.fireEvent('tag changed', tag);
								og.updateWsCrumbsTag(tag);
							}
						}
					}
				}]
			},
			Ext.getCmp('tabs-panel')
		 ]
	});
	
    og.captureLinks();
});